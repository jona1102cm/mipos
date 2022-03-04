<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Venta extends Model
{
	protected $fillable = [
		'id',
		'cliente_id',
		'cupon_id',
		'option_id',
		'pago_id',
		'factura',
		'total',
		'descuento',
		'observacion',
		'register_id',
		'status_id',
		'caja_id',
		'caja_status',
		'delivery_id',
		'sucursal_id',
		'subtotal',
		'ticket',
		'fiscal',
		'adicional',
		'created_at'
	];
}
