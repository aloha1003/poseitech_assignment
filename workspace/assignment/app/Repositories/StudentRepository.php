<?php
namespace App\Repositories;
use App\Student;
use App\StudentCourseGrade;
use App\Course;
use App\Grades;
use App\Library\FormValidator;
class StudentRepository {

  public function getStudentByStudentId($studentId)
  {
    $ruleAry = [
                    'studentId' => 'integer',
                ];
    $dataAry = ['studentId' => $studentId];
    $rules = FormValidator::make($dataAry, $ruleAry);
    $student = Student::where('id', '=', $studentId )
                            ->first(); 
    if (!$student) {
      return [];
    } else {
      return $student->toArray();                              
    }                                            
  }

  public function listStudent($query = [])
  {
    $student = new Student();
    
    if (isset($query['id']) && trim($query['id']) != '') {
      $student = $student->where('id', '=', $query['id'] );
    }
    if (isset($query['studentName']) && trim($query['studentName']) != '') {
      $student = $student->where('name', 'like', '%'.$query['studentName'].'%' );
    }
    if (isset($query['registerDate']) && trim($query['registerDate']) != '') {
      $student = $student->where('registerDate', '=', $query['registerDate'] );
    }
    $list = $student->get()->toArray();
    return $list;
  }


  public function listStudentByOffset($offset= 0, $limit = 20)
  {
    $student = new Student();
    $list = $student->orderBy('id', 'ASC')->limit($limit)->offset($offset)->get()->toArray();
    return $list;
  }
  public function updateStudent($dataAry)
  {
    $ruleAry = [
                    'studentId' => 'integer|trim',
                    'name' => 'required_if:product_uid,',
                    'registerDate' => 'date|required_if:product_uid,',
                    'remark' => 'string',
                ];
    $rules = FormValidator::make($dataAry, $ruleAry);
    if ($dataAry['studentId']) {
      $student = Student::where('id', '=', $dataAry['studentId'])->first();
    } else {
      $student = new Student();
    }
    $student->saveMapping($dataAry);
    return $student->toArray();
  }
  public function listGrades($query = [])
  {
    $studentCourseGradeTableName = StudentCourseGrade::getTableName();
    $courseTableName = Course::getTableName();
    $gradesTableName = Grades::getTableName();
    $selectFieldAry = [
      \DB::raw($courseTableName.'.name as course'),
      \DB::raw('gradelevel as level'),
      \DB::raw('count(1) as count'),
    ];
    $list = StudentCourseGrade::join($courseTableName, $courseTableName.'.id', '=', $studentCourseGradeTableName.'.courseId' )
                              ->select($selectFieldAry)
                              ->groupBy(\DB::raw($courseTableName.'.name,gradelevel'));
    return $list->get()->toArray();
  }

  
}