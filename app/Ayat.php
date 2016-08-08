<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ayat extends Model
{
    protected $table = 'ayat';

    protected $fillable = [
        'ID','sura','ayaNo','aya','muyassar'
    ];


}
