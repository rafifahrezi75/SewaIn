<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SewaIN - Log In</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            200: '#99f6e4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="bg-[#14b8a6]/10 font-sans text-gray-800 antialiased overflow-hidden">

    <!-- Full Screen Solid Background -->
    <div class="min-h-screen bg-brand-600 flex items-center justify-center p-4 sm:p-8 relative">

        <!-- Login Card Container -->
        <div class="relative z-10 w-full max-w-4xl bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col md:flex-row min-h-[550px] md:min-h-[500px]">
            
            <!-- Left Image Section (Hidden on Mobile) -->
            <div class="w-full md:w-1/2 relative hidden md:block bg-brand-500">
                <!-- Image -> Warehouse (Moved from background) -->
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80');"></div>
                <!-- Teal Overlay -->
                <div class="absolute inset-0 bg-brand-500 opacity-30"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-brand-700 opacity-80 to-transparent"></div>
            </div>

            <!-- Right Form Section -->
            <div class="w-full md:w-1/2 bg-white relative flex flex-col justify-center px-8 py-10 sm:px-14 items-center xl:items-end">
                
                <!-- SVG S-Curve Border (Creates the wave effect overlapping the image) -->
                <!-- It's positioned precisely on the left edge of this column and "spills" over into the left image area -->
                <svg class="absolute top-0 bottom-0 left-0 w-24 h-full hidden md:block" style="transform: translateX(-99%); margin-left: 1px;" preserveAspectRatio="none" viewBox="0 0 100 100" fill="#ffffff">
                    <path d="M100 0 L0 0 C50 0, 50 100, 100 100 Z" />
                </svg>

                <div class="w-full max-w-xs relative z-10 text-right">
                    
                    <h2 class="text-[32px] font-normal text-gray-700 mb-1 leading-tight tracking-wide">Welcome</h2>
                    <p class="text-gray-400 text-[13px] mb-8 font-light">Log in to your account to continue</p>
                    
                    <form action="#" class="space-y-4">
                        
                        <!-- Email Input -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <i class='bx bxs-user text-gray-400 text-lg'></i>
                            </div>
                            <input type="email" class="w-full pl-11 pr-4 py-2.5 rounded-lg border border-gray-200 text-xs sm:text-sm focus:outline-none focus:border-brand-400 focus:ring-1 focus:ring-brand-400 transition-colors placeholder-gray-300 text-gray-600" placeholder="awesome@user.com" value="admin@sewain.co.id">
                        </div>

                        <!-- Password Input -->
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                                <i class='bx bx-lock-alt text-gray-400 text-lg'></i>
                            </div>
                            <!-- 'font-mono' and 'tracking-widest' gives the visual dotted lock look nicely -->
                            <input type="password" class="w-full pl-11 pr-4 py-2.5 rounded-lg border border-gray-200 text-xs sm:text-sm focus:outline-none focus:border-brand-400 focus:ring-1 focus:ring-brand-400 transition-colors placeholder-gray-300 text-gray-600 tracking-[0.2em] font-mono" placeholder="••••••••••••" value="password123">
                        </div>

                        <div class="flex justify-end w-full pb-2">
                            <a href="#" class="text-[11px] text-gray-300 hover:text-brand-400 transition-colors underline underline-offset-2">Forgot your password?</a>
                        </div>
                        
                        <div class="flex justify-end pt-2">
                            <!-- Direct to Dashboard on click! -->
                            <button type="button" onclick="window.location.href='{{ url('admin/dashboard') }}'" class="w-32 py-2.5 rounded-lg bg-brand-400 hover:bg-brand-500 text-white font-medium text-sm transition-all focus:outline-none shadow-[0_4px_14px_0_rgba(45,212,191,0.39)] hover:shadow-[0_6px_20px_rgba(45,212,191,0.23)]">
                                Log In
                            </button>
                        </div>
                        
                        <div class="text-right mt-8 pt-4">
                            <p class="text-[12px] text-gray-400 tracking-wide font-light">Don't have an account? <a href="#" class="text-gray-300 hover:text-gray-400 underline underline-offset-2 font-normal">Sign up!</a></p>
                        </div>
                    </form>

                    <!-- Social Media Links -->
                    <div class="flex items-center justify-end gap-4 mt-6">
                        <a href="#" class="w-8 h-8 flex items-center justify-center text-gray-300 hover:text-brand-500 transition-colors text-xl">
                            <i class='bx bxl-facebook-square'></i>
                        </a>
                        <a href="#" class="w-8 h-8 flex items-center justify-center text-gray-300 hover:text-brand-500 transition-colors text-xl">
                            <i class='bx bxl-twitter'></i>
                        </a>
                        <a href="#" class="w-8 h-8 flex items-center justify-center text-gray-300 hover:text-brand-500 transition-colors text-xl">
                            <i class='bx bxl-linkedin-square'></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</body>
</html>
