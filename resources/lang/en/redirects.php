<?php

use CubeAgency\FilamentRedirects\Enums\RedirectStatus;

return [
    'status' => [
        RedirectStatus::TEMPORARY->value => 'Temporary',
        RedirectStatus::PERMANENT->value => 'Permanent',
    ],
];
