<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $fillable = ['name','email','password','phone','address','photo'];

    protected $hidden = ['password'];

//    public function getPhotoAttribute($value) // فائدة هالدالة انو بتعمل تغييرات على اسم الحقل photo حصرا
//    {
//        $actual_link = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/';
//        return ($value == null ? '' : $actual_link . 'images/managers/' . $value);
//    }
    public function mall(){
        return $this->hasMany(Mall::class,'manager_id');
    }
}
