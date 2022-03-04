<?php

namespace App\Imports;

use App\Producto;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Producto([
            'id' => $row[0],
            'name'     => $row[1],
            'description'    => $row[2],
            'precio' => $row[3],
            'categoria_id' => $row[4]
        ]);
    }
}
