<?php
namespace App\Filament\Admin\Resources\Leads\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
class LeadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nombre')->searchable(),
                TextColumn::make('company')->label('Empresa')->searchable(),
                TextColumn::make('industry')->label('Giro')->searchable(),
                TextColumn::make('position')->label('Cargo')->searchable(),
                TextColumn::make('phone')->label('Teléfono')->searchable(),
                TextColumn::make('whatsapp')->label('WhatsApp')->searchable(),
                TextColumn::make('email')->label('Correo')->searchable(),
                TextColumn::make('city')->label('Ciudad')->searchable(),
                TextColumn::make('state')->label('Estado')->searchable(),
                TextColumn::make('employees')->label('Empleados')->numeric()->sortable(),
                TextColumn::make('revenue')->label('Facturación')->numeric()->sortable(),
                TextColumn::make('source')->label('Fuente')->searchable(),
                TextColumn::make('status')->label('Estatus')->searchable(),
                TextColumn::make('hunter_id')->label('Hunter (ID)')->numeric()->sortable(),
                TextColumn::make('created_at')->label('Creado')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->label('Actualizado')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}