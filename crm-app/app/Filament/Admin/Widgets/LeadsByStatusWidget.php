<?php
namespace App\Filament\Admin\Widgets;
use App\Models\Lead;
use App\Models\Opportunity;
use App\Models\FollowUpTask;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LeadsByStatusWidget extends StatsOverviewWidget
{
    public static function canView(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'director']);
    }


    protected function getStats(): array
    {
        return [
            Stat::make('Total de Leads', Lead::count())->color('primary'),
            Stat::make('Leads Nuevos', Lead::where('status', 'nuevo')->count())->color('info'),
            Stat::make('Con Calificación', Lead::has('qualification')->count())->color('success'),
            Stat::make('Oportunidades Abiertas', Opportunity::where('stage', '<', 8)->count())->color('warning'),
            Stat::make('Tareas Pendientes', FollowUpTask::where('status', 'pendiente')->count())->color('danger'),
        ];
    }
}