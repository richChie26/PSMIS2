
$(document).ready(function () {
  jQuery.noConflict();

  $("#btnlogin").click(function (e) {
    e.preventDefault();

    $.ajax({
      url: 'login.php',
      method: "GET",
      data: { username: $("#username").val(), password: $("#password").val() },
      cache: false,
      success: function (data) {

        // window.location='index.html';
        // alert(data);


        if (data == 1) {
          window.location = 'home.html';
        } else {
          alert("Account Information could not found!");
          // window.location='index.html';
        }

      }
    });
  })

  $(document).on("click", ".btnunitsremove", function (e) {
    e.preventDefault();

    var mydata = $(this).attr("id");

    var arr = mydata.split("|");

    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to delete <strong >" + arr[1] + "</strong>?</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnyesunits" id="btnyesunits" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");

  })

  $(document).on("click", ".btnsupplyremove", function (e) {
    e.preventDefault();

    var mydata = $(this).attr("id");

    var arr = mydata.split("|");

    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to delete <strong >" + arr[1] + "</strong> as Supplier?  .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnyessupp" id="btnyessupp" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");

  })
  $(document).on("click", ".btnrcremove", function (e) {
    e.preventDefault();

    var mydata = $(this).attr("id");

    var arr = mydata.split("|");

    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to delete <strong >" + arr[1] + "</strong> as Responsibility Center?  .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnyesrc" id="btnyesrc" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");

  })

  $(document).on("click", ".btnremoveitemname", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");

    var arr = mydata.split("|");

    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to delete <strong >" + arr[1] + "</strong> as Item Name?  .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnitemnameyes" id="btnitemnameyes" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");
  })
  $(document).on("click", ".btntitleremove", function (e) {
    e.preventDefault();

    var mydata = $(this).attr("id");

    var arr = mydata.split("|");

    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to delete <strong >" + arr[1] + "</strong> as Account Title?  .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnyestitle" id="btnyestitle" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");
  })
  $(document).on("click", ".bntmatremove", function (e) {
    e.preventDefault();

    var mydata = $(this).attr("id");

    var arr = mydata.split("|");

    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to delete <strong >" + arr[1] + "</strong> as Materials?  .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnyesmat" id="btnyesmat" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");
  })


  $(document).on("click", ".btnreceivedremove", function (e) {
    e.preventDefault();

    var mydata = $(this).attr("id");

    var arr = mydata.split("|");

    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to delete <strong >" + arr[1] + "</strong> as item to receive??  .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnyesreceive" id="btnyesreceive" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");

  })

  $(document).on("click", ".btnrequestremove", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");

    var arr = mydata.split("|");

    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to delete <strong >" + arr[1] + "</strong> as item to request??  .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnreqyes" id="btnreqyes" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");
  })


  $(document).on("click", ".btnclusterremove", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");

    var arr = mydata.split("|");

    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to delete <strong >" + arr[1] + "</strong> as Fund Category?  .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnyescluster" id="btnyescluster" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");
  })

  $(document).on("click", ".btnremovesimeppe", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");

    var arr = mydata.split("|");

    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to delete <strong >" + arr[1] + "</strong> .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnyesremovesemippe" id="btnyesremovesemippe" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");
  })


  $(document).on("click", ".btnremovemyppedetails", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");

    var arr = mydata.split("|");

    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to remove <strong >" + arr[1] + "</strong> .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid" value="' + arr[0] + '">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnremsemippeyes" id="btnremsemippeyes" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");
  })
  $(document).on("click", ".btntempptrremove", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to remove <strong >" + arr[1] + "</strong> .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnremoveptrtemp" id="btnremoveptrtemp" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");
  })
  $(document).on("click", ".btnsectiondel", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to remove <strong >" + arr[1] + "</strong> .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btndelsection" id="btndelsection" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");
  })

  $(document).on("click", ".btndivisiondel", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to remove <strong >" + arr[1] + "</strong> .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnyesdeldivision" id="btnyesdeldivision" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");
  })


  $(document).on("click", ".btnremovemyppe", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to remove <strong >" + arr[1] + "</strong> .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnremoveppeki" id="btnremoveppeki" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");
  })
  $(document).on("click", ".btnremovemanual", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to remove <strong >" + arr[1] + "</strong> .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnremovenewmanual" id="btnremovenewmanual" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");
  })


  $(document).on("click", ".btnremovemanualsemi", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to remove <strong >" + arr[1] + "</strong> .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btnremovenewmanualsemi" id="btnremovenewmanual" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");
  })
  $(document).on("click", ".btnpositiondel", function (e) {
    e.preventDefault();
    var mydata = $(this).attr("id");
    var arr = mydata.split("|");
    var myalert = "<div class='alert alert-danger'><strong class='blink'> **** </strong><strong>Confirmation! </strong>Are you sure you want to remove <strong >" + arr[1] + "</strong> .</div>"
    $("#errmsgconf1").html(myalert);
    var str = '   <form id="frmdelmenu">' +

      '<input type="hidden" name="btnid" id="btnid">' +
      '<div class="row">' +
      ' <div class="col-xs-2">' +
      '<input type="submit" name="btndelposition" id="btndelposition" value="YES" class="btn btn-primary btn-block btn-flat"></div>' +
      '<div class="col-xs-2">' +
      '<input type="submit" name="btnnoacct" id="btnnoacct" value="NO" class="btn btn-danger btn-block btn-flat"></div>' +
      '</div>' +
      '</form>';

    $("#richiemodal").html(str);
    $("#btnid").val(arr[0]);
    $("#myModalconfirm").modal("show");
  })
})