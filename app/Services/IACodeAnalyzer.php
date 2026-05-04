<?php
// app/Services/IACodeAnalyzer.php

namespace App\Services;

use ReflectionClass;
use ReflectionMethod;
use App\Models\IAKnowledgeBase;

class IACodeAnalyzer
{
    public function analyzeController($controllerClass)
    {
        try {
            $reflection = new ReflectionClass($controllerClass);
            $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
            
            $map = [];
            foreach ($methods as $method) {
                if ($method->isConstructor() || str_starts_with($method->getName(), '__')) {
                    continue;
                }
                
                $docComment = $method->getDocComment();
                $description = $this->extractDescription($docComment);
                
                $map[] = [
                    'method_name' => $method->getName(),
                    'description' => $description ?: $this->generateDescriptionFromName($method->getName()),
                    'parameters' => array_map(fn($p) => $p->getName(), $method->getParameters()),
                    'class' => $controllerClass,
                ];
            }
            
            return $map;
        } catch (\Exception $e) {
            \Log::error("Error analyzing controller: " . $e->getMessage());
            return [];
        }
    }
    
    private function extractDescription($docComment)
    {
        if (!$docComment) return null;
        preg_match('/\*\s*(.+?)(?:\n|\*\/)/', $docComment, $matches);
        return $matches[1] ?? null;
    }
    
    private function generateDescriptionFromName($methodName)
    {
        $descriptions = [
            'getUsers' => 'Obtiene lista de usuarios con contador de mensajes no leídos',
            'getMessages' => 'Obtiene historial de mensajes de una conversación',
            'sendMessage' => 'Envía un mensaje a otro usuario',
            'markAsRead' => 'Marca mensajes como leídos',
            'getTotalUnreadCount' => 'Obtiene total de mensajes no leídos',
            'getConversations' => 'Obtiene resumen de últimas conversaciones',
        ];
        
        return $descriptions[$methodName] ?? "Método {$methodName} del sistema";
    }
    
    public function syncToDatabase($controllerClass)
    {
        $methods = $this->analyzeController($controllerClass);
        $count = 0;
        
        foreach ($methods as $method) {
            $keywords = $this->generateKeywords($method['method_name']);
            
            foreach ($keywords as $keyword) {
                IAKnowledgeBase::updateOrCreate(
                    ['keyword' => $keyword, 'method_name' => $method['method_name']],
                    [
                        'module_name' => $this->detectModule($method['method_name']),
                        'response_text' => $method['description'],
                        'controller_class' => $method['class'],
                        'confidence_score' => 80,
                    ]
                );
                $count++;
            }
        }
        
        return $count;
    }
    
    private function generateKeywords($methodName)
    {
        $map = [
            'getUsers' => ['usuarios', 'contactos', 'lista usuarios', 'cómo ver usuarios'],
            'getMessages' => ['mensajes', 'historial', 'ver mensajes', 'conversación'],
            'sendMessage' => ['enviar', 'mensaje', 'escribir mensaje', 'mandar'],
            'markAsRead' => ['leer', 'leídos', 'marcar leído', 'visto'],
            'getTotalUnreadCount' => ['no leídos', 'pendientes', 'mensajes nuevos', 'contador'],
            'getConversations' => ['conversaciones', 'chats', 'últimos chats', 'dialogos'],
        ];
        
        return $map[$methodName] ?? [strtolower($methodName)];
    }
    
    private function detectModule($methodName)
    {
        if (str_contains($methodName, 'User')) return 'Usuarios';
        if (str_contains($methodName, 'Message')) return 'Mensajes';
        if (str_contains($methodName, 'Conversation')) return 'Conversaciones';
        if (str_contains($methodName, 'Read') || str_contains($methodName, 'Unread')) return 'Lectura';
        return 'General';
    }
}