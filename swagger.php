<?php

use OpenApi\Generator;

require_once __DIR__ . '/vendor/autoload.php';

// Generar la documentación
$openapi = Generator::scan([__DIR__ . '/app/Http/Controllers']);
header('Content-Type: application/json');
echo $openapi->toJson();
