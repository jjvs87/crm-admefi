<?php
namespace App\Filament\Admin\Resources\Qualifications\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
class QualificationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('lead.name')->label('Lead')->sortable(),
                IconColumn::make('has_company')->label('¿Empresa?')->boolean(),
                TextColumn::make('employees')->label('Empleados')->numeric()->sortable(),
                IconColumn::make('has_inhouse_lawyer')->label('¿Abogado?')->boolean(),
                IconColumn::make('has_insurance')->label('¿Seguro?')->boolean(),
                IconColumn::make('has_lawsuits')->label('¿Demandas?')->boolean(),
                IconColumn::make('has_overdue_debt')->label('¿Cartera vencida?')->boolean(),
                IconColumn::make('has_branches')->label('¿Sucursales?')->boolean(),
                TextColumn::make('decision_maker')->label('Decide')->searchable(),
                TextColumn::make('revenue')->label('Facturación')->numeric()->sortable(),
                TextColumn::make('level')->label('Nivel')->searchable(),
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