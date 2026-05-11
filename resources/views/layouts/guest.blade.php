<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'POS System') }}</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            /* ===== RESET ===== */
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

            /* ===== PAGE BACKGROUND ===== */
            body {
                font-family: 'Inter', sans-serif;
                min-height: 100vh;
                background: #f0f4ff;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem 1rem;
                position: relative;
                overflow-x: hidden;
            }

            /* Soft decorative circles in background */
            body::before {
                content: '';
                position: fixed;
                width: 500px; height: 500px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(99,102,241,0.12) 0%, transparent 70%);
                top: -150px; left: -150px;
                pointer-events: none;
            }
            body::after {
                content: '';
                position: fixed;
                width: 400px; height: 400px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(139,92,246,0.10) 0%, transparent 70%);
                bottom: -100px; right: -100px;
                pointer-events: none;
            }

            /* ===== AUTH CARD ===== */
            .auth-card {
                background: #ffffff;
                border-radius: 20px;
                width: 100%;
                max-width: 440px;
                padding: 2.5rem 2.25rem 2rem;
                box-shadow:
                    0 1px 3px rgba(0,0,0,0.04),
                    0 8px 32px rgba(99,102,241,0.10),
                    0 24px 64px rgba(0,0,0,0.06);
                position: relative;
                z-index: 1;
            }

            /* Accent top border on card */
            .auth-card::before {
                content: '';
                position: absolute;
                top: 0; left: 0; right: 0;
                height: 3px;
                border-radius: 20px 20px 0 0;
                background: linear-gradient(90deg, #6366f1, #8b5cf6, #06b6d4);
            }

            /* ===== BRAND LOGO AREA ===== */
            .auth-logo-wrap {
                display: flex;
                justify-content: center;
                margin-bottom: 1.5rem;
            }

            .auth-logo-box {
                width: 52px; height: 52px;
                background: linear-gradient(135deg, #6366f1, #8b5cf6);
                border-radius: 14px;
                display: flex; align-items: center; justify-content: center;
                box-shadow: 0 4px 16px rgba(99,102,241,0.35);
            }
            .auth-logo-box svg { width: 28px; height: 28px; fill: #fff; }

            /* ===== HEADINGS ===== */
            .auth-heading {
                font-size: 1.55rem;
                font-weight: 800;
                color: #1e1b4b;
                text-align: center;
                margin-bottom: 0.3rem;
            }

            .auth-subheading {
                font-size: 0.85rem;
                color: #94a3b8;
                text-align: center;
                margin-bottom: 1.75rem;
            }

            /* ===== FORM FIELDS ===== */
            .field-group {
                margin-bottom: 1.1rem;
            }

            .field-group label {
                display: block;
                font-size: 0.8rem;
                font-weight: 600;
                color: #475569;
                margin-bottom: 0.4rem;
                letter-spacing: 0.01em;
            }

            .field-group label .req { color: #ef4444; margin-left: 2px; }

            .field-input {
                width: 100%;
                background: #f8fafc;
                border: 1.5px solid #e2e8f0;
                border-radius: 10px;
                padding: 0.72rem 1rem;
                font-size: 0.9rem;
                color: #1e293b;
                outline: none;
                transition: border-color 0.22s, box-shadow 0.22s, background 0.22s;
                font-family: 'Inter', sans-serif;
            }

            .field-input::placeholder { color: #cbd5e1; }

            .field-input:focus {
                border-color: #6366f1;
                background: #fafbff;
                box-shadow: 0 0 0 3.5px rgba(99,102,241,0.14);
            }

            /* Password wrapper */
            .pw-wrap { position: relative; }
            .pw-wrap .field-input { padding-right: 2.8rem; }

            .pw-toggle {
                position: absolute;
                right: 0.85rem;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                cursor: pointer;
                color: #94a3b8;
                display: flex;
                align-items: center;
                transition: color 0.2s;
                padding: 0;
                line-height: 1;
            }
            .pw-toggle:hover { color: #6366f1; }

            /* ===== INLINE ERRORS ===== */
            .field-error {
                font-size: 0.75rem;
                color: #ef4444;
                margin-top: 0.35rem;
                display: flex;
                align-items: center;
                gap: 0.3rem;
            }

            /* ===== META ROW (remember + forgot) ===== */
            .meta-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 1.4rem;
                flex-wrap: wrap;
                gap: 0.5rem;
            }

            .check-label {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                font-size: 0.82rem;
                color: #64748b;
                cursor: pointer;
                user-select: none;
            }
            .check-label input[type="checkbox"] {
                width: 15px; height: 15px;
                accent-color: #6366f1;
                cursor: pointer;
            }

            .forgot-link {
                font-size: 0.82rem;
                color: #6366f1;
                font-weight: 500;
                text-decoration: none;
                transition: color 0.2s;
            }
            .forgot-link:hover { color: #4f46e5; }

            /* ===== PRIMARY BUTTON ===== */
            .btn-primary {
                width: 100%;
                padding: 0.82rem 1rem;
                background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
                color: #fff;
                font-size: 0.93rem;
                font-weight: 600;
                border: none;
                border-radius: 10px;
                cursor: pointer;
                transition: transform 0.2s, box-shadow 0.2s;
                font-family: 'Inter', sans-serif;
                letter-spacing: 0.015em;
                margin-top: 0.25rem;
            }
            .btn-primary:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 24px rgba(99,102,241,0.38);
            }
            .btn-primary:active { transform: translateY(0); }

            /* ===== FOOTER LINK ===== */
            .auth-footer {
                text-align: center;
                font-size: 0.84rem;
                color: #94a3b8;
                margin-top: 1.4rem;
            }
            .auth-footer a {
                color: #6366f1;
                font-weight: 600;
                text-decoration: none;
                transition: color 0.2s;
            }
            .auth-footer a:hover { color: #4f46e5; }

            /* ===== SESSION STATUS ===== */
            .session-status {
                background: #f0fdf4;
                border: 1px solid #bbf7d0;
                border-radius: 8px;
                padding: 0.6rem 0.9rem;
                font-size: 0.82rem;
                color: #15803d;
                margin-bottom: 1.2rem;
            }

            /* ===== TERMS NOTE ===== */
            .terms-note {
                font-size: 0.74rem;
                color: #94a3b8;
                margin-bottom: 1.1rem;
                line-height: 1.6;
            }
            .terms-note a {
                color: #6366f1;
                font-weight: 500;
                text-decoration: none;
            }
            .terms-note a:hover { text-decoration: underline; }
        </style>
    </head>
    <body>
        <div class="auth-card">

            {{ $slot }}
        </div>
    </body>
</html>
