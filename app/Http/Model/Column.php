<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    protected $table='column';
    protected $primaryKey='column_id';
    public $timestamps=false;
    protected $guarded=[];//排除法 所有数据都能填充
}
