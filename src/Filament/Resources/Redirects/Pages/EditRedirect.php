<?php

namespace CubeAgency\FilamentRedirects\Filament\Resources\Redirects\Pages;

use CubeAgency\FilamentRedirects\Filament\Resources\RedirectResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRedirect extends EditRecord
{
    protected static string $resource = RedirectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
