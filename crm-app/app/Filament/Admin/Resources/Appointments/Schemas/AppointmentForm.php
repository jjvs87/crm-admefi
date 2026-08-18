<?php

namespace App\Filament\Admin\Resources\Appointments\Schemas;

use App\Models\Client;
use App\Models\Lead;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Titulo')
                    ->required(),

                Select::make('type')
                    ->label('Tipo')
                    ->options([
                        'reunion' => 'Reunion',
                        'llamada' => 'Llamada',
                        'presencial' => 'Presencial',
                        'otro' => 'Otro',
                    ])
                    ->default('reunion')
                    ->required(),

                DateTimePicker::make('start_at')
                    ->label('Inicio')
                    ->required(),

                DateTimePicker::make('end_at')
                    ->label('Fin'),

                TextInput::make('location')
                    ->label('Lugar / enlace'),

                Select::make('status')
                    ->label('Estado')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'completada' => 'Completada',
                        'cancelada' => 'Cancelada',
                    ])
                    ->default('pendiente')
                    ->required(),

                Select::make('user_id')
                    ->label('Responsable')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->default(fn () => auth()->id())
                    ->required(),

                Select::make('lead_id')
                    ->label('Lead relacionado')
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $search) => Lead::where('name', 'like', "%{$search}%")->limit(20)->pluck('name', 'id'))
                    ->getOptionLabelUsing(fn ($value) => Lead::find($value)?->name),

                Select::make('client_id')
                    ->label('Cliente relacionado')
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $search) => Client::whereHas('lead', fn ($q) => $q->where('name', 'like', "%{$search}%"))->limit(20)->get()->mapWithKeys(fn ($client) => [$client->id => $client->lead?->name ?? ('Cliente #'.$client->id)]))
                    ->getOptionLabelUsing(fn ($value) => Client::find($value)?->lead?->name ?? ('Cliente #'.$value)),

                Textarea::make('notes')
                    ->label('Notas')
                    ->columnSpanFull(),
            ]);
    }
}