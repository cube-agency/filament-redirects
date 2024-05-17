<?php

namespace CubeAgency\FilamentRedirects\Models;

use CubeAgency\FilamentRedirects\Enums\RedirectStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redirect extends Model
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        $this->table = config('filament-redirects.table_name');

        parent::__construct($attributes);
    }

    protected $fillable = [
        'from_url',
        'to_url',
        'status',
    ];

    public function getStatusLabelAttribute(): ?string
    {
        return RedirectStatus::asSelectArray()[$this->status] ?? null;
    }
}
