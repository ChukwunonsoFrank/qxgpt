@props(['title', 'description'])

<div class="flex w-full flex-col text-center">
    <flux:heading class="font-semibold text-3xl tracking-tight text-white" size="xl">{{ $title }}
    </flux:heading>
    <flux:subheading class="text-xs text-white font-medium">{{ $description }}</flux:subheading>
</div>
