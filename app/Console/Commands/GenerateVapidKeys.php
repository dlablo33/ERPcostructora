<?php
// app/Console/Commands/GenerateVapidKeys.php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Minishlink\WebPush\VAPID;

class GenerateVapidKeys extends Command
{
    protected $signature = 'vapid:generate';
    protected $description = 'Generate VAPID keys for Web Push Notifications';

    public function handle()
    {
        $this->info('Generating VAPID keys...');
        
        $keys = VAPID::createVapidKeys();
        
        $this->info('✅ VAPID keys generated successfully!');
        $this->newLine();
        $this->info('Add these to your .env file:');
        $this->newLine();
        $this->line('VAPID_PUBLIC_KEY=' . $keys['publicKey']);
        $this->line('VAPID_PRIVATE_KEY=' . $keys['privateKey']);
        $this->line('VAPID_SUBJECT=mailto:tu-email@ejemplo.com');
        $this->newLine();
        
        // Guardar en un archivo temporal por si acaso
        $file = storage_path('vapid_keys.txt');
        file_put_contents($file, 
            "VAPID_PUBLIC_KEY=" . $keys['publicKey'] . "\n" .
            "VAPID_PRIVATE_KEY=" . $keys['privateKey'] . "\n" .
            "VAPID_SUBJECT=mailto:tu-email@ejemplo.com\n"
        );
        $this->info("✅ Keys also saved to: $file");
        
        return 0;
    }
}