<?php

namespace App\Filament\Admin\Resources\Quotes\Tables;

use App\Models\Quote;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class QuotesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('quote_number')
                    ->label('Numero')
                    ->searchable(),
                TextColumn::make('lead.name')
                    ->label('Lead'),
                TextColumn::make('client.lead.name')
                    ->label('Cliente'),
                TextColumn::make('status')
                    ->label('Estado')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'borrador' => 'gray',
                        'enviada' => 'info',
                        'aceptada' => 'success',
                        'rechazada' => 'danger',
                        'expirada' => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('valid_until')
                    ->label('Valida hasta')
                    ->date()
                    ->sortable(),
                TextColumn::make('total')
                    ->label('Total')
                    ->money('MXN')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Responsable'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('pdf')
                    ->label('PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->action(function (Quote $record) {
                        $pdf = Pdf::loadView('pdf.quote', [
                            'quote' => $record->load('items', 'client.lead', 'lead', 'user'),
                        ]);

                        return response()->streamDownload(
                            fn () => print ($pdf->output()),
                            $record->quote_number.'.pdf'
                        );
                    }),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}