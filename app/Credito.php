<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Models\User;
use Carbon\Carbon;

class Credito extends Model
{

    use SoftDeletes;
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
