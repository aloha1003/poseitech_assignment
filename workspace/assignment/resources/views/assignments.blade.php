<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>學生系統Demo</title>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
    </head>
    <body>
     <!-- Nav tabs -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#tabAddStudent" aria-controls="tabAddStudent" class="tabNav" role="tab" data-toggle="tab">新增學生</a></li>

        <li role="presentation"><a href="#tabSearchsearchBtnById" aria-controls="tabSearchsearchBtnById" class="tabNav" role="tab" data-toggle="tab">查詢特定的學生</a></li>
        <li role="presentation"><a href="#tabQueryBarByQuery" aria-controls="tabQueryBarByQuery" class="tabNav" role="tab" data-toggle="tab">依條件查詢學生</a></li>
        <li role="presentation"><a href="#tabQueryBarByAll" aria-controls="tabQueryBarByAll" class="tabNav" role="tab" data-toggle="tab">查詢所有學生</a></li>
        <li role="presentation"><a href="#tabQueryGrade" aria-controls="tabQueryGrade" class="tabNav" id="tabQueryGradeTab" role="tab" data-toggle="tab">查詢各科成績的學生人數</a></li>
      </ul>
      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="tabAddStudent">
            <form id="addStudentForm">
               <div class="form-group">
                    <label for="addStudentFormStudentName">學生姓名</label>
                    <input type="name" class="form-control" id="addStudentFormStudentName" placeholder="請輸入學生姓名">
                </div>
                <div class="form-group">
                    <label for="addStudentFormRegisterDate">註冊時間</label>
                    <input type="date" class="form-control" id="addStudentFormRegisterDate" placeholder="註冊時間">
                </div>
                <div class="form-group">
                    <label for="addStudentFormRemark">備註</label>
                    <textarea class="form-control" id="addStudentFormRemark" placeholder="備註" ></textarea>
                </div>
                <button type="button" id="addStudentBtn" class="btn btn-default">新增學生</button> 
            </form>
            
        </div>
        <div role="tabpanel" class="tab-pane" id="tabSearchsearchBtnById">
             <div class="col-md-12">
                <h2 class="h2">查詢特定的學生</h2>
                <input type="text" id="studentIdOnlyOne" placeholder="請輸入學生編號">
                <button id="searchBtnById" >按下搜尋</button>
             </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="tabQueryBarByQuery">
            <div class="col-md-12">
                <h2 class="h2">依條件查詢學生</h2>
                <input type="text" id="studentIdByQuery" placeholder="請輸入學生編號">
                <input type="text" id="studentNameByQuery" placeholder="請輸入學生姓名">
                <input type="text" id="registerDateByQuery" placeholder="請輸入學生註冊時間">

                <button id="searchBtnByQuery" >按下搜尋</button>
             </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="tabQueryBarByAll">
            <div  class="toolbar">
                <h2 class="h2">查詢所有學生</h2>
                <input type="text" id="startRow" placeholder="請輸入開始筆數">
                <input type="text" id="limit" placeholder="每頁幾筆">
                <button id="searchBtnByAll" >按下搜尋</button>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="tabQueryGrade">
            <div id="searchBarByGrade" class="toolbar">
                <h2 class="h2">查詢各科成績的學生人數</h2>
            </div>
        </div>
        
      </div>
      <label>API回傳結果</label>
      <pre id="apiResult">
      </pre>
    <table id="studentList" class="table table-bordered  table-hover">
        <thead>
            <th>學生編號</th>
            <th>姓名</th>
            <th>註冊時間</th>
        </thead>
        <tbody id="studentListBody">
            
        </tbody>
    </table>
    <table id="studentUriContainer" class="table table-bordered  table-hover">
        <thead>
            <th>學生編號</th>
            <th>姓名</th>
            <th>註冊時間</th>
            <th>Uri</th>
        </thead>
        <tbody id="studentUriContainerBody">
            
        </tbody>
    </table>
    <table id="gradeList" class="table table-bordered  table-hover">
        <thead>
            <th>Level</th>
            <th>課程名稱</th>
            <th>數量</th>
        </thead>
        <tbody id="gradeListBody">

        </tbody>
    </table>
    <span id="totalCount"></span>
    <script type="text/javascript" src="/js/jQuery-2.1.4.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/jquery.tmpl.js"></script>
    <script type="text/javascript" src="/js/assignments.js"></script>
    </body>
</html>
