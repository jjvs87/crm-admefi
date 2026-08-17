<?php
namespace App\Filament\Admin\Resources\Tickets\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.product')->label('Cliente / Producto')->searchable(),
                TextColumn::make('subject')->label('Asunto')->searchable(),
                TextColumn::make('status')->label('Estatus')->badge(),
                TextColumn::make('created_at')->label('Creado')->dateTime()->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
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