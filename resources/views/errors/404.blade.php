<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Página no encontrada - Mauro Santana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Montserrat', sans-serif; }</style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="text-center px-6">
        <div class="mb-8">
            <svg class="w-24 h-24 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>

        <h1 class="text-6xl font-black text-blue-500 mb-4">404</h1>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">¡Ups! No encontramos esa página.</h2>
        <p class="text-gray-600 mb-8 max-w-md mx-auto">Parece que la dirección que buscas no existe o fue movida. No te preocupes, puedes volver al inicio.</p>

        <a href="{{ url('/') }}" class="inline-block bg-blue-500 text-white font-bold py-3 px-8 rounded-full hover:bg-blue-600 transition shadow-lg transform hover:-translate-y-1">
            Volver al Inicio
        </a>
    </div>

</body>
</html>