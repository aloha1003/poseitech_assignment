<?php

use Illuminate\Database\Seeder;

use Faker\Factory as Faker;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        // $this->call(UsersTableSeeder::class);
        $faker = Faker::create();
        foreach (range(1,100) as $index) {
            DB::table('student')->insert([
                'name' => $faker->name,
                'birthday' => $faker->date,
                'registerDate' => $faker->date,
                 'remark' => $faker->text(100)
            ]);
        }
        $courseAry = array(
                            array(
                                  'name'=> 'English',
                                  'createDate'=> date("Y-m-d"),
                                  'remark'=> 'English'
                                  ),
                            array(
                                  'name'=> 'Math',
                                  'createDate'=> date("Y-m-d"),
                                  'remark'=> 'Math'
                                  ),
                            array(
                                  'name'=> 'Art',
                                  'createDate'=> date("Y-m-d"),
                                  'remark'=> 'Art'
                                  ),
                     );
        foreach ($courseAry as $key => $course) {
            DB::table('course')->insert($course);
        }

        //建立每個學生上課分數
        $gradelevelAry = [ 'A', 'B', 'C', 'D'];
        $studentIdAry  = DB::table('student')->select('id')->get()->toArray();
        $courseIdAry  = DB::table('course')->select('id')->get()->toArray();
        foreach ($studentIdAry as $key => $studentId) {
            foreach ($courseIdAry as $key => $courseId) {
                $insertData = [
                            'studentId' => $studentId->id,
                            'courseId' => $courseId->id,
                            'gradelevel' => $gradelevelAry[array_rand($gradelevelAry)],
                          ];
                DB::table('student_course_grade')->insert($insertData);
            }
        }
        
    }
}
