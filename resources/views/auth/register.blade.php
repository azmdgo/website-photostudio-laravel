<x-layouts.app :title="'Registrasi - ' . config('app.name')">
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-purple-50 relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0">
            <div class="absolute top-0 left-0 w-48 h-48 bg-blue-100 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-pulse"></div>
            <div class="absolute bottom-0 right-0 w-72 h-72 bg-purple-100 rounded-full mix-blend-multiply filter blur-xl opacity-40 animate-pulse"></div>
            <div class="absolute top-1/2 left-1/2 w-72 h-72 bg-pink-100 rounded-full mix-blend-multiply filter blur-xl opacity-40 animate-pulse"></div>
        </div>
        
        <div class="relative z-10 flex items-center justify-center min-h-screen py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full">
                <!-- Main Card -->
                <div class="bg-white rounded-2xl shadow-2xl p-8 border border-gray-100">
                    <!-- Header -->
                    <div class="text-center mb-8">
                        <!-- Logo/Icon -->
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full mb-6 shadow-lg">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                        
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">Yujin Foto Studio</h1>
                        <h2 class="text-2xl font-bold text-gray-900 mb-3">Buat Akun Baru</h2>
                        <p class="text-gray-600">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors duration-300">
                                Masuk di sini
                            </a>
                        </p>
                        
                        <!-- Decorative line -->
                        <div class="mt-6 flex justify-center">
                            <div class="w-16 h-1 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full"></div>
                        </div>
                    </div>

            <!-- Registration Form -->
            <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                
                <div class="space-y-4">
                    <!-- Nama Lengkap -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">
                            Nama Lengkap
                        </label>
                        <input 
                            id="name" 
                            name="name" 
                            type="text" 
                            autocomplete="name" 
                            required 
                            value="{{ old('name') }}"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-md placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 @error('name') border-red-500 @enderror transition duration-300 ease-in-out"
                            placeholder="Masukkan nama lengkap Anda"
                        >
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">
                            Alamat Email
                        </label>
                        <input 
                            id="email" 
                            name="email" 
                            type="email" 
                            autocomplete="email" 
                            required 
                            value="{{ old('email') }}"
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-md placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 @error('email') border-red-500 @enderror transition duration-300 ease-in-out"
                            placeholder="contoh@email.com"
                        >
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Password
                        </label>
                        <input 
                            id="password" 
                            name="password" 
                            type="password" 
                            autocomplete="new-password" 
                            required 
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-md placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 @error('password') border-red-500 @enderror transition duration-300 ease-in-out"
                            placeholder="Masukkan password"
                        >
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            Konfirmasi Password
                        </label>
                        <input 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            type="password" 
                            autocomplete="new-password" 
                            required 
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-md placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 transition duration-300 ease-in-out"
                            placeholder="Ulangi password"
                        >
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button 
                        type="submit" 
                        class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-sm font-bold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                        Daftar Sekarang
                    </button>
                </div>

                <!-- Additional Info -->
                <div class="mt-6 p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg border border-blue-100">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs text-gray-600 leading-relaxed">
                            Dengan mendaftar, Anda menyetujui 
                            <a href="#" class="text-blue-600 hover:text-blue-700 font-medium transition-colors duration-300">Syarat & Ketentuan</a> 
                            dan 
                            <a href="#" class="text-blue-600 hover:text-blue-700 font-medium transition-colors duration-300">Kebijakan Privasi</a> 
                            kami.
                        </p>
                    </div>
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
