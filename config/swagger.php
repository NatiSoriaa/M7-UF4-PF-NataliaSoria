<?php
return [
    'api' => [
        'title' => 'API de Productos',
        'version' => '1.0.0',
        'description' => 'Documentación de la API de Productos',
    ],
    'paths' => [
        'docs' => storage_path('api-docs'), // Carpeta donde se generará el archivo JSON
        'annotations' => base_path('app'), // Carpeta donde buscará las anotaciones
    ],
];