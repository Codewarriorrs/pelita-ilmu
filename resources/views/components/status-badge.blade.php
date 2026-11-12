@props(['status'])

@php
    $normalized = strtoupper(trim((string) $status));
    $classes = match (true) {
        str_contains($normalized, 'TERIMA') => 'bg-emerald-100 text-emerald-800 border-emerald-300',
        str_contains($normalized, 'HUBUNG') => 'bg-blue-100 text-blue-800 border-blue-300',
        str_contains($normalized, 'BARU') => 'bg-amber-100 text-amber-800 border-amber-300',
        default => 'bg-gray-100 text-gray-800 border-gray-300',
    };
    $label = match (true) {
        str_contains($normalized, 'TERIMA') => 'DITERIMA',
        str_contains($normalized, 'HUBUNG') => 'DIHUBUNGI',
        str_contains($normalized, 'BARU') => 'BARU MASUK',
        default => $status ?: '-',
    };
@endphp

<span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-bold border tracking-wide whitespace-nowrap {{ $classes }}">
    {{ $label }}
</span>

