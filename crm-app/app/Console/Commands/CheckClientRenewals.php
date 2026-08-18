<?php

namespace App\Console\Commands;

use App\Models\Client;
use App\Models\FollowUpTask;
use Illuminate\Console\Command;

class CheckClientRenewals extends Command
{
    protected $signature = 'crm:check-client-renewals';

    protected $description = 'Crea alertas de renovacion a 120/90/60/30/15/7/1 dias';

    private array $thresholds = [120, 90, 60, 30, 15, 7, 1];

    public function handle(): void
    {
        $clients = Client::where('status', 'activo')
            ->whereNotNull('renewal_date')
            ->get();

        foreach ($clients as $client) {
            $daysLeft = now()->startOfDay()->diffInDays($client->renewal_date->copy()->startOfDay(), false);

            if ($daysLeft < 0) {
                continue;
            }

            foreach ($this->thresholds as $threshold) {
                if ((int) $daysLeft === $threshold) {
                    $this->createAlertIfNotExists($client, $threshold);
                }
            }
        }

        $this->info('Revision de renovaciones completada.');
    }

    private function createAlertIfNotExists(Client $client, int $threshold): void
    {
        $exists = FollowUpTask::where('lead_id', $client->lead_id)
            ->where('type', 'renovacion')
            ->where('message', 'like', "%{$threshold} dias%")
            ->exists();

        if ($exists) {
            return;
        }

        FollowUpTask::create([
            'lead_id' => $client->lead_id,
            'user_id' => $client->responsible_id,
            'type' => 'renovacion',
            'message' => 'El cliente "' . ($client->lead?->name ?? 'Sin nombre') . '" (producto: ' . ($client->product ?? 'N/A') . ') se renueva en ' . $threshold . ' dias (' . $client->renewal_date->format('d/m/Y') . ').',
            'status' => 'pendiente',
        ]);
    }
}
