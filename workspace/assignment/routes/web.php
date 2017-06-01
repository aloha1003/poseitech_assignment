<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('assignments');
});
Route::get('/assignments', function () {
    return view('assignments');
});
Route::group(['prefix' => '/assignments/api/v1/'], function() use ($router) {
      $router->get('/students/{studentId}', function ($studentId) {
        $app = App();
        try {
            if ($studentId == 'grades') {
                $parameters = [];
                $controller = $app->make('App\Http\Controllers\AssignmentController');
                return output_result($controller->callAction('getGrades', $parameters));
            } else {
                $controller = $app->make('App\Http\Controllers\AssignmentController');
                return output_result($controller->callAction('getStudent', $parameters = array(
                    $studentId
                )));
            }
            
        } catch (\Exception $e) {
            return output_errorresult(\App\Exceptions\ErrorHandler::exceptionHandler($this, $e));
        }
      });
      $router->match(['post', 'options','get'],'/students', function () {
        $app = App();  
        try {
            $parameters = [];
            if (request()->isMethod('post') && request()->has('method')) {
                $action = 'doDynamicMethod';
                $parameters = array(
                    request()['method']
                );
            } else {
                $action = 'queryAllStudent';
            }
            $controller = $app->make('App\Http\Controllers\AssignmentController');
            return output_result($controller->callAction($action, $parameters));
        } catch (\Exception $e) {
            return output_errorresult(\App\Exceptions\ErrorHandler::exceptionHandler($this, $e));
        }
      });
});
