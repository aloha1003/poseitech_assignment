<?php

namespace App\Exceptions;
use Exception;

class APIException extends Exception
{
    protected $extMessage = null;

    public function __construct($code = "003", $message = null, $extMessage = null, $apiError = null, $traceLayer = false )
    {
        $this->code = $code;

        if (!is_null($message)) {
            $this->message = $message;
        }
        
        if (!is_null($extMessage)) {
            $this->extMessage = $extMessage;
        }
        
        if (!is_null($apiError['line'])) {
            $this->line = $apiError['line'];
        }
        if (!is_null($apiError['file'])) {
            $this->file = $apiError['file'];
        }
        if ($traceLayer !== false) {
            $this->file = $this->getTrace()[$traceLayer]['file'];
            $this->line = $this->getTrace()[$traceLayer]['line'];

        }
    }

    public function getExMessage()
    {
        return $this->extMessage;
    }

    public function getExCode()
    {
        return $this->code;
    }
    
    public function setMessage($message)
    {
        $this->message = $message;
    }
}
?>