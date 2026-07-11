<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Feeds RSS
    |--------------------------------------------------------------------------
    | Cada entrada: ['url' => '...', 'source' => 'Nome legível']
    */
    'feeds' => [
        // ['url' => 'https://exemplo.com/feed.xml', 'source' => 'Exemplo'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Perfil de interesses
    |--------------------------------------------------------------------------
    | Frases que descrevem os temas relevantes. Cada frase é embeddada com
    | bge-m3 e usada como vetor de referência pelo InterestRanker.
    */
    'interest_phrases' => [
        // 'novidades em modelos de IA open source',
        // 'regulação de inteligência artificial no Brasil',
    ],

    /*
    |--------------------------------------------------------------------------
    | Palavras-chave (boost de score)
    |--------------------------------------------------------------------------
    | Menções a esses termos somam β ao score final do artigo.
    | Não são porteiros — só aumentam o peso.
    */
    'keywords' => [
        // 'Ollama', 'LLaMA', 'Claude', 'pgvector',
    ],

    /*
    |--------------------------------------------------------------------------
    | Pesos do ranking e tamanho do digest
    |--------------------------------------------------------------------------
    */
    'alpha'  => env('NEWS_ALPHA', 0.7),   // peso do cosseno semântico
    'beta'   => env('NEWS_BETA', 0.3),    // peso do match de keyword
    'top_n'  => env('NEWS_TOP_N', 5),     // artigos por digest

    /*
    |--------------------------------------------------------------------------
    | Ollama
    |--------------------------------------------------------------------------
    */
    'ollama' => [
        'base_url'       => env('OLLAMA_URL', 'http://localhost:11434'),
        'embed_model'    => env('OLLAMA_EMBED_MODEL', 'bge-m3'),
        'generate_model' => env('OLLAMA_GENERATE_MODEL', 'qwen3:8b'),
        'timeout'        => env('OLLAMA_TIMEOUT', 120),
        'generation'     => [
            'think'          => false,
            'temperature'    => 0.2,
            'repeat_penalty' => 1.15,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Piper TTS
    |--------------------------------------------------------------------------
    */
    'piper' => [
        'executable' => env('PIPER_BIN', '/usr/local/bin/piper'),
        'model'      => env('PIPER_MODEL', ''),       // caminho do arquivo .onnx
        'config'     => env('PIPER_MODEL_CONFIG', ''), // caminho do .onnx.json
        'output_dir' => env('PIPER_OUTPUT_DIR', storage_path('app/digests/audio')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Canais de entrega
    |--------------------------------------------------------------------------
    */
    'channels' => [
        'blog'     => env('NEWS_CHANNEL_BLOG', true),
        'telegram' => env('NEWS_CHANNEL_TELEGRAM', false),
        'discord'  => env('NEWS_CHANNEL_DISCORD', false),
    ],

    'telegram' => [
        'bot_token' => env('TELEGRAM_BOT_TOKEN', ''),
        'chat_id'   => env('TELEGRAM_CHAT_ID', ''),
        'send_audio' => env('TELEGRAM_SEND_AUDIO', false),
    ],

    'discord' => [
        'webhook_url' => env('DISCORD_WEBHOOK_URL', ''),
    ],

];
