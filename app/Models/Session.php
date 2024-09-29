<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Session extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'session_id',
    //     'shop',
    //     'is_online',
    //     'state',
    //     'scope',
    //     'access_token',
    //     'expires_at',
    //     'user_id',
    //     'user_first_name',
    //     'user_last_name',
    //     'user_email_name',
    //     'user_email_verified',
    //     'account_owner',
    //     'locale',
    //     'collaborator',
    // ];


    public function user(){
        return $this->belongsTo(User::class);
    }

}
