<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'description',
    ];

    // 1 Category dapat memiliki banyak Articles
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
