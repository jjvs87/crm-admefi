<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; }
        .header { width: 100%; margin-bottom: 20px; }
        .header td { vertical-align: top; }
        .company-name { font-size: 20px; font-weight: bold; color: #0070b5; }
        .title { font-size: 22px; font-weight: bold; color: #00548d; text-align: right; }
        .meta { text-align: right; font-size: 11px; color: #4b5563; }
        table.items { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table.items th { background: #0070b5; color: #fff; padding: 8px; text-align: left; font-size: 11px; }
        table.items td { padding: 8px; border-bottom: 1px solid #e5e7eb; font-size: 11px; }
        table.totals { width: 100%; margin-top: 10px; }
        table.totals td { padding: 4px 8px; font-size: 12px; }
        .totals .label { text-align: right; color: #4b5563; }
        .totals .value { text-align: right; width: 120px; }
        .grand-total { font-weight: bold; font-size: 14px; color: #00548d; border-top: 2px solid #0070b5; }
        .notes { margin-top: 30px; font-size: 11px; color: #4b5563; }
    </style>
</head>
<body>
    <table class="header">
        <tr>
            <td class="company-name">Admefi CRM</td>
            <td class="title">COTIZACION</td>
        </tr>
        <tr>
            <td></td>
            <td class="meta">
                No. {{ $quote->quote_number }}<br>
                Fecha: {{ $quote->created_at->format('d/m/Y') }}<br>
                @if($quote->valid_until)
                    Valida hasta: {{ $quote->valid_until->format('d/m/Y') }}<br>
                @endif
                Estado: {{ ucfirst($quote->status) }}
            </td>
        </tr>
    </table>

    <p>
        <strong>Cliente:</strong>
        {{ $quote->client?->lead?->name ?? $quote->lead?->name ?? 'N/A' }}<br>
        @if($quote->client?->lead?->company ?? $quote->lead?->company ?? null)
            {{ $quote->client?->lead?->company ?? $quote->lead?->company }}<br>
        @endif
        @if($quote->client?->lead?->email ?? $quote->lead?->email ?? null)
            {{ $quote->client?->lead?->email ?? $quote->lead?->email }}
        @endif
    </p>

    <table class="items">
        <thead>
            <tr>
                <th>Descripcion</th>
                <th>Cantidad</th>
                <th>Precio unitario</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quote->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ number_format($item->quantity, 2) }}</td>
                    <td>${{ number_format($item->unit_price, 2) }}</td>
                    <td>${{ number_format($item->subtotal, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td class="label">Subtotal:</td>
            <td class="value">${{ number_format($quote->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Impuesto ({{ number_format($quote->tax_rate, 2) }}%):</td>
            <td class="value">${{ number_format($quote->tax_amount, 2) }}</td>
        </tr>
        <tr class="grand-total">
            <td class="label">Total:</td>
            <td class="value">${{ number_format($quote->total, 2) }}</td>
        </tr>
    </table>

    @if($quote->notes)
        <div class="notes">
            <strong>Notas:</strong><br>
            {{ $quote->notes }}
        </div>
    @endif
</body>
</html>