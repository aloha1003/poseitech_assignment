<?php

namespace App;
use App\BaseModel as Model;

class Course extends Model
{
    protected $table = 'course';
    public $primaryKey = 'id';
    public $timestamps = false;
}
