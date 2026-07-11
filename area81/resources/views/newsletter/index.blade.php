@extends('layouts.app')

@section('title', 'Newsletter')
@section('description', 'Assine a newsletter do blog e receba os novos posts por e-mail.')

@section('content')
    <section class="dark" style="background-color:#0d0d14; padding:160px 0 120px; min-height:60vh;">
        <div class="container" style="max-width:560px; position:relative; z-index:1; display:flex; flex-direction:column; align-items:center; text-align:center;">
            <span class="cp-eyebrow">// NEWSLETTER</span>
            <h1 style="font-family:'Inter', sans-serif; font-size:clamp(1.75rem, 4vw, 2.75rem); font-weight:800; color:#f1f5f9; letter-spacing:-0.03em; line-height:1.15; margin:0.5rem 0 1rem;">
                Receba os novos posts por e-mail
            </h1>
            <p style="font-family:'Inter', sans-serif; font-size:1.05rem; color:#94a3b8; line-height:1.75; margin-bottom:2.5rem;">
                Sem spam. Só as novidades do blog, quando saem.
            </p>

            @include('partials.newsletter_form')
        </div>
    </section>
@endsection
