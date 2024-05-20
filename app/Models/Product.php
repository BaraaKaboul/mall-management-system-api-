<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name','description','manufacture_company','photo'];

    public function vendor()
    {
        return $this->belongsToMany(Vendor::class,'vendors_products','product_id');
    }
}
