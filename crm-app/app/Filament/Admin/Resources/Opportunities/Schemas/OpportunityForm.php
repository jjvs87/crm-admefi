<?php
namespace App\Filament\Admin\Resources\Opportunities\Schemas;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use App\Models\Opportunity;

class OpportunityForm
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
                Select::make('closer_id')
                    ->label('Closer')
                    ->relationship('closer', 'name')
                    ->searchable(),
                Select::make('stage')
                    ->label('Etapa')
                    ->options(Opportunity::STAGES)
                    ->required()
                    ->default(1),
                TextInput::make('product')->label('Producto'),
                TextInput::make('amount')->label('Monto')->numeric()->prefix('$'),
                Textarea::make('comments')->label('Comentarios')->columnSpanFull(),
            ]);
    }
}
