$(document).ready(function () {
  var btntag = 0;
  var editbtnid = 0;
  loadpage();
  var rgn = 0;


  //  setInterval(function() {
  //   updateUsers();
  // }, 1000);
  updateUsers();

  function disablemyinput() {

    $(".myinput").attr("disabled", true);
  }

  function updateUsers() {
    $.ajax({
      url: 'updateuser.php',
      type: 'get',
      caches: false,
      success: function (data) {

      }
    })

  }
  function loaditemname() {
    $.ajax({
      url: 'itemname.php',
      cache: false,
      success: function (data) {
        $("#rcdetails").html(data);
      }
    })
  }
  // ========================== Change Password
  $("#btnpassword").click(function (e) {
    e.preventDefault();

    $.ajax({
      url: 'cpp.php',
      type: 'get',
      data: {
        currentpassword: $("#currentpassword").val(),
        newpassword: $("#newpassword").val(),
        confirmpassword: $("#confirmpassword").val()
      },
      dataType: 'JSON',
      success: function (response) {
        var len = response.length;
        var msg = response[0].msg;
        for (var i = 0; i < len; i++) {
          var msg = response[i].msg;
          var tag = response[i].tag;
          if (tag == 1) {
            var msgtag = '<div class="alert alert-danger">' +
              '<strong>Warning!</strong> ' + msg + ' .</div>';

            $("#errmsg1").html(msgtag);
          } else if (tag == 2) {
            var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';
            $("#errmsg1").html(msgtag);
          } else if (tag == 3) {
            var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';
            $("#errmsg1").html(msgtag);
          }

          $("#currentpassword").val("");
          $("#newpassword").val("");
          $("#confirmpassword").val("");

        }

      }
    });

  })
  // ============== Profile

  $(document).on("click", "#A0001", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Employee Entry</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);

    $.ajax({
      url: 'A0001.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
        loadprofiledetails();
      }
    })
    btntag = 0;
    // loadprofiledetails();
    loadprofiledetails();
  })

  // ====================Menu Entry
  $(document).on("click", "#A003", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Menu Entry Form</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <form action="#" method="post" id="frmMenu">' +

      ' <div id="myalert"><div class="alert alert-info" >' + '<strong>Information!</strong> Please fill-up the form correctly!  .</div></div>' +

      '<div class="row">' +
      '<div class="col-xs-4">' +
      ' <div class="form-group has-feedback">' +
      ' <input type="text" class="form-control" placeholder="Menu Code" id="mcode" name= "mcode" required="true">' +
      '<span class="glyphicon glyphicon-th-large form-control-feedback"></span>' +
      '</div>' +
      '</div>' +
      '<div class="col-xs-4">' +
      '<div class="form-group has-feedback">' +
      '<input type="text" class="form-control" placeholder="Menu Name" id ="mnuname" name="mnuname"  required="true">' +
      '<span class="glyphicon glyphicon-th form-control-feedback"></span>' +
      ' </div>' +
      '</div>' +

      '</div> ' +
      '<div class="form-group has-feedback">' +
      '<input type="text" class="form-control" placeholder="Link" id="mnulink" name="mnulink"  required="true">' +
      '<span class="glyphicon glyphicon-th-list form-control-feedback"></span>' +
      '</div>' +


      '<div class="row">' +
      '<div class="col-xs-4">' +
      ' <div class="form-group has-feedback">' +
      ' <select class="form-control" name ="mnumode" id="mnumode">' +
      '<option value ="Select Module" >Select Module</option>' +
      '<option value ="Setup" >Setup</option>' +
      '<option value ="Transaction" >Transaction</option>' +
      '<option value ="Report" >Report</option></select>' +
      '<span class="glyphicon glyphicon-file form-control-feedback"></span>' +
      '</div>' +
      '</div></div>' +

      ' <div class="row">' +


      '<div class="col-xs-4">' +
      '<button type="submit" class="btn btn-primary btn-block btn-flat" style="margin:5px;" id="bntmenu">Save</button><br/>' +
      '</div>' +

      '</div>' +
      ' </form> <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);
    loadmenudetails();
  })
  // =======================bntmenu
  $(document).on("click", "#bntmenu", function (e) {
    e.preventDefault();

    if (btntag == 0) {
      $.ajax({
        url: "btnmenu.php",
        type: "get",
        data: {
          mcode: $("#mcode").val(),
          mnuname: $("#mnuname").val(),
          mnulink: $("#mnulink").val(),
          mnumode: $("#mnumode").val()
        },
        dataType: "JSON",
        success: function (response) {
          var len = response.length;
          var msg = response[0].msg;
          for (var i = 0; i < len; i++) {
            var msg = response[i].msg;
            var tag = response[i].tag;

            if (tag == 5) {
              var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';
              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("PSMIS Message");
              $("#yourtuklaw").modal("show");
              loadmenudetails();
              $("#mcode").val("");
              $("#mnuname").val("");
              $("#mnulink").val("");
            } else {
              var msgtag = '<div class="alert alert-danger">' + msg + ' .</div>';
              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("PSMIS Message");
              $("#yourtuklaw").modal("show");

            }
          }
        }
      })
    } else if (btntag == 1) {


      $.ajax({
        url: 'btnmeuedit.php',
        type: 'get',
        data: {
          mnuid: youreditid,
          mcode: $('#mcode').val(),
          menuname: $('#mnuname').val(),
          link: $('#mnulink').val(),
          mnumode: $("#mnumode").val()
        },
        dataType: "JSON",
        success: function (response) {
          var len = response.length;
          var msg = response[0].msg;
          //  alert(response);

          // $("#myalert").html(response);
          for (var i = 0; i < len; i++) {
            var msg = response[i].msg;
            var tag = response[i].tag;


            if (tag == 2) {
              var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';
              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("PSMIS Message");
              $("#yourtuklaw").modal("show");
              loadmenudetails();

              $("#A003").trigger("click");
              $("#btnmeuedit").html("Update");
            } else {
              var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';
              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("PSMIS Message");
              $("#yourtuklaw").modal("show");
            }


          }

        }
      })
    }
  })
  // =======================btnyes
  $(document).on("click", "#btnyes", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'deletemenu.php',
      type: "get",
      data: { mnuid: $("#mnuid").val() },
      cache: false,
      success: function (data) {

        loadmenudetails();
        $("#myModalconfirm").modal("hide");
      }
    })
  })
  $(document).on("click", "#btnno", function (e) {
    e.preventDefault();
    $("#myModalconfirm").modal("hide");
  })

  // ==============frmmodalbody
  var youreditid = 0;
  $(document).on("click", ".btnmnuedit", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    youreditid = arr[0];
    $("#mcode").val(arr[1]);
    $("#mnuname").val(arr[2]);
    $("#mnulink").val(arr[3]);
    $("#mnumode").val(arr[4]);
    btntag = 1;
    // $.ajax({
    //   url:"editmenu.php",
    //   type:'get',
    //   data:{id:$(this).attr('id')},
    //   cache:false,
    //   success:function(data){
    //     $("#frmmodalbody").html(data);
    //    loadmenudetails();
    //   }
    // })
  })

  // =====================btnmeuedit
  $(document).on("click", "#btnmeuedit", function (e) {
    e.preventDefault();
    $("#btnmeuedit").prop('disabled', true);
    var img = "<img src = 'img/loading.gif'/ style='width:30px; height:30px;'>";
    $("#btnmeuedit").prepend(img);


    $.ajax({
      url: 'btnmeuedit.php',
      type: 'get',
      data: {
        mnuid: $('#mnuid').val(),
        mcode: $('#mcode').val(),
        menuname: $('#mnuname').val(),
        link: $('#mnulink').val()
      },
      dataType: "JSON",
      success: function (response) {
        var len = response.length;
        var msg = response[0].msg;
        for (var i = 0; i < len; i++) {
          var msg = response[i].msg;
          var tag = response[i].tag;


          if (tag == 2) {
            var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';
            $("#tuklawmodal").html(msgtag);
            $("#tuklawtitle").html("PSMIS Message");
            $("#yourtuklaw").modal("show");
            // loadmenudetails();
            $("#A003").trigger("click");
            $("#btnmeuedit").html("Update");
          } else {
            var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';
            $("#tuklawmodal").html(msgtag);
            $("#tuklawtitle").html("PSMIS Message");
            $("#yourtuklaw").modal("show");
          }


        }

      }
    })

    $("#btnmeuedit").prop('disabled', false);
    var img = "Save";
    $("#btnmeuedit").html(img);

  })

  // ========================= bntmnuremove
  $(document).on("click", ".bntmnuremove", function (e) {
    e.preventDefault();
    $("#myModalconfirm").modal("show");
    $("#mdconfirm").html("Delete Menu");
    var trid = $(this).closest('tr').attr('id');
    var msg = "<div class='alert alert-danger'>Are you sure you want to Delete <b>" + trid + "</b> from our menu?</div>";
    $("#errmsgconf1").html(msg);
    $("#mnuid").val($(this).attr("id"));

  })
  // =================== User Account
  $(document).on("click", "#A0002", function (e) {
    e.preventDefault();
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">User Account Registration</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <form action="#" method="post" id="frmMenu">' +

      ' <div id="myalert"><div class="alert alert-info" >' + '<strong>Information!</strong> Please fill-up the form correctly!  .</div></div>' +

      '<div class="row">' +
      '<div class="col-xs-4">' +
      ' <div class="form-group has-feedback">' +
      ' <input type="text" class="form-control" placeholder="User Name" id="username" name= "username" required="true">' +
      '<span class="glyphicon glyphicon-user form-control-feedback"></span>' +
      '</div>' +
      '</div>' +
      '<div class="col-xs-4">' +
      ' <div class="form-group has-feedback">' +
      '<input type="hidden" id="hiddenid">' +
      ' <input type="password" class="form-control" placeholder="Password" id="password" name= "password" required="true">' +
      '<span class="glyphicon glyphicon-lock form-control-feedback"></span>' +
      '</div>' +
      '</div>' +
      '<div class="col-xs-4">' +
      '<div class="form-group has-feedback">' +
      '<input type="password" class="form-control" placeholder="Confirm Password" id ="confirmpassword" name="confirmpassword"  required="true">' +
      '<span class="glyphicon glyphicon-lock form-control-feedback"></span>' +
      ' </div>' +
      '</div>' +

      '</div> ' +
      '<div class="form-group has-feedback">' +
      '<input type="text" class="form-control" placeholder="Completename" id="completename" name="completename"  required="true" readonly="true">' +
      '<span class="glyphicon glyphicon-th-list form-control-feedback"></span>' +
      '</div>' +


      ' <div class="row">' +


      '<div class="col-xs-4">' +
      '<button type="submit" class="btn btn-primary btn-block btn-flat" style="margin:5px;" id="btnaccount">Save</button><br/>' +
      '</div>' +




      ' </form> <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);
    loadaccount();
  })
  $(document).on("click", "#btnaccountedit", function (e) {
    e.preventDefault();
    var username = $("#username").val();
    $("#btnaccountedit").prop('disabled', true);
    var img = "<img src = 'img/loading.gif'/ style='width:30px; height:30px;'>";
    $("#btnaccountedit").prepend(img);
    if (username == "") {
      var myalert = "<div class='alert alert-danger'> <strong class='blink'>Warning!</strong> Employee Name is required!  .</div>"
      $("#myalert").html(myalert);
    } else {
      $.ajax({
        url: 'saveedit.php',
        type: 'get',
        dataType: 'JSON',
        data: {
          hiddenid: $("#hiddenid").val(),
          username: username
        },
        success: function (response) {
          var len = response.length;

          var msg = response[0].msg;
          for (var i = 0; i < len; i++) {
            var msg = response[i].msg;
            var tag = response[i].tag;

            if (tag == 1) {
              var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';
              $("#myalert").html(msgtag);
            } else {
              var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';
              $("#myalert").html(msgtag);
              $("#A0002").trigger("click");

            }


          }
        }
      })
    }
    $("#btnaccountedit").prop('disabled', true);
    var img = "Save";
    $("#btnaccountedit").html(img);

  })

  $(document).on("click", "#A0004", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">User Group Entry</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <form action="#" method="post" id="frmMenu">' +

      ' <div id="myalert"><div class="alert alert-info" >' + '<strong>Information!</strong> Please fill-up the form correctly!  .</div></div>' +

      '<div class="row">' +
      '<div class="col-xs-4">' +
      ' <div class="form-group has-feedback">' +
      ' <input type="text" class="form-control" placeholder="Group Name" id="gname" name= "gname" required="true">' +
      '<span class="glyphicon glyphicon-th-large form-control-feedback"></span>' +
      '</div>' +
      '</div></div>' +



      '<div class="row">' +
      '<div class="col-xs-4">' +
      '<div class="form-group has-feedback">' +
      '<input type="text" class="form-control" placeholder="Description" id="gdescription" name="gdescription"  required="true">' +
      '<span class="glyphicon glyphicon-th-list form-control-feedback"></span>' +
      '</div></div></div>' +


      ' <div class="row">' +


      '<div class="col-xs-4">' +
      '<button type="submit" class="btn btn-primary btn-block btn-flat" style="margin:5px;" id="btngroup">Save</button><br/>' +
      '</div>' +

      '</div>' +
      ' </form> <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);
    loadgroup();
  })

  $(document).on("click", "#btnsearchname", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'searchemployee.php',
      cache: false,
      type: 'get',
      data: { txtsearhname: $("#txtsearhname").val() },
      success: function (data) {
        $("#tblsearch").html(data);

      }
    })
  })

  $(document).on("click", "#btnsearchmenu", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'btnsearchmenu.php',
      cache: false,
      type: 'get',
      data: { txtsearchmenu: $("#txtsearchmenu").val() },
      success: function (data) {
        $("#tblsearch").html(data);

      }
    })
  })
  // ================btngroup
  $(document).on("click", "#btngroup", function (e) {
    e.preventDefault();
    var gname = $("#gname").val();
    var gdescription = $("#gdescription").val();
    $("#btngroup").prop('disabled', true);
    var img = "<img src = 'img/loading.gif'/ style='width:30px; height:30px;'>";
    $("#btngroup").prepend(img);

    if (gname == "") {
      var myalert = "<div class='alert alert-danger'> <strong>Warning!</strong> Username is required!  .</div>"
      $("#myalert").html(myalert);
    } else if (gdescription == "") {
      var myalert = "<div class='alert alert-danger'> <strong>Warning!</strong> Username is required!  .</div>"
      $("#myalert").html(myalert);
    } else {
      $.ajax({
        url: 'btngroup.php',
        type: 'get',
        dataType: 'JSON',
        data: { gname: gname, gdescription: gdescription },
        success: function (response) {
          var len = response.length;

          var msg = response[0].msg;
          for (var i = 0; i < len; i++) {
            var msg = response[i].msg;
            var tag = response[i].tag;

            if (tag == 1) {
              var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';
              $("#myalert").html(msgtag);
            } else {
              var msgtag = '<div class="alert alert-success">' + '<strong>Warning!</strong> ' + msg + ' .</div>';
              $("#myalert").html(msgtag);
              loadgroup();
            }
          }
        }
      })
    }

    $("#btngroup").prop('disabled', false);
    var img = "Save";
    $("#btngroup").html(img);
  })

  // =======================btnremovegroup

  $(document).on("click", ".btnremovegroup", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    $("#mdconfirm").html("Delete Group Name");
    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to delete <strong >" + arr[1] + "</strong> Group?  .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnyesgroup" id="btnyesgroup" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnogroup" id="btnnogroup" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");

  })
  $(document).on("click", "#btnnogroup", function (e) {
    e.preventDefault();
    $("#myModalconfirm").modal("hide");
  })

  $(document).on("click", "#btnyesgroup", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'btnyesgroup.php',
      data: { id: $("#btnid").val() },
      cache: false,
      success: function (data) {
        loadgroup();
        $("#myModalconfirm").modal("hide");
      }
    })
  })
  $(document).on("click", "#btngroupedit", function (e) {
    e.preventDefault();
    $("#btngroupedit").prop('disabled', true);
    var img = "<img src = 'img/loading.gif'/ style='width:30px; height:30px;'>";
    $("#btngroupedit").prepend(img);
    if ($("#Groupnane").val() == "") {
      var myalert = "<div class='alert alert-danger'> <strong>Warning!</strong> Group Name is required!  .</div>"
      $("#myalert").html(myalert);
    } else if ($("#Description").val() == "") {
      var myalert = "<div class='alert alert-danger'> <strong>Warning!</strong> Description is required!  .</div>"
      $("#myalert").html(myalert);
    } else {
      $.ajax({
        url: 'btngroupedit.php',
        type: 'get',
        data: {
          mnuid: $("#mnuid").val(),
          Groupnane: $("#Groupnane").val(),
          Description: $("#Description").val()
        },
        dataType: 'JSON',
        success: function (response) {
          var len = response.length;

          var msg = response[0].msg;
          for (var i = 0; i < len; i++) {
            var msg = response[i].msg;
            var tag = response[i].tag;
            if (tag == 1) {
              var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';
              $("#myalert").html(msgtag);
            } else {
              var msgtag = '<div class="alert alert-success">' + '<strong>Warning!</strong> ' + msg + ' .</div>';
              $("#myalert").html(msgtag);
              $("#Groupnane").val("");
              $("#Description").val("");
              loadgroup();

            }
          }
        }
      })
    }
    $("#btngroupedit").prop('disabled', false);
    var img = "Save";
    $("#btngroupedit").html(img);
  })
  $(document).on("click", ".btneditgroup", function (e) {
    e.preventDefault();

    $.ajax({
      url: "btneditgroup.php",
      type: 'get',
      data: { id: $(this).attr('id') },
      cache: false,
      success: function (data) {
        $("#frmmodalbody").html(data);
        loadgroup();
      }
    })
  })


  $(document).on("click", "#A0005", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Responsibility Center</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'A0005.php',
      cache: false,
      type: 'get',
      success: function (data) {

        $("#frmmodalbody").html(data);
        $.ajax({
          url: 'rcdetails.php',

          cache: false,
          success: function (data) {

            $("#rcdetails").html(data);
          }
        })
      }
    })
    loadrcdetails();
    btntag = 0;
  })
  $(document).on("click", "#T0001", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Users Group Menu Setup</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'frmmodalbody.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
      }
    })
  })

  $(document).on("click", "#T0002", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Users Group Set-up</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);
    $.ajax({
      url: 'usergroup.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
      }
    })
  })

  $(document).on("change", "#cmbGroup1", function (e) {
    e.preventDefault();
    gpbody1();

  })
  // ====================btnaccount
  $(document).on("click", "#btnaccount", function (e) {
    e.preventDefault();
    var username = $("#username").val();
    var password = $("#password").val();
    var confirmpassword = $("#confirmpassword").val();
    var completename = $("#completename").val();
    var hiddenid = $("#hiddenid").val();
    $("#btnaccount").prop('disabled', true);
    var img = "<img src = 'img/loading.gif'/ style='width:30px; height:30px;'>";
    $("#btnaccount").prepend(img);

    if (username == "") {
      var myalert = "<div class='alert alert-danger'> <strong>Warning!</strong> Username is required!  .</div>"
      $("#myalert").html(myalert);
    } else if (password == "") {
      var myalert = "<div class='alert alert-danger'> <strong>Warning!</strong> Password is required!  .</div>"
      $("#myalert").html(myalert);
    } else if (password != confirmpassword) {
      var myalert = "<div class='alert alert-danger'> <strong>Warning!</strong> Password is not match!  .</div>"
      $("#myalert").html(myalert);
    } else if (completename == "") {
      var myalert = "<div class='alert alert-danger'> <strong>Warning!</strong> Employee Name is required!  .</div>"
      $("#myalert").html(myalert);
    } else {

      $.ajax({
        url: 'saveaccount.php',
        type: 'get',

        data: {
          hiddenid: $("#hiddenid").val(),
          username: $("#username").val(),
          password: $("#password").val()
        },
        success: function (response) {
          var len = response.length;

          var msg = response[0].msg;
          for (var i = 0; i < len; i++) {
            var msg = response[i].msg;
            var tag = response[i].tag;

            if (tag == 1) {
              var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';
              $("#myalert").html(msgtag);
            } else {
              var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';
              $("#myalert").html(msgtag);
              $("#hiddenid").val("");
              $("#username").val("");
              $("#password").val("");
              $("#completename").val("");
              $("#A0002").trigger("click");
            }

          }
        }
      })

    }
    loadaccount();
    $("#btnaccount").prop('disabled', true);

    $("#btnaccount").html("Save");
  })

  // ==================completename
  $(document).on("click", "#completename", function (e) {
    e.preventDefault();

    var myalert = "<div class='alert alert-info'> <strong>Information!</strong>Select Employee Name correctly!  .</div>"
    $("#errmsgconf1").html(myalert);
    $("#mdconfirm").html("Select Employee");


    $.ajax({
      url: 'emplist.php',
      type: 'get',
      cache: false,
      success: function (data) {
        $("#richiemodal").html(data);
      }
    })
    $("#myModalconfirm").modal("show");
  })

  $(document).on("click", ".rihieid", function (e) {
    e.preventDefault();
    // alert($(".tdclass").closest("id"));
    // userTable
    var data = $(this).attr("id");
    var arr = data.split("|");

    $("#hiddenid").val(arr[0]);
    $("#completename").val(arr[1])
    $("#myModalconfirm").modal("hide");
  })
  $(document).on("click", ".btnremoveAccount", function (e) {
    e.preventDefault();

    var mydata = $(this).attr("id");

    var arr = mydata.split("|");

    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to delete <strong >" + arr[1] + "</strong> Account?  .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnyesacct" id="btnyesacct" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");

  })


  $(document).on("click", "#btnyesacct", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'delacc.php',
      type: 'get',
      cache: false,
      data: { btnid: $("#btnid").val() },
      success: function (data) {


        loadaccount();
      }
    })

    // $("#myModalconfirm").modal("hide");
  })
  // ================blink text 

  function blink_text() {
    $('.blink').fadeOut(500);
    $('.blink').fadeIn(500);
  }
  setInterval(blink_text, 1000);
  $(document).on("click", "#btnnoacct", function (e) {
    e.preventDefault();
    $("#myModalconfirm").modal("hide");
  })
  $(document).on("click", ".btneditaccount", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    $.ajax({
      url: "btneditaccount.php",
      type: 'get',
      data: { id: arr[0] },
      cache: false,
      success: function (data) {
        $("#frmmodalbody").html(data);
        loadaccount();
      }
    })
  })



  // ==================== Btnprofile

  $(document).on("click", "#btnremovegroup1", function (e) {
    e.preventDefault();
    e.preventDefault();
    var val = [];


    $('#chkmenu:checked').each(function (i) {
      val[i] = $(this).val();
    });
    $.ajax({
      url: 'btnremovegroup1.php',
      type: 'get',
      cache: false,
      data: { val: val },
      success: function (data) {
        gpbody1();
        // alert(data);
        $('input[type=checkbox]').prop('checked', false);

      }
    })

  })
  $(document).on("click", "#btnremovemenu", function (e) {
    e.preventDefault();
    var val = [];


    $('#chkmenu:checked').each(function (i) {
      val[i] = $(this).val();
    });
    $.ajax({
      url: 'btnremovemenu.php',
      type: 'get',
      cache: false,
      data: { val: val },
      success: function (data) {
        gpbody();
        // alert(data);
        $('input[type=checkbox]').prop('checked', false);

      }
    })


  })
  $(document).on("click", "#btnyessupp", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'btnyessupp.php',
      type: 'get',
      data: { btnid: $("#btnid").val() },
      cache: false,
      success: function (data) {



        loadsupplierdetails();
        $("#myModalconfirm").modal("hide");
        var myalert = "<div class='alert alert-info'> <strong>Information!</strong> Please fill-up the form correctly!  .</div>"
        $("#myalert").html(myalert);
      }
    })
  })

  $(document).on("click", "#btnyesrc", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'btnyesrc.php',
      type: 'get',
      data: { btnid: $("#btnid").val() },
      cache: false,
      success: function (data) {



        loadrcdetails();
        $("#myModalconfirm").modal("hide");
        var myalert = "<div class='alert alert-info'> <strong>Information!</strong> Please fill-up the form correctly!  .</div>"
        $("#myalert").html(myalert);
      }
    })
  })


  $(document).on("click", "#btnsearchrc", function (e) {
    e.preventDefault();
    loadrcdetails();
  })
  $(document).on("click", "#btnsavgroup1", function (e) {
    e.preventDefault();
    var val = [];
    var cmbGroup = $("#cmbGroup1").val();
    $('#ad_Checkbox1:checked').each(function (i) {
      val[i] = $(this).val();
    });


    $.ajax({
      url: 'btnsavgroup1.php',
      type: 'get',
      cache: false,
      data: { val: val, cmbGroup: cmbGroup },
      success: function (data) {
        // alert(data);
        gpbody1();


        $('input[type=checkbox]').prop('checked', false);
      }
    })

  })
  $(document).on("click", "#btnsavemenu", function (e) {
    e.preventDefault();
    var val = [];
    var cmbGroup = $("#cmbGroup").val();
    $('#ad_Checkbox1:checked').each(function (i) {
      val[i] = $(this).val();
    });


    $.ajax({
      url: 'savemenu.php',
      type: 'get',
      cache: false,
      data: { val: val, cmbGroup: cmbGroup },
      success: function (data) {

        gpbody();


        $('input[type=checkbox]').prop('checked', false);
      }
    })


  })

  // $(document).on("click",".mytr",function(e){
  //   e.preventDefault();
  //   alert($(this).closest('tr').attr('id'));
  // })

  $(document).on("change", "#cmbGroup", function (e) {
    e.preventDefault();
    gpbody();
  })

  $(document).on("click", ".bntproremove", function (e) {
    e.preventDefault();

    var mydata = $(this).attr("id");

    var arr = mydata.split("|");

    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to delete <strong >" + arr[1] + "</strong> Profile?  .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnyespro" id="btnyespro" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);

    $("#myModalconfirm").modal("show");


    // var mydata = $(this).attr("id");

    //      var arr = mydata.split("|");
    // $.ajax({
    //          url:'rprodetails.php',
    //          data:{pid:arr[0]},
    //          cache:false,
    //          success:function(data){

    //            loadprofiledetails();
    //          }
    //      })
  })
  // ===================Functions
  function gpbody() {
    $.ajax({
      url: 'gpbody.php',
      type: 'get',
      cache: false,
      data: { cmbGroup: $("#cmbGroup").val() },
      success: function (data) {
        $("#gpbody").html(data);
      }
    })
  }
  function gpbody1() {
    $.ajax({
      url: 'gpbody1.php',
      type: 'get',
      cache: false,
      data: { cmbGroup: $("#cmbGroup1").val() },
      success: function (data) {
        $("#gpbody").html(data);
      }
    })
  }
  function loadgroup() {
    $.ajax({
      url: 'loadgroup.php',
      cache: false,
      success: function (data) {

        $("#mnudetails").html(data);
        $("#gname").val("");
        $("#gdescription").val("");

      }
    })
  }


  function loadaccount() {
    $.ajax({
      url: 'accountdetail.php',
      cache: false,
      success: function (data) {

        $("#mnudetails").html(data);
      }
    })
  }
  function loadmenudetails() {


    $.ajax({
      url: 'mnudetails.php',
      cache: false,
      success: function (data) {

        $("#mnudetails").html(data);
      }
    })

  }
  function loadprofiledetails() {
    $.ajax({
      url: 'prodetails.php',
      cache: false,
      success: function (data) {

        $("#vwprofiledetails").html(data);
      }
    })
  }

  function loadprofilecombo() {
    $.ajax({
      url: 'section.php',
      cache: false,
      success: function (data) {

        $("#sec").html(data);
      }
    })

    $.ajax({
      url: 'resposibility.php',
      cache: false,
      success: function (data) {

        $("#rc").html(data);
      }
    })
    $.ajax({
      url: 'position.php',
      cache: false,
      success: function (data) {

        $("#pos").html(data);
      }
    })
  }
  $(document).on("click", "#btnprofilerefresh", function (e) {
    e.preventDefault();
    loadprofiledetails();
    loadprofilecombo();
  })
  $(document).on("click", "#btnsaverc", function (e) {
    e.preventDefault();

    var msg = "";
    $("#btnsaverc").prop('disabled', true);
    var msgtag = "";
    if ($("#rcocde").val() == "") {
      msg = "Responsibility center code is required";
      msgtag = '<div class="alert alert-danger blink">' + msg + ' .</div>';
      $("#myalert").html(msgtag);
    } else if ($("#rccenter").val() == "") {
      msg = "Responsibility center name is required";
      msgtag = '<div class="alert alert-danger">' + msg + ' .</div>';
      $("#myalert").html(msgtag);
    } else if ($("#opunit").val() == "") {
      msg = "Operation unit code is required!";
      msgtag = '<div class="alert alert-danger">' + msg + ' .</div>';
      $("#myalert").html(msgtag);
    } else {

      if (btntag == 0) {
        $.ajax({
          url: 'btnsaverc.php',
          type: 'get',
          dataType: 'JSON',
          data: {
            rcocde: $("#rcocde").val(),
            rccenter: $("#rccenter").val(),
            opunit: $("#opunit").val()
          },
          success: function (response) {
            var len = response.length;

            var msg = response[0].msg;
            for (var i = 0; i < len; i++) {
              var msg = response[i].msg;
              var tag = response[i].tag;

              if (tag == 1) {
                var msgtag = '<div class="alert alert-danger">' + msg + '</div>';
                $("#myalert").html(msgtag);
              } else {
                var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' </div>';
                $("#myalert").html(msgtag);
                loadrcdetails();
              }

            }
          }
        })

      } else {
        // editbtnid
        $.ajax({
          url: 'btneditrc.php',
          type: 'get',
          dataType: 'JSON',
          data: {
            rcocde: $("#rcocde").val(),
            rccenter: $("#rccenter").val(),
            opunit: $("#opunit").val(),
            editbtnid: editbtnid
          },
          success: function (response) {
            var len = response.length;

            var msg = response[0].msg;
            for (var i = 0; i < len; i++) {
              var msg = response[i].msg;
              var tag = response[i].tag;

              if (tag == 1) {
                var msgtag = '<div class="alert alert-danger">' + msg + ' </div>';
                $("#myalert").html(msgtag);
              } else {
                var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' </div>';
                $("#myalert").html(msgtag);
                loadrcdetails();
                var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
                $("#btnsaverc").html(bntval);
              }

            }
          }
        })


      }

      $("#rcocde").val("");
      $("#rccenter").val("");
      $("#opunit").val("");
      btntag = 0;
    }
    $("#btnsaverc").prop('disabled', false);

  })

  $(document).on("click", ".btnrcedit", function (e) {
    e.preventDefault();
    btntag = 1;
    var mydata = $(this).attr("id");

    var arr = mydata.split("|");
    editbtnid = arr[0];
    $("#rcocde").val(arr[1]);
    $("#rccenter").val(arr[2]);
    $("#opunit").val(arr[3]);
    var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Update</span>';
    $("#btnsaverc").html(bntval);





  })

  $(document).on("click", ".btnsupplyedit", function (e) {
    e.preventDefault();
    btntag = 1;
    var mydata = $(this).attr("id");

    var arr = mydata.split("|");
    editbtnid = arr[0];
    $("#supplier").val(arr[1]);
    $("#address").val(arr[2]);
    $("#tin").val(arr[3]);
    $("#cp").val(arr[4]);
    $("#cpnumber").val(arr[5]);
    $("#cpPosition").val(arr[6]);

  })
  function loadrcdetails() {
    $.ajax({
      url: 'rcdetails.php',

      cache: false,
      success: function (data) {

        $("#rcdetails").html(data);
      }
    })
  }

  function loadsupplierdetails() {
    $.ajax({
      url: 'supplierdetails.php',
      data: { txtsearchrc: $("#txtsearchsupplier").val() },
      cache: false,
      success: function (data) {

        $("#rcdetails").html(data);
      }
    })
  }
  function loadaccountitledetails() {
    $.ajax({
      url: 'accounttiledetails.php',

      cache: false,
      success: function (data) {

        $("#rcdetails").html(data);
      }
    })
  }

  function loadfundclusterdetails() {
    $.ajax({
      url: 'fundclusterdetails.php',

      cache: false,
      success: function (data) {

        $("#rcdetails").html(data);
      }
    })
  }


  function loadrecieveddetails() {
    // $.ajax({
    //      url:'receiveddetails.php',

    //      cache:false,
    //      success:function(data){

    //        $("#rcdetails").html(data);
    //      }
    //  })
  }


  function loadrequestdetails() {
    $.ajax({
      url: 'requestdetails.php',

      cache: false,
      success: function (data) {

        $("#rcdetails").html(data);
      }
    })
  }
  function unitsdetails() {
    $.ajax({
      url: 'unitsdetails.php',
      data: { txtsearchrc: $("#txtsearchunits").val() },
      cache: false,
      success: function (data) {

        $("#rcdetails").html(data);
      }
    })
  }



  function loadmenus() {
    $.ajax({
      url: 'menu.php',
      type: 'get',
      dataType: 'JSON',
      success: function (response) {
        var len = response.length;
        var tr_str = '<ul class="list-group">';
        var tr_str1 = '';
        for (var i = 0; i < len; i++) {

          var menucode = response[i].menucode;
          var menuname = response[i].menuname;
          var link = response[i].link;


          tr_str1 = tr_str1 + '<li class="list-group-item"><a href="" id="' + menucode + '">' + menuname + '</a></li>';


        }
        tr_str = tr_str + tr_str1 + '</ul>';
        $("#mnusetup").append(tr_str);

      }
    });

    $.ajax({
      url: 'menutrans.php',
      type: 'get',
      dataType: 'JSON',
      success: function (response) {
        var len = response.length;
        var tr_str = '<ul class="list-group">';
        var tr_str1 = '';
        for (var i = 0; i < len; i++) {

          var menucode = response[i].menucode;
          var menuname = response[i].menuname;
          var link = response[i].link;


          tr_str1 = tr_str1 + '<li class="list-group-item"><a href="" id="' + menucode + '">' + menuname + '</a></li>';


        }
        tr_str = tr_str + tr_str1 + '</ul>';
        $("#mnutransaction").append(tr_str);

      }
    });


    $.ajax({
      url: 'menureports.php',
      type: 'get',
      dataType: 'JSON',
      success: function (response) {
        var len = response.length;
        var tr_str = '<ul class="list-group">';
        var tr_str1 = '';
        for (var i = 0; i < len; i++) {

          var menucode = response[i].menucode;
          var menuname = response[i].menuname;
          var link = response[i].link;


          tr_str1 = tr_str1 + '<li class="list-group-item"><a href="" id="' + menucode + '">' + menuname + '</a></li>';


        }
        tr_str = tr_str + tr_str1 + '</ul>';
        $("#mnureports").append(tr_str);

      }
    });
  }

  function loadpage() {
    $.ajax({
      url: 'controller.php',
      cache: false,
      success: function (data) {

        if (data == 0) {

          $.ajax({
            url: 'nav.php',

            cache: false,
            success: function (data) {

              $("#myheader").html(data);

            }
          });


          $.ajax({
            url: 'carousel.php',
            cache: false,
            success: function (data) {
              $("#cardetails").html(data);
            }

          });


        } else {
          $.ajax({
            url: 'nav.php',

            cache: false,
            success: function (data) {

              $("#myheader").html(data);
              loadmenus();
            }
          });

          $.ajax({
            url: 'temp.php',
            cache: false,
            success: function (data) {
              $("#cardetails").html(data);




            }

          });





        }



      }

    });
  }


  $(document).on("click", "#A0006", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Unit of Measure</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'A0006.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
        unitsdetails();
      }
    })

    btntag = 0;
  })
  $(document).on("click", "#btnyesunits", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'btnyesunits.php',
      type: 'get',
      data: { btnid: $("#btnid").val() },
      cache: false,
      success: function (data) {



        unitsdetails();
        $("#myModalconfirm").modal("hide");
        var myalert = "<div class='alert alert-info'> <strong>Information!</strong> Please fill-up the form correctly!  .</div>"
        $("#myalert").html(myalert);
      }
    })
  })

  $(document).on("click", ".btnunitsedit", function (e) {
    e.preventDefault();
    btntag = 1;
    var mydata = $(this).attr("id");

    var arr = mydata.split("|");
    editbtnid = arr[0];

    $("#Units").val(arr[1]);

  })

  $(document).on("click", "#btnsaveunits", function (e) {
    e.preventDefault();
    var msg = "";
    $("#btnsaveunits").prop('disabled', true);

    if ($("#Units").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + 'Units of measurement name is required' + ' .</div>';
      $("#myalert").html(msgtag);
    } else {

      if (btntag == 0) {
        //Add
        $.ajax({
          url: 'btnsaveunits.php',
          type: 'get',
          dataType: 'JSON',
          data: { Units: $("#Units").val() },
          success: function (response) {

            var len = response.length;

            var msg = response[0].msg;
            for (var i = 0; i < len; i++) {
              var msg = response[i].msg;
              var tag = response[i].tag;

              if (tag == 1) {
                var msgtag = '<div class="alert alert-danger">' + msg + ' .</div>';
                $("#myalert").html(msgtag);
              } else {
                var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';
                $("#myalert").html(msgtag);
                unitsdetails();
              }

            }

          }

        })
      } else if (btntag == 1) {
        $.ajax({
          url: 'btneditunits.php',
          type: 'get',
          dataType: 'JSON',
          data: {
            Units: $("#Units").val(),
            editbtnid: editbtnid
          },
          success: function (response) {
            var len = response.length;

            var msg = response[0].msg;
            for (var i = 0; i < len; i++) {
              var msg = response[i].msg;
              var tag = response[i].tag;

              if (tag == 1) {
                var msgtag = '<div class="alert alert-danger">' + msg + ' .</div>';
                $("#myalert").html(msgtag);
              } else {
                var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';
                $("#myalert").html(msgtag);
                unitsdetails();
                btntag = 0;
              }

            }
          }
        })
      }
    }
    $("#btnsaveunits").prop('disabled', false);
  })
  $(document).on("click", "#btnsearchunits", function (e) {
    e.preventDefault();
    unitsdetails();
  })

  $(document).on("click", "#A0007", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Supplier </div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'A0007.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
      }
    })
    loadsupplierdetails();
    btntag = 0;
  })

  $(document).on("click", "#btnsavesuppply", function (e) {
    e.preventDefault();

    $("#btnsavesuppply").prop('disabled', true);

    if ($("#supplier").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + 'Supplier name is required' + ' .</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
    } else if ($("#address").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + 'Supplier address is required' + ' .</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
    } else if ($("#tin").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + 'Supplier bussiness tin is required' + ' .</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
    } else if ($("#cp").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + 'Contact person is required' + ' .</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
    } else if ($("#cpnumber").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + 'Supplier contact number is required' + ' .</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
    } else {
      if (btntag == 0) {
        $.ajax({
          url: 'btnsavesupplier.php',
          type: 'get',
          // dataType:'JSON',
          data: {
            supplier: $("#supplier").val(),
            address: $("#address").val(),
            tin: $("#tin").val(),
            cp: $("#cp").val(),
            cpnumber: $("#cpnumber").val(),
            cpPosition: $("#cpPosition").val()
          },
          success: function (response) {
            // alert(response);
            var len = response.length;

            var msg = response[0].msg;
            for (var i = 0; i < len; i++) {
              var msg = response[i].msg;
              var tag = response[i].tag;

              if (tag == 1) {
                var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Supplier already exist.</div>';
                $("#tuklawmodal").html(msgtag);
                $("#tuklawtitle").html("PSMIS Message");
                $("#yourtuklaw").modal("show");
              } else {
                var msgtag = '<div class="alert alert-success">' + ' Successfully saved .</div>';
                $("#tuklawmodal").html(msgtag);
                $("#tuklawtitle").html("PSMIS Message");
                $("#yourtuklaw").modal("show");
                loadsupplierdetails();
              }

            }
          }
        })


      } else if (btntag == 1) {

        $.ajax({
          url: 'btneditsupplier.php',
          type: 'get',
          dataType: 'JSON',
          data: {
            supplier: $("#supplier").val(),
            address: $("#address").val(),
            tin: $("#tin").val(),
            cp: $("#cp").val(),
            cpnumber: $("#cpnumber").val(),
            cpPosition: $("#cpPosition").val(),
            editbtnid: editbtnid
          },
          success: function (response) {
            var len = response.length;

            var msg = response[0].msg;
            for (var i = 0; i < len; i++) {
              var msg = response[i].msg;
              var tag = response[i].tag;

              if (tag == 1) {
                var msgtag = '<div class="alert alert-danger">' + msg + ' .</div>';
                $("#tuklawmodal").html(msgtag);
                $("#tuklawtitle").html("PSMIS Message");
                $("#yourtuklaw").modal("show");
              } else {
                var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';
                $("#tuklawmodal").html(msgtag);
                $("#tuklawtitle").html("PSMIS Message");
                $("#yourtuklaw").modal("show");
                loadsupplierdetails();
                btntag = 0;
              }

            }

          }
        })

      }
    }


    $("#btnsavesuppply").prop('disabled', false);
  })

  $(document).on("click", "#btnsearchsupplier", function (e) {
    e.preventDefault();
    loadsupplierdetails();
  })

  $(document).on("click", "#A0008", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Account Title Entry</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'A0008.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
        // $("#txtaccounttitle").addClass('richieholder');
        loadaccountitledetails();
      }
    })

    btntag = 0;
    var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
    $("#btnsaveaccounttitle").html(bntval);

  })


  $(document).on("click", "#btnsaveaccounttitle", function (e) {

    e.preventDefault();
    var msg = "";
    var ischeck = 0;
    if ($("#chkactive").is(':checked')) {
      ischeck = 1;
    }

    $("#btnsaveaccounttitle").prop('disabled', true);

    if ($("#txtaccounttitle").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + 'Account Title is Required!' + ' .</div>';
      $("#myalert").html(msgtag);
    } else if ($("#accasset").val() == "Select type of Assets") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + 'Select type of Assets!' + ' .</div>';
      $("#myalert").html(msgtag);
    } else if ($("#aucscode").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + 'Account AUCS Code is Required!' + ' .</div>';
      $("#myalert").html(msgtag);
    } else if ($("#submajor").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + 'Sub-Major Account Group is Required!' + ' .</div>';
      $("#myalert").html(msgtag);
    } else if ($("#glaccount").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + 'GL Account Required!' + ' .</div>';
      $("#myalert").html(msgtag);
    } else {

      if (btntag == 0) {
        //Add

        $.ajax({
          url: 'btnsaveaccounttitle.php',
          type: 'get',

          data: {
            txtaccounttitle: $("#txtaccounttitle").val(),
            accasset: $("#accasset").val(),
            Acronyms: $("#txtacro").val(),
            aucscode: $("#aucscode").val(),
            submajor: $("#submajor").val(),
            glaccount: $("#glaccount").val(),
            chkactive: ischeck
          },

          success: function (response) {


            var len = response.length;

            var msg = response[0].msg;
            for (var i = 0; i < len; i++) {
              var msg = response[i].msg;
              var tag = response[i].tag;

              if (tag == 1) {
                var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Account Title Already exist.</div>';
                $("#myalert").html(msgtag);
              } else {
                var msgtag = '<div class="alert alert-success">' + ' Account Title Successfully save.</div>';
                $("#myalert").html(msgtag);
                loadaccountitledetails();
                $("#txtaccounttitle").val("");
                var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
                $("#btnsaveaccounttitle").html(bntval);

                $("#txtaccounttitle").val("");
                $("#accasset").val("");
                $("#txtacro").val("");
                $("#aucscode").val("");
                $("#submajor").val("");
                $("#glaccount").val("");
                $("#chkactive").prop('checked', false);
              }

            }

          }

        })
      } else if (btntag == 1) {
        $.ajax({
          url: 'btnedittitle.php',
          type: 'get',

          data: {
            txtaccounttitle: $("#txtaccounttitle").val(),
            accasset: $("#accasset").val(),
            Acronyms: $("#txtacro").val(),
            aucscode: $("#aucscode").val(),
            submajor: $("#submajor").val(),
            glaccount: $("#glaccount").val(),
            chkactive: ischeck,
            editbtnid: editbtnid
          },
          success: function (response) {
            // $("#myalert").html(response);
            var len = response.length;

            var msg = response[0].msg;
            for (var i = 0; i < len; i++) {
              var msg = response[i].msg;
              var tag = response[i].tag;

              if (tag == 1) {
                var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Account Title Already exist .</div>';
                $("#myalert").html(msgtag);
              } else {
                var msgtag = '<div class="alert alert-success">' + ' Account Title Successfully Edited .</div>';
                $("#myalert").html(msgtag);
                loadaccountitledetails();
                var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
                $("#btnsaveaccounttitle").html(bntval);
                $("#txtaccounttitle").val("");
                $("#accasset").val("");
                $("#txtacro").val("");
                $("#aucscode").val("");
                $("#submajor").val("");
                $("#glaccount").val("");
                $("#chkactive").prop('checked', false);
              }

            }
          }
        })
      }
    }
    $("#btnsaveaccounttitle").prop('disabled', false);
  })





  $(document).on("click", "#btnyestitle", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'btnyestitle.php',
      type: 'get',
      data: { btnid: $("#btnid").val() },
      cache: false,
      success: function (data) {


        loadaccountitledetails();
        $("#myModalconfirm").modal("hide");
        var myalert = "<div class='alert alert-info'> <strong>Information!</strong> Please fill-up the form correctly!  .</div>"
        $("#myalert").html(myalert);

      }
    })


  })

  $(document).on("click", ".btnedittitle", function (e) {
    e.preventDefault();

    btntag = 1;
    var mydata = $(this).attr("id");

    var arr = mydata.split("|");
    editbtnid = arr[0];
    $("#accasset").val(arr[1]);
    $("#txtaccounttitle").val(arr[2]);
    $("#txtacro").val(arr[3]);
    $("#aucscode").val(arr[4]);
    $("#submajor").val(arr[5]);
    $("#glaccount").val(arr[6]);
    if (arr[7] == 1) {
      $("#chkactive").prop('checked', true);
    } else {
      $("#chkactive").prop('checked', false);
    }

    var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Update</span>';
    $("#btnsaveaccounttitle").html(bntval);

    var myalert = "<div class='alert alert-info'> <strong>Edit Mode!</strong> Please fill-up the form correctly!  .</div>";
    $("#myalert").html(myalert);
    $("#accasset").focus();

  })
  $(document).on("click", "#btnaccoutntitle", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'accounttitlesearch.php',
      data: { search: $("#txtsearchaccunttile").val() },
      cache: false,
      success: function (data) {

        $("#rcdetails").html(data);
      }
    })

  })

  $(document).on("click", "#M0001", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Materials Entry</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'M0001.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);


      }
    })

    btntag = 0;
  })



  $(document).on("click", "#btnmaterialssave", function (e) {
    e.preventDefault();
    var msg = "";
    // alert(btntag);


    var mydata = $("#mnutitle").val();
    var arr = mydata.split("|");
    var newactasset = arr[1];
    var txtmyitem = $("#txtartivle").val();
    $("#btnmaterialssave").prop('disabled', true);

    if ($("#txtdescription").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + 'Materials and Supply Description is Required!' + ' .</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtartivle").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + 'Item Name is Required' + ' .</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtreorder").val() == "") {

      var msgtag = '<div class="alert alert-danger">' + 'Reorder point is required' + ' .</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");

    } else if ($("#txtreorder").val() == "0") {
      var msgtag = '<div class="alert alert-danger">' + 'Reorder point is required' + ' .</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");

    } else if ($("#mnuunits").val() == "Select Units") {
      var msgtag = '<div class="alert alert-danger">' + 'Unit of measurement is required' + ' .</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
    } else {

      if (btntag == 0) {

        if (newactasset == 1) {
          // save supplys
          $.ajax({
            url: 'btnmaterialssave.php',
            type: 'get',
            dataType: 'JSON',
            data: {
              mnutitle: arr[0],
              txtitem: $("#txtartivle").val(),
              txtdescription: $("#txtdescription").val(),
              mnuunits: $("#mnuunits").val(),
              txtreorder: $("#txtreorder").val()
            },
            success: function (response) {

              var len = response.length;

              var msg = response[0].msg;
              for (var i = 0; i < len; i++) {
                var msg = response[i].msg;
                var tag = response[i].tag;

                if (tag == 1) {
                  var msgtag = '<div class="alert alert-danger">' + msg + '.</div>';
                  $("#tuklawmodal").html(msgtag);
                  $("#tuklawtitle").html("PSMIS Message");
                  $("#yourtuklaw").modal("show");
                } else {


                  var myalert = "<div class='alert alert-success'> " + "Successfully saved.</div>";
                  $("#tuklawmodal").html(myalert);
                  $("#tuklawtitle").html("PSMIS Message");
                  $("#yourtuklaw").modal("show");

                  $("#mnutitle").focus();

                  lodmaterialsdetails();

                  var msg = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
                  $("#btnmaterialssave").html(msg);


                  if ($("#mnutitle").val() != "Select Account Title") {
                    var newid = $("#mnutitle").val();
                    if (btntag === 1) {

                    } else {
                      var arr = newid.split("|");
                      instantid = arr[0];
                      yourtagid = arr[1];
                      $.ajax({
                        url: 'tyller.php',
                        type: 'get',
                        data: { btnid: arr[0] },
                        cache: false,
                        success: function (data) {

                          $("#tyller").html(data);

                          lodmaterialsdetails();
                        }
                      })
                    }

                  }


                  $("#mnutitle").focus();
                  $("#txtreorder").val("");
                  $("#txtdescription").val("");
                  $("#mnuunits").val("");

                }

              }

            }
          })

        } else {
          // save semi expendables
          // txtartivle
          // txtaccountcode

          $.ajax({
            url: 'savesemi.php',
            type: 'get',
            dataType: 'JSON',
            data: {
              mnutitle: arr[0],
              txtartivle: $("#txtartivle").val(),
              txtyearoflife: $("#txtyearoflife").val(),
              mnuunits: $("#mnuunits").val()

            },
            success: function (response) {


              var len = response.length;

              var msg = response[0].msg;
              for (var i = 0; i < len; i++) {
                var msg = response[i].msg;
                var tag = response[i].tag;

                if (tag == 1) {
                  var msgtag = '<div class="alert alert-danger"><strong>Warning! </strong>' + msg + '.</div>';
                  $("#tuklawmodal").html(msgtag);
                  $("#tuklawtitle").html("PSMIS Message");
                  $("#yourtuklaw").modal("show");
                } else {
                  //  var msgtag =  '<div class="alert alert-success"><strong>Success! </strong> ' + msg +'</div>'; 
                  //   $("#tuklawmodal").html(msgtag);
                  //   $("#tuklawtitle").html("PSMIS Message");
                  //   $("#yourtuklaw").modal("show");
                  lodmaterialsdetails();



                  var myalert = "<div class='alert alert-success'> <strong>Success! </strong> " + txtmyitem + " Successfully saved.</div>";
                  $("#tuklawmodal").html(myalert);
                  $("#tuklawtitle").html("Item Saved");
                  $("#yourtuklaw").modal("show");
                  // $("#myalert").html(myalert);
                  // $("#mnutitle").focus();

                  // $("#mnutitle").focus();

                  $("#txtdescription").val("");
                  $("#mnuunits").val("");
                  var msg = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
                  $("#btnmaterialssave").html(msg);


                }

              }


            }
          })
        }
      } else if (btntag == 1) {
        if (newactasset == 1) {

          $.ajax({
            url: 'btnmatedit.php',
            type: 'get',
            dataType: 'JSON',
            data: {
              mnutitle: arr[0],
              txtitem: $("#txtartivle").val(),

              txtdescription: $("#txtdescription").val(),
              mnuunits: $("#mnuunits").val(),
              txtreorder: $("#txtreorder").val(),
              editbtnid: editbtnid

            },
            success: function (response) {
              // $("#myalert").html(response);
              var len = response.length;

              var msg = response[0].msg;
              for (var i = 0; i < len; i++) {
                var msg = response[i].msg;
                var tag = response[i].tag;

                if (tag == 1) {
                  var msgtag = '<div class="alert alert-danger">' + '<strong>Warning! </strong> ' + msg + ' .</div>';
                  $("#tuklawmodal").html(msgtag);
                  $("#tuklawtitle").html("PSMIS Message");
                  $("#yourtuklaw").modal("show");
                } else {
                  lodmaterialsdetails();



                  var myalert = "<div class='alert alert-success'> <strong>Success! </strong> " + txtmyitem + "Successfully Updated.</div>";
                  $("#tuklawmodal").html(myalert);
                  $("#tuklawtitle").html("PSMIS Message");
                  $("#yourtuklaw").modal("show");
                  // $("#myalert").html(myalert);
                  $("#mnutitle").focus();
                  $("#txtartivle").val("");
                  $("#txtreorder").val("");
                  $("#txtdescription").val("");
                  $("#mnuunits").val("");
                  var msg = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
                  $("#btnmaterialssave").html(msg);

                }

              }
            }
          })
        } else if (newactasset == 2) {
          // ======================
          var yourdata = $("#mnutitle").val();
          var yourarr = yourdata.split("|");


          $.ajax({
            url: 'semippeedit.php',
            type: 'get',

            data: {
              mahalid: mahalid,
              txtartivle: $("#txtartivle").val(),
              mnuunits: $("#mnuunits").val(),
              txtyearoflife: $("#txtyearoflife").val(),
              yourarr: yourarr[0]

            },
            success: function (response) {

              var len = response.length;

              var msg = response[0].msg;
              for (var i = 0; i < len; i++) {
                var msg = response[i].msg;
                var tag = response[i].tag;

                if (tag == 1) {
                  var msgtag = '<div class="alert alert-danger">' + '<strong>Warning! </strong> Duplicate Item Exist  </div>';
                  $("#tuklawmodal").html(msgtag);
                  $("#tuklawtitle").html("PSMIS Message");
                  $("#yourtuklaw").modal("show");
                } else {
                  lodmaterialsdetails();



                  var myalert = "<div class='alert alert-success'> <strong>Success! </strong> " + txtmyitem + "Successfully Updated.</div>";
                  $("#tuklawmodal").html(myalert);
                  $("#tuklawtitle").html("PSMIS Message");
                  $("#yourtuklaw").modal("show");
                  // $("#myalert").html(myalert);
                  $("#mnutitle").focus();
                  $("#txtyearoflife").val("");
                  $("#txtartivle").val("");
                  $("#mnuunits").val("");
                  var msg = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
                  $("#btnmaterialssave").html(msg);


                }

              }
            }
          })
          // ======================================
        } else if (newactasset == 3) {
          // ==========================================
          var yourdata = $("#mnutitle").val();
          var yourarr = yourdata.split("|");


          $.ajax({
            url: 'semippeedit.php',
            type: 'get',

            data: {
              mahalid: mahalid,
              txtartivle: $("#txtartivle").val(),
              mnuunits: $("#mnuunits").val(),
              txtyearoflife: $("#txtyearoflife").val(),
              yourarr: yourarr[0]

            },
            success: function (response) {

              var len = response.length;

              var msg = response[0].msg;
              for (var i = 0; i < len; i++) {
                var msg = response[i].msg;
                var tag = response[i].tag;

                if (tag == 1) {
                  var msgtag = '<div class="alert alert-danger">' + '<strong>Warning! </strong> Duplicate Item Exist.</div>';
                  $("#tuklawmodal").html(msgtag);
                  $("#tuklawtitle").html("PSMIS Message");
                  $("#yourtuklaw").modal("show");
                } else {
                  lodmaterialsdetails();



                  var myalert = "<div class='alert alert-success'> <strong>Success! </strong> " + txtmyitem + "Successfully Updated.</div>";
                  $("#tuklawmodal").html(myalert);
                  $("#tuklawtitle").html("PSMIS Message");
                  $("#yourtuklaw").modal("show");
                  // $("#myalert").html(myalert);
                  $("#mnutitle").focus();
                  $("#txtyearoflife").val("");
                  $("#txtartivle").val("");
                  $("#mnuunits").val("");
                  var msg = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
                  $("#btnmaterialssave").html(msg);

                }

              }
            }
          })
          // ==================================

        }


      }
    }

    lodmaterialsdetails();
    $("#btnmaterialssave").prop('disabled', false);

  })

  $(document).on("click", ".btnmatedit", function (e) {
    e.preventDefault();
    btntag = 1;
    var mydata = $(this).attr("id");

    var arr = mydata.split("|");
    editbtnid = arr[0];
    // alert(arr[1]);
    // $("#mnutitle").val(arr[1]);
    $("#txtartivle").val(arr[3]);
    $("#selitem").val(arr[7]);
    $("#txtstockno").val(arr[3]);
    $("#txtdescription").val(arr[4]);

    $("#mnuunits").val(arr[5]);
    $("#txtreorder").val(arr[6]);
    var msg = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Update</span>';
    $("#btnmaterialssave").html(msg);
  })

  $(document).on("click", "#btnyesmat", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'btnyesmat.php',
      type: 'get',
      data: { btnid: $("#btnid").val() },
      cache: false,
      success: function (data) {

        lodmaterialsdetails();
        $("#myModalconfirm").modal("hide");
        var myalert = "<div class='alert alert-info'> <strong>Information!</strong> Please fill-up the form correctly!  .</div>"
        $("#tuklawmodal").html(myalert);
        $("#tuklawtitle").html("PSMIS Message");
        $("#yourtuklaw").modal("show");

      }
    })
  })



  $(document).on("click", "#T0003", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Receiving Entry </div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 't0003.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
      }
    })
    // loadrecieveddetails();
    btntag = 0;
  })

  $(document).on("click", "#T0004", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Inventory Request Form </div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'T0004.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
        loadrequestdetails();
        loadtablst();
      }
    })


    btntag = 0;
  })
  $(document).on("click", ".btbproedit", function (e) {
    e.preventDefault();
    btntag = 1;
    var mydata = $(this).attr("id");

    var arr = mydata.split("|");
    editbtnid = arr[0];

    $("#fname").val(arr[1]);
    $("#lname").val(arr[2]);
    $("#mname").val(arr[3]);
    $("#address").val(arr[5]);
    $("#contact").val(arr[4]);
    $("#pos").val(arr[6]);
    $("#rc").val(arr[7]);
    $("#sec").val(arr[8]);
    $("#btnprofile").html("Update");

  })


  $(document).on("click", "#btnprofile", function (e) {
    e.preventDefault();


    if ($("#fname").val() == "") {
      var myalert = "<div class='alert alert-danger'> Employee First Name is required.</div>"
      $("#tuklawmodal").html(myalert);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
    } else if ($("#mname").val() == "") {
      var myalert = "<div class='alert alert-danger'>  Employee Middle Name is required.</div>"
      $("#tuklawmodal").html(myalert);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
    } else if ($("#lname").val() == "") {
      var myalert = "<div class='alert alert-danger'>  Employee Last Name is required.</div>"
      $("#tuklawmodal").html(myalert);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
    } else if ($("#pos").val() == "Select Position") {
      var myalert = "<div class='alert alert-danger'> Please select Employee Position.</div>"
      $("#tuklawmodal").html(myalert);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
    } else if ($("#rc").val() == "Select Responsibility Center") {
      var myalert = "<div class='alert alert-danger'>  Please select Responsibility Center.</div>"
      $("#tuklawmodal").html(myalert);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
    } else if ($("#sec").val() == "Select Section") {
      var myalert = "<div class='alert alert-danger'>Please select Employee Section.</div>"
      $("#tuklawmodal").html(myalert);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
    } else {
      if (btntag == 0) {
        $.ajax({
          url: 'btnprofile.php',
          type: 'get',
          dataType: 'JSON',
          data: {
            fname: $("#fname").val(),
            mname: $("#mname").val(),
            lname: $("#lname").val(),
            address: $("#address").val(),
            contact: $("#contact").val(),
            pos: $("#pos").val(),
            rc: $("#rc").val(),
            sec: $("#sec").val()
          },
          success: function (response) {

            var len = response.length;

            var msg = response[0].msg;
            for (var i = 0; i < len; i++) {
              var msg = response[i].msg;
              var tag = response[i].tag;

              if (tag == 1) {
                var msgtag = '<div class="alert alert-danger">' + msg + ' </div>';
                // $("#myalert").html(msgtag);
                $("#tuklawmodal").html(msgtag);
                $("#tuklawtitle").html("PSMIS Message");
                $("#yourtuklaw").modal("show");
              } else {
                var msgtag = '<div class="alert alert-success">' + msg + ' </div>';
                // $("#myalert").html(msgtag);
                $("#tuklawmodal").html(msgtag);
                $("#tuklawtitle").html("PSMIS Message");
                $("#yourtuklaw").modal("show");
                loadprofiledetails();
                $("#fname").val("");
                $("#mname").val("");
                $("#lname").val("");
                $("#address").val("");
                $("#contact").val("");
                $("#pos").val("");
                $("#rc").val("");
                $("#sec").val("");
              }
              $("#btnprofile").html("Register");

            }

          }

        })
      } else if (btntag == 1) {

        $.ajax({
          url: 'btnproedit.php',
          type: 'get',
          dataType: 'JSON',
          data: {
            fname: $("#fname").val(),
            mname: $("#mname").val(),
            lname: $("#lname").val(),
            address: $("#address").val(),
            contact: $("#contact").val(),
            pos: $("#pos").val(),
            rc: $("#rc").val(),
            sec: $("#sec").val(),
            editbtnid: editbtnid
          },
          success: function (response) {

            var len = response.length;

            var msg = response[0].msg;
            for (var i = 0; i < len; i++) {
              var msg = response[i].msg;
              var tag = response[i].tag;

              if (tag == 1) {
                var msgtag = '<div class="alert alert-danger">' + msg + ' </div>';
                // $("#myalert").html(msgtag);
                $("#tuklawmodal").html(msgtag);
                $("#tuklawtitle").html("PSMIS Message");
                $("#yourtuklaw").modal("show");
              } else {
                var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' </div>';
                // $("#myalert").html(msgtag);
                $("#tuklawmodal").html(msgtag);
                $("#tuklawtitle").html("PSMIS Message");
                $("#yourtuklaw").modal("show");
                loadprofiledetails();
                $("#fname").val("");
                $("#mname").val("");
                $("#lname").val("");
                $("#address").val("");
                $("#contact").val("");
                $("#pos").val("");
                $("#rc").val("");
                $("#sec").val("");
                $("#btnprofile").html("Register");
              }

            }
          }
        })

      }
    }

  })

  $(document).on("click", "#txtaccount", function (e) {
    e.preventDefault();
    $("#txtstockno3").trigger("click");
  })

  $(document).on("click", "#txtitem3", function (e) {
    e.preventDefault();
    $("#txtstockno3").trigger("click");
  })

  $(document).on("click", "#txtstockno3", function (e) {
    e.preventDefault();

    $.ajax({
      url: "listofmats.php",
      type: "get",
      data: { mnuasset: 1 },
      cache: false,
      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });

    $("#myModallist").modal("show");
  })
  $(document).on("click", ".itemrowname", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    $("#txtartivle").val(arr[1]);
    $("#myModallist").modal("hide");
  })
  $(document).on("click", "#txtartivle", function (e) {
    e.preventDefault();

    $.ajax({
      url: "txtartivle.php",
      type: "get",
      data: { mnuasset: instantid, yourtagid: yourtagid },
      cache: false,
      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });

    $("#myModallist").modal("show");
  })
  var bal = 0;
  $(document).on("click", ".itemrow", function (e) {
    e.preventDefault();


    var mydata = $(this).attr("id");

    var arr = mydata.split("|");
    editbtnid = arr[0];
    // alert(arr[1]);
    $("#txtitem3").val(arr[2]);
    $("#txtstockno3").val(arr[1]);
    $("#txtdescription3").val(arr[3]);
    $("#txtunits").val(arr[4]);
    $("#txtaccount").val(arr[5]);
    bal = arr[6]

    $("#myModallist").modal("hide");
    $("#txtreorder").val(arr[7]);
  })


  $(document).on("click", "#btnadd", function (e) {
    e.preventDefault();
    var textname = $("#txtitem3").val();
    $("#btnadd").prop('disabled', true);
    if ($("#txtsupplier").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Please Select Supplier.</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      $("#txtsupplier").focus();
    } else if ($("#txtsource").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Please Select Source of Fund!.</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      $("#txtsource").focus()
    } else if ($("#txtquantity").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Quantity is required.</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      $("#txtquantity").focus();



    } else if ($("#txtpodate").val() > $("#txtddate").val()) {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> P.O. date is not later than delivery date.</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      $("#txtpodate").focus();
    } else if ($("#txtquantity").val() < 1) {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Quantity is required.</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      $("#txtquantity").focus();
    } else if ($("#txtamount").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Amount is required.</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      $("#txtamount").focus();
    } else if ($("#txtamount").val() < 1) {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Invalid Amount.</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      $("#txtamount").focus();

    } else {




      $.ajax({
        url: 'addcart.php',
        type: 'get',
        cache: false,
        data: {
          editbtnid: editbtnid,
          txtquantity: $("#txtquantity").val(),
          txtamount: $("#txtamount").val(),
          txtsource: $("#txtsource").val()
        },
        success: function (data) {


          var myalert = "<div class='alert alert-success'>    Successfully added.</div>";
          $("#tuklawmodal").html(myalert);
          $("#tuklawtitle").html("PSMIS Message");
          $("#yourtuklaw").modal("show");
          loadtempreceived();

        }
      })


      $("#txtquantity").val("");
      $("#txtamount").val("");
      $("txtunits").val("");
      $("txtdescription3").val("");
      $("txtitem3").val("");
      $("txtstockno3").val("");
      $("txtaccount").val("");
      $("#txtitem3").val("");
      $("#txtstockno3").val("");
      $("#txtdescription3").val("");
      $("#txtunits").val("");
      $("#txtaccount").val("");
    }

    $("#btnadd").prop('disabled', false);


    // loadrecieveddetails();
  })


  function loadtempreceived() {
    $.ajax({
      url: 'cartdetails.php',
      type: 'get',
      cache: false,
      success: function (data) {

        $("#rcdetails").html(data);
      }
    })
  }

  $(document).on("click", "#btnyesreceive", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'deleterec.php',
      type: 'get',
      data: { btnid: $("#btnid").val() },
      cache: false,
      success: function (data) {


        loadrecieveddetails();
        $("#myModalconfirm").modal("hide");
      }
    })
  })

  $(document).on("click", "#btnsavereceived", function (e) {
    e.preventDefault();
    $("#btnsavereceived").prop('disabled', true);

    var rowcount = $("#rcdetails tr").length;
    // alert(rowcount);

    if ($("#txtsupplier").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Please add supplier.</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      $("#txtsupplier").focus();
    } else if (rowcount < 1) {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Sorry No item to save.</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      $("#txtsupplier").focus();

    } else if ($("#txtsource").val() == "") {

      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Please Select Fund Source.</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      $("#txtsource").focus();
    } else if ($("#txtddate").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Please add delivery date.</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      $("#txtddate").focus();

    } else if ($("#txtpodate").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Please add P.O. Date.</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      $("#txtpodate").focus();

    } else if ($("#txtpodate").val() > $("#txtddate").val()) {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> P.O. date should not be  later than delivery date.</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      $("#txtpodate").focus();
    } else if ($("#txtPO").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> P.O. Number is required.</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      $("#txtPO").focus();
    } else if ($("#txtreceiptni").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Delivery Receipt Number is requiered</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      $("#txtreceiptni").focus();
    } else {
      if ($("#rcdetails").html() != "") {

        $.ajax({
          url: "listtosavereceived.php",
          data: {
            txtsupplier: $("#txtsupplier").val(),
            txtsource: $("#txtsource").val(),
            txtPO: $("#txtPO").val(),
            txtddate: $("#txtddate").val(),
            txtpodate: $("#txtpodate").val(),
            txtreceiptni: $("#txtreceiptni").val()

          },
          type: "get",
          cache: false,

          success: function (data) {
            $("#richielistmodal").html(data);
          }
        });

        $("#myModallist").modal("show");




      }
    }
    $("#btnsavereceived").prop('disabled', false);
  })

  $(document).on("click", "#btnyestosave", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'savereceiving.php',
      type: 'get',
      data: {
        supplierid: supplierid,
        fundid: fundid,
        txtPO: $("#txtPO").val(),
        txtddate: $("#txtddate").val(),
        txtpodate: $("#txtpodate").val(),
        txtreceiptni: $("#txtreceiptni").val()
      },
      dataType: 'JSON',
      success: function (response) {
        // $("#myalert").html(response);
        // alert(response);
        var len = response.length;

        var msg = response[0].msg;
        for (var i = 0; i < len; i++) {
          var msg = response[i].msg;
          var tag = response[i].tag;


          var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';
          $("#tuklawmodal").html(msgtag);
          $("#tuklawtitle").html("PSMIS Message");
          $("#yourtuklaw").modal("show");



        }
        loadtempreceived();
        $("#myModallist").modal("hide");
        $("#mnuasset").focus();
        $("#txtsupplier").val("");
        $("#txtsource").val("");
        $("#txtPO").val("");
        $("#txtreceiptni").val("");
      }
    })

  })

  $(document).on("click", "#btnaddrec", function (e) {
    e.preventDefault();
    // alert(bal);
    $("#btnaddrec").prop('disabled', true);
    if ($("#txtstockno3").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Please Select Materials and Supply.</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtquantity").val() < 1) {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Invalid Quantity!</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
    } else if ($("#dtpdate").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Date  is required.</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      // }else if(   $("#txtquantity").val() > bal  ){
      //   var msgtag =  '<div class="alert alert-danger">' + '<strong></strong> Insufficient Stocks!</div>'; 
      //   $("#tuklawmodal").html(msgtag);
      //   $("#tuklawtitle").html("PSMIS Message");
      //   $("#yourtuklaw").modal("show");
      //
    } else {

      $.ajax({
        url: 'savetempreq.php',
        type: "get",
        data: {
          editbtnid: editbtnid,
          bal: bal,
          txtquantity: $("#txtquantity").val(),
          txtamount: $("#txtamount").val(),
          txtsource: $("#txtsource").val()
        },

        dataType: 'JSON',
        success: function (response) {
          // $("#myalert").html(response);


          var len = response.length;

          var msg = response[0].msg;
          for (var i = 0; i < len; i++) {
            var msg = response[i].msg;
            var tag = response[i].tag;

            if (tag == 1) {
              var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';
              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("PSMIS Message");
              $("#yourtuklaw").modal("show");
              loadrequestdetails();
              loadtablst();
              $("#txtitem3").val("");
              $("#txtstockno3").val("");
              $("#txtdescription3").val("");
              $("#txtunits").val("");
              $("#txtquantity").val("");


            } else {
              var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';
              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("PSMIS Message");
              $("#yourtuklaw").modal("show");
            }


          }
        }

      })




    }
    $("#btnaddrec").prop('disabled', false);

  })

  $(document).on("click", "#btnreqyes", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'deletereq.php',
      type: 'get',
      data: { btnid: $("#btnid").val() },
      cache: false,
      success: function (data) {


        loadrequestdetails();
        $("#myModalconfirm").modal("hide");
      }
    })
  })

  $(document).on("click", "#btnsaverequest", function (e) {
    e.preventDefault();
    $("#btnsaverequest").prop('disabled', true);
    if ($("#txtpurpose").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong>Request Purpose is required!.</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
    } else if ($("#dtpdate").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Please Select date of request.</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
    } else {

      $.ajax({
        url: 'requestlist.php',
        type: 'get',

        data: {
          txtpurpose: $("#txtpurpose").val()
          , dtpdate: $("#dtpdate").val()
        },
        success: function (response) {

          $("#richielistmodal").html(response);

        }
      })
      $("#myModallist").modal("show");
    }
    $("#btnsaverequest").prop('disabled', false);
  })
  $(document).on("click", "#btnnoreq", function (e) {
    e.preventDefault();
    $("#myModallist").modal("hide");
  })
  $(document).on("click", "#btnyesreq", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'saverequest.php',
      type: 'get',
      dataType: 'JSON',
      data: {
        txtpurpose: $("#txtpurpose").val()
        , dtpdate: $("#dtpdate").val()
      },
      success: function (response) {
        $("#myalert").html(response);
        var len = response.length;

        var msg = response[0].msg;
        for (var i = 0; i < len; i++) {
          var msg = response[i].msg;
          var tag = response[i].tag;


          var msgtag = '<div class="alert alert-success">' + '' + msg + ' </div>';
          $("#tuklawmodal").html(msgtag);
          $("#tuklawtitle").html("PSMIS Message");
          $("#yourtuklaw").modal("show");
          $("#myModallist").modal("hide");
          loadrequestdetails();

        }
      }
    })

  })
  $(document).on("click", "#T0005", function (e) {
    e.preventDefault();
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">PROPERTY ACKNOWLEDGMENT RECEIPT</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'newppetab.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html('<div class="container">' + data + '</div>');
      }
    })

    btntag = 0;
  })
  $(document).on("click", "#T0006", function (e) {

    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">REQUISITION AND ISSUE SLIP Approval </div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'T0006.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
      }
    })

    btntag = 0;
  })


  $(document).on("click", ".btnviewris", function (e) {
    e.preventDefault();


    var mydata = $(this).attr("id");

    var arr = mydata.split("|");

    var purpose = arr[1];
    var Requestedby = arr[2];
    var DateRequest = arr[3];
    $.ajax({
      url: "listofris.php",
      type: "get",
      cache: false,
      data: {
        myid: arr[0],
        purpose: purpose,
        Requestedby: Requestedby,
        DateRequest: DateRequest
      },
      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });

    $("#myModallist").modal("show");
  })

  $(document).on("click", ".btnapproveris", function (e) {
    e.preventDefault();
    var myid = $(this).attr("id");
    $.ajax({
      url: 'approveris.php',
      type: 'get',
      data: { myid: myid },
      cache: false,
      success: function (data) {
        $("#myModallist").modal("hide");

      }
    })
  })

  $(document).on("click", ".btnrelease", function (e) {
    e.preventDefault();
    var myid = $(this).attr("id");
    $.ajax({
      url: "par.php",
      type: "get",
      cache: false,
      data: { myid: myid },
      success: function (data) {
        $("#richielistmodal1").html(data);
      }
    })

    $("#mymodalrichie").modal("show");
  })



  $(document).on("click", "#R0001", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Stock Card</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'R0001.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
      }
    })
    rgn = 1;
    btntag = 0;
  })

  $(document).on("change", "#txtsearchmats", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'txtsearchmats.php',
      cache: false,
      type: 'get',
      data: {
        txtsearchmats: $("#txtsearchmats").val()
        , mnuasset: 1
      },
      success: function (data) {
        $("#listofmats").html(data);
      }
    })
  })
  $(document).on("click", "#btnsearchmats", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'txtsearchmats.php',
      cache: false,
      type: 'get',
      data: {
        txtsearchmats: $("#txtsearchmats").val(),
        mnuasset: 1
      },
      success: function (data) {
        $("#listofmats").html(data);
      }
    })
  })


  $(document).on("click", "#btnsearchprofile", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'sprodetails.php',
      cache: false,
      data: { txtsearchprofile: $("#txtsearchprofile").val() },
      success: function (data) {

        $("#rcdetails").html(data);
      }
    })
  })

  $(document).on("click", "#btnsearchaccount", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'txtsearchaccount.php',
      cache: false,
      data: { txtsearchaccount: $("#txtsearchaccount").val() },
      success: function (data) {

        $("#mnudetails").html(data);
      }
    })
  })

  function populateunit() {
    $.ajax({
      url: 'units.php',
      cache: false,
      success: function (data) {

        $("#mnutitle").html(data);
      }
    })
  }

  $(document).on("click", "#M0002", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Article Name List</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'M0002.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
        // $("#txtaccounttitle").addClass('richieholder');
        // loaditemname();
      }
    })

    btntag = 0;
    var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
    $("#btnsaveitemname").html(bntval);
  })

  $(document).on("click", "#btnsearchitemname", function (e) {
    e.preventDefault();
    if ($("#seltitle").val() != "0") {
      $.ajax({
        url: 'btnsearchitemname.php',
        cache: false,
        type: 'get',
        data: {
          txtsearchitemname: $("#txtsearchitemname").val(),
          seltitle: $("#seltitle").val()
        },
        success: function (data) {
          $("#rcdetails").html(data);
        }
      })
    }
  })
  $(document).on("click", "#btnsaveitemname", function (e) {
    e.preventDefault();
    $("#btnsaveitemname").prop('disabled', true);
    if ($("#txtitemname").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + 'Item Name is required!</div>';
      // $("#myalert").html(msgtag);
      // var msgtag =  '<div class="alert alert-danger">' + 'Item Name exist.</div>'; 
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");



    } else if ($("#seltitle").val() == 0) {
      var msgtag = '<div class="alert alert-danger">' + 'Select Account Title!</div>';
      //  $("#myalert").html(msgtag);
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
    } else {
      if (btntag == 0) {
        $.ajax({
          url: 'btnsaveitemname.php',
          type: 'get',
          dataType: 'JSON',
          data: { txtitemname: $("#txtitemname").val(), seltitle: $("#seltitle").val() },

          success: function (response) {
            var len = response.length;
            // alert(response);
            var msg = response[0].msg;
            for (var i = 0; i < len; i++) {
              var msg = response[i].msg;
              var tag = response[i].tag;

              if (tag == 1) {
                var msgtag = '<div class="alert alert-danger">' + 'Item Name exist.</div>';
                $("#tuklawmodal").html(msgtag);
                $("#tuklawtitle").html("PSMIS Message");
                $("#yourtuklaw").modal("show");
              } else {
                var msgtag = '<div class="alert alert-success">' + 'Successfully added .</div>';
                $("#tuklawmodal").html(msgtag);
                $("#tuklawtitle").html("PSMIS Message");
                $("#yourtuklaw").modal("show");

                $("#txtitemname").val("");
                var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
                $("#btnsaveitemname").html(bntval);

                $.ajax({
                  url: 'M0002.php',
                  cache: false,
                  type: 'get',
                  success: function (data) {
                    $("#frmmodalbody").html(data);

                  }
                })

                // loaditemname();
              }

            }

          }

        })
      } else if (btntag == 1) {
        $.ajax({
          url: 'btnupdateitem.php',
          type: 'get',

          data: {
            txtitemname: $("#txtitemname").val()
            , seltitle: $("#seltitle").val(),
            editbtnid: editbtnid
          },
          dataType: 'JSON',
          success: function (response) {


            var len = response.length;

            var msg = response[0].msg;
            for (var i = 0; i < len; i++) {
              var msg = response[i].msg;
              var tag = response[i].tag;

              if (tag == 1) {
                var msgtag = '<div class="alert alert-danger">' + msg + ' .</div>';
                $("#tuklawmodal").html(msgtag);
                $("#tuklawtitle").html("PSMIS Message");
                $("#yourtuklaw").modal("show");
              } else {
                var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';
                $("#tuklawmodal").html(msgtag);
                $("#tuklawtitle").html("PSMIS Message");
                $("#yourtuklaw").modal("show");

                $("#txtitemname").val("");
                var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
                $("#btnsaveitemname").html(bntval);
                // loaditemname();


                $.ajax({
                  url: 'M0002.php',
                  cache: false,
                  type: 'get',
                  success: function (data) {
                    $("#frmmodalbody").html(data);

                  }
                })

              }

            }

          }

        })
      }
    }
    btntag = 0;
    $("#btnsaveitemname").prop('disabled', false);
  })

  $(document).on("click", ".btnedititemname", function (e) {
    e.preventDefault();
    btntag = 1;
    var mydata = $(this).attr("id");

    var arr = mydata.split("|");
    editbtnid = arr[0];
    $("#txtitemname").val(arr[1]);

    $("#seltitle").val(arr[2]);

  })


  $(document).on("click", "#btnitemnameyes", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'btnitemnameyes.php',
      type: 'get',
      data: { btnid: $("#btnid").val() },
      cache: false,
      success: function (data) {



        $.ajax({
          url: 'M0002.php',
          cache: false,
          type: 'get',
          success: function (data) {
            $("#frmmodalbody").html(data);

          }
        })
        // loaditemname();
        $("#myModalconfirm").modal("hide");
        var myalert = "<div class='alert alert-success'> Successfully deleted.</div>"
        $("#tuklawmodal").html(myalert);
        $("#tuklawtitle").html("PSMIS Message");
        $("#yourtuklaw").modal("show");
      }
    })
  })
  var instantid = 0;
  var yourtagid = 0;
  $(document).on("change", "#mnutitle", function (e) {
    e.preventDefault();

    if ($(this).val() != "Select Account Title") {
      var newid = $(this).val();
      if (btntag === 1) {

      } else {
        var arr = newid.split("|");
        instantid = arr[0];
        yourtagid = arr[1];
        $.ajax({
          url: 'tyller.php',
          type: 'get',
          data: { btnid: arr[0] },
          cache: false,
          success: function (data) {

            $("#tyller").html(data);

            lodmaterialsdetails();
          }
        })
      }

    }

  })

  $(document).on("click", "#A0010", function (e) {
    e.preventDefault();

    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Funding Source</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'A0010.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
        loadfundclusterdetails();

      }
    })

    btntag = 0;
    var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
    $("#btnsaveaccounttitle").html(bntval);
  })

  $(document).on("click", ".btneditcluster", function (e) {
    e.preventDefault();

    btntag = 1;
    var mydata = $(this).attr("id");

    var arr = mydata.split("|");
    editbtnid = arr[0];
    $("#fundcode").val(arr[1]);
    $("#fsource").val(arr[2]);
    $("#txtauthorization").val(arr[3]);
    $("#fcategory").val(arr[4]);
    if (arr[5] == 1) {
      $("#chkactive").prop('checked', true);
    } else {
      $("#chkactive").prop('checked', false);
    }


    var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Update</span>';
    $("#btnsavefundcluster").html(bntval);

    var myalert = "<div class='alert alert-info'> <strong>Edit Mode!</strong> Please fill-up the form correctly!  .</div>";
    $("#tuklawmodal").html(myalert);
    $("#tuklawtitle").html("PSMIS Message");
    // $("#yourtuklaw").modal("show");
    $("#accasset").focus();
  })

  $(document).on("click", "#btnsearchcluster", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'searchfundcluster.php',
      type: 'get',
      data: { txtSearchcluster: $("#txtSearchcluster").val() },
      cache: false,
      success: function (data) {

        $("#rcdetails").html(data);
      }
    })
  })

  $(document).on("click", "#btnsavefundcluster", function (e) {
    e.preventDefault();

    var ischeck = 0;
    if ($("#chkactive").is(':checked')) {
      ischeck = 1;
    }
    if ($("#fundcode").val() == "") {
      var myalert = "<div class='alert alert-danger'>  Fund Cluster Code is required!  </div>";
      $("#tuklawmodal").html(myalert);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      $("#fundcode").focus();
    } else if ($("#fsource").val() == "") {
      var myalert = "<div class='alert alert-danger'>  Financing Source is required!  </div>";
      $("#tuklawmodal").html(myalert);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      $("#fsource").focus();
    } else if ($("#txtauthorization").val() == "") {
      var myalert = "<div class='alert alert-danger'>  Authorization is required!  </div>";
      $("#tuklawmodal").html(myalert);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      $("#txtauthorization").focus();
    } else if ($("#fcategory").val() == "") {
      var myalert = "<div class='alert alert-danger'>  Fund category is required!  </div>";
      $("#tuklawmodal").html(myalert);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      $("#fcategory").focus();
    } else {


      if (btntag == 0) {
        $.ajax({
          url: 'btnsavefundcluster.php',
          type: 'get',
          data: {
            fundcode: $("#fundcode").val(),
            fsource: $("#fsource").val(),
            txtauthorization: $("#txtauthorization").val(),
            fcategory: $("#fcategory").val(),
            chkactive: ischeck
          },
          dataType: 'JSON',
          success: function (response) {


            var len = response.length;

            var msg = response[0].msg;
            for (var i = 0; i < len; i++) {
              var msg = response[i].msg;
              var tag = response[i].tag;

              if (tag == 1) {
                var msgtag = '<div class="alert alert-danger">' + msg + ' .</div>';
                $("#tuklawmodal").html(msgtag);
                $("#tuklawtitle").html("PSMIS Message");
                $("#yourtuklaw").modal("show");
              } else {
                var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';
                $("#tuklawmodal").html(msgtag);
                $("#tuklawtitle").html("PSMIS Message");
                $("#yourtuklaw").modal("show");

                $("#txtitemname").val("");
                var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
                $("#btnsaveitemname").html(bntval);
              }

            }

          }

        })
      } else if (btntag == 1) {
        $.ajax({
          url: 'btnupdatefundcluster.php',
          type: 'get',

          data: {
            fundcode: $("#fundcode").val(),
            fsource: $("#fsource").val(),
            txtauthorization: $("#txtauthorization").val(),
            fcategory: $("#fcategory").val(),
            editbtnid: editbtnid,
            chkactive: ischeck
          },
          dataType: 'JSON',
          success: function (response) {


            var len = response.length;

            var msg = response[0].msg;
            for (var i = 0; i < len; i++) {
              var msg = response[i].msg;
              var tag = response[i].tag;

              if (tag == 1) {
                var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';
                $("#tuklawmodal").html(msgtag);
                $("#tuklawtitle").html("PSMIS Message");
                $("#yourtuklaw").modal("show");
              } else {
                var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';
                $("#tuklawmodal").html(msgtag);
                $("#tuklawtitle").html("PSMIS Message");
                $("#yourtuklaw").modal("show");

                $("#txtitemname").val("");
                var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
                $("#btnsavefundcluster").html(bntval);
              }

            }

          }

        })
      }

      var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
      $("#btnsavefundcluster").html(bntval);
      $("#chkactive").prop('checked', false);
      $("#fundcode").val("");
      $("#fsource").val("");
      $("#txtauthorization").val("");
      $("#fcategory").val("");
      loadfundclusterdetails();
    }

    $("#btnsavefundcluster").prop('disabled', false);
  })


  $(document).on("click", "#btnyescluster", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'btnyescluster.php',
      type: 'get',
      data: { btnid: $("#btnid").val() },
      cache: false,
      success: function (data) {

        loadfundclusterdetails();
        $("#myModalconfirm").modal("hide");
        var myalert = "<div class='alert alert-info'> <strong>Information!</strong> Fund Cluster Deleted!  .</div>"
        $("#tuklawmodal").html(myalert);
        $("#tuklawtitle").html("PSMIS Message");
        $("#yourtuklaw").modal("show");

      }
    })
  })



  $(document).on("change", "#seltype", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'receivingcont.php',
      type: 'get',
      data: {
        mnuasset: $("#mnuasset").val(),
        seltype: $("#seltype").val()
      },
      success: function (data) {
        $("#receivingbox").html(data);

        loadmydetails();



      }
    })
    if ($(this).val() == "Receiving (Transfer From)") {
      var ss = ' &nbsp;&nbsp;&nbsp;<button class ="btn btn-primary " id="btnmanual" style="margin-letf:5px; ">Switch to Manual</button>';

      $("#divmanual").html(ss);

      // $("#btnmanual").removeClass("richiehide");
      if ($("#mnuasset").val() == 2) {

        $.ajax({
          url: 'semitransfer.php',
          cache: false,
          type: 'get',
          success: function (response) {
            $("#receivingbox").html(response);
            // alert(response);
          }
        })
      } else if ($("#mnuasset").val() == 3) {
        $.ajax({
          url: 'ppetransfer.php',
          cache: false,
          type: 'get',
          success: function (response) {
            $("#receivingbox").html(response);
          }
        })
      }
    } else {
      $("#divmanual").html("");
      // $("#btnmanual").addClass("richiehide");
    }


  })
  var mymanual = 0;
  function loadmymanual() {
    $.ajax({
      url: 'tempmanualrec.php',
      type: 'get',
      cache: false,
      success: function (data) {
        $("#rcdetails").html(data);
      }
    })
  }
  $(document).on("click", "#btnmanual", function (e) {
    e.preventDefault();
    if (mymanual == 0) {
      mymanual = 1;
      $("#btnmanual").html("Switch to Auto");
      if ($("#mnuasset").val() == 2) {

        $.ajax({
          url: 'transfersemi.php',
          type: 'get',
          cache: false,
          success: function (response) {
            $("#receivingbox").html(response);
            loadmanualsemi();
          }
        })
      } else if ($("#mnuasset").val() == 3) {
        $.ajax({
          url: 'ppetransfermanual.php',
          type: 'get',
          cache: false,
          success: function (response) {
            $("#receivingbox").html(response);
            loadmymanual();
          }
        })
      }


    } else if (mymanual == 1) {
      mymanual = 0;
      $("#btnmanual").html("Switch to Manual");
      // $("#receivingbox").html("Auto mode");
      if ($("#mnuasset").val() == 2) {
        // alert("chie");
        $.ajax({
          url: 'semitransfer.php',
          cache: false,
          type: 'get',
          success: function (response) {
            $("#receivingbox").html(response);
            // alert(response);
          }
        })
      } else if ($("#mnuasset").val() == 3) {
        $.ajax({
          url: 'ppetransfer.php',
          cache: false,
          type: 'get',
          success: function (response) {
            $("#receivingbox").html(response);
          }
        })
      }


    }
  })
  function loadmydetails() {
    if (($("#mnuasset").val() == 2) && ($("#seltype").val() == "Receiving (Purchase)")) {
      tempsimereceive();

    } else if (($("#mnuasset").val() == 2) && ($("#seltype").val() == "Receiving (Transfer From)")) {

    } else if (($("#mnuasset").val() == 3) && ($("#seltype").val() == "Receiving (Purchase)")) {
      tempppereceive();
    } else if (($("#mnuasset").val() == 3) && ($("#seltype").val() == "Receiving (Transfer From)")) {

    } else {
      loadtempreceived();
    }
  }

  $(document).on("click", "#btnshowreceive", function (e) {
    e.preventDefault();
    $("#seltype").trigger("change");



    loadmydetails();
  })

  $(document).on("click", "#txtsupplier", function (e) {
    e.preventDefault();
    $.ajax({
      url: "listofsup.php",
      type: "get",
      cache: false,
      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });

    $("#myModallist").modal("show");
  })

  var supplierid = 0;
  $(document).on("click", ".itemrowsupplier", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");

    var arr = mydata.split("|");
    supplierid = arr[0];
    // alert(arr[1]);

    $("#txtsupplier").val(arr[1]);


    $("#myModallist").modal("hide");
  })

  $(document).on("click", "#txtsource", function (e) {
    e.preventDefault();
    $.ajax({
      url: "listofund.php",
      type: "get",
      cache: false,
      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });

    $("#myModallist").modal("show");

  })
  var fundid = 0;
  $(document).on("click", ".itemrowfund", function (e) {
    e.preventDefault();

    var mydata = $(this).attr("id");

    var arr = mydata.split("|");
    fundid = arr[0];
    // alert(arr[1]);


    $("#txtsource").val(arr[1]);


    $("#myModallist").modal("hide");
  })
  $(document).on("click", ".itemroweq", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");

    var arr = mydata.split("|");
    editbtnid = arr[0];
    // alert(arr[1]);

    $("#txtaccount").val(arr[1]);
    $("#txtarticle").val(arr[2]);
    $("#txtestimated").val(arr[3]);
    if (arr[1] == "Motor Vehicles") {
      $("#txtchasis").removeClass("richiehide");

      $("#txtengine").attr("placeholder", "Engine Number");

      // $("#txtchasis").addClass("richiehide");
      // $("#txtengine").attr("placeholder","Serial Number");
    } else if (arr[1] == "Motor Vehicle") {
      $("#txtchasis").removeClass("richiehide");

      $("#txtengine").attr("placeholder", "Engine Number");


    } else {
      $("#txtchasis").addClass("richiehide");
      $("#txtengine").attr("placeholder", "Serial Number");
    }

    $("#myModallist").modal("hide");

    $.ajax({
      url: 'listofproperty.php',
      type: 'get',
      cache: false,
      data: { editbtnid: editbtnid },
      success: function (data) {
        $("#selproperty").html(data);
      }
    })

  })
  $(document).on("click", "#txtarticle", function (e) {
    e.preventDefault();

    $.ajax({
      url: "listofequipment.php",
      type: "get",
      data: { mnuasset: $("#mnuasset").val() },
      cache: false,
      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });

    $("#myModallist").modal("show");
  })
  $(document).on("click", "#btnsearchpper", function (e) {
    e.preventDefault();

    $.ajax({
      url: "btnsearchpper.php",
      type: "get",
      data: {
        mnuasset: $("#mnuasset").val()
        , txtppe: $("#txtppe").val()
      },
      cache: false,
      success: function (data) {
        $("#listofmats").html(data);
      }
    });
  })


  $(document).on("click", ".btnremovetemplist", function (e) {
    e.preventDefault();
    var myid = $(this).attr("id");
    $.ajax({
      url: 'deletetemp.php',
      type: 'get',
      data: { myid: myid },
      cache: false,
      success: function (data) {

        loadtempreceived();

      }
    })
  })

  $(document).on("click", "#receivelisttab", function (e) {
    e.preventDefault();
    loadtab();
  })
  // $(document).on("click",".itemset",function(e){
  //   e.preventDefault();
  //    var mydata = $(this).attr("id");

  //         var arr = mydata.split("|");
  //         var  transcode  = arr[0];
  //         var  Suppliername  = arr[1];
  //         var  Pono  = arr[2];
  //         var  PoDate = arr[3];
  //         var  receiptno = arr[4];
  //         var  datereceived = arr[5];


  //       $.ajax({
  //         url:"listofitem.php",
  //         data:{
  //                 transcode:transcode,
  //                 Suppliername:Suppliername,
  //                 Pono:Pono,
  //                 PoDate:PoDate,
  //                 receiptno:receiptno,
  //                 datereceived:datereceived
  //         },
  //         type:"get",
  //         cache:false,

  //         success:function(data){
  //           $("#richielistmodal").html(data);
  //         }
  //     });

  //     $("#myModallist").modal("show");



  // })

  function loadtab() {
    $.ajax({
      url: 'listofreceived.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#tabrichie").html(data);
      }
    })
  }

  function loadtablst() {
    $.ajax({
      url: 'newrislist.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#tabrichie").html(data);
      }
    })
  }

  $(document).on("click", "#rislist", function (e) {
    e.preventDefault();
    loadtablst();
  })

  $(document).on("click", ".itemsetris", function (e) {
    var mydata = $(this).attr("id");

    var arr = mydata.split("|");
    var risno = arr[0];
    var purpose = arr[1];
    var Requestedby = arr[2];
    var DateRequest = arr[3];


    $.ajax({
      url: "listofmyris.php",
      data: {
        risno: risno,
        purpose: purpose,
        Requestedby: Requestedby,
        DateRequest: DateRequest
      },
      type: "get",
      cache: false,

      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });

    $("#myModallist").modal("show");
  })

  $(document).on("click", ".btnapprovemyris", function (e) {
    e.preventDefault();

    // var yourid = "txtremarks" + myid;
    // var result = $(this).closest('tr').find(".yourtxtremarks").val();

    var mydata = $(this).attr("id");

    var arr = mydata.split("|");
    var purpose = arr[1];
    var Requestedby = arr[2];
    var DateRequest = arr[3];
    var rsino = arr[4];

    var txtremarks = "#txtremarks" + arr[0];

    $.ajax({
      url: "listforrisapproval.php",
      type: "get",
      cache: false,
      data: {
        myid: arr[4],
        purpose: purpose,
        Requestedby: Requestedby,
        DateRequest: DateRequest,
        result: $(txtremarks).val(),
        yourid: arr[0]
      },
      success: function (data) {
        $("#richielistmodal").html(data);

      }
    });

    $("#myModallist").modal("show");
  })

  $(document).on("click", ".btnyesapproval", function (e) {
    e.preventDefault();

    var mydata = $(this).attr("id");
    var arr = mydata.split("|");

    $.ajax({
      url: 'approveyourris.php',
      type: 'get',
      data: {
        myid: arr[0],
        remarks: arr[1]
      },
      cache: false,
      success: function (data) {
        '<div class="panel-heading">REQUISITION AND ISSUE SLIP Approval </div>' +
          '<div class="panel-body" id="frmmodalbody">' +
          ' <div id="mnudetails"></div> </div> </div></div>';

        $("#richiedetails").html(strform);
        $.ajax({
          url: 'T0006.php',
          cache: false,
          type: 'get',
          success: function (data) {
            $("#frmmodalbody").html(data);
          }
        })

      }
    })


    $("#myModallist").modal("hide");

    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">REQUISITION AND ISSUE SLIP Approval </div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'T0006.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
      }
    })

    btntag = 0;


  })

  $(document).on("click", ".btndisapprovemyris", function (e) {
    e.preventDefault();

    var mydata = $(this).attr("id");

    var arr = mydata.split("|");
    var purpose = arr[1];
    var Requestedby = arr[2];
    var DateRequest = arr[3];
    var rsino = arr[4];

    var txtremarks = "#txtremarks" + arr[0];

    $.ajax({
      url: "listofdisapprove.php",
      type: "get",
      cache: false,
      data: {
        myid: arr[4],
        purpose: purpose,
        Requestedby: Requestedby,
        DateRequest: DateRequest,
        result: $(txtremarks).val(),
        yourid: arr[0]
      },
      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });

    $("#myModallist").modal("show");
  })

  $(document).on("click", "#bntnonono", function (e) {
    e.preventDefault();
    $("#myModallist").modal("hide");
  })
  $(document).on("click", ".btnyesdisapproved", function (e) {
    e.preventDefault();


    var mydata = $(this).attr("id");
    var arr = mydata.split("|");

    $.ajax({
      url: 'disapproveris.php',
      type: 'get',
      data: {
        myid: arr[0],
        remarks: arr[1]
      },
      cache: false,
      success: function (data) {
        $("#T0006").trigger("click");
        // alert(data);
      }
    })


    $("#myModallist").modal("hide");

  })
  $(document).on("click", "#T0007", function (e) {

    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Issuance </div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'T0007.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
      }
    })

    btntag = 0;

  })


  $(document).on("change", "#selmytype", function (e) {
    e.preventDefault();

    var myopt = "";
    var myval = $(this).val();
    if (myval == 1) {
      $("#seltypetrans").html(myopt);
    } else if (myval == 2) {
      myopt = '<option value="1">INVENTORY CUSTODIAN SLIP (ICS)</option>' +
        '<option value="2">PROPERTY TRANSFER REPORT (PTR)</option>';
      $("#seltypetrans").html(myopt);
    } else if (myval == 3) {
      myopt = '<option value="1">PROPERTY ACKNOWLEDGEMENT RECEIPT (PAR)</option>' +
        '<option value="2">PROPERTY TRANSFER REPORT (PTR)</option>';
      $("#seltypetrans").html(myopt);
    }

  })
  var myshow = 0;
  $(document).on("click", "#btnshowtrans", function (e) {
    e.preventDefault();

    if ($("#selmytype").val() == 1) {

      $.ajax({
        url: 'inventoryissuance.php',
        cache: false,
        type: 'get',
        success: function (data) {
          $("#receivingbox").html(data);
        }
      })


    } else if (($("#selmytype").val() == 2) && ($("#seltypetrans").val() == 1)) {
      $.ajax({
        url: 'semiissuance.php',
        cache: false,
        type: 'get',
        success: function (data) {
          $("#receivingbox").html(data);
          ppetempicsdetails();
        }
      })

      myshow = 2;
    } else if (($("#selmytype").val() == 2) && ($("#seltypetrans").val() == 2)) {
      $.ajax({
        url: 'ptrissuance.php',
        cache: false,
        type: 'get',
        success: function (data) {
          $("#receivingbox").html(data);
          ptrtempdetails();

        }
      })
      myshow = 2;
    } else if (($("#selmytype").val() == 3) && ($("#seltypetrans").val() == 1)) {
      $.ajax({
        url: 'ppeissuance.php',
        cache: false,
        type: 'get',
        success: function (data) {
          $("#receivingbox").html(data);

          ppetempdetails();
        }
      })
      myshow = 3;
    } else if (($("#selmytype").val() == 3) && ($("#seltypetrans").val() == 2)) {
      myshow = 3;
      $.ajax({
        url: 'ptrpeeissuance.php',
        cache: false,
        type: 'get',
        success: function (data) {
          $("#receivingbox").html(data);
          ptrtempdetails();
        }
      })
    }
  })



  var richiecode = "";
  var empyeeid = "";
  $(document).on("click", ".txtreceivedby", function (e) {
    e.preventDefault();

    richiecode = '#' + $(this).attr("id");
    empyeeid = '#' + $(this).attr("id") + $(this).attr("id");

    $.ajax({
      url: "listofemployees.php",
      type: "get",
      cache: false,
      success: function (data) {
        $("#richierichmodal").html(data);
      }
    });

    $("#tymodal").modal("show");
  })

  $(document).on("click", ".employeerow", function (e) {
    e.preventDefault();


    var mydata = $(this).attr("id");
    var arr = mydata.split("|");

    $(richiecode).val(arr[1]);
    $(empyeeid).val(arr[0]);
    $("#tymodal").modal("hide");
  })



  var tagabato = "";

  $(document).on("click", ".btnreleaseitem", function (e) {
    e.preventDefault();


    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    var txtapproveqty = "#txtapproveqty" + arr[0];
    var txtmyqty = "#txtmyqty" + arr[0];
    var code = arr[1];
    tagabato = "#" + arr[2];
    var avls = arr[3];
    var app = $(txtapproveqty).val();
    var req = $(txtmyqty).val();

    if ($(tagabato).val() == "") {
      var myalert = "<div class='alert alert-danger'> <strong>Warning!</strong> Receive By is Required.</div>";
      $("#tuklawmodal").html(myalert);
      $("#tuklawtitle").html("Receiver Warning");
      $("#yourtuklaw").modal("show");
      // $("#myalert").html(myalert);
      $("#selmytype").focus();

      // }else if(avls > le ){
      // }else if($(txtapproveqty).val() < 1 ){
      //   var myalert = "<div class='alert alert-danger'> <strong>Warning!</strong> Approved Quantity is Required!</div>";
      //   $("#tuklawmodal").html(myalert);
      //   $("#tuklawtitle").html("Approved Quantity Warning");
      //   $("#yourtuklaw").modal("show");

    } else if ($(txtapproveqty).val() == "") {

      var myalert = "<div class='alert alert-danger'> <strong>Warning!</strong> Approve Quantity is Required!</div>";
      $("#tuklawmodal").html(myalert);
      $("#tuklawtitle").html("Approved Quantity Warning");
      $("#yourtuklaw").modal("show");
      $("#selmytype").focus();

      //     }else if(app > req ){
      // var myalert = "<div class='alert alert-danger'> <strong>Warning!</strong>  Approved Quantity should not be greater than the requested Quantity!</div>";
      //       $("#tuklawmodal").html(myalert);
      //       $("#tuklawtitle").html("Approved Quantity Warning");
      //       $("#yourtuklaw").modal("show");
      // } else if(ne <  le ){
      //    var myalert = "<div class='alert alert-danger'> <strong>Warning!</strong>Approved Quantity is greater than the requested Quantity!</div>";
      //   $("#tuklawmodal").html(myalert);
      //   $("#tuklawtitle").html("Approved Quantity Warning");
      //   $("#yourtuklaw").modal("show");
      //   }else if(      avls < ne   ){
      // $("#tuklawmodal").html(myalert);
      //  alert(ne);
      //      var myalert = "<div class='alert alert-danger'> <strong>Warning!</strong> Insufficient Stocks!</div>";
      //     $("#tuklawmodal").html(myalert);
      //     $("#tuklawtitle").html("Approved Quantity Warning");
      //     $("#yourtuklaw").modal("show");



    } else {
      $.ajax({
        url: 'saveissuance.php',
        type: 'get',
        data: {
          myid: arr[0],
          txtapproveqty: $(txtapproveqty).val(),
          app: app,
          req: req,
          ris: arr[1], tagabato: $(tagabato).val()
        },
        success: function (data) {
          // alert(data);
          // $("#myalert").html(data);
          if (data == "2") {

            var myalert = "<div class='alert alert-danger'> <strong>Warning!</strong>  Approved Quantity should not be greater than the requested Quantity!</div>";
            $("#tuklawmodal").html(myalert);
            $("#tuklawtitle").html("Approved Quantity Warning");
            $("#yourtuklaw").modal("show");
          } else if (data == "3") {

          } else if (data == "1") {

            $("#btnshowtrans").trigger("click");

            $.ajax({
              url: 'inventoryissuance.php',
              cache: false,
              type: 'get',
              success: function (data1) {
                $("#receivingbox").html(data1);
              }
            })

            var myalert = "<div class='alert alert-success'> Invertory successfully issued!</div>";

            $("#tuklawmodal").html(myalert);
            $("#tuklawtitle").html("Success");
            $("#yourtuklaw").modal("show");
            var tbl = "#tbl" + code;
            // $(tbl).html(data);



          } else {
            var myalert = "<div class='alert alert-success'>  Inventory Item Successfully released!</div>";

            $("#tuklawmodal").html(myalert);
            $("#tuklawtitle").html("Success");
            $("#yourtuklaw").modal("show");
            var tbl = "#tbl" + code;
            $(tbl).html(data);


          }
        }
      })
    }

  })

  var mahalid = 0;
  $(document).on("click", ".btneditccc", function (e) {
    e.preventDefault();

    var mydata = $(this).attr("id");
    var arr = mydata.split("|");

    $("#txtartivle").val(arr[2]);
    $("#txtyearoflife").val(arr[4]);
    $("#mnuunits").val(arr[3]);
    btntag = 1;
    mahalid = arr[0];
    var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Update</span>';
    $("#btnmaterialssave").html(bntval);
  })

  $(document).on("click", "#btnrefreshmat", function (e) {
    e.preventDefault();
    $("#mnutitle").trigger("change");
    var msg = '<div class="alert alert-info" >' + '<strong>Information!</strong> Please fill-up the form correctly!  .</div>';
    $("#myalert").html(msg);
  })


  $(document).on("click", "#btnsearchppe", function (e) {
    e.preventDefault();



    if (myshow == 2) {
      $.ajax({
        url: "searchitemlistppe.php",
        type: "get",
        data: { mnuasset: 2, txtsearchppe: $("#txtsearchppe").val() },
        cache: false,
        success: function (data) {
          $("#listofmats").html(data);
        }
      });

    } else if (myshow == 3) {
      $.ajax({
        url: "searchitemlistppe.php",
        type: "get",
        data: { mnuasset: 3, txtsearchppe: $("#txtsearchppe").val() },
        cache: false,
        success: function (data) {
          $("#listofmats").html(data);
        }
      });
    }
  })

  $(document).on("click", "#txtsimeitem", function (e) {
    e.preventDefault();

    if (myshow == 2) {
      $.ajax({
        url: "listofsime.php",
        type: "get",
        data: { mnuasset: 2 },
        cache: false,
        success: function (data) {
          $("#richielistmodal").html(data);
        }
      });

    } else if (myshow == 3) {
      $.ajax({
        url: "listofptritem.php",
        type: "get",
        data: { mnuasset: 3 },
        cache: false,
        success: function (data) {
          $("#richielistmodal").html(data);
        }
      });
    }
    $("#myModallist").modal("show");
  })


  $(document).on("click", "#txtproperty", function (e) {
    e.preventDefault();

    $.ajax({
      url: "listofppe.php",
      type: "get",
      data: { mnuasset: 3 },
      cache: false,
      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });

    $("#myModallist").modal("show");
  })
  var tagreciever = 0;
  $(document).on("click", "#txtreceived", function (e) {
    e.preventDefault();

    $.ajax({
      url: "listofreceivedby.php",
      type: "get",
      data: { mnuasset: 3 },
      cache: false,
      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });
    tagreciever = 1;
    $("#myModallist").modal("show");
  })

  var propertyid = 0
  $(document).on("click", ".itemrowppe", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    propertyid = arr[0];
    $("#txtproperty").val(arr[1]);
    $("#txtsemidesc").val(arr[3]);
    $("#myModallist").modal("hide");
  })

  $(document).on("click", ".itemrowppesemi", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    propertyid = arr[0];
    $("#txtsimeitem").val(arr[1]);
    $("#txtsemidesc").val(arr[3]);
    $("#myModallist").modal("hide");
  })

  var myreceiver = 0;
  var issued = 0;
  $(document).on("click", ".itemlistiof", function (e) {
    e.preventDefault();
    $("#myModallist").modal("hide");

    var mydata = $(this).attr("id");
    arr = mydata.split("|");
    // alert(arr[0]);
    $("#txtrecidforis").val(arr[0]);
    if (tagreciever == 1) {

      myreceiver = arr[0];
      $("#txtreceived").val(arr[2]);
      $("#txtposition").val(arr[3]);
    } else if (tagreciever == 2) {
      issued = arr[0];
      $("#txtissued").val(arr[2]);
      $("#txtissuedposition").val(arr[3]);
    }
  })

  $(document).on("click", "#btntempppeissuance", function (e) {
    e.preventDefault();
    if ($("#txtproperty").val() == "") {
      var msgtag = '<div class="alert alert-danger">Property Number is required!</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");


    } else if ($("#txtreceived").val() == "") {
      var msgtag = '<div class="alert alert-danger">Receiver is required!</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");

    } else if ($("#dtpissued").val() == "mm/dd/yyyy") {
      var msgtag = '<div class="alert alert-danger">Date is required!</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else {
      $.ajax({
        url: 'savetemppar.php',
        type: 'get',
        data: {
          txtproperty: $("#txtproperty").val(),
          propertyid: propertyid, txtrecidforis: $("#txtrecidforis").val(),
          dtpissued: $("#dtpissued").val()
        },
        dataType: 'JSON',
        success: function (response) {
          var len = response.length;
          var msg = response[0].msg;
          for (var i = 0; i < len; i++) {
            var msg = response[i].msg;
            var tag = response[i].tag;

            if (tag == 2) {
              var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';
              $("#myalert").html(msgtag);
              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Success");
              $("#yourtuklaw").modal("show");
            } else {
              var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';
              $("#myalert").html(msgtag);
              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Warning");
              $("#yourtuklaw").modal("show");

            }
          }
          ppetempdetails();
          $("#txtproperty").val("");
          $("#txtsemidesc").val("");
        }
      })
    }
  })

  $(document).on("click", "#btnsaveppeissuance", function (e) {
    e.preventDefault();

    var rowcount = $("#tblrichie tr").length;
    if (rowcount < 2) {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong>Property and Edquipment to issue is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("PSMIS Message");
      $("#yourtuklaw").modal("show");
      // }else if ($("#txtreceived").val() == ""){
      //      var msgtag =  '<div class="alert alert-danger">' + '<strong>Warning!</strong>Receiver name is Required!</div>'; 

      //                         $("#tuklawmodal").html(msgtag);
      //                         $("#tuklawtitle").html("PSMIS Message");
      //                         $("#yourtuklaw").modal("show");
      // }else if($("#dtpissued").val() == ""){
      //   var msgtag =  '<div class="alert alert-danger">' + '<strong>Warning!</strong>Date Issuance is Required!</div>'; 

      //                         $("#tuklawmodal").html(msgtag);
      //                         $("#tuklawtitle").html("PSMIS Message");
      //                         $("#yourtuklaw").modal("show");
    } else {
      $.ajax({
        url: 'savepar.php',
        type: 'get',
        data: {
          myreceiver: myreceiver,
          dtpissued: $("#dtpissued").val()
        },

        success: function (response) {
          var len = response.length;
          var msg = response[0].msg;
          for (var i = 0; i < len; i++) {
            var msg = response[i].msg;
            var tag = response[i].tag;

            if (tag == 1) {
              var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';

              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Success");
              $("#yourtuklaw").modal("show");
            }
          }

          // $("#tuklawmodal").html(response);
          //     $("#tuklawtitle").html("Success");
          //     $("#yourtuklaw").modal("show");

          $("#txtproperty").val("");
          $("#txtsemidesc").val("");
          ppetempdetails();

        }

      })
    }



  })

  function ppetempdetails() {
    $.ajax({
      url: 'ppetempdetails.php',
      type: 'get',
      cache: false,
      success: function (data) {
        $("#rcdetails").html(data);
      }
    })
  }
  $(document).on("click", "#newppetab", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'newppetab.php',
      type: 'get',
      cache: false,
      success: function (data) {
        $("#tabppe").html(data);
      }
    })
  })

  $(document).on("click", "#newsemitab", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'newsemitab.php',
      type: 'get',
      cache: false,
      success: function (data) {
        $("#tabsemi").html(data);
      }
    })

  })

  $(document).on("click", "#btntempsemireceive", function (e) {
    e.preventDefault();
    // editbtnid
    $(this).prop('disabled', true);

    if ($("#txtarticle").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Item Name is Required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Success");
      $("#yourtuklaw").modal("show");
      //  }else if($("#txtddate").val() < $("#txtpodate").val()){
      // var msgtag =  '<div class="alert alert-danger">' + '<strong>Warning!</strong> PO should not be ahead of the Delivery Date!</div>'; 

      //                          $("#tuklawmodal").html(msgtag);
      //                          $("#tuklawtitle").html("Success");
      //                          $("#yourtuklaw").modal("show");
    } else if ($("#txtamount").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Amount is Required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Success");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtamount").val() >= 50000) {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Amount must be less than 50000 only!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Success");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtdesc").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Description is Required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Success");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtserial").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Serial Number is Required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Success");
      $("#yourtuklaw").modal("show");
    } else if ($("#dtpdateaquired").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Date of acquisition is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Success");
      $("#yourtuklaw").modal("show");
    } else {

      $.ajax({
        url: 'btntempsemireceive.php',
        type: 'get',
        cache: false,
        dataType: 'JSON',
        data: {
          editbtnid: editbtnid,
          txtddate: $("#txtddate").val(),
          txtpodate: $("#txtpodate").val(),
          txtdesc: $("#txtdesc").val(),
          txtserial: $("#txtserial").val(),
          txtamount: $("#txtamount").val(),
          dtpdateaquired: $("#dtpdateaquired").val()
        },
        success: function (response) {
          var len = response.length;
          var msg = response[0].msg;
          for (var i = 0; i < len; i++) {
            var msg = response[i].msg;
            var tag = response[i].tag;

            if (tag == 1) {
              var msgtag = '<div class="alert alert-danger">' + '<strong>Warning! </strong> ' + msg + ' .</div>';

              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Warning");
              $("#yourtuklaw").modal("show");
            } else if (tag == 2) {
              var msgtag = '<div class="alert alert-success">' + '<strong>Success! </strong> ' + msg + ' .</div>';

              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Success");
              $("#yourtuklaw").modal("show");
 
              $("#txtdesc").val("");
              $("#txtserial").val("");
              $("#txtamount").val("");
              $("#dtpdateaquired").val("");
              $("#txtaccount").val("");
              $("#txtarticle").val("");
              $("#txtestimated").val("");
              tempsimereceive();
            }
          }


        }
      })

    }
    $(this).prop('disabled', false);
  })

  $(document).on("click", "#btnsavesemireceive", function (e) {
    e.preventDefault();
    var rowcount = $("#tblrichie tr").length;
    // supplierid
    // fundid
    if (rowcount < 2) {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Sorry No Item to Receive!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtsupplier").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Supplier Name is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtddate").val() < $("#txtpodate").val()) {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> P.O. date is not later than delivery date.</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtddate").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Delivery Date is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtPO").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> P.O. Number is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtpodate").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> P.O. Date is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtreceiptn").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Delivery Reciept Number is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtsource").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Source of fund is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtreceiptn").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Delivery Reciept Number is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else {

      $.ajax({
        url: "listofsemippe.php",
        data: {
          txtsupplier: $("#txtsupplier").val(),
          txtsource: $("#txtsource").val(),
          txtPO: $("#txtPO").val(),
          txtddate: $("#txtddate").val(),
          txtpodate: $("#txtpodate").val(),
          txtreceiptni: $("#txtreceiptn").val()
        },
        type: "get",
        cache: false,

        success: function (data) {
          $("#richielistmodal").html(data);
        }
      });

      $("#myModallist").modal("show");



    }

  })
  function tempsimereceive() {
    $.ajax({
      url: 'tempsemireceive.php',
      cash: false,
      success: function (data) {
        $("#rcdetails").html(data);
      }

    })
  }

  function tempppereceive() {
    $.ajax({
      url: 'tempppereceive.php',
      cash: false,
      success: function (data) {
        $("#rcdetails").html(data);
      }

    })
  }
  $(document).on("click", "#btnyesremovesemippe", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'btnyesremovesemippe.php',
      type: 'get',
      data: { btnid: $("#btnid").val() },
      success: function (data) {
        // tempsimereceive();
        // tempppereceive()
        loadmydetails();
        // tempppereceive();
        $("#myModalconfirm").modal("hide");
      }
    })
  })

  $(document).on("click", "#btnyestosavesemippe", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'savesemireciept.php',
      cache: false,
      type: 'get',
      dataType: 'JSON',
      data: {
        supplierid: supplierid,
        fundid: fundid,
        txtddate: $("#txtddate").val(),
        txtPO: $("#txtPO").val(),
        txtpodate: $("#txtpodate").val(),
        txtreceiptn: $("#txtreceiptn").val()
      },
      success: function (response) {
        var len = response.length;
        var msg = response[0].msg;
        for (var i = 0; i < len; i++) {
          var msg = response[i].msg;
          var tag = response[i].tag;

          if (tag == 1) {
            // var msgtag =  '<div class="alert alert-danger">' + ' ' + msg +' .</div>'; 

            //              $("#tuklawmodal").html(msgtag);
            //              $("#tuklawtitle").html("Success");
            //              $("#yourtuklaw").modal("show");
            tempsimereceive();
            $("#txtsupplier").val("");
            $("#txtddate").val("");
            $("#txtPO").val("");
            $("#txtpodate").val("");
            $("#txtreceiptn").val("");
            $("#txtsource").val("");
            $("#myModallist").modal("hide");
          }
        }

      }
    })
  })


  $(document).on("click", "#receivesemitab", function (e) {
    e.preventDefault();
    semippereceive();
  })
  function semippereceive() {
    $.ajax({
      url: 'semippereceive.php',
      cache: false,
      success: function (data) {
        $("#tabrichie").html(data);
      }
    })
  }
  function mysemippereceive() {
    $.ajax({
      url: 'mysemippereceive.php',
      cache: false,
      success: function (data) {
        $("#tabrichie").html(data);
      }
    })
  }
  $(document).on("click", "#receiveppetab", function (e) {
    e.preventDefault();
    mysemippereceive();
  })

  $(document).on("click", "#btntempsemiissuance", function (e) {
    e.preventDefault();

    if ($("#txtproperty").val() == "") {
      var msgtag = '<div class="alert alert-danger">Property Number is required!</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");


    } else if ($("#txtreceived").val() == "") {
      var msgtag = '<div class="alert alert-danger">Receiver is required!</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");

    } else if ($("#dtpissued").val() == "mm/dd/yyyy") {
      var msgtag = '<div class="alert alert-danger">Date is required!</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else {
      $.ajax({
        url: 'savetempics.php',
        type: 'get',
        data: {
          txtproperty: $("#txtsimeitem").val(),
          propertyid: propertyid
        },
        dataType: 'JSON',
        success: function (response) {
          var len = response.length;
          var msg = response[0].msg;
          for (var i = 0; i < len; i++) {
            var msg = response[i].msg;
            var tag = response[i].tag;

            if (tag == 2) {
              var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';

              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Success");
              $("#yourtuklaw").modal("show");
            } else {
              var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';

              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Warning");
              $("#yourtuklaw").modal("show");

            }
          }
          ppetempicsdetails();
        }
      })
    }
  })


  function ptrtempdetails() {
    $.ajax({
      url: 'ptrtempdetails.php',
      type: 'get',
      cache: false,
      data: { tag: myshow },
      success: function (data) {
        $("#rcdetails").html(data);
      }
    })
  }


  function ppetempicsdetails() {
    $.ajax({
      url: 'ppetempicsdetails.php',
      type: 'get',
      cache: false,
      success: function (data) {
        $("#rcdetails").html(data);
      }
    })
  }

  $(document).on("click", "#btnremsemippeyes", function (e) {
    e.preventDefault();
    var btnid = $("#btnid").val();

    $.ajax({
      url: 'btnremsemippeyes.php',
      type: 'get',
      data: { btnid: btnid },
      cache: false,
      success: function (data) {
        if (myshow == 2) {
          // ppetempdetails();
          ppetempicsdetails();
        } else if (myshow == 3) {
          // ppetempicsdetails();
          ppetempdetails();
        }
        // $("#errmsgconf1").html(data);
        $("#myModalconfirm").modal("hide");
      }
    })
  })

  $(document).on("click", "#btnsavesemiissuance", function (e) {
    e.preventDefault();

    var rowcount = $("#tblrichie tr").length;
    if ($("#txtreceived").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Receiver Name is Required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#dtpissued").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Date Issuance is Required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if (rowcount < 2) {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Sorry no item to issue!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else {


      $.ajax({
        url: "listofmypee.php",
        data: {
          txtsupplier: $("#txtsupplier").val(),
          txtsource: $("#txtsource").val(),
          txtPO: $("#txtPO").val(),
          txtddate: $("#txtddate").val(),
          txtpodate: $("#txtpodate").val(),
          txtreceiptni: $("#txtreceiptn").val()
        },
        type: "get",
        cache: false,

        success: function (data) {
          $("#richielistmodal").html(data);
        }
      });

      $("#myModallist").modal("show");

    }
  })


  $(document).on("click", "#btnyestosavemysemippe", function (e) {
    e.preventDefault();
    // myreceiver
    $.ajax({
      url: 'btnyestosavemysemippe.php',
      cache: false,
      type: 'get',

      data: {
        myreceiver: myreceiver,
        dtpissued: $("#dtpissued").val()
      },
      success: function (response) {
        var len = response.length;
        var msg = response[0].msg;
        for (var i = 0; i < len; i++) {
          var msg = response[i].msg;
          var tag = response[i].tag;

          if (tag == 1) {
            var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';

            $("#tuklawmodal").html(msgtag);
            $("#tuklawtitle").html("Success");
            $("#yourtuklaw").modal("show");
          }
        }
        $("#myModallist").modal("hide");
        ppetempicsdetails();


        // $("#tuklawmodal").html(response);
        //                     $("#tuklawtitle").html("Success");
        //                     $("#yourtuklaw").modal("show");
      }

    })

  })



  $(document).on("click", "#btntempppereceive", function (e) {
    e.preventDefault();
    // editbtnid



    if ($("#txtarticle").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Item Name is Required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Success");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtamount").val() < 1) {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Amount is Required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Success");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtamount").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Amount is Required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Success");
      $("#yourtuklaw").modal("show");

    } else if (($("#txtaccount").val() == "Motor Vehicle") && ($("#txtchasis").val() == "")) {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Please add the chassis number!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Success");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtdesc").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Please add the description!</div>';
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Success");
      $("#yourtuklaw").modal("show");


    } else if ($("#txtengine").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Please add the  serial number!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Success");
      $("#yourtuklaw").modal("show");
    } else if ($("#dtpdateaquired").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Please add the  acquisition date!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Success");
      $("#yourtuklaw").modal("show");
    } else {

      if (($("#txtarticle").val().trim() != "Land")) {
        if ($("#txtamount").val() < 50000) {
          var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Cost did not meet the capitalization treshhold!</div>';

          $("#tuklawmodal").html(msgtag);
          $("#tuklawtitle").html("Success");
          $("#yourtuklaw").modal("show");

        } else {
          $.ajax({
            url: 'saveko.php',
            type: 'get',
            cache: false,
            dataType: 'JSON',
            data: {
              editbtnid: editbtnid,
              txtdesc: $("#txtdesc").val(),
              txtserial: $("#txtengine").val(),
              txtamount: $("#txtamount").val(),
              txtchasis: $("#txtchasis").val(),
              dtpdateaquired: $("#dtpdateaquired").val()
            },
            success: function (response) {
              var len = response.length;
              var msg = response[0].msg;
              for (var i = 0; i < len; i++) {
                var msg = response[i].msg;
                var tag = response[i].tag;

                if (tag == 1) {
                  var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';

                  $("#tuklawmodal").html(msgtag);
                  $("#tuklawtitle").html("Warning");
                  $("#yourtuklaw").modal("show");
                } else if (tag == 2) {
                  var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';

                  $("#tuklawmodal").html(msgtag);
                  $("#tuklawtitle").html("Success");
                  $("#yourtuklaw").modal("show");

                  $("#txtdesc").val("");
                  $("#txtengine").val("");
                  $("#txtamount").val("");
                  $("#dtpdateaquired").val("");
                  $("#txtaccount").val("");
                  $("#txtarticle").val("");
                  $("#txtestimated").val("");
                  $("#txtchasis").val("");
                }
              }

              tempppereceive();

            }
          })

        }

      } else {
        $.ajax({
          url: 'saveko.php',
          type: 'get',
          cache: false,
          dataType: 'JSON',
          data: {
            editbtnid: editbtnid,
            txtdesc: $("#txtdesc").val(),
            txtserial: $("#txtengine").val(),
            txtamount: $("#txtamount").val(),
            txtchasis: $("#txtchasis").val(),
            dtpdateaquired: $("#dtpdateaquired").val()
          },
          success: function (response) {
            var len = response.length;
            var msg = response[0].msg;
            for (var i = 0; i < len; i++) {
              var msg = response[i].msg;
              var tag = response[i].tag;

              if (tag == 1) {
                var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';

                $("#tuklawmodal").html(msgtag);
                $("#tuklawtitle").html("Warning");
                $("#yourtuklaw").modal("show");
              } else if (tag == 2) {
                var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';

                $("#tuklawmodal").html(msgtag);
                $("#tuklawtitle").html("Success");
                $("#yourtuklaw").modal("show");

                $("#txtdesc").val("");
                $("#txtengine").val("");
                $("#txtamount").val("");
                $("#dtpdateaquired").val("");
                $("#txtaccount").val("");
                $("#txtarticle").val("");
                $("#txtestimated").val("");
                $("#txtchasis").val("");
              }
            }

            tempppereceive();

          }
        })


      }


    }
  })



  $(document).on("click", "#btnsaveppereceive", function (e) {
    e.preventDefault();
    var rowcount = $("#tblrichie tr").length;
    // supplierid
    // fundid
    if (rowcount < 2) {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Sorry No Item to Receive!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtsupplier").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Supplier Name is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtddate").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Delivery Date is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtPO").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> P.O. Number is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
      // }else if($("#txtpodate").val() > $("#txtddate").val()){
      //             var msgtag =  '<div class="alert alert-danger">' + '<strong>Warning!</strong> P.O. date is not later than delivery date.</div>'; 
      //                   $("#tuklawmodal").html(msgtag);
      //                       $("#tuklawtitle").html("Warning");
      //                       $("#yourtuklaw").modal("show");   
    } else if ($("#txtpodate").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> P.O. Date is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtreceiptn").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Delivery Reciept Number is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtsource").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Source of fund is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtreceiptn").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Delivery Reciept Number is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else {

      $.ajax({
        url: "mylistofsemippe.php",
        data: {
          txtsupplier: $("#txtsupplier").val(),
          txtsource: $("#txtsource").val(),
          txtpodate: $("#txtpodate").val(),
          txtddate: $("#txtddate").val(),
          txtPO: $("#txtPO").val(),
          txtddate: $("#txtddate").val(),
          txtpodate: $("#txtpodate").val(),
          txtreceiptni: $("#txtreceiptn").val()
        },
        type: "get",
        cache: false,

        success: function (data) {
          if (data == 1) {
            var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> P.O. date is not later than delivery date.</div>';
            $("#tuklawmodal").html(msgtag);
            $("#tuklawtitle").html("Warning");
            $("#yourtuklaw").modal("show");
          } else {
            $("#richielistmodal").html(data);
            $("#myModallist").modal("show");
          }

        }
      });





    }

  })



  $(document).on("click", "#btnyestoppe", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'btnyestoppe.php',
      cache: false,
      type: 'get',
      dataType: 'JSON',
      data: {
        supplierid: supplierid,
        fundid: fundid,
        txtddate: $("#txtddate").val(),
        txtPO: $("#txtPO").val(),
        txtpodate: $("#txtpodate").val(),
        txtreceiptn: $("#txtreceiptn").val()
      },
      success: function (response) {
        var len = response.length;
        var msg = response[0].msg;
        for (var i = 0; i < len; i++) {
          var msg = response[i].msg;
          var tag = response[i].tag;

          if (tag == 1) {
            // var msgtag =  '<div class="alert alert-danger">' + ' ' + msg +' .</div>'; 


            $("#txtsupplier").val("");
            $("#txtddate").val("");
            $("#txtPO").val("");
            $("#txtpodate").val("");
            $("#txtreceiptn").val("");
            $("#txtsource").val("");
            $("#myModallist").modal("hide");
            // tempsimereceive();
            tempppereceive();
          }
        }
        // $("#tuklawmodal").html(response);
        //          $("#tuklawtitle").html("Success");
        //          $("#yourtuklaw").modal("show");
        //          tempsimereceive();

      }


    })
  })
  $(document).on("click", "#txttransferedto", function (e) {


    $.ajax({
      url: "listofresponsibilitycenter.php",
      type: "get",
      cache: false,
      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });

    $("#myModallist").modal("show");
  })
  var resid = 0;
  $(document).on("click", ".itemlistiofrespon", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    resid = arr[0];
    $("#txttransferedto").val(arr[3]);
    $("#myModallist").modal("hide");
  })
  $(document).on("change", "#seltypeoftransfer", function (e) {
    e.preventDefault();
    if ($(this).val() == "OTHERS") {
      $("#txtothers").removeClass("richiehide");
    } else {
      $("#txtothers").addClass("richiehide");
    }
  })


  $(document).on("click", "#btntempptr", function (e) {
    e.preventDefault();
    if ($("#txtsimeitem").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong>Semi Expandible item to add is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#seltypeoftransfer").val() == "Select Option") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong>Transfer type is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if (($("#seltypeoftransfer").val() == "OTHERS") && ($("#txtothers").val() == "")) {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong>Please Specify if Others!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");

    } else if ($("#txttransferedto").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong>Responsibility Center to Transfer is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#selcondition").val() == "Select Option") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong>Property condition is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#dtpissued").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong>Date Transfer is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtreason").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong>Reason for Transfer is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else {


      $.ajax({
        url: 'btntempptr.php',
        type: 'get',
        cache: false,
        dataType: 'JSON',
        data: {
          propertyid: propertyid,
          txtsimeitem: $("#txtsimeitem").val(),
          selcondition: $("#selcondition").val(),
          txtreason: $("#txtreason").val(),
          tag: myshow
        },
        success: function (response) {
          var len = response.length;
          var msg = response[0].msg;
          for (var i = 0; i < len; i++) {
            var msg = response[i].msg;
            var tag = response[i].tag;

            if (tag == 1) {
              var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';

              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Warning");
              $("#yourtuklaw").modal("show");
            } else if (tag == 2) {
              var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';

              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Success");
              $("#yourtuklaw").modal("show");
              ptrtempdetails();
              $("#txtsimeitem").val("");
              $("#selcondition").val("");
              $("#txtreason").val("");
              $("#txtsemidesc").val("");
            }
          }


        }
      })
    }
  })

  $(document).on("click", "#btnremoveptrtemp", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'btnremoveptrtemp.php',
      type: 'get',
      data: { btnid: $("#btnid").val() },
      success: function (data) {
        ptrtempdetails();
        $("#myModalconfirm").modal("hide");
      }
    })
  })

  $(document).on("click", "#btnsaveptr", function (e) {
    e.preventDefault();
    var rowcount = $("#tblrichie tr").length;
    if (rowcount < 2) {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong>Sorry No Item to Transfer!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");

    } else if ($("#seltypeoftransfer").val() == "Select Option") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong>Transfer type is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if (($("#seltypeoftransfer").val() == "OTHERS") && ($("#txtothers").val() == "")) {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong>Please Specify if Others!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");

    } else if ($("#txttransferedto").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong>Responsibility Center to Transfer is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");

    } else if ($("#dtpissued").val() == "") {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong>Date Transfer is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else {


      $.ajax({
        url: "btnsaveptr.php",
        data: {
          txtothers: $("#txtothers").val(),
          seltypeoftransfer: $("#seltypeoftransfer").val(),
          txttransferedto: $("#txttransferedto").val(),
          dtpissued: $("#dtpissued").val(),
          selmytype: $("#selmytype").val()
        },
        type: "get",
        cache: false,

        success: function (data) {
          $("#richielistmodal").html(data);
        }
      });
      $("#mdconfirm").html("Confirmation");
      $("#myModallist").modal("show");

    }
  })


  $(document).on("click", "#btnyessaveptr", function (e) {
    e.preventDefault();
    $.ajax({
      url: "btnyessaveptr.php",
      dataType: 'JSON',
      data: {
        txtothers: $("#txtothers").val(),
        seltypeoftransfer: $("#seltypeoftransfer").val(),
        resid: resid,
        txthiddenid: $("#txthiddenid").val(),
        dtpissued: $("#dtpissued").val(),
        tag: myshow
      },
      type: "get",
      cache: false,

      success: function (response) {

        ptrtempdetails();
        $("#myModallist").modal("hide");
        $("#txtothers").val("");
        $("#seltypeoftransfer").val("");
        $("#dtpissued").val("");
        $("#txttransferedto").val("");
      }
    });
  })



  $(document).on("click", "#tabptr", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'tabptr.php',
      type: 'get',
      data: { tag: myshow },
      cache: false,
      success: function (data) {
        $("#tabptrdetails").html(data);
      }
    })

  })
  var wid = 0;
  $(document).on("click", ".btnacceptreceived", function (e) {
    e.preventDefault();

    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    wid = arr[0];
    var data = '<div class="alert alert-info">Are you sure you want to receive ' + arr[1] + ", " + arr[2] + " from " + arr[4] + " for " + arr[3] + "?</div>" +
      '<div class="row">'
      + '<div class="col-xs-12">'
      + '<button class="btn btn-primary" id="btnyesacceptreceipt">Yes</button>'
      + '&nbsp;<button class="btn btn-danger" data-dismiss="modal">No</button>'
      + '</div></div>';
    $("#mdconfirm").html("Confirmation");
    $("#richielistmodal").html(data);
    $("#myModallist").modal("show");
  })

  $(document).on("click", "#btnyesacceptreceipt", function (e) {
    e.preventDefault();


    $.ajax({
      url: 'btnyesacceptreceipt.php',
      type: 'get',
      data: { wid: wid },
      success: function (data) {
        if ($("#mnuasset").val() == 2) {
          // alert("chie");
          $.ajax({
            url: 'semitransfer.php',
            cache: false,
            type: 'get',
            success: function (response) {
              $("#receivingbox").html(response);
              // alert(response);
            }
          })
        } else if ($("#mnuasset").val() == 3) {
          $.ajax({
            url: 'ppetransfer.php',
            cache: false,
            type: 'get',
            success: function (response) {
              $("#receivingbox").html(response);
            }
          })
        }
      }
    })
    $("#myModallist").modal("hide");

    // $("#btnshowreceive").trigger("click");
  })


  $(document).on("click", "#tabptrres", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'tabptrres.php',
      type: 'get',
      data: { tag: $("#myhiddentag").val() },
      cache: false,
      success: function (data) {
        $("#tabptrdetails").html(data);
      }
    })

  })



  $(document).on("click", ".btnprintreceive", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");

    $.ajax({
      url: 'btnprintreceive.php',
      type: 'get',
      data: {
        ptrcode: mydata,
        tag: $("#myhiddentag").val()
      },
      success: function (data) {
        $("#richiedetails").html(data);
        $("#anakproblema").addClass("asawaproblema");
        $("#anakproblema").removeClass("problema");

        window.print();
        $("#anakproblema").addClass("problema");
        $("#anakproblema").removeClass("asawaproblema");
      }
    })


  })

  $(document).on("click", ".itemset", function (e) {
    e.preventDefault();
    var savelog = $("#richiedetails").html();
    var mydata = $(this).attr("id");
    // alert($(this).attr("id"));
    $.ajax({
      url: 'btnprintinventory.php',
      type: 'get',
      data: { mydata: mydata },
      success: function (data) {
        $("#richiedetails").html(data);
        $("#anakproblema").addClass("asawaproblema");
        $("#anakproblema").removeClass("problema");

        window.print();
        $("#anakproblema").addClass("problema");
        $("#anakproblema").removeClass("asawaproblema");
        $("#richiedetails").html(savelog);
      }
    })
    $("#myModallist").modal("hide");
  })

  $(document).on("click", ".btnprintppedel", function (e) {
    e.preventDefault();
    var savelog = $("#richiedetails").html();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");

    $.ajax({
      url: 'btnprintsemippedel.php',
      type: 'get',
      data: { mydata: arr[1], tag: 3 },
      success: function (data) {
        $("#richiedetails").html(data);
        $("#anakproblema").addClass("asawaproblema");
        $("#anakproblema").removeClass("problema");

        window.print();
        $("#anakproblema").addClass("problema");
        $("#anakproblema").removeClass("asawaproblema");
        $("#richiedetails").html(savelog);
      }
    })
  })
  $(document).on("click", ".btnprintsemidel", function (e) {
    e.preventDefault();
    var savelog = $("#richiedetails").html();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");

    $.ajax({
      url: 'btnprintsemippedel.php',
      type: 'get',
      data: { mydata: arr[1], tag: 2 },
      success: function (data) {
        $("#richiedetails").html(data);
        $("#anakproblema").addClass("asawaproblema");
        $("#anakproblema").removeClass("problema");

        window.print();
        $("#anakproblema").addClass("problema");
        $("#anakproblema").removeClass("asawaproblema");

        $("#richiedetails").html(savelog);
      }
    })
  })

  $(document).on("click", "#newinvettab", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'inventorytab.php',
      type: 'get',
      cache: false,
      success: function (data) {
        $("#tabsemi").html(data);
      }
    })



  })


  // function loadinventorydetails(){
  //   // rcdetails

  //      var newid = $("#mnutitle").val();
  //     var arr = newid.split("|");
  //     instantid  =arr[0];
  //     yourtagid = arr[1];

  //     $.ajax({
  //       url:'loadmaterialsdetail.php',
  //       type:'get',
  //       cache:false,
  //       data:{btnid:instantid},
  //       success:function(data){
  //         $("#rcdetails").html(data);
  //       }

  //     })
  // }

  function lodmaterialsdetails() {

    // alert();
    var mydata = $("#mnutitle").val();
    var arr = mydata.split("|");
    // alert(mydata);
    $.ajax({
      url: 'materialsdetails.php',
      data: {
        btnid: arr[0]
        , tag: arr[1]
      },
      cache: false,
      success: function (data) {

        $("#rcdetails").html(data);
      }
    })
  }



  $(document).on("click", "#btnsearchmat", function (e) {
    e.preventDefault();

    var mydata = $("#mnutitle").val();
    var arr = mydata.split("|");
    $.ajax({
      url: 'btnsearchmat.php',
      data: {
        btnid: arr[0]
        , tag: arr[1]
        , txtsearchmat: $("#txtsearchmat").val()
      },
      cache: false,
      success: function (data) {

        $("#rcdetails").html(data);
      }
    })


  })


  $(document).on("click", "#btnsearchsuppliers", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'listofsups.php',
      cache: false,
      type: 'get',
      data: { txtsearchsupplier: $("#txtsearchsupplier").val() },
      success: function (data) {
        $("#listofsups").html(data);
      }
    })
  })

  $(document).on("click", "#btnsearchsup", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'listoffundssearch.php',
      type: 'get',
      cache: false,
      data: { txtsearchfund: $("#txtsearchfund").val() },
      success: function (data) {
        $("#listofmats").html(data);
      }
    })


  })

  $(document).on("click", "#btnsearchitems", function (e) {
    e.preventDefault();
    var mydata = $("#mnutitle").val();
    var arr = mydata.split('|');
    $.ajax({
      url: 'listofmyname.php',
      type: 'get',
      cache: false,
      data: { txtsearchmyname: $("#txtsearchmyname").val(), mnutitle: arr[0] },
      success: function (data) {
        $("#listofmyname").html(data);
      }

    })

  })

  $(document).on("click", ".btnprintris", function (e) {
    e.preventDefault();
    var savelog = $("#richiedetails").html();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");

    $.ajax({
      url: 'btnprintris.php',
      type: 'get',
      data: { mydata: arr[1] },
      success: function (data) {
        $("#richiedetails").html(data);
        $("#anakproblema").addClass("asawaproblema");
        $("#anakproblema").removeClass("problema");
        window.print();
        $("#anakproblema").addClass("problema");
        $("#anakproblema").removeClass("asawaproblema");
        $("#richiedetails").html(savelog);


        $.ajax({
          url: 'inventorytab.php',
          type: 'get',
          cache: false,
          success: function (data) {
            $("#tabsemi").html(data);
          }
        })

      }
    })
  })

  $(document).on("click", ".btnmyprint", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var savelog = $("#richiedetails").html();
    var arr = mydata.split("|");
    // alert(arr[1]);
    $.ajax({
      url: 'btnprintptr.php',
      type: 'get',
      data: { mydata: arr[1] },
      success: function (data) {
        $("#richiedetails").html(data);
        $("#anakproblema").addClass("asawaproblema");
        $("#anakproblema").removeClass("problema");

        window.print();
        $("#anakproblema").addClass("problema");
        $("#anakproblema").removeClass("asawaproblema");
        $("#richiedetails").html(savelog);
      }
    })


  })
  $(document).on("click", ".btnprintics", function (e) {
    e.preventDefault();
    var savelog = $("#richiedetails").html();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");

    $.ajax({
      url: 'btnprintics.php',
      type: 'get',
      data: { mydata: arr[1] },
      success: function (data) {
        $("#richiedetails").html(data);
        $("#anakproblema").addClass("asawaproblema");
        $("#anakproblema").removeClass("problema");

        window.print();
        $("#anakproblema").addClass("problema");
        $("#anakproblema").removeClass("asawaproblema");
        $("#richiedetails").html(savelog);
        $.ajax({
          url: 'newsemitab.php',
          type: 'get',
          cache: false,
          success: function (data) {
            $("#tabsemi").html(data);
          }
        })
      }
    })
  })

  function spawnFruit(data) {
    $("#richiedetails").html(data);
    $("#anakproblema").addClass("asawaproblema");
    $("#anakproblema").removeClass("problema");

    window.print();
    $("#anakproblema").addClass("problema");
    $("#anakproblema").removeClass("asawaproblema");

  }


  $(document).on("click", "#A0013", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Division Entry</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'A0013.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
        devisiondetails();
      }
    })

    btntag = 0;
  })
  function devisiondetails() {
    $.ajax({
      url: 'devisiondetails.php',
      data: { txtdivision: $("#txtdivision").val() },
      cache: false,
      success: function (data) {

        $("#rcdetails").html(data);
      }
    })
  }

  $(document).on("click", "#btnsavedivision", function (e) {
    e.preventDefault();
    if ($("#division").val() == "") {
      var msgtag = '<div class="alert alert-danger">' +
        '<strong>Warning! </strong> Division Name is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");

    } else {
      var stat = "";

      if (btntag == 0) {
        stat = "Save";
      } else {
        stat = "Update";
      }

      var myalert = "<div class='alert alert-info'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to " + stat + " <strong > " + $("#division").val() + "? </strong> .</div>"
      $("#errmsgconf1").html(myalert);
      var str = '   <form id="frmdelmenu">' +


        '<div class="row">' +
        ' <div class="col-xs-2">' +
        '<input type="submit" name="btnyesdivision" id="btnyesdivision" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
        '<div class="col-xs-2">' +
        '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat" data-dismiss="modal"></div>' +
        '</div>' +
        '</form>';

      $("#richiemodal").html(str);

      $("#myModalconfirm").modal("show");





    }
  })
  $(document).on("click", "#btnyesdivision", function (e) {
    e.preventDefault();

    if (btntag == 0) {
      $.ajax({
        url: 'savedivision.php',
        type: 'get',
        dataType: 'JSON',
        data: { division: $("#division").val() },
        success: function (response) {
          var len = response.length;
          var msg = response[0].msg;
          for (var i = 0; i < len; i++) {
            var msg = response[i].msg;
            var tag = response[i].tag;

            if (tag == 1) {
              var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';

              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Warning");
              $("#yourtuklaw").modal("show");
            } else if (tag == 2) {
              var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';

              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Success");
              $("#yourtuklaw").modal("show");
              $("#myModalconfirm").modal("hide");
              devisiondetails();
              $("#division").val("");


            }
          }
        }
      })
    } else if (btntag == 1) {
      $.ajax({
        url: 'editdivision.php',
        type: 'get',
        dataType: 'JSON',
        data: {
          mydivid: mydivid,
          division: $("#division").val()
        },
        success: function (response) {
          var len = response.length;
          var msg = response[0].msg;
          for (var i = 0; i < len; i++) {
            var msg = response[i].msg;
            var tag = response[i].tag;

            if (tag == 1) {
              var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';

              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Warning");
              $("#yourtuklaw").modal("show");
            } else if (tag == 2) {
              var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';

              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Success");
              $("#yourtuklaw").modal("show");
              $("#myModalconfirm").modal("hide");
              devisiondetails();
              $("#division").val("");


            }
          }
        }
      })
    }
    var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
    $("#btnsavedivision").html(bntval);
    btntag = 0;

  })
  var mydivid = 0;
  $(document).on("click", ".btndivedit", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    mydivid = arr[0];
    $("#division").val(arr[1]);
    btntag = 1;


    var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Update</span>';
    $("#btnsavedivision").html(bntval);
  })
  $(document).on("click", "#A0009", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Section Entry</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'A0009.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
        sectiondetails();
      }
    })

    btntag = 0;

  })

  $(document).on("click", "#btndivision", function (e) {
    e.preventDefault();
    devisiondetails();
  })
  function sectiondetails() {
    $.ajax({
      url: 'sectiondetails.php',

      cache: false,
      success: function (data) {

        $("#rcdetails").html(data);
      }
    })
  }
  $(document).on("click", "#btnsavesection", function (e) {
    e.preventDefault();
    if ($("#txtsectiondata").val() == "") {
      var msgtag = '<div class="alert alert-danger">' +
        ' Section name is required.</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");

    } else {
      var stat = "";

      if (btntag == 0) {
        stat = "Save";
      } else {
        stat = "Update";
      }

      var myalert = "<div class='alert alert-info'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to " + stat + " <strong > " + $("#txtsectiondata").val() + "? </strong> .</div>"
      $("#errmsgconf1").html(myalert);
      var str = '   <form id="frmdelmenu">' +


        '<div class="row">' +
        ' <div class="col-xs-2">' +
        '<input type="submit" name="btnyesection" id="btnyesection" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
        '<div class="col-xs-2">' +
        '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat" data-dismiss="modal"></div>' +
        '</div>' +
        '</form>';

      $("#richiemodal").html(str);

      $("#myModalconfirm").modal("show");





    }
  })
  $(document).on("click", "#btnyesection", function (e) {
    e.preventDefault();

    if (btntag == 0) {
      $.ajax({
        url: 'savesection.php',
        type: 'get',
        dataType: 'JSON',
        data: { txtsectiondata: $("#txtsectiondata").val() },
        success: function (response) {
          var len = response.length;
          var msg = response[0].msg;
          for (var i = 0; i < len; i++) {
            var msg = response[i].msg;
            var tag = response[i].tag;

            if (tag == 1) {
              var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';

              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Warning");
              $("#yourtuklaw").modal("show");
            } else if (tag == 2) {
              var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';

              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Success");
              $("#yourtuklaw").modal("show");
              $("#myModalconfirm").modal("hide");
              sectiondetails();
              $("#txtsectiondata").val("");


            }
          }
        }
      })
    } else if (btntag == 1) {
      $.ajax({
        url: 'editsection.php',
        type: 'get',
        dataType: 'JSON',
        data: {
          mydivid: mydivid,
          txtsectiondata: $("#txtsectiondata").val()
        },
        success: function (response) {
          var len = response.length;
          var msg = response[0].msg;
          for (var i = 0; i < len; i++) {
            var msg = response[i].msg;
            var tag = response[i].tag;

            if (tag == 1) {
              var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';

              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Warning");
              $("#yourtuklaw").modal("show");
            } else if (tag == 2) {
              var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';

              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Success");
              $("#yourtuklaw").modal("show");
              $("#myModalconfirm").modal("hide");
              sectiondetails();
              $("#txtsectiondata").val("");


            }
          }
        }
      })
    }
    var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
    $("#btnsavesection").html(bntval);
    btntag = 0;
  })

  $(document).on("click", ".btnsectionedit", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    mydivid = arr[0];
    $("#txtsectiondata").val(arr[1]);
    btntag = 1;


    var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Update</span>';
    $("#btnsavesection").html(bntval);
  })

  $(document).on("click", "#btnsectionsearch", function (e) {
    e.preventDefault();
    sectiondetails();
  })

  $(document).on("click", "#btndelsection", function (e) {
    e.preventDefault()
    $.ajax({
      url: 'btndelsection.php',
      type: 'get',
      data: { btnid: $("#btnid").val() },
      success: function (data) {
        sectiondetails();
        $("#myModalconfirm").modal("hide");
      }
    })
  })

  $(document).on("click", "#btnyesdeldivision", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'btnyesdeldivision.php',
      type: 'get',
      data: { btnid: $("#btnid").val() },
      success: function (data) {
        devisiondetails();
        $("#myModalconfirm").modal("hide");
      }
    })
  })

  $(document).on("click", "#R0002", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading"> REPORT OF SUPPLIES AND MATERIALS ISSUED  </div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'R0002.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
        rsmitabs();

      }
    })
  })

  function rsmitabs() {
    $.ajax({
      url: 'rsmitab.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#tsmli").html(data);


      }
    })
  }

  $(document).on("click", "#btnsaversmi", function (e) {



    var myalert = "<div class='alert alert-info'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to Submit the selected RIS NO.: <strong > ? </strong> .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +



      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnsyesrsmi" id="btnsyesrsmi" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat" data-dismiss="modal"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);

    $("#myModalconfirm").modal("show");

  })
  $(document).on("click", "#btnsyesrsmi", function (e) {
    e.preventDefault();
    var val = [];

    $('#ads_Checkboxes:checked').each(function (i) {
      val[i] = $(this).val();
    });


    $.ajax({
      url: 'btnsyesrsmi.php',
      type: 'get',
      cache: false,
      data: { val: val },
      success: function (data) {




        $('input[type=checkbox]').prop('checked', false);
      }
    })

  })
  $(document).on("click", "#btnremoveppeki", function (e) {
    e.preventDefault();
    // alert($("#btnid").val());
    $.ajax({
      url: 'removeequipment.php',
      type: 'get',
      data: { btnid: $("#btnid").val() },
      cache: false,
      success: function (data) {
        lodmaterialsdetails();
        $("#myModalconfirm").modal("hide");

      }
    })
  })
  $(document).on("change", "#mnuasset", function (e) {
    e.preventDefault();
    if ($(this).val() == 1) {
      var quarix = ' <select id="seltype" class="form-control">' +
        '<option value="Select">Select Option</option>' +
        '<option value="Receiving (Purchase)">Receiving (Purchase)</option>' +
        '</select>';
      $(".receivingoption").html(quarix);
    } else {
      var quarix = ' <select id="seltype" class="form-control">' +
        '<option value="Select">Select Option</option>' +
        '<option value="Receiving (Purchase)">Receiving (Purchase)</option>' +
        '<option value="Receiving (Transfer From)">Receiving (Transfer From)</option>' +
        '</select>  ';
      $(".receivingoption").html(quarix);
    }
    $("#btnshowreceive").trigger("click");
    $("#seltype").trigger("change");

    // console.log("you change me");
  })

  $(document).on("click", "#T008", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Credit Memorandum on Property Accountability</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'return.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
      }
    })
  })

  $(document).on("click", ".btnremovereturn", function (e) {
    e.preventDefault();
    var myid = $(this).attr("id");


    $.ajax({
      url: 'deleterReturn.php',
      cache: false,
      type: 'get',
      data: { myid: myid },
      success: function (data) {



        $.ajax({
          url: 'return.php',
          cache: false,
          type: 'get',
          success: function (data) {
            $("#frmmodalbody").html(data);


            var msgtag = '<div class="alert alert-success">' + ' Item successfully removed. </div>';

            $("#tuklawmodal").html(msgtag);
            $("#tuklawtitle").html("Success");
            $("#yourtuklaw").modal("show");
          }
        })
      }
    })
  })

  $(document).on("click", "#txtpropertyreturn", function (e) {
    e.preventDefault();
    if ($("#optsets").val() != 0) {
      $.ajax({
        url: "retlist.php",
        type: "get",
        data: { mnuasset: $("#optsets").val() },
        cache: false,
        success: function (data) {
          $("#richielistmodal").html(data);
        }

      });
      $("#myModallist").modal("show");
    }
  })

  $(document).on("click", "#btnsearchproperty", function (e) {
    e.preventDefault();
    $.ajax({
      url: "btnsearchproperty.php",
      type: "get",
      data: {
        mnuasset: $("#optsets").val(),
        txtsearchproperty: $("#txtsearchproperty").val()
      },
      cache: false,
      success: function (data) {
        $("#listofmats").html(data);
      }
    });
  })
  var dids = 0;
  var eid = 0;
  $(document).on("click", ".itemrowppechie", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    $("#txtpropertyreturn").val(arr[1]);
    var tddata = '<tr>' +
      '<td>' + arr[1] + '</td>' +
      '<td>' + arr[2] + '</td>' +
      '<td>' + arr[3] + '</td>' +
      '<td><label id="lblpar">' + arr[8] + '</label></td>' +
      '<td>' + arr[6] + '</td>' +
      '<td>' + arr[7] + '</td> <input type="hidden" value="' + arr[6] + '" id="acctperson">' +
      '</tr>';
    dids = arr[9];
    eid = arr[0];
    $("#myModallist").modal("hide");
    $("#returnlist").html(tddata);
    // alert(dids);
  })

  $(document).on("click", "#btnreturnadd", function (e) {
    e.preventDefault();
    var rowcount = $("#returnlist tr").length;
    $("#dtpdateret").removeClass('newwarning');
    $("#txtmyremarks").removeClass('newwarning');
    if (rowcount < 1) {
      $("#returnlist").addClass('newwarning');
      $("#returnlist").focus();
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Sorry No Item To Add! </div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#dtpdateret").val() == "") {
      $("#dtpdateret").addClass('newwarning');
      $("#dtpdateret").focus();
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Invalid date! </div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtmyremarks").val() == "") {
      $("#txtmyremarks").addClass('newwarning');
      $("#txtmyremarks").focus();
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Remarks is Required! </div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else {
      $.ajax({
        url: 'btnreturnadd.php',
        type: 'get',
        cache: false,
        data: {
          txtpropertyreturn: $("#txtpropertyreturn").val(),
          lblpar: $("#lblpar").html(),
          dtpdateret: $("#dtpdateret").val(),
          acctperson: $("#acctperson").val(),
          txtmyremarks: $("#txtmyremarks").val(),
          optsets: $("#optsets").val(),
          selcondition: $("#selcondition").val()
        },
        success: function (data) {
          treturn();
          $("#returnlist").html("");
        }
      })
    }
  })

  $(document).on("click", "#btnmanualtemp", function (e) {
    e.preventDefault();
    // $("#btnmanualtemp").prop('disabled', true);
    $("#txtorigin").removeClass('newwarning');
    $("#PTRNumber").removeClass('newwarning');
    $("#ptrdate").removeClass('newwarning');
    $("#txtsource").removeClass('newwarning');
    $("#dtpdateaquired").removeClass('newwarning');
    $("#txtaccount").removeClass('newwarning');
    $("#txtarticle").removeClass('newwarning');
    $("#txtamount").removeClass('newwarning');
    $("#txtpropertys").removeClass('newwarning');
    if ($("#txtorigin").val() == "") {
      $("#txtorigin").addClass('newwarning');
      $("#txtorigin").focus();
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Origin is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");

    } else if ($("#PTRNumber").val() == "") {
      $("#PTRNumber").addClass('newwarning');
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> PTR Number is required! </div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#ptrdate").val() == "") {
      $("#ptrdate").addClass('newwarning');
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> PTR date is required! </div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtsource").val() == "") {
      $("#txtsource").addClass('newwarning');
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Source of Fund is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtpropertys").val() == "") {
      $("#txtpropertys").addClass('newwarning');
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Property Number is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#dtpdateaquired").val() == "") {
      $("#dtpdateaquired").addClass('newwarning');
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Date acquired is required! </div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtaccount").val() == "") {
      $("#txtaccount").addClass('newwarning');
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Account Title is required! </div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtarticle").val() == "") {
      $("#txtarticle").addClass('newwarning');
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Article Name is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");

    } else if ($("#txtamount").val() == "") {
      $("#txtamount").addClass('newwarning');
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Amount is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtamount").val() < 50000) {
      $("#txtamount").addClass('newwarning');
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Amount must not be less than the capitalization treshold!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else {
      $.ajax({
        url: 'btnmanualtemp.php',
        type: 'get',
        cache: false,
        data: {
          editbtnid: editbtnid,
          fundid: fundid,
          txtamount: $("#txtamount").val(),
          txtdesc: $("#txtdesc").val(),
          txtengine: $("#txtengine").val(),
          txtchasis: $("#txtchasis").val(),
          txtpropertys: $("#txtpropertys").val(),
          dtpdateaquired: $("#dtpdateaquired").val()

        },
        success: function (response) {

          var msgtag = '<div class="alert alert-success">' + ' Property Plants and Edquipment Successfully Added!</div>';

          $("#tuklawmodal").html(msgtag);
          $("#tuklawtitle").html("Success");
          $("#yourtuklaw").modal("show");
          $("#btnmanualtemp").prop('disabled', true);
          $("#txtorigin").removeClass('newwarning');
          $("#PTRNumber").removeClass('newwarning');
          $("#ptrdate").removeClass('newwarning');
          $("#txtsource").removeClass('newwarning');
          $("#dtpdateaquired").removeClass('newwarning');
          $("#txtaccount").removeClass('newwarning');
          $("#txtarticle").removeClass('newwarning');
          $("#txtamount").removeClass('newwarning');



          $("#dtpdateaquired").val("");
          $("#txtaccount").val("");
          $("#txtarticle").val("");
          $("#txtamount").val("");
          loadmymanual();

        }
      })
    }
    // $("#btnmanualtemp").prop('disabled', false);
  })

  $(document).on("click", "#btnsaversmi2", function (e) {
    e.preventDefault();
    var val = [];
    var xxs = 0;
    $('#ad_Checkbox12:checked').each(function (i) {
      val[i] = $(this).val();
      xxs = xxs + 1;
    });
    if (xxs == 0) {
      var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> Please Select RIS to submit!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else {
      $.ajax({
        url: 'displayrsmi.php',
        type: 'get',
        data: { val: val },
        cache: false,
        success: function (response) {
          $("#richielistmodal").html(response);

        }
      })

      $("#myModallist").modal("show");
    }

  })

  $(document).on("click", "#rsmino", function (e) {
    e.preventDefault();
    $("#myModallist").modal("hide");
  })


  $(document).on("click", "#rsmiyes", function (e) {
    e.preventDefault();

    var val = [];
    var xxs = 0;
    $('#ad_Checkbox12:checked').each(function (i) {
      val[i] = $(this).val();
      xxs = xxs + 1;
    });
    $.ajax({
      url: 'saversmi.php',
      type: 'get',
      data: { val: val },
      cache: false,
      success: function (data) {
        var msgtag = '<div class="alert alert-success">' + ' Successfully submitted!</div>';

        $("#tuklawmodal").html(msgtag);
        $("#tuklawtitle").html("Success");
        $("#yourtuklaw").modal("show");
        $("#R0002").trigger("click");

        var strform = ' <div class="panel panel-primary">' +
          '<div class="panel-heading"> REPORT OF SUPPLIES AND MATERIALS ISSUED  </div>' +
          '<div class="panel-body" id="frmmodalbody">' +
          ' <div id="mnudetails"></div> </div> </div></div>';

        $("#richiedetails").html(strform);


        $.ajax({
          url: 'R0002.php',
          cache: false,
          type: 'get',
          success: function (data1) {
            $("#frmmodalbody").html(data1);
            rsmitabs();

          }
        })

      }
    })
    $("#myModallist").modal("hide");
    rsmitabs();
  })

  $(document).on("click", "#tabnewrsmi", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'rsmisubmited.php',
      type: 'get',
      cache: false,
      success: function (response) {
        $("#mynewrsmi").html(response);
      }
    })
  })

  $(document).on("click", "#btnremovenewmanual", function (e) {
    e.preventDefault();
    // alert($("#btnid").val());
    $.ajax({
      url: 'btnremovenewmanual.php',
      type: 'get',
      data: { btnid: $("#btnid").val() },
      cache: false,
      success: function (data) {
        loadmymanual();
        $("#myModalconfirm").modal("hide");

      }
    })
  })
  $(document).on("click", "#btnsavemanualppe", function (e) {
    e.preventDefault();
    $("#txtorigin").removeClass("newwarning");
    $("#PTRNumber").removeClass("newwarning");
    $("#ptrdate").removeClass("newwarning");
    var rowcount = $("#tblrichie tr").length;
    if (rowcount < 1) {
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> Select Item to Received!</div>';
      $("#txtorigin").addClass("newwarning");
      $("#txtorigin").focus();
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");

    } else if ($("#txtorigin").val() == "") {
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> Origin is required!</div>';
      $("#txtorigin").addClass("newwarning");
      $("#txtorigin").focus();
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#PTRNumber").val() == "") {
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> PTR Number is required!</div>';
      $("#PTRNumber").addClass("newwarning");
      $("#PTRNumber").focus();
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#ptrdate").val() == "") {
      $("#ptrdate").addClass("newwarning");
      $("#ptrdate").focus();
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> PTR Date is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else {

      $.ajax({
        url: 'listoffortransppe.php',
        type: 'get',
        cache: false,
        data: {
          txtorigin: $("#txtorigin").val(),
          PTRNumber: $("#PTRNumber").val(),
          ptrdate: $("#ptrdate").val()
        },
        success: function (data) {
          $("#richielistmodal").html(data);
          $("#myModallist").modal("show");
        }
      })
    }
  })
  $(document).on("click", "#btnyesppemanual", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'btnyesppemanual.php',
      type: 'get',
      cache: false,
      data: {
        txtorigin: $("#txtorigin").val(),
        PTRNumber: $("#PTRNumber").val(),
        ptrdate: $("#ptrdate").val()
      },
      success: function (data) {
        var msgtag = '<div class="alert alert-success">' + '<strong>Success! </strong> Transfer Successfully Received!</div>';

        $("#tuklawmodal").html(msgtag);
        $("#tuklawtitle").html("Success");
        $("#yourtuklaw").modal("show");
        loadmymanual();

        $("#txtorigin").val("");
        $("#PTRNumber").val("");
        $("#ptrdate").val("");
        $("#txtsource").val("");
        $("#dtpdateaquired").val("");
        $("#txtaccount").val("");
        $("#txtarticle").val("");
        $("#txtamount").val("");
        $("#txtorigin").val("");
        $("#PTRNumber").val("");
        $("#ptrdate").val("");
        $("#myModallist").modal("hide");
      }
    })
  })

  function loadmanualsemi() {
    $.ajax({
      url: 'loadmanualsemi.php',
      type: 'get',
      cache: false,
      success: function (data) {
        $("#rcdetails").html(data);
      }
    })
  }

  $(document).on("click", "#btntempsemireceivemanual", function (e) {
    e.preventDefault();
    $("#txtorigin").removeClass('newwarning');
    $("#PTRNumber").removeClass('newwarning');
    $("#ptrdate").removeClass('newwarning');
    $("#txtsource").removeClass('newwarning');
    $("#dtpdateaquired").removeClass('newwarning');
    $("#txtaccount").removeClass('newwarning');
    $("#txtarticle").removeClass('newwarning');
    $("#txtestimated").removeClass('newwarning');
    $("#txtamount").removeClass('newwarning');
    $("#txtdesc").removeClass('newwarning');
    $("#txtserial").removeClass('newwarning');
    $("#txtpropertys").removeClass("newwarning");
    if ($("#txtorigin").val() == "") {
      $("#txtorigin").addClass('newwarning');
      $("#txtorigin").focus();
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> Origin is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#PTRNumber").val() == "") {
      $("#PTRNumber").addClass('newwarning');
      $("#PTRNumber").focus();
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> PTR Number is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#ptrdate").val() == "") {
      $("#ptrdate").addClass('newwarning');
      $("#ptrdate").focus();
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> PTR Date is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtpropertys").val() == "") {
      $("#txtpropertys").addClass('newwarning');
      $("#txtpropertys").focus();
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> Property Number is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");

    } else if ($("#txtsource").val() == "") {
      $("#txtsource").addClass('newwarning');
      $("#txtsource").focus();
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> Source of Fund is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#dtpdateaquired").val() == "") {
      $("#dtpdateaquired").addClass('newwarning');
      $("#dtpdateaquired").focus();
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> Date Acquired is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtaccount").val() == "") {
      $("#txtaccount").addClass('newwarning');
      $("#txtaccount").focus();
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> Account Title is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtarticle").val() == "") {
      $("#txtarticle").addClass('newwarning');
      $("#txtarticle").focus();
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> Article name is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");

    } else if ($("#txtamount").val() == "") {
      $("#txtamount").addClass('newwarning');
      $("#txtamount").focus();
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> Amount is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtdesc").val() == "") {
      $("#txtdesc").addClass('newwarning');
      $("#txtdesc").focus();
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> Description is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtserial").val() == "") {
      $("#txtserial").addClass('newwarning');
      $("#txtserial").focus();
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> Serial number is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");


    } else {
      $.ajax({
        url: 'btntempsemireceivemanual.php',
        type: 'get',
        cache: false,
        data: {
          editbtnid: editbtnid,
          fundid: fundid,
          txtpropertys: $("#txtpropertys").val(),
          dtpdateaquired: $("#dtpdateaquired").val(),
          txtamount: $("#txtamount").val(),
          txtdesc: $("#txtdesc").val(),
          txtserial: $("#txtserial").val(),

        },
        success: function (data) {
          if (data == 1) {
            var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> Amount not greater than capitalization treshold!</div>';

            $("#tuklawmodal").html(msgtag);
            $("#tuklawtitle").html("Warning");
            $("#yourtuklaw").modal("show");
            $("#txtamount").addClass('newwarning');
            $("#txtamount").focus();
          } else {
            var msgtag = '<div class="alert alert-success">' + '<strong>Success! </strong> Item Successfully Added!</div>';

            $("#tuklawmodal").html(msgtag);
            $("#tuklawtitle").html("Success");
            $("#yourtuklaw").modal("show");
            loadmanualsemi();
            $("#txtsource").val("");
            $("#dtpdateaquired").val("");
            $("#txtaccount").val("");
            $("#txtarticle").val("");
            $("#txtamount").val("");
            $("#txtdesc").val("");
            $("#txtserial").val("");
          }


        }
      })


    }
  })

  $(document).on("click", "#btnremovenewmanualsemi", function (e) {
    e.preventDefault();
    // alert($("#btnid").val());
    $.ajax({
      url: 'btnremovenewmanual.php',
      type: 'get',
      data: { btnid: $("#btnid").val() },
      cache: false,
      success: function (data) {
        loadmanualsemi();
        $("#myModalconfirm").modal("hide");

      }
    })
  })
  $(document).on("click", "#btnsavesemireceivemanual", function (e) {
    e.preventDefault();
    $("#txtorigin").removeClass("newwarning");
    $("#PTRNumber").removeClass("newwarning");
    $("#ptrdate").removeClass("newwarning");

    var rowcount = $("#tblrichie tr").length;
    if (rowcount < 1) {
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> Select Item to Received!</div>';
      $("#txtorigin").addClass("newwarning");
      $("#txtorigin").focus();
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");

    } else if ($("#txtorigin").val() == "") {
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> Origin is required!</div>';
      $("#txtorigin").addClass("newwarning");
      $("#txtorigin").focus();
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#PTRNumber").val() == "") {
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> PTR Number is required!</div>';
      $("#PTRNumber").addClass("newwarning");
      $("#PTRNumber").focus();
      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#ptrdate").val() == "") {
      $("#ptrdate").addClass("newwarning");
      $("#ptrdate").focus();
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> PTR Date is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else {

      $.ajax({
        url: 'lsi.php',
        type: 'get',
        cache: false,
        data: {
          txtorigin: $("#txtorigin").val(),
          PTRNumber: $("#PTRNumber").val(),
          ptrdate: $("#ptrdate").val()
        },
        success: function (data) {
          $("#richielistmodal").html(data);
          $("#myModallist").modal("show");
        }
      })
    }
  })

  $(document).on("click", "#btnyessemimanual", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'btnyessemimanual.php',
      type: 'get',
      cache: false,
      data: {
        txtorigin: $("#txtorigin").val(),
        PTRNumber: $("#PTRNumber").val(),
        ptrdate: $("#ptrdate").val()
      },
      success: function (data) {
        var msgtag = '<div class="alert alert-success">' + '<strong>Success! </strong> Transfer Successfully Received!</div>';

        $("#tuklawmodal").html(msgtag);
        $("#tuklawtitle").html("Success");
        $("#yourtuklaw").modal("show");
        loadmanualsemi();

        $("#txtorigin").val("");
        $("#PTRNumber").val("");
        $("#ptrdate").val("");
        $("#txtsource").val("");
        $("#dtpdateaquired").val("");
        $("#txtaccount").val("");
        $("#txtarticle").val("");
        $("#txtamount").val("");
        $("#txtorigin").val("");
        $("#PTRNumber").val("");
        $("#ptrdate").val("");
        $("#myModallist").modal("hide");
      }
    })
  })
  $(document).on("click", "#tabtranssemi", function (e) {
    e.preventDefault();
    tabtranssemis();
  })


  function tabtranssemis() {
    $.ajax({
      url: 'tabtranssemi.php',
      cache: false,
      success: function (data) {
        $("#tabrichie").html(data);
      }
    })
  }
  $(document).on("click", "#tabnewmanual", function (e) {
    e.preventDefault();
    mytabmanual();
  })
  function mytabmanual() {
    $.ajax({
      url: 'mytabmanual.php',
      cache: false,
      success: function (data) {
        $("#tabrichie").html(data);
      }
    })
  }

  $(document).on("click", "#tabtranssemi", function (e) {
    e.preventDefault();
    tabtranssemis();
  })

  $(document).on("change", "#selrsmi", function (e) {
    e.preventDefault();
    if ($("#selrsmi").val() == "3") {
      $("#txtsearchnewrsmi").attr('type', 'date');
    } else {
      $("#txtsearchnewrsmi").attr('type', 'text');
    }
  })
  $(document).on("click", "#btnsearchrsmi", function (e) {
    e.preventDefault();
    $("#selrsmi").removeClass("newwarning");
    if ($("#selrsmi").val() == "1") {
      $("#selrsmi").addClass("newwarning");
      $("#selrsmi").focus();
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> Please select option for searching!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");

    } else {
      $.ajax({
        url: 'searchrsmi.php',
        type: 'get',
        data: {
          selrsmi: $("#selrsmi").val(),
          txtsearchnewrsmi: $("#txtsearchnewrsmi").val()
        },
        cache: false,
        success: function (data) {
          $("#rsmidetails").html(data);
        }
      })
    }
  })

  $(document).on("click", ".btnprintrsmi", function (e) {
    e.preventDefault();
    var savelog = $("#richiedetails").html();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");

    $.ajax({
      url: 'btnprintrsmi.php',
      type: 'get',
      data: { mydata: arr[1] },
      success: function (data) {
        $("#richiedetails").html(data);
        $("#anakproblema").addClass("asawaproblema");
        $("#anakproblema").removeClass("problema");
        window.print();
        $("#anakproblema").addClass("problema");
        $("#anakproblema").removeClass("asawaproblema");
        $("#richiedetails").html(savelog);
      }
    })
  })

  $(document).on("click", "#R0012", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Consolidated REPORT OF SUPPLIES AND MATERIALS ISSUED  </div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'R0012.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
        rsmitabscons();

      }
    })
  })

  function rsmitabscons() {
    $.ajax({
      url: 'rsmicons.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#tsmli").html(data);


      }
    })
  }

  $(document).on("click", "#btnsubmitrsmiconts", function (e) {
    e.preventDefault();

    var rowcount = $("#rsmidetailsss tr").length;
    $("#rsmidetailsss").removeClass("newwarning");
    if (rowcount < 1) {
      $("#rsmidetailsss").addClass("newwarning");
      $("#rsmidetailsss").focus();
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> Sorry No Item to Submit!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");

    } else {
      $.ajax({
        url: 'rsmidetail.php',
        type: 'get',
        cache: false,
        success: function (data) {
          //alert(data);
          $("#R0012").trigger("click");
        }
      })
    }
  })
  // setTimeout(function(){ chksession(); }, 1000);
  function chksession() {
    $.ajax({
      url: 'chksession.php',
      type: 'get',
      cache: false,
      success: function (data) {

        if (data == 0) {
          $("#myModal").modal("show");
        }
      }
    })
  }

  function treturn() {
    $.ajax({
      url: 'treturn.php',
      cache: false,
      type: 'get',
      success: function (e) {
        $("#treturn").html(e);
      }
    })
  }

  // creditMemo
  $(document).on("click", "#btnretursubmit", function (e) {
    e.preventDefault();
    $("#dtpdateret").removeClass("newwarning");
    if ($("#dtpdateret").val() == "") {
      $("#dtpdateret").addClass("newwarning");
      $("#dtpdateret").focus();
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> Date of return is required!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");

    } else {




      $.ajax({
        url: 'btnretursubmit.php',
        type: 'get',
        cache: false,
        data: { dtpdateret: $("#dtpdateret").val() },
        success: function (data) {
          var msgtag = '<div class="alert alert-success">' + '<strong>Successfully submitted! </strong>  </div>' +
            '<div class="row"><div class="cols-xs-12"></div><div class="cols"><button style="display:none;" class="btn btn-primary">Yes </button>' +
            '<button class="btn btn-warning"  style="display:none;">No </button></div></div>';

          $("#tuklawmodal").html(msgtag);
          $("#tuklawtitle").html("Success");
          $("#yourtuklaw").modal("show");
          treturn();

          $("#returnlist").html("");
          $("#txtpropertyreturn").val("");
          $("#selcondition").val("");
          $("#dtpdateret").val("");
          $("#txtmyremarks").val("");
        }
      })
    }


  })

  $(document).on("click", "#newreturntab", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'tabmyreturn.php',
      type: 'get',
      cache: false,
      success: function (response) {
        $("#tabmyreturn").html(response);
      }
    })
  })

  $(document).on("click", ".btnprintirr", function (e) {
    e.preventDefault();
    // alert("Warriors");

  })

  $(document).on("click", "#txtitemsc", function (e) {
    e.preventDefault();
    $.ajax({
      url: "listofmats2.php",
      type: "get",
      data: { mnuasset: 1 },
      cache: false,
      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });

    $("#myModallist").modal("show");
  })
  $(document).on("click", ".itemrowsc", function (e) {
    e.preventDefault();


    var mydata = $(this).attr("id");

    var arr = mydata.split("|");
    editbtnid = arr[0];
    // alert(arr[1]);
    $("#txtitemsc").val(arr[2]);
    $("#txtstocknosc").val(arr[1]);
    $("#txtdescription3").val(arr[3]);
    $("#txtunits").val(arr[4]);
    $("#txtaccount").val(arr[5]);
    bal = arr[6]

    $("#myModallist").modal("hide");
    $("#txtreorder").val(arr[7]);

    $.ajax({
      url: 'scdetails.php',
      cache: false,
      type: 'get',
      data: { editbtnid: editbtnid },
      success: function (response) {
        $("#scdetails").html(response);
      }
    })
  })

  $(document).on("click", "#R0003", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Property Card</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'R0003.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
      }
    })
  })

  $(document).on("click", "#txtsimeitem3", function (e) {
    e.preventDefault();
    $.ajax({
      url: "listofptritem3.php",
      type: "get",
      data: { mnuasset: 3 },
      cache: false,
      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });
    $("#myModallist").modal("show");

  })
  $(document).on("click", ".itemrowppesemi3", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    propertyid = arr[0];

    $("#txtproperty3").val(arr[1]);
    $("#txtsimeitem3").val(arr[2]);
    $("#txtsemidesc").val(arr[3]);
    $("#txtfundcluster").val(arr[6]);
    $("#myModallist").modal("hide");

    $.ajax({
      url: 'pcdetails.php',
      cache: false,
      type: 'get',
      data: { txtproperty3: $("#txtproperty3").val() },
      success: function (response) {
        $("#scdetails").html(response);
      }
    })

  })

  $(document).on("click", "#R0004", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Semi-Expendable Card</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'R0004.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
      }
    })
  })
  $(document).on("click", "#txtsimeitem4", function (e) {
    e.preventDefault();
    $.ajax({
      url: "listofptritem4.php",
      type: "get",
      data: { mnuasset: 2 },
      cache: false,
      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });
    $("#myModallist").modal("show");

  })


  $(document).on("click", ".itemrowppesemi4", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    propertyid = arr[0];

    $("#txtproperty4").val(arr[1]);
    $("#txtsimeitem4").val(arr[2]);
    $("#txtsemidesc").val(arr[3]);
    $("#txtfundcluster").val(arr[6]);
    $("#myModallist").modal("hide");

    $.ajax({
      url: 'pcdetails2.php',
      cache: false,
      type: 'get',
      data: { txtproperty3: $("#txtproperty4").val() },
      success: function (response) {
        $("#scdetails").html(response);
      }
    })

  })
  $(document).on("click", "#btnprintsc", function (e) {
    e.preventDefault();
    var savelog = $("#richiedetails").html();
    $.ajax({
      url: 'btnprintsc.php',
      cache: false,
      type: 'get',
      data: {
        editbtnid: editbtnid,
        txtstocknosc: $("#txtstocknosc").val(),
        txtitemsc: $("#txtitemsc").val(),
        txtdescription3: $("#txtdescription3").val(),
        txtunits: $("#txtunits").val(),
        txtreorder: $("#txtreorder").val()
      },
      success: function (response) {

        $("#richiedetails").html(response);
        $("#anakproblema").addClass("asawaproblema");
        $("#anakproblema").removeClass("problema");

        window.print();
        $("#anakproblema").addClass("problema");
        $("#anakproblema").removeClass("asawaproblema");
        $("#richiedetails").html(savelog);
      }
    })
  })
  $(document).on("click", "#btnprintpc", function (e) {
    e.preventDefault();
    var savelog = $("#richiedetails").html();
    $.ajax({
      url: 'btnprintpc.php',
      cache: false,
      type: 'get',
      data: {
        editbtnid: propertyid,
        txtEntity: $("#txtEntity").val(),
        txtfundcluster: $("#txtfundcluster").val(),
        txtproperty3: $("#txtproperty3").val(),
        txtsimeitem3: $("#txtsimeitem3").val(),
        txtsemidesc: $("#txtsemidesc").val()
      },
      success: function (response) {

        $("#richiedetails").html(response);

        $("#anakproblema").addClass("asawaproblema");
        $("#anakproblema").removeClass("problema");

        window.print();
        $("#anakproblema").addClass("problema");
        $("#anakproblema").removeClass("asawaproblema");
        $("#richiedetails").html(savelog);


      }
    })
  })
  $(document).on("click", "#btnprintpcsemi", function (e) {
    e.preventDefault();

    var savelog = $("#richiedetails").html();
    $.ajax({
      url: 'btnprintpcsemi.php',
      cache: false,
      type: 'get',
      data: {
        propertyid: propertyid,
        txtproperty4: $("#txtproperty4").val(),
        txtsimeitem4: $("#txtsimeitem4").val(),
        txtsemidesc: $("#txtsemidesc").val(),
        txtfundcluster: $("#txtfundcluster").val()
      },
      success: function (response) {

        $("#richiedetails").html(response);
        window.print(); $("#anakproblema").addClass("asawaproblema");
        $("#anakproblema").removeClass("problema");

        window.print();
        $("#anakproblema").addClass("problema");
        $("#anakproblema").removeClass("asawaproblema"); $("#richiedetails").html(savelog);
      }
    })
  })
  $(document).on("click", "#R0006", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">REPORT ON THE PHYSICAL COUNT OF INVENTORIES (RPCI)</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'R0006.php',
      cache: false,
      type: 'get',

      success: function (data) {
        $("#frmmodalbody").html(data);
      }
    })
  })

  $(document).on("change", "#selmyacct", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'rpci.php',
      cache: false,
      type: 'get',
      data: { selmyacct: $("#selmyacct").val() },
      success: function (data) {
        $("#tblrpci").html(data);
      }
    })
  })

  $(document).on("change", "#selmyacctppe", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'rpcppe.php',
      cache: false,
      type: 'get',
      data: { selmyacct: $("#selmyacctppe").val() },
      success: function (data) {
        $("#tblrpci").html(data);
      }
    })
  })


  $(document).on("click", "#btnprintrpci", function (e) {
    e.preventDefault();
    var savelog = $("#richiedetails").html();
    $.ajax({
      url: 'btnprintrpci.php',
      cache: false,
      type: 'get',
      data: {
        selmyacct: $("#selmyacct").val()

      },
      success: function (response) {

        $("#richiedetails").html(response);
        $("#anakproblema").addClass("asawaproblema");
        $("#anakproblema").removeClass("problema");

        window.print();
        $("#anakproblema").addClass("problema");
        $("#anakproblema").removeClass("asawaproblema");
        $("#richiedetails").html(savelog);
      }
    })
  })
  $(document).on("click", "#btnprintrpcppe", function (e) {
    e.preventDefault();
    var savelog = $("#richiedetails").html();
    $.ajax({
      url: 'btnprintrpcppe.php',
      cache: false,
      type: 'get',
      data: {
        selmyacct: $("#selmyacctppe").val()

      },
      success: function (response) {

        $("#anakproblema").addClass("asawaproblema");
        $("#anakproblema").removeClass("problema");

        window.print();
        $("#anakproblema").addClass("problema");
        $("#anakproblema").removeClass("asawaproblema");
        $("#richiedetails").html(savelog);
      }
    })
  })
  $(document).on("click", "#R0005", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">INDIVIDUAL EMPLOYEE PROPERTY INDEX  </div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'R0005.php',
      cache: false,
      type: 'get',

      success: function (data) {
        $("#frmmodalbody").html(data);
      }
    })
  })

  $(document).on("click", "#txtempnameindex", function (e) {
    e.preventDefault();
    $.ajax({
      url: "listofemployees2.php",
      type: "get",
      cache: false,
      success: function (data) {
        // $("#richierichmodal").html(data);
        $("#tuklawmodal").html(data);
        $("#tuklawtitle").html("List of Employee");
        $("#yourtuklaw").modal("show");
      }
    });

    $("#yourtuklaw").modal("show");


  })
  var eidko = "";
  $(document).on("click", ".employeerow2", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    $("#txtempnameindex").val(arr[1]);
    eidko = arr[1];
    $("#yourtuklaw").modal("hide");

    $.ajax({
      url: 'employeerow2.php',
      type: 'get',
      cache: false,
      data: { eidko: eidko },
      success: function (data) {
        $("#ooo5").html(data);
      }
    })
  })
  $(document).on("change", "#txtempnameindex", function (e) {
    e.preventDefault();

  })
  $(document).on("click", "#btnprinindex", function (e) {
    e.preventDefault();
    var savelog = $("#richiedetails").html();
    $.ajax({
      url: 'btnprinindex.php',
      cache: false,
      type: 'get',
      data: {
        eidko: eidko,
        txtempnameindex: $("#txtempnameindex").val()
      },
      success: function (response) {

        $("#richiedetails").html(response);
        $("#anakproblema").addClass("asawaproblema");
        $("#anakproblema").removeClass("problema");

        window.print();
        $("#anakproblema").addClass("problema");
        $("#anakproblema").removeClass("asawaproblema");
        $("#richiedetails").html(savelog);
      }
    })
  })

  $(document).on("click", "#R0007", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">PHYSICAL COUNT</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'R0007.php',
      cache: false,
      type: 'get',

      success: function (data) {
        $("#frmmodalbody").html(data);

        $.ajax({
          url: 'selPhysical.php',
          cache: false,
          type: 'get'
          , data: { Accid: 1 },
          success: function (data) {
            $("#cnoption").html(data);



          }
        })
      }
    })
  })


  $(document).on("click", "#tabnewrsmicc", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'tabnewrsmicc.php',
      type: 'get',
      cache: false,
      success: function (data) {
        $("#mynewrsmi").html(data);
      }
    })
  })

  $(document).on("click", "#R0013", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Consolidated REPORT OF SUPPLIES AND MATERIALS ISSUED  </div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'R0013.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
        //     rsmitabscons();
        $("#tabnewrsmicc").trigger("click");
      }
    })
  })

  $(document).on("click", "#btnsearchrsmicc", function (e) {
    e.preventDefault();
    $("#selrsmicc").removeClass("newwarning");
    if ($("#selrsmicc").val() == "1") {
      $("#selrsmicc").addClass("newwarning");
      $("#selrsmicc").focus();
      var msgtag = '<div class="alert alert-warning">' + '<strong>Warning! </strong> Please select option for searching!</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");

    } else {
      $.ajax({
        url: 'searchrsmicc.php',
        type: 'get',
        data: {
          selrsmi: $("#selrsmi").val(),
          txtsearchnewrsmi: $("#txtsearchnewrsmic").val()
        },
        cache: false,
        success: function (data) {
          $("#rsmidetails").html(data);
        }
      })
    }
  })

  $(document).on("click", "#R0009", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">REPORT ON THE PHYSICAL COUNT OF SEMI-EXPENDABLE (RPCS-E)</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'R0009.php',
      cache: false,
      type: 'get',

      success: function (data) {
        $("#frmmodalbody").html(data);
      }
    })
  })

  $(document).on("click", "#T0012", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Inventory and Inspection Report on Unserviceable Property </div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'T0010.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
        irrupdetails();
      }
    })
  })

  function irrupdetails() {
    $.ajax({
      url: 'irrupdetails.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#irrup1").html(data);


      }
    })
  }

  $(document).on("click", "#btnirrupsend", function (e) {
    e.preventDefault();
    var rowcount = $("#tbats tr").length;

    if (rowcount < 1) {

      $("#tuklawmodal").html(" No Data to Submit!");


      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else {
      var val = [];

      $('#ad_Checkbox1:checked').each(function (i) {
        val[i] = $(this).val();
      });

      $.ajax({
        url: 'btnirrup.php',
        type: 'get',
        cache: false,
        data: { val: val },
        success: function (data) {
          // alert(data);
          irrupdetails();
        }
      })
    }

  })
  $(document).on("click", ".btnmyprint2", function (e) {
    var savelog = $("#richiedetails").html();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");

    $.ajax({
      url: 'btnprintsemippedel.php',
      type: 'get',
      data: { mydata: arr[1], tag: 3 },
      success: function (data) {
        $("#richiedetails").html(data);
        window.print();
        $("#richiedetails").html(savelog);
      }
    })


  })

  $(document).on("click", ".btnprintret", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    // var arr = mydata.split("|");
    var savelog = $("#richiedetails").html();
    $.ajax({
      url: 'btnprintret.php',
      type: 'get',
      data: { arr: mydata },
      success: function (data) {
        $("#anakproblema").removeClass("problema");
        $("#richiedetails").html(data);
        window.print();
        $("#anakproblema").addClass("problema");
        $("#richiedetails").html(savelog);
      }
    })
  })

  $(document).on("click", "#A0011", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Plantilla Position</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'A0011.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
        positiondetails();
      }
    })

    btntag = 0;

  })
  function positiondetails() {
    $.ajax({
      url: 'positiondetails.php',
      data: { txtsections: $("#txtsearchposition").val() },
      cache: false,
      success: function (data) {

        $("#rcdetails").html(data);
      }
    })
  }

  $(document).on("click", ".btnpositionedit", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    mydivid = arr[0];
    $("#txtpositiondata").val(arr[1]);
    btntag = 1;


    var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Update</span>';
    $("#btnsaveposition").html(bntval);
  })



  $(document).on("click", "#btnsaveposition", function (e) {
    e.preventDefault();
    if ($("#txtpositiondata").val() == "") {
      var msgtag = '<div class="alert alert-danger">' +
        '<strong>Warning! </strong> Position  is Required!</strong> .</div>';

      $("#tuklawmodal").html(msgtag);
      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");

    } else {
      var stat = "";

      if (btntag == 0) {
        stat = "Save";
      } else {
        stat = "Update";
      }

      var myalert = "<div class='alert alert-info'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to " + stat + " <strong > " + $("#txtpositiondata").val() + "? </strong> .</div>"
      $("#errmsgconf1").html(myalert);
      var str = '   <form id="frmdelmenu">' +


        '<div class="row">' +
        ' <div class="col-xs-2">' +
        '<input type="submit" name="btnpositionyes" id="btnpositionyes" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
        '<div class="col-xs-2">' +
        '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat" data-dismiss="modal"></div>' +
        '</div>' +
        '</form>';

      $("#richiemodal").html(str);

      $("#myModalconfirm").modal("show");





    }
  })

  $(document).on("click", "#btnpositionyes", function (e) {
    e.preventDefault();

    if (btntag == 0) {
      $.ajax({
        url: 'saveposition.php',
        type: 'get',
        dataType: 'JSON',
        data: { txtsectiondata: $("#txtpositiondata").val() },
        success: function (response) {
          var len = response.length;
          var msg = response[0].msg;
          for (var i = 0; i < len; i++) {
            var msg = response[i].msg;
            var tag = response[i].tag;

            if (tag == 1) {
              var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';

              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Warning");
              $("#yourtuklaw").modal("show");
            } else if (tag == 2) {
              var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';



              $.ajax({
                url: 'A0011.php',
                cache: false,
                type: 'get',
                success: function (data) {
                  $("#frmmodalbody").html(data);
                  positiondetails();
                }
              })
              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Success");
              $("#yourtuklaw").modal("show");
              $("#myModalconfirm").modal("hide");
              positiondetails();
              $("#txtpositiondata").val("");


            }
          }
        }
      })
    } else if (btntag == 1) {
      $.ajax({
        url: 'editposition.php',
        type: 'get',
        dataType: 'JSON',
        data: {
          mydivid: mydivid,
          txtsectiondata: $("#txtpositiondata").val()
        },
        success: function (response) {
          var len = response.length;
          var msg = response[0].msg;
          for (var i = 0; i < len; i++) {
            var msg = response[i].msg;
            var tag = response[i].tag;

            if (tag == 1) {
              var msgtag = '<div class="alert alert-danger">' + '<strong>Warning!</strong> ' + msg + ' .</div>';

              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Warning");
              $("#yourtuklaw").modal("show");
            } else if (tag == 2) {
              var msgtag = '<div class="alert alert-success">' + ' ' + msg + ' .</div>';
              $.ajax({
                url: 'A0011.php',
                cache: false,
                type: 'get',
                success: function (data) {
                  $("#frmmodalbody").html(data);
                  positiondetails();
                }
              })

              $("#tuklawmodal").html(msgtag);
              $("#tuklawtitle").html("Success");
              $("#yourtuklaw").modal("show");
              $("#myModalconfirm").modal("hide");
              positiondetails();
              $("#txtpositiondata").val("");


            }
          }
        }
      })
    }
    var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
    $("#btnsaveposition").html(bntval);
    btntag = 0;
  })

  $(document).on("click", "#btndelposition", function (e) {
    e.preventDefault()
    $.ajax({
      url: 'btndelposition.php',
      type: 'get',
      data: { btnid: $("#btnid").val() },
      success: function (data) {
        positiondetails();

        $.ajax({
          url: 'A0011.php',
          cache: false,
          type: 'get',
          success: function (data) {
            $("#frmmodalbody").html(data);
            positiondetails();
            var msgtags = '<div class="alert alert-success"> Successfully deleted.</div>';


            $("#tuklawmodal").html(msgtags);
            $("#tuklawtitle").html("Success");
            $("#yourtuklaw").modal("show");
          }
        })
        $("#myModalconfirm").modal("hide");
      }
    })
  })

  $(document).on("click", "#btnaccoutntitleimport", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'samplerichie.php',
      type: 'get',

      success: function (data) {
        $(".showimportaccount").html(data);
      }
    })
  })

  $(document).on("click", "#btnuploads", function (e) {
    e.preventDefault();

    $("#btnuploads").prop('disabled', true);
    var tb = $('.layui-table:eq(0) tbody');
    var size = tb.find("tr").length;
    var mysize = [];
    var chie0 = [];
    var chie1 = [];
    var i = 0;



    var tb = $('.layui-table:eq(0) tbody');
    var size = tb.find("tr").length;
    console.log("Number of rows : " + size);
    tb.find("tr").each(function (index, element) {
      var colSize = $(element).find('td').length;

      $(element).find('td').each(function (index, element) {
        var colVal = $(element).text();
        //    console.log( colVal.trim());

        chie0.push(colVal);


      });

    });
    // alert(chie0);

    $.ajax({
      url: 'saveupload.php',
      type: 'get',
      data: { chie0: chie0 },
      cache: false,
      success: function (response) {


        $("#tuklawmodal").html("Account Title Succesfully Uploaded");

        $("#tuklawtitle").html("Success");
        $("#yourtuklaw").modal("show");
        $("#btnuploads").prop('disabled', false);

        var strform = ' <div class="panel panel-primary">' +
          '<div class="panel-heading">Account Title Entry</div>' +
          '<div class="panel-body" id="frmmodalbody">' +
          ' <div id="mnudetails"></div> </div> </div></div>';

        $("#richiedetails").html(strform);
        $.ajax({
          url: 'A0008.php',
          cache: false,
          type: 'get',
          success: function (data) {
            $("#frmmodalbody").html(data);

            loadaccountitledetails();
          }
        })

        btntag = 0;
        var bntval = '<span class="glyphicon glyphicon-floppy-disk">&nbsp;Save</span>';
        $("#btnsaveaccounttitle").html(bntval);

      }
    })

  })
  $(document).on("click", "#btnItemimport", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'importitemname.php',
      type: 'get',

      success: function (data) {
        $(".showimportaccount").html(data);

        $("#mnutitle").addClass("richiehide");
      }
    })

  })

  $(document).on("click", "#btnuploaditem", function (e) {
    e.preventDefault();



    $("#btnuploaditem").prop('disabled', true);
    var tb = $('.layui-table:eq(0) tbody');
    var size = tb.find("tr").length;
    var mysize = [];
    var chie0 = [];
    var chie1 = [];
    var i = 0;



    var tb = $('.layui-table:eq(0) tbody');
    var size = tb.find("tr").length;
    // console.log("Number of rows : " + size);
    tb.find("tr").each(function (index, element) {
      var colSize = $(element).find('td').length;

      $(element).find('td').each(function (index, element) {
        var colVal = $(element).text();
        //    console.log( colVal.trim());

        chie0.push(colVal);


      });

    });

    // alert(chie0);
    $.ajax({
      url: 'saveuploaditem.php',
      type: 'POST',
      data: { chie0: chie0 },
      cache: false,
      success: function (response) {
        // alert(response);
        $("#tuklawmodal").html(" Title Succesfully Uploaded");

        $("#tuklawtitle").html("Success");
        $("#yourtuklaw").modal("show");
      }
    })
    $("#btnuploaditem").prop('disabled', false);
  })

  $(document).on("click", "#btnsearchposition", function (e) {
    e.preventDefault();
    positiondetails();
  })



  $(document).on("click", "#btnprofileimport", function (e) {
    e.preventDefault();
    e.preventDefault();
    $.ajax({
      url: 'profileupload.php',
      type: 'get',

      success: function (data) {
        $("#showcontent").html(data);
      }
    })
  })


  $(document).on("click", "#btnuploadsx", function (e) {
    e.preventDefault();

    $("#btnuploadsx").prop('disabled', true);
    var tb = $('.layui-table:eq(0) tbody');
    var size = tb.find("tr").length;
    var mysize = [];
    var chie0 = [];
    var chie1 = [];
    var i = 0;



    var tb = $('.layui-table:eq(0) tbody');
    var size = tb.find("tr").length;
    console.log("Number of rows : " + size);
    tb.find("tr").each(function (index, element) {
      var colSize = $(element).find('td').length;

      $(element).find('td').each(function (index, element) {
        var colVal = $(element).text();
        //    console.log( colVal.trim());

        chie0.push(colVal);


      });

    });
    // alert(chie0);

    $.ajax({
      url: 'saveuploadprofile.php',
      type: 'get',
      data: { chie0: chie0 },
      cache: false,
      success: function (response) {

        $("#tuklawmodal").html("Employee Profile Succesfully Uploaded");

        $("#tuklawtitle").html("Success");
        $("#yourtuklaw").modal("show");

      }
    })

  })

  $(document).on("click", "#A0012", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Department Approver</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);

    $.ajax({
      url: 'A0012.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
        // $("#txtaccounttitle").addClass('richieholder');
        // loadaccountitledetails();
        loadapproverdetails();
      }
    })

  })
  $(document).on("click", "#txtdempname", function (e) {
    e.preventDefault();

    $.ajax({
      url: "txtdempname.php",
      type: "get",

      cache: false,
      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });

    $("#myModallist").modal("show");
  })


  $(document).on("click", "#btnsearchoflist", function (e) {
    e.preventDefault();

    $.ajax({
      url: "btnsearchoflist.php",
      type: "get",
      data: { txtsearchoflist: $("#txtsearchoflist").val() },
      cache: false,
      success: function (data) {
        $("#listofmats").html(data);
      }
    });
  })



  $(document).on("click", "#btnsearchdemp", function (e) {
    e.preventDefault();

    $.ajax({
      url: "btnsearchdemp.php",
      type: "get",
      data: { txtsearchoflist: $("#txtsearchoflist").val() },
      cache: false,
      success: function (data) {
        $("#listofmats").html(data);
      }
    });
  })

  var aapid = 0;
  $(document).on("click", ".itemappover", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    $("#txtdempname").val(arr[2]);
    appid = arr[0];

    // alert(appid);
    $("#myModallist").modal("hide");
  })


  $(document).on("click", "#btnSearchapprover", function (e) {
    e.preventDefault();
    loadapproverdetails();
  })
  function loadapproverdetails() {
    $.ajax({
      url: 'approverdetails.php',
      type: 'get',
      data: { txtsearchapprover: $("#txtsearchapprover").val() },
      cache: false,
      success: function (data) {

        $("#rcdetails").html(data);
      }
    })
  }

  $(document).on("click", "#btnsaveApprover", function (e) {
    e.preventDefault();
    if ($("#ressel").val() == "Select  Responsibility Center") {
      $("#tuklawmodal").html(" Please Select Responsibility Center!");

      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#scesel").val() == "Select Section") {
      $("#tuklawmodal").html(" Please Select Sections!");

      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if ($("#txtdempname").val() == "") {
      $("#tuklawmodal").html(" Please Select Employee Name!");

      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else if (appid == 0) {
      $("#tuklawmodal").html(" Please Select Employee Name!");

      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else {
      $.ajax({
        url: 'btnsaveApprover.php',
        type: 'get',
        data: {
          ressel: $("#ressel").val(),
          scesel: $("#scesel").val(),
          appid: appid
        },
        cache: false,
        success: function (data) {
          if (data == 1) {
            $("#tuklawmodal").html(" Approver Name Successfully Added!");

            $("#tuklawtitle").html("Success");
            $("#yourtuklaw").modal("show");
            loadapproverdetails();
            $("#txtdempname").val("");
            appid = 0;
            $("#ressel").val(0);
            $("#scesel").val(0);
          } else if (data == 2) {
            $("#tuklawmodal").html(" Approve name alread tag to this responsibility Center!");

            $("#tuklawtitle").html("Warning");
            $("#yourtuklaw").modal("show");
          } else {
            $("#tuklawmodal").html(" Something Went Wrong!");
            // $("#tuklawmodal").html(data);

            $("#tuklawtitle").html("Warning");
            $("#yourtuklaw").modal("show");
          }
        }

      })
    }


  })

  $(document).on("click", "#btnaddrow", function (e) {
    e.preventDefault();


    $.ajax({
      url: "listofmyitem.php",
      type: "get",
      data: {
        mnuasset: 1, datereceived: $("#dtpReportDate").val(),
        optcount: $("#optcount").val()
      },
      cache: false,
      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });

    $("#myModallist").modal("show");

  })


  $(document).on("click", ".btnremovesel", function (e) {
    e.preventDefault()

    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    var ss = 'row' + arr[1];
    let dtpReportDate = $("#dtpReportDate").val();
    // alert(ss);
    $.ajax({
      type: "GET",
      caches: false,
      url: "delselected.php",
      data: {
        itemid: arr[1],
        dtpReportDate: dtpReportDate
      },
      success: function (response) {
        // $("#tblrpci").html(response);
        // alert(response);


        if (response == 2) {

          var row2 = document.getElementById(ss);
          row2.remove();
        } else {
          $("#tuklawmodal").html('<div class="alert alert-danger">Selected item cannot be deleted. Partial physical count record found</div>');

          $("#tuklawtitle").html("Warning");
          $("#yourtuklaw").modal("show");
        }
        // alert(response)
      }
    });


  })


  $(document).on("click", ".itemrownew", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    var selsource = $("#txtsource").val();

    // alert(arr[1]);
    $.ajax({
      type: "GET",
      caches: false,
      url: "savetemprpc.php",
      data: {
        itemname22: arr[2],
        desc: arr[3],
        stock: arr[1],
        unit: arr[4],
        cost: arr[8],
        bal: arr[6],
        dtpReportDate: $("#dtpReportDate").val(),
        itemid: arr[0],

        selsource: selsource


      },
      success: function (response) {

        if (response == 1) {
          $("#tuklawmodal").html('<div class="alert alert-danger"> Duplicate found on the list.</div>');

          $("#tuklawtitle").html("Warning");
          $("#yourtuklaw").modal("show");
        } else {
          $("#tblrpci").html(response);
        }

        // alert(response)
      }
    });



    $("#myModallist").modal("hide");
  })

  $(document).on("click", ".btnApproverRemove", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    $.ajax({
      url: 'btnApproverRemove.php',
      type: 'get',
      data: { mydata: arr[0] },
      cache: false,
      success: function (data) {
        if (data == 1) {
          $("#tuklawmodal").html(" Approver Name Successfully Removed!");

          $("#tuklawtitle").html("Success");
          $("#yourtuklaw").modal("show");
          loadapproverdetails();

          appid = 0;

          $("#scesel").val(0);

        } else {
          $("#tuklawmodal").html(" Something Went Wrong!");


          $("#tuklawtitle").html("Warning");
          $("#yourtuklaw").modal("show");
        }
      }

    })
  })
  $(document).on("click", "#btnyespro", function (e) {
    e.preventDefault();
    $.ajax({
      type: "GET",
      caches: false,
      url: "btnyespro.php",
      data: { btnid: $("#btnid").val() },
      success: function (response) {
        $("#myModalconfirm").modal("hide");
        loadprofiledetails();
      }
    });
  })

  $(document).on("click", "#irrups", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'irruplist.php',
      caches: false,
      success: function (data) {
        $("#irrupe").html(data);
        // alert(data);
      }


    })
  })


  $(document).on("click", "#T0011", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Reclassification from PPE to Semi-Expendable</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>' +
      '<br/><div class="panel panel-primary">' +
      '<div class="panel-heading">List of Reclassified Items</div>' +
      '<div class="panel-body" id="frmmodalbody2">' +
      ' <div id="mnudetails"></div> </div> </div></div>'
      ;

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'T0011.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);



      }
    })


    $.ajax({
      url: 'reclassdetails.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody2").html(data);



      }
    })



  })

  $(document).on("change", "#txtSearchReclass", function (e) {
    e.preventDefault();
    var txtsearch = $(this).val();


    $.ajax({
      url: 'tblsearch.php',
      cache: false,
      data: { txtsearch: txtsearch },
      success: function (mydata) {
        $("#tblsearch").html(mydata);

      }
    })

  });



  $(document).on("click", "#btnsaveMepi", function (e) {
    e.preventDefault();
    var val = [];
    var cmbGroup = $("#optClass").val();
    $('#ad_Checkbox1:checked').each(function (i) {
      val[i] = $(this).val();
    });


    $.ajax({
      url: 'btnsaveMepi.php',
      type: 'get',
      cache: false,
      data: { val: val, cmbGroup: cmbGroup },
      success: function (data) {
        // alert(data);
        // gpbody();
        $.ajax({
          url: 'postgpbody.php',
          cache: false,

          success: function (mydata) {
            $("#mygpbody").html(mydata);

          }
        })

        $('input[type=checkbox]').prop('checked', false);
      }
    })


  })

  $(document).on("click", "#btnirrup", function (e) {
    e.preventDefault();

  })

  $(document).on("click", "#itemShowmore", function (e) {
    e.preventDefault();


    $.ajax({
      url: 'showsemiexpendable.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#richielistmodal12").html(data);

      }
    })
    $("#mymodalrichieshowDetails").modal("show");
  })

  $(document).on("change", "#txtseachsemirec", function (e) {
    e.preventDefault();
    $.ajax({
      url: 'txtseachsemirec.php',
      data: { item: $(this).val() },
      cache: false,
      type: 'get',
      success: function (data) {
        $("#tblsearchsss").html(data);



      }
    })
  })


  $(document).on("click", "#btnseachClass", function (e) {
    e.preventDefault()
    $.ajax({
      url: 'newsearch.php',
      data: { txtSearchReclass: $("#txtSearchReclass").val() },
      cache: false,
      type: 'get',
      success: function (data) {
        $("#tblsearch").html(data);



      }
    })


  })
  $(document).on("click", "#btnsavereclass", function (e) {
    e.preventDefault();
    var myhdid = $("#myhdid").val();
    var reclassremarks = $("#reclassremarks").val();
    var optClass = $("#titleid").val();
    var recid = $("#recid").val();
    var prop = $("#prop").val();
    // alert(" TO  "+ recid + " From  " + myhdid + " " + reclassremarks + " " + optClass) ;
    $.ajax({
      url: "btnsaveMepi.php",
      type: "get",
      cache: false,
      data: {
        myhdid: myhdid,
        reclassremarks: reclassremarks,
        optClass: optClass,
        recid: recid,
        prop: prop
      },
      success: function (data) {

        $.ajax({
          url: 'T0011.php',
          cache: false,
          type: 'get',
          success: function (data) {
            $("#frmmodalbody").html(data);



          }
        })


        $.ajax({
          url: 'reclassdetails.php',
          cache: false,
          type: 'get',
          success: function (data) {
            $("#frmmodalbody2").html(data);



          }
        })



        $("#mymodalrichie").modal("hide");

      }
    })

  })

  $(document).on("click", ".selectmyid", function (e) {
    e.preventDefault();
    var r = $(this).attr("id");
    var myhdid = $("#myhdid").val()
    $.ajax({
      url: "showmydetails.php",
      type: "get",
      cache: false,
      data: { myid: r, myhdid: myhdid },
      success: function (data) {
        $("#showmydetails").html(data);
        $("#mymodalrichieshowDetails").modal("hide");
      }
    })



  })
  $(document).on("click", ".bnmyreclass", function (e) {
    e.preventDefault();
    var myid = $(this).attr("id");
    //  alert(myid);
    $.ajax({
      url: "newreclass.php",
      type: "get",
      cache: false,
      data: { myid: myid },
      success: function (data) {
        $("#richielistmodal1").html(data);
        $("#mdconfirm").val("Reclassification Details");
      }
    })

    $("#mymodalrichie").modal("show");
  })


  $(document).on("click", "#btnshowReports", function (e) {
    e.preventDefault();


    if ($("#dtpReportDate").val() == "") {
      $("#tuklawmodal").html('<div class="alert alert-danger"> Please select cut-off date.</div>');

      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else {
      var optcount = $("#optcount").val();
      var dtpReportDate = $("#dtpReportDate").val();
      var selPhysical = $("#selPhysical").val();
      var selsource = $("#txtsource").val();
      $.ajax({
        url: 'showphysicalcount.php',
        cache: false,
        type: 'get'
        , data: {
          optcount: optcount,
          dtpReportDate: dtpReportDate,
          selPhysical: selPhysical,
          selsource: selsource


        },
        success: function (data) {
          $("#newcontaner").html(data);



        }
      })


    }

  })



  $(document).on("click", ".btnapprrpc", function (e) {
    e.preventDefault();
  })
  $(document).on("change", "#selPhysical", function (e) {
    e.preventDefault();
    var Accid = $(this).val();
    $.ajax({
      url: 'selPhysical.php',
      cache: false,
      type: 'get'
      , data: { Accid: Accid },
      success: function (data) {

        $("#cnoption").html(data);


      }
    })


  })

  $(document).on("change", "#dtpdate", function (e) {
    e.preventDefault();
    const selectedDate = new Date(e.target.value);


    const currentDate = new Date();

    if (selectedDate.getTime() > currentDate.getTime()) {
      e.target.value = '';


      $("#tuklawmodal").html('<div class="alert alert-danger"> Please select a valid date.</div>');

      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    }
  })

  $(document).on("change", ".txtbpccount", function (e) {
    e.preventDefault();


    //   var mydata = $(this).attr("id");
    //   var arr = mydata.split("|");


    //   var myid = '.'  +  arr[0] ;
    //   var myave = '.lblave' +  arr[1];
    // var txtbpccount =  parseFloat($(this).val())  - parseFloat(arr[2]);
    // var myvals  = parseFloat(arr[3]) * parseFloat(txtbpccount);
    // let myval = myvals.toLocaleString(); 



    // $(myid).html(txtbpccount);
    // $(myave).html(myval);
    // $.ajax({
    //   url:'txtbpccount.php',
    //   cache:false,
    //   type:'get',
    //   data:{itemid: arr[1],
    //     txtbpccount:txtbpccount,
    //     myval:myval,
    //     bal:arr[2],
    //     qty:$(this).val(),
    //     dtpReportDate:$("#dtpReportDate").val(),
    //     cost:arr[3]
    //   },
    //   success:function(data){


    //   }
    // })

  })



  $(document).on("click", "#R0014", function (e) {
    e.preventDefault();
    var strform =
      '<br/><div class="panel panel-primary">' +
      '<div class="panel-heading">List of Disposal</div>' +
      '<div class="panel-body" id="frmmodalbody2">' +
      ' <div id="mnudetails"></div> </div> </div></div>'
      ;

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'R0014.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody2").html(data);



      }
    })



  })
  $(document).on("click", "#T0013", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">PHYSICAL COUNT APPROVAL</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);
    $.ajax({
      url: 'T0013.php',
      cache: false,
      type: 'get',

      success: function (data) {
        $("#frmmodalbody").html(data);

        // $.ajax({
        //   url:'selPhysical.php',
        //   cache:false,
        //   type:'get'
        //   ,data:{Accid:1},
        //   success:function(data){
        //     $("#cnoption").html(data);



        //   }
        // })
      }
    })


  })

  $(document).on("click", "#btnshowapprovalspc", function (e) {
    e.preventDefault();
    if ($("#txtsource").val() == "") {
      $("#tuklawmodal").html('<div class="alert alert-danger"> Select fund source</div>');

      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else {
      let selPhysicalA = $("#selPhysicalA").val();
      let txtsource = $("#txtsource").val();


      $.ajax({
        url: 'btnshowapprovalspc.php',
        cache: false,
        type: 'get'
        , data: {
          selPhysicalA: selPhysicalA,
          txtsource: txtsource

        },
        success: function (data) {
          $("#newcontaner").html(data);
        }
      })

    }



  })
  $(document).on("change", ".txtremarks", function (e) {
    e.preventDefault();
    let mydata = $(this).attr("id");
    let arr = mydata.split("|");
    // window.print();
    let id = arr[1];


    $.ajax({
      url: 'saveremarks.php',
      cache: false,
      type: 'get'
      , data: {
        itemid: id,
        remarks: $(this).val()
      },
      success: function () {

      }
    })


  })
  $(document).on("click", "#btnPhysicalprint", function (e) {
    e.preventDefault();

    if ($("#dtpReportDate").val() == "") {
      $("#tuklawmodal").html('<div class="alert alert-danger"> Please select cut-off date.</div>');

      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else {
      var optcount = $("#optcount").val();
      var dtpReportDate = $("#dtpReportDate").val();
      var selPhysical = $("#selPhysical").val();
      $.ajax({
        url: 'showphysicalcount.php',
        cache: false,
        type: 'get'
        , data: {
          optcount: optcount,
          dtpReportDate: dtpReportDate,
          selPhysical: selPhysical


        },
        success: function (data) {
          $("#newcontaner").html(data);



        }
      })


    }

  })


  $(document).on("click", ".txtbpccount", function (e) {
    e.preventDefault();

    let mydata = $(this).attr("id");
    let arr = mydata.split("|")
    var optcount = $("#optcount").val();
    var dtpReportDate = $("#dtpReportDate").val();
    var selPhysical = $("#selPhysical").val();
    var selsource = $("#txtsource").val();
    let itemid = arr[1];
    $.ajax({
      url: "showresponsibility.php",
      type: "get",
      cache: false,
      data: {
        optcount: optcount,
        dtpReportDate: dtpReportDate,
        selPhysical: selPhysical,
        selsource: selsource,
        itemid: itemid,
        cost: arr[3]
      },
      success: function (data) {

        var myalert = "<div class='alert alert-success'>    Successfully added.</div>";
        $("#tuklawmodal").html(myalert);
        $("#tuklawtitle").html("Physical Count");
        $("#yourtuklaw").modal("show");
      }
    });




  })
  $(document).on("click", ".itemrowresponsibility", function (e) {
    e.preventDefault();
    var mydata = $(this).val();
    let arr = mydata.split("|");

    $("#txtCenter").val(arr[1]);

    $("#myModallist").modal("hide");
  })
  $(document).on("click", "#txtCenter", function (e) {

    $.ajax({
      url: "listofres.php",
      type: "get",
      cache: false,
      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });

    $("#myModallist").modal("show");

  })

  $(document).on("change", ".txtpcountrow", function (e) {
    e.preventDefault();

    let mydata = $(this).attr("id");
    let arr = mydata.split("|");
    let calc = parseInt($(this).val()) - parseInt(arr[1]);
    let newdata = "#str" + arr[2];
    //  alert($(this).val());
    // alert(mydata);
    // alert(newdata);
    $(newdata).html(calc);
    var dtpReportDate = $("#dtpReportDate").val();
    $.ajax({
      url: "txtpcountrow.php",
      type: "get",
      cache: false,
      data: {
        id: arr[2],
        itemid: arr[3],
        dtpReportDate: dtpReportDate,
        calc: calc,
        newval: $(this).val(),
        ave: arr[4],
        totss: arr[5]
      },
      success: function (data) {

        let xdata = data.split('|');

        let lblave = ".lblave" + arr[3];

        let mynewdata = xdata[0] * arr[4];
        $("#txtmytotals").html(xdata[0]);
        $("#txtmytotalsover").html(xdata[1]);
        $(lblave).html(mynewdata);

        var optcount = $("#optcount").val();
        var dtpReportDate = $("#dtpReportDate").val();
        var selPhysical = $("#selPhysical").val();
        var selsource = $("#txtsource").val();
        $.ajax({
          url: 'showphysicalcount.php',
          cache: false,
          type: 'get'
          , data: {
            optcount: optcount,
            dtpReportDate: dtpReportDate,
            selPhysical: selPhysical,
            selsource: selsource


          },
          success: function (data) {
            $("#newcontaner").html(data);



          }
        })



        // #lblcount10|10|210|161.85
        // lblcount10|10|210|161.85
        // alert(lblcount);

      }
    });

  })

  $(document).on("click", "#btnsaverppc", function (e) {
    e.preventDefault();
    var selsource = $("#txtsource").val();
    $.ajax({
      url: 'btnsaverppc.php',
      cache: false,
      type: 'get'
      , data: {
        dtpReportDate: $("#dtpReportDate").val(),
        selsource: selsource
      },
      success: function (data) {
        // $("#cnoption").html(data);

        // alert(data);
        if (data == 1) {
          $("#tuklawmodal").html('<div class="alert alert-danger">Physical count Incomplete!</div>');

          $("#tuklawtitle").html('<div style="color:red"> Warning</div>');
          $("#yourtuklaw").modal("show");

        } else {
          $("#tuklawmodal").html('<div class="alert alert-success"> Successfully submited.</div>');

          // $("#tuklawmodal").html(data);
          $("#tuklawtitle").html("Success");
          $("#yourtuklaw").modal("show");
          var optcount = $("#optcount").val();
          var dtpReportDate = $("#dtpReportDate").val();
          var selPhysical = $("#selPhysical").val();
          var selsource = $("#txtsource").val();
          $.ajax({
            url: 'showphysicalcount.php',
            cache: false,
            type: 'get'
            , data: {
              optcount: optcount,
              dtpReportDate: dtpReportDate,
              selPhysical: selPhysical,
              selsource: selsource


            },
            success: function (data) {
              $("#newcontaner").html(data);

            }
          })





        }


      }


    })
  })


  $(document).on("change", ".txtikaw", function (e) {
    e.preventDefault();
    let arr = $(this).val().split("|");

  })
  $(document).on("click", "#T0014", function (e) {
    e.preventDefault();

    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">PHYSICAL COUNT</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'T0014.php',
      cache: false,
      type: 'get',

      success: function (data) {
        $("#frmmodalbody").html(data);

        $.ajax({
          url: 'selphysical2.php',
          cache: false,
          type: 'get'
          , data: { Accid: 1 },
          success: function (data) {
            $("#cnoption").html(data);



          }
        })
      }
    })

  })
  $(document).on("change", "#selPhysical2", function (e) {
    e.preventDefault();
    var Accid = $(this).val();
    $.ajax({
      url: 'selPhysical2.php',
      cache: false,
      type: 'get'
      , data: { Accid: Accid },
      success: function (data) {

        $("#cnoption").html(data);


      }
    })


  })


  $(document).on("click", "#btnshowReports2", function (e) {
    e.preventDefault();


    if ($("#dtpReportDate").val() == "") {
      $("#tuklawmodal").html('<div class="alert alert-danger"> Please select cut-off date.</div>');

      $("#tuklawtitle").html("Warning");
      $("#yourtuklaw").modal("show");
    } else {
      var optcount = $("#optcount").val();
      var dtpReportDate = $("#dtpReportDate").val();
      var selPhysical = $("#selPhysical").val();
      var selsource = $("#txtsource").val();
      $.ajax({
        url: 'showphysicalcountConsolidation.php',
        cache: false,
        type: 'get'
        , data: {
          optcount: optcount,
          dtpReportDate: dtpReportDate,
          selPhysical: selPhysical,
          selsource: selsource


        },
        success: function (data) {
          $("#newcontaner").html(data);



        }
      })


    }

  })


  $(document).on("click", "#btnsavephisical", function (e) {
    e.preventDefault();

    var val = [];

    $('#ad_Checkbox1:checked').each(function (i) {
      val[i] = $(this).val();
    });

    $.ajax({
      url: 'btnsavephisical.php',
      cache: false,
      type: 'get'
      , data: {
        val: val


      },
      success: function (data) {
        alert(data);



      }
    })
  })

  $(document).on("click", "#A0014", function (e) {
    e.preventDefault()
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Menu Sequence</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);

    $.ajax({
      url: 'A0014.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);

      }
    })

  })


  $(document).on("click", "#mcode2", function (e) {
    e.preventDefault();
    $.ajax({
      url: "mcode2.php",
      type: "get",
      cache: false,
      data: { tag: $("#mnutag").val() },
      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });

    $("#myModallist").modal("show");

  })


  $(document).on("click", "#btnimportposition", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'importposition.php',
      type: 'get',

      success: function (data) {
        $("#frmmodalbody").html(data);
      }
    })
  })
  $(document).on("click", ".btnreset", function (e) {
    e.preventDefault();
    var data = $(this).attr("id").split("|");
    //  alert(data[1]); 
    let msg = `<span class="blink"> ****** </span>Are you sure you want to reset the password of <b>  ${data[2]}</b>`;
    let newcon = `<br/> <button class="btn btn-primary" style="margin:10px"> YES</button><button class="btn btn-danger"> No </button>`;

    $("#tuklawmodal").html('<div class="alert alert-danger">' + msg + '  </div>' + newcon);

    $("#tuklawtitle").html("Confirmation");
    $("#yourtuklaw").modal("show");

  })



  $(document).on("click", "#R0015", function (e) {
    e.preventDefault();
    // alert("PSMIS");
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">REPORT ON THE PHYSICAL COUNT OF PPE (RPCPPE)</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);


    $.ajax({
      url: 'R0015.php',
      cache: false,
      type: 'get',

      success: function (data) {
        $("#frmmodalbody").html(data);
      }
    })
  })


  $(document).on("click", ".btnprintpar", function (e) {
    e.preventDefault();
    var savelog = $("#richiedetails").html();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");

    $.ajax({
      url: 'btnprintpar.php',
      type: 'get',
      data: { mydata: arr[1] },
      success: function (data) {
        setInterval(spawnFruit(data), 500);
        $("#richiedetails").html(savelog);
        $.ajax({
          url: 'newppetab.php',
          type: 'get',
          cache: false,
          success: function (data) {
            $("#tabppe").html(data);
          }
        })


      }
    })

  })



  $(document).on("click", ".btnprevics", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'newicsdet.php',
      cache: false,
      type: 'get',
      data: { mydata: $(this).attr("id") },
      success: function (data) {
        $("#tuklawmodal").html(data);

        $("#tuklawtitle").html("Details");
        $("#yourtuklaw").modal("show");
      }
    })
  })
  $(document).on("click", ".btnprevris", function (e) {
    e.preventDefault();

    $.ajax({
      url: 'btnprevris.php',
      cache: false,
      type: 'get',
      data: { mydata: $(this).attr("id") },
      success: function (data) {
        $("#tuklawmodal").html(data);

        $("#tuklawtitle").html("Details");
        $("#yourtuklaw").modal("show");
      }
    })
  })

  $(document).on("click", ".pardet", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id").split("|");

    $.ajax({
      url: 'newpardet.php',
      cache: false,
      type: 'get',
      data: { mydata: mydata[1] },
      success: function (data) {
        $("#tuklawmodal").html(data);

        $("#tuklawtitle").html("Details");
        $("#yourtuklaw").modal("show");
      }
    })



  })



  $(document).on("click", "#A0015", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Agency Profile</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);
    disablemyinput();
    $.ajax({
      url: 'cprofile.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
        disablemyinput();
      }
    });

  })

  $(document).on("click", ".btneditp", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id").split("|");
    // alert(mydata[1]);


    $.ajax({
      url: 'edititem.php',
      cache: false,
      type: 'get',
      data: {
        itemid: mydata[1]
        , propertyno: mydata[2]
      },
      success: function (data) {
        $("#frmmodalbody").html(data);

        // $("#tuklawmodal").html(data);

        // $("#tuklawtitle").html("Edit Delivery Details");
        // $("#yourtuklaw").modal("show");

      }
    })
  })


  // var strform = ' <div class="panel panel-primary">'+
  // '<div class="panel-heading">REPORT ON THE PHYSICAL COUNT OF PPE (RPCPPE)</div>'+
  // '<div class="panel-body" id="frmmodalbody">'+
  //   ' <div id="mnudetails"></div> </div> </div></div>';

  //   $("#richiedetails").html(strform);


  //   $.ajax({
  //     url:'R0015.php',
  //     cache:false,
  //     type:'get',

  //     success:function(data){
  //       $("#frmmodalbody").html(data);
  //     }
  //   })


  $(document).on("click", ".btndelp", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id").split("|");
    $.ajax({
      url: 'Deleteitem.php',
      cache: false,
      type: 'get',
      data: { propertyno: mydata[2] },
      success: function (data) {
        $("#tuklawmodal").html(data);

        $("#tuklawtitle").html("Delete Delivery Details");
        $("#yourtuklaw").modal("show");

      }
    })

  })

  $(document).on("click", ".btnyesdelp", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id").split("|");

    // btnyesdelp

    $.ajax({
      url: 'btnyesdelp.php',
      cache: false,
      type: 'get',
      data: {
        propertyno: mydata[1]

      },
      success: function (response) {

        // alert(response);
        $.ajax({
          url: 'employeerow2.php',
          type: 'get',
          cache: false,
          data: { eidko: eidko },
          success: function (data) {
            $("#ooo5").html(data);
          }
        })
        $("#yourtuklaw").modal("hide");

      }
    })
    // 
  })

  $(document).on("click", "#btnnodelp", function (e) {
    e.preventDefault();
    $("#yourtuklaw").modal("hide");

  })
  $(document).on("click", ".btnsaveedititem", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id").split("|");

    var dtpdateaquired = $("#dtpdateaquired").val();
    var txtamount = $("#txtamount").val();
    var txtdesc = $("#txtdesc").val();
    var txtserial = $("#txtserial").val();
    var txtarticlee = $("#txtarticlee").val();
    $.ajax({
      url: 'saveedititem.php',
      cache: false,
      type: 'get',
      data: {
        propertyno: mydata[1],
        dtpdateaquired: dtpdateaquired,
        txtamount: txtamount,
        txtdesc: txtdesc,
        txtserial: txtserial
        , txtarticlee: txtarticlee
      },
      success: function (data) {

        // alert(eidko);
        $.ajax({
          url: 'employeerow2.php',
          type: 'get',
          cache: false,
          data: { eidko: eidko },
          success: function (data) {
            $("#ooo5").html(data);
          }
        })
        $("#yourtuklaw").modal("hide");

      }
    })
  })
  $(document).on("click", "#btneditLogo", function (e) {
    $(".myinput").attr("disabled", false);

  })



  function uploadLogo() {
    var formData = new FormData($('#fileUploadForm')[0]);


    formData.forEach(function (value, key) {
      console.log(key, value);
    });
    $.ajax({
      url: 'uploadLogo.php',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        alert(response);
      }
    });

  }



  $("#form").on('submit', (function (e) {
    e.preventDefault();
    $.ajax({
      url: "uploadLogo.php",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      beforeSend: function () {
        //$("#preview").fadeOut();
        $("#err").fadeOut();
      },
      success: function (data) {
        if (data == 'invalid') {
          // invalid file format.
          $("#err").html("Invalid File !").fadeIn();
        }
        else {
          // view uploaded file.
          $("#preview").html(data).fadeIn();
          //  $("#form")[0].reset(); 
        }
      },
      error: function (e) {
        $("#err").html(e).fadeIn();
      }
    });
  }));


  $(document).on("change", "#uploadImagelogo", function (e) {
    var file = this.files[0];

    if (file) {

      var reader = new FileReader();
      reader.onload = function (e) {

        $("#logoimageko").attr("src", e.target.result);

      };
      reader.readAsDataURL(file);
    } else {

      $("#logoimageko").attr("src", "");
    }
  })


  $(document).on("click", "#A0016", function (e) {
    e.preventDefault();
    var strform = ' <div class="panel panel-primary">' +
      '<div class="panel-heading">Capitalization Treshold</div>' +
      '<div class="panel-body" id="frmmodalbody">' +
      ' <div id="mnudetails"></div> </div> </div></div>';

    $("#richiedetails").html(strform);
 
    $.ajax({
      url: 'Capitalization.php',
      cache: false,
      type: 'get',
      success: function (data) {
        $("#frmmodalbody").html(data);
     
      }
    });
  })

  $(document).on('click','#txtaccounttitleTresh',function(e){
    e.preventDefault();
    $.ajax({
      url: "TresHaccountTitle.php",
      type: "get",
      cache: false,
      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });

    $("#myModallist").modal("show");

  })
  $(document).on("click", "#txtarticlee", function (e) {
    $.ajax({
      url: "newlistofequipment.php",
      type: "get",
      data: { mnuasset: $("#txtaccount").val() },
      cache: false,
      success: function (data) {
        $("#richielistmodal").html(data);
      }
    });

    $("#myModallist").modal("show");
  })

  $(document).on("click", ".itemroweqxs", function (e) {
    e.preventDefault();

    var mydata = $(this).attr("id");

    var arr = mydata.split("|");
    editbtnid = arr[0];
    // alert(arr[1]);

    $("#txtaccount").val(arr[1]);
    $("#txtarticlee").val(arr[2]);
    $("#txtestimated").val(arr[3]);
    if (arr[1] == "Motor Vehicles") {
      $("#txtchasis").removeClass("richiehide");

      $("#txtengine").attr("placeholder", "Engine Number");
    } else if (arr[1] == "Motor Vehicle") {
      $("#txtchasis").removeClass("richiehide");

      $("#txtengine").attr("placeholder", "Engine Number");


    } else {
      $("#txtchasis").addClass("richiehide");
      $("#txtengine").attr("placeholder", "Serial Number");
    }

    $("#myModallist").modal("hide");
  })
})




