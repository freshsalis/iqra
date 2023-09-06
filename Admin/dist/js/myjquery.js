/*##############################################################################
 Designed by: YUSUF SALISU BAKO
 Author	: Fresh salis
 2016 all right reserved
 ##############################################################################*/
 function requestFullScreen(element) {
  var requestMethod = element.requestFullScreen || element.webkitRequestFullScreen || element.mozRequestFullScreen || element.msRequestFullScreen;
  if (requestMethod) {
      requestMethod.call(element)
  } else if (typeof window.ActiveXObject !== "undefined") {
      var wscript = new ActiveXObject("WScript.Shell");
      if (wscript !== null) {
          wscript.SendKeys("{F11}");
      }
      
  }
}
function mode(idm, section_id="") {
  $(".alert1").hide();
  $(".error").hide();
  $("#update").show();

  var table = $(".edit").attr("rel");

  switch (table) {
    case "test":
      var data = "editTest";
      var id = "edit";
      // alert(idm)
      $.ajax({
        type: "POST",
        url: "asset/config/process.php",
        data: { data: data, idm: idm, id: id },
        success: function (msg) {
          // alert(msg)
          if (msg != "") {
            $(document).find(".myclass").html("");
            $(document).find(".myclass").html(msg);
            $(".alert1").hide();
            $("#error").hide();
            edit(idm, "test", section_id);
            return false;
          }
        },
      });
      break;

    case "paper":
        var data = "editPaper";
        var id = "edit";
        // alert(idm)
        $.ajax({
          type: "POST",
          url: "asset/config/process.php",
          data: { data: data, idm: idm, id: id },
          success: function (msg) {
            // alert(msg)
            if (msg != "") {
              $(document).find(".myclass").html("");
              $(document).find(".myclass").html(msg);
              $(".alert1").hide();
              $("#error").hide();
              edit(idm, "paper", section_id);
              return false;
            }
          },
        });
        break;

    case "exam":
      var data = "editExam";
      var id = "edit";
      // alert(idm)
      $.ajax({
        type: "POST",
        url: "asset/config/process.php",
        data: { data: data, idm: idm, id: id },
        success: function (msg) {
          // alert(msg)
          if (msg != "") {
            $(document).find(".myclass").html("");
            $(document).find(".myclass").html(msg);
            $(".alert1").hide();
            $("#error").hide();
            edit(idm, "exam", section_id);
            return false;
          }
        },
      });
      break;
  
    case "student":
      $(document).find(".myclass").html("");
      var data = "editStudent";
      var id = "edit";

      $.ajax({
        type: "POST",
        url: "asset/config/process.php",
        data: { data: data, idm: idm, id: id },
        success: function (msg) {
          if (msg != "") {
            $(document).find(".myclass").html("");
            $(document).find(".myclass").html(msg);
            $(".modal").find(".panel-heading").html("<h3>Edit Student</h3>");
            edit(idm, "student", section_id);
          }
        },
      });
      return false;
      break;

    case "question":
      var data = "editQuestion";
      var id = "edit";


      var type = section_id

      $.ajax({
        type: "POST",
        url: "asset/config/process.php",
        data: { data: data, idm: idm, id: id, type },
        success: function (msg) {
          if (msg != "") {
            $(document).find(".bx").html("");
            $(document).find(".bx").html(msg);
            $(".alert1").hide();
            $("#error").hide();
            edit(idm, "question", section_id);
          }
        },
      });
      return false;
      break;

    case "class":
      var data = "editClass";
      var id = "edit";
      $.ajax({
        type: "POST",
        url: "asset/config/process.php",
        data: { data: data, idm: idm, id: id },
        success: function (msg) {
          if (msg != "") {
            $(document).find(".myclass").html("");
            $(document).find(".myclass").html(msg);
            $(".alert1").hide();
            $("#error").hide();
            edit(idm, "class", section_id);
          }
        },
      });
      return false;
      break;
  }
}

function viewStudent() {
  var dta = "student";
  $.ajax({
    type: "POST",
    url: "confiq.php",
    data: "&data=" + dta,
    success: function (msg) {
      if (msg != "") {
        document.getElementById("qustn_tbl").innerHTML = msg;
      } else {
        document.getElementById("qustn_tbl").innerHTML =
          '<div class="noresult"<h3>Ooops! No Students found</h3></div>';
      }
    },
  });
}

function viewQuestion() {
  $("#view").on("change", function () {
    var dta = "question";
    $.ajax({
      type: "POST",
      url: "confiq.php",
      data: "&view=" + this.value + "&data=" + dta,
      success: function (msg) {
        if (msg != "") {
          return (document.getElementById("qustn_tbl").innerHTML = msg);
        } else {
          document.getElementById("qustn_tbl").innerHTML =
            '<div class="noresult"<h3>Ooops! No Questions found</h3></div>';
        }
      },
    });
  });
}

function viewResult() {
  $("#view").on("change", function () {
    $.ajax({
      type: "POST",
      url: "result_checker.php",
      data: "&view=" + this.value,
      success: function (msg) {
        if (msg != 0) {
          document.getElementById("qustn_tbl").innerHTML = msg;
        } else {
          document.getElementById("qustn_tbl").innerHTML =
            '<div class="noresult"<h3>Ooops! No Results found</h3></div>';
        }
      },
    });
  });
}

function viewTest() {
  var dta = "test";
  $.ajax({
    type: "POST",
    url: "confiq.php",
    data: "&data=" + dta,
    success: function (msg) {
      if (msg != "") {
        document.getElementById("qustn_tbl").innerHTML = msg;
      } else {
        document.getElementById("qustn_tbl").innerHTML =
          '<div class="noresult"<h3>Ooops! No Test found</h3></div>';
      }
    },
  });
}

function viewStaff() {
  var dta = "staff";
  $.ajax({
    type: "POST",
    url: "confiq.php",
    data: "&data=" + dta,
    success: function (msg) {
      if (msg != "") {
        document.getElementById("qustn_tbl").innerHTML = msg;
      } else {
        document.getElementById("qustn_tbl").innerHTML =
          '<div class="noresult"<h3>Ooops! No results found</h3></div>';
      }
    },
  });
}

function viewClass() {
  var dta = "class";
  $.ajax({
    type: "POST",
    url: "confiq.php",
    data: "&data=" + dta,
    success: function (msg) {
      if (msg != "") {
        document.getElementById("qustn_tbl").innerHTML = msg;
      } else {
        document.getElementById("qustn_tbl").innerHTML =
          '<div class="noresult"<h3>Ooops! No Class found</h3></div>';
      }
    },
  });
}

function add() {
  var table = $(".add").attr("rel");

  switch (table) {
    case "Test":
      var dt = "addTest";
      // alert(dt)
      $.ajax({
        type: "POSt",
        url: "confiq.php",
        data: "&data=" + dt,
        success: function (msg) {
          $(document).find("#editbody").html("");
          $(document).find("#editbody").html(msg);
          $(".modal")
            .find(".panel-heading")
            .html("<h3><strong>Add test</strong></h3>");
          $("form").find("#updateT").text("Add");
          insert("test");
        },
      });

      break;

      case "paper":
      var dt = "addPaper";
      // alert(dt)
      $.ajax({
        type: "POSt",
        url: "confiq.php",
        data: "&data=" + dt,
        success: function (msg) {
          $(document).find("#editbody").html("");
          $(document).find("#editbody").html(msg);
          $(".modal")
            .find(".panel-heading")
            .html("<h3><strong>Add test</strong></h3>");
          $("form").find("#updateT").text("Add");
          insert("test");
        },
      });

      break;

    case "Class":
      var dt = "addClass";

      $.ajax({
        type: "POSt",
        url: "confiq.php",
        data: "&data=" + dt,
        success: function (msg) {
          $(document).find("#editbody").html("");
          $(document).find("#editbody").html(msg);
          $(".modal").find(".panel-heading").html("<h3>Add Class</h3>");
          $(".modal").find("#update").text("Add");
          insert("class");
        },
      });

      break;

    case "Student":
      var dt = "addStudent";
      alert("ok");
      $.ajax({
        type: "POSt",
        url: "confiq.php",
        data: "&data=" + dt,
        success: function (msg) {
          $(document).find("#editbody").html(msg);
          $(".modal").find(".panel-heading").html("<h3>Add Student</h3>");
          $("form").find("#updateSt").text("Add");
          insert("student");
        },
      });

      break;

    case "Admin":
      var dt = "addStaff";

      $.ajax({
        type: "POSt",
        url: "confiq.php",
        data: "&data=" + dt,
        success: function (msg) {
          $("#updateS").show();
          $(document).find("#editbody").html("");
          $(document).find("#editbody").html(msg);
          $("#uname").attr("disabled", true);
          $(document).find(".panel-heading").html("<h3>Add Staff</h3>");
          $("form").find("#updateS").text("Add");
          insert("staff");
        },
      });

      break;
  }
}

function edit(idm, table, id) {
  switch (table) {
    /*####################### test  ######################*/
    case "test":
      $("#update").on("click", function (e) {
        e.preventDefault();
        var dt = "editTest";
        var formData =
          $("#studentForm").serialize() + "&dt=" + dt + "&idm=" + idm;
        $.ajax({
          type: "POST",
          url: "asset/config/edit.php",
          data: formData,
          success: function (msg) {
            // alert(msg)
            if (msg == 1) {
              $("#alert1")
                .html(
                  '<div class="alert alert1"><b>Success!</b> Edited Successfully</div>'
                )
                .css({ "background-color": "#F0F8FF", color: "green" });
              setTimeout(
                ' window.location = "viewTest.php?id=' + id + '"',
                2000
              );
              $("#update").hide();
            } else {
              $("#alert1").html(
                '<div class="alert alert-danger alert1"><b>Error! Sorry the there is an error in your request' +
                  msg +
                  "</div>"
              );
            }
          },
        });
      });
      break;

    case "exam":
        $("#update").on("click", function (e) {
          e.preventDefault();
          var dt = "editExam";
          var formData =
            $("#studentForm").serialize() + "&dt=" + dt + "&idm=" + idm;
          $.ajax({
            type: "POST",
            url: "asset/config/edit.php",
            data: formData,
            success: function (msg) {
              // alert(msg)
              if (msg == 1) {
                $("#alert1")
                  .html(
                    '<div class="alert alert1"><b>Success!</b> Exam Edited Successfully</div>'
                  )
                  .css({ "background-color": "#F0F8FF", color: "green" });
                // location.reload();
                // $("#update").hide();
              } else {
                $("#alert1").html(
                  '<div class="alert alert-danger alert1"><b>Error! Sorry the there is an error in your request' +
                    msg +
                    "</div>"
                );
              }
            },
          });
        });
        break;

    case "paper":
      $("#update").on("click", function (e) {
        e.preventDefault();
        var dt = "editPaper";
        var formData =
          $("#studentForm").serialize() + "&dt=" + dt + "&idm=" + idm;
        $.ajax({
          type: "POST",
          url: "asset/config/edit.php",
          data: formData,
          success: function (msg) {
            // alert(msg)
            if (msg == 1) {
              $("#alert1")
                .html(
                  '<div class="alert alert1"><b>Success!</b> Paper Edited Successfully</div>'
                )
                .css({ "background-color": "#F0F8FF", color: "green" });
              setTimeout(
                ' window.location = "?id=' + id + '"',
                2000
              );
              $("#update").hide();
            } else {
              $("#alert1").html(
                '<div class="alert alert-danger alert1"><b>Error! Sorry the there is an error in your request' +
                  msg +
                  "</div>"
              );
            }
          },
        });
      });
      break;

    //########################  student #############################
    case "student":
      $("#update").on("click", function (e) {
        e.preventDefault();
        var dt = "editStudent";
        var formData =
          $("#studentForm").serialize() + "&dt=" + dt + "&idm=" + idm;
        $.ajax({
          type: "POST",
          url: "asset/config/edit.php",
          data: formData,
          success: function (msg) {
            if (msg == 0) {
              $(document)
                .find("#error")
                .html(
                  '<div class="alert alert-danger"><strong>ERROR!</strong> Username already exist</div>'
                );
              return false;
            } else if (msg == 1) {
              $(".modal")
                .find("#error")
                .html(
                  '<div class="alert alert-success"><strong>SUCCESS!</strong> Student edited successfully</div>'
                );
              setTimeout(
                ' window.location = "viewStudent.php?id=' + id + '"',
                2000
              );
              $("#update").hide();
            } else {
              $(document)
                .find("#error")
                .html(
                  '<div class="alert alert-danger"><strong>ERROR!</strong> Can\'t process your request Try again.</div>'
                );
              return false;
            }
          },
        });
      });

      break;

    case "question":
      $("#update").on("click", function (e) {
        e.preventDefault();
        var dt = "editQuestion";
        var formData =
          $("#studentForm").serialize() + "&dt=" + dt + "&idm=" + idm;
        $.ajax({
          type: "POST",
          url: "asset/config/edit.php",
          data: formData,
          success: function (msg) {
            if (msg == 0) {
              $(document)
                .find("#alert1")
                .html(
                  '<div class="alert alert-danger"><strong>ERROR!</strong> try again...</div>'
                );
              return false;
            } else if (msg == 1) {
              $(document)
                .find("#alert1")
                .html(
                  '<div class="alert alert-success"><strong>SUCCESS!</strong> Question edited successfully</div>'
                );
              location.reload();
              //    $('#update').hide();
            } else {
              $(document)
                .find("#alert1")
                .html(
                  '<div class="alert alert-danger"><strong>ERROR!</strong> Can\'t process your request Try again.</div>'
                );
              return false;
            }
          },
        });
      });

      break;
    //#######################   class   ##########################
    case "class":
      $("#update").on("click", function (e) {
        e.preventDefault();
        var dt = "editClass";
        var formData = $("#cbt").serialize() + "&dt=" + dt + "&idm=" + idm;
        $.ajax({
          type: "POST",
          url: "asset/config/edit.php",
          data: formData,
          success: function (msg) {
            if (msg == 1) {
              $("#alert1")
                .html(
                  '<div class="alert alert1"><b>Success!</b> Edited Successfully</div>'
                )
                .css({ "background-color": "#F0F8FF", color: "green" });
              setTimeout(' window.location = "viewClass.php"', 1000);
              $("#update").hide();
            } else {
              $("#alert1").html(
                '<div class="alert alert-danger alert1"><b>Error! Sorry the there is an error in your request' +
                  msg +
                  "</div>"
              );
            }
          },
        });
      });

      break;
  }
}

function myDelete(idm, id) {
  var table = $(".delete").attr("rel");
  switch (table) {
    case "test":
      $("#ok").on("click", function () {
        $.ajax({
          type: "POST",
          url: "asset/config/delete.php",
          data: "&idm=" + idm + "&table=" + table,
          success: function (msg) {
            if (msg == 1) {
              setTimeout(
                ' window.location = "viewTest.php?id=' + id + '"',
                500
              );
            }
          },
        });
        $("#del").on("click", function () {});
      });
      break;

    case "student":
      $("#ok").on("click", function () {
        $.ajax({
          type: "POST",
          url: "asset/config/delete.php",
          data: "&idm=" + idm + "&table=" + table,
          success: function (msg) {
            if (msg == 1) {
              setTimeout(
                ' window.location = "viewStudent.php?id=' + id + '"',
                500
              );
            }
          },
        });
      });
      break;

    case "staff":
      $("#ok").on("click", function () {
        $.ajax({
          type: "POST",
          url: "delete.php",
          data: "&idm=" + idm + "&table=" + table,
          success: function (msg) {
            if (msg == 1) {
            }
          },
        });
      });
      break;

    case "question":
      $("#ok").on("click", function () {
        $.ajax({
          type: "POST",
          url: "asset/config/delete.php",
          data: "&idm=" + idm + "&table=" + table,
          success: function (msg) {
            if (msg == 1) {
              setTimeout(
                ' window.location = "viewQuestion.php?id=' + id + '"',
                500
              );
            }
          },
        });
      });
      break;
    
    case "class":
      $("#ok").on("click", function () {
        $.ajax({
          type: "POST",
          url: "asset/config/delete.php",
          data: "&idm=" + idm + "&table=" + table,
          success: function (msg) {
            if (msg == 1) {
              setTimeout(' window.location = "viewClass.php"', 500);
            }
          },
        });
      });

      break;
    
    case "paper":
      $("#ok").on("click", function () {

        $.ajax({
          type: "POST",
          url: "asset/config/delete.php",
          data: "&idm=" + idm + "&table=" + table,
          success: function (msg) {
            if (msg == 1) {
              // setTimeout(' window.location = ""', 500);
              location.reload()
            }
          },
        });
      });

      break;
    
    case "exam":
     
        $("#ok").on("click", function () {

          $.ajax({
            type: "POST",
            url: "asset/config/delete.php",
            data: "&idm=" + idm + "&table=" + table,
            success: function (msg) {
              if (msg == 1) {
                // setTimeout(' window.location = ""', 500);
                location.reload()
              }
            },
          });
        });

        break;
  
  }

}

function insert(table) {
  //alert('ok')
  switch (table) {
    case "test":
      var dta = "insertTest";
      $("#form1").submit(function (e) {
        e.preventDefault();
        var formData = $(this).serialize() + "&data=" + dta;
        alert(formData);
        $.ajax({
          type: "POST",
          url: "confiq.php",
          data: formData,
          success: function (msg) {
            if (msg == 0) {
              $(document)
                .find("#error")
                .html(
                  '<div class="alert alert-danger"><strong>ERROR! </strong>Test already exis</div>'
                );
              return false;
            } else if (msg == 1) {
              $(document)
                .find("#error")
                .html(
                  '<div class="alert alert-success"><strong>SUCCESS!</strong> Test added successfully</div>'
                );
            } else {
              $(document)
                .find("#error")
                .html(
                  '<div class="alert alert-danger"><strong>Error!</strong>ggf All fields are required </div>'
                );
              return false;
            }
          },
        });
      });
      return false;
      break;

    case "class":
      var dta = "insertClass";
      $("#update").click(function (e) {
        e.preventDefault();
        var formData = $("#cbt").serialize() + "&data=" + dta;
        $.ajax({
          type: "POST",
          url: "confiq.php",
          data: formData,
          success: function (msg) {
            if (msg == 0) {
              $(document)
                .find("#error")
                .html(
                  '<div class="alert alert-danger"><strong>ERROR!</strong> Class already exist</div>'
                );
              return false;
            } else if (msg == 1) {
              $(document)
                .find("#error")
                .html(
                  '<div class="alert alert-success"><strong>SUCCESS!</strong> Class added successfully</div>'
                );
            } else if (msg == 3) {
              $(document)
                .find("#error")
                .html(
                  '<div class="alert alert-danger"><strong>ERROR!</strong> Enter a valid Class name</div>'
                );
              return false;
            } else {
              $(document)
                .find("#error")
                .html(
                  '<div class="alert alert-danger"><strong>ERROR!</strong> Can\'t pocess your request Try again.</div>'
                );
              return false;
            }
          },
        });
      });
      return false;
      break;

    case "staff":
      var dta = "insertStaff";
      $("#staffForm").submit(function (e) {
        e.preventDefault();

        var formData = $(this).serialize() + "&data=" + dta;
        $.ajax({
          type: "POST",
          url: "confiq.php",
          data: formData,
          success: function (msg) {
            if (msg == 0) {
              $(document)
                .find("#error")
                .html(
                  '<div class="alert alert-danger"><strong>ERROR!</strong> Username already exist</div>'
                );
              return false;
            } else if (msg == 1) {
              $(document)
                .find("#error")
                .html(
                  '<div class="alert alert-success"><strong>SUCCESS!</strong> Staff added successfully</div>'
                );
            } else if (msg == 3) {
              $(document)
                .find("#error")
                .html(
                  '<div class="alert alert-danger"><strong>ERROR!</strong> All fields required</div>'
                );
              return false;
            } else {
              $(document)
                .find("#error")
                .html(
                  '<div class="alert alert-danger"><strong>ERROR!</strong> Can\'t pocess your request Try again.</div>'
                );
              return false;
            }
          },
        });
      });
      return false;
      break;

    case "student":
      var dta = "insertStudent";
      $("#studentForm").submit(function (e) {
        e.preventDefault();
        //
        var formData = $(this).serialize() + "&data=" + dta;
        // alert(formData)
        $.ajax({
          type: "POST",
          url: "confiq.php",
          data: formData,
          success: function (msg) {
            alert(msg);
            if (msg == 0) {
              $(document)
                .find("#error")
                .html(
                  '<div class="alert alert-danger"><strong>ERROR!</strong> Username already exist</div>'
                );
              return false;
            } else if (msg == 1) {
              $(document)
                .find("#error")
                .html(
                  '<div class="alert alert-success"><strong>SUCCESS!</strong> Student added successfully</div>'
                );
            } else if (msg == 3) {
              $(document)
                .find("#error")
                .html(
                  '<div class="alert alert-danger"><strong>ERROR!</strong> All fields required</div>'
                );
              return false;
            } else {
              $(document)
                .find("#error")
                .html(
                  '<div class="alert alert-danger"><strong>ERROR!</strong> Can\'t pocess your request Try again.</div>'
                );
              return false;
            }
          },
        });
      });
      return false;
      break;
  }
}

function submittest() {
  $(".submit").hide();
  var formData = jQuery("form").serialize();

  
  $.ajax({
    type: "POST",
    url: "process_ans.php",
    data: formData,
    success: function (html) {
      $(".qtn").fadeIn();
      $("#saveSubmit").hide();
      $(".qtn").html(html);
      localStorage.clear()
    },
  });
}

// add a leading zero when timer less than 10
function padZero(n) {
  return n < 10 ? "0" + n : n;
}
function countdown(id) {
  var m = $(".min");
  var s = $(".sec");
  var duration = $("#dur").val() / 60;
  var half_time = duration * (2 / 3);
  // alert(half_time+" "+duration)
  if (parseInt(m.html()) <= half_time) {
    $("#saveSubmit").removeClass("hidden");
  }
  
  localStorage.setItem(id,JSON.stringify({"min": parseInt(m.html()),"sec": parseInt(s.html())}))
  if (m.html() == 0 && parseInt(s.html()) <= 0) {
    $(".clock").html("Time UP");
    $(".question").hide();
    // $('.clock').html('Done');
    $(".clock").hide();
    $(".numNav").hide();
    $("#signout").hide();
    $("#signout").hide();

    submittest();
    setTimeout(' window.location = "./logout.php";', 40000);
    $("#saveSubmit").hide();
  }
  if (parseInt(s.html()) <= 0) {
    m.html(padZero(parseInt(m.html() - 1)));
    s.html(60);
  }
  if (parseInt(s.html()) <= 0) {
    $(".clock").html('<span class="sec">59</span> seconds. ');
  }
  s.html(padZero(parseInt(s.html() - 1)));

}

function optionClick(studentId) {
  $(".rg").change(function (e) {
    e.preventDefault();
    var qId = $(this).attr("rel");
    var role = $(this).attr("role");
    var option = $(this).val();
    var data = "optionClick";
    $(".num")
      .find("#" + role)
      .css({ color: "white", "background-color": "green", border: "0px" });

    //check radio butt

    $.ajax({
      type: "POST",
      url: "Admin/asset/config/process.php",
      cache: false,
      data:
        "&qId=" +
        qId +
        "&option=" +
        option +
        "&id=" +
        data +
        "&data=" +
        data +
        "&studentId=" +
        studentId,
        success: function (response) {},
        error: function (e) {
          alert("Error in network connection. Please contact system admin.")
        }
    });
  });
}

function confirmSubmit() {
  jQuery(".submit").click(function (e) {
    // if (confirm("Are you sure want to submit?") == true){
    $(".submit").hide();
    $(".clock").html("Done");
    $(".clock").hide();
    $(".numNav").hide();
    $("#signout").hide();
    $(".question").html(
      "<div class='jumbotron text-danger'><i>Submitted successfully</i></div>"
    );

    e.preventDefault();
    submittest();
    $("#confirmSubmit").modal("hide");
    $("#saveSubmit").hide();
    setTimeout(' window.location = "./logout.php";', 1000 * 60);

    // }
    return false;
  });
}

// this manages navigation
var t = parseInt(1); //current question

function manageQuestionApp() {
  $(".question").hide();
  $("#btnPrev").hide();
  var last = parseInt($(".last").val());
  $("#cquestion").html(t);
  $("#tquestion").html(last);
  $(".question:first").show();
  $(document).on("click", ".btnNavigate", function (e) {
    //e.preventDefault();
    var detr = $(this).attr("id");

    if (detr == "btnPrev") {
      t--;
      $("#cquestion").html(t);
      if (t <= 1) {
        $(".question:first").show();
        $("#c" + (t + 1)).hide();
        $("#btnPrev").hide();
      } else {
        $("#c" + (t + 1)).hide();
        $("#c" + (t - 1)).hide();
        $("#c" + t).show();
        $("#btnNext").show();
      }
    } else if (detr == "btnNext") {
      t++;
      $("#cquestion").html(t);
      $("#btnPrev").show();
      if (t >= last) {
        $("#cquestion").html(t);
        $("#btnNext").hide();
        $(".question").hide();
        $("#c" + t).show();
        $("#c" + (t - 1)).hide();
      } else {
        $("#c" + (t - 1)).hide();
        $(".question").hide();
        $("#c" + t).show();
      }
    } else {
    }
  });
}

function trackTimer(studentId, testId) {
  var min = parseInt($(".min").text()) * 60;
  var sec = parseInt($(".sec").text());
  var data = "trackTimer";

  var time = min + sec;

  // alert(time)
  $.ajax({
    type: "POST",
    url: "Admin/asset/config/process.php",
    cache: false,
    data:
      "&time=" +
      time +
      "&studentId=" +
      studentId +
      "&testId=" +
      testId +
      "&data=" +
      data +
      "&id=" +
      data,
    success: function (response) {},
    error: function (e) {
      alert("Error in network connection. Please contact system admin.")
    }
  });
}

function logout() {
  $(document).on("click", ".logout", function (e) {
    e.preventDefault();
    var data = "logout";
    $.ajax({
      type: "POST",
      url: "admin/confiq.php",
      cache: false,
      data: "&data=" + data,
      success: function (response) {
        if (response == 1) {
          setTimeout(' window.location = "cbt_login.php";', 1000);
        }
      },
    });
  });
}

function go() {
  window.location = "welcome.php";
}

function login() {
  jQuery(".login").submit(function (e) {
    e.preventDefault();
    $(".alert1").hide();
    jQuery("#error").hide();
    var uname = $("#username").val();
    var password = $("#pwd").val();
    var test = $("#exam").val();
    $.ajax({
      type: "POST",
      url: "login_parse.php",
      data: "&uname=" + uname + "&password=" + password + "&test=" + test,
      success: function (msg) {
        //    alert(msg)
        if (msg == 4) {
          jQuery(".alert1")
            .removeAttr("hidden")
            .html(
              '<span><img src="images/mm.gif"/></span><b>Success! </b>Login Sucessfully'
            )
            .fadeToggle("fast");
          jQuery("#error").hide();
          jQuery("#subm").hide();
          setTimeout("go()", 3000);
        } else if (msg == 2) {
          $(".alert1")
            .html(
              '<h6 class="text-danger">Error! Invalid username and password</h6>'
            )
            .fadeToggle("fast");
        } else if (msg == 3) {
          $(".alert1")
            .html(
              '<h6 class="text-danger">Error! an error occured processing your request</h6>'
            )
            .fadeToggle("fast");
        } else if (msg == 1) {
          $(".alert1")
            .html(
              '<h6 class="text-danger">Error! You have taken this test</h6>'
            )
            .fadeToggle("fast");
        } else if (msg == -1) {
          $(".alert1")
            .html(
              '<h6 class="text-danger">Locked! Your account has been locked. Contact system admin.</h6>'
            )
            .fadeToggle("fast");
        } else {
          $(".alert1")
            .html(
              '<h6 class="text-danger">Error! You have not registered for this test</h6>'
            )
            .fadeToggle("fast");
        }
      },
    });
    return false;
  });
}

function go1() {
  window.location = "index.php";
}

function adminLogin() {
  jQuery(".admin-login").submit(function (e) {
    e.preventDefault();
    $(".alert1").hide();
    jQuery("#error").hide();
    var uname = $("#username").val();
    var password = $("#pwd").val();
    // alert(uname)
    $.ajax({
      type: "POST",
      url: "admin_gateway.php",
      data: "&uname=" + uname + "&password=" + password,
      success: function (msg) {
        if (msg == 4) {
          jQuery(".alert1")
            .removeAttr("hidden")
            .html(
              '<span><img src="../images/mm.gif"/></span><b>Success! </b>Login Sucessfully'
            )
            .fadeToggle("fast");
          jQuery("#error").hide();
          jQuery("#subm").hide();
          setTimeout("go1()", 3000);
        }
        //else alert(msg);/*
        else if (msg == 2) {
          $(".alert1")
            .html(
              '<h6 class="text-danger">Error! Invalid username and password</h6>'
            )
            .fadeToggle("fast");
        } else {
          $(".alert1")
            .html('<h6 class="text-danger">Error! cannot login,try again</h6>')
            .fadeToggle("fast");
        }
        //*/
      },
    });
    return false;
  });
}

function examinerLogin() {
  jQuery(".examiner-login").submit(function (e) {
    e.preventDefault();
    $(".alert1").hide();
    jQuery("#error").hide();
    var uname = $("#username").val();
    var password = $("#pwd").val();
    // alert(uname)
    $.ajax({
      type: "POST",
      url: "examiner_gateway.php",
      data: "&uname=" + uname + "&password=" + password,
      success: function (msg) {
        if (msg == 4) {
          jQuery(".alert1")
            .removeAttr("hidden")
            .html(
              '<span><img src="../images/mm.gif"/></span><b>Success! </b>Login Sucessfully'
            )
            .fadeToggle("fast");
          jQuery("#error").hide();
          jQuery("#subm").hide();
          setTimeout(function () {
            window.location="dashboard.php"
          }, 3000);
        }
        //else alert(msg);/*
        else if (msg == 2) {
          $(".alert1")
            .html(
              '<h6 class="text-danger">Error! Invalid username and password</h6>'
            )
            .fadeToggle("fast");
        } else {
          $(".alert1")
            .html('<h6 class="text-danger">Error! cannot login,try again</h6>')
            .fadeToggle("fast");
        }
        //*/
      },
    });
    return false;
  });
}

function updateScore(questionId, score) {
  if (scores.hasOwnProperty(questionId)) {
    // If the questionId already exists, update the score
    scores[questionId] = score;
  } else {
    // If the questionId doesn't exist, insert the score
    scores[questionId] = score;
  }
}

/*
 *  document dot ready
 * */
const scores = {};
var total_grade = 0;

$(document).ready(function (e) {
  // full screen
  login();
  adminLogin();
  examinerLogin();
  manageQuestionApp();
  $(".alert1").hide();


  // generate num nav when loading...
  var a = $(".last").val();
  for (var i = 1; i <= a; i++) {
    var btn = $("#c" + i)
      .find("#val")
      .val();
    if (btn != 5) {
      $(".num")
        .find("#c" + i)
        .css({ color: "white", "background-color": "green" });
    }
  }
  /* ############################## add button clicked ######################*/
  $(document).on("click", ".add", function (e) {
    $(".msg")
          .removeAttr("hidden")
          .show()
          .text("Please wait...")
          
    e.preventDefault();
    var id = $(this).attr("id");
    var data = $(this).attr("rel");
    switch (data) {
      case "Question":
        // var form_data = new FormData();
        var form_data = new FormData();
       
        var question = CKEDITOR.instances.editor.getData();
        var test_id = $("#test_id").val();
        var type = $("#type_id").val();
        form_data.append("test_id", test_id);

        if (type ==1) {
          var file_data = $("#file").prop("files")[0];
          var opt1 = CKEDITOR.instances.editor2.getData();
          var opt2 = CKEDITOR.instances.editor3.getData();
          var opt3 = CKEDITOR.instances.editor4.getData();
          var opt4 = CKEDITOR.instances.editor5.getData();
          var answer = $("#answer").val();
          var section = $("#section").val();
          form_data.append("file", file_data);
          form_data.append("opt1", opt1);
          form_data.append("opt2", opt2);
          form_data.append("opt3", opt3);
          form_data.append("opt4", opt4);
          form_data.append("answer", answer);
          form_data.append("type", type);
        }else{
          var mark1 = $("#mark1").val()
          var mark2 = $("#mark2").val()
          var mark3 = $("#mark3").val()
          var mark4 = $("#mark4").val()


          form_data.append("mark1", mark1);
          form_data.append("mark2", mark2);
          form_data.append("mark3", mark3);
          form_data.append("mark4", mark4);
          form_data.append("type", type);

        }
       
        form_data.append("question1", question);
        form_data.append("data", data);
        form_data.append("id", id);
        form_data.append("section", section);

        $.ajax({
          type: "POST",
          url: "asset/config/process.php",
          dataType: "text", // what to expect back from the PHP script, if anything
          cache: false,
          contentType: false,
          processData: false,
          data: form_data,
          type: "post",
          success: function (msg) {
            //  alert(msg)
            if (msg == 1) {
              $(".msg")
                .removeAttr("hidden")
                .show()
                .text("Question successfully added")
                .css({ color: "green", padding: "10px", "font-weight": "bold" })
                .fadeOut(10000);
              // $(".form-control").val("");
            } else if (msg == 4) {
              $(".msg")
                .removeAttr("hidden")
                .show()
                .text("All the fields cannot be empty")
                .css({ color: "red", padding: "10px", "font-weight": "bold" })
                .fadeOut(10000);
            } else {
              $(".msg")
                .removeAttr("hidden")
                .show()
                .text(msg)
                .css({ color: "red", padding: "10px", "font-weight": "bold" });
            }
          },
        });
        break;

        break;
      default: //end ajax

      var formData = $(".form-add").serialize() + "&id=" + id + "&data=" + data;
      if (data == 'test') {

        var qps = $('#quest-section').val();
        var qpst = $('#qstn-student').val();


        const cmpr = qps.split(",").reduce((acc, num)=> acc + Number(num), 0);
  
        if (cmpr != Number(qpst)) {
          $(".msg")
            .removeAttr("hidden")
            .show()
            .text("Error! Question per section does not sums to question per student")
            .css({
              color: "red",
              padding: "10px",
              "font-weight": "bold",
            });
            return;
        }
        formData =
          $(".form-add").serialize() + "&id=" + id + "&data=" + data;
      }
      
        console.log($(".form-add").serialize())
        $(".msg").attr("hidden");

        $.ajax({
          type: "POST",
          url: "asset/config/process.php",
          cache: false,
          data: formData,
          success: function (msg) {
            // alert(msg)
            switch (data) {
              case "class":
                if (msg == 1) {
                  $(".msg")
                    .removeAttr("hidden")
                    .show()
                    .text("Class successfully added")
                    .css({
                      color: "green",
                      padding: "10px",
                      "font-weight": "bold",
                    });
                  // .fadeOut(6000);
                } else if (msg == 0) {
                  $(".msg")
                    .removeAttr("hidden")
                    .show()
                    .text("Class name already exist")
                    .css({
                      color: "red",
                      padding: "10px",
                      "font-weight": "bold",
                    });
                  // .fadeOut(6000);
                } else if (msg == 2) {
                  $(".msg")
                    .removeAttr("hidden")
                    .show()
                    .text("Unable to insert, try again")
                    .css({
                      color: "red",
                      padding: "10px",
                      "font-weight": "bold",
                    });
                  // .fadeOut(6000);
                } else if (msg == 3) {
                  $(".msg")
                    .removeAttr("hidden")
                    .show()
                    .text("Class name cannot be empty")
                    .css({
                      color: "red",
                      padding: "10px",
                      "font-weight": "bold",
                    });
                }
                break;
              case "student":
                if (msg == 1) {
                  $(".msg")
                    .removeAttr("hidden")
                    .show()
                    .text("Student successfully added")
                    .css({
                      color: "green",
                      padding: "10px",
                      "font-weight": "bold",
                    });
                  // .fadeOut(10000);
                } else if (msg == 0) {
                  $(".msg")
                    .removeAttr("hidden")
                    .show()
                    .text("Student regno already exist")
                    .css({
                      color: "red",
                      padding: "10px",
                      "font-weight": "bold",
                    });
                  // .fadeOut(10000);
                } else if (msg == 2) {
                  $(".msg")
                    .removeAttr("hidden")
                    .show()
                    .text("Unable to insert, try again")
                    .css({
                      color: "red",
                      padding: "10px",
                      "font-weight": "bold",
                    });
                  // .fadeOut(6000);
                } else if (msg == 4) {
                  $(".msg")
                    .removeAttr("hidden")
                    .show()
                    .text("Some fields cannot be empty")
                    .css({
                      color: "red",
                      padding: "10px",
                      "font-weight": "bold",
                    });
                  // .fadeOut(10000);
                } else {
                  $(".msg").removeAttr("hidden").show().text(msg).css({
                    color: "red",
                    padding: "10px",
                    "font-weight": "bold",
                  });
                  // .fadeOut(10000);
                }
                break;
              case "test":
                // alert(msg)
                if (msg == 1) {
                  $(".msg")
                    .removeAttr("hidden")
                    .show()
                    .text("Test successfully added")
                    .css({
                      color: "green",
                      padding: "10px",
                      "font-weight": "bold",
                    });
                  setTimeout(function () {
                    window.location = "#msg";
                  }, 100);
                  // .fadeOut(6000);
                } else if (msg == 0) {
                  $(".msg")
                    .removeAttr("hidden")
                    .show()
                    .text("Test already exist")
                    .css({
                      color: "red",
                      padding: "10px",
                      "font-weight": "bold",
                    });
                  // .fadeOut(6000);
                } else if (msg == 2) {
                  $(".msg")
                    .removeAttr("hidden")
                    .show()
                    .text("Unable to insert, try again")
                    .css({
                      color: "red",
                      padding: "10px",
                      "font-weight": "bold",
                    })
                    .fadeOut(6000);
                } else if (msg == 3) {
                  $(".msg")
                    .removeAttr("hidden")
                    .show()
                    .text("Some fields cannot be empty")
                    .css({
                      color: "red",
                      padding: "10px",
                      "font-weight": "bold",
                    });
                  // .fadeOut(6000);
                }
                break;
              case "exam":
                  if (msg == 1) {
                    $(".msg")
                      .removeAttr("hidden")
                      .show()
                      .text("Exam successfully created")
                      .css({
                        color: "green",
                        padding: "10px",
                        "font-weight": "bold",
                      });
                    // .fadeOut(10000);
                  } else if (msg == 0) {
                    $(".msg")
                      .removeAttr("hidden")
                      .show()
                      .text("Exam already exist")
                      .css({
                        color: "red",
                        padding: "10px",
                        "font-weight": "bold",
                      });
                    // .fadeOut(10000);
                  } else if (msg == 2) {
                    $(".msg")
                      .removeAttr("hidden")
                      .show()
                      .text("Unable to insert, try again")
                      .css({
                        color: "red",
                        padding: "10px",
                        "font-weight": "bold",
                      });
                    // .fadeOut(6000);
                  } else if (msg == 4) {
                    $(".msg")
                      .removeAttr("hidden")
                      .show()
                      .text("Some fields cannot be empty")
                      .css({
                        color: "red",
                        padding: "10px",
                        "font-weight": "bold",
                      });
                    // .fadeOut(10000);
                  } else {
                    $(".msg").removeAttr("hidden").show().text(msg).css({
                      color: "red",
                      padding: "10px",
                      "font-weight": "bold",
                    });
                    // .fadeOut(10000);
                  }
                break;
            } //end inner switch
          }, //success function
        });
        break;
    } //outer switch
  });

  // new codes --- Add paper -----
  $(document).on("submit", "#paper-form", function (e) {
    e.preventDefault();

    var id = "add";
    var data = "paper";

    $(".msg")
          .removeAttr("hidden")
          .show()
          .text("Please wait...")

    var form_data = $(this).serialize() + "&id=" + id + "&data=" + data;
    $.ajax({
      type: "POST",
      url: "asset/config/process.php",
      cache: false,
      data: form_data,
      success: function (msg) {
        // alert(msg)
        if (msg == 1) {
          $(".msg")
            .removeAttr("hidden")
            .show()
            .text("Paper successfully added")
            .css({
              color: "green",
              padding: "10px",
              "font-weight": "bold",
            });
          location.reload();
          // .fadeOut(6000);
        } else if (msg == 0) {
          $(".msg")
            .removeAttr("hidden")
            .show()
            .text("Paper already exist")
            .css({
              color: "red",
              padding: "10px",
              "font-weight": "bold",
            });
          // .fadeOut(6000);
        } else if (msg == 2) {
          $(".msg")
            .removeAttr("hidden")
            .show()
            .text("Unable to insert, try again")
            .css({
              color: "red",
              padding: "10px",
              "font-weight": "bold",
            })
            .fadeOut(6000);
        } else if (msg == 3) {
          $(".msg")
            .removeAttr("hidden")
            .show()
            .text("Some fields cannot be empty")
            .css({
              color: "red",
              padding: "10px",
              "font-weight": "bold",
            });
          // .fadeOut(6000);
        }
    }})

    $(".msg")
            .removeAttr("hidden")
            .show()
            .text("Error, please contact system admin.")
            .css({
              color: "red",
              padding: "10px",
              "font-weight": "bold",
            });
      return false;
  })

  $(document).on("submit", "#examiner-form", function (e) {
    e.preventDefault();

    var id = "add";
    var data = "examiner";

    $(".msg")
          .removeAttr("hidden")
          .show()
          .text("Please wait...")

    var form_data = $(this).serialize() + "&id=" + id + "&data=" + data;
    $.ajax({
      type: "POST",
      url: "asset/config/process.php",
      cache: false,
      data: form_data,
      success: function (msg) {
        // alert(msg)
        if (msg == 1) {
          $(".msg")
            .removeAttr("hidden")
            .show()
            .text("Examiner successfully added")
            .css({
              color: "green",
              padding: "10px",
              "font-weight": "bold",
            });
          location.reload();
          // .fadeOut(6000);
        } else if (msg == 0) {
          $(".msg")
            .removeAttr("hidden")
            .show()
            .text("Examiner already exist")
            .css({
              color: "red",
              padding: "10px",
              "font-weight": "bold",
            });
          // .fadeOut(6000);
        } else if (msg == 2) {
          $(".msg")
            .removeAttr("hidden")
            .show()
            .text("Unable to insert, try again")
            .css({
              color: "red",
              padding: "10px",
              "font-weight": "bold",
            })
            .fadeOut(6000);
        } else if (msg == 3) {
          $(".msg")
            .removeAttr("hidden")
            .show()
            .text("Some fields cannot be empty")
            .css({
              color: "red",
              padding: "10px",
              "font-weight": "bold",
            });
          // .fadeOut(6000);
        }
    }})

    $(".msg")
            .removeAttr("hidden")
            .show()
            .text("Error, please contact system admin.")
            .css({
              color: "red",
              padding: "10px",
              "font-weight": "bold",
            });
      return false;
  })

  $(document).on("submit", "#exam-form", function (e) {
    e.preventDefault();

    
    $(".msg")
          .removeAttr("hidden")
          .show()
          .text("Please wait...2")
    var id = "add";
    var data = "exam";

    var form_data = $(this).serialize() + "&id=" + id + "&data=" + data;
    $.ajax({
      type: "POST",
      url: "asset/config/process.php",
      cache: false,
      data: form_data,
      success: function (msg) {
        if (msg == 1) {
          $(".msg")
            .removeAttr("hidden")
            .show()
            .text("Paper successfully added")
            .css({
              color: "green",
              padding: "10px",
              "font-weight": "bold",
            });
          location.reload();
          // .fadeOut(6000);
        } else if (msg == 0) {
          $(".msg")
            .removeAttr("hidden")
            .show()
            .text("Paper already exist")
            .css({
              color: "red",
              padding: "10px",
              "font-weight": "bold",
            });
          // .fadeOut(6000);
        } else if (msg == 2) {
          $(".msg")
            .removeAttr("hidden")
            .show()
            .text("Unable to insert, try again")
            .css({
              color: "red",
              padding: "10px",
              "font-weight": "bold",
            })
            .fadeOut(6000);
        } else if (msg == 3) {
          $(".msg")
            .removeAttr("hidden")
            .show()
            .text("Some fields cannot be empty")
            .css({
              color: "red",
              padding: "10px",
              "font-weight": "bold",
            });
          // .fadeOut(6000);
        }
    }})

    $(".msg")
            .removeAttr("hidden")
            .show()
            .text("Error, please contact system admin.")
            .css({
              color: "red",
              padding: "10px",
              "font-weight": "bold",
            });
      return false;
  })

  /* ############################## upload button clicked ######################*/
  $(document).on("click", ".uploadStudents", function (e) {
    e.preventDefault();
    var test = $("#test_id").val();
    var batch = $("#batch").val();
    var file_data = $("#uploadFile").prop("files")[0];
    var form_data = new FormData();
    form_data.append("uploadFile", file_data);
    form_data.append("batch", batch);
    //append values into formData object
    form_data.append("test", test);
    $(".ul").hide();
    $(".spin").removeAttr("hidden").fadeIn(3000);
    $.ajax({
      url: "asset/config/uploadStudentsExcel.php",
      dataType: "text", // what to expect back from the PHP script, if anything
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      type: "post",
      success: function (msg) {
        e.preventDefault();
        // display response from the PHP script, if any
        $(".report").html(msg);
        $(".form-control").val("");

        return false;
      },
    }); //end ajax
  });

  $(document).on("click", ".upload", function (e) {
    e.preventDefault();
    var paper = $("#paper").val();
    var section = $("#section").val();
    var file_data = $("#uploadFile").prop("files")[0];
    var form_data = new FormData();
    form_data.append("uploadFile", file_data);
    form_data.append("section", section);
    // alert(section)
    //append values into formData object
    form_data.append("paper", paper);
    $(".ul").hide();
    $(".spin").removeAttr("hidden").fadeIn(3000);
    $.ajax({
      url: "asset/config/uploadExcel.php",
      dataType: "text", // what to expect back from the PHP script, if anything
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      type: "post",
      success: function (msg) {
        e.preventDefault();
        // display response from the PHP script, if any
        $(".report").html(msg);
        $("#example1").dataTable();
        $("#example2").dataTable({
          bPaginate: true,
          bLengthChange: false,
          bFilter: false,
          bSort: true,
          bInfo: true,
          bAutoWidth: false,
        });
        return false;
      },
    }); //end ajax
  });

  $(document).on("click", "#unlock", function (e) {
    e.preventDefault();
    var regno = $("#regno").val();
    var test_id = $("#test_id").val();
    $(".report").html("");
    $(".ul").hide();
    $(".spin").removeAttr("hidden").fadeIn(3000);
    $.ajax({
      url: "asset/config/edit.php",
      dataType: "text", // what to expect back from the PHP script, if anything
      cache: false,
      data: { dt: "unlock", regno: regno, test_id: test_id },
      type: "post",
      success: function (msg) {
        // alert(msg)
        e.preventDefault();
        // display response from the PHP script, if any
        if (msg == -1) {
          $(".report").html(
            '<b class="text-danger">This student was not scheduled to write this test.</b>'
          );
        } else if (msg == 1) {
          $(".report").html(
            '<b class="text-success">Student successfully unclocked.</b>'
          );
        } else {
          $(".report").html(
            '<b class="text-danger">Internal server error contact system admin.</b>'
          );
        }
        return false;
      },
    }); //end ajax
  });
  $(document).on("click", "#unlock_all", function (e) {
    e.preventDefault();
    //    var regno = $('#regno').val();
    if (confirm("Are you sure you want to unlock all students?")) {
      var test_id = $("#test_id").val();
      //    alert(test_id)
      $(".report").html("<i>Please wait...</i>");
      $(".ul").hide();
      $(".spin").removeAttr("hidden").fadeIn(3000);
      $.ajax({
        url: "asset/config/edit.php",
        dataType: "text", // what to expect back from the PHP script, if anything
        cache: false,
        data: { dt: "unlock_all", test_id: test_id },
        type: "post",
        success: function (msg) {
          // alert(msg)
          e.preventDefault();
          // display response from the PHP script, if any
          if (msg == -1) {
            $(".report").html(
              '<b class="text-danger">Internal server error contact system admin.</b>'
            );
          } else if (msg == 1) {
            $(".report").html(
              '<b class="text-success">All students successfully unclocked.</b>'
            );
          } else {
            $(".report").html(
              '<b class="text-danger">Internal server error contact system admin.</b>'
            );
          }
          return false;
        },
      }); //end ajax
    }
  });

  $(document).on("click", ".uploadWord", function (e) {
    e.preventDefault();
    var paper = $("#paper").val();
    var section = $("#section").val();
    var file_data = $("#uploadFile").prop("files")[0];
    var form_data = new FormData();
    form_data.append("uploadFile", file_data);
    form_data.append("section", section);
    // $('.report').html('');

    //append values into formData object
    form_data.append("paper", paper);
    $(".ul").hide();
    $(".spin").removeAttr("hidden").fadeIn(3000);
    $.ajax({
      url: "asset/config/phpWordUpload.php",
      dataType: "text", // what to expect back from the PHP script, if anything
      cache: false,
      contentType: false,
      processData: false,
      data: form_data,
      type: "post",
      success: function (msg) {
        e.preventDefault();
        // display response from the PHP script, if any
        $(".report").html(msg);

        $("#example1").dataTable();
        $("#example2").dataTable({
          bPaginate: true,
          bLengthChange: false,
          bFilter: false,
          bSort: true,
          bInfo: true,
          bAutoWidth: false,
        });
        return false;
      },
    }); //end ajax
  });

  // ################# click num nav ##############################
  $(document).on("click", ".numNav", function (e) {
    var question = $(this).attr("id");
    var rel = $(this).attr("rel");
    t = rel; //set current
    //    alert(rel)
    $(".question").hide();
    $("#" + question).show();
    $("#cquestion").html(rel);
    if (rel == a) {
      $("#btnPrev").show();
      $("#btnNext").hide();
    }
    if (rel == 1) {
      $("#btnPrev").hide();
      $("#btnNext").show();
    }
    if (rel != 1 && rel != a) {
      $("#btnPrev").show();
      $("#btnNext").show();
    }
  });
  // ################# mark numnav for students that started the test somewhere
  $(".rg").each(function () {
    var role = $(this).attr("role");
    var val = $(this).val();
    var ischecked = $(this).attr("checked");
    // alert(ischecked)
    if (val != 5) {
      if (ischecked == "checked") {
        $(".num")
          .find("#" + role)
          .css({ color: "white", "background-color": "green", border: "0px" });
      }
    }
  });
  /*#################################### change password #################################*/
  $(document).on("click", "#saveChanges", function (e) {
    e.preventDefault();
    var data = "changePassword";
    var id = "changePassword";
    var formData =
      $("#changePassword").serialize() + "&data=" + data + "&id=" + id;
    $.ajax({
      url: "asset/config/process.php",
      type: "POST",
      data: formData,
      cache: false,
      success: function (msg) {
        if (msg == 0) {
          $(".err_msg").html(
            '<div class="alert alert-danger" style="font-weight: bolder">&times; Incorrect current password</div>'
          );
        } else if (msg == 1) {
          $(".err_msg").html(
            '<div class="alert alert-danger" style="font-weight: bolder">&times; Password mismatch</div>'
          );
        } else if (msg == 2) {
          $(".err_msg").html(
            '<div class="alert alert-danger" style="font-weight: bolder">&times; ' +
              msg +
              "</div>"
          );
        } else if (msg == 3) {
          $(".err_msg").html(
            '<div class="alert alert-success" style="font-weight: bolder">Password successfully changed</div>'
          );
        } else if (msg == 4) {
          $(".err_msg").html(
            '<div class="alert alert-danger" style="font-weight: bolder">&times; All fields required</div>'
          );
        } else {
          $(".err_msg").html(
            '<div class="alert alert-danger" style="font-weight: bolder">&times; cannot update password, try again' +
              msg +
              "</div>"
          );
        }
      },
    });
  });

  $(document).on("click", "#batch_del_student", function (e) {
    e.preventDefault();
    var data = "batch_del_student";
    var id = "batch_del_student";
    var test = $(this).attr("test");
    var batch = $(this).attr("batch");

    $(document).on("click", "#ok_delete", function (e) {
      let password = $("#del_confirm").val();
      if (password != null) {
        $("#status").text("Deleting students please wait...");
        $.ajax({
              url: "asset/config/process.php",
              type: "POST",
              data: {"data" : data, "id": id,'test':test,'batch':batch,'password':password},
              cache: false,
              dataType: 'JSON',
              success: function (msg) {
                if (msg.response_status =='success') {
                  alert(msg.message)
                  location.reload()
                }else{
                  $("#status").html(`<br><p class="alert alert-danger">* ${msg.message}</p>`);

                }
              }

        })
            
      }
    });
  });
  
  $(document).on("click", "#all_del_question", function (e) {
    e.preventDefault();
    var data = "all_del_question";
    var id = "all_del_question";
    var test = $(this).attr("test");
    var type = $(this).data("paper-type")

    $(document).on("click", "#ok_delete_question", function (e) {
      let password = $("#del_confirm").val();
      if (password != null) {
        $("#status").text("Deleting questions please wait...");
        $.ajax({
              url: "asset/config/process.php",
              type: "POST",
              data: {"data" : data, "id": id,'test':test,'password':password,type},
              cache: false,
              dataType: 'JSON',
              success: function (msg) {
                if (msg.response_status =='success') {
                  alert(msg.message)
                  location.reload()
                }else{
                  $("#status").html(`<br><p class="alert alert-danger">* ${msg.message}</p>`);
                }
              }

        })
            
      }
    });
  });
  $(document).on("click", ".resetM", function (e) {
    e.preventDefault();
    var data = "reset_exam";
    var id = "reset_exam";
    var rel = $(this).attr("rel");
    var name = $(this).attr("name");
    var batch = $(this).attr("batch");
    var level = $(this).attr("level");

    $('#name').text(name);
    // alert(level)

    $(document).on("click", "#ok_reset", function (e) {
      let password = $("#del_confirm").val();
      if (password != null) {
        $("#status").text("Resetting exam please wait...");
        $.ajax({
              url: "asset/config/process.php",
              type: "POST",
              data: {"rel" : rel, "id": id,'password':password,'batch':batch,'level':level,'data':data},
              cache: false,
              dataType: 'JSON',
              success: function (msg) {
                if (msg.response_status =='success') {
                  alert(msg.message)
                  location.reload()
                }else{
                  $("#status").html(`<br><p class="alert alert-danger">* ${msg.message}</p>`);
                }
              }

        })
            
      }
    });
  });
  $(document).on("click", "#ok_resetS", function (e) {
    let password = $("#del_confirm").val();
    var data = "software_reset"
    var id = data;
    if (password != null) {
      $("#status").text("Resetting data please wait...");
      $.ajax({
            url: "asset/config/process.php",
            type: "POST",
            data: {"data" : data,'password':password, "id":id},
            cache: false,
            dataType: 'JSON',
            success: function (msg) {
              if (msg.response_status =='success') {
                alert(msg.message)
                location.reload()
              }else{
                $("#status").html(`<br><p class="alert alert-danger">* ${msg.message}</p>`);
              }
            }

      })
          
    }
  });

  // search students 
  $(document).on("click", "#search", function (e) {
    e.preventDefault();

    Object.keys(scores).forEach(questionId => {
      delete scores[questionId];
    }); 
    
    total_grade =0;
    
    var data = $("#grading-form").serialize();
     
      $("#status").text("Searching student please wait...");
      $.ajax({
            url: "../Admin/asset/config/search.php",
            type: "POST",
            data: data,
            cache: false,
            // dataType: 'JSON',
            success: function (msg) {
              $("#status").html(msg);

            }

      })
  });

  
  $(document).on("click", ".mark", function (e) {
    // e.preventDefault()
    var qid = $(this).attr("rel");
    var value = $(this).val();
    var stid = $(this).data("stdid");

    updateScore(qid, value);

    let totalScore = 0;
    for (const questionId in scores) {
      if (scores.hasOwnProperty(questionId)) {
        totalScore += parseFloat(scores[questionId]);
      }
    }
    $('#total').text(totalScore);

    total_grade = totalScore;
   
    var data = "optionClick";

    
    $.ajax({
      type: "POST",
      url: "../Admin/asset/config/process.php",
      cache: false,
      data:{"qId" :qid, "option": value,"id" :data,"data": data, "studentId": stid},
      success: function (response) {},
      error: function (e) {
        alert("Error in network connection. Please contact system admin.")
      }
    });
  });

  $(document).on("click", ".submit-grading", function (e) {
    // e.preventDefault()
    var stid = $(this).data("student");
    var paper = $(this).data("paper");

    var status = $('#status').html();

    $('#status').text("Processing grade please wait...");

    
    $.ajax({
      type: "POST",
      url: "./process_grade.php",
      cache: false,
      data:{"paper": paper, "std": stid},
      success: function (response) {
        $('#status').html(response);
      },
      error: function (e) {
        alert("Error in network connection. Please contact system admin.")
      }
    });
  });



}); // end document dot ready function
