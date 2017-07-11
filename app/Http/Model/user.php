<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class user extends Model
{
    //
    protected $table='user';
    protected $primarykey='id';
    public $timestamps = false;
    protected $guarded=[];
}
