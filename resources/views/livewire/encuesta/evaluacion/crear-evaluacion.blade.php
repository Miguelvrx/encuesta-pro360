 <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-white py-8 px-4 sm:px-6 lg:px-8">
        <form class="space-y-8 max-w-6xl mx-auto">

            <!-- Bloque para mostrar mensajes de sesión -->
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" role="alert" style="display: none;">
                <p class="font-bold">¡Éxito!</p>
                <p id="success-message"></p>
            </div>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6" role="alert" style="display: none;">
                <p class="font-bold">¡Error!</p>
                <p id="error-message"></p>
            </div>

            <!-- Encabezado de Pasos -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <div class="flex justify-around items-center text-center">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-blue-600 text-white font-bold text-lg">1</div>
                        <span class="text-sm font-semibold text-blue-600 mt-2">INFORMACIÓN BÁSICA</span>
                    </div>
                    <div class="flex flex-col items-center opacity-50">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-300 text-gray-700 font-bold text-lg">2</div>
                        <span class="text-sm font-medium text-gray-500 mt-2">CONFIGURACIÓN</span>
                    </div>
                    <div class="flex flex-col items-center opacity-50">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-300 text-gray-700 font-bold text-lg">3</div>
                        <span class="text-sm font-medium text-gray-500 mt-2">ENCUESTADO</span>
                    </div>
                    <div class="flex flex-col items-center opacity-50">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-300 text-gray-700 font-bold text-lg">4</div>
                        <span class="text-sm font-medium text-gray-500 mt-2">CALIFICADORES</span>
                    </div>
                    <div class="flex flex-col items-center opacity-50">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-300 text-gray-700 font-bold text-lg">5</div>
                        <span class="text-sm font-medium text-gray-500 mt-2">REVISIÓN</span>
                    </div>
                    <div class="flex flex-col items-center opacity-50">
                        <div class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-300 text-gray-700 font-bold text-lg">6</div>
                        <span class="text-sm font-medium text-gray-500 mt-2">ASIGNACIONES</span>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN: Información de la Evaluación -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-blue-10 px-6 py-4 flex items-center">
                    <svg class="h-6 w-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h2 class="text-lg font-semibold text-gray-800">Información de la Evaluación</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-6">
                        {{-- Tipo de Evaluación --}}
                        <div>
                            <label for="tipo_evaluacion" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Evaluación</label>
                            <select id="tipo_evaluacion" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">Selecciona un tipo</option>
                                <option value="Prueba 360">Prueba 360</option>  
                                <option value="Desempeño">Desempeño</option>
                                <option value="Competencias">Competencias</option>
                                <option value="Clima Laboral">Clima Laboral</option>
                            </select>
                            <span class="text-red-500 text-sm mt-1 error-message" id="tipo-error" style="display: none;"></span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Fecha de Inicio --}}
                            <div>
                                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Inicio</label>
                                <input type="date" id="fecha_inicio" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <span class="text-red-500 text-sm mt-1 error-message" id="fecha-inicio-error" style="display: none;"></span>
                            </div>

                            {{-- Fecha de Cierre --}}
                            <div>
                                <label for="fecha_cierre" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Cierre</label>
                                <input type="date" id="fecha_cierre" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <span class="text-red-500 text-sm mt-1 error-message" id="fecha-cierre-error" style="display: none;"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Descripción Opcional --}}
                    <div class="mt-6">
                        <label for="descripcion_evaluacion" class="block text-sm font-medium text-gray-700 mb-2">Descripción Opcional</label>
                        <textarea id="descripcion_evaluacion" rows="4" placeholder="Ej. Evaluación 360° para medir competencias y desempeño del área comercial." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"></textarea>
                        <span class="text-red-500 text-sm mt-1 error-message" id="descripcion-error" style="display: none;"></span>
                    </div>
                </div>
            </div>

            <!-- Botones de Navegación -->
            <div class="flex justify-between mt-8">
                <button type="button" class="px-6 py-3 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-600 transition-colors">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Anterior
                </button>
                <button type="button" id="submit-btn" class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-colors">
                    Siguiente
                    <svg class="w-5 h-5 inline-block ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Establecer fechas por defecto
            const today = new Date();
            const nextMonth = new Date(today.getFullYear(), today.getMonth() + 1, today.getDate());
            
            document.getElementById('fecha_inicio').valueAsDate = today;
            document.getElementById('fecha_cierre').valueAsDate = nextMonth;
            
            // Manejar el envío del formulario
            document.getElementById('submit-btn').addEventListener('click', function() {
                const tipoEvaluacion = document.getElementById('tipo_evaluacion').value;
                const fechaInicio = document.getElementById('fecha_inicio').value;
                const fechaCierre = document.getElementById('fecha_cierre').value;
                const descripcion = document.getElementById('descripcion_evaluacion').value;
                
                // Ocultar mensajes de error previos
                document.querySelectorAll('.error-message').forEach(el => {
                    el.style.display = 'none';
                });
                
                let isValid = true;
                
                // Validaciones
                if (!tipoEvaluacion) {
                    document.getElementById('tipo-error').textContent = 'El tipo de evaluación es obligatorio.';
                    document.getElementById('tipo-error').style.display = 'block';
                    isValid = false;
                }
                
                if (!fechaInicio) {
                    document.getElementById('fecha-inicio-error').textContent = 'La fecha de inicio es obligatoria.';
                    document.getElementById('fecha-inicio-error').style.display = 'block';
                    isValid = false;
                }
                
                if (!fechaCierre) {
                    document.getElementById('fecha-cierre-error').textContent = 'La fecha de cierre es obligatoria.';
                    document.getElementById('fecha-cierre-error').style.display = 'block';
                    isValid = false;
                }
                
                if (fechaInicio && fechaCierre && new Date(fechaCierre) < new Date(fechaInicio)) {
                    document.getElementById('fecha-cierre-error').textContent = 'La fecha de cierre debe ser posterior o igual a la fecha de inicio.';
                    document.getElementById('fecha-cierre-error').style.display = 'block';
                    isValid = false;
                }
                
                if (!descripcion) {
                    document.getElementById('descripcion-error').textContent = 'La descripción es obligatoria.';
                    document.getElementById('descripcion-error').style.display = 'block';
                    isValid = false;
                }
                
                if (isValid) {
                    // Simular envío exitoso
                    document.getElementById('success-message').textContent = '¡Evaluación creada exitosamente!';
                    document.querySelector('.bg-green-100').style.display = 'block';
                    
                    // Simular redirección después de un breve tiempo
                    setTimeout(function() {
                        alert('Redirigiendo a la página de evaluaciones...');
                        // En un caso real, aquí iría: window.location.href = "/mostrar-evaluaciones";
                    }, 1500);
                }
            });
        });
    </script>