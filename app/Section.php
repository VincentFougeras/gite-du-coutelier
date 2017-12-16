<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'content', 'image'];


    public static $rules = [
        'title' => 'required|max:100',
        'section_content' => 'required|max:10000'
    ];
}
