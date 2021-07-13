<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class inscription extends Model
{
    //
    protected $fillable = ['candidat_id','user_id','session_id','option_id'];

}
