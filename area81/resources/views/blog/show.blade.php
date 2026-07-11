@extends('layouts.app')

@section('title', $post['title'])
@section('description', Str::limit($post['excerpt'], 160))

@section('content')

    <!-- Post Header -->
    <section class="dark include-header" style="background-color: var(--cp-bg); padding: 130px 0 60px; position: relative; overflow: hidden;">
        <svg style="position: absolute; inset: 0; z-index: 0; opacity: 0.14;" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
            <defs>
                <pattern id="cp-dots-post" x="0" y="0" width="28" height="28" patternUnits="userSpaceOnUse">
                    <circle cx="1.5" cy="1.5" r="1.2" fill="#6366f1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#cp-dots-post)"/>
        </svg>
        <div style="position: absolute; top: -50px; right: -60px; width: 450px; height: 450px; background: radial-gradient(ellipse, rgba(99,102,241,0.07) 0%, transparent 68%); pointer-events: none; z-index: 0;"></div>

        <div class="container" style="position: relative; z-index: 1; max-width: 840px;">
            <div style="margin-bottom: 22px;">
                <a href="{{ route('blog.index') }}" style="font-family: var(--cp-font-mono); font-size: 0.76rem; color: var(--cp-accent); text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: gap 0.2s;" onmouseover="this.style.gap='10px'" onmouseout="this.style.gap='6px'">
                    <i class="bi-arrow-left" style="font-size: 0.7rem;"></i> voltar ao blog
                </a>
            </div>

            <div style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <span style="font-family: var(--cp-font-mono); font-size: 0.66rem; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: var(--cp-accent); background: var(--cp-accent-soft); border: 1px solid rgba(99,102,241,0.18); border-radius: 4px; padding: 3px 10px;">{{ $post['category'] }}</span>
                <span style="display: inline-flex; align-items: center; gap: 6px; font-family: var(--cp-font-mono); font-size: 0.72rem; color: var(--cp-text-muted);">
                    <i class="fa-regular fa-calendar" style="font-size: 0.65rem;"></i> {{ $post['date'] }}
                </span>
                <span style="display: inline-flex; align-items: center; gap: 5px; font-family: var(--cp-font-mono); font-size: 0.72rem; color: #4b5563;">
                    <i class="fa-regular fa-clock" style="font-size: 0.65rem;"></i> {{ $post['reading_time'] }} min
                </span>
            </div>

            <h1 style="font-family: var(--cp-font-sans); font-size: clamp(1.8rem, 4vw, 2.9rem); font-weight: 800; color: var(--cp-text); letter-spacing: -0.03em; line-height: 1.15; margin-bottom: 20px;">{{ $post['title'] }}</h1>

            <p style="font-family: var(--cp-font-sans); font-size: 1.12rem; color: var(--cp-text-secondary); line-height: 1.78; max-width: 660px;">{{ $post['excerpt'] }}</p>
        </div>
    </section>

    <!-- Post Content -->
    <section id="content">
        <div class="content-wrap py-0">
            <section class="section my-0 dark" style="background-color: var(--cp-surface); padding: 80px 0 110px;">
                <div class="container" style="max-width: 840px;">
                    <div class="row justify-content-center">
                        <div class="col-12">

                            <!-- Conteúdo do post -->
                            <div class="post-content" style="font-family: var(--cp-font-sans); font-size: 1.0625rem; color: #cbd5e1; line-height: 1.9;">
                                {!! $post['content'] !!}
                            </div>

                            <!-- Tags -->
                            @if(!empty($post['tags']))
                            <div style="margin-top: 52px; padding-top: 32px; border-top: 1px solid rgba(99,102,241,0.1);">
                                <div style="display: flex; align-items: flex-start; gap: 10px; flex-wrap: wrap;">
                                    <span style="font-family: var(--cp-font-mono); font-size: 0.72rem; color: var(--cp-text-muted); white-space: nowrap;">// tags</span>
                                    <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                                        @foreach($post['tags'] as $tag)
                                        <span style="font-family: var(--cp-font-mono); font-size: 0.72rem; color: var(--cp-text-secondary); background: rgba(255,255,255,0.03); border: 1px solid rgba(99,102,241,0.12); border-radius: 99px; padding: 4px 14px; transition: all 0.2s; cursor: default;" onmouseover="this.style.borderColor='rgba(99,102,241,0.35)'; this.style.color='#a5b4fc'" onmouseout="this.style.borderColor='rgba(99,102,241,0.12)'; this.style.color='#94a3b8'">#{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Navegação entre posts -->
                            <div class="row g-4 mt-4">
                                @if($prevPost)
                                <div class="col-sm-6">
                                    <a href="{{ route('blog.show', $prevPost['slug']) }}" class="cp-post-nav-card">
                                        <span style="font-family: var(--cp-font-mono); font-size: 0.68rem; color: var(--cp-accent); display: block; margin-bottom: 8px;">← anterior</span>
                                        <span style="font-family: var(--cp-font-sans); font-size: 0.92rem; color: var(--cp-text); font-weight: 500; line-height: 1.42; display: block;">{{ Str::limit($prevPost['title'], 55) }}</span>
                                    </a>
                                </div>
                                @else
                                <div class="col-sm-6"></div>
                                @endif

                                @if($nextPost)
                                <div class="col-sm-6">
                                    <a href="{{ route('blog.show', $nextPost['slug']) }}" class="cp-post-nav-card text-end" style="text-align: right;">
                                        <span style="font-family: var(--cp-font-mono); font-size: 0.68rem; color: var(--cp-accent); display: block; margin-bottom: 8px;">próximo →</span>
                                        <span style="font-family: var(--cp-font-sans); font-size: 0.92rem; color: var(--cp-text); font-weight: 500; line-height: 1.42; display: block;">{{ Str::limit($nextPost['title'], 55) }}</span>
                                    </a>
                                </div>
                                @endif
                            </div>

                            <!-- CTA voltar -->
                            <div class="text-center mt-5 pt-3">
                                <a href="{{ route('blog.index') }}" class="button button-rounded button-large button-border" style="border-color: rgba(99,102,241,0.4); color: #a5b4fc; font-family: var(--cp-font-sans); font-weight: 600; transition: all 0.25s;" onmouseover="this.style.borderColor='#6366f1'; this.style.color='#c7d2fe'" onmouseout="this.style.borderColor='rgba(99,102,241,0.4)'; this.style.color='#a5b4fc'">← Ver todos os posts</a>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>

@endsection

@push('styles')
<style>
.post-content h1, .post-content h2, .post-content h3, .post-content h4 {
    font-family: var(--cp-font-sans);
    color: var(--cp-text);
    letter-spacing: -0.02em;
    margin-top: 2.75rem;
    margin-bottom: 1rem;
}
.post-content h2 { font-size: 1.72rem; font-weight: 700; }
.post-content h3 { font-size: 1.35rem; font-weight: 600; }
.post-content p { margin-bottom: 1.6rem; }
.post-content a { color: #818cf8; text-decoration: underline; text-underline-offset: 3px; text-decoration-thickness: 1px; transition: color 0.15s; }
.post-content a:hover { color: #a5b4fc; }
.post-content code {
    font-family: var(--cp-font-mono);
    font-size: 0.86em;
    color: #a5b4fc;
    background: rgba(99,102,241,0.1);
    border: 1px solid rgba(99,102,241,0.18);
    border-radius: 5px;
    padding: 2px 7px;
}
.post-content pre {
    background: var(--cp-bg);
    border: 1px solid rgba(99,102,241,0.18);
    border-radius: 12px;
    padding: 26px;
    overflow-x: auto;
    margin-bottom: 1.75rem;
}
.post-content pre code {
    background: none;
    border: none;
    padding: 0;
    color: #e2e8f0;
    font-size: 0.87rem;
    line-height: 1.85;
}
.post-content blockquote {
    border-left: 3px solid var(--cp-accent);
    padding: 14px 26px;
    margin: 2.25rem 0;
    background: rgba(99,102,241,0.04);
    border-radius: 0 10px 10px 0;
    color: var(--cp-text-secondary);
    font-style: italic;
}
.post-content ul, .post-content ol {
    padding-left: 1.6rem;
    margin-bottom: 1.6rem;
}
.post-content li { margin-bottom: 0.55rem; }
.post-content hr {
    border: none;
    border-top: 1px solid rgba(99,102,241,0.13);
    margin: 3.25rem 0;
}
.post-content img {
    max-width: 100%;
    height: auto;
    border-radius: var(--cp-radius-md);
    margin: 2rem 0;
}
</style>
@endpush
