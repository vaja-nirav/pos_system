<x-guest-layout>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="session-status">{{ session('status') }}</div>
    @endif

    <h1 class="auth-heading">Welcome back</h1>
    <p class="auth-subheading">Sign in to your account to continue</p>

    <form method="POST" action="{{ route('login') }}" id="login-form">
        @csrf

        {{-- Email --}}
        <div class="field-group">
            <label for="email">Email Address <span class="req">*</span></label>
            <input
                id="email"
                class="field-input"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required autofocus
                autocomplete="username"
                placeholder="you@example.com"
            />
            @error('email')
                <p class="field-error">
                    <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="field-group">
            <label for="password">Password <span class="req">*</span></label>
            <div class="pw-wrap">
                <input
                    id="password"
                    class="field-input"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
                <button type="button" class="pw-toggle" id="pw-toggle-login" aria-label="Show/hide password">
                    <svg id="eye-login" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="field-error">
                    <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Remember + Forgot --}}
        <div class="meta-row">
            <label class="check-label" for="remember_me">
                <input id="remember_me" type="checkbox" name="remember">
                Remember me
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="btn-primary">Sign In</button>
    </form>

    <div class="auth-footer">
        Don't have an account? <a href="{{ route('register') }}">Create one now</a>
    </div>

    <script>
        (function () {
            const input  = document.getElementById('password');
            const toggle = document.getElementById('pw-toggle-login');
            const icon   = document.getElementById('eye-login');
            const open   = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
            const closed = `<line x1="1" y1="1" x2="23" y2="23"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 11 7 11 7a13.16 13.16 0 0 1-1.67 2.68M6.61 6.61A13.526 13.526 0 0 0 1 12s4 7 11 7a9.74 9.74 0 0 0 5.39-1.61"/>`;
            toggle.addEventListener('click', () => {
                const hidden = input.type === 'password';
                input.type = hidden ? 'text' : 'password';
                icon.innerHTML = hidden ? closed : open;
            });
        })();
    </script>

</x-guest-layout>
