@extends('soporte.layouts.app')

@section('soporte-content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 bg-gradient-to-r from-yellow-50 to-yellow-100 border-b border-yellow-200">
            <div class="flex items-center">
                <i class="fas fa-plus-circle text-yellow-600 text-xl mr-3"></i>
                <div>
                    <h3 class="text-xl font-bold text-gray-800">Crear Nuevo Ticket</h3>
                    <p class="text-sm text-gray-600">Completa el formulario para crear una nueva solicitud de soporte</p>
                </div>
            </div>
        </div>

        <!-- Formulario -->
        <form class="p-6 space-y-6" id="ticket-form">
            @csrf

            <!-- Título -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Título del Ticket <span class="text-red-500">*</span>
                </label>
                <input type="text" name="titulo" required
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                       placeholder="Ej: Error al generar factura #12345">
                <p class="text-xs text-gray-500 mt-1">Describe brevemente el problema o solicitud</p>
            </div>

            <!-- Descripción -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Descripción <span class="text-red-500">*</span>
                </label>
                <textarea name="descripcion" rows="5" required
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition"
                          placeholder="Describe detalladamente el problema o solicitud..."></textarea>
                <p class="text-xs text-gray-500 mt-1">Incluye todos los detalles relevantes para que el equipo de soporte pueda ayudarte mejor</p>
            </div>

            <!-- Tipo y Prioridad -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tipo de Solicitud <span class="text-red-500">*</span>
                    </label>
                    <select name="tipo" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition">
                        <option value="">Seleccionar tipo...</option>
                        <option value="error">🐛 Error</option>
                        <option value="solicitud">💡 Solicitud</option>
                        <option value="mejora">🚀 Mejora</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Prioridad <span class="text-red-500">*</span>
                    </label>
                    <select name="prioridad" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500 transition">
                        <option value="">Seleccionar prioridad...</option>
                        <option value="baja">🟢 Baja</option>
                        <option value="media">🟡 Media</option>
                        <option value="alta">🟠 Alta</option>
                        <option value="critica">🔴 Crítica</option>
                    </select>
                </div>
            </div>

            <!-- Archivos adjuntos -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Archivos adjuntos
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-yellow-400 transition cursor-pointer" id="drop-zone">
                    <div class="space-y-2">
                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400"></i>
                        <p class="text-gray-600">Arrastra y suelta archivos aquí o haz clic para seleccionar</p>
                        <p class="text-xs text-gray-500">Máximo 10MB por archivo. Formatos: JPG, PNG, PDF, DOCX</p>
                    </div>
                    <input type="file" name="archivos[]" multiple class="hidden" accept=".jpg,.jpeg,.png,.pdf,.docx,.txt,.log">
                </div>
                <div id="file-list" class="mt-2 space-y-1"></div>
            </div>

            <!-- Botones -->
            <div class="flex flex-wrap gap-3 pt-4 border-t border-gray-200">
                <button type="submit" class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-lg transition font-medium flex items-center">
                    <i class="fas fa-paper-plane mr-2"></i> Enviar Ticket
                </button>
                <a href="{{ route('soporte.tickets.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg transition font-medium flex items-center">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </a>
            </div>
        </form>
    </div>

    <!-- Consejos -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <i class="fas fa-lightbulb text-blue-500 mt-1 mr-3"></i>
            <div>
                <h4 class="font-medium text-blue-800">Consejos para un ticket efectivo:</h4>
                <ul class="text-sm text-blue-700 mt-1 space-y-1">
                    <li>• Sé específico y detallado en la descripción</li>
                    <li>• Adjunta capturas de pantalla si es posible</li>
                    <li>• Incluye pasos para reproducir el error</li>
                    <li>• Marca la prioridad correctamente según la urgencia</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('drop-zone').addEventListener('click', function() {
    this.querySelector('input[type="file"]').click();
});

document.getElementById('drop-zone').addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('border-yellow-500', 'bg-yellow-50');
});

document.getElementById('drop-zone').addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('border-yellow-500', 'bg-yellow-50');
});

document.getElementById('drop-zone').addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('border-yellow-500', 'bg-yellow-50');
    const files = e.dataTransfer.files;
    handleFiles(files);
});

document.querySelector('#drop-zone input[type="file"]').addEventListener('change', function() {
    handleFiles(this.files);
});

function handleFiles(files) {
    const fileList = document.getElementById('file-list');
    for (let file of files) {
        const item = document.createElement('div');
        item.className = 'flex items-center justify-between p-2 bg-gray-50 rounded-lg text-sm';
        item.innerHTML = `
            <div class="flex items-center">
                <i class="fas fa-file text-gray-400 mr-2"></i>
                <span>${file.name}</span>
                <span class="text-xs text-gray-500 ml-2">(${(file.size / 1024).toFixed(1)} KB)</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                <i class="fas fa-times"></i>
            </button>
        `;
        fileList.appendChild(item);
    }
}

document.getElementById('ticket-form').addEventListener('submit', function(e) {
    e.preventDefault();
    alert('✅ Ticket creado exitosamente! (Demo)');
    window.location.href = '{{ route('soporte.tickets.index') }}';
});
</script>
@endpush
@endsection