<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Overtrue\LaravelFavorite\Traits\Favoriteable;
use Kyslik\ColumnSortable\Sortable;
use Carbon\Carbon;

class Restaurant extends Model
{
    use HasFactory, Favoriteable, Sortable;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getFormattedOpenTimeAttribute()
    {
        return Carbon::parse($this->attributes['open_time'])->format('H:i');
    }

    public function getFormattedCloseTimeAttribute()
    {
        return Carbon::parse($this->attributes['close_time'])->format('H:i');
    }
}
