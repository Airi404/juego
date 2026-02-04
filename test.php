<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Gemini as GeminiNative; 
use GuzzleHttp\Client as GuzzleClient;

try {
    // Saltamos SSL para evitar el error de certificado local
    $httpClient = new GuzzleClient(['verify' => false]);

    $client = GeminiNative::factory()
        ->withApiKey(env('GEMINI_API_KEY')) 
        ->withHttpClient($httpClient)
        ->make();

    // El nombre exacto para la versión 2.0 en este momento es este:
    $modelName = 'gemini-2.0-flash-exp'; 

    $result = $client->generativeModel(model: $modelName)->generateContent("Hola, estoy probando el modelo 2.0");

    echo "\n--- TEST EXITOSO ---";
    echo "\nModelo solicitado: " . $modelName;
    echo "\nRespuesta de la IA: " . $result->text() . "\n";

} catch (\Exception $e) {
    echo "\nEl modelo 2.0-flash-exp falló. Intentando con el modelo estable 1.5-flash...";
    
    try {
        // Backup: Este modelo siempre está disponible
        $result = $client->generativeModel(model: 'gemini-2.5-flash')->generateContent("Hola desde el backup");
        echo "\nRespuesta de la IA (2.5-flash): " . $result->text() . "\n";
    } catch (\Exception $e2) {
        echo "\nError final: " . $e2->getMessage() . "\n";
    }
}