<?php
namespace App\Filament\Admin\Resources\Leads\Schemas;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
class LeadForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nombre')->required(),
                TextInput::make('company')->label('Empresa'),
                TextInput::make('industry')->label('Giro'),
                TextInput::make('position')->label('Cargo'),
                TextInput::make('phone')->label('Teléfono')->tel(),
                TextInput::make('whatsapp')->label('WhatsApp'),
                TextInput::make('email')->label('Correo')->email(),
                TextInput::make('city')->label('Ciudad'),
                TextInput::make('state')->label('Estado'),
                TextInput::make('employees')->label('Número de empleados')->numeric(),
                TextInput::make('revenue')->label('Facturación aproximada')->numeric(),
                TextInput::make('source')->label('Fuente del lead'),
                TextInput::make('status')->label('Estatus')->required()->default('nuevo'),
                Select::make('hunter_id')
                    ->label('Hunter asignado')
                    ->relationship('hunter', 'name')
                    ->searchable()
                    ->helperText('Si lo dejas vacío, se asigna automáticamente al Hunter con menos leads.'),
            ]);
    }
}