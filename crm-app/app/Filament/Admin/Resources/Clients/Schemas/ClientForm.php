<?php
namespace App\Filament\Admin\Resources\Clients\Schemas;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('lead_id')->label('Lead')->relationship('lead', 'name')->searchable()->required(),
                Select::make('opportunity_id')->label('Oportunidad de origen')->relationship('opportunity', 'id')->searchable(),
                TextInput::make('product')->label('Producto'),
                TextInput::make('amount')->label('Monto')->numeric()->prefix('$'),
                DatePicker::make('contract_date')->label('Fecha de contratación'),
                DatePicker::make('renewal_date')->label('Fecha de renovación'),
                Select::make('status')
                    ->label('Estatus')
                    ->options(['activo' => 'Activo', 'cancelado' => 'Cancelado', 'renovado' => 'Renovado'])
                    ->default('activo')->required(),
                Select::make('responsible_id')->label('Responsable')->relationship('responsible', 'name')->searchable(),
            ]);
    }
}
