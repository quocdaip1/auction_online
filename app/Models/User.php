<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Scout\Searchable;
use Abbasudo\Purity\Traits\Filterable;
use Abbasudo\Purity\Traits\Sortable;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Searchable,Filterable,Sortable;
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public function user_info()
    {
        return $this->hasOne(UserInfo::class, 'user_id');
    }
    public function toSearchableArray()
    {
        return [
            'email' => '',
            'status'=>'',
            'is_admin'=>'',
            'user_info.name' => '',
            'user_info.phone' => '',
        ];
    }


    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function auction(){
        return $this->hasMany(Auction::class);
    }



    protected $fillable = [
        'id',
        'email',
        'password',
        'is_admin',
        'status',
        'balance',
        'block_balance',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}