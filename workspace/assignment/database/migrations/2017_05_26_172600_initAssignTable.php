<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InitAssignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name', 60)
            ->nullable(false)
            ->comment = "學生中文全名";
            $table->date('birthday')
                  ->nullable()
                  ->comment = '學生出生年月日'
            ;
            $table->date('registerDate', 100)
                  ->nullable(false)
                  ->comment = '學生註冊日期'
            ;
            $table->string('remark')
                  ->nullable()
                  ->comment = '備註'
            ;
        });
        Schema::create('course', function (Blueprint $table) {
          $table->increments('id')->unsigned();
          $table->string('name', 60)
            ->nullable(false)
            ->comment = "專案中文或英文名稱";
          $table->date('createDate')
                  ->nullable(false)
                  ->comment = '建立日期'
            ;
          $table->string('remark', 100)->nullable()->comment= '備註';  
        });
        Schema::create('grade', function (Blueprint $table) {
          $table->char('level', 1)->nullable(false)->comment = '評等，如：A, B, C, D';
          $table->string('remark', 100)->nullable()->comment= '備註';
        });
        $sql = "CREATE TABLE `student_course_grade` (
                          `studentId` int(10) unsigned NOT NULL,
                          `courseId` int(10) unsigned NOT NULL,
                          `gradelevel` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
                          KEY `studentId` (`studentId`),
                          KEY `courseId` (`courseId`),
                          CONSTRAINT `courseId` FOREIGN KEY (`courseId`) REFERENCES `course` (`id`),
                          CONSTRAINT `studentId` FOREIGN KEY (`studentId`) REFERENCES `student` (`id`)
                  ) 
                ";
        DB::connection()->getPdo()->exec($sql);
        //建立修業成績的評等
        $gradeLevelAry = array(
                             array(
                                  'level'=> 'A',
                                  'remark'=> 'A',
                                  ),
                             array(
                                  'level'=> 'B',
                                  'remark'=> 'B',
                                  ),
                             array(
                                  'level'=> 'C',
                                  'remark'=> 'C',
                                  ),
                             array(
                                  'level'=> 'D',
                                  'remark'=> 'D',
                                  ),
                       );
        DB::table('grade')->insert($gradeLevelAry);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('student_course_grade');
      Schema::dropIfExists('student');
      Schema::dropIfExists('course');
      Schema::dropIfExists('grade');
    }
}
