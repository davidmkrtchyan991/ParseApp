<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /**
     * The attributes are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('title', 'description', 'image', 'url', 'date');
}
