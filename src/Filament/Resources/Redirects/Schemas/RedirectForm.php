<?php

namespace CubeAgency\FilamentRedirects\Filament\Resources\Redirects\Schemas;

use CubeAgency\FilamentRedirects\Enums\RedirectStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class RedirectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('from_url')
                    ->rules('required'),

                TextInput::make('to_url')
                    ->rules('required'),

                Select::make('status')
                    ->options(RedirectStatus::asSelectArray())
                    ->default(RedirectStatus::TEMPORARY->value)
                    ->required(),
            ]);
    }
}
