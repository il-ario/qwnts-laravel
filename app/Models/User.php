<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'given_name',
        'family_name',
        'email',
        'birth_date',
        'password',
        'address_id',
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
        'email_verified_at' => 'datetime:Y-m-d h:i:s',
        'birth_date' => 'datetime:Y-m-d'
    ];

    /**
     * Address relationship.
     */
    public function address()
    {
        return $this->hasOne('App\Models\Address');
    }

    /**
     * Comments relationship.
     */
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    /**
     * Values assignment.
     * 
     * @param array $values
     */
    public function setValues(array $values)
    {
        $this->given_name = $values['given_name'];
        $this->family_name = $values['family_name'];
        $this->email = $values['email'];
        $this->birth_date = $values['birth_date'];
        $this->password = Hash::make($values['password']);
        $this->address_id = $values['address_id'];
    }
}
