<article class="w-80 md:w-96 flex-shrink-0 bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition duration-300 transform hover:-translate-y-2 flex flex-col border border-gray-100 h-[450px]">
    
    <div class="h-48 w-full relative overflow-hidden group bg-gray-100">
        @if($project->imagen_path)
            <img src="{{ asset('storage/' . $project->imagen_path) }}" alt="{{ $project->titulo }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
            </div>
        @endif

        <div class="absolute top-4 right-4">
            @if($project->tipo == 'Ordenanza')
                <span class="bg-purple-600 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm uppercase tracking-wider">
                    Ordenanza
                </span>
            @else
                <span class="bg-mauro-yellow text-gray-900 text-xs font-bold px-3 py-1.5 rounded-lg shadow-sm uppercase tracking-wider">
                    Proyecto
                </span>
            @endif
        </div>
    </div>

    <div class="p-6 flex-1 flex flex-col">
        <div class="flex justify-between items-center mb-4">
            <span class="text-xs font-bold text-mauro-blue uppercase bg-blue-50 px-2 py-1 rounded">
                {{ $project->categoria }}
            </span>
            <span class="text-xs text-gray-400 font-semibold">
                {{ \Carbon\Carbon::parse($project->fecha)->format('d/m/Y') }}
            </span>
        </div>

        <h3 class="text-xl font-extrabold text-gray-900 mb-4 leading-snug flex-1 line-clamp-3">
            {{ $project->titulo }}
        </h3>

        <div class="pt-4 mt-auto border-t border-gray-100 flex items-center justify-between">
            <a href="{{ asset('storage/' . $project->pdf_path) }}" target="_blank" class="flex items-center text-gray-700 hover:text-mauro-blue font-bold transition group text-sm">
                Leer Documento
                <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>

            @if($project->qr_path)
            <a href="{{ asset('storage/' . $project->qr_path) }}" download class="text-gray-300 hover:text-gray-600 transition" title="Descargar QR">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            </a>
            @endif
        </div>
    </div>
</article>