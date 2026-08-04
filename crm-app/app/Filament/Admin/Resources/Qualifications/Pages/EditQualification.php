<?php

namespace App\Filament\Admin\Resources\Qualifications\Pages;

use App\Filament\Admin\Resources\Qualifications\QualificationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditQualification extends EditRecord
{
    protected static string $resource = QualificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
