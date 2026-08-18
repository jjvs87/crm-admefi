<?php

namespace App\Filament\Admin\Resources\Tickets;

use App\Filament\Admin\Resources\Tickets\Pages\CreateTicket;
use App\Filament\Admin\Resources\Tickets\Pages\EditTicket;
use App\Filament\Admin\Resources\Tickets\Pages\ListTickets;
use App\Filament\Admin\Resources\Tickets\Schemas\TicketForm;
use App\Filament\Admin\Resources\Tickets\Tables\TicketsTable;
use App\Models\Ticket;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TicketResource extends Resource
{

    protected static string|\UnitEnum|null $navigationGroup = 'Clientes';
    protected static ?string $modelLabel = 'Ticket';
    protected static ?string $pluralModelLabel = 'Tickets';
    protected static ?int $navigationSort = 3;

    protected static ?string $model = Ticket::class;


    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if (in_array($user->role, ['admin', 'director'])) {
            return $query;
        }

        if (in_array($user->role, ['closer', 'customer_success'])) {
            return $query->whereHas('client', fn ($q) => $q->where('responsible_id', $user->id));
        }

        return $query->whereRaw('1 = 0');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'director', 'closer', 'customer_success']);
    }

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-ticket';

    public static function form(Schema $schema): Schema
    {
        return TicketForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TicketsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTickets::route('/'),
            'create' => CreateTicket::route('/create'),
            'edit' => EditTicket::route('/{record}/edit'),
        ];
    }
}
