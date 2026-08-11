<?php

namespace App\Filament\Admin\Resources\FollowUpTasks\Pages;

use App\Filament\Admin\Resources\FollowUpTasks\FollowUpTaskResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFollowUpTask extends EditRecord
{
    protected static string $resource = FollowUpTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
