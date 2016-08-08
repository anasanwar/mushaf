<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Surah extends Model
{
    protected $table = 'surah';

    protected $fillable = [
        'name','name_en','English_Translation','madina','p_ID','total_aya','tanzeel','updated_at'
    ];


}
