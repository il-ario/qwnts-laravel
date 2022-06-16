<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'body',
        'user_id',
        'status',
    ];

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
        $this->title = $values['title'];
        $this->body = $values['body'];
        $this->status = $values['status'];
    }
}
