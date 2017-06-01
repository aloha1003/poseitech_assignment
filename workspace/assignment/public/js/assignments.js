"use strict";
$(document).ready(function(){
  var addStudentBtn = $('#addStudentBtn');
  //查詢特定的學生
  var studentIdOnlyOne = $('#studentIdOnlyOne');
  //依條件查詢
  var studentId = $('#studentIdByQuery');
  var studentName = $('#studentNameByQuery');
  var registerDate = $('#registerDateByQuery');
  //查詢所有學生
  var startRow = $('#startRow');
  var limit = $('#limit');
  //學生列表
  var studentList = $('#studentList');
  var studentListBody = $('#studentListBody');
  //新增學生回傳的表格
  var studentUriContainer = $('#studentUriContainer');
  var studentUriContainerBody = $('#studentUriContainerBody');
  //分數列表
  var gradeList = $('#gradeList');
  var gradeListBody = $('#gradeListBody');
  //新增學生表單
  var addStudentFormStudentName = $('#addStudentFormStudentName');
  var addStudentFormRegisterDate = $('#addStudentFormRegisterDate');
  var addStudentFormRemark = $('#addStudentFormRemark');
  //API回傳結果
  var apiResult = $('#apiResult');
  resetView();
  $('body').delegate('.tabNav', 'click', function(){
      //清掉查詢結果
      resetView();
  });
  $('body').delegate('#searchBtnById', 'click', function(){
    getStudentByGetStudentId();
  });
  $('body').delegate('#searchBtnByQuery', 'click', function(){
    listStudentByQuery();
  });
  $('body').delegate('#searchBtnByAll', 'click', function(){
    listStudentByAll();
  });
  $('body').delegate('#addStudentBtn', 'click', function(){
    var data = {
              name: addStudentFormStudentName.val(),
              registerDate: addStudentFormRegisterDate.val(),
              remark: addStudentFormRemark.val(),
              };
    $.ajax({
        url : '/assignments/api/v1/students?method=c',
        data : data,
        method: 'POST',
        success : function(data) {
          output(syntaxHighlight(data));
          if (typeof data.data != 'undefined') {
            renderStudentListWithUri(data.data);
          }
          if (typeof data.error != 'undefined') {
            alert(data.error);
          }
        },
        dataType: "json"
        }
      ).fail(function() {
        console.log( "error" );
      })
      .always(function() {
        console.log( "complete" );
      })
    ;
  });
  $('body').delegate('#tabQueryGradeTab', 'click', function(){
    getStudentGrade();
  });
  function resetView()
  {
    studentList.children('tbody').empty();
    studentList.hide();
    studentUriContainer.children('tbody').empty();
    studentUriContainer.hide();
    gradeList.children('tbody').empty();
    gradeList.hide();
    output('');
  }
  function getStudentByGetStudentId() {
    var studentId = studentIdOnlyOne.val();
    $.ajax({
        url : '/assignments/api/v1/students/'+studentId,
        method: 'GET',
        success : function(data) {
          output(syntaxHighlight(data));
          if (typeof data.data != 'undefined') {
            var list = [];
            if (data.data.length > 0) {
              list.push(data.data);
            } 
            renderStudentListItem(list);
          }
          if (typeof data.error != 'undefined') {
            alert(data.error);
          }
        },
        dataType: "json"
        }
      ).fail(function() {
        console.log( "error" );
      })
      .always(function() {
        console.log( "complete" );
      })
    ;
  }
  function listStudentByAll() {
    var data = {
      start: startRow.val(),
      limit: limit.val(),
    };
    $.ajax({
        url : '/assignments/api/v1/students',
        data : data,
        method: 'POST',
        success : function(data) {
          output(syntaxHighlight(data));
          if (typeof data.data != 'undefined') {
            renderStudentListItem(data.data);
          }
          if (typeof data.error != 'undefined') {
            alert(data.error);
          }
        },
        dataType: "json"
        }
      ).fail(function() {
        console.log( "error" );
      })
      .always(function() {
        console.log( "complete" );
      })
    ;
  }

  function listStudentByQuery() {
    var data = {
      id: studentId.val(),
      studentName: studentName.val(),
      registerDate: registerDate.val(),
    };
    $.ajax({
        url : '/assignments/api/v1/students?method=r',
        data : data,
        method: 'POST',
        success : function(data) {
          output(syntaxHighlight(data));
          if (typeof data.data != 'undefined') {
            renderStudentListItem(data.data);
          }
          if (typeof data.error != 'undefined') {
            alert(data.error);
          }
        },
        dataType: "json"
        }
      ).fail(function() {
        console.log( "error" );
      })
      .always(function() {
        console.log( "complete" );
      })
    ;
  }

  function getStudentGrade() {
    $.ajax({
        url : '/assignments/api/v1/students/grades',
        method: 'GET',
        success : function(data) {
          output(syntaxHighlight(data));
          if (typeof data.data != 'undefined') {
            renderGrade(data.data);
          }
          if (typeof data.error != 'undefined') {
            alert(data.error);
          }
        },
        dataType: "json"
        }
      ).fail(function() {
        console.log( "error" );
      })
      .always(function() {
        console.log( "complete" );
      })
    ;
  }

  
  function renderGrade(data)
  {
    gradeList.show();
    gradeList.children('tbody').empty();
    if (data.length > 0) {
      $.get('/js/template/assignments/course.html', function(template) {
      gradeListBody.append(template);
        $( "#courseTmpl" ).tmpl( data ).appendTo('#gradeListBody');
      });  
    } else {
      gradeListBody.html('<tr><td colspan=3>找不到任何成績分佈</td></tr>');
    }
  }
  function renderStudentListItem(data)
  {
    studentList.show();
    studentList.children('tbody').empty();
    if (data.length > 0) {
      $.get('/js/template/assignments/student.html', function(template) {
      studentListBody.append(template);
        $( "#studentListTmpl" ).tmpl( data ).appendTo('#studentListBody');
      });  
    } else {
      studentListBody.html('<tr><td colspan="3">找不到任何學生</td></tr>');
    }
  }


  function renderStudentListWithUri(data)
  {
    studentUriContainer.show();
    studentUriContainer.children('tbody').empty();
    if (!Array.isArray(data) && Object.getOwnPropertyNames(data).length > 0) {
      $.get('/js/template/assignments/studentWithUri.html', function(template) {
        studentUriContainerBody.append(template);
        $( "#studentItemWithUriTmpl" ).tmpl( data ).appendTo('#studentUriContainerBody');
      });  
    } else {
      studentListBody.html('<tr><td colspan="4">找不到任何學生</td></tr>');
    }
  }
  function output(data){
    apiResult.html(data);
  }
  function syntaxHighlight(data) {
    var json = JSON.stringify(data, undefined, 4);
    json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
        var cls = 'number';
        if (/^"/.test(match)) {
            if (/:$/.test(match)) {
                cls = 'key';
            } else {
                cls = 'string';
            }
        } else if (/true|false/.test(match)) {
            cls = 'boolean';
        } else if (/null/.test(match)) {
            cls = 'null';
        }
        return '<span class="' + cls + '">' + match + '</span>';
    });
  }
  
});