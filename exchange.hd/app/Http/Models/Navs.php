<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Navs extends Model{
    protected $table='navs';
	protected $primaryKey='id';
	public $timestamps=false;
	protected $guarded=[];
}
