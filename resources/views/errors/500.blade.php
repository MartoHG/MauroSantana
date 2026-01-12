<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Error del Servidor - Mauro Santana</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Montserrat', sans-serif; }</style>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="text-center px-6">
        <div class="mb-8">
            <svg class="w-24 h-24 text-yellow-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>

        <h1 class="text-5xl font-black text-gray-800 mb-2">Algo salió mal</h1>
        <p class="text-xl text-gray-500 mb-6">Error 500 - Problema Interno</p>
        
        <p class="text-gray-600 mb-8 max-w-md mx-auto">
            Hubo un problema técnico al procesar tu solicitud. Nuestro equipo ya ha sido notificado.
            Por favor, intenta recargar la página o vuelve en unos minutos.
        </p>

        <div class="flex justify-center gap-4">
            <a href="{{ url('/') }}" class="bg-blue-500 text-white font-bold py-3 px-6 rounded-lg hover:bg-blue-600 transition">
                Ir al Inicio
            </a>
            <button onclick="location.reload()" class="bg-gray-200 text-gray-700 font-bold py-3 px-6 rounded-lg hover:bg-gray-300 transition">
                Recargar
            </button>
        </div>
    </div>

</body>
</html>