<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'content'];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public static $rules = [
        'book_content' => 'required|max:10000',
    ];
}
