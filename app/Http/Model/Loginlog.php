<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Loginlog extends Model
{
    protected $table='log';
    protected $primaryKey='id';
    public $timestamps=false;
}
