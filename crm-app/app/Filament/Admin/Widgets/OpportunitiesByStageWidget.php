<?php
namespace App\Filament\Admin\Widgets;
use App\Models\Opportunity;
use Filament\Widgets\ChartWidget;

class OpportunitiesByStageWidget extends ChartWidget
{
    protected ?string $heading = 'Oportunidades por Etapa';

    protected function getData(): array
    {
        $counts = Opportunity::query()
            ->selectRaw('stage, count(*) as total')
            ->groupBy('stage')
            ->pluck('total', 'stage');

        $labels = [];
        $data = [];

        foreach (Opportunity::STAGES as $stage => $label) {
            $labels[] = $label;
            $data[] = $counts[$stage] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Oportunidades',
                    'data' => $data,
                    'backgroundColor' => '#f59e0b',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}