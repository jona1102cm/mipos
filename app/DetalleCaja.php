<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class DetalleCaja extends Model
{
	protected $fillable = [
		'created_at',
		'updated_at',
		'deleted_at',
		'cantidad_ventas',
		'importe_inicial',
		'total_ventas',
		'ingresos',
		'egresos',
		'caja_id',
		'description',
		'editor_id'
	];
}
