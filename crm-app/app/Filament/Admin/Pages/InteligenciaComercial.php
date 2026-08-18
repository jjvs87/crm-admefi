<?php

namespace App\Filament\Admin\Pages;

use App\Models\Activity;
use App\Models\Client;
use App\Models\Opportunity;
use Filament\Pages\Page;

class InteligenciaComercial extends Page
{
    protected string $view = 'filament.admin.pages.inteligencia-comercial';

    protected static string|\UnitEnum|null $navigationGroup = 'Ventas';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Inteligencia Comercial';
    protected static ?string $title = 'Inteligencia Comercial';
    protected static ?int $navigationSort = 5;


    public static function shouldRegisterNavigation(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'director']);
    }

    public static function canAccess(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'director']);
    }

    public $porCanal = [];
    public $porHunter = [];
    public $porCloser = [];
    public $cicloVentaPromedio = null;
    public $porIndustria = [];
    public $porProducto = [];

    public function mount(): void
    {
        $this->porCanal = Client::query()
            ->join('leads', 'leads.id', '=', 'clients.lead_id')
            ->selectRaw('leads.source as canal, count(*) as clientes, sum(clients.amount) as ingresos')
            ->groupBy('leads.source')
            ->orderByDesc('clientes')
            ->get()
            ->toArray();

        $this->porHunter = Activity::query()
            ->where('type', 'reunion')
            ->join('users', 'users.id', '=', 'activities.user_id')
            ->selectRaw('users.name as hunter, count(*) as reuniones')
            ->groupBy('users.name')
            ->orderByDesc('reuniones')
            ->get()
            ->toArray();

        $this->porCloser = Opportunity::query()
            ->join('users', 'users.id', '=', 'opportunities.closer_id')
            ->selectRaw('users.name as closer, count(*) as total, sum(case when opportunities.stage >= 8 then 1 else 0 end) as ganadas')
            ->groupBy('users.name')
            ->get()
            ->map(function ($row) {
                $row->conversion = $row->total > 0 ? round(($row->ganadas / $row->total) * 100, 1) : 0;
                return $row;
            })
            ->toArray();

        $this->cicloVentaPromedio = Client::query()
            ->join('leads', 'leads.id', '=', 'clients.lead_id')
            ->whereNotNull('clients.contract_date')
            ->selectRaw('AVG(DATEDIFF(clients.contract_date, leads.created_at)) as promedio')
            ->value('promedio');

        $this->porIndustria = Client::query()
            ->join('leads', 'leads.id', '=', 'clients.lead_id')
            ->selectRaw('leads.industry as industria, count(*) as clientes, sum(clients.amount) as ingresos')
            ->groupBy('leads.industry')
            ->orderByDesc('clientes')
            ->get()
            ->toArray();

        $this->porProducto = Client::query()
            ->selectRaw('product as producto, count(*) as clientes, sum(amount) as ingresos')
            ->groupBy('product')
            ->orderByDesc('clientes')
            ->get()
            ->toArray();
    }
}