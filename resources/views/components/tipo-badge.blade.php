@props(['tipo'])

<span @class([
    'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold',
    'bg-mauro-blue-light text-mauro-blue-dark' => $tipo === 'Proyecto',
    'bg-mauro-yellow/15 text-mauro-yellow-dark' => $tipo !== 'Proyecto',
])>{{ $tipo }}</span>
