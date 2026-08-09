@php
    $iconSize = match($iconSize) {
        \Filament\Support\Enums\IconSize::Small => 'w-8 h-8',
        \Filament\Support\Enums\IconSize::Medium => 'w-12 h-12',
        \Filament\Support\Enums\IconSize::Large => 'w-16 h-16',
        default => 'w-12 h-12'
    };
@endphp
<x-filament-panels::page>
    <div>
        @foreach($cards as $groupName => $items)
            @php
                $canCollapse = $canBeCollapsed($groupName);
            @endphp
            <div x-data="{ collapsed: {{ $isCollapsed($groupName) ? 'true' : 'false' }} }">
                <h4 @if ($canCollapse) @@click="collapsed = ! collapsed" @endif
                    @class([
                        'cursor-default' => ! $canCollapse,
                        'cursor-pointer' => $canCollapse,
                        'text-sm flex items-center tracking-wide text-gray-500 dark:text-gray-400 mb-3 filament-header-heading'
                    ])
                >
                    @if (filled($groupName))
                        @if ($canCollapse)
                            <x-icon x-show="! collapsed" name="heroicon-o-chevron-down" class="w-3 h-3 me-2"></x-icon>
                            <x-icon x-show="collapsed" name="heroicon-o-chevron-right" class="w-3 h-3 me-2"></x-icon>
                        @endif
                        {{ $groupName }}
                    @endif
                </h4>
                <div x-show="! collapsed" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-6">
                @foreach($items as $item)
                    <a href="{{ $item->getUrl() }}" @if($item->shouldOpenInNewTab()) target="_blank"@elseif(\Filament\Support\Facades\FilamentView::hasSpaMode($item->getUrl())) wire:navigate @endif @class([
                        'group relative flex flex-col gap-2 p-4 overflow-hidden rounded-xl bg-white text-gray-700 shadow-sm ring-1 ring-gray-950/5',
                        'dark:text-gray-200 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10',
                        'items-start' => $alignment === $alignmentEnum::Start,
                        'items-center' => $alignment === $alignmentEnum::Center,
                        'items-end' => $alignment === $alignmentEnum::End,
                    ])>
                        @if ($item->shouldOpenInNewTab())
                        <x-icon name="heroicon-s-arrow-top-right-on-square" @class([
                            'absolute w-4 h-4 top-3',
                            'right-3' => $alignment != $alignmentEnum::End,
                            'left-3' => $alignment == $alignmentEnum::End
                        ]) />
                        @endif

                        <div @class([
                            'flex gap-2',
                            'items-start' => ! $isIconInlined && $alignment === $alignmentEnum::Start,
                            'items-center' => $isIconInlined || (! $isIconInlined && $alignment === $alignmentEnum::Center),
                            'items-end' => ! $isIconInlined && $alignment === $alignmentEnum::End,
                            'flex-row' => $isIconInlined && $alignment !== $alignmentEnum::End,
                            'flex-row-reverse' => $isIconInlined && $alignment === $alignmentEnum::End,
                            'flex-col' => ! $isIconInlined
                        ])>
                            @if(filled($item->getIcon()))
                                <x-icon name="{{ $item->getIcon() }}" class="{{ $iconSize }} group-hover:text-primary-600" />
                            @endif
                            <h5 @class([
                                'font-semibold',
                                'text-start' => $alignment === $alignmentEnum::Start,
                                'text-center' => $alignment === $alignmentEnum::Center,
                                'text-end' => $alignment === $alignmentEnum::End,
                            ])>{{ $item->getTitle() }}</h5>
                        </div>
                        @if(filled($item->getDescription()))
                            <p @class([
                                'text-xs',
                                'text-start' => $alignment === $alignmentEnum::Start,
                                'text-center' => $alignment === $alignmentEnum::Center,
                                'text-end' => $alignment === $alignmentEnum::End
                            ])>{{ $item->getDescription() }}</p>
                        @endif
                    </a>
                @endforeach
                </div>
            </div>
        @endforeach
    </div>
</x-filament-panels::page>
