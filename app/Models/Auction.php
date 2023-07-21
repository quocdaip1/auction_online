<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class Auction extends Model
{
    use HasFactory,Searchable;

    protected $table = 'auctions';

    public function product(){
        return $this->hasOne(Product::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function user_info(){
        return $this->belongsTo(UserInfo::class);
    }


    public function toSearchableArray()
    {
        return [
            'products.name' => '',
            'user_info.name'=> '',
        ];
    }


}
