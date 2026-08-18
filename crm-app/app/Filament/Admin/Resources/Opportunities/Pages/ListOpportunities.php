<?php

namespace App\Filament\Admin\Resources\Opportunities\Pages;

use App\Enums\OpportunityStage;
use App\Filament\Admin\Resources\Opportunities\OpportunityResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Wezlo\FilamentKanban\Concerns\HasKanbanBoard;
use Wezlo\FilamentKanban\KanbanBoard;

class ListOpportunities extends ListRecords
{
    use HasKanbanBoard;

    protected static string $resource = OpportunityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function kanban(KanbanBoard $kanban): KanbanBoard
    {
        return $kanban
            ->enumColumn('stage', OpportunityStage::class)
            ->cardTitle(fn ($record) => $record->lead?->name ?? 'Sin lead')
            ->cardDescription(fn ($record) => $record->product ?? '')
            ->cardBadges(fn ($record) => $record->amount
                ? [['label' => '$' . number_format($record->amount, 0), 'color' => 'success']]
                : [])
            ->cardFooterActions([
                Action::make('edit')
                    ->icon(Heroicon::PencilSquare)
                    ->color('gray')
                    ->url(fn ($record) => OpportunityResource::getUrl('edit', ['record' => $record])),
            ])
            ->searchable(['lead.name', 'product']);
    }
}