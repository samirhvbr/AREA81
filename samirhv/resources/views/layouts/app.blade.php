<!DOCTYPE html>
<html dir="ltr" lang="pt-BR">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'Blog pessoal de Samir Hanna Verza — tecnologia, desenvolvimento e reflexões.')">
    <meta name="author" content="Samir Hanna Verza">

    <meta property="og:title" content="@yield('title', 'Samirhv') | Blog">
    <meta property="og:description" content="@yield('description', 'Blog pessoal de Samir Hanna Verza — tecnologia, desenvolvimento e reflexões.')">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('vendor/canvas/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/canvas/css/font-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/canvas/css/blog-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/canvas/css/custom.css') }}">

    @stack('styles')

    <title>@yield('title', 'Samirhv') — Blog</title>

    {{-- Matomo Analytics (self-hosted) — só renderiza com MATOMO_* configurado. --}}
    @include('partials.matomo')
</head>

<body class="stretched dark">

    <div id="wrapper">

        <!-- Header -->
        <header id="header" class="transparent-header dark no-sticky">
            <div id="header-wrap">
                <div class="container">
                    <div class="header-row justify-content-lg-between">

                        <div id="logo" class="col-lg-2 order-lg-2 mx-lg-auto justify-content-lg-center">
                            <a href="{{ route('home') }}">
                                <span style="font-family: var(--cp-font-mono); font-size: 1.3rem; font-weight: 700; color: #f1f5f9; letter-spacing: -0.03em;">samirhv<span style="color: var(--cp-accent);">.</span></span>
                            </a>
                        </div>

                        <div class="primary-menu-trigger" data-target=".primary-menu">
                            <button class="cnvs-hamburger" type="button" title="Abrir menu">
                                <span class="cnvs-hamburger-box"><span class="cnvs-hamburger-inner"></span></span>
                            </button>
                        </div>

                        <div class="col-lg-4 d-lg-flex justify-content-end order-lg-last align-items-center gap-3">
                            <div class="header-misc d-none d-lg-flex align-items-center gap-3">
                                <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2" style="font-family: var(--cp-font-sans); font-size: 0.82rem; color: var(--cp-text-muted); text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#a5b4fc'" onmouseout="this.style.color='#64748b'">
                                    <i class="fa-solid fa-house" style="font-size: 0.72rem;"></i> Início
                                </a>
                                <span style="width: 4px; height: 4px; border-radius: 50%; background: rgba(99,102,241,0.35);"></span>
                                <a href="{{ route('blog.index') }}" class="button cp-header-cta rounded m-0" data-class="down-lg:button-small">
                                    <span>Ver todos os posts</span> <i class="bi-arrow-right ms-2 me-0 d-none d-lg-inline"></i>
                                </a>
                            </div>
                        </div>

                        <nav class="primary-menu col-lg-6 order-lg-1 on-click" aria-label="Navegação principal">
                            <ul class="menu-container" style="gap: 2px;">
                                <li class="menu-item"><a class="menu-link" href="{{ route('home') }}"><div>Início</div></a></li>
                                <li class="menu-item"><a class="menu-link" href="{{ route('blog.index') }}"><div>Blog</div></a></li>
                                <li class="menu-item"><a class="menu-link" href="{{ route('blog.index') }}?categoria=tecnologia"><div>Tecnologia</div></a></li>
                                <li class="menu-item"><a class="menu-link" href="{{ route('blog.index') }}?categoria=dev"><div>Dev</div></a></li>
                            </ul>
                        </nav>

                    </div>
                </div>
            </div>
            <div class="header-wrap-clone"></div>
        </header>

        @yield('content')

        <!-- Footer -->
        <footer id="footer" class="dark" style="border-top: 1px solid rgba(99,102,241,0.1);">
            <div class="container">
                <div class="footer-widgets-wrap" style="padding-top: 64px; padding-bottom: 40px;">
                    <div class="row g-5">

                        <!-- Brand Column -->
                        <div class="col-lg-5 col-md-6">
                            <a href="{{ route('home') }}" style="text-decoration: none;">
                                <p style="font-family: var(--cp-font-mono); font-size: 1.6rem; font-weight: 700; color: #f1f5f9; letter-spacing: -0.03em; margin-bottom: 14px;">samirhv<span style="color: var(--cp-accent);">.</span></p>
                            </a>
                            <p class="text-white-50" style="font-size: 0.92rem; line-height: 1.75; max-width: 320px; margin-bottom: 22px;">Blog pessoal de Samir Hanna Verza. Reflexões sobre tecnologia, desenvolvimento de software e o que mais despertar curiosidade.</p>
                            <div class="d-flex gap-3">
                                <a href="https://github.com/samirhv" target="_blank" rel="noopener" class="social-icon bg-white bg-opacity-25 border-transparent rounded-circle si-small h-bg-github" aria-label="GitHub" style="transition: all 0.2s;" onmouseover="this.style.background='rgba(99,102,241,0.45)'" onmouseout="this.style.background='rgba(255,255,255,0.25)'">
                                    <i class="fa-brands fa-github"></i>
                                    <i class="fa-brands fa-github"></i>
                                </a>
                                <a href="#" class="social-icon bg-white bg-opacity-25 border-transparent rounded-circle si-small h-bg-linkedin" aria-label="LinkedIn" style="transition: all 0.2s;" onmouseover="this.style.background='rgba(99,102,241,0.45)'" onmouseout="this.style.background='rgba(255,255,255,0.25)'">
                                    <i class="fa-brands fa-linkedin"></i>
                                    <i class="fa-brands fa-linkedin"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Categories -->
                        <div class="col-lg-3 col-md-6 col-6">
                            <h4 style="font-family: var(--cp-font-sans); font-size: 0.82rem; font-weight: 600; color: var(--cp-text); margin-bottom: 18px; text-transform: uppercase; letter-spacing: 0.08em;">Categorias</h4>
                            <ul class="list-unstyled mb-0" style="display: flex; flex-direction: column; gap: 10px;">
                                <li><a href="{{ route('blog.index') }}?categoria=tecnologia" class="text-light" style="font-size: 0.9rem; color: var(--cp-text-secondary) !important; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#a5b4fc'" onmouseout="this.style.color='#94a3b8'">Tecnologia</a></li>
                                <li><a href="{{ route('blog.index') }}?categoria=dev" class="text-light" style="font-size: 0.9rem; color: var(--cp-text-secondary) !important; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#a5b4fc'" onmouseout="this.style.color='#94a3b8'">Desenvolvimento</a></li>
                                <li><a href="{{ route('blog.index') }}?categoria=linux" class="text-light" style="font-size: 0.9rem; color: var(--cp-text-secondary) !important; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#a5b4fc'" onmouseout="this.style.color='#94a3b8'">Linux</a></li>
                                <li><a href="{{ route('blog.index') }}?categoria=reflexoes" class="text-light" style="font-size: 0.9rem; color: var(--cp-text-secondary) !important; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#a5b4fc'" onmouseout="this.style.color='#94a3b8'">Reflexões</a></li>
                            </ul>
                        </div>

                        <!-- Links -->
                        <div class="col-lg-2 col-6">
                            <h4 style="font-family: var(--cp-font-sans); font-size: 0.82rem; font-weight: 600; color: var(--cp-text); margin-bottom: 18px; text-transform: uppercase; letter-spacing: 0.08em;">Links</h4>
                            <ul class="list-unstyled mb-0" style="display: flex; flex-direction: column; gap: 10px;">
                                <li><a href="{{ route('home') }}" class="text-light" style="font-size: 0.9rem; color: var(--cp-text-secondary) !important; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#a5b4fc'" onmouseout="this.style.color='#94a3b8'">Início</a></li>
                                <li><a href="{{ route('blog.index') }}" class="text-light" style="font-size: 0.9rem; color: var(--cp-text-secondary) !important; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#a5b4fc'" onmouseout="this.style.color='#94a3b8'">Todos os posts</a></li>
                            </ul>
                        </div>

                        <!-- Newsletter Mini CTA -->
                        <div class="col-lg-2 col-12 mt-4 mt-lg-0">
                            <div style="background: rgba(99,102,241,0.07); border: 1px solid rgba(99,102,241,0.12); border-radius: var(--cp-radius-md); padding: 20px;">
                                <p style="font-family: var(--cp-font-mono); font-size: 0.68rem; color: var(--cp-accent); font-weight: 600; letter-spacing: 0.08em; margin-bottom: 8px;">// NEWSLETTER</p>
                                <p style="font-size: 0.82rem; color: var(--cp-text-secondary); line-height: 1.55; margin-bottom: 12px;">Receba novos posts por email.</p>
                                <a href="{{ route('newsletter.status') }}" class="d-inline-flex align-items-center gap-2" style="font-family: var(--cp-font-mono); font-size: 0.78rem; color: var(--cp-accent); text-decoration: none; font-weight: 500;">
                                    Assinar <i class="bi-arrow-right" style="font-size: 0.7rem;"></i>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div id="copyrights" class="dark" style="border-top: 1px solid rgba(99,102,241,0.08);">
                <div class="container" style="padding: 18px 0;">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-md-6 text-white-50" style="font-size: 0.82rem;">
                            &copy; {{ date('Y') }} Samirhv. Todos os direitos reservados.
                        </div>
                        <div class="col-md-6 d-flex justify-content-md-end mt-3 mt-md-0 align-items-center gap-2">
                            <span style="font-family: var(--cp-font-mono); font-size: 0.7rem; color: var(--cp-text-muted);">feito com Laravel + Canvas</span>
                            <span style="color: rgba(99,102,241,0.25);">·</span>
                            <a href="{{ route('home') }}" class="text-white-50" style="font-size: 0.82rem; text-decoration: none;">Início</a>
                            <span style="color: rgba(255,255,255,0.15);">/</span>
                            <a href="{{ route('blog.index') }}" class="text-white-50" style="font-size: 0.82rem; text-decoration: none;">Blog</a>
                        </div>
                    </div>
                </div>
            </div>

        </footer>

    </div><!-- #wrapper end -->

    <script src="{{ asset('vendor/canvas/js/plugins.min.js') }}"></script>
    <script src="{{ asset('vendor/canvas/js/functions.bundle.js') }}"></script>

    @stack('scripts')

</body>
</html>
