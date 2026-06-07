<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirme sua inscrição</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background:#0d0d14; margin:0; padding:32px;">
    <div style="max-width:520px; margin:0 auto; background:#111827; border:1px solid rgba(99,102,241,0.2); border-radius:12px; padding:36px;">
        <p style="font-family:'Courier New', monospace; font-size:0.7rem; letter-spacing:0.15em; color:#6366f1; margin:0 0 20px;">// NEWSLETTER</p>

        <h1 style="color:#f1f5f9; font-size:1.35rem; margin:0 0 16px;">Olá, {{ $name }} 👋</h1>

        <p style="color:#94a3b8; line-height:1.7; font-size:0.95rem; margin:0 0 28px;">
            Falta só um passo pra você receber as novidades do blog. Clique no botão abaixo pra confirmar sua inscrição.
        </p>

        <p style="text-align:center; margin:0 0 28px;">
            <a href="{{ $confirmUrl }}"
               style="display:inline-block; background:#6366f1; color:#ffffff; text-decoration:none; padding:14px 32px; border-radius:8px; font-weight:600; font-size:0.95rem;">
                Confirmar inscrição
            </a>
        </p>

        <p style="color:#64748b; font-size:0.82rem; line-height:1.6; margin:0 0 8px;">
            Este link expira em {{ $expiresAt->format('d/m/Y H:i') }} (2 dias).
        </p>
        <p style="color:#64748b; font-size:0.82rem; line-height:1.6; margin:0;">
            Se você não fez essa inscrição, é só ignorar este e-mail.
        </p>
    </div>
</body>
</html>
