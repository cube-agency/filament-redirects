<?php

use CubeAgency\FilamentRedirects\Enums\RedirectStatus;

return [
    'status' => [
        RedirectStatus::PERMANENT->value => 'Permanent',
        RedirectStatus::TEMPORARY->value => 'Temporary',
    ],
];
