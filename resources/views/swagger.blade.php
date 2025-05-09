<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swagger UI</title>
    <link rel="stylesheet" href="/vendor/swagger-api/swagger-ui/dist/swagger-ui.css">
</head>
<body>
    <div id="swagger-ui"></div>
    <script src="/vendor/swagger-api/swagger-ui/dist/swagger-ui-bundle.js"></script>
    <script src="/vendor/swagger-api/swagger-ui/dist/swagger-ui-standalone-preset.js"></script>
    <script>
        window.onload = () => {
            const ui = SwaggerUIBundle({
                url: "/api/documentation", // Ruta al archivo JSON generado por Swagger
                dom_id: '#swagger-ui',
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                layout: "StandaloneLayout"
            });
            window.ui = ui;
        };
    </script>
</body>
</html>