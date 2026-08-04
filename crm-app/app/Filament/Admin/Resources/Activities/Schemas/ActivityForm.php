<?php
namespace App\Filament\Admin\Resources\Activities\Schemas;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
class ActivityForm
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
                Select::make('user_id')
                    ->label('Responsable (Hunter/Closer)')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                Select::make('type')
                    ->label('Tipo de actividad')
                    ->options([
                        'llamada' => 'Llamada',
                        'correo' => 'Correo',
                        'whatsapp' => 'WhatsApp',
                        'linkedin' => 'LinkedIn',
                        'visita' => 'Visita',
                        'seguimiento' => 'Seguimiento',
                        'reunion' => 'Reunión',
                    ])
                    ->required(),
                Select::make('result')
                    ->label('Resultado')
                    ->options([
                        'contactado' => 'Contactado',
                        'no_contesto' => 'No contestó',
                        'no_interesado' => 'No interesado',
                        'reunion_agendada' => 'Reunión agendada',
                        'fuera_de_perfil' => 'Fuera de perfil',
                    ]),
                Textarea::make('notes')->label('Notas')->columnSpanFull(),
            ]);
    }
}
