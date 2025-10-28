<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50/30 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        
        <!-- Cabecera de la Página -->
        <header class="mb-8">
            <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100/50">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    <div class="space-y-4">
                        <div class="flex items-center gap-4">
                            <div class="p-3 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-md">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z" />
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-4xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                                    Manual de Usuario
                                </h1>
                                <p class="text-xl text-gray-600 mt-2">Gestión de Empresas - E360 Pro</p>
                            </div>
                        </div>
                        <p class="text-gray-600 text-lg max-w-3xl leading-relaxed">
                            Guía completa para administrar empresas en el sistema E360 Pro. Aprende a crear, editar, buscar y gestionar todas las empresas registradas.
                        </p>
                    </div>
                    
                    <!-- Botón Volver -->
                    <a href="<?php echo e(route('mostrar-empresa')); ?>" wire:navigate
                       class="group inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold text-lg rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                        <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Volver a Empresas
                    </a>
                </div>
            </div>
        </header>

        <!-- Contenido del Manual -->
        <div class="space-y-8">
            
            <!-- Sección 1: Introducción -->
            <section class="bg-white rounded-2xl shadow-lg border border-gray-100/50 p-8">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold text-lg">1</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Introducción</h2>
                </div>
                <div class="prose prose-lg max-w-none text-gray-600">
                    <p class="text-lg leading-relaxed">
                        El módulo de <strong class="text-blue-600">Gestión de Empresas</strong> en <strong class="text-indigo-600">E360 Pro</strong> es el centro de administración para todas las empresas registradas en el sistema. Desde esta plataforma puedes realizar operaciones completas de gestión empresarial incluyendo creación, edición, búsqueda avanzada y organización mediante filtros.
                    </p>
                    <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                        <p class="text-blue-800 flex items-start">
                            <span class="text-xl mr-3">🎯</span>
                            <span><strong>Objetivo Principal:</strong> Centralizar y simplificar la administración de todas las empresas asociadas a tu organización, proporcionando herramientas poderosas para mantener la información actualizada y accesible.</span>
                        </p>
                    </div>
                </div>
            </section>

            <!-- Sección 2: Funcionalidades Principales -->
            <section class="bg-white rounded-2xl shadow-lg border border-gray-100/50 p-8">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold text-lg">2</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Funcionalidades Principales</h2>
                </div>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Tarjeta 1 -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 p-6 rounded-xl border border-green-200">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">Crear Empresa</h3>
                        </div>
                        <p class="text-gray-600 leading-relaxed">
                            Registra nuevas empresas con información completa incluyendo datos fiscales, ubicación, sector empresarial y datos de contacto.
                        </p>
                    </div>

                    <!-- Tarjeta 2 -->
                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 p-6 rounded-xl border border-blue-200">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">Búsqueda Avanzada</h3>
                        </div>
                        <p class="text-gray-600 leading-relaxed">
                            Encuentra empresas rápidamente usando múltiples criterios: ID, nombre comercial, razón social, RFC o ubicación.
                        </p>
                    </div>

                    <!-- Tarjeta 3 -->
                    <div class="bg-gradient-to-br from-purple-50 to-violet-50 p-6 rounded-xl border border-purple-200">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">Edición Completa</h3>
                        </div>
                        <p class="text-gray-600 leading-relaxed">
                            Modifica toda la información de las empresas existentes, actualizando datos según sea necesario.
                        </p>
                    </div>

                    <!-- Tarjeta 4 -->
                    <div class="bg-gradient-to-br from-orange-50 to-amber-50 p-6 rounded-xl border border-orange-200">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800">Gestión de Estados</h3>
                        </div>
                        <p class="text-gray-600 leading-relaxed">
                            Controla el estado de las empresas (Activo, Inactivo, En Proceso, Suspendido) y gestiona la papelera de eliminados.
                        </p>
                    </div>
                </div>
            </section>

            <!-- Sección 3: Búsqueda y Filtros -->
            <section class="bg-white rounded-2xl shadow-lg border border-gray-100/50 p-8">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-12 h-12 bg-amber-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold text-lg">3</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Búsqueda y Filtros</h2>
                </div>

                <div class="space-y-6">
                    <div class="bg-amber-50 rounded-xl p-6 border border-amber-200">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Campo de Búsqueda</h3>
                        <p class="text-gray-600 mb-4">Puedes buscar empresas utilizando los siguientes criterios:</p>
                        <ul class="grid md:grid-cols-2 gap-3 text-gray-600">
                            <li class="flex items-center">
                                <span class="w-2 h-2 bg-amber-500 rounded-full mr-3"></span>
                                <strong>ID</strong> de la empresa
                            </li>
                            <li class="flex items-center">
                                <span class="w-2 h-2 bg-amber-500 rounded-full mr-3"></span>
                                <strong>Nombre comercial</strong>
                            </li>
                            <li class="flex items-center">
                                <span class="w-2 h-2 bg-amber-500 rounded-full mr-3"></span>
                                <strong>Razón social</strong>
                            </li>
                            <li class="flex items-center">
                                <span class="w-2 h-2 bg-amber-500 rounded-full mr-3"></span>
                                <strong>RFC</strong>
                            </li>
                        </ul>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-blue-50 rounded-xl p-6 border border-blue-200">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Filtro por Sector</h4>
                            <p class="text-gray-600">Filtra empresas según su sector empresarial para encontrar rápidamente empresas del mismo rubro.</p>
                        </div>
                        <div class="bg-green-50 rounded-xl p-6 border border-green-200">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Filtro por Estado</h4>
                            <p class="text-gray-600">Organiza las empresas según su ubicación geográfica por estado o municipio.</p>
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200">
                        <p class="text-green-800 flex items-start">
                            <span class="text-2xl mr-3">💡</span>
                            <span><strong>Consejo Práctico:</strong> Usa términos específicos en la búsqueda para obtener resultados más precisos. Combina múltiples filtros para refinar tu búsqueda.</span>
                        </p>
                    </div>
                </div>
            </section>

            <!-- Sección 4: Acciones Rápidas -->
            <section class="bg-white rounded-2xl shadow-lg border border-gray-100/50 p-8">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white font-bold text-lg">4</span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Acciones Rápidas</h2>
                </div>

                <div class="grid lg:grid-cols-3 gap-6">
                    <div class="text-center p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Nueva Empresa</h3>
                        <p class="text-gray-600 text-sm">Registra una nueva empresa en el sistema</p>
                    </div>

                    <div class="text-center p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                        <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Papelera</h3>
                        <p class="text-gray-600 text-sm">Gestiona empresas eliminadas temporalmente</p>
                    </div>

                    <div class="text-center p-6 bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-shadow duration-300">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Exportar Datos</h3>
                        <p class="text-gray-600 text-sm">Descarga información en varios formatos</p>
                    </div>
                </div>
            </section>

            <!-- Pie de Página -->
            <footer class="text-center py-8">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100/50 p-6">
                    <p class="text-gray-600">
                        <strong>E360 Pro</strong> • Manual de Usuario • Gestión de Empresas • 
                        <span class="text-blue-600"><?php echo e(now()->format('d/m/Y')); ?></span>
                    </p>
                    <p class="text-gray-500 text-sm mt-2">
                        Para soporte técnico adicional, contacta al administrador del sistema.
                    </p>
                </div>
            </footer>
        </div>
    </div>
</div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/empresa/manual-usuario-emp-modal.blade.php ENDPATH**/ ?>