<?php

namespace App\Filament\Admin\Resources\Documents;

use App\Filament\Admin\Resources\Documents\Pages\CreateDocument;
use App\Filament\Admin\Resources\Documents\Pages\EditDocument;
use App\Filament\Admin\Resources\Documents\Pages\ListDocuments;
use App\Filament\Admin\Resources\Documents\Schemas\DocumentForm;
use App\Filament\Admin\Resources\Documents\Tables\DocumentsTable;
use App\Models\Document;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class DocumentResource extends Resource
{

    protected static ?string $navigationLabel = 'Documentos';
    protected static ?string $modelLabel = 'Documento';
    protected static ?string $pluralModelLabel = 'Documentos';

    protected static string|\UnitEnum|null $navigationGroup = 'Gestión';
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-text';
    protected static ?int $navigationSort = 1;

    protected static ?string $model = Document::class;


    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if (in_array($user->role, ['admin', 'director'])) {
            return $query;
        }

        if ($user->role === 'hunter') {
            return $query->whereHas('lead', fn ($q) => $q->where('hunter_id', $user->id));
        }

        if ($user->role === 'closer') {
            return $query->whereHas('lead.opportunities', fn ($q) => $q->where('closer_id', $user->id));
        }

        if ($user->role === 'customer_success') {
            return $query->whereHas('lead.clients', fn ($q) => $q->where('responsible_id', $user->id));
        }

        return $query->whereRaw('1 = 0');
    }

    protected static ?string $recordTitleAttribute = 'type';

    public static function form(Schema $schema): Schema
    {
        return DocumentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DocumentsTable::configure($table);
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
            'index' => ListDocuments::route('/'),
            'create' => CreateDocument::route('/create'),
            'edit' => EditDocument::route('/{record}/edit'),
        ];
    }
}
