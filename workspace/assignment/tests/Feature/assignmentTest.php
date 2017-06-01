<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class assignment extends TestCase
{
    public $client ;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testQueryStudentById()
    {  //查詢特定的學生
        // $this->get('/assignments/api/v1/students/151')
        //      ->assertTrue('Laravel 5');
        // $this->assertTrue(true);
        $studentId = 1;
        // $request = $this->client->get('/assignments/api/v1/students/'.$studentId, null, json_encode($data));
        $request = $this->get('/assignments/api/v1/students/'.$studentId);
        $response = $request->send();
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $data);
        $data = $data['data'];
        if ($data) {
            $this->assertArrayHasKey('id', $data);
            $this->assertArrayHasKey('name', $data);
            $this->assertArrayHasKey('registerDate', $data);    
        }
        
    }

    public function testQueryStudentByIdError()
    {  //查詢特定的學生，發生錯誤情況
        $studentId = 'XXXXXX';
        $request = $this->get('/assignments/api/v1/students/'.$studentId);
        $response = $request->send();
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('error', $data);
    }


    public function testQueryStudentByQuery()
    {  //依條件查詢學生
        $queryData = [
                        'id' => 151,
                     ];
        $this->queryStudentByQuery($queryData);
        $queryData = [
                        'name' => 'Belle Heaney',
                     ];
        $this->queryStudentByQuery($queryData);
        $queryData = [
                        'registerDate' => '1980-01-09',
                     ];
        $this->queryStudentByQuery($queryData);
    }

    private function queryStudentByQuery($queryData)
    {
        $request = $this->post('/assignments/api/v1/students?method=r', $queryData);
        $response = $request->send();
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $data);
        $data = $data['data'];
        if ($data) {
            foreach ($data as $key => $item) {
                $this->assertArrayHasKey('id', $item);
                $this->assertArrayHasKey('name', $item);
                $this->assertArrayHasKey('registerDate', $item);    
            }
        } 
    }

    public function testQueryStudentByAll()
    {  //查詢所有學生
        $queryData = [
                        'start' => 1,
                        'limit' => 20,
                     ];
        $this->queryStudentByAll($queryData);
    }

    private function queryStudentByAll($queryData)
    {
        $request = $this->post('/assignments/api/v1/students', $queryData);
        $response = $request->send();
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $data);
        $data = $data['data'];
        if ($data) {
            foreach ($data as $key => $item) {
                $this->assertArrayHasKey('id', $item);
                $this->assertArrayHasKey('name', $item);
                $this->assertArrayHasKey('registerDate', $item);    
            }
        } 
    }

    public function testAddStudent()
    {  
        //新增一個學生
        $studentData = [
                        'name' => '手動輸入',
                        'registerDate' => date("Y-m-d"),
                        'remark' => "測試資料",
                     ];
        $this->addStudent($studentData);
        //錯誤的情形, 沒有輸入註冊日期
        $studentData = [
                        'name' => '手動輸入',
                        'remark' => "測試資料",
                     ];
        $this->addStudent($studentData, true);
        //錯誤的情形, 沒有輸入姓名
        $studentData = [
                        'registerDate' => date("Y-m-d"),
                        'remark' => "測試資料",
                     ];
        $this->addStudent($studentData, true);
    }

    private function addStudent($studentData, $errorHappened = false)
    {

        $request = $this->post('/assignments/api/v1/students?method=c', $studentData);
        $response = $request->send();
        $data = json_decode($response->getContent(), true);
        if (!$errorHappened) {
            $this->assertArrayHasKey('data', $data);
            $data = $data['data'];
            if (!$errorHappened) {
                $this->assertArrayHasKey('id', $data);
                $this->assertArrayHasKey('name', $data);
                $this->assertArrayHasKey('registerDate', $data);    
            } 
        } else {
          $this->assertArrayHasKey('error', $data);  
        }
    }

    public function testQueryGrade()
    {  
        //查詢各科成績的學生人數
        $request = $this->get('/assignments/api/v1/students/grades');
        $response = $request->send();
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('data', $data);
        $data = $data['data'];
        if ($data) {
            foreach ($data as $key => $item) {
                $this->assertArrayHasKey('level', $item);
                $this->assertArrayHasKey('course', $item);
                $this->assertArrayHasKey('count', $item);    
            }
        } 
    }

}
