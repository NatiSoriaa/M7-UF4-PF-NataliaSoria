<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Agregar productos a la base de datos
        Product::create([
            'name' => 'Producto Ejemplo',
            'price' => 99.99,
            'description' => 'Descripción del producto ejemplo.',
        ]);

        Product::create([
            'name' => 'Producto 2',
            'price' => 149.99,
            'description' => 'Descripción del producto 2.',
        ]);

        // Puedes agregar más productos aquí si deseas.
    }
}
