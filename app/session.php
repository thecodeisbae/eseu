<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class session extends Model
{
    //
    protected $guarded = [];
    public function getDateOral($value)
    {
        return Carbon::parse($value)->format('Y-m-d\TH:i');
    }

    public function getDateEcrit($value)
    {
        return Carbon::parse($value)->format('Y-m-d\TH:i');
    }
}
