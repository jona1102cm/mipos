<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class Kardex extends AbstractAction
{
    public function getTitle()
    {
        return 'Kardex';
    }

    public function getIcon()
    {
        return 'voyager-helm';
    }

    public function getPolicy()
    {
        return 'browse';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-success pull-right',
        ];
    }

    public function getDefaultRoute()
    {
        return route('catalogo.enviar', ['id' =>  $this->data->{$this->data->getKeyName()} ]);
    }

    public function shouldActionDisplayOnDataType()
    {
        return $this->dataType->slug == 'pensionados';
    }
}