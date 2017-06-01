<?php
namespace App\Exceptions;
use Exception;
use Log;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class ErrorHandler extends Handler
{
    public static $environment;
    public static $ex;
    public static $errCode;
    public static $line;
    public static $file;
    public static $errMessage;
    public static $errExtMessage;
    public static $enableTrace;
    public static $sub_path;
   
    public static function output($data = null)
    {
      return $data['message'];
      //return  json_encode($data);
    }

    public static function errorJSONOutput($param, $endResponse = true)
    {
        $errorAry["code"] = $param["code"];
        $errorAry["message"] = (string)$param["message"];
        $errorAry["extMessage"] = !empty($param["extMessage"]) ? $param["extMessage"] : "";
        if (!empty($param["line"])) {
            $errorAry["line"] =  $param["line"] ;
        }
        if (!empty($param["file"])) {
            $errorAry["file"] =  $param["file"] ;
        }
        if (!$errorAry["extMessage"]) {
            unset($errorAry["extMessage"]);
        }

        $error = self::output($errorAry);
        unset($errorAry);
        if ($endResponse) {
            die($error);
        } else {
            return $error;
        }
        
    }

    public static function getErrorString($param)
    {
        $string = "";
        ($param["code"] != "") ? $string .= "[" .  $param["code"] . "]" : null ;
        ($param["message"] != "") ? $string .=  $param["message"] : null ;
        ($param["extMessage"] != "") ? $string .= " 詳細錯誤: " . $param["extMessage"]  : null ;
        ($param["file"] != "") ? $string .= " 檔案: " .  $param["file"] : null ;
        ($param["line"] != "") ? $string .= " 行數: " .  $param["line"] : null ;
        return $string;
    }

    public static function getErrorData($controller = null)
    {

        $param = array();
        $param = array( "message" => self::$errMessage,
            "extMessage" => self::$errExtMessage,
            "code" => self::$errCode,
            "file" => (self::$ex->getFile() != "") ? self::$ex->getFile() : null,
            "line" => (self::$ex->getLine() != "") ? self::$ex->getLine() : null,
            "createTime" => date("Y-m-d H:i:s"),
            "className" => get_class(self::$ex));
        return $param;
    }

    public static function filterErrorData($param)
    {
        switch (self::$environment) {
            case "development":
            case "local":
            case 'testing':
            case "beta":
                return $param;

            case "stage":
            case "production":
            default: 
                $param["extMessage"] = null;
                $param["file"] = null;
                $param["line"] = null;
                $param["className"] = null;
                return $param;
        }
    }

    public static function alertOutputAndRedirect($controller, $redirectUrl, $ex)
    {
        ErrorHandler::initExceptionParam($ex);

        $param = self::getErrorData($controller);
        $controller->view->disable();
        $message = $ex->getMessage();
        $content  = "<meta http-equiv='content-type' content='text/html; charset=UTF-8'/>";
        if (!empty($ex)) {
            $content .= "<script>alert('" . $message . "');</script>";
        } else {
            $content .= "<script>alert('未知的錯誤');</script>";
        }
        if (empty($redirectUrl)) {
            if (empty($_SERVER['HTTP_REFERER'])) {
                $content .= "<script>history.go(-1);</script>";
            } else {
                $content .= "<script>location.replace('" . $_SERVER['HTTP_REFERER'] . "');</script>";
            }
        } else {
            $content .= "<script>location.replace('" . $redirectUrl . "');</script>";
        }
        $controller->response->setContent($content);
        $controller->response->send();
    }

    public static  function errorOutput($controller)
    {
        $param = self::getErrorData($controller);
        // 顯示畫面
        $param = self::filterErrorData($param);
        return self::errorJSONOutput($param, false);
    }

    public static function initExceptionParam($ex)
    {
        self::$ex = $ex;
        self::$errCode = null;
        self::$errMessage = null;
        self::$errExtMessage = null;
        switch (get_class($ex)) {
            case "App\Exceptions\APIException":
                self::$errCode = $ex->getCode();
                self::$errMessage = $ex->getMessage();
                self::$errExtMessage = $ex->getExMessage();
                self::$line = $ex->getLine();
                self::$file = $ex->getFile();
                break;
            case "Exception":
                self::$errCode = "003";
                self::$errMessage = $ex->getMessage();
                self::$errExtMessage = $ex->getMessage();
                break;
            default:
                self::$line = $ex->getLine();
                self::$file = $ex->getFile();
                self::$errCode = "003";
                self::$errMessage = $ex->getMessage();
                self::$errExtMessage = $ex->getMessage();
                break;
        }
    }

    public static function exceptionHandler($controller, $ex)
    {
        self::initExceptionParam($ex);
        self::LogReport($controller,$ex);
       return  self::errorOutput($controller);
        
    }

    


    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Controller  $controller
     * @param  \Exception  $exception
     * @return void
     */
    public static function LogReport($controller, $exception)
    {
        $param = self::getErrorData($controller);
    }
}


?>
