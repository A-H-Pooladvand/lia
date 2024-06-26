<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id', '_id'];

    public function hasInventoryOf(int $count): bool
    {
        return $this->inventory >= $count;
    }
}
