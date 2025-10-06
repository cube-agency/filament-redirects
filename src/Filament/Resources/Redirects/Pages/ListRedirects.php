<?php

namespace CubeAgency\FilamentRedirects\Filament\Resources\Redirects\Pages;

use CubeAgency\FilamentRedirects\Filament\Resources\RedirectResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRedirects extends ListRecords
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
