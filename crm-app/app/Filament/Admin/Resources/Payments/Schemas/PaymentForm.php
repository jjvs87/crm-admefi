<?php
namespace App\Filament\Admin\Resources\Payments\Schemas;
use App\Models\Client;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('client_id')
                    ->label('Cliente')
                    ->searchable()
                    ->preload()
                    ->getSearchResultsUsing(function (string $search) {
                        return Client::query()
                            ->whereHas('lead', fn ($q) => $q->where('name', 'like', "%{$search}%"))
                            ->orWhere('product', 'like', "%{$search}%")
                            ->limit(50)
                            ->get()
                            ->mapWithKeys(fn ($c) => [$c->id => ($c->lead?->name ?? 'Sin lead') . ' - ' . ($c->product ?? 'Sin producto')]);
                    })
                    ->getOptionLabelUsing(function ($value) {
                        $c = Client::find($value);
                        return $c ? ($c->lead?->name ?? 'Sin lead') . ' - ' . ($c->product ?? 'Sin producto') : null;
                    })
                    ->required(),
                TextInput::make('amount')->label('Monto')->numeric()->prefix('$')->required(),
                DatePicker::make('payment_date')->label('Fecha de pago')->required(),
                TextInput::make('method')->label('Metodo de pago'),
                Select::make('status')
                    ->label('Estatus')
                    ->options(['pagado' => 'Pagado', 'pendiente' => 'Pendiente', 'vencido' => 'Vencido'])
                    ->default('pagado')->required(),
            ]);
    }
}