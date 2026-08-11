<?php
namespace App\Filament\Admin\Resources\FollowUpTasks\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FollowUpTasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lead.name')->label('Lead')->searchable(),
                TextColumn::make('user.name')->label('Asignado a')->searchable(),
                TextColumn::make('type')->label('Tipo')->badge(),
                TextColumn::make('message')->label('Mensaje')->limit(50),
                TextColumn::make('status')->label('Estatus')->badge()
                    ->color(fn (string $state): string => $state === 'pendiente' ? 'warning' : 'success'),
                TextColumn::make('created_at')->label('Creada')->dateTime()->sortable(),
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