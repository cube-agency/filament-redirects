<?php

namespace CubeAgency\FilamentRedirects\Filament\Resources;

use CubeAgency\FilamentRedirects\Enums\RedirectStatus;
use CubeAgency\FilamentRedirects\Filament\Resources\RedirectResource\Pages\CreateRedirect;
use CubeAgency\FilamentRedirects\Filament\Resources\RedirectResource\Pages\EditRedirect;
use CubeAgency\FilamentRedirects\Filament\Resources\RedirectResource\Pages\ListRedirects;
use CubeAgency\FilamentRedirects\Models\Redirect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RedirectResource extends Resource
{
    protected static ?string $model = Redirect::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $recordTitleAttribute = 'from_url';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('from_url')->rules('required'),
                TextInput::make('to_url')->rules('required'),
                Select::make('status')
                    ->options(RedirectStatus::asSelectArray())
                    ->default(RedirectStatus::PERMANENT->value),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('from_url'),
                Tables\Columns\TextColumn::make('to_url'),
                Tables\Columns\TextColumn::make('status_label')->label('Status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
