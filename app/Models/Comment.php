<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'text',
        'post_id',
        'user_id',
    ];

    /**
     * Post relationship.
     */
    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }

    /**
     * User relationship.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
