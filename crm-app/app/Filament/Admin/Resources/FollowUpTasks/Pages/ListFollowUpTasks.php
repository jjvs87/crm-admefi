<?php

namespace App\Filament\Admin\Resources\FollowUpTasks\Pages;

use App\Filament\Admin\Resources\FollowUpTasks\FollowUpTaskResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFollowUpTasks extends ListRecords
{
    protected static string $resource = FollowUpTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
