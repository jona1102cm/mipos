<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
	use SoftDeletes;
	protected $fillable = [
		'id',
		'name',
		'description',
		'precio',
		'categoria_id',
		'stock'
	];

	public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

}
