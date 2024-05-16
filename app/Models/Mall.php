<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mall extends Model
{
    use HasFactory;

    protected $fillable = ['manager_id','name','address','phone','space','note','photo'];


    public function manager(){

        return $this->belongsTo(Manager::class,'manager_id','id');
    }
    public function department(){
        return $this->hasMany(Department::class,'mall_id');
    }
}
