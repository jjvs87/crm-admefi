<x-filament-panels::page>
    <div class="space-y-6">

        @if (! auth()->user()->hasMailConfigured())
            <x-filament::section>
                <p>No has configurado tu cuenta de correo todavia. Ve a "Configuracion de correo" en el menu para conectarla.</p>
            </x-filament::section>
        @else

            <x-filament::section heading="Bandeja de entrada">
                <div class="flex justify-end gap-2 mb-4">
                    <x-filament::button wire:click="loadInbox" color="gray" size="sm">
                        Actualizar
                    </x-filament::button>
                    <x-filament::button wire:click="openCompose" size="sm">
                        Redactar
                    </x-filament::button>
                </div>

                @if ($connectionError)
                    <p class="text-danger-600 text-sm mb-4">Error: {{ $connectionError }}</p>
                @endif

                <div class="space-y-2">
                    @forelse ($messages as $message)
                        <details class="border rounded-lg p-3">
                            <summary class="cursor-pointer font-medium">
                                {{ $message['subject'] }} <span class="text-gray-500 text-sm font-normal">- {{ $message['from'] }} - {{ $message['date'] }}</span>
                            </summary>
                            <div class="mt-3 flex gap-2">
                                <x-filament::button wire:click="replyTo('{{ $message['id'] }}')" size="xs" color="gray">
                                    Responder
                                </x-filament::button>
                                <x-filament::button
                                    wire:click="deleteMessage('{{ $message['id'] }}')"
                                    wire:confirm="Seguro que quieres eliminar este correo?"
                                    size="xs"
                                    color="danger"
                                >
                                    Eliminar
                                </x-filament::button>
                            </div>
                            <div class="mt-3">
                                <iframe
                                    srcdoc="{{ $message['body'] }}"
                                    sandbox=""
                                    loading="lazy"
                                    style="width:100%; height:350px; border:1px solid #333; border-radius:8px; background:white;"
                                ></iframe>
                            </div>
                        </details>
                    @empty
                        <p class="text-gray-500 text-sm">Sin mensajes todavia.</p>
                    @endforelse
                </div>
            </x-filament::section>

            @if ($showCompose)
                <x-filament::section heading="Redactar correo">
                    <form wire:submit="sendMail">
                        {{ $this->composeForm }}
                        <div class="mt-4 flex gap-2">
                            <x-filament::button type="submit">
                                Enviar
                            </x-filament::button>
                            <x-filament::button type="button" color="gray" wire:click="$set('showCompose', false)">
                                Cancelar
                            </x-filament::button>
                        </div>
                    </form>
                </x-filament::section>
            @endif

        @endif

    </div>
</x-filament-panels::page>