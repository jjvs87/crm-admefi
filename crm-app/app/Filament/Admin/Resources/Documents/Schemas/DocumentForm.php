<?php
namespace App\Filament\Admin\Resources\Documents\Schemas;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('lead_id')
                    ->label('Lead / Cliente')
                    ->relationship('lead', 'name')
                    ->searchable()
                    ->required(),
                Select::make('type')
                    ->label('Tipo de documento')
                    ->options([
                        'ine' => 'INE',
                        'rfc' => 'RFC',
                        'constancia' => 'Constancia de Situación Fiscal',
                        'acta_constitutiva' => 'Acta Constitutiva',
                        'poderes' => 'Poderes',
                        'contrato' => 'Contrato',
                        'poliza' => 'Póliza',
                        'cotizacion' => 'Cotización',
                        'pago' => 'Comprobante de pago',
                        'factura' => 'Factura',
                    ])
                    ->required(),
                FileUpload::make('file_path')
                    ->label('Archivo')
                    ->directory('documentos')
                    ->required(),
            ]);
    }
}
