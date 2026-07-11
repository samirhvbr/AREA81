<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'pgsql_vector';

    public function up(): void
    {
        // Habilita a extensão pgvector (idempotente)
        DB::connection('pgsql_vector')->statement('CREATE EXTENSION IF NOT EXISTS vector');

        Schema::connection('pgsql_vector')->create('news_articles', function (Blueprint $table) {
            $table->id();
            $table->string('url')->unique();
            $table->string('title');
            $table->string('source');
            $table->text('excerpt')->nullable();
            $table->longText('content')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->enum('status', ['novo', 'embeddado', 'descartado', 'resumido'])->default('novo');
            $table->float('score')->nullable();
            $table->timestamps();
        });

        // Coluna vector(1024) — tipo nativo do pgvector, fora do Blueprint
        DB::connection('pgsql_vector')
            ->statement('ALTER TABLE news_articles ADD COLUMN embedding vector(1024)');

        // Índice HNSW para busca por cosseno
        DB::connection('pgsql_vector')
            ->statement('CREATE INDEX news_articles_embedding_hnsw ON news_articles USING hnsw (embedding vector_cosine_ops)');
    }

    public function down(): void
    {
        Schema::connection('pgsql_vector')->dropIfExists('news_articles');
    }
};
