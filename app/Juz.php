<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Juz extends Model
{
    protected $table = 'juz';

    protected $fillable = [
        'madina','letter','updated_at'
    ];


}
