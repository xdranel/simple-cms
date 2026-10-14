@props([
    'style' => '',
    'padding' => 'p-6',
    'hover' => true,
    'tag' => 'div',
])

<{{ $tag }}
{{ $attributes->merge([
    'class' => 'group overflow-hidden rounded-2xl border border-slate-200
                bg-white transition-all duration-300'
                . ($hover ? ' hover:-translate-y-1 hover:shadow-xl hover:shadow-slate-200/60' : '')
                . ' ' . $padding
                . ' ' . $style
]) }}
>
{{ $slot }}
</{{ $tag }}>
