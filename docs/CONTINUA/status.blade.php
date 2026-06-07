@extends('layouts.app')

@section('title', 'Inscrição na newsletter')
@section('description', 'Confirmação de inscrição na newsletter do blog.')

@section('content')
    <section class="dark" style="background-color:#0d0d14; padding:160px 0 120px; min-height:60vh;">
        <div class="container" style="max-width:560px; text-align:center; position:relative; z-index:1;">
            @php
                $info = match ($result) {
                    'confirmed' => [
                        'Inscrição confirmada! 🎉',
                        'Pronto, você está na lista. Em breve as novidades chegam no seu e-mail.',
                    ],
                    'expired' => [
                        'Este link expirou',
                        'O link de confirmação vale por 2 dias. Faça a inscrição de novo para receber um novo link.',
                    ],
                    default => [
                        'Link inválido',
                        'Não encontramos essa confirmação. Tente se inscrever novamente.',
                    ],
                };
            @endphp

            <span class="cp-eyebrow">// NEWSLETTER</span>
            <h1 style="font-family:'Inter', sans-serif; font-size:clamp(1.75rem, 4vw, 2.75rem); font-weight:800; color:#f1f5f9; letter-spacing:-0.03em; line-height:1.15; margin:0.5rem 0 1rem;">
                {{ $info[0] }}
            </h1>
            <p style="font-family:'Inter', sans-serif; font-size:1.05rem; color:#94a3b8; line-height:1.75; margin-bottom:2.5rem;">
                {{ $info[1] }}
            </p>

            <a href="{{ route('home') }}" class="button button-rounded button-large"
               style="background:#6366f1; border-color:#6366f1; color:#fff; font-family:'Inter', sans-serif; font-weight:600;">
                Voltar ao início
            </a>
        </div>
    </section>
@endsection
