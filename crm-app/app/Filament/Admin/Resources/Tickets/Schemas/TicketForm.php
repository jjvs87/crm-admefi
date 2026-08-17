<?php
namespace App\Filament\Admin\Resources\Tickets\Schemas;
use App\Models\Client;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TicketForm
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
                TextInput::make('subject')->label('Asunto')->required(),
                Textarea::make('description')->label('Descripcion')->columnSpanFull(),
                Select::make('status')
                    ->label('Estatus')
                    ->options(['abierto' => 'Abierto', 'en_proceso' => 'En proceso', 'cerrado' => 'Cerrado'])
                    ->default('abierto')
                    ->required(),
            ]);
    }
}