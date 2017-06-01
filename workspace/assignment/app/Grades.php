<?php

namespace App;

use App\BaseModel as Model;

class Grades extends Model
{
    protected $table = 'grade';
    public $primaryKey = 'level';
}
