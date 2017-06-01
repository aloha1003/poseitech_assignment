<?php
namespace App\Library;
use Validator;
class FormValidator {
    /**
     * 建立變數檢查
     * @author Jones Lin
     * @modifyDate 2015-03-24T14:03:35+0800
     * @param      array                  $input     要檢查的資料來源
     * @param      array                   $rules 檢查規則
     * @param      array                   $messages 指定的提示訊息
     * @param      array                   $afterRemoveField 檢查完欄位之後，需要刪除的欄位
     * @return     [type]                                     [description]
     */
    public static function make(&$input, $rules, $messages= array(), $afterRemoveField = array() ) 
    {
        foreach ($rules as $key => $value) {
                //檢查裡面有沒有required
                if (!isset($input[$key])) {
                    $isNull = true;
                    $input[$key] = '';
                } else {
                    $isNull = false;
                }
                if (is_array($value)) {
                    $result = self::isReplaceDefaultStr($input[$key], $value, $key);
                  if ( $result['isReset']) {
                      $input[$key] = $result['newInput'];
                  } else {
                      if ($isNull) {
                          unset($input[$key]);
                      }
                  }
                } else {
                  //分割|
                  $tmp = explode('|', $value);
                  $result = self::isReplaceDefaultStr($input[$key], $tmp, $key);
                  if ( $result['isReset']) {
                      $input[$key] = $result['newInput'];
                  } else {
                      if ($isNull) {
                          unset($input[$key]);
                      }
                  }
                }

        }
        $validator = \Validator::make($input, $rules, $messages);
        if ($validator->fails())
        {
            $messageAry = $validator->messages()->toArray();
            $message = '';
            foreach ($messageAry as $key => $value) {
                $message .= $value[0].',';
            }
            $message = rtrim($message, ",");
            throw new \App\Exceptions\APIException('003',$message, null, null, 0);
        }
        if ($afterRemoveField) {
            foreach ($afterRemoveField as $field) {
                unset($rules[$field]);
            }
        }
        return $rules;
    }
    public static function isReplaceDefaultStr($input, $ruleItem, $inputKey)
    {
          $isReset = false;
          foreach ($ruleItem as $key => $value) {
              $ruleItemAry = explode(':', $value);
              if (in_array('default',$ruleItemAry)) {
                  if (!$input  && count($ruleItemAry) == 2) {
                      $input = $ruleItemAry[1];
                      $isReset = true;
                  }
              }
              if (in_array('trim',$ruleItemAry)) {
                  $input = trim($input);
                  $isReset = true;
              }
          }
          return ['isReset' => $isReset, 'newInput' => $input];
    }


}