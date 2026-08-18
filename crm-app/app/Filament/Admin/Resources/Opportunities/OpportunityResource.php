<?php

namespace App\Filament\Admin\Resources\Opportunities;

use App\Filament\Admin\Resources\Opportunities\Pages\CreateOpportunity;
use App\Filament\Admin\Resources\Opportunities\Pages\EditOpportunity;
use App\Filament\Admin\Resources\Opportunities\Pages\ListOpportunities;
use App\Filament\Admin\Resources\Opportunities\Schemas\OpportunityForm;
use App\Filament\Admin\Resources\Opportunities\Tables\OpportunitiesTable;
use App\Models\Opportunity;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class OpportunityResource extends Resource
 {
    protected static ?string $navigationLabel = 'Oportunidades';
    protected static ?string $modelLabel = 'Oportunidad';
    protected static ?string $pluralModelLabel = 'Oportunidades';

    protected static string|\UnitEnum|null $navigationGroup = 'Ventas';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-user-plus';
    protected static ?int $navigationSort = 3;

    protected static ?string $model = Opportunity::class;


    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if (in_array($user->role, ['admin', 'director'])) {
            return $query;
        }

        if ($user->role === 'closer') {
            return $query->where('closer_id', $user->id);
        }

        return $query->whereRaw('1 = 0');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return in_array(auth()->user()?->role, ['admin', 'director', 'closer']);
    }

    public static function form(Schema $schema): Schema
    {
        return OpportunityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OpportunitiesTable::configure($table);
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
            'index' => ListOpportunities::route('/'),
            'create' => CreateOpportunity::route('/create'),
            'edit' => EditOpportunity::route('/{record}/edit'),
        ];
    }
}
