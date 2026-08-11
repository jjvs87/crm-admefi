<?php
namespace App\Filament\Admin\Widgets;
use App\Models\FollowUpTask;
use Filament\Actions\BulkActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class PendingTasksWidget extends TableWidget
{
    protected static ?string $heading = 'Tareas de Seguimiento Pendientes';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => FollowUpTask::query()->where('status', 'pendiente')->latest())
            ->columns([
                TextColumn::make('lead.name')->label('Lead'),
                TextColumn::make('user.name')->label('Asignado a'),
                TextColumn::make('type')->label('Tipo')->badge(),
                TextColumn::make('message')->label('Mensaje')->limit(60),
                TextColumn::make('created_at')->label('Creada')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}