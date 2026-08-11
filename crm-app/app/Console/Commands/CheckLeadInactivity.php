<?php

namespace App\Console\Commands;

use App\Models\FollowUpTask;
use App\Models\Lead;
use App\Models\User;
use Illuminate\Console\Command;

class CheckLeadInactivity extends Command
{
    protected $signature = 'crm:check-lead-inactivity';

    protected $description = 'Crea tareas automaticas para leads sin actividad reciente';

    public function handle(): void
    {
        $leads = Lead::whereNotIn('status', ['descartado', 'cliente'])->get();

        foreach ($leads as $lead) {
            $lastActivity = $lead->activities()->latest()->first();
            $lastDate = $lastActivity ? $lastActivity->created_at : $lead->created_at;
            $days = now()->diffInDays($lastDate);

            if ($days >= 10) {
                $this->createTaskIfNotExists($lead, 'alerta_director', $days);
            } elseif ($days >= 5) {
                $this->createTaskIfNotExists($lead, 'recordatorio', $days);
            } elseif ($days >= 2) {
                $this->createTaskIfNotExists($lead, 'llamada_pendiente', $days);
            }
        }

        $this->info('Revision de inactividad completada.');
    }

    private function createTaskIfNotExists(Lead $lead, string $type, int $days): void
    {
        $exists = FollowUpTask::where('lead_id', $lead->id)
            ->where('type', $type)
            ->where('status', 'pendiente')
            ->exists();

        if ($exists) {
            return;
        }

        $assignedTo = $type === 'alerta_director'
            ? User::where('role', 'director')->first()?->id
            : $lead->hunter_id;

        $messages = [
            'llamada_pendiente' => "El lead \"{$lead->name}\" lleva {$days} dias sin actividad. Contactar.",
            'recordatorio' => "Recordatorio: el lead \"{$lead->name}\" lleva {$days} dias sin seguimiento.",
            'alerta_director' => "Alerta: el lead \"{$lead->name}\" lleva {$days} dias sin actividad, revisar con el equipo.",
        ];

        FollowUpTask::create([
            'lead_id' => $lead->id,
            'user_id' => $assignedTo,
            'type' => $type,
            'message' => $messages[$type],
            'status' => 'pendiente',
        ]);
    }
}
