<?php
namespace App\Filament\Admin\Resources\Clients\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lead.name')->label('Lead')->searchable(),
                TextColumn::make('product')->label('Producto')->searchable(),
                TextColumn::make('amount')->label('Monto')->money('MXN')->sortable(),
                TextColumn::make('contract_date')->label('Contratación')->date()->sortable(),
                TextColumn::make('renewal_date')->label('Renovación')->date()->sortable(),
                TextColumn::make('status')->label('Estatus')->badge(),
                TextColumn::make('responsible.name')->label('Responsable')->searchable(),
            ])
            ->defaultSort('renewal_date')
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