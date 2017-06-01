<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use App\Repositories\StudentRepository;

class AssignmentController extends BaseController
{
    public static $operationMethodAry = [
                            'r' => 'query',
                            'c' => 'create',
                          ];

    public function getStudent($studentId)
    {
      $studentRepository = new StudentRepository();
      $student = $studentRepository->getStudentByStudentId($studentId);
      return $student;
    }
    /**
     * 處理動態方法
     * @method     doDynamicMethod
     * @author John Lin <john.lin@flyelephant.com.tw>
     * @version    [version]
     * @modifyDate 2017-05-27T17:50:57+0800
     * @param      [type]                   $method [description]
     * @return     [type]                           [description]
     */
    public function doDynamicMethod($method)
    {
        if (!isset(self::$operationMethodAry[$method])) {
            throw new \Exception("Not Define This Method", 1);
        }
        $dynamicMethod = 'dynamicMethod'.ucfirst(self::$operationMethodAry[$method]);
        if (!method_exists($this, $dynamicMethod)) {
            throw new \Exception("Not Found This Method", 1);
        }
        return $this->$dynamicMethod();
    }

    private function dynamicMethodQuery()
    {
        $searchAry = \Request::all();
        $studentRepository = new StudentRepository();
        return $studentRepository->listStudent($searchAry);
    }


    private function dynamicMethodCreate()
    {
        $inputAry = \Request::all();
        $studentRepository = new StudentRepository();
        $data = $studentRepository->updateStudent($inputAry);
        $data['uri'] = request()->root().'/assignments/api/v1/students/'.$data['id'];
        return $data;
    }

    public function queryAllStudent()
    {
        $searchAry = \Request::all();
        $studentRepository = new StudentRepository();
        $offset = (isset($searchAry['start'])) ? intval($searchAry['start']) : 0;
        $limit = (isset($searchAry['limit'])) ? intval($searchAry['limit']) : 20;
        return $studentRepository->listStudentByOffset($offset, $limit);
    }

    public function getGrades()
    {
      $studentRepository = new StudentRepository();
      return $studentRepository->listGrades();
    }
}
