<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class option extends Model
{
    //
    public function matieres()
    {
        return $this->hasMany('App\Matiere');
    }
}
