<?php
namespace App\Filament\Admin\Resources\Opportunities\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Opportunity;

class OpportunitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lead.name')->label('Lead')->searchable(),
                TextColumn::make('closer.name')->label('Closer')->searchable(),
                TextColumn::make('stage')->label('Etapa')
                    ->formatStateUsing(fn ($state) => Opportunity::STAGES[$state] ?? $state)
                    ->badge()
                    ->sortable(),
                TextColumn::make('product')->label('Producto')->searchable(),
                TextColumn::make('amount')->label('Monto')->money('MXN')->sortable(),
                TextColumn::make('created_at')->label('Creado')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
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