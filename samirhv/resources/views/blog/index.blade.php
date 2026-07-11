@extends('layouts.app')

@section('title', 'Blog')
@section('description', 'Todos os posts do blog — tecnologia, desenvolvimento e reflexões.')

@section('content')

    <!-- Page Header -->
    <section class="dark include-header" style="background-color: var(--cp-bg); padding: 130px 0 70px; position: relative; overflow: hidden;">
        <svg style="position: absolute; inset: 0; z-index: 0; opacity: 0.18;" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
            <defs>
                <pattern id="cp-dots-blog" x="0" y="0" width="28" height="28" patternUnits="userSpaceOnUse">
                    <circle cx="1.5" cy="1.5" r="1.2" fill="#6366f1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#cp-dots-blog)"/>
        </svg>
        <div style="position: absolute; top: -60px; right: -80px; width: 480px; height: 480px; background: radial-gradient(ellipse, rgba(99,102,241,0.07) 0%, transparent 68%); pointer-events: none; z-index: 0;"></div>
        <div style="position: absolute; bottom: -80px; left: -60px; width: 350px; height: 350px; background: radial-gradient(ellipse, rgba(99,102,241,0.04) 0%, transparent 65%); pointer-events: none; z-index: 0;"></div>

        <div class="container" style="position: relative; z-index: 1;">
            <span class="cp-eyebrow">// BLOG</span>
            <h1 style="font-family: var(--cp-font-sans); font-size: clamp(2rem, 4vw, 3.4rem); font-weight: 800; color: var(--cp-text); letter-spacing: -0.03em; line-height: 1.08; margin-bottom: 14px;">
                Todos os <span style="color: var(--cp-accent);">posts</span>
            </h1>
            <p style="font-family: var(--cp-font-sans); font-size: 1.05rem; color: var(--cp-text-secondary); max-width: 500px; line-height: 1.75; margin-bottom: 28px;">
                {{ $totalPosts }} {{ $totalPosts === 1 ? 'publicação' : 'publicações' }}{{ $currentCategory ? ' em "'.$currentCategory.'"' : '' }}
            </p>

            <!-- Filtro de categorias -->
            <div class="d-flex flex-wrap gap-2" style="padding-top: 8px;">
                <a href="{{ route('blog.index') }}" class="button button-rounded button-small {{ !$currentCategory ? '' : 'button-border' }}" style="{{ !$currentCategory ? 'background:var(--cp-accent);border-color:var(--cp-accent);color:#fff;' : 'border-color:rgba(99,102,241,0.3);color:var(--cp-text-muted);' } font-family:var(--cp-font-mono);font-size:0.74rem;transition:all 0.2s;">Todos</a>
                @foreach($categories as $cat)
                <a href="{{ route('blog.index') }}?categoria={{ $cat['slug'] }}" class="button button-rounded button-small {{ $currentCategory === $cat['slug'] ? '' : 'button-border' }}" style="{{ $currentCategory === $cat['slug'] ? 'background:var(--cp-accent);border-color:var(--cp-accent);color:#fff;' : 'border-color:rgba(99,102,241,0.3);color:var(--cp-text-muted);' } font-family:var(--cp-font-mono);font-size:0.74rem;transition:all 0.2s;">{{ $cat['name'] }}</a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Posts Grid -->
    <section id="content">
        <div class="content-wrap py-0">
            <section class="section my-0 dark" style="background-color: var(--cp-surface); padding: 80px 0 110px;">
                <div class="container">
                    @if($posts->count() > 0)
                    <div class="row g-4">
                        @foreach($posts as $post)
                        <div class="col-lg-4 col-md-6">
                            <article class="cp-glass-card h-100" style="padding: 30px; display: flex; flex-direction: column;">
                                <div style="margin-bottom: 16px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                                    <span style="font-family: var(--cp-font-mono); font-size: 0.66rem; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: var(--cp-accent); background: var(--cp-accent-soft); border: 1px solid rgba(99,102,241,0.18); border-radius: 4px; padding: 3px 10px;">{{ $post['category'] }}</span>
                                    @if($post['featured'] ?? false)
                                    <span style="font-family: var(--cp-font-mono); font-size: 0.63rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: #0d0d14; background: linear-gradient(135deg, #f59e0b, #fbbf24); border-radius: 4px; padding: 3px 9px;">destaque</span>
                                    @endif
                                </div>
                                <h2 style="font-family: var(--cp-font-sans); font-size: 1.1rem; font-weight: 600; color: var(--cp-text); line-height: 1.42; margin-bottom: 12px;">
                                    <a href="{{ route('blog.show', $post['slug']) }}" style="color: inherit; text-decoration: none;">{{ $post['title'] }}</a>
                                </h2>
                                <p style="font-family: var(--cp-font-sans); font-size: 0.89rem; color: var(--cp-text-secondary); line-height: 1.72; margin-bottom: 20px; flex: 1;">{{ Str::limit($post['excerpt'], 140) }}</p>
                                <div style="display: flex; align-items: center; justify-content: space-between; padding-top: 18px; border-top: 1px solid rgba(99,102,241,0.09);">
                                    <div>
                                        <span style="font-family: var(--cp-font-mono); font-size: 0.7rem; color: var(--cp-text-muted); display: block;">{{ $post['date'] }}</span>
                                        <span style="font-family: var(--cp-font-mono); font-size: 0.66rem; color: #4b5563;">{{ $post['reading_time'] }} min de leitura</span>
                                    </div>
                                    <a href="{{ route('blog.show', $post['slug']) }}" style="font-family: var(--cp-font-mono); font-size: 0.72rem; color: var(--cp-accent); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: gap 0.2s;" onmouseover="this.style.gap='8px'" onmouseout="this.style.gap='4px'">ler <i class="bi-arrow-right" style="font-size: 0.62rem;"></i></a>
                                </div>
                            </article>
                        </div>
                        @endforeach
                    </div>

                    <!-- Paginação -->
                    @if($posts instanceof \Illuminate\Pagination\LengthAwarePaginator && $posts->hasPages())
                    <div class="d-flex justify-content-center mt-5 gap-3" style="padding-top: 16px;">
                        @if($posts->onFirstPage())
                            <span class="button button-rounded button-small button-border" style="border-color:rgba(99,102,241,0.15);color:#4b5563;cursor:not-allowed;font-family:var(--cp-font-mono);font-size:0.78rem;">← anterior</span>
                        @else
                            <a href="{{ $posts->previousPageUrl() }}" class="button button-rounded button-small button-border" style="border-color:rgba(99,102,241,0.3);color:var(--cp-text-secondary);font-family:var(--cp-font-mono);font-size:0.78rem;transition:all 0.2s;">← anterior</a>
                        @endif
                        @if($posts->hasMorePages())
                            <a href="{{ $posts->nextPageUrl() }}" class="button button-rounded button-small" style="background:var(--cp-accent);border-color:var(--cp-accent);color:#fff;font-family:var(--cp-font-mono);font-size:0.78rem;transition:all 0.2s;">próximo →</a>
                        @else
                            <span class="button button-rounded button-small button-border" style="border-color:rgba(99,102,241,0.15);color:#4b5563;cursor:not-allowed;font-family:var(--cp-font-mono);font-size:0.78rem;">próximo →</span>
                        @endif
                    </div>
                    @endif

                    @else
                    <div class="text-center" style="padding: 90px 0;">
                        <div style="font-family: var(--cp-font-mono); font-size: 2.4rem; color: rgba(99,102,241,0.2); margin-bottom: 1.25rem;">&#123; &#125;</div>
                        <h3 style="font-family: var(--cp-font-sans); color: var(--cp-text-muted); font-weight: 500; font-size: 1.15rem;">Nenhum post encontrado</h3>
                        <p style="font-family: var(--cp-font-mono); font-size: 0.82rem; color: #4b5563; margin-top: 0.6rem;">// em breve por aqui</p>
                        <a href="{{ route('home') }}" class="button button-rounded mt-4" style="background:var(--cp-accent);border-color:var(--cp-accent);color:#fff;font-family:var(--cp-font-sans);font-weight:600;padding:10px 26px;">← Voltar ao início</a>
                    </div>
                    @endif
                </div>
            </section>
        </div>
    </section>

@endsection
