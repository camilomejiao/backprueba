<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class folder extends Model
{
    //
    protected $fillable = [
        'nombrecarpeta', 'id_subcarpeta', 'user_id',
    ];

    public function usuarios()
    {
        return $this->belongsToMany(User::class);
    }

    public function folders(){
        return $this->hasMany(self::class,'id_subcarpeta');
    }
}
