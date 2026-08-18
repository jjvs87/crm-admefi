<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Resources\Appointments\AppointmentResource;
use App\Models\Appointment;
use Filament\Pages\Page;

class AgendaCalendario extends Page
{
    protected string $view = 'filament.admin.pages.agenda-calendario';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Calendario';
    protected static ?string $title = 'Calendario de Agenda';
    protected static ?int $navigationSort = 1;
    protected static string|\UnitEnum|null $navigationGroup = 'Agenda';

    public array $events = [];

    public function mount(): void
    {
        $user = auth()->user();

        $query = Appointment::query()->with(['lead', 'client.lead', 'user']);

        if (! in_array($user->role, ['admin', 'director'])) {
            $query->where('user_id', $user->id);
        }

        $colors = [
            'pendiente' => '#f59e0b',
            'completada' => '#22c55e',
            'cancelada' => '#ef4444',
        ];

        $this->events = $query->get()->map(function (Appointment $appointment) use ($colors) {
            $extra = $appointment->lead?->name ?? $appointment->client?->lead?->name;

            return [
                'id' => $appointment->id,
                'title' => $appointment->title.($extra ? " - {$extra}" : ''),
                'start' => optional($appointment->start_at)->toIso8601String(),
                'end' => optional($appointment->end_at)->toIso8601String(),
                'color' => $colors[$appointment->status] ?? '#6b7280',
                'url' => AppointmentResource::getUrl('edit', ['record' => $appointment->id]),
            ];
        })->toArray();
    }
}
