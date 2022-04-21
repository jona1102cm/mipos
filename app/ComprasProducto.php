<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ComprasProducto extends Model
{
    use SoftDeletes;
	protected $fillable = [
		'producto_id'

	];
}
