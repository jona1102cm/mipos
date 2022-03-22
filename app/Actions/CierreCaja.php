<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class CierreCaja extends AbstractAction
{
    public function getTitle()
    {
        return 'Imprimir';
    }

    public function getIcon()
    {
        return 'voyager-photos';
    }

    public function getPolicy()
    {
        return 'add';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-right',
        ];
    }

    public function getDefaultRoute()
    {
        return route('cajas.cierre_caja', ['id' =>  $this->data->{$this->data->getKeyName()} ]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'detalle-cajas';
    }
}