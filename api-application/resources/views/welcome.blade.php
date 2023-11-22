<!DOCTYPE html>
<html>
<head>
    <title>OpenAPI Documentation</title>
    <link rel="stylesheet" href="{{asset('swagger-ui.css')}}">
    <link rel="shortcut icon" href="{{asset('logo.png')}}" type="image/x-icon">
</head>
<body>
    <div id="swagger-ui"></div>

    <script src="{{asset('swagger-ui-bundle.js')}}"></script>
    <script>
        window.onload = function() {
            const ui = SwaggerUIBundle({
                url: "openapi-posyandu-melati.yml",
                dom_id: "#swagger-ui",
            });
        }
    </script>
</body>
</html>
