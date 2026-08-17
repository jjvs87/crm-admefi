<?php
namespace App\Filament\Admin\Resources\Payments\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.product')->label('Cliente / Producto')->searchable(),
                TextColumn::make('amount')->label('Monto')->money('MXN')->sortable(),
                TextColumn::make('payment_date')->label('Fecha')->date()->sortable(),
                TextColumn::make('method')->label('Método'),
                TextColumn::make('status')->label('Estatus')->badge(),
            ])
            ->defaultSort('payment_date', 'desc')
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