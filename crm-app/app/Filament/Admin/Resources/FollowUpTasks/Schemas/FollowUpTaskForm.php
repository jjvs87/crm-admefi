<?php
namespace App\Filament\Admin\Resources\FollowUpTasks\Schemas;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class FollowUpTaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('lead_id')
                    ->label('Lead')
                    ->relationship('lead', 'name')
                    ->searchable()
                    ->required(),
                Select::make('user_id')
                    ->label('Asignado a')
                    ->relationship('user', 'name')
                    ->searchable(),
                Select::make('type')
                    ->label('Tipo')
                    ->options([
                        'llamada_pendiente' => 'Llamada pendiente',
                        'recordatorio' => 'Recordatorio',
                        'alerta_director' => 'Alerta a Dirección',
                    ])
                    ->required(),
                Textarea::make('message')->label('Mensaje')->columnSpanFull(),
                Select::make('status')
                    ->label('Estatus')
                    ->options([
                        'pendiente' => 'Pendiente',
                        'completada' => 'Completada',
                    ])
                    ->default('pendiente')
                    ->required(),
            ]);
    }
}
