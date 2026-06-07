<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('news_digests', function (Blueprint $table) {
            $table->id();
            $table->date('digest_date')->unique();
            $table->text('content');
            $table->string('audio_path')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->boolean('sent_telegram')->default(false);
            $table->boolean('sent_discord')->default(false);
            $table->json('article_ids')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('news_digests');
    }
};
