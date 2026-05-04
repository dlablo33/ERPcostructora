<?php
// app/Console/Commands/AnalyzeFullSystem.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MistralAIService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use ReflectionClass;
use ReflectionMethod;

class AnalyzeFullSystem extends Command
{
    protected $signature = 'system:analyze 
                            {--module= : Analizar solo un módulo específico}
                            {--detailed : Análisis extremadamente detallado}
                            {--save-db : Guardar análisis en base de conocimiento}';
    
    protected $description = 'Analiza TODO el sistema: controladores, vistas, modelos, rutas y explica TODO lo que puede hacer';

    public function handle(MistralAIService $mistral)
    {
        $this->info('🔍 ANALIZANDO SISTEMA ERP CONSTRUCTORA COMPLETO');
        $this->newLine();
        
        // ===========================================
        // 1. ANALIZAR CONTROLADORES
        // ===========================================
        $this->info('📂 1. Analizando CONTROLADORES...');
        $controladoresInfo = $this->analyzeControllers();
        $this->info('   ✓ ' . count($controladoresInfo) . ' controladores analizados');
        
        // ===========================================
        // 2. ANALIZAR VISTAS
        // ===========================================
        $this->info('🎨 2. Analizando VISTAS...');
        $vistasInfo = $this->analyzeViews();
        $this->info('   ✓ ' . $vistasInfo['total'] . ' vistas encontradas');
        
        // ===========================================
        // 3. ANALIZAR MODELOS
        // ===========================================
        $this->info('🗄️ 3. Analizando MODELOS...');
        $modelosInfo = $this->analyzeModels();
        $this->info('   ✓ ' . count($modelosInfo) . ' modelos analizados');
        
        // ===========================================
        // 4. ANALIZAR RUTAS
        // ===========================================
        $this->info('🛣️ 4. Analizando RUTAS...');
        $rutasInfo = $this->analyzeRoutes();
        $this->info('   ✓ ' . $rutasInfo['total'] . ' rutas analizadas');
        
        // ===========================================
        // 5. GENERAR DOCUMENTACIÓN COMPLETA
        // ===========================================
        $this->newLine();
        $this->info('📝 5. Generando documentación completa...');
        
        $documentacion = $this->generateDocumentation($controladoresInfo, $vistasInfo, $modelosInfo, $rutasInfo);
        
        // ===========================================
        // 6. USAR MISTRAL PARA MEJORAR ANÁLISIS
        // ===========================================
        $this->newLine();
        $this->info('🤖 6. Mejorando análisis con Mistral...');
        
        $analisisMejorado = $this->enhanceWithMistral($mistral, $documentacion);
        
        // ===========================================
        // 7. GUARDAR RESULTADOS
        // ===========================================
        $outputFile = storage_path('analisis_completo_sistema_' . date('Y-m-d_H-i-s') . '.md');
        File::put($outputFile, $analisisMejorado);
        
        $this->newLine();
        $this->info("✅ Análisis completo guardado en: {$outputFile}");
        
        // ===========================================
        // 8. GUARDAR EN BD DE CONOCIMIENTO
        // ===========================================
        if ($this->option('save-db') || $this->confirm('¿Guardar este análisis en la base de conocimiento de la IA?')) {
            $this->saveToKnowledgeBase($analisisMejorado);
            $this->info('✅ Análisis guardado en base de conocimiento');
            $this->info('💡 Ahora puedes preguntar en el chat: "qué puede hacer el sistema" o "cómo se factura"');
        }
        
        // ===========================================
        // 9. MOSTRAR RESUMEN
        // ===========================================
        $this->newLine();
        $this->line('═══════════════════════════════════════════════════════════════');
        $this->line('📊 RESUMEN DEL SISTEMA');
        $this->line('═══════════════════════════════════════════════════════════════');
        $this->newLine();
        $this->line($this->generateSummary($controladoresInfo, $vistasInfo, $modelosInfo));
        $this->newLine();
        $this->line('═══════════════════════════════════════════════════════════════');
        
        return Command::SUCCESS;
    }
    
    /**
     * Analizar todos los controladores y extraer métodos
     */
    private function analyzeControllers()
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
                $modulo = $this->detectModule($nombre);
                
                $metodos = [];
                foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                    if (!$method->isConstructor() && !str_starts_with($method->getName(), '__')) {
                        $params = [];
                        foreach ($method->getParameters() as $param) {
                            $params[] = '$' . $param->getName();
                        }
                        
                        $docComment = $method->getDocComment();
                        $descripcion = $this->extractDescription($docComment);
                        
                        $metodos[] = [
                            'nombre' => $method->getName(),
                            'parametros' => $params,
                            'descripcion' => $descripcion ?: $this->generateMethodDescription($method->getName()),
                            'return_type' => $method->hasReturnType() ? (string)$method->getReturnType() : 'mixed'
                        ];
                    }
                }
                
                if (!empty($metodos)) {
                    $controllers[$modulo][$nombre] = [
                        'archivo' => str_replace(base_path(), '', $file),
                        'metodos' => $metodos,
                        'total_metodos' => count($metodos)
                    ];
                }
            }
        }
        
        return $controllers;
    }
    
    /**
     * Analizar todas las vistas Blade
     */
    private function analyzeViews()
    {
        $views = [];
        $viewsPath = resource_path('views');
        
        if (is_dir($viewsPath)) {
            $files = File::allFiles($viewsPath);
            
            foreach ($files as $file) {
                if ($file->getExtension() === 'php' || $file->getExtension() === 'blade.php') {
                    $relativePath = str_replace($viewsPath . '/', '', $file->getPathname());
                    $modulo = explode('/', $relativePath)[0];
                    
                    $content = File::get($file);
                    
                    // Extraer información de la vista
                    $views[$modulo][] = [
                        'nombre' => $file->getFilename(),
                        'ruta' => $relativePath,
                        'tiene_forms' => str_contains($content, '<form'),
                        'tiene_tablas' => str_contains($content, '<table'),
                        'tiene_modales' => str_contains($content, 'modal'),
                        'tiene_ajax' => str_contains($content, 'fetch') || str_contains($content, '$.ajax'),
                        'tamaño' => strlen($content)
                    ];
                }
            }
        }
        
        return [
            'total' => count($files ?? []),
            'por_modulo' => $views
        ];
    }
    
    /**
     * Analizar modelos de datos
     */
    private function analyzeModels()
    {
        $models = [];
        $modelsPath = app_path('Models');
        
        if (is_dir($modelsPath)) {
            $files = glob($modelsPath . '/*.php');
            
            foreach ($files as $file) {
                $className = 'App\\Models\\' . basename($file, '.php');
                
                if (class_exists($className)) {
                    $reflection = new ReflectionClass($className);
                    $model = new $className();
                    
                    $models[basename($file, '.php')] = [
                        'tabla' => $model->getTable() ?? str_plural(strtolower(basename($file, '.php'))),
                        'fillable' => property_exists($className, 'fillable') ? (new $className())->getFillable() : [],
                        'casts' => property_exists($className, 'casts') ? (new $className())->getCasts() : [],
                        'relationships' => $this->getModelRelationships($reflection)
                    ];
                }
            }
        }
        
        return $models;
    }
    
    /**
     * Analizar rutas
     */
    private function analyzeRoutes()
    {
        $routes = [];
        $routeCount = 0;
        
        foreach (Route::getRoutes() as $route) {
            $action = $route->getActionName();
            if (!str_contains($action, 'Closure')) {
                $method = implode('|', $route->methods());
                $uri = $route->uri();
                $controller = class_basename($action);
                $modulo = $this->detectModule($controller);
                
                $routes[$modulo][] = [
                    'method' => $method,
                    'uri' => $uri,
                    'controller' => $controller,
                    'name' => $route->getName()
                ];
                $routeCount++;
            }
        }
        
        return [
            'total' => $routeCount,
            'por_modulo' => $routes
        ];
    }
    
    /**
     * Extraer descripción de comentarios PHP
     */
    private function extractDescription($docComment)
    {
        if (!$docComment) return null;
        preg_match('/\*\s*(.+?)(?:\n|\*\/)/', $docComment, $matches);
        return $matches[1] ?? null;
    }
    
    /**
     * Generar descripción basada en nombre del método
     */
    private function generateMethodDescription($methodName)
    {
        $descriptions = [
            'index' => 'Lista todos los registros',
            'create' => 'Muestra formulario para crear nuevo registro',
            'store' => 'Guarda un nuevo registro en la base de datos',
            'show' => 'Muestra los detalles de un registro específico',
            'edit' => 'Muestra formulario para editar un registro',
            'update' => 'Actualiza un registro existente',
            'destroy' => 'Elimina un registro',
            'getUsers' => 'Obtiene lista de usuarios del sistema',
            'sendMessage' => 'Envía un mensaje a otro usuario',
            'markAsRead' => 'Marca mensajes como leídos',
        ];
        
        return $descriptions[$methodName] ?? "Método {$methodName} del sistema";
    }
    
    /**
     * Obtener relaciones del modelo
     */
    private function getModelRelationships($reflection)
    {
        $relationships = [];
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
        
        foreach ($methods as $method) {
            $code = file_get_contents($reflection->getFileName());
            $pattern = '/function\s+' . $method->getName() . '\(\)\s*\{\s*return\s+\$this->(belongsTo|hasMany|hasOne|belongsToMany)/';
            
            if (preg_match($pattern, $code, $matches)) {
                $relationships[] = [
                    'nombre' => $method->getName(),
                    'tipo' => $matches[1]
                ];
            }
        }
        
        return $relationships;
    }
    
    /**
     * Detectar módulo por nombre
     */
    private function detectModule($name)
    {
        $name = strtolower($name);
        if (str_contains($name, 'admin')) return 'Administración';
        if (str_contains($name, 'contab')) return 'Contabilidad';
        if (str_contains($name, 'proyecto')) return 'Proyectos';
        if (str_contains($name, 'rrhh') || str_contains($name, 'rh')) return 'RRHH';
        if (str_contains($name, 'inventario') || str_contains($name, 'almacen')) return 'Inventarios';
        if (str_contains($name, 'compra')) return 'Compras';
        if (str_contains($name, 'chat')) return 'Chat';
        if (str_contains($name, 'bi') || str_contains($name, 'dashboard')) return 'BI';
        if (str_contains($name, 'factura')) return 'Facturación';
        return 'General';
    }
    
    /**
     * Generar documentación completa
     */
    private function generateDocumentation($controllers, $views, $models, $routes)
    {
        $doc = "# 📚 DOCUMENTACIÓN COMPLETA DEL SISTEMA ERP CONSTRUCTORA\n\n";
        $doc .= "**Generado:** " . date('Y-m-d H:i:s') . "\n\n";
        
        // ===========================================
        // CONTROLADORES
        // ===========================================
        $doc .= "## 📂 CONTROLADORES Y ACCIONES\n\n";
        
        foreach ($controllers as $modulo => $moduloControllers) {
            $doc .= "### 🗂️ Módulo: {$modulo}\n\n";
            
            foreach ($moduloControllers as $controller => $data) {
                $doc .= "#### 📄 {$controller}\n";
                $doc .= "- **Archivo:** `{$data['archivo']}`\n";
                $doc .= "- **Métodos disponibles:** {$data['total_metodos']}\n\n";
                
                $doc .= "| Método | Parámetros | Descripción | Retorna |\n";
                $doc .= "|--------|-----------|-------------|---------|\n";
                
                foreach ($data['metodos'] as $metodo) {
                    $params = empty($metodo['parametros']) ? 'ninguno' : implode(', ', $metodo['parametros']);
                    $doc .= "| `{$metodo['nombre']}()` | {$params} | {$metodo['descripcion']} | {$metodo['return_type']} |\n";
                }
                $doc .= "\n";
            }
        }
        
        // ===========================================
        // VISTAS
        // ===========================================
        $doc .= "## 🎨 VISTAS BLADE\n\n";
        $doc .= "Total de vistas: **{$views['total']}**\n\n";
        
        foreach ($views['por_modulo'] as $modulo => $vistasModulo) {
            $doc .= "### 📁 {$modulo}\n\n";
            foreach ($vistasModulo as $vista) {
                $doc .= "- **`{$vista['nombre']}`**\n";
                $doc .= "  - Ruta: `{$vista['ruta']}`\n";
                if ($vista['tiene_forms']) $doc .= "  - ✅ Contiene formularios\n";
                if ($vista['tiene_tablas']) $doc .= "  - ✅ Contiene tablas de datos\n";
                if ($vista['tiene_modales']) $doc .= "  - ✅ Tiene modales\n";
                if ($vista['tiene_ajax']) $doc .= "  - ✅ Usa AJAX\n";
            }
            $doc .= "\n";
        }
        
        // ===========================================
        // RUTAS
        // ===========================================
        $doc .= "## 🛣️ RUTAS API Y WEB\n\n";
        $doc .= "Total de rutas: **{$routes['total']}**\n\n";
        
        foreach ($routes['por_modulo'] as $modulo => $rutasModulo) {
            $doc .= "### {$modulo}\n\n";
            foreach ($rutasModulo as $ruta) {
                $doc .= "- `[{$ruta['method']}]` **{$ruta['uri']}** → `{$ruta['controller']}`\n";
                if ($ruta['name']) $doc .= "  - Nombre: `{$ruta['name']}`\n";
            }
            $doc .= "\n";
        }
        
        return $doc;
    }
    
    /**
     * Mejorar análisis con Mistral
     */
    private function enhanceWithMistral($mistral, $documentacion)
    {
        $prompt = "Analiza este sistema ERP Constructora y genera una EXPLICACIÓN CLARA de:

1. QUÉ PUEDE HACER CADA MÓDULO (funcionalidades principales)
2. CÓMO SE HACE CADA ACCIÓN (pasos para usar cada función)
3. QUÉ MÉTODOS DEBO USAR PARA CADA TAREA

Información técnica del sistema:
" . substr($documentacion, 0, 3000) . "

Responde en español, con formato claro:

## 📋 FUNCIONALIDADES DEL SISTEMA

### [Nombre del Módulo]
**Qué puede hacer:**
- [Lista de funcionalidades]

**Cómo se hace (pasos):**
1. [Paso 1 - método a usar]
2. [Paso 2 - vista/ruta]
3. [Paso 3 - resultado esperado]

**Métodos clave:**
- `nombre_metodo()` → [qué hace]

Responde SOLO con esta estructura, máximo 1500 caracteres.";

        $analisis = $mistral->ask($prompt);
        
        if (strlen($analisis) < 100) {
            $analisis = $this->generateManualAnalysis($documentacion);
        }
        
        return $documentacion . "\n\n---\n\n" . $analisis;
    }
    
    /**
     * Análisis manual si Mistral falla
     */
    private function generateManualAnalysis($documentacion)
    {
        return "## 📋 FUNCIONALIDADES DEL SISTEMA\n\n" .
               "Para más detalles, revisa la documentación técnica completa arriba.\n\n" .
               "**Consulta los métodos disponibles en cada controlador para entender las acciones posibles.**";
    }
    
    /**
     * Guardar en base de conocimiento
     */
    private function saveToKnowledgeBase($analisis)
    {
        $modulos = [
            'qué puede hacer el sistema' => 'Funcionalidades completas del sistema ERP',
            'cómo funciona el sistema' => 'Guía de uso del sistema',
            'documentación del sistema' => $analisis
        ];
        
        foreach ($modulos as $keyword => $desc) {
            \App\Models\IAKnowledgeBase::updateOrCreate(
                ['keyword' => $keyword],
                [
                    'module_name' => 'Documentación',
                    'response_text' => substr($desc, 0, 500),
                    'confidence_score' => 100
                ]
            );
        }
    }
    
    /**
     * Generar resumen
     */
    private function generateSummary($controllers, $views, $models)
    {
        $totalMetodos = 0;
        foreach ($controllers as $modulo => $moduloControllers) {
            foreach ($moduloControllers as $controller) {
                $totalMetodos += $controller['total_metodos'];
            }
        }
        
        return "📊 **ESTADÍSTICAS DEL SISTEMA**\n\n" .
               "| Concepto | Cantidad |\n" .
               "|----------|----------|\n" .
               "| Módulos | " . count($controllers) . " |\n" .
               "| Controladores | " . array_sum(array_map('count', $controllers)) . " |\n" .
               "| Métodos/Acciones | {$totalMetodos} |\n" .
               "| Vistas | {$views['total']} |\n" .
               "| Modelos | " . count($models) . " |\n\n" .
               "💡 **Para más detalle**: Revisa el archivo generado en storage/";
    }
}