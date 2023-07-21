<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Category extends Model
{
    use HasFactory,Searchable;
    protected $table = 'categories';
    protected $fillable = [
        'id',
        'name',
        'status',
        'image',
        'created_at',
        'updated_at'
    ];

    public function users() {
        return $this->belongsTo(User::class, 'category_user', 'category_id', 'user_id');
    }

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function toSearchableArray()
    {
        return [
            'name' => '',
            'status' => '',
            'user_info.name'=> '',
        ];
    }

    


}
