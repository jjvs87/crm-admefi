<x-filament-panels::page>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <x-filament::section>
            <x-slot name="heading">Que canal genera mas clientes</x-slot>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2">Canal</th>
                        <th class="py-2">Clientes</th>
                        <th class="py-2">Ingresos</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($porCanal as $row)
                        <tr class="border-b">
                            <td class="py-2">{{ $row['canal'] ?? 'Sin fuente' }}</td>
                            <td class="py-2">{{ $row['clientes'] }}</td>
                            <td class="py-2">${{ number_format($row['ingresos'] ?? 0, 0) }}</td>
                        </tr>
                    @empty
                        <tr><td class="py-2" colspan="3">Sin datos todavia.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">Que Hunter agenda mas reuniones</x-slot>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2">Hunter</th>
                        <th class="py-2">Reuniones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($porHunter as $row)
                        <tr class="border-b">
                            <td class="py-2">{{ $row['hunter'] }}</td>
                            <td class="py-2">{{ $row['reuniones'] }}</td>
                        </tr>
                    @empty
                        <tr><td class="py-2" colspan="2">Sin datos todavia.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">Que Closer convierte mejor</x-slot>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2">Closer</th>
                        <th class="py-2">Oportunidades</th>
                        <th class="py-2">Ganadas</th>
                        <th class="py-2">Conversion</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($porCloser as $row)
                        <tr class="border-b">
                            <td class="py-2">{{ $row['closer'] }}</td>
                            <td class="py-2">{{ $row['total'] }}</td>
                            <td class="py-2">{{ $row['ganadas'] }}</td>
                            <td class="py-2">{{ $row['conversion'] }}%</td>
                        </tr>
                    @empty
                        <tr><td class="py-2" colspan="4">Sin datos todavia.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">Ciclo promedio de venta</x-slot>
            <p class="text-3xl font-bold">
                {{ $cicloVentaPromedio ? round($cicloVentaPromedio) . ' dias' : 'Sin datos todavia' }}
            </p>
            <p class="text-sm text-gray-500">Desde que se crea el Lead hasta que se convierte en Cliente.</p>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">Que industria compra mas</x-slot>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2">Industria</th>
                        <th class="py-2">Clientes</th>
                        <th class="py-2">Ingresos</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($porIndustria as $row)
                        <tr class="border-b">
                            <td class="py-2">{{ $row['industria'] ?? 'Sin dato' }}</td>
                            <td class="py-2">{{ $row['clientes'] }}</td>
                            <td class="py-2">${{ number_format($row['ingresos'] ?? 0, 0) }}</td>
                        </tr>
                    @empty
                        <tr><td class="py-2" colspan="3">Sin datos todavia.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </x-filament::section>

        <x-filament::section>
            <x-slot name="heading">Que producto se vende mas</x-slot>
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left border-b">
                        <th class="py-2">Producto</th>
                        <th class="py-2">Clientes</th>
                        <th class="py-2">Ingresos</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($porProducto as $row)
                        <tr class="border-b">
                            <td class="py-2">{{ $row['producto'] ?? 'Sin producto' }}</td>
                            <td class="py-2">{{ $row['clientes'] }}</td>
                            <td class="py-2">${{ number_format($row['ingresos'] ?? 0, 0) }}</td>
                        </tr>
                    @empty
                        <tr><td class="py-2" colspan="3">Sin datos todavia.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </x-filament::section>

    </div>
</x-filament-panels::page>