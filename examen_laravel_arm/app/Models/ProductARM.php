<?php
// ARM
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductARM extends Model
{
    protected $table = 'products';
    protected $fillable = ['nombre', 'precio', 'stock'];
}
