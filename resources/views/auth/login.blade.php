<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lensio CRM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            display: flex;
            background: #0f172a;
            overflow: hidden;
        }

        /* ── Left panel: full-bleed photo ── */
        .photo-panel {
            flex: 1;
            position: relative;
            overflow: hidden;
            display: none; /* hidden on mobile */
        }

        @media (min-width: 992px) {
            .photo-panel { display: block; }
        }

        .photo-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            transition: opacity 1.2s ease;
            opacity: 0;
        }

        .photo-bg.active {
            opacity: 1;
        }

        /* Dark gradient overlay so text is readable */
        .photo-panel::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(15, 23, 42, 0.55) 0%,
                rgba(15, 23, 42, 0.25) 50%,
                rgba(15, 23, 42, 0.65) 100%
            );
            z-index: 1;
        }

        /* Brand overlay on photo */
        .photo-brand {
            position: absolute;
            top: 2rem;
            left: 2rem;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .photo-brand i {
            font-size: 1.75rem;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .photo-brand span {
            font-size: 1.4rem;
            font-weight: 700;
            color: #f1f5f9;
            letter-spacing: -0.3px;
        }

        /* Tagline at bottom of photo */
        .photo-tagline {
            position: absolute;
            bottom: 5rem;
            left: 2.5rem;
            right: 2.5rem;
            z-index: 2;
        }

        .photo-tagline h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #f1f5f9;
            line-height: 1.3;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 12px rgba(0,0,0,0.4);
        }

        .photo-tagline p {
            color: rgba(241, 245, 249, 0.7);
            font-size: 0.95rem;
            margin: 0;
        }

        /* Photo credit */
        .photo-credit {
            position: absolute;
            bottom: 1.5rem;
            left: 2.5rem;
            z-index: 2;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .photo-credit a {
            font-size: 0.72rem;
            color: rgba(241, 245, 249, 0.5);
            text-decoration: none;
            transition: color 0.2s;
        }

        .photo-credit a:hover {
            color: rgba(241, 245, 249, 0.9);
        }

        .photo-credit i {
            font-size: 0.7rem;
            color: rgba(241, 245, 249, 0.4);
        }

        /* Dot indicators */
        .photo-dots {
            position: absolute;
            bottom: 1.6rem;
            right: 2rem;
            z-index: 2;
            display: flex;
            gap: 6px;
        }

        .photo-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: rgba(255,255,255,0.25);
            cursor: pointer;
            transition: all 0.3s;
        }

        .photo-dot.active {
            background: #6366f1;
            width: 18px;
            border-radius: 3px;
        }

        /* ── Right panel: login form ── */
        .login-panel {
            width: 100%;
            max-width: 480px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 2.5rem 3rem;
            background: #0f172a;
            position: relative;
            overflow-y: auto;
        }

        @media (max-width: 991.98px) {
            .login-panel {
                max-width: 100%;
                padding: 2rem 1.5rem;
            }
        }

        /* Subtle glow behind form on mobile */
        .login-panel::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.1) 0%, transparent 70%);
            top: -80px;
            right: -80px;
            pointer-events: none;
        }

        /* Mobile brand (only visible when photo panel is hidden) */
        .mobile-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2.5rem;
        }

        @media (min-width: 992px) {
            .mobile-brand { display: none; }
        }

        .mobile-brand i {
            font-size: 1.75rem;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .mobile-brand span {
            font-size: 1.4rem;
            font-weight: 700;
            color: #f1f5f9;
        }

        .login-heading {
            margin-bottom: 2rem;
        }

        .login-heading h1 {
            font-size: 1.625rem;
            font-weight: 700;
            color: #f1f5f9;
            margin: 0 0 0.35rem;
        }

        .login-heading p {
            color: #64748b;
            font-size: 0.875rem;
            margin: 0;
        }

        .form-label {
            font-weight: 500;
            color: #94a3b8;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 10px;
            padding: 0.75rem 1rem;
            border: 1px solid rgba(148, 163, 184, 0.12);
            background: #1e293b;
            color: #f1f5f9;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .form-control::placeholder {
            color: #475569;
        }

        .form-control:focus {
            background: #263348;
            color: #f1f5f9;
            border-color: rgba(99, 102, 241, 0.5);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
            outline: none;
        }

        .input-icon-wrap {
            position: relative;
        }

        .input-icon-wrap .bi {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #475569;
            font-size: 0.9rem;
            pointer-events: none;
        }

        .input-icon-wrap .form-control {
            padding-left: 2.5rem;
        }

        .form-check-input {
            background-color: #1e293b;
            border-color: rgba(148, 163, 184, 0.2);
            width: 1rem;
            height: 1rem;
        }

        .form-check-input:checked {
            background-color: #6366f1;
            border-color: #6366f1;
        }

        .form-check-label {
            color: #64748b;
            font-size: 0.875rem;
        }

        .btn-login {
            width: 100%;
            padding: 0.875rem;
            border-radius: 12px;
            font-weight: 600;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            border: none;
            color: white;
            transition: all 0.2s;
            font-size: 0.9rem;
            letter-spacing: 0.3px;
            position: relative;
            overflow: hidden;
        }

        .btn-login::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, transparent 100%);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.4);
            color: white;
        }

        .btn-login:hover::after {
            opacity: 1;
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.5rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(148, 163, 184, 0.1);
        }

        .divider span {
            font-size: 0.75rem;
            color: #475569;
            white-space: nowrap;
        }

        .alert-error {
            border-radius: 10px;
            background: rgba(244, 63, 94, 0.1);
            color: #fb7185;
            border: 1px solid rgba(244, 63, 94, 0.2);
            font-size: 0.875rem;
            padding: 0.75rem 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .alert-error i {
            flex-shrink: 0;
            margin-top: 1px;
        }

        .login-footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.75rem;
            color: #334155;
        }
    </style>
</head>

<body>

    <!-- ── Left: Photo Slideshow Panel ── -->
    <div class="photo-panel" id="photoPanel">

        <!-- Background images (JS will activate them) -->
        <div class="photo-bg" id="bg0"></div>
        <div class="photo-bg" id="bg1"></div>
        <div class="photo-bg" id="bg2"></div>
        <div class="photo-bg" id="bg3"></div>
        <div class="photo-bg" id="bg4"></div>

        <!-- Brand -->
        <div class="photo-brand">
            <i class="bi bi-camera-fill"></i>
            <span>Lensio</span>
        </div>

        <!-- Tagline -->
        <div class="photo-tagline">
            <h2>Capture every<br>moment beautifully.</h2>
            <p>Your complete event photography CRM.</p>
        </div>

        <!-- Photo credit -->
        <div class="photo-credit" id="photoCredit">
            <i class="bi bi-camera"></i>
            <a href="#" id="creditLink" target="_blank" rel="noopener noreferrer">Photo on Unsplash</a>
        </div>

        <!-- Dot indicators -->
        <div class="photo-dots" id="photoDots"></div>
    </div>

    <!-- ── Right: Login Form Panel ── -->
    <div class="login-panel">

        <!-- Mobile-only brand -->
        <div class="mobile-brand">
            <i class="bi bi-camera-fill"></i>
            <span>Lensio</span>
        </div>

        <div class="login-heading">
            <h1>Welcome back</h1>
            <p>Sign in to your Lensio account to continue.</p>
        </div>

        @if($errors->any())
            <div class="alert-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-envelope"></i>
                    <input type="email" class="form-control" id="email" name="email"
                        value="{{ old('email') }}" placeholder="you@example.com" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-icon-wrap">
                    <i class="bi bi-lock"></i>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="••••••••" required>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="form-check mb-0">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>
            </div>

            <button type="submit" class="btn btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
            </button>
        </form>

        <div class="login-footer">
            &copy; {{ date('Y') }} Lensio &mdash; Event Photography CRM
        </div>
    </div>

    <script>
        /**
         * Photography-themed Unsplash images with author credits.
         * Using source.unsplash.com for direct, license-compliant image delivery.
         * Each image links back to the photographer's Unsplash profile per Unsplash guidelines.
         */
        const photos = [
            {
                // Wedding ceremony — Foto di Nathan Dumlao
                url: 'https://images.unsplash.com/photo-1519741497674-611481863552?w=1600&q=80&fit=crop',
                author: 'Nathan Dumlao',
                profileUrl: 'https://unsplash.com/@nate_dumlao?utm_source=lensio_crm&utm_medium=referral'
            },
            {
                // Portrait photography — Foto di Chalo Garcia
                url: 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=1600&q=80&fit=crop',
                author: 'Chalo Garcia',
                profileUrl: 'https://unsplash.com/@chalogarcia?utm_source=lensio_crm&utm_medium=referral'
            },
            {
                // Event / concert lights — Foto di Aranxa Esteve
                url: 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=1600&q=80&fit=crop',
                author: 'Aranxa Esteve',
                profileUrl: 'https://unsplash.com/@aranxa_esteve?utm_source=lensio_crm&utm_medium=referral'
            },
            {
                // Camera gear — Foto di ShareGrid
                url: 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=1600&q=80&fit=crop',
                author: 'ShareGrid',
                profileUrl: 'https://unsplash.com/@sharegrid?utm_source=lensio_crm&utm_medium=referral'
            },
            {
                // Outdoor portrait — Foto di Allef Vinicius
                url: 'https://images.unsplash.com/photo-1531746020798-e6953c6e8e04?w=1600&q=80&fit=crop',
                author: 'Allef Vinicius',
                profileUrl: 'https://unsplash.com/@seteales?utm_source=lensio_crm&utm_medium=referral'
            }
        ];

        const bgs        = Array.from({ length: photos.length }, (_, i) => document.getElementById('bg' + i));
        const dotsWrap   = document.getElementById('photoDots');
        const creditLink = document.getElementById('creditLink');
        let current      = Math.floor(Math.random() * photos.length); // start random
        let timer;

        // Build dots
        photos.forEach((_, i) => {
            const dot = document.createElement('div');
            dot.className = 'photo-dot';
            dot.addEventListener('click', () => goTo(i));
            dotsWrap.appendChild(dot);
        });

        const dots = dotsWrap.querySelectorAll('.photo-dot');

        function preload(index) {
            const img = new Image();
            img.src = photos[index].url;
        }

        function goTo(index) {
            // Deactivate current
            bgs[current].classList.remove('active');
            dots[current].classList.remove('active');

            current = index;

            // Activate new
            bgs[current].style.backgroundImage = `url('${photos[current].url}')`;
            bgs[current].classList.add('active');
            dots[current].classList.add('active');

            // Update credit
            creditLink.textContent = 'Photo by ' + photos[current].author + ' on Unsplash';
            creditLink.href = photos[current].profileUrl;

            // Preload next
            preload((current + 1) % photos.length);
        }

        function next() {
            goTo((current + 1) % photos.length);
        }

        function startTimer() {
            clearInterval(timer);
            timer = setInterval(next, 6000);
        }

        // Init: preload first two, then start
        photos.forEach((p, i) => {
            bgs[i].style.backgroundImage = `url('${p.url}')`;
        });

        goTo(current);
        startTimer();

        // Pause on hover
        const panel = document.getElementById('photoPanel');
        panel.addEventListener('mouseenter', () => clearInterval(timer));
        panel.addEventListener('mouseleave', startTimer);
    </script>
</body>

</html>
