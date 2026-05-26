<?php

namespace CubeAgency\FilamentRedirects\Filament\Resources\Redirects\Tables;

use CubeAgency\FilamentRedirects\Enums\RedirectStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RedirectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('from_url')->searchable(),
                TextColumn::make('to_url')->searchable(),
                TextColumn::make('status_label')->label('Status'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(RedirectStatus::asSelectArray())
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
