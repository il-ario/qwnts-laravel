<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'street',
        'city',
        'postal_code',
        'country_code',
        'lat',
        'lng',
        'user_id',
    ];

    /**
     * User relationship.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Values assignment.
     * 
     * @param array $values
     */
    public function setValues(array $values)
    {
        $this->street = $values['street'];
        $this->city = $values['city'];
        $this->postal_code = $values['postal_code'];
        $this->country_code = $values['country_code'];
        $this->lat = $values['lat'];
        $this->lng = $values['lng'];
        $this->user_id = $values['user_id'];
    }
}
