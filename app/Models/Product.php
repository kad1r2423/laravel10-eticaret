<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use Sluggable,HasFactory;
    protected $fillable =[
    'name',
    'slug',
    'image',
    'short_text',
    'price',
    'category_id',
    'content',
    'size',
    'qty',
    'status',
    'color'
    ];

    public function category()
    {
        return  $this->hasOne(Category::class,'id','category_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
