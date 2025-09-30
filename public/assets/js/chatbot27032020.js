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

var typeloader=`  <p class="typeloader" style="clear:both;"><img class="responsive-img" src="//cdn.vgn.in/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"><img class="responsive-img" src="//cdn.vgn.in/images/vgnchatbot/loading_dots.gif" width="30" style="margin-top: -1px;"></p>`;

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


    $(".typeloader").append(typeloader);

    var divtest = ` <p class="bot_chat"><img class="responsive-img" src="//cdn.vgn.in/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> Hi, I'm your VGN Assistant. May I know your name please?</p>`;
      $(".conversation").append(divtest);
      $(".typeloader").remove();

      $("#one").show();
      $("#two").hide();
      $("#three").hide();
      $("#four").hide();
      $("#five").hide();
      $("#six").hide();

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
      console.log(cust_name_chat);
      $.post('/api/vgncustomchatreq/acceptname', {name: cust_name_chat,session:session}, function(data){
      	if (data != 0) {
      		 aa += 1;
      if(aa == '1'){
          $(".conversation").append(`<p class="usr_response"><span class="badge_css red" >` + usr_typed_txt + `</span></p>`);
          
          var divtest = ` <p class="bot_chat"><img class="responsive-img" src="//cdn.vgn.in/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> `+data+`</p>`;
          $(".conversation").append(divtest);
          $(".typeloader").remove();

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
      	else{
      	  var divtest = ` <p class="bot_chat"><img class="responsive-img" src="//cdn.vgn.in/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> Please enter a valid text.</p>`;
          $(".conversation").append(divtest);
          $(".typeloader").remove();
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
    var error1 = ` <p class="bot_chat"><img class="responsive-img" src="//cdn.vgn.in/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> `+cust_name_chat+`, Please Enter your 10 digit mobile number.</p>`;
    $(".conversation").append(error1);
    mobpass = false;
  }
  else {
    if (usr_typed_txt.length == 10) {
      mobpass = true;
    } else {
      var error1 = ` <p class="bot_chat"><img class="responsive-img" src="//cdn.vgn.in/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> `+cust_name_chat+`, Please Enter your 10 digit mobile number.</p>`;
      $(".conversation").append(error1);
      mobpass = false;
    }
  }
  
  if ((request_step == 2) && (mobpass === true)) {


    if (usr_typed_txt != '') {

      //$(".conversation").append('<p class="usr_response">'+countrycode+' '+usr_typed_txt+'</p>');
     
      mob_chat = countrycode + usr_typed_txt;
      ctrcode_chat = countrycode;

      //var ipText = $("#typing_text1").val();
$(".conversation").append(typeloader);
$(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');

	 bb += 1;
      if(bb == '1'){
         $(".conversation").append(`<p class="usr_response"><span class="badge_css red" >` + countrycode + ' ' + usr_typed_txt + `</span></p>`);
         $(".typeloader").remove();
         
          var divtest = ` <p class="bot_chat"><img class="responsive-img" src="//cdn.vgn.in/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> `+cust_name_chat+`, are you interested in buying Apartments or Plots?</p>`;
          $(".conversation").append(divtest);
          

            
            
  
              Options = "<li class='projecttypebadge' data-badge-caption='Apartments'>Apartments</li><li class='projecttypebadge' data-badge-caption='Plots'>Plots</li>";
            
  
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
    
    cc += 1;
      if(cc == '1'){
        $(".typeloader").remove();
        $(".conversation").append(`<p class="usr_response"><span class="badge_css red" data-badge-caption="` + projecttype_intrested + `">` + projecttype_intrested + `</span></p>`);
        
        var divtest = ` <p class="bot_chat"><img class="responsive-img" src="//cdn.vgn.in/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> `+cust_name_chat+`, May I know your budget range please?</p>`;
        $(".conversation").append(divtest);
        

          

          

         Options = '<li class="budgetbadge" data-badge-caption="Rs.10-20 Lakhs">Rs.10-20 Lakhs</li><li class="budgetbadge" data-badge-caption="Rs.21-40 Lakhs">Rs.21-40 Lakhs</li><li class="budgetbadge" data-badge-caption="Rs.41-60 Lakhs">Rs.41-60 Lakhs</li><li class="budgetbadge" data-badge-caption="Rs.61-80 Lakhs">Rs.61-80 Lakhs</li><li class="budgetbadge" data-badge-caption="Rs.81-99 Lakhs">Rs.81-99 Lakhs</li><li class="budgetbadge" data-badge-caption="Rs.1 Crore+">Rs.1 Crore+</li>';
          

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
});


$("#vgnchatbot").on('click', '.budgetbadge', function (event) {
  event.preventDefault();

  var budget_intrested = $(this).attr('data-badge-caption');
  if ((budget_intrested != '') && (request_step == '3')) {

    // $(".conversation").append('<p class="usr_response">'+budget_intrested+'</p>');
    
    var ipText = budget_intrested;
    budj_range_chat = budget_intrested;
$(".conversation").append(typeloader);
$(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');

$.post('/api/vgncustomchatreq/gettypelocations',{projecttype_intrested: projtype_chat,session:session}, function(data){
	if (data != 0) {
		//var ndata = JSON.parse(data);
		//console.log(data);
		
		dd += 1;
      if(dd == '1'){
        $(".typeloader").remove();
        $(".conversation").append(`<p class="usr_response"><span class="badge_css red"  data-badge-caption="` + budget_intrested + `">` + budget_intrested + `</span></p>`);
        
        
        var divtest = ` <p class="bot_chat"><img class="responsive-img" src="//cdn.vgn.in/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> `+cust_name_chat+`,  In which location would you like to buy</p>`;
        $(".conversation").append(divtest);
       	
       	$("#location_chat").children().remove();
          $(".vgnchatbot #location_chat").addClass('defineblock');
       	var Options = "<option value=''>Location</option>";
       	$.each(data, function (k,v) {
       		Options = Options + "<option value='" + v.Location + "'>" + v.Location + "</option>";
       	});
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
	else{
		var divtest = ` <p class="bot_chat"><img class="responsive-img" src="//cdn.vgn.in/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> Please enter a valid option.</p>`;
          $(".conversation").append(divtest);
          $(".typeloader").remove();
	}
});

  }


});


$("#btn_click2").on('click', function (event) {
  event.preventDefault();
  var usr_typed_txt = $("#location_chat").val();

  if (request_step == 4) {

    if (usr_typed_txt != '') {
      //$(".conversation").append('<p class="usr_response">'+usr_typed_txt+'</p>');
      
      var ipText = $("#location_chat").val();
      loc_chat = usr_typed_txt;
$(".conversation").append(typeloader);
$(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');

$.post('/api/vgncustomchatreq/getlocationprojectslist',{projectlocationlist_intrested: loc_chat,projecttype: projtype_chat,session:session}, function(data){
	if (data != 0) {
		 ee += 1;
      if(ee == '1'){
        $(".typeloader").remove();
        $(".conversation").append(`<p class="usr_response"><span class="badge_css red" >` + usr_typed_txt + `</span></p>`);
          
          var divtest = ` <p class="bot_chat"><img class="responsive-img" src="//cdn.vgn.in/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> `+cust_name_chat+`, Please select the project you are interested in</p>`;
          $(".conversation").append(divtest);
           
  
  
            var Options = "";
            $.each(data,function(k,v) {
            	Options = Options + "<li class='projectbadge' data-badge-caption='" + v['Project_name'] + "'>VGN " + v['Project_name'] + "</li>";
            });
  
              
            
  
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
	else{
		var divtest = ` <p class="bot_chat"><img class="responsive-img" src="//cdn.vgn.in/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> Please enter a valid project name.</p>`;
          $(".conversation").append(divtest);
          $(".typeloader").remove();
	}

	});

            
    }

  }

});


$("#vgnchatbot").on('click', '.projectbadge', function (event) {
  event.preventDefault();

  var project_intrested = $(this).attr('data-badge-caption');
  if ((project_intrested != '') && (request_step == '5')) {

    // $(".conversation").append('<p class="usr_response">'+project_intrested+'</p>');
    
    var ipText = project_intrested;
    proj_chat = project_intrested;
$(".conversation").append(typeloader);
$(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');

$.post('/api/vgncustomchatreq/submitprojectslist',{projectlocationlist_intrested: loc_chat,projecttype: projtype_chat,projectinterested: proj_chat,session:session}, function(data){

	if (data != 0) {
		ff += 1;
      if(ff == '1'){
        $(".typeloader").remove();
        $(".conversation").append(`<p class="usr_response"><span class="badge_css red" data-badge-caption="` + project_intrested + `"> VGN ` + project_intrested + `</span></p>`);
              
        	var divtest1 = ` <p class="bot_chat"><img class="responsive-img" src="//cdn.vgn.in/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> `+cust_name_chat+`, Kindly share your email address to send you the relevant project details.</p>`;
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
	else{
		var divtest = ` <p class="bot_chat"><img class="responsive-img" src="//cdn.vgn.in/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> Please enter a valid project name.</p>`;
          $(".conversation").append(divtest);
          $(".typeloader").remove();
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

$.post('/api/vgncustomchatreq/submitemailandclose',{name: cust_name_chat,mobile: mob_chat,projectlocationlist_intrested: loc_chat,projecttype: projtype_chat,projectinterested: proj_chat,email: email_chat,budget_range:budj_range_chat,session:session}, function(data){
	console.log(data);
	console.log('gg '+gg);
	if (data != 0) {
		gg += 1;
      if(gg == '1'){
        $(".typeloader").remove();
        $(".conversation").append(`<p class="usr_response"><span class="badge_css red" data-badge-caption="` + usr_typed_txt + `">` + usr_typed_txt + `</span></p>`);
                    

          if (data == 0) {
            var anothertext = ` <p class="bot_chat"><img class="responsive-img" src="//cdn.vgn.in/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> Please enter a valid emailid.</p>`;
            $(".conversation").append(anothertext);
            $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');
          }
          else {
            
            var divtest1 = ` <p class="bot_chat"><img class="responsive-img" src="//cdn.vgn.in/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> Thank You `+cust_name_chat+`. Our sales representative will get in touch with you shortly.</p>`;
            $(".conversation").append(divtest1);
  
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
	else{
		$(".typeloader").remove();
		var anothertext = ` <p class="bot_chat"><img class="responsive-img" src="//cdn.vgn.in/images/vgnchatbot/robot-icon-circle2.png" width="30" style="margin-top: -1px;"> Please enter a valid emailid.</p>`;
            $(".conversation").append(anothertext);
            $(".conversation").animate({ scrollTop: $('.conversation').prop("scrollHeight") }, 2000,'swing');
	}
});
      
    }

  }

});




});