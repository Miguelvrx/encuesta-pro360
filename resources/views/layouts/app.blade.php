<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
    <style>
        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .rotating-border {
            background: conic-gradient(from 0deg,
                    #3b82f6,
                    #06b6d4,
                    #10b981,
                    #f59e0b,
                    #ef4444,
                    #8b5cf6,
                    #3b82f6);
            animation: rotate 3s linear infinite;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('menu-navegacion')
        <livewire:headernavegacion />

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main class="w-full md:w-[calc(100%-256px)] md:ml-64 transition-all main">
            <div class="pt-0">
                <main class="">
                    {{ $slot }}
                </main>
            </div>
        </main>
    </div>

    @stack('modals')

    @livewireScripts

    <!-- jQuery (requerido para Select2) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.2/color-thief.umd.js"></script>

    <!-- jQuery (requerido por Toastr) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Script para manejar notificaciones Toastr -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuración de Toastr
            toastr.options = {
                "progressBar": true,
                "positionClass": "toast-top-right",
                "closeButton": true,
                "timeOut": 4000,
                "extendedTimeOut": 4000,
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            // Escuchar eventos de Livewire para mostrar notificaciones
            Livewire.on('toastr-success', (event) => {
                toastr.success(event.message);
            });

            Livewire.on('toastr-error', (event) => {
                toastr.error(event.message);
            });

            Livewire.on('toastr-warning', (event) => {
                toastr.warning(event.message);
            });
        });
    </script>

    @stack('scripts')
    <livewire:encuesta.departamento.manual-usuario-dep-modal />
</body>

</html>