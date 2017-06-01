<?php

namespace App;
use App\BaseModel as Model;

class Student extends Model
{
    protected $table = 'student';
    public $primaryKey = 'id';
    protected $hidden = ['created_at', 'updated_at'];
    public $timestamps = false;
    public static function MappingKey()
    {
        return [
            'id', 'name', 'remark', 'registerDate'
        ];
    }

}
