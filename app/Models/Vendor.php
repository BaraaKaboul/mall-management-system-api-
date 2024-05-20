<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = ['department_id','name','phone','description','note'];


    public function department(){

        return $this->belongsTo(Department::class,'department_id');
    }

    public function product()
    {
        return $this->belongsToMany(Product::class,'vendors_products','vendor_id');
    }
}
