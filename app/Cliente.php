<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Cliente extends Model
{
	protected $fillable = [
		'id',
		'first_name',
		'last_name',
		'display',
		'phone',
		'ci_nit'
	];
}
