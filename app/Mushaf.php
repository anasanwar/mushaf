<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mushaf extends Model
{
    protected $table = 'mushaf';

    protected $fillable = [
        's_ID', 'aya', 'j_ID', 'h_ID', 'p_ID', 'l_ID', 'without', 'pointing', 'madina',
    ];


}
