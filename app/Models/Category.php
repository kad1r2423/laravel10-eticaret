<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use Sluggable;
    protected $fillable = [
        'name',
        'image',
        'thumbnail',
        'slug',
        'content',
        'cat_ust',
        'status',
    ];

public function items(){

    return $this->hasMany(Product::class,'category_id','id');
}

public function subCategory()
{
    return $this->  hasMany(Category::class,'cat_ust','id');
}

public function category()
{
    return $this->  hasOne(Category::class,'id','cat_ust');
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
