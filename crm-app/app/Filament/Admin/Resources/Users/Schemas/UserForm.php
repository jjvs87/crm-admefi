<?php
namespace App\Filament\Admin\Resources\Users\Schemas;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nombre')->required(),
                TextInput::make('email')->label('Correo')->email()->required(),
                Select::make('role')
                    ->label('Rol')
                    ->options([
                        'hunter' => 'Hunter',
                        'closer' => 'Closer',
                        'customer_success' => 'Customer Success',
                        'director' => 'Director Comercial',
                        'admin' => 'Administrador',
                    ])
                    ->required()
                    ->default('hunter'),
                Toggle::make('active')->label('Activo')->default(true),
                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->dehydrateStateUsing(fn ($state) => bcrypt($state))
                    ->dehydrated(fn ($state) => filled($state))
                    ->required(fn (string $context): bool => $context === 'create'),
            ]);
    }
}