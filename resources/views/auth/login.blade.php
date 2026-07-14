<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk - {{ config('app.name', 'Angop Library') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-gray-50 to-teal-50 min-h-screen flex items-center justify-center p-6">
    <main x-data="{
        loading: false,
        emailError: @js($errors->first('email')),
        passwordError: @js($errors->first('password')),
        showPassword: false,
        validate() {
            this.emailError = '';
            this.passwordError = '';

            if (!this.$refs.email.value) {
                this.emailError = 'Email wajib diisi.';
                return false;
            }

            if (!this.$refs.email.validity.valid) {
                this.emailError = 'Format email tidak valid.';
                return false;
            }

            if (!this.$refs.password.value) {
                this.passwordError = 'Kata sandi wajib diisi.';
                return false;
            }

            this.loading = true;
            return true;
        }
    }" class="w-full max-w-[400px] bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="text-center mb-8 flex flex-col items-center">
            <div class="w-16 h-16 bg-teal-100/20 rounded-full flex items-center justify-center mb-2">
                <span class="material-symbols-outlined text-teal-600 text-4xl">local_library</span>
            </div>
            <h1 class="text-2xl font-bold text-teal-600 mb-1">Angop Library</h1>
            <p class="text-base text-gray-600 font-medium">Sistem Informasi Perpustakaan</p>
            <p class="text-sm text-slate-600 mt-2">Silakan masuk ke akun Anda</p>
        </div>

        <form class="space-y-4" method="POST" action="{{ route('login') }}" x-on:submit="if (!validate()) $event.preventDefault()">
            @csrf

            <div class="w-full max-w-xs mx-auto">
                <label class="text-sm font-medium text-gray-900 mb-1 block" for="email">Email</label>
                <label class="input input-bordered flex items-center gap-2 bg-white focus-within:ring-2 focus-within:ring-teal-500 focus-within:border-teal-500 px-3 outline-none transition-all duration-150" :class="emailError ? 'border-red-500' : 'border-gray-300'">
                    <svg class="size-5 shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    <input x-ref="email" id="email" name="email" type="email" class="grow outline-none" placeholder="nama@email.com" value="{{ old('email') }}" required>
                </label>
                <p x-show="emailError" x-cloak x-text="emailError" class="mt-1 text-xs text-red-600"></p>
            </div>

            <div class="w-full max-w-xs mx-auto">
                <label class="text-sm font-medium text-gray-900 mb-1 block" for="password">Kata Sandi</label>
                <label class="input input-bordered flex items-center gap-2 bg-white focus-within:ring-2 focus-within:ring-teal-500 focus-within:border-teal-500 px-3 outline-none transition-all duration-150" :class="passwordError ? 'border-red-500' : 'border-gray-300'">
                    <svg class="size-5 shrink-0 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1s3.1 1.39 3.1 3.1v2z"/></svg>
                    <input x-ref="password" id="password" name="password" :type="showPassword ? 'text' : 'password'" class="grow outline-none" placeholder="••••••••" required>
                    <button type="button" @click="showPassword = !showPassword" class="shrink-0 text-gray-400 hover:text-gray-600 transition-colors" tabindex="-1">
                        <svg x-show="!showPassword" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg x-show="showPassword" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/></svg>
                    </button>
                </label>
                <p x-show="passwordError" x-cloak x-text="passwordError" class="mt-1 text-xs text-red-600"></p>
                <p class="mt-1 text-xs text-gray-500">Belum punya akun? Kunjungi loket atau <a href="https://wa.me/{{ config('app.whatsapp_number') }}" target="_blank" rel="noopener noreferrer" class="text-teal-600 hover:text-teal-700 underline">hubungi petugas</a></p>
            </div>

            <button class="btn w-full bg-teal-600 hover:bg-teal-700 text-white border-0 rounded-lg font-medium mt-4 shadow-sm" type="submit" :disabled="loading">
                <span x-show="loading" class="loading loading-spinner loading-sm"></span>
                Masuk
            </button>

            <div class="mt-6 p-3 bg-amber-50 border border-amber-200 rounded-lg text-xs text-amber-800">
                <p>Untuk demo cepat, gunakan akun berikut:</p>
                <ul class="list-disc list-inside mt-1 space-y-0.5">
                    <li>Admin: <strong>admin@gmail.com</strong> / <strong>admin1234</strong></li>
                    <li>Anggota: <strong>imam@gmail.com</strong> / <strong>imam1234</strong></li>
                </ul>
            </div>
        </form>
    </main>
</body>
</html>
