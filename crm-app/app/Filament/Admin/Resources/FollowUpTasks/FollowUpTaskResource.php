<?php

namespace App\Filament\Admin\Resources\FollowUpTasks;

use App\Filament\Admin\Resources\FollowUpTasks\Pages\CreateFollowUpTask;
use App\Filament\Admin\Resources\FollowUpTasks\Pages\EditFollowUpTask;
use App\Filament\Admin\Resources\FollowUpTasks\Pages\ListFollowUpTasks;
use App\Filament\Admin\Resources\FollowUpTasks\Schemas\FollowUpTaskForm;
use App\Filament\Admin\Resources\FollowUpTasks\Tables\FollowUpTasksTable;
use App\Models\FollowUpTask;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FollowUpTaskResource extends Resource
{
    protected static ?string $navigationLabel = 'Tareas de Seguimiento';
    protected static ?string $modelLabel = 'Tarea de Seguimiento';
    protected static ?string $pluralModelLabel = 'Tareas de Seguimiento';

    protected static string|\UnitEnum|null $navigationGroup = 'Gestión';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-bell-alert';
    protected static ?int $navigationSort = 2;
	
    protected static ?string $model = FollowUpTask::class;

  

    protected static ?string $recordTitleAttribute = 'message';

    public static function form(Schema $schema): Schema
    {
        return FollowUpTaskForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FollowUpTasksTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFollowUpTasks::route('/'),
            'create' => CreateFollowUpTask::route('/create'),
            'edit' => EditFollowUpTask::route('/{record}/edit'),
        ];
    }
}
