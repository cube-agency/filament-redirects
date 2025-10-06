<?php

namespace CubeAgency\FilamentRedirects\Filament\Resources;

use BackedEnum;
use CubeAgency\FilamentRedirects\Filament\Resources\Redirects\Pages\CreateRedirect;
use CubeAgency\FilamentRedirects\Filament\Resources\Redirects\Pages\EditRedirect;
use CubeAgency\FilamentRedirects\Filament\Resources\Redirects\Pages\ListRedirects;
use CubeAgency\FilamentRedirects\Filament\Resources\Redirects\Schemas\RedirectForm;
use CubeAgency\FilamentRedirects\Filament\Resources\Redirects\Tables\RedirectsTable;
use CubeAgency\FilamentRedirects\Models\Redirect;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::Link;

    protected static ?string $recordTitleAttribute = 'from_url';

    public static function form(Schema $schema): Schema
    {
        return RedirectForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RedirectsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRedirects::route('/'),
            'create' => CreateRedirect::route('/create'),
            'edit' => EditRedirect::route('/{record}/edit'),
        ];
    }
}
