<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @package BaseModel
 */
class BaseModel extends Model
{
    protected $skipRecordColumn = ['updated_at'];    //略過記錄的欄位
    public function getSkipRecordColumn()
    {
        return $this->skipRecordColumn;
    }
    public static function getTableName()
    {
        $instace = with(new static);
        return $instace->getTable();
    }
    public static function boot()
    {
        parent::boot();
    }
    
    public static function getConnectDbName()
    {
        $instace = with(new static);
        return $instace->getConnection()->getDataBaseName();
    }


    public static function MappingKey()
    {
        return [];
    }
    
    /**
     * 只有在MappingKey裡面的欄位才會存入
     * @method     saveMapping
     * @author Jones Lin <jones@mypay.tw>
     * @version    [version]
     * @modifyDate 2016-06-03T17:56:57+0800
     * @return     [type]                   [description]
     */
    public function saveMapping($dataAry)
    {
        foreach ($dataAry as $key => $value) {
            if (in_array($key, $this->MappingKey())) {
                $this->$key = $value;
            }
        }
        return $this->save();
    }

    public static function getNullModel()
    {
        $nullModel = [];
        foreach ( static::MappingKey() as $key => $value) {
            $nullModel[$value]  = '';
        }
        $nullModel['start_date'] = date("Y-m-d H:i:s");
        $nullModel['end_date'] = date("Y-m-d H:i:s");
        return $nullModel;
    }

}
