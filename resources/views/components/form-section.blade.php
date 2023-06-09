@props(['submit'])

<div {{ $attributes->merge(['class' => 'row']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="col-md-8">
        <div
            class="card shadow-sm">
            <form wire:submit.prevent="{{ $submit }}">
                <div class="card-body">
                    {{ $form }}
                </div>

                @if (isset($actions))
                    <div
                        class="card-footer d-flex justify-content-end">
                        {{ $actions }}
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
