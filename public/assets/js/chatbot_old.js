var session = Math.random();
var request_step = 0;



var mob_chat = '';
var ctrcode_chat = '';
var email_chat = '';
var proj_chat = '';
var cust_name_chat = '';
var loc_chat = '';
var budj_range_chat = '';

$(".refresh_page").on('click', function () {
  location.reload();
});
$(".chat_close").on('click', function () {
  $(".vgnchatbot").css('display', 'none');
  $(".conversation").empty();
  request_step = 0;
  session = Math.random();
  mob_chat = '';
  ctrcode_chat = '';
  email_chat = '';
  proj_chat = '';
  cust_name_chat = '';
  loc_chat = '';
  budj_range_chat = '';

});


$('.text_chat').keypress(function (event) {
  var keycode = (event.keyCode ? event.keyCode : event.which);
  if (keycode == '13') {
    var idclicked = $(this).attr('id');
    if (idclicked == 'typing_text') {
      $("#btn_click").trigger('click');
    }
    if (idclicked == 'typing_text1') {
      $("#btn_click1").trigger('click');
    }
    if (idclicked == 'typing_text2') {
      $("#btn_click3").trigger('click');
    }

  }
});




$("#one").hide();
$("#two").hide();
$("#three").hide();
$("#four").hide();
$("#five").hide();
$("#six").hide();

$("#chatIcon").on("click", function () {
  $(".conversation").empty();
  $("#typing_text").val('');
  $("#typing_text1").val('');
  $("#typing_text2").val('');
  request_step = 0;
  session = Math.random();
  mob_chat = '';
  ctrcode_chat = '';
  email_chat = '';
  proj_chat = '';
  cust_name_chat = '';
  loc_chat = '';
  budj_range_chat = '';
  if (request_step == 0) {
    $(".conversation").empty();

    var text = "hi";




    $.get("https://vgn-chat-lyrjtx.appspot.com/intent", { "_token": "{{ csrf_token() }}",'qt': text, 'qs': session }, function (data) {
console.log(data);
      var divtest = ` <p class="bot_chat"><img class="responsive-img" src="/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${data}</p>`;
      $(".conversation").append(divtest);
      $("#one").show();
      $("#two").hide();
      $("#three").hide();
      $("#four").hide();
      $("#five").hide();
      $("#six").hide();

    });

    $(".vgnchatbot").css('display', 'block');
    request_step = 1;
    $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 1000);
  }
});



$("#btn_click").on('click', function () {
  var usr_typed_txt = $("#typing_text").val();
  if (request_step == 1) {


    if (usr_typed_txt != '') {
      //$(".conversation").append('<p class="usr_response">'+usr_typed_txt+'</p>');
      $(".conversation").append(`<p class="usr_response"><span class="badge_css red" >` + usr_typed_txt + `</span></p>`);
      var ipText = $("#typing_text").val();
      cust_name_chat = usr_typed_txt;
      //ipText
      $.post("https://vgn-chat-lyrjtx.appspot.com/intent", { 'text': ipText, 'ptext': '', 'session': session }, function (data) {
        //var datanew1 = JSON.parse(data);


        var divtest1 = ` <p class="bot_chat"><img class="responsive-img" src="/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${data.message}</p>`;
        $(".conversation").append(divtest1);

        if (data.number == "number") {
          $(".vgnchatbot .select-dropdown").remove();
          $(".vgnchatbot #countrycode").addClass('defineblock');

          $("#one").hide();
          $("#two").show();
          $("#three").hide();
          $("#four").hide();
          $("#five").hide();
          $("#six").hide();
          request_step = 2;
          $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 1000);


        }
      });


    }

  }

});



$("#btn_click1").on('click', function () {
  var usr_typed_txt = $("#typing_text1").val();
  var countrycode = $("#countrycode").val();
  var filter = /^\d*(?:\.\d{1,2})?$/;
  var mobpass = false;
  if (filter.test(usr_typed_txt) == false) {
    var error1 = ` <p class="bot_chat"><img class="responsive-img" src="/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> Please Enter a valid mobile number.</p>`;
    $(".conversation").append(error1);
    mobpass = false;
  }
  else {
    if (usr_typed_txt.length == 10) {
      mobpass = true;
    } else {
      var error1 = ` <p class="bot_chat"><img class="responsive-img" src="/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> Please Enter 10 digit mobile number.</p>`;
      $(".conversation").append(error1);
      mobpass = false;
    }
  }

  if ((request_step == 2) && (mobpass === true)) {


    if (usr_typed_txt != '') {

      //$(".conversation").append('<p class="usr_response">'+countrycode+' '+usr_typed_txt+'</p>');
      $(".conversation").append(`<p class="usr_response"><span class="badge_css red" >` + countrycode + ' ' + usr_typed_txt + `</span></p>`);
      mob_chat = countrycode + usr_typed_txt;
      ctrcode_chat = countrycode;

      var ipText = $("#typing_text1").val();

      //ipText
      $.post("https://vgn-chat-lyrjtx.appspot.com/intent", { 'text': '', 'ptext': mob_chat, 'session': session }, function (data) {
        //var datanew1 = JSON.parse(data);


        var divtest1 = ` <p class="bot_chat"><img class="responsive-img" src="/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${data.message}</p>`;
        $(".conversation").append(divtest1);

        if (data['drop_down'] != undefined) {
          $(".vgnchatbot .select-dropdown").remove();
          $(".vgnchatbot #location_chat").addClass('defineblock');




          $("#one").hide();
          $("#two").hide();
          $("#three").show();
          $("#four").hide();
          $("#five").hide();
          $("#six").hide();
          request_step = 3;
          $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 1000);

        }
      });


    }

  }

});



$("#btn_click2").on('click', function () {
  var usr_typed_txt = $("#location_chat").val();

  if (request_step == 3) {

    if (usr_typed_txt != '') {
      //$(".conversation").append('<p class="usr_response">'+usr_typed_txt+'</p>');
      $(".conversation").append(`<p class="usr_response"><span class="badge_css red" >` + usr_typed_txt + `</span></p>`);
      var ipText = $("#location_chat").val();
      loc_chat = usr_typed_txt;
      //ipText
      $.post("https://vgn-chat-lyrjtx.appspot.com/intent", { 'text': ipText, 'ptext': '', 'session': session }, function (data) {
        //var datanew1 = JSON.parse(data);


        var divtest1 = ` <p class="bot_chat"><img class="responsive-img" src="/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${data.message}</p>`;
        $(".conversation").append(divtest1);
        if (data['pills'] != undefined) {



          var Options = "";
          for (var i = 0; i < data.pills.length; i++) {

            Options = Options + "<span class='projectbadge botbadge_css' data-badge-caption='" + data.pills[i] + "'>" + data.pills[i] + "</span>";
          }

          $(".conversation").append(`<p class="bot_chat"><img class="responsive-img" src="/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${Options}</p>`);

          $("#one").hide();
          $("#two").hide();
          $("#three").hide();
          $("#four").show();
          $("#five").hide();
          $("#six").hide();
          request_step = 4;
          $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 1000);

        }
      });


    }

  }

});


$("#vgnchatbot").on('click', '.projectbadge', function () {

  var project_intrested = $(this).attr('data-badge-caption');
  if ((project_intrested != '') && (request_step == '4')) {

    // $(".conversation").append('<p class="usr_response">'+project_intrested+'</p>');
    $(".conversation").append(`<p class="usr_response"><span class="badge_css red" data-badge-caption="` + project_intrested + `">` + project_intrested + `</span></p>`);
    var ipText = project_intrested;
    proj_chat = project_intrested;

    //ipText
    $.post("https://vgn-chat-lyrjtx.appspot.com/intent", { 'text': ipText, 'ptext': '', 'session': session }, function (data) {
      //var datanew1 = JSON.parse(data);

      if (data['message'] == undefined) {
        var anothertext = ` <p class="bot_chat"><img class="responsive-img" src="/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${data}</p>`;
        $(".conversation").append(anothertext);
        $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 1000);

      }
      else {
        var divtest1 = ` <p class="bot_chat"><img class="responsive-img" src="/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${data.message}</p>`;
        $(".conversation").append(divtest1);
        if (data['pills'] != undefined) {

          var Options = "";
          for (var i = 0; i < data.pills.length; i++) {

            Options = Options + "<span class='budgetbadge botbadge_css' data-badge-caption='" + data.pills[i] + "'>" + data.pills[i] + "</span>";
          }

          $(".conversation").append(`<p class="bot_chat"><img class="responsive-img" src="/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${Options}</p>`);

          $("#one").hide();
          $("#two").hide();
          $("#three").hide();
          $("#four").show();
          $("#five").hide();
          $("#six").hide();
          request_step = 5;
          $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 1000);

        }
      }

    });


  }


});


$("#vgnchatbot").on('click', '.budgetbadge', function () {

  var budget_intrested = $(this).attr('data-badge-caption');
  if ((budget_intrested != '') && (request_step == '5')) {

    // $(".conversation").append('<p class="usr_response">'+budget_intrested+'</p>');
    $(".conversation").append(`<p class="usr_response"><span class="badge_css red"  data-badge-caption="` + budget_intrested + `">` + budget_intrested + `</span></p>`);
    var ipText = budget_intrested;
    budj_range_chat = budget_intrested;



    //ipText
    $.post("https://vgn-chat-lyrjtx.appspot.com/intent", { 'text': ipText, 'ptext': '', 'session': session }, function (data) {
      //var datanew1 = JSON.parse(data);


      var divtest1 = ` <p class="bot_chat"><img class="responsive-img" src="/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${data}</p>`;
      $(".conversation").append(divtest1);


      $("#one").hide();
      $("#two").hide();
      $("#three").hide();
      $("#four").hide();
      $("#five").show();
      $("#six").hide();
      request_step = 6;
      $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 1000);




    });


  }


});



$("#btn_click3").on('click', function () {
  var usr_typed_txt = $("#typing_text2").val();

  if (request_step == 6) {

    if (usr_typed_txt != '') {
      //$(".conversation").append('<p class="usr_response">'+usr_typed_txt+'</p>');
      $(".conversation").append(`<p class="usr_response"><span class="badge_css red" data-badge-caption="` + usr_typed_txt + `">` + usr_typed_txt + `</span></p>`);
      var ipText = $("#typing_text2").val();
      email_chat = usr_typed_txt;
      //ipText

      $.post("https://vgn-chat-lyrjtx.appspot.com/intent", { 'text': ipText, 'ptext': mob_chat, 'session': session }, function (data) {
        //var datanew1 = JSON.parse(data);

        if (data['message'] == undefined) {
          var anothertext = ` <p class="bot_chat"><img class="responsive-img" src="/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${data}</p>`;
          $(".conversation").append(anothertext);
          $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 1000);
        }
        else {
          var divtest1 = ` <p class="bot_chat"><img class="responsive-img" src="/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${data.message}</p>`;
          $(".conversation").append(divtest1);

          if (data['end'] != undefined) {

            $("#one").hide();
            $("#two").hide();
            $("#three").hide();
            $("#four").hide();
            $("#five").hide();
            $("#six").show();
            request_step = 0;

            $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 1000);

          }
        }


      });


    }

  }

});