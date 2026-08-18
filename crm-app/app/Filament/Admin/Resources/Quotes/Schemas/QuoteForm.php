<?php

namespace App\Filament\Admin\Resources\Quotes\Schemas;

use App\Models\Client;
use App\Models\Lead;
use App\Models\Opportunity;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class QuoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')->default(fn () => auth()->id()),

                Select::make('status')
                    ->label('Estado')
                    ->options([
                        'borrador' => 'Borrador',
                        'enviada' => 'Enviada',
                        'aceptada' => 'Aceptada',
                        'rechazada' => 'Rechazada',
                        'expirada' => 'Expirada',
                    ])
                    ->default('borrador')
                    ->required(),

                DatePicker::make('valid_until')
                    ->label('Valida hasta'),

                Select::make('lead_id')
                    ->label('Lead')
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $search) => Lead::where('name', 'like', "%{$search}%")->limit(20)->pluck('name', 'id'))
                    ->getOptionLabelUsing(fn ($value) => Lead::find($value)?->name),

                Select::make('client_id')
                    ->label('Cliente')
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $search) => Client::whereHas('lead', fn ($q) => $q->where('name', 'like', "%{$search}%"))->limit(20)->get()->mapWithKeys(fn ($client) => [$client->id => $client->lead?->name ?? ('Cliente #'.$client->id)]))
                    ->getOptionLabelUsing(fn ($value) => Client::find($value)?->lead?->name ?? ('Cliente #'.$value)),

                Select::make('opportunity_id')
                    ->label('Oportunidad')
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $search) => Opportunity::whereHas('lead', fn ($q) => $q->where('name', 'like', "%{$search}%"))->limit(20)->get()->mapWithKeys(fn ($o) => [$o->id => ($o->lead?->name ?? 'Oportunidad').' - '.($o->product ?? '')]))
                    ->getOptionLabelUsing(fn ($value) => Opportunity::find($value)?->lead?->name),

                TextInput::make('tax_rate')
                    ->label('Impuesto (%)')
                    ->numeric()
                    ->default(16)
                    ->required(),

                Repeater::make('items')
                    ->relationship()
                    ->label('Productos / servicios')
                    ->schema([
                        TextInput::make('description')
                            ->label('Descripcion')
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('quantity')
                            ->label('Cantidad')
                            ->numeric()
                            ->default(1)
                            ->required(),
                        TextInput::make('unit_price')
                            ->label('Precio unitario')
                            ->numeric()
                            ->required(),
                    ])
                    ->columns(4)
                    ->columnSpanFull()
                    ->defaultItems(1)
                    ->addActionLabel('Agregar producto/servicio'),

                Textarea::make('notes')
                    ->label('Notas')
                    ->columnSpanFull(),
            ]);
    }
}