<x-guest-layout>

    <h1 class="auth-heading">Create account ✨</h1>
    <p class="auth-subheading">Fill in your details to get started for free</p>

    <form method="POST" action="{{ route('register') }}" id="register-form">
        @csrf

        {{-- Full Name --}}
        <div class="field-group">
            <label for="name">Full Name <span class="req">*</span></label>
            <input
                id="name"
                class="field-input"
                type="text"
                name="name"
                value="{{ old('name') }}"
                required autofocus
                autocomplete="name"
                placeholder="John Doe"
            />
            @error('name')
                <p class="field-error">
                    <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="field-group">
            <label for="email">Email Address <span class="req">*</span></label>
            <input
                id="email"
                class="field-input"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
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
                    autocomplete="new-password"
                    placeholder="Min. 8 characters"
                />
                <button type="button" class="pw-toggle" id="pw-toggle-reg" aria-label="Show/hide password">
                    <svg id="eye-reg" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

        {{-- Confirm Password --}}
        <div class="field-group">
            <label for="password_confirmation">Confirm Password <span class="req">*</span></label>
            <div class="pw-wrap">
                <input
                    id="password_confirmation"
                    class="field-input"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="Re-enter your password"
                />
                <button type="button" class="pw-toggle" id="pw-toggle-conf" aria-label="Show/hide confirm password">
                    <svg id="eye-conf" xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
            @error('password_confirmation')
                <p class="field-error">
                    <svg width="12" height="12" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Terms note --}}
        <p class="terms-note">
            By creating an account you agree to our
            <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
        </p>

        <button type="submit" class="btn-primary">Create Account</button>
    </form>

    <div class="auth-footer">
        Already have an account? <a href="{{ route('login') }}">Sign in instead</a>
    </div>

    <script>
        (function () {
            function makeToggle(inputId, toggleId, iconId) {
                const input  = document.getElementById(inputId);
                const toggle = document.getElementById(toggleId);
                const icon   = document.getElementById(iconId);
                if (!input || !toggle || !icon) return;
                const open   = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;
                const closed = `<line x1="1" y1="1" x2="23" y2="23"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 11 7 11 7a13.16 13.16 0 0 1-1.67 2.68M6.61 6.61A13.526 13.526 0 0 0 1 12s4 7 11 7a9.74 9.74 0 0 0 5.39-1.61"/>`;
                toggle.addEventListener('click', () => {
                    const hidden = input.type === 'password';
                    input.type = hidden ? 'text' : 'password';
                    icon.innerHTML = hidden ? closed : open;
                });
            }
            makeToggle('password',              'pw-toggle-reg',  'eye-reg');
            makeToggle('password_confirmation', 'pw-toggle-conf', 'eye-conf');
        })();
    </script>

</x-guest-layout>
