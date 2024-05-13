<?php

namespace CubeAgency\FilamentRedirects\Filament\Resources\RedirectResource\Pages;

use CubeAgency\FilamentRedirects\Filament\Resources\RedirectResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListRedirects extends ListRecords
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
