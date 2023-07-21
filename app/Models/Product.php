<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;



    protected $table = 'products';



    protected $fillable = [
        'name',
        'image',
        'description',
        'status',
        'quanlity',
        'Manufacturer_Name',
        'Manufacturer_Brand',
        'files',
        'created_at',
        'updated_at',
    ];
    public function category(){
        return $this->hasMany(Product::class);
    }

    public function User(){
        return $this->BelongsTo(User::class);
    }

    public function setFilenamesAttribute($value)
    {
        $this->attributes['filenames'] = json_encode($value);
    }


    
}
