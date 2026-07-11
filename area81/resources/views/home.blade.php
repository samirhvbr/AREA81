@extends('layouts.app')

@section('title', 'Samirhv')
@section('description', 'Blog pessoal de Samir Hanna Verza — tecnologia, desenvolvimento e reflexões.')

@section('content')

    <!-- Hero -->
    <section id="hero" class="min-vh-100 d-flex align-items-center dark include-header py-5 py-lg-0" style="background-color: var(--cp-bg); position: relative; overflow: hidden;">

        <!-- Dot Grid -->
        <svg class="cp-dot-grid" xmlns="http://www.w3.org/2000/svg" width="100%" height="100%">
            <defs>
                <pattern id="cp-dots" x="0" y="0" width="28" height="28" patternUnits="userSpaceOnUse">
                    <circle cx="1.5" cy="1.5" r="1.2" fill="#6366f1"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#cp-dots)"/>
        </svg>

        <div class="cp-hero-glow"></div>

        <!-- Secondary glow (bottom-left) -->
        <div style="position: absolute; bottom: -120px; left: -80px; width: 400px; height: 400px; background: radial-gradient(ellipse, rgba(99,102,241,0.06) 0%, transparent 65%); pointer-events: none; z-index: 0;"></div>

        <div class="container" style="position: relative; z-index: 1; padding-bottom: 90px;">
            <div class="row align-items-center g-5">

                <!-- Coluna esquerda -->
                <div class="col-lg-6">
                    <div style="display: inline-flex; align-items: center; gap: 8px; background: rgba(99,102,241,0.08); border: 1px solid rgba(99,102,241,0.15); border-radius: 99px; padding: 6px 16px; margin-bottom: 24px;">
                        <span style="width: 7px; height: 7px; border-radius: 50%; background: #22c55e; animation: cp-blink 2s ease-in-out infinite;"></span>
                        <span class="cp-eyebrow" style="margin-bottom: 0;">BLOG PESSOAL</span>
                    </div>

                    <h1 class="cp-hero-h1 mb-4">
                        Ideias, código<br><span style="color: var(--cp-accent);">e reflexões.</span>
                    </h1>

                    <p style="font-family: var(--cp-font-sans); font-size: 1.15rem; color: var(--cp-text-secondary); line-height: 1.8; max-width: 500px; margin-bottom: 0;">
                        Escrito por Samir Hanna Verza. Aqui registro o que aprendo, experimento e penso sobre tecnologia, desenvolvimento e o mundo ao redor.
                    </p>

                    <div class="d-flex gap-3 flex-wrap" style="margin-top: 2.25rem;">
                        <a href="{{ route('blog.index') }}" class="button button-rounded button-large d-inline-flex align-items-center gap-2" style="background: linear-gradient(135deg, #6366f1, #818cf8); border: none; color: #fff; font-family: var(--cp-font-sans); font-weight: 600; padding: 15px 34px; box-shadow: 0 4px 24px rgba(99,102,241,0.35); transition: all 0.25s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 32px rgba(99,102,241,0.45)'" onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 24px rgba(99,102,241,0.35)'">
                            Ver todos os posts <i class="bi-arrow-right" style="font-size: 0.9rem;"></i>
                        </a>
                        <a href="{{ route('blog.index') }}?categoria=dev" class="button button-rounded button-large button-border d-inline-flex align-items-center gap-2" style="border-color: rgba(99,102,241,0.4); color: #a5b4fc; font-family: var(--cp-font-sans); font-weight: 600; padding: 15px 34px; transition: all 0.25s;" onmouseover="this.style.borderColor='#6366f1'; this.style.color='#c7d2fe'; this.style.background='rgba(99,102,241,0.08)'" onmouseout="this.style.borderColor='rgba(99,102,241,0.4)'; this.style.color='#a5b4fc'; this.style.background='transparent'">
                            <i class="fa-solid fa-code" style="font-size: 0.85rem;"></i> Dev & Tech
                        </a>
                    </div>

                    <div style="margin-top: 2rem; display: flex; align-items: center; gap: 16px;">
                        <span style="font-size: 0.82rem; color: var(--cp-text-muted); font-family: var(--cp-font-mono);">
                            <span style="color: #22c55e;">&#9679;</span>&nbsp; samirhv.com.br
                        </span>
                        <span style="width: 3px; height: 3px; border-radius: 50%; background: rgba(99,102,241,0.35);"></span>
                        <span style="font-size: 0.82rem; color: var(--cp-text-muted); font-family: var(--cp-font-mono);">
                            Laravel + Canvas
                        </span>
                    </div>
                </div>

                <!-- Coluna direita — Post em destaque simulado -->
                <div class="col-lg-6">
                    <div class="cp-terminal-wrapper">
                        <div class="cp-terminal-inner">

                            <!-- Header do card -->
                            <div style="background: linear-gradient(180deg, #1e1e36 0%, #1a1a2e 100%); padding: 14px 20px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid rgba(99,102,241,0.12);">
                                <div style="display: flex; gap: 7px;">
                                    <span style="width:11px;height:11px;border-radius:50%;background:#ff5f57;display:inline-block;"></span>
                                    <span style="width:11px;height:11px;border-radius:50%;background:#febc2e;display:inline-block;"></span>
                                    <span style="width:11px;height:11px;border-radius:50%;background:#28c840;display:inline-block;"></span>
                                </div>
                                <span style="margin-left: 14px; font-family: var(--cp-font-mono); font-size: 0.72rem; color: var(--cp-text-muted); letter-spacing: 0.02em;">post-recente.md</span>
                                <span style="margin-left: auto; font-family: var(--cp-font-mono); font-size: 0.65rem; color: #374151; background: rgba(99,102,241,0.1); border: 1px solid rgba(99,102,241,0.18); border-radius: 4px; padding: 2px 10px;">Blog</span>
                            </div>

                            <!-- Conteúdo -->
                            <div style="padding: 28px 30px; font-family: var(--cp-font-mono); font-size: 0.82rem; line-height: 2; background: var(--cp-bg); overflow-x: auto;">
                                @if(isset($featuredPost))
                                    <div><span style="color:#4b5563"># {{ $featuredPost['category'] }}</span></div>
                                    <div>&nbsp;</div>
                                    <div><span style="color:#a78bfa">## </span><span style="color:#f1f5f9">{{ $featuredPost['title'] }}</span></div>
                                    <div>&nbsp;</div>
                                    <div><span style="color:#94a3b8">{{ Str::limit($featuredPost['excerpt'], 140) }}</div>
                                    <div>&nbsp;</div>
                                    <div><span style="color:#4b5563">// {{ $featuredPost['date'] }} &mdash; {{ $featuredPost['reading_time'] }} min de leitura</span></div>
                                @else
                                    <div><span style="color:#4b5563"># tecnologia</span></div>
                                    <div>&nbsp;</div>
                                    <div><span style="color:#a78bfa">## </span><span style="color:#f1f5f9">Bem-vindo ao blog</span></div>
                                    <div>&nbsp;</div>
                                    <div><span style="color:#94a3b8">Este é o meu espaço pessoal para escrever sobre</span></div>
                                    <div><span style="color:#94a3b8">tecnologia, código e o que mais despertar</span></div>
                                    <div><span style="color:#94a3b8">curiosidade no caminho.</span></div>
                                    <div>&nbsp;</div>
                                    <div><span style="color:#4b5563">// maio 2026 &mdash; primeiros passos</span></div>
                                @endif
                                <div style="padding-left: 0; position: relative; margin-top: 0.75rem;">
                                    <span style="color: rgba(99,102,241,0.5); font-style: italic;">Continue lendo...</span><span class="cp-cursor"></span>
                                </div>
                            </div>

                            <!-- Badge -->
                            <div style="padding: 12px 20px; border-top: 1px solid rgba(99,102,241,0.12); background: rgba(99,102,241,0.05); display: flex; align-items: center; gap: 10px;">
                                <span style="color: var(--cp-accent); font-size: 0.85rem;">&#10022;</span>
                                <span style="font-family: var(--cp-font-mono); font-size: 0.72rem; color: #a5b4fc;">Novo post disponível — <strong style="color: #e0e7ff;">leia agora</strong></span>
                                <a href="{{ route('blog.index') }}" style="margin-left: auto; font-family: var(--cp-font-mono); font-size: 0.68rem; color: var(--cp-accent); white-space: nowrap; text-decoration: none; background: rgba(99,102,241,0.1); padding: 4px 12px; border-radius: 99px; transition: all 0.2s;" onmouseover="this.style.background='rgba(99,102,241,0.2)'" onmouseout="this.style.background='rgba(99,102,241,0.1)'">Ver todos →</a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Marquee Strip -->
        <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(180deg, transparent, rgba(26,26,46,0.95)); border-top: 1px solid rgba(99,102,241,0.12); padding: 13px 0; overflow: hidden; z-index: 2; backdrop-filter: blur(8px);">
            <div class="cp-marquee-track">
                <span style="font-family: var(--cp-font-mono); font-size: 0.74rem; color: var(--cp-text-muted); margin: 0 38px; letter-spacing: 0.06em; white-space: nowrap; display: inline-flex; align-items: center; gap: 7px;"><i class="fa-solid fa-server" style="color:var(--cp-accent);"></i>Linux</span>
                <span style="font-family: var(--cp-font-mono); font-size: 0.74rem; color: var(--cp-text-muted); margin: 0 38px; letter-spacing: 0.06em; white-space: nowrap; display: inline-flex; align-items: center; gap: 7px;"><i class="fa-brands fa-laravel" style="color:#FF2D20;"></i>Laravel</span>
                <span style="font-family: var(--cp-font-mono); font-size: 0.74rem; color: var(--cp-text-muted); margin: 0 38px; letter-spacing: 0.06em; white-space: nowrap; display: inline-flex; align-items: center; gap: 7px;"><i class="fa-brands fa-php" style="color:#777BB4;"></i>PHP</span>
                <span style="font-family: var(--cp-font-mono); font-size: 0.74rem; color: var(--cp-text-muted); margin: 0 38px; letter-spacing: 0.06em; white-space: nowrap; display: inline-flex; align-items: center; gap: 7px;"><i class="fa-brands fa-docker" style="color:#2496ED;"></i>Docker</span>
                <span style="font-family: var(--cp-font-mono); font-size: 0.74rem; color: var(--cp-text-muted); margin: 0 38px; letter-spacing: 0.06em; white-space: nowrap; display: inline-flex; align-items: center; gap: 7px;"><i class="fa-brands fa-git-alt" style="color:#F05032;"></i>Git</span>
                <span style="font-family: var(--cp-font-mono); font-size: 0.74rem; color: var(--cp-text-muted); margin: 0 38px; letter-spacing: 0.06em; white-space: nowrap; display: inline-flex; align-items: center; gap: 7px;"><i class="fa-solid fa-database" style="color:#4479A1;"></i>MySQL</span>
                <span style="font-family: var(--cp-font-mono); font-size: 0.74rem; color: rgba(99,102,241,0.25); margin: 0 38px; letter-spacing: 0.06em; white-space: nowrap; display: inline-flex; align-items: center; gap: 6px;"><i class="fa-solid fa-circle-dot" style="font-size:0.45rem;"></i></span>
                <!-- Duplicate for seamless loop -->
                <span style="font-family: var(--cp-font-mono); font-size: 0.74rem; color: var(--cp-text-muted); margin: 0 38px; letter-spacing: 0.06em; white-space: nowrap; display: inline-flex; align-items: center; gap: 7px;"><i class="fa-solid fa-server" style="color:var(--cp-accent);"></i>Linux</span>
                <span style="font-family: var(--cp-font-mono); font-size: 0.74rem; color: var(--cp-text-muted); margin: 0 38px; letter-spacing: 0.06em; white-space: nowrap; display: inline-flex; align-items: center; gap: 7px;"><i class="fa-solid fa-server" style="color:#fff000;"></i>Debian</span>
                <span style="font-family: var(--cp-font-mono); font-size: 0.74rem; color: var(--cp-text-muted); margin: 0 38px; letter-spacing: 0.06em; white-space: nowrap; display: inline-flex; align-items: center; gap: 7px;"><i class="fa-brands fa-laravel" style="color:#FF2D20;"></i>Laravel</span>
                <span style="font-family: var(--cp-font-mono); font-size: 0.74rem; color: var(--cp-text-muted); margin: 0 38px; letter-spacing: 0.06em; white-space: nowrap; display: inline-flex; align-items: center; gap: 7px;"><i class="fa-brands fa-php" style="color:#777BB4;"></i>PHP</span>
                <span style="font-family: var(--cp-font-mono); font-size: 0.74rem; color: var(--cp-text-muted); margin: 0 38px; letter-spacing: 0.06em; white-space: nowrap; display: inline-flex; align-items: center; gap: 7px;"><i class="fa-brands fa-docker" style="color:#2496ED;"></i>Docker</span>
                <span style="font-family: var(--cp-font-mono); font-size: 0.74rem; color: var(--cp-text-muted); margin: 0 38px; letter-spacing: 0.06em; white-space: nowrap; display: inline-flex; align-items: center; gap: 7px;"><i class="fa-brands fa-git-alt" style="color:#F05032;"></i>Git</span>
                <span style="font-family: var(--cp-font-mono); font-size: 0.74rem; color: var(--cp-text-muted); margin: 0 38px; letter-spacing: 0.06em; white-space: nowrap; display: inline-flex; align-items: center; gap: 7px;"><i class="fa-solid fa-database" style="color:#4479A1;"></i>MySQL</span>
                <span style="font-family: var(--cp-font-mono); font-size: 0.74rem; color: rgba(99,102,241,0.25); margin: 0 38px; letter-spacing: 0.06em; white-space: nowrap; display: inline-flex; align-items: center; gap: 6px;"><i class="fa-solid fa-circle-dot" style="font-size:0.45rem;"></i></span>
            </div>
        </div>

    </section>

    <!-- Content -->
    <section id="content">
        <div class="content-wrap py-0">

            <!-- Tópicos / Categorias -->
            <section class="section my-0 dark" style="background-color: var(--cp-surface); padding: 95px 0; position: relative;">
                <div style="position: absolute; top: 0; left: 50%; transform: translateX(-50%); width: 600px; height: 300px; background: radial-gradient(ellipse at center top, rgba(99,102,241,0.05) 0%, transparent 70%); pointer-events: none;"></div>

                <div class="container" style="position: relative;">
                    <div class="text-center mb-5" style="max-width: 560px; margin-left: auto; margin-right: auto;">
                        <span class="cp-eyebrow">// TÓPICOS</span>
                        <h2 style="font-family: var(--cp-font-sans); font-weight: 700; font-size: clamp(1.75rem, 3vw, 2.5rem); line-height: 1.2; letter-spacing: -0.01em; color: var(--cp-text); margin-bottom: 14px;">O que você vai encontrar aqui</h2>
                        <p style="font-family: var(--cp-font-sans); font-size: 1.05rem; color: var(--cp-text-secondary); line-height: 1.75; margin: 0;">Escrita honesta sobre temas que me interessam de verdade.</p>
                    </div>
                    <div class="row g-4 mt-2">
                        @foreach($topics as $topic)
                        <div class="col-lg-4 col-md-6 col-12">
                            <a href="{{ route('blog.index') }}?categoria={{ $topic['slug'] }}" style="text-decoration: none;">
                                <div class="cp-feat-card">
                                    <div class="cp-feat-icon">
                                        <i class="{{ $topic['icon'] }}" style="font-size: 1.3rem; color: var(--cp-accent);"></i>
                                    </div>
                                    <h3 style="font-family: var(--cp-font-sans); font-weight: 600; font-size: 1.1rem; color: var(--cp-text); margin-bottom: 10px;">{{ $topic['name'] }}</h3>
                                    <p style="font-family: var(--cp-font-sans); font-size: 0.9rem; color: var(--cp-text-secondary); line-height: 1.7; margin: 0;">{{ $topic['description'] }}</p>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <!-- Posts Recentes -->
            <section class="section my-0 dark" style="background-color: var(--cp-bg); padding: 95px 0; position: relative; overflow: hidden;">
                <div style="position: absolute; top: -100px; left: -150px; width: 550px; height: 550px; background: radial-gradient(ellipse, rgba(99,102,241,0.07) 0%, transparent 68%); pointer-events: none; z-index: 0;"></div>
                <div style="position: absolute; bottom: -120px; right: -100px; width: 450px; height: 450px; background: radial-gradient(ellipse, rgba(99,102,241,0.04) 0%, transparent 68%); pointer-events: none; z-index: 0;"></div>

                <div class="container" style="position: relative; z-index: 1;">

                    <div class="text-center" style="max-width: 580px; margin: 0 auto 64px;">
                        <span class="cp-eyebrow">// POSTS RECENTES</span>
                        <h2 style="font-family: var(--cp-font-sans); font-size: clamp(1.75rem, 3vw, 2.5rem); font-weight: 700; color: var(--cp-text); letter-spacing: -0.02em; line-height: 1.2; margin-bottom: 14px;">Últimas publicações</h2>
                    </div>

                    <div class="row g-4">
                        @forelse($recentPosts as $post)
                        <div class="col-lg-4 col-md-6">
                            <article class="cp-glass-card h-100" style="padding: 30px; display: flex; flex-direction: column;">
                                <div style="margin-bottom: 18px; display: flex; align-items: center; gap: 10px;">
                                    <span style="font-family: var(--cp-font-mono); font-size: 0.66rem; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; color: var(--cp-accent); background: var(--cp-accent-soft); border: 1px solid rgba(99,102,241,0.18); border-radius: 4px; padding: 3px 10px;">{{ $post['category'] }}</span>
                                </div>
                                <h3 style="font-family: var(--cp-font-sans); font-size: 1.1rem; font-weight: 600; color: var(--cp-text); line-height: 1.42; margin-bottom: 12px;">
                                    <a href="{{ route('blog.show', $post['slug']) }}" style="color: inherit; text-decoration: none;">{{ $post['title'] }}</a>
                                </h3>
                                <p style="font-family: var(--cp-font-sans); font-size: 0.89rem; color: var(--cp-text-secondary); line-height: 1.72; margin-bottom: 22px; flex: 1;">{{ Str::limit($post['excerpt'], 120) }}</p>
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-top: auto; padding-top: 18px; border-top: 1px solid rgba(99,102,241,0.09);">
                                    <span style="font-family: var(--cp-font-mono); font-size: 0.7rem; color: var(--cp-text-muted);">{{ $post['date'] }}</span>
                                    <a href="{{ route('blog.show', $post['slug']) }}" style="font-family: var(--cp-font-mono); font-size: 0.72rem; color: var(--cp-accent); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: gap 0.2s;" onmouseover="this.style.gap='8px'" onmouseout="this.style.gap='4px'">ler <i class="bi-arrow-right" style="font-size: 0.62rem;"></i></a>
                                </div>
                            </article>
                        </div>
                        @empty
                        <div class="col-12 text-center" style="padding: 70px 0;">
                            <div style="font-family: var(--cp-font-mono); font-size: 2.2rem; color: rgba(99,102,241,0.2); margin-bottom: 1rem;">&#123; &#125;</div>
                            <h3 style="font-family: var(--cp-font-sans); color: var(--cp-text-muted); font-weight: 500;">Nenhum post ainda</h3>
                            <p style="font-family: var(--cp-font-mono); font-size: 0.82rem; color: #4b5563; margin-top: 0.5rem;">// em breve por aqui</p>
                        </div>
                        @endforelse
                    </div>

                    @if(count($recentPosts) > 0)
                    <div class="text-center mt-5 pt-3">
                        <a href="{{ route('blog.index') }}" class="button button-rounded button-large button-border" style="border-color: rgba(99,102,241,0.4); color: #a5b4fc; font-family: var(--cp-font-sans); font-weight: 600; transition: all 0.25s;" onmouseover="this.style.borderColor='#6366f1'; this.style.color='#c7d2fe'" onmouseout="this.style.borderColor='rgba(99,102,241,0.4)'; this.style.color='#a5b4fc'">
                            Ver todos os posts <i class="bi-arrow-right ms-2"></i>
                        </a>
                    </div>
                    @endif

                </div>
            </section>

        </div>
    </section>

@endsection
