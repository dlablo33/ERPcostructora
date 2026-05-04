<?php
// app/Services/MistralAIService.php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\IAMistralCache;
use App\Models\IAKnowledgeBase;

class MistralAIService
{
    private $apiKey;
    private $apiUrl = 'https://api.mistral.ai/v1/chat/completions';
    
    public function __construct()
    {
        $this->apiKey = '5pP4gWElZmChg9eKYRVowuVPpywQOxET';
    }
    
    /**
     * Preguntar a la IA - Obtiene respuesta del análisis, conocimiento local o Mistral
     */
    public function ask($userQuestion)
    {
        // 1. Buscar en cache
        $questionHash = md5($userQuestion);
        $cached = IAMistralCache::where('context_hash', $questionHash)
            ->where(function($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>', now());
            })
            ->first();
            
        if ($cached) {
            return $cached->ai_response;
        }
        
        // 2. PRIMERO: Buscar en guías paso a paso
        $localKnowledge = $this->searchIntelligentKnowledge($userQuestion);
        if ($localKnowledge) {
            IAMistralCache::create([
                'user_question' => $userQuestion,
                'ai_response' => $localKnowledge,
                'context_hash' => $questionHash,
                'expires_at' => now()->addDays(30)
            ]);
            return $localKnowledge;
        }
        
        // 3. SEGUNDO: Buscar en el análisis técnico
        $systemAnalysis = $this->searchInSystemAnalysis($userQuestion);
        if ($systemAnalysis) {
            $friendlyResponse = $this->makeResponseFriendly($systemAnalysis, $userQuestion);
            IAMistralCache::create([
                'user_question' => $userQuestion,
                'ai_response' => $friendlyResponse,
                'context_hash' => $questionHash,
                'expires_at' => now()->addDays(30)
            ]);
            return $friendlyResponse;
        }
        
        // 4. Consultar a Mistral
        $response = $this->callMistral($userQuestion);
        
        if ($response) {
            IAMistralCache::create([
                'user_question' => $userQuestion,
                'ai_response' => $response,
                'context_hash' => $questionHash,
                'expires_at' => now()->addDays(7)
            ]);
            return $response;
        }
        
        return $this->getHelpfulResponse($userQuestion);
    }
    
    /**
     * Convertir respuesta técnica a formato amigable
     */
    private function makeResponseFriendly($technicalResponse, $originalQuestion)
    {
        $questionLower = strtolower($originalQuestion);
        
        if (str_contains($questionLower, 'proyecto') || str_contains($questionLower, 'alta')) {
            return "🏗️ **COMO DAR DE ALTA UN PROYECTO**

Para crear un nuevo proyecto:

1️⃣ Ve al menú principal y haz clic en PROYECTOS
2️⃣ Dentro de Proyectos, selecciona GESTION DE PROYECTOS
3️⃣ Luego haz clic en ALTA DE PROYECTO
4️⃣ Completa el formulario con:
   - Nombre del proyecto
   - Cliente
   - Fecha de inicio
   - Fecha de fin estimada
   - Presupuesto asignado
5️⃣ Adjunta documentos (contrato, planos)
6️⃣ Haz clic en GUARDAR

✅ El proyecto quedará registrado en tu cartera de proyectos.";
        }
        
        if (str_contains($questionLower, 'ingreso') || str_contains($questionLower, 'deposito')) {
            return "💰 **COMO REGISTRAR UN INGRESO**

Para registrar un ingreso:

1️⃣ Ve a ADMINISTRACION → TESORERIA
2️⃣ Selecciona DEPOSITOS
3️⃣ Presiona NUEVO REGISTRO
4️⃣ Completa los datos:
   - Cuenta bancaria destino
   - Monto del ingreso
   - Concepto
   - Cliente
5️⃣ Adjunta comprobante
6️⃣ Guarda

✅ El ingreso se reflejará en el saldo de la cuenta.";
        }
        
        if (str_contains($questionLower, 'asistencia') || str_contains($questionLower, 'marcar entrada')) {
            return "👥 **COMO REGISTRAR ASISTENCIA**

Para registrar asistencia:

1️⃣ Ve a RRHH → ASISTENCIA
2️⃣ Selecciona REGISTRAR ENTRADA
3️⃣ Elige el empleado
4️⃣ Marca la hora de entrada
5️⃣ Guarda

✅ El registro quedará guardado en el sistema.";
        }
        
        if (str_contains($questionLower, 'requisicion') || str_contains($questionLower, 'requisiciones')) {
            return "📋 **REQUISICIONES DE COMPRA**

Para crear una requisicion:

1️⃣ Ve a COMPRAS (icono 🛒)
2️⃣ Selecciona REQUISICIONES
3️⃣ Presiona NUEVA REQUISICION
4️⃣ Completa:
   - Area solicitante
   - Articulos o materiales
   - Cantidades
   - Fecha requerida
5️⃣ Guarda

✅ Quedara pendiente de autorizacion.

🏢 **Para autorizar:**
1️⃣ Ve a REQUISICIONES
2️⃣ Busca pendientes
3️⃣ Haz clic en AUTORIZAR

✨ Las requisiciones autorizadas se convierten en ordenes de compra.";
        }
        
        return "📋 Información encontrada en el sistema. Para ayuda especifica, preguntame: 'como crear un proyecto', 'como registrar un ingreso', 'como crear una requisicion' o 'como marcar asistencia'.";
    }
    
    /**
     * Cargar el análisis completo del sistema desde el archivo
     */
    private function loadSystemAnalysis()
    {
        $analysisFile = storage_path('analisis_completo_sistema_*.md');
        $files = glob($analysisFile);
        
        if (empty($files)) {
            return null;
        }
        
        // Tomar el archivo más reciente
        $latestFile = $files[0];
        foreach ($files as $file) {
            if (filemtime($file) > filemtime($latestFile)) {
                $latestFile = $file;
            }
        }
        
        return file_get_contents($latestFile);
    }
    
    /**
     * Buscar en el análisis del sistema
     */
    private function searchInSystemAnalysis($question)
    {
        $analysis = $this->loadSystemAnalysis();
        if (!$analysis) {
            return null;
        }
        
        $questionLower = strtolower($question);
        $searchTerms = [];
        
        if (str_contains($questionLower, 'vista') || str_contains($questionLower, 'blade')) {
            $searchTerms = ['vista', 'blade.php', 'resources/views'];
        } elseif (str_contains($questionLower, 'controlador') || str_contains($questionLower, 'controller')) {
            $searchTerms = ['Controller', 'métodos disponibles'];
        } elseif (str_contains($questionLower, 'ruta') || str_contains($questionLower, 'route')) {
            $searchTerms = ['GET|HEAD', 'POST|', 'RUTAS'];
        } elseif (str_contains($questionLower, 'factura')) {
            $searchTerms = ['facturacion', 'Facturación'];
        } elseif (str_contains($questionLower, 'asistencia')) {
            $searchTerms = ['asistencia', 'AsistenciaController'];
        } elseif (str_contains($questionLower, 'proyecto')) {
            $searchTerms = ['proyectos', 'ProyectoController'];
        } elseif (str_contains($questionLower, 'almacen') || str_contains($questionLower, 'inventario')) {
            $searchTerms = ['almacen', 'InventarioController'];
        } elseif (str_contains($questionLower, 'compras') || str_contains($questionLower, 'requisicion')) {
            $searchTerms = ['compras', 'RequisicionController'];
        } elseif (str_contains($questionLower, 'rrhh')) {
            $searchTerms = ['rh/', 'PlantillaController'];
        } elseif (str_contains($questionLower, 'contabilidad')) {
            $searchTerms = ['conta/', 'Contabilidad'];
        }
        
        if (empty($searchTerms)) {
            $words = explode(' ', $questionLower);
            $searchTerms = array_filter($words, function($w) {
                return strlen($w) > 4;
            });
        }
        
        $lines = explode("\n", $analysis);
        $relevantLines = [];
        
        foreach ($searchTerms as $term) {
            foreach ($lines as $index => $line) {
                if (str_contains(strtolower($line), strtolower($term))) {
                    $start = max(0, $index - 5);
                    $end = min(count($lines) - 1, $index + 5);
                    for ($i = $start; $i <= $end; $i++) {
                        if (!empty(trim($lines[$i])) && !in_array(trim($lines[$i]), $relevantLines)) {
                            $relevantLines[] = trim($lines[$i]);
                        }
                    }
                    break 2;
                }
            }
        }
        
        if (!empty($relevantLines)) {
            return implode("\n", $relevantLines);
        }
        
        return null;
    }
    
    /**
     * Guías paso a paso
     */
    private function searchIntelligentKnowledge($question)
    {
        $questionLower = strtolower($question);
        
        // Almacen / Inventarios
        if (str_contains($questionLower, 'almacen') || str_contains($questionLower, 'entrada de almacen')) {
            return "📦 **ALMACEN - ENTRADA DE MATERIAL**

1️⃣ Ve a ALMACEN → MOVIMIENTOS
2️⃣ Selecciona ENTRADAS Y SALIDAS
3️⃣ Presiona NUEVA ENTRADA
4️⃣ Completa: material, cantidad, almacen
5️⃣ Guarda

✅ Material registrado en inventario.";
        }
        
        // Facturación
        if (str_contains($questionLower, 'factura') || str_contains($questionLower, 'facturacion')) {
            return "📋 **FACTURACION**

1️⃣ Ve a ADMINISTRACION → FACTURACION
2️⃣ Opciones disponibles:
   - Crear nueva factura
   - Ver CFDI
   - Generar Notas de Credito
   - Contrarecibos

✅ Puedes filtrar por cliente o fecha.";
        }
        
        // Proyectos
        if (str_contains($questionLower, 'proyecto') || str_contains($questionLower, 'obra') || str_contains($questionLower, 'alta proyecto')) {
            return "🏗️ **PROYECTOS - ALTA DE PROYECTO**

Para crear un nuevo proyecto:

1️⃣ Ve a PROYECTOS → GESTION DE PROYECTOS
2️⃣ Selecciona ALTA DE PROYECTO
3️⃣ Completa el formulario:
   - Nombre del proyecto
   - Cliente
   - Fecha de inicio
   - Fecha de fin
   - Presupuesto
4️⃣ Adjunta documentos
5️⃣ Guarda

✅ El proyecto quedara registrado.";
        }
        
        // REQUISICIONES - Actualizado para mejor deteccion
        if (str_contains($questionLower, 'requisicion') || str_contains($questionLower, 'requisiciones') || 
            str_contains($questionLower, 'creo una requisicion') || str_contains($questionLower, 'hago una requisicion') ||
            str_contains($questionLower, 'crear requisicion')) {
            return "📋 **REQUISICIONES DE COMPRA**

Para crear una requisicion:

1️⃣ Ve al menu principal y haz clic en COMPRAS (icono 🛒)
2️⃣ Dentro de Compras, selecciona REQUISICIONES
3️⃣ Presiona el boton NUEVA REQUISICION
4️⃣ Completa los datos:
   - Selecciona el area solicitante
   - Agrega los articulos o materiales
   - Especifica cantidades
   - Indica la fecha requerida
5️⃣ Adjunta observaciones si es necesario
6️⃣ Guarda la requisicion

✅ La requisicion quedara pendiente de autorizacion.

🏢 **Para autorizar una requisicion:**
1️⃣ Ve a COMPRAS → REQUISICIONES
2️⃣ Busca las pendientes de autorizacion
3️⃣ Revisa los detalles
4️⃣ Haz clic en AUTORIZAR o RECHAZAR

✨ Las requisiciones autorizadas se convierten automaticamente en ordenes de compra.";
        }
        
        // Autorizar compra
        if (str_contains($questionLower, 'autorizo') || str_contains($questionLower, 'autorizar compra') || 
            str_contains($questionLower, 'aprobar compra') || str_contains($questionLower, 'autorizar requisicion')) {
            return "✅ **AUTORIZAR UNA COMPRA**

Para autorizar una requisicion:

1️⃣ Ve a COMPRAS → REQUISICIONES
2️⃣ Filtra por 'Pendientes de Autorizacion'
3️⃣ Selecciona la requisicion que deseas revisar
4️⃣ Revisa los detalles:
   - Articulos solicitados
   - Cantidades
   - Justificacion
5️⃣ Toma una decision:
   - AUTORIZAR → La requisicion pasa a orden de compra
   - RECHAZAR → Se notifica al solicitante

✅ Una vez autorizada, el sistema genera automaticamente la orden de compra.

👥 Nota: Solo usuarios con rol de autorizador pueden hacer esto.";
        }
        
        // Compras general
        if (str_contains($questionLower, 'compra') || str_contains($questionLower, 'orden de compra')) {
            return "🛒 **COMPRAS**

1️⃣ Ve a COMPRAS
2️⃣ Selecciona REQUISICIONES
3️⃣ Presiona NUEVO
4️⃣ Completa los datos del proveedor y articulos
5️⃣ Guarda

✅ Las requisiciones aprobadas se convierten en ordenes.";
        }
        
        // Asistencia
        if (str_contains($questionLower, 'asistencia') || str_contains($questionLower, 'marcar entrada') || 
            str_contains($questionLower, 'registrar asistencia')) {
            return "👥 **COMO REGISTRAR ASISTENCIA**

Para registrar asistencia:

1️⃣ Ve a RRHH → ASISTENCIA
2️⃣ Selecciona REGISTRAR ENTRADA
3️⃣ Elige el empleado
4️⃣ Marca la hora de entrada
5️⃣ Guarda

✅ El registro quedara guardado en el sistema.";
        }
        
        // Ingresos / Depositos
        if (str_contains($questionLower, 'ingreso') || str_contains($questionLower, 'deposito') || 
            str_contains($questionLower, 'registrar ingreso')) {
            return "💰 **COMO REGISTRAR UN INGRESO**

Para registrar un ingreso:

1️⃣ Ve a ADMINISTRACION → TESORERIA
2️⃣ Selecciona DEPOSITOS
3️⃣ Presiona NUEVO REGISTRO
4️⃣ Completa los datos:
   - Cuenta bancaria destino
   - Monto del ingreso
   - Concepto (ej: Pago cliente)
   - Cliente (opcional)
   - Fecha
5️⃣ Adjunta comprobante (opcional)
6️⃣ Guarda

✅ El ingreso se reflejara en el saldo de la cuenta.

📂 Formulario: administracion/tesoreria/depositos.blade.php";
        }
        
        // Nomina
        if (str_contains($questionLower, 'nomina') || str_contains($questionLower, 'nómina') || 
            str_contains($questionLower, 'calcular nomina')) {
            return "💰 **NOMINA**

Para gestionar nominas:

1️⃣ Ve a RRHH → NOMINA
2️⃣ Selecciona CALCULO DE NOMINA
3️⃣ Elige el periodo
4️⃣ Calcula y revisa
5️⃣ Genera recibos

✅ Puedes exportar a Excel con el boton Exportar.";
        }
        
        return null;
    }
    
    /**
     * Llama a la API de Mistral
     */
    private function callMistral($question)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, [
                'model' => 'mistral-tiny',
                'messages' => [
                    ['role' => 'system', 'content' => 'Eres un asistente guia de un sistema ERP. Responde paso a paso. Maximo 600 caracteres.'],
                    ['role' => 'user', 'content' => $question]
                ],
                'max_tokens' => 600,
                'temperature' => 0.7,
            ]);
            
            if ($response->successful()) {
                return $response->json()['choices'][0]['message']['content'];
            }
            
            return null;
            
        } catch (\Exception $e) {
            \Log::error("Mistral error: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Respuesta de ayuda
     */
    private function getHelpfulResponse($question)
    {
        return "🤖 **Que necesitas hacer?**

Puedo ayudarte con:

📦 **Almacen**
- Entradas de almacen
- Salidas de almacen
- Inventario

📋 **Administracion**
- Facturacion
- CFDI
- Tesoreria
- Depositos

🏗️ **Proyectos**
- Alta de proyectos
- Gestion de proyectos
- Presupuestos

👥 **RRHH**
- Registrar asistencia
- Nomina
- Personal

🛒 **Compras**
- Crear requisiciones
- Autorizar compras
- Ordenes de compra

❓ **Ejemplos de preguntas:**
- 'como registro una entrada de almacen'
- 'como creo una requisicion'
- 'como autorizo una compra'
- 'como registro un ingreso'
- 'como marco asistencia'";
    }
    
    /**
     * Consulta a Mistral directamente SIN usar cache ni conocimiento local
     */
    public function askDirect($question, $systemPrompt = null)
    {
        try {
            $defaultSystemPrompt = $systemPrompt ?: "Eres un asistente util. Responde de manera clara y concisa.";
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->apiUrl, [
                'model' => 'mistral-tiny',
                'messages' => [
                    ['role' => 'system', 'content' => $defaultSystemPrompt],
                    ['role' => 'user', 'content' => $question]
                ],
                'max_tokens' => 800,
                'temperature' => 0.7,
            ]);
            
            if ($response->successful()) {
                return trim($response->json()['choices'][0]['message']['content']);
            }
            
            \Log::error('Mistral API error: ' . $response->body());
            return null;
            
        } catch (\Exception $e) {
            \Log::error('Mistral exception: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Generar mapa del sistema forzando consulta a Mistral
     */
    public function generateSystemMap()
    {
        $prompt = "Eres un arquitecto de software. Genera un mapa de sistema ERP para USUARIOS finales.

DATOS del sistema:
- Nombre: ERP Constructora MejoraSoft
- Modulos: Administracion, Proyectos, Contabilidad, RRHH, Inventarios, Compras, Chat, BI

INSTRUCCIONES:
1. El mapa debe ser entendible por usuarios NO tecnicos
2. Usa emojis: 🏠 📊 📋 👥 🏗️ 💬 📦 🛒
3. Muestra la JERARQUIA DE NAVEGACION
4. Maximo 800 caracteres

AHORA GENERA EL MAPA DE NAVEGACION:";

        return $this->askDirect($prompt, "Eres un generador de mapas de navegacion. Responde SOLO con el mapa.");
    }
}