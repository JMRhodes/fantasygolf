<div @class('fi-ta-text grid w-full gap-y-1 px-3 py-4')>
    <p
        @class([
            'font-semibold text-sm text-gray-900',
        ])
    >
    {{ $getState() }}
    </p>
    <div @class('text-xs text-gray-500')>
        {{ $getRecord()->owner->name }}
    </div>
</div>
