<div class="rounded-2xl p-6 shadow {{ $bg }}">
    <h2 class="text-xs uppercase tracking-wide {{ $label }}">
        {{ $title }}
    </h2>

    <p class="mt-3 text-4xl font-bold {{ $valueColor }}">
        {{ $value }}
    </p>

    @isset($hint)
        <p class="text-xs mt-1 opacity-80">
            {{ $hint }}
        </p>
    @endisset
</div>
