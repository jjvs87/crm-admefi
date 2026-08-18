<x-filament-panels::page>
    <x-filament::section heading="Configurar mi correo">
        <form wire:submit="saveSettings">
            {{ $this->settingsForm }}
            <div class="mt-4">
                <x-filament::button type="submit">
                    Guardar y probar conexion
                </x-filament::button>
            </div>
        </form>
        @if ($connectionError)
            <p class="text-danger-600 text-sm mt-2">Error: {{ $connectionError }}</p>
        @endif
    </x-filament::section>
</x-filament-panels::page>