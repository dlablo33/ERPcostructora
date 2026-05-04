<?php
// app/Console/Commands/IALearnFromCode.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\IACodeAnalyzer;

class IALearnFromCode extends Command
{
    protected $signature = 'ia:learn';
    protected $description = 'IA aprende la estructura del código';
    
    public function handle(IACodeAnalyzer $analyzer)
    {
        $this->info('🤖 Analizando ChatController...');
        
        $synced = $analyzer->syncToDatabase('App\Http\Controllers\ChatController');
        
        $this->info("✅ Aprendidos {$synced} conceptos nuevos");
        $this->info('🎉 IA lista para responder preguntas!');
    }
}