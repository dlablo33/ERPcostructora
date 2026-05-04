<?php
// app/Console/Commands/GenerateSystemMap.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MistralAIService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use ReflectionClass;
use ReflectionMethod;

class GenerateSystemMap extends Command
{
    protected $signature = 'system:map 
                            {--detailed : Generar mapa detallado con métodos}
                            {--output= : Guardar en archivo específico}';
    
    protected $description = 'Generar mapa completo del sistema usando IA (Mistral)';

    public function handle(MistralAIService $mistral)
    {
        $this->info('🗺️  Generando mapa del sistema ERP Constructora...');
        $this->newLine();
        
        // ===========================================
        // 1. RECOLECTAR ESTRUCTURA DEL SISTEMA
        // ===========================================
        $this->info('📂 1. Escaneando estructura del sistema...');
        
        // a) Módulos desde base de conocimiento
        $modulos = \App\Models\IAKnowledgeBase::whereNotNull('module_name')
            ->select('keyword', 'module_name', 'response_text')
            ->get()
            ->groupBy('module_name');
        
        $this->info('   ✓ ' . $modulos->count() . ' módulos encontrados en conocimiento');
        
        // b) Controladores del sistema
        $controladores = $this->scanControllers();
        $this->info('   ✓ ' . count($controladores) . ' controladores encontrados');
        
        // c) Rutas principales
        $rutas = $this->scanRoutes();
        $this->info('   ✓ ' . count($rutas) . ' rutas principales');
        
        // d) Estructura de directorios
        $directorios = $this->scanDirectories();
        $this->info('   ✓ ' . count($directorios) . ' directorios mapeados');
        
        $this->newLine();
        
        // ===========================================
        // 2. CONSTRUIR PROMPT PARA MISTRAL
        // ===========================================
        $this->info('🤖 2. Enviando datos a Mistral para análisis...');
        
        // ===========================================
        // 3. GENERAR MAPA CON MISTRAL
        // ===========================================
        $this->info('🧠 3. Generando mapa del sistema...');
        
        // Intentar generar mapa con Mistral
        $mapa = $mistral->generateSystemMap();
        
        // Si Mistral no devuelve un mapa válido, usar el predeterminado
        if (empty($mapa) || strlen($mapa) < 50 || $mapa === '*') {
            $this->warn('   ⚠️  Mistral no generó un mapa válido. Usando mapa predeterminado...');
            $mapa = $this->getDefaultMap();
        }
        
        // ===========================================
        // 4. GUARDAR MAPA
        // ===========================================
        $outputFile = $this->option('output') ?? storage_path('mapa_sistema_' . date('Y-m-d_H-i-s') . '.md');
        
        File::put($outputFile, $this->formatMapOutput($mapa, $modulos, $controladores));
        
        $this->newLine();
        $this->info("✅ Mapa guardado en: {$outputFile}");
        
        // ===========================================
        // 5. MOSTRAR MAPA EN PANTALLA
        // ===========================================
        $this->newLine();
        $this->line('═══════════════════════════════════════════════════════════');
        $this->line('🗺️  MAPA DEL SISTEMA ERP CONSTRUCTORA');
        $this->line('═══════════════════════════════════════════════════════════');
        $this->newLine();
        $this->line($mapa);
        $this->newLine();
        $this->line('═══════════════════════════════════════════════════════════');
        
        // ===========================================
        // 6. OPCIÓN: GUARDAR TAMBIÉN EN CONOCIMIENTO
        // ===========================================
        if ($this->confirm('¿Deseas guardar este mapa en la base de conocimiento de la IA?')) {
            \App\Models\IAKnowledgeBase::updateOrCreate(
                ['keyword' => 'mapa del sistema'],
                [
                    'module_name' => 'Sistema',
                    'response_text' => substr($mapa, 0, 500),
                    'confidence_score' => 100
                ]
            );
            $this->info('✅ Mapa guardado en conocimiento de la IA');
            $this->info('💡 Ahora puedes preguntar en el chat: "muéstrame el mapa del sistema"');
        }
        
        return Command::SUCCESS;
    }
    
    /**
     * Mapa predeterminado del sistema (fallback)
     */
    private function getDefaultMap()
    {
        return "🏠 **ERP CONSTRUCTORA MEJORASOFT - MAPA DEL SISTEMA**

📊 **BI (Business Intelligence)**
├── Dashboard Directivo
├── Dashboard Finanzas
├── Licitaciones
├── Ventas y Propuestas
└── Facturación y Cobranza

📋 **ADMINISTRACIÓN**
├── Facturación (CFDI, Notas, Contrarecibos)
├── Cuentas por Cobrar
├── Cuentas por Pagar
├── Tesorería
│   ├── Depósitos
│   ├── Transferencias
│   ├── Pagos
│   └── Conciliación Bancaria
├── Presupuestos
└── Operaciones (Prepago, Anticipos, Crédito)

🏗️ **PROYECTOS**
├── Gestión de Proyectos
│   ├── Cartera de Proyectos
│   ├── Alta de Proyecto
│   └── Cronograma y Hitos
├── Licitaciones y Cotizaciones
├── Presupuestos por Proyecto
├── Costos (Directos/Indirectos)
├── Avances de Obra
│   ├── Estimaciones
│   └── Reporte Fotográfico
├── Personal Asignado
├── Maquinaria y Equipo
└── Control de Riesgos

📊 **CONTABILIDAD**
├── Estados Financieros
│   ├── Estado de Resultados
│   ├── Balance General
│   └── Flujo de Efectivo
├── Registro Contable
├── Catálogo de Cuentas
├── Contabilidad por Proyecto
└── Fiscal (DIOT, Declaraciones, Retenciones)

👥 **RRHH (Recursos Humanos)**
├── Plantilla de Empleados
├── Asistencia y Horarios
├── Nómina
│   ├── Cálculo de Nómina
│   ├── Pagos
│   └── Recibos Timbrados
├── Prestaciones y Descuentos
└── Unidades y Flotilla

📦 **ALMACÉN / INVENTARIOS**
├── Catálogos (Materiales, Activos, Familias)
├── Existencias por Almacén
├── Movimientos
│   ├── Entradas y Salidas
│   └── Traspasos
└── Requisiciones

🛒 **COMPRAS**
├── Requisiciones
├── Órdenes de Compra
├── Autorizaciones
└── Proveedores

💬 **CHAT**
├── Usuarios y Contactos
├── Conversaciones 1 a 1
├── Mensajes en Tiempo Real
└── Notificaciones

🔗 **RELACIONES ENTRE MÓDULOS**
• Proyectos ←→ Presupuestos ←→ Administración
• Compras ←→ Inventarios ←→ Proyectos
• RRHH ←→ Nómina ←→ Contabilidad
• Facturación ←→ Cuentas ←→ Tesorería
• Chat ←→ Todos los usuarios del sistema

🔄 **FLUJO DE NAVEGACIÓN**
1. Login → Dashboard principal (BI/Estadísticas)
2. Desde menú lateral → Acceso a cualquier módulo
3. Pestañas → Multitarea entre módulos
4. Chat flotante → Comunicación en tiempo real";
    }
    
    /**
     * Escanear todos los controladores del sistema
     */
    private function scanControllers()
    {
        $controllers = [];
        $files = glob(app_path('Http/Controllers/**/*.php'));
        
        foreach ($files as $file) {
            $className = 'App\\Http\\Controllers\\' . str_replace(
                ['/', '.php'],
                ['\\', ''],
                str_replace(app_path('Http/Controllers/'), '', $file)
            );
            
            if (class_exists($className)) {
                $reflection = new ReflectionClass($className);
                $nombre = class_basename($className);
                
                $metodos = [];
                if ($this->option('detailed')) {
                    foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                        if (!$method->isConstructor() && !str_starts_with($method->getName(), '__')) {
                            $metodos[] = $method->getName() . '()';
                        }
                    }
                }
                
                $controllers[$nombre] = [
                    'namespace' => $className,
                    'archivo' => str_replace(app_path(), '', $file),
                    'metodos' => $metodos,
                    'modulo' => $this->detectModule($nombre)
                ];
            }
        }
        
        return $controllers;
    }
    
    /**
     * Escanear rutas principales
     */
    private function scanRoutes()
    {
        $routes = [];
        $count = 0;
        
        foreach (Route::getRoutes() as $route) {
            if ($count > 100) break; // Limitar para no saturar
            
            $action = $route->getActionName();
            if (!str_contains($action, 'Closure')) {
                $routes[] = [
                    'uri' => $route->uri(),
                    'method' => implode('|', $route->methods()),
                    'name' => $route->getName(),
                    'controller' => class_basename($action)
                ];
                $count++;
            }
        }
        
        return $routes;
    }
    
    /**
     * Escanear estructura de directorios
     */
    private function scanDirectories()
    {
        $directories = [];
        $paths = [
            'app/Http/Controllers' => 'Controladores',
            'app/Models' => 'Modelos',
            'app/Services' => 'Servicios',
            'resources/views' => 'Vistas',
            'database/migrations' => 'Migraciones',
            'routes' => 'Rutas',
        ];
        
        foreach ($paths as $path => $description) {
            $fullPath = base_path($path);
            if (is_dir($fullPath)) {
                $directories[$path] = [
                    'descripcion' => $description,
                    'archivos' => count(glob($fullPath . '/*.php')) + count(glob($fullPath . '/*.blade.php'))
                ];
            }
        }
        
        return $directories;
    }
    
    /**
     * Detectar módulo basado en nombre del controlador
     */
    private function detectModule($controllerName)
    {
        $controllerLower = strtolower($controllerName);
        
        if (str_contains($controllerLower, 'admin')) return 'Administración';
        if (str_contains($controllerLower, 'factura')) return 'Facturación';
        if (str_contains($controllerLower, 'proyecto')) return 'Proyectos';
        if (str_contains($controllerLower, 'presupuesto')) return 'Presupuestos';
        if (str_contains($controllerLower, 'contabilidad') || str_contains($controllerLower, 'conta')) return 'Contabilidad';
        if (str_contains($controllerLower, 'rh') || str_contains($controllerLower, 'rrhh') || str_contains($controllerLower, 'empleado')) return 'RRHH';
        if (str_contains($controllerLower, 'inventario') || str_contains($controllerLower, 'almacen')) return 'Inventarios';
        if (str_contains($controllerLower, 'compra')) return 'Compras';
        if (str_contains($controllerLower, 'chat')) return 'Chat';
        if (str_contains($controllerLower, 'bi') || str_contains($controllerLower, 'dashboard')) return 'BI';
        
        return 'General';
    }
    
    /**
     * Formatear salida del mapa
     */
    private function formatMapOutput($mapa, $modulos, $controladores)
    {
        $output = "# Mapa del Sistema ERP Constructora\n\n";
        $output .= "**Generado:** " . date('Y-m-d H:i:s') . "\n\n";
        $output .= "## Datos del Sistema\n\n";
        $output .= "- **Módulos en conocimiento:** " . $modulos->count() . "\n";
        $output .= "- **Controladores encontrados:** " . count($controladores) . "\n";
        $output .= "- **Versión del mapa:** " . ($this->option('detailed') ? 'Detallada' : 'Resumida') . "\n\n";
        $output .= "## Mapa del Sistema\n\n";
        $output .= $mapa . "\n\n";
        $output .= "---\n";
        $output .= "*Mapa generado automáticamente*\n";
        
        return $output;
    }
}