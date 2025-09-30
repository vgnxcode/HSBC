$(window).on('load', function() {
var session = Math.random();
var request_step = 0;

var accessToken = "01b686f55f3e471e8c11ca388dad1045";
var baseUrl = "https://api.api.ai/v1/";


var mob_chat = '';
var ctrcode_chat = '';
var email_chat = '';
var proj_chat = '';
var cust_name_chat = '';
var loc_chat = '';
var budj_range_chat = '';

var aa = 0;
var bb = 0;
var cc = 0;
var dd = 0;
var ee = 0;
var ff = 0;
var gg = 0;

var touched = 0;
setTimeout(function () {

  if(touched == '0'){
  $("#chtbtn").trigger("click");
}
},4000);

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
  aa = 0;
  bb = 0;
  cc = 0;
  dd = 0;
  ee = 0;
  ff = 0;
  gg = 0;

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

var typeloader=`  <p class="typeloader" style="clear:both;"><img class="responsive-img" src="//d2qetrl79qxrcm.cloudfront.net/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"><img class="responsive-img" src="//d2qetrl79qxrcm.cloudfront.net/images/vgnchatbot/loading_dots.gif" width="30" style="margin-top: -1px;"></p>`;

$("#chatIcon").on("click", function (event) {
  touched = 1;
  event.preventDefault();
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

    $(".typeloader").append(typeloader);

    $.ajax({
      type: "POST",
      url: baseUrl + "query?v=20150910",
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      headers: {
        "Authorization": "Bearer " + accessToken
      },
      data: JSON.stringify({ query: text, lang: "en", sessionId: ''+session+'' }),

      success: function(data) {
        console.log(data);
        var ndata = data;
        
        ndata = ndata.result.fulfillment.messages[0]['speech'];
        
      var divtest = ` <p class="bot_chat"><img class="responsive-img" src="//d2qetrl79qxrcm.cloudfront.net/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${ndata}</p>`;
      $(".conversation").append(divtest);
      $(".typeloader").remove();

      $("#one").show();
      $("#two").hide();
      $("#three").hide();
      $("#four").hide();
      $("#five").hide();
      $("#six").hide();

      },
      error: function() {
        $(".conversation").append("Internal Server Error");
      }
    });


    $(".vgnchatbot").css('display', 'block');
    request_step = 1;
    $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');
  }
});






$("#btn_click").on('click', function (event) {
  event.preventDefault();
  
  
  
  var usr_typed_txt = $("#typing_text").val();
  if (request_step == 1) {


    if (usr_typed_txt != '') {

      
      var ipText = $("#typing_text").val();
      cust_name_chat = usr_typed_txt;
     $(".conversation").append(typeloader);
     $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');
      $.ajax({
        type: "POST",
        url: baseUrl + "query?v=20150910",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
          "Authorization": "Bearer " + accessToken
        },
        data: JSON.stringify({ query: ipText, lang: "en", sessionId: ''+session+'' }),
  
        success: function(data) {
      aa += 1;
      if(aa == '1'){
          $(".conversation").append(`<p class="usr_response"><span class="badge_css red" >` + usr_typed_txt + `</span></p>`);
      
      console.log('inside response = '+aa);
          var ndata = data;
          
          ndata = ndata.result.fulfillment.messages[0]['speech'];
          ndata = JSON.parse(ndata);
          var divtest = ` <p class="bot_chat"><img class="responsive-img" src="//d2qetrl79qxrcm.cloudfront.net/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${ndata.message}</p>`;
          $(".conversation").append(divtest);
          $(".typeloader").remove();
          if (ndata.number == "number") {
            $(".vgnchatbot .select-dropdown").remove();
            $(".vgnchatbot .select-wrapper svg").remove();
            $(".vgnchatbot #countrycode").addClass('defineblock');
  
            $("#one").hide();
            $("#two").show();
            $("#three").hide();
            $("#four").hide();
            $("#five").hide();
            $("#six").hide();
            request_step = 2;
            $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');
  
  
          }
      }
  
        },
        error: function() {
          $(".conversation").append("Internal Server Error");
        }
      });



    }

  }

});




$("#btn_click1").on('click', function (event) {
  event.preventDefault();
  
  var usr_typed_txt = $("#typing_text1").val();
  var countrycode = $("#countrycode").val();
  var filter = /^[0-9]+$/;
  var mobpass = false;
  
  if (filter.test(usr_typed_txt) == false) {
    var error1 = ` <p class="bot_chat"><img class="responsive-img" src="//d2qetrl79qxrcm.cloudfront.net/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> `+cust_name_chat+`, Please Enter your 10 digit mobile number.</p>`;
    $(".conversation").append(error1);
    mobpass = false;
  }
  else {
    if (usr_typed_txt.length == 10) {
      mobpass = true;
    } else {
      var error1 = ` <p class="bot_chat"><img class="responsive-img" src="//d2qetrl79qxrcm.cloudfront.net/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> `+cust_name_chat+`, Please Enter your 10 digit mobile number.</p>`;
      $(".conversation").append(error1);
      mobpass = false;
    }
  }
  
  if ((request_step == 2) && (mobpass === true)) {


    if (usr_typed_txt != '') {
     
      mob_chat = countrycode + usr_typed_txt;
      ctrcode_chat = countrycode;
$(".conversation").append(typeloader);
$(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');
      $.ajax({
        type: "POST",
        url: baseUrl + "query?v=20150910",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
          "Authorization": "Bearer " + accessToken
        },
        data: JSON.stringify({ query: mob_chat, lang: "en", sessionId: ''+session+'' }),
  
        success: function(data) {
      bb += 1;
      if(bb == '1'){
         $(".conversation").append(`<p class="usr_response"><span class="badge_css red" >` + countrycode + ' ' + usr_typed_txt + `</span></p>`);
         $(".typeloader").remove();
          var ndata = data;
          ndata = ndata.result.fulfillment.messages[0]['speech'];
          console.log(ndata);
          ndata = JSON.parse(ndata);
          var divtest = ` <p class="bot_chat"><img class="responsive-img" src="//d2qetrl79qxrcm.cloudfront.net/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${ndata.message}</p>`;
          $(".conversation").append(divtest);
          if (ndata['pills'] != undefined) {



            var Options = "";
            for (var i = 0; i < ndata.pills.length; i++) {
  
              Options = Options + "<li class='projecttypebadge' data-badge-caption='" + ndata.pills[i] + "'>" + ndata.pills[i] + "</li>";
            }
  
            $(".conversation").append(`<p class="bot_chat"><ul class="newultagbtn"> ${Options}</ul></p>`);
  
            $("#one").hide();
            $("#two").hide();
            $("#three").hide();
            $("#four").show();
            $("#five").hide();
            $("#six").hide();
            request_step = 2.1;
            $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');
  
          }
         
          
    }
        },
        error: function() {
          $(".conversation").append("Internal Server Error");
        }
      });



    }

  }

});



$("#vgnchatbot").on('click', '.projecttypebadge', function (event) {
  event.preventDefault();

  var projecttype_intrested = $(this).attr('data-badge-caption');
  if ((projecttype_intrested != '') && (request_step == '2.1')) {

    
    var ipText = projecttype_intrested;
    projtype_chat = projecttype_intrested;

$(".conversation").append(typeloader);
$(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');
    $.ajax({
      type: "POST",
      url: baseUrl + "query?v=20150910",
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      headers: {
        "Authorization": "Bearer " + accessToken
      },
      data: JSON.stringify({ query: projtype_chat, lang: "en", sessionId: ''+session+'' }),

      success: function(data) {
      cc += 1;
      if(cc == '1'){
        $(".typeloader").remove();
        $(".conversation").append(`<p class="usr_response"><span class="badge_css red" data-badge-caption="` + projecttype_intrested + `">` + projecttype_intrested + `</span></p>`);
        var ndata = data;
        ndata = ndata.result.fulfillment.messages[0]['speech'];
        
        ndata = JSON.parse(ndata);
        var divtest = ` <p class="bot_chat"><img class="responsive-img" src="//d2qetrl79qxrcm.cloudfront.net/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${ndata.message}</p>`;
        $(".conversation").append(divtest);
        if (ndata['pills'] != undefined) {



          var Options = "";

          for (var i = 0; i < ndata.pills.length; i++) {

            Options = Options + "<li class='budgetbadge' data-badge-caption='" + ndata.pills[i] + "'>" + ndata.pills[i] + "</li>";
          }

          $(".conversation").append(`<div class="bot_chat"><ul class="newultagbtn"> ${Options}</ul></div>`);

          $("#one").hide();
          $("#two").hide();
          $("#three").hide();
          $("#four").show();
          $("#five").hide();
          $("#six").hide();
          request_step = 3;
          $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 1000);

        }
       
        
    }
      },
      error: function() {
        $(".conversation").append("Internal Server Error");
      }
    });


  }
});



$("#vgnchatbot").on('click', '.budgetbadge', function (event) {
  event.preventDefault();

  var budget_intrested = $(this).attr('data-badge-caption');
  if ((budget_intrested != '') && (request_step == '3')) {
    
    var ipText = budget_intrested;
    budj_range_chat = budget_intrested;
$(".conversation").append(typeloader);
$(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');

    $.ajax({
      type: "POST",
      url: baseUrl + "query?v=20150910",
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      headers: {
        "Authorization": "Bearer " + accessToken
      },
      data: JSON.stringify({ query: budj_range_chat, lang: "en", sessionId: ''+session+'' }),

      success: function(data) {
      dd += 1;
      if(dd == '1'){
        $(".typeloader").remove();
        $(".conversation").append(`<p class="usr_response"><span class="badge_css red"  data-badge-caption="` + budget_intrested + `">` + budget_intrested + `</span></p>`);
        var ndata = data;
        ndata = ndata.result.fulfillment.messages[0]['speech'];
        ndata = JSON.parse(ndata);
        var divtest = ` <p class="bot_chat"><img class="responsive-img" src="//d2qetrl79qxrcm.cloudfront.net/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${ndata.message}</p>`;
        $(".conversation").append(divtest);
       
        if (ndata['drop_down'] != undefined) {
          $("#location_chat").children().remove();
          $(".vgnchatbot #location_chat").addClass('defineblock');
          var Options = "<option value=''>Location</option>";
          for (var i = 0; i < ndata.drop_down.length; i++) {

            Options = Options + "<option value='" + ndata.drop_down[i] + "'>" + ndata.drop_down[i] + "</option>";
          }

          $(".vgnchatbot #location_chat").append(Options);

          $("#one").hide();
          $("#two").hide();
          $("#three").show();
          $("#four").hide();
          $("#five").hide();
          $("#six").hide();
          request_step = 4;
          $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');

        }
        
       
      }

      },
      error: function() {
        $(".conversation").append("Internal Server Error");
      }
    });


    
  }


});




$("#btn_click2").on('click', function (event) {
  event.preventDefault();
  var usr_typed_txt = $("#location_chat").val();

  if (request_step == 4) {

    if (usr_typed_txt != '') {
      
      var ipText = $("#location_chat").val();
      loc_chat = usr_typed_txt;
$(".conversation").append(typeloader);
$(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');

      $.ajax({
        type: "POST",
        url: baseUrl + "query?v=20150910",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
          "Authorization": "Bearer " + accessToken
        },
        data: JSON.stringify({ query: loc_chat, lang: "en", sessionId: ''+session+'' }),
  
        success: function(data) {
      ee += 1;
      if(ee == '1'){
        $(".typeloader").remove();
        $(".conversation").append(`<p class="usr_response"><span class="badge_css red" >` + usr_typed_txt + `</span></p>`);
          var ndata = data;
          ndata = ndata.result.fulfillment.messages[0]['speech'];
          
          ndata = JSON.parse(ndata);
          var divtest = ` <p class="bot_chat"><img class="responsive-img" src="//d2qetrl79qxrcm.cloudfront.net/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${ndata.message}</p>`;
          $(".conversation").append(divtest);
          if (ndata['pills'] != undefined) {
  
  
  
            var Options = "";
            for (var i = 0; i < ndata.pills.length; i++) {
  
              Options = Options + "<li class='projectbadge' data-badge-caption='" + ndata.pills[i] + "'>" + ndata.pills[i] + "</li>";
            }
  
            $(".conversation").append(`<p class="bot_chat"><ul class="newultagbtn">${Options}</ul></p>`);
  
            $("#one").hide();
            $("#two").hide();
            $("#three").hide();
            $("#four").show();
            $("#five").hide();
            $("#six").hide();
            request_step = 5;
            $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');
  
          }
         
      }
  
        },
        error: function() {
          $(".conversation").append("Internal Server Error");
        }
      });

      
    }

  }

});


$("#vgnchatbot").on('click', '.projectbadge', function (event) {
  event.preventDefault();

  var project_intrested = $(this).attr('data-badge-caption');
  if ((project_intrested != '') && (request_step == '5')) {
    
    var ipText = project_intrested;
    proj_chat = project_intrested;
$(".conversation").append(typeloader);
$(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');

    $.ajax({
      type: "POST",
      url: baseUrl + "query?v=20150910",
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      headers: {
        "Authorization": "Bearer " + accessToken
      },
      data: JSON.stringify({ query: proj_chat, lang: "en", sessionId: ''+session+'' }),

      success: function(data) {
        ff += 1;
      if(ff == '1'){
        $(".typeloader").remove();
        $(".conversation").append(`<p class="usr_response"><span class="badge_css red" data-badge-caption="` + project_intrested + `">` + project_intrested + `</span></p>`);
        var ndata = data;
        nndata = ndata.result.fulfillment['speech'];
        console.log(nndata);
        
        

        if (ndata.result.fulfillment['speech'] == undefined) {
          var anothertext = ` <p class="bot_chat"><img class="responsive-img" src="//d2qetrl79qxrcm.cloudfront.net/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${nndata}</p>`;
          $(".conversation").append(anothertext);
          $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 1000);
  
        }
        else {
          var divtest1 = ` <p class="bot_chat"><img class="responsive-img" src="//d2qetrl79qxrcm.cloudfront.net/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${nndata}</p>`;
          $(".conversation").append(divtest1);

          $("#one").hide();
          $("#two").hide();
          $("#three").hide();
          $("#four").hide();
          $("#five").show();
          $("#six").hide();
          request_step = 6;
          $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');

          
        }
        
       
      }

      },
      error: function() {
        $(".conversation").append("Internal Server Error");
      }
    });



    


  }


});






$("#btn_click3").on('click', function (event) {
  event.preventDefault();
  var usr_typed_txt = $("#typing_text2").val();

  if (request_step == 6) {

    if (usr_typed_txt != '') {
      //$(".conversation").append('<p class="usr_response">'+usr_typed_txt+'</p>');
      
      var ipText = $("#typing_text2").val();
      email_chat = usr_typed_txt;
      //ipText
      $(".conversation").append(typeloader);
      $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');

      $.ajax({
        type: "POST",
        url: baseUrl + "query?v=20150910",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        headers: {
          "Authorization": "Bearer " + accessToken
        },
        data: JSON.stringify({ query: email_chat, lang: "en", sessionId: ''+session+'' }),
  
        success: function(data) {
        gg += 1;
      if(gg == '1'){
        $(".typeloader").remove();
        $(".conversation").append(`<p class="usr_response"><span class="badge_css red" data-badge-caption="` + usr_typed_txt + `">` + usr_typed_txt + `</span></p>`);
          var ndata = data;
          ndata = ndata.result.fulfillment.messages[0]['speech'];
          

          if (ndata == undefined) {
            var anothertext = ` <p class="bot_chat"><img class="responsive-img" src="//d2qetrl79qxrcm.cloudfront.net/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> Please enter a valid emailid.</p>`;
            $(".conversation").append(anothertext);
            $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');
          }
          else {
            ndata = JSON.parse(ndata);  
            var divtest1 = ` <p class="bot_chat"><img class="responsive-img" src="//d2qetrl79qxrcm.cloudfront.net/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> ${ndata.message}</p>`;
            $(".conversation").append(divtest1);
  
            if (ndata.end != undefined) {
  
              $("#one").hide();
              $("#two").hide();
              $("#three").hide();
              $("#four").hide();
              $("#five").hide();
              $("#six").show();
              request_step = 0;
  
              $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');
  
            }
          }
         
      }
  
        },
        error: function() {
          $(".conversation").append("Internal Server Error");
        }
      });



      


    }

  }

});

});