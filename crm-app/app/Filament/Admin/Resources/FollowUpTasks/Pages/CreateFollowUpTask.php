<?php

namespace App\Filament\Admin\Resources\FollowUpTasks\Pages;

use App\Filament\Admin\Resources\FollowUpTasks\FollowUpTaskResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFollowUpTask extends CreateRecord
{
    protected static string $resource = FollowUpTaskResource::class;
}
