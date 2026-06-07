# Resumo Inteligente de Notícias — Descrição do Projeto

> Sistema que coleta notícias de fontes de interesse, filtra por relevância pessoal,
> resume em **português (pt-BR)** usando LLM local e entrega o resumo em múltiplos
> canais (Blog, Telegram, Discord — incluindo áudio). Tudo roda em infraestrutura
> local (Ollama + Piper), reaproveitando o stack de RAG já validado.

*Nome de trabalho: "News Digest IA" — sinta-se livre pra renomear.*

---

## 1. Objetivo

Receber, todo dia, um resumo enxuto **só do que interessa**, em português, sem precisar
abrir dezenas de sites. O sistema:

- Coleta notícias automaticamente das fontes escolhidas (RSS).
- Filtra por interesse usando similaridade semântica **+** palavras-chave.
- Resume e entrega já em pt-BR (sem etapa separada de tradução).
- Distribui em vários canais, com versão em **áudio**.
- Roda 100% local, reaproveitando a infra de embeddings/LLM que já existe.

---

## 2. Arquitetura (pipeline + fan-out)

```
Fontes (RSS)
   │  FeedFetcher  (coleta + dedupe por URL)
   ▼
news_articles ──► ArticleEmbedder (bge-m3) ──► embedding (1024 dims)
   │
   ▼  InterestRanker   score = α·cosseno(perfil) + β·match_keyword
Top N artigos
   │  Summarizer  (qwen3:8b → resumo em pt-BR)
   ▼
news_digests (texto pt-BR)
   │  SpeechSynthesizer  (Piper → MP3)
   ▼
Fan-out ─┬─► BlogPublisher      (página no site)
         ├─► TelegramPublisher  (texto + voz)
         └─► DiscordPublisher   (webhook + áudio anexado)
```

O **núcleo** (coletar → filtrar → resumir) produz **um** digest canônico no banco.
Cada **publicador** é independente e consome esse digest, então dá pra ligar/desligar
canal sem mexer no resto.

---

## 3. Stack técnica

| Camada            | Escolha                                                        |
|-------------------|----------------------------------------------------------------|
| Aplicação         | Laravel (PHP 8.4+) — controllers finos, lógica em *services*   |
| Banco da app      | MySQL / MariaDB                                                 |
| Store vetorial    | Postgres + pgvector (reaproveitado do RAG) — *ver §8*          |
| LLM               | `qwen3:8b` via Ollama (caminho para `qwen3:14b`)               |
| Embeddings        | `bge-m3` (multilíngue, 1024 dims) via Ollama                   |
| TTS (áudio)       | Piper (local, roda em CPU, voz pt-BR)                           |
| Hardware          | Tesla V100 (16 GB VRAM)                                         |
| Entrega           | Blog (Blade), Telegram Bot API, Discord webhook                |
| Agendamento       | Laravel Scheduler (cron) — 1x/dia por padrão                   |

---

## 4. Componentes

### Camada de IA — `OllamaClient`
Ponto único de contato com o Ollama, usado pelo embedder e pelo summarizer.
Centraliza endpoints (`/api/embeddings`, `/api/generate`), timeouts, retry e os
parâmetros de geração. **É aqui que mora a "formatação da API pra uso da IA":**
toda chamada ao modelo passa por uma interface só, com o formato de request padronizado.

### `FeedFetcher`
Lê os feeds RSS, normaliza os itens e grava os novos em `news_articles`, evitando
duplicatas pelo índice único em `url`. Idempotente: rodar de novo não reprocessa nada.

### `ArticleEmbedder`
Gera o embedding (`bge-m3`) de cada artigo novo e guarda no vetor. Mesma mecânica do
ingest do RAG.

### `InterestRanker`
Calcula o score de cada artigo e seleciona os melhores:

```
score_final = α · cosseno(artigo, perfil_de_interesses) + β · match_de_keyword
```

- **Cosseno** = relevância temática (semântica), via `bge-m3`.
- **Keyword** = bônus por menção a termos específicos (nomes, produtos, empresas).
- Keyword é *boost*, **não** porteiro — não exige a palavra, só dá peso a mais.

### `Summarizer`
Resume o artigo **direto em pt-BR** com `qwen3:8b`, via `OllamaClient`. Como o qwen3 é
multilíngue, resumir o original já entregando em português corta uma camada de perda
(melhor que traduzir um resumo em inglês).

### `SpeechSynthesizer`
Converte o texto do digest em MP3 com Piper. Local, leve, não disputa VRAM com o
qwen3/bge-m3.

### Publicadores
- **`BlogPublisher`** — persiste o digest e renderiza numa página do site.
- **`TelegramPublisher`** — manda o texto (e, opcionalmente, mensagem de voz).
- **`DiscordPublisher`** — POST num webhook com o texto + o MP3 anexado (sem hospedar bot).

### Comando `news:digest`
Orquestra o pipeline ponta a ponta e fica registrado no scheduler.

---

## 5. Configuração de geração (LLM)

Parâmetros fixados (mesma base usada no RAG, pra evitar looping e incoerência):

- `think: false`
- `temperature: 0.2`
- `repeat_penalty: 1.15`
- Prompt **grounded**: resumir só com base no conteúdo do artigo, N frases, tom neutro,
  saída obrigatoriamente em pt-BR.

---

## 6. Filtro de interesse (detalhe)

O "perfil de interesses" é um conjunto de **frases descrevendo os temas** que importam
(ex.: "novidades em modelos de IA open source", "regulação de IA no Brasil"), embeddadas
com `bge-m3`. Cada artigo é comparado contra esse perfil por cosseno; quem casa com uma
keyword leva o bônus. Pega-se o **top N** por `score_final`.

Por que misto: o semântico acerta o que é *tematicamente* relevante mesmo com outra
redação; a keyword garante menções a coisas específicas que o embedding às vezes não
pondera forte.

---

## 7. Decisões tomadas

- Resumir **e** traduzir num passo só (qwen3 multilíngue).
- Filtro **misto**: cosseno como base + keyword como boost.
- TTS **local com Piper** (CPU, voz pt-BR).
- Áudio no Discord = **arquivo MP3 via webhook** (não bot em canal de voz).
- **Reaproveitar** a infra de embeddings/LLM do RAG.
- Entrega agendada **1x/dia** via scheduler.
- Núcleo desacoplado dos canais (1 digest → N publicadores).

---

## 8. Decisões em aberto

- **Store vetorial** — *(pendente)*
  - **Recomendado:** reaproveitar o **Postgres + pgvector** já validado (`vector(1024)`,
    HNSW, cosseno via `<=>`, lógica do `RagService` pronta). Mínimo código novo, zero
    risco novo. `news_articles` fica nessa conexão; o resto na MariaDB.
  - **Alternativa:** **MariaDB 11.8 LTS** tem busca vetorial nativa (tipo `VECTOR`, HNSW,
    `VEC_DISTANCE_COSINE()`). Consolida tudo num banco só, mas exige reescrever a parte
    vetorial na sintaxe do MariaDB e estar no 11.8+.
- **Topologia** — módulo dentro do blog (samirhv) **ou** serviço/app separado?
  *(define como as conexões de banco são ligadas)*
- **Fontes e keywords** — lista concreta de feeds RSS e palavras-chave a definir.
- **Frequência exata** — 1x/dia (padrão) ou mais vezes.

---

## 9. Princípios

- **Local-first** — modelos e TTS rodando localmente; sem dependência de nuvem.
- **Reaproveitar o validado** — usar a base de RAG em vez de reconstruir.
- **Controllers finos / services** — toda a lógica vive em services testáveis.
- **Idempotência** — dedupe por `url`; nunca reprocessar nem reenviar.
- **Desacoplamento** — o núcleo não sabe quais canais existem.
