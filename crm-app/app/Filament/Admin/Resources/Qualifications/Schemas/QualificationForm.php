<?php
namespace App\Filament\Admin\Resources\Qualifications\Schemas;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
class QualificationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('lead_id')
                    ->label('Lead')
                    ->relationship('lead', 'name')
                    ->searchable()
                    ->required(),
                Toggle::make('has_company')->label('¿Tiene empresa?'),
                TextInput::make('employees')->label('N° de empleados')->numeric(),
                Toggle::make('has_inhouse_lawyer')->label('¿Tiene abogado interno?'),
                Toggle::make('has_insurance')->label('¿Tiene seguro?'),
                Toggle::make('has_lawsuits')->label('¿Ha tenido demandas?'),
                Toggle::make('has_overdue_debt')->label('¿Tiene cartera vencida?'),
                Toggle::make('has_branches')->label('¿Tiene sucursales?'),
                TextInput::make('decision_maker')->label('¿Quién decide?'),
                TextInput::make('revenue')->label('Facturación')->numeric(),
                TextInput::make('level')->label('Nivel del prospecto (A/B/C/D)'),
            ]);
    }
}