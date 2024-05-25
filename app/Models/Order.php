<?php

namespace App\Models;

use App\Observers\OrderObserver;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\EmbedsMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([OrderObserver::class])]
class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id', '_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function products(): EmbedsMany
    {
        return $this->embedsMany(Product::class);
    }
}
