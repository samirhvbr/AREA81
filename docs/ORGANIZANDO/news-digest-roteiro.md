# Resumo Inteligente de Notícias — Roteiro de Implementação

> Plano faseado. Cada fase é **testável isoladamente** e depende da anterior, então a
> ordem importa: coleta → embeddings → ranking → resumo → áudio → entrega → orquestração.
> Marque as caixas conforme avança.

---

## Fase 0 — Fundação

- [ ] Confirmar o **store vetorial**: pgvector reaproveitado *vs* MariaDB 11.8 nativo
- [ ] Definir **topologia**: módulo dentro do blog *vs* serviço separado
- [ ] Criar `config/news.php` (feeds, keywords, pesos α/β, top N, toggles de canal, endpoints Ollama/Piper)
- [ ] Levantar a **lista inicial** de feeds RSS e palavras-chave
- [ ] Migrations: `news_articles` (com `url` único + coluna de embedding) e `news_digests`
- [ ] Models: `NewsArticle`, `NewsDigest`

## Fase 1 — Camada de IA (cliente Ollama)

> A "formatação da API pra uso da IA" — fazer isso primeiro porque coleta, embeddings e
> resumo todos dependem dela.

- [ ] `OllamaClient`: chamadas a `/api/embeddings` e `/api/generate`, com timeout e retry
- [ ] Padronizar o formato de request e centralizar os parâmetros de geração
      (`think:false`, `temperature:0.2`, `repeat_penalty:1.15`)
- [ ] Teste rápido: gerar 1 embedding com `bge-m3` e 1 resposta com `qwen3:8b`

## Fase 2 — Coleta

- [ ] `FeedFetcher`: ler RSS (SimplePie ou Guzzle + parse XML), normalizar os itens
- [ ] Dedupe pelo índice único em `url`
- [ ] Persistir artigos novos com status `novo`
- [ ] Teste: rodar a coleta e conferir os artigos no banco

## Fase 3 — Filtro por interesse

- [ ] `ArticleEmbedder`: gerar o embedding (`bge-m3`) de cada artigo novo
- [ ] Montar o **perfil de interesses** (frases-tema → embeddar e guardar)
- [ ] `InterestRanker`: `score = α·cosseno + β·keyword`; selecionar top N
- [ ] Ajustar **α/β** e o **N** com dados reais

## Fase 4 — Resumo em pt-BR

- [ ] `Summarizer`: prompt *grounded* em pt-BR (N frases, tom neutro), via `OllamaClient`
- [ ] Tratar artigos longos (truncar ou dividir, se necessário)
- [ ] Validar a qualidade e iterar no prompt

## Fase 5 — Áudio (TTS)

- [ ] Instalar Piper + baixar uma voz pt-BR
- [ ] `SpeechSynthesizer`: texto do digest → MP3
- [ ] Definir formato/qualidade e salvar no storage

## Fase 6 — Entrega (fan-out)

- [ ] Montar o `news_digests` do dia (texto + caminho do áudio)
- [ ] `BlogPublisher` + rota e view listando os digests
- [ ] `TelegramPublisher`: texto (+ voz opcional)
- [ ] `DiscordPublisher`: webhook com texto + MP3 anexado
- [ ] Toggles de canal lendo do `config/news.php`

## Fase 7 — Orquestração

- [ ] Comando `news:digest` amarrando o pipeline ponta a ponta
- [ ] Registrar no **scheduler** (1x/dia)
- [ ] Garantir idempotência: não reenviar digest já enviado
- [ ] Logs por etapa (coleta, ranking, resumo, áudio, envio)

## Fase 8 — Refino e escala

- [ ] Métricas: nº de artigos, tempo por etapa, qualidade do filtro
- [ ] Ajuste fino de prompt e pesos com feedback de uso
- [ ] Avaliar `qwen3:14b` se a qualidade do resumo exigir
- [ ] *(Futuro)* fontes além de RSS que precisem de parsing dedicado

---

### Ordem sugerida de construção

A dependência é linear: sem **coleta** não há o que **embeddar**; sem embeddings não há
**ranking**; sem ranking não há o que **resumir**; sem resumo não há **áudio** nem
**entrega**. Construa cada fase até ela funcionar sozinha antes de seguir — assim você
sempre tem um pedaço testável e nunca debuga três coisas ao mesmo tempo.
