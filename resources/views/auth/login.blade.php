<x-layouts.app :title="'Login - ' . config('app.name')">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">Yujin Foto Studio</h1>
                        <h2 class="text-2xl font-bold text-gray-900 mb-3">Masuk ke Akun Anda</h2>
                        <p class="text-gray-600">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700 transition-colors duration-300">
                                Daftar di sini
                            </a>
                        </p>
                        
                        <!-- Decorative line -->
                        <div class="mt-6 flex justify-center">
                            <div class="w-16 h-1 bg-gradient-to-r from-blue-400 to-purple-400 rounded-full"></div>
                        </div>
                    </div>

            <!-- Login Form -->
            <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                
                <div class="space-y-4">
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
                            autocomplete="current-password" 
                            required 
                            class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-md placeholder-gray-400 focus:outline-none focus:ring-purple-500 focus:border-purple-500 @error('password') border-red-500 @enderror transition duration-300 ease-in-out"
                            placeholder="Masukkan password"
                        >
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Remember me and Forgot password -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input 
                            id="remember" 
                            name="remember" 
                            type="checkbox" 
                            class="h-4 w-4 text-blue-600 focus:ring-purple-500 border-gray-300 rounded transition duration-300 ease-in-out"
                        >
                        <label for="remember" class="ml-2 block text-sm text-gray-900">
                            Ingat saya
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="#" class="font-medium text-blue-600 hover:text-blue-500">
                            Lupa password?
                        </a>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button 
                        type="submit" 
                        class="w-full inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-purple-600 text-white text-sm font-bold rounded-xl hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 shadow-md hover:shadow-lg"
                    >
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                        Masuk
                    </button>
                </div>

                <!-- Demo Accounts Info -->
                <div class="mt-6 p-4 bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg border border-blue-100">
                    <div class="flex items-center mb-3">
                        <svg class="w-4 h-4 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-sm font-semibold text-gray-900">Demo Akun untuk Testing:</h3>
                    </div>
                    <div class="text-xs text-gray-600 space-y-1">
                        <p><strong>Customer:</strong> customer@demo.com / password</p>
                        <p><strong>Admin:</strong> admin@demo.com / password</p>
                        <p><strong>Studio Staff:</strong> staff@demo.com / password</p>
                        <p><strong>Owner:</strong> owner@demo.com / password</p>
                    </div>
                </div>
            </form>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
