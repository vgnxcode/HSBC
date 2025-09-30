@extends('newemployeezone.layout') @section('title') VGN Projects Estates Pvt Ltd |Employee Zone| Leave Management System | Home
Page @endsection @section('description')
<meta name="description" content=""> @endsection @section('keyword') @endsection @section('style') @include('newemployeezone.styles.commoncss')
 <!-- fullCalendar -->
 <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
   <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<style>
  .carousel-inner>.item>img {
    min-height: 280px;
  }
  .maximg{
    max-width:120px;
    max-height:120px;
  }

  .carousel-inner>.item>img
	{
		min-height: 280px;
	}
    .fc-day-grid-event .fc-content {
        white-space: normal;
        text-align: center;
        cursor: pointer;
    }
    #createdevents{
        height: 200px;
        overflow: scroll;
    }
    .close{
        cursor: pointer;
    }

    /* Preloader */

#preloader {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #fff;
  /* change if the mask should have another color then white */
  z-index: 99;
  /* makes sure it stays on top */
}

#status {
  width: 200px;
  height: 200px;
  position: absolute;
  left: 50%;
  /* centers the loading animation horizontally one the screen */
  top: 50%;
  /* centers the loading animation vertically one the screen */
  background-image: url("{{ config('app.AWS_URL')}}/images/Preloader.gif");
  /* path to your loading animation */
  background-repeat: no-repeat;
  background-position: center;
  margin: -100px 0 0 -100px;
  /* is width and height divided by two */
}
  
</style>

@endsection @section('bodycontent')

<body class="hold-transition skin-red fixed sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">

    @foreach($getemployeedata as $employee) 
    @include('newemployeezone.header.index') 
    @include('newemployeezone.aside.index')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div id="preloader">
  <div id="status">&nbsp;</div>
</div>
      
      <!-- Main content -->
      <section class="content">

      <div class="row">
		<div class="col-md-10 col-md-offset-1">

	@include('newemployeezone.contenttop')


      	</div>
  </div>

  <section class="content-header">
        <h1>
          Leave Management System
          
        </h1>
        <ol class="breadcrumb">
          <li>
            <a href="#">
              <i class="fa fa-dashboard"></i> Home</a>
          </li>
          <li>My Leaves & Approvals</li>
          <li class="active">Leave Management System</li>
        </ol>
      </section>
      <br>
  
      <div class="row" style="padding:20px; box-shadow: inset 0px 11px 8px -10px #CCC, inset 0px -11px 8px -10px #CCC; ">

      <div class="row">
       <div class="col-md-8">
          <div class="box box-danger">
            <div class="box-body no-padding">
            <div id="calendar"></div>
              </div>
                 </div>
                </div>

<div class="row">
 <div class="col-md-4 col-sm-12">

           
<div class="box box-solid card">
            <div class="box-header with-border bg-aqua">
              <i class="fa fa-edit"></i>

              <h3 class="box-title">Request Application</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @if($iscontract == 1)
              <div class="col-md-6">
                 <h5><a href="{{ url('/')}}/employeezone/lms/employee_request_application/3" class="text-black"><i class="fa fa-check-circle"></i> On-Duty</a></h5>
                 </div>
              @else
              <div class="col-md-6">
                 <h5><a href="{{ url('/')}}/employeezone/lms/employee_request_application/1" class="text-black"><i class="fa fa-check-circle"></i> Leave</a></h5>
                 <h5><a href="{{ url('/')}}/employeezone/lms/employee_request_application/2" class="text-black"><i class="fa fa-check-circle"></i> Permission</a></h5>
                 <h5><a href="{{ url('/')}}/employeezone/lms/employee_request_application/3" class="text-black"><i class="fa fa-check-circle"></i> On-Duty</a></h5>
                 <h5><a href="{{ url('/')}}/employeezone/lms/lop" class="text-black"><i class="fa fa-check-circle"></i> Loss Of Pay</a></h5>
                 </div>
                 <div class="col-md-6">
                <h5><a href="{{ url('/')}}/employeezone/lms/employee_request_application/4" class="text-black"><i class="fa fa-check-circle"></i> Tour</a></h5>
                <h5><a href="{{ url('/employeezone/lms/compoff')}}" class="text-black"><i class="fa fa-check-circle"></i> Compensatory Off</a></h5>
                <!-- <h5><a href="{{ url('/')}}/employeezone/lms/mispunch" class="text-black"><i class="fa fa-check-circle"></i> Mispunch</a></h5> -->
                </div>
              @endif
              
              
            </div>
            <!-- /.box-body -->
          </div>


          </div>
         
          @if($iscontract == 0)
          <div class="col-md-4 col-sm-12">

<div class="box box-solid card">
<div class="box-header with-border bg-red">
  <i class="fa fa-edit"></i>

  <h3 class="box-title">Leave Balance - {{\Carbon\Carbon::now()->format('M Y')}}</h3>
</div>
<!-- /.box-header -->
<div class="box-body">
  <marquee direction="up" scrollamount="3" onmouseover="this.stop();" onmouseout="this.start();">
   <p><b><i class="fa fa-info-circle"></i> Only 3 Mispunch applications are allowed per month.</b></p>
    <p><b><i class="fa fa-info-circle"></i> Leaves approvals by HOD is extended for max. of 5 days!</b></p>
  
    </marquee>
  <hr>
    @if(count($getleavebalance) > 0)
      @foreach($getleavebalance[0] as $k => $v)
      
      @if($k == 'CL')
       <h5><i class="fa fa-check-circle"></i> Casual Leave - {{$v}} </h5>@endif
      @if($k == 'SL') <h5 ><i class="fa fa-check-circle"></i> Sick Leave - {{$v}}</h5>@endif
      @if($k == 'PL') <h5><i class="fa fa-check-circle"></i> Earned Leave - {{$v}}</h5>
      
      @endif
      
      
      @if($gender == 'Female')
      @if($k == 'ML')
       <h5><i class="fa fa-check-circle"></i> Maternity Leave - {{$v}}</h5>@endif
      @endif
       @if($k == 'Permission')<h5><i class="fa fa-check-circle"></i> Permission - {{$v}}</h5> @endif

       @if($checkrestricted_holiday > 0)
      @if($k == 'RH') <h5><i class="fa fa-check-circle"></i> Restricted Holiday - {{$v}}</h5>@endif
      @endif
      
      @if($k == 'Onduty')<hr> <h5><i class="fa fa-check-circle"></i> On-Duty - @if($v == null) 0 @else {{$v}} @endif</h5>@endif
      @if($k == 'Tour')<h5><i class="fa fa-check-circle"></i> Tour - @if($v == null) 0 @else {{$v}} @endif</h5>@endif
      @if($k == 'Compoff') <h5><i class="fa fa-check-circle"></i> Compensatory-Off - @if($v == null) 0 @else {{$v}} @endif</h5>@endif
      <!-- @if($k == 'Mispunch')<h5><i class="fa fa-check-circle"></i> Mispunch - @if($v == null) 0 @else {{$v}} @endif</h5>@endif -->
      @if($k == 'LOP')<h5><i class="fa fa-check-circle"></i> Loss of Pay - @if($v == null) 0 @else {{$v}} @endif</h5>@endif
      @if($k == 'late_count')<h5 style="display:none;"><i class="fa fa-check-circle"></i> Late - @if($v == null) 0 @else {{$v}} @endif</h5>@endif
      @if($k == 'early_out_count')<h5 style="display:none;"><i class="fa fa-check-circle"></i> Early Out - @if($v == null) 0 @else {{$v}} @endif</h5>@endif
      @if($k == 'Present')<h5 style="display:none;"><i class="fa fa-check-circle"></i> Present Days - @if($v == null) 0 @else {{$v}} @endif</h5>@endif
      @if($k == 'Absent')<h5 style="display:none;"><i class="fa fa-check-circle"></i> Absent Days - @if($v == null) 0 @else {{$v}} @endif</h5>@endif
      @endforeach
    @endif
  
</div>
<!-- /.box-body -->
</div>

</div>

@endif




</div>


<div class="row">
<div class="col-md-4 col-sm-12">
<a href="{{url('/employeezone/lms/viewallapplication')}}" style="color:#fff;">
<div class="box box-solid card text-center">

<!-- /.box-header -->
<div class="box-body" style="border: 3px solid #fff;background-color: #f56954;" >
  
    <h3><i class="fa fa-eye"></i> Your Applications</h3>
  
</div>
<!-- /.box-body -->
</div>
</a>
</div>
<div class="col-md-4 col-sm-12">
<a href="{{url('/employeezone/lms/attendance_view')}}" style="color:#fff;">
<div class="box box-solid card text-center">

<!-- /.box-header -->
<div class="box-body" style="border: 3px solid #fff;background-color: #00c0ef ;" >
  
    <h3><i class="fa fa-table"></i> My Attendance</h3>
  
</div>
<!-- /.box-body -->
</div>
</a>
</div>
<div class="col-md-4 col-sm-12">
<a href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/lms/instructions.pdf" target="_blank" style="color:#fff;">
<div class="box box-solid card text-center">

<!-- /.box-header -->
<div class="box-body" style="border: 3px solid #fff;background-color: orange ;" >
  
    <h3><i class="fa fa-info-circle"></i> Instructions</h3>
  
</div>
<!-- /.box-body -->
</div>
</a>
</div>
</div>

                </div>

    

</div>

        
        @endforeach
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@include('newemployeezone.footer')
    <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
  </div>
  <!-- ./wrapper -->



  @endsection @section('script') @include('newemployeezone.js.commonjs')
  <!-- jQuery UI 1.11.4 -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- fullCalendar -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/moment/moment.js"></script>
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
  
<script>
function closethevent(classid, eventdate){
          
    
     $.post('/employeezone/deleteevents',{_token: '{{csrf_token()}}',selecteddate:eventdate,selectedclassid:classid}, function(data){
         
         if(data == 1){
             window.location.reload();
         }
         
     });
    
    
      }    
</script>
<script>

$(window).on('load', function() { 
  setTimeout(function() {
     // makes sure the whole site is loaded 
  $('#status').fadeOut(); // will first fade out the loading animation 
  $('#preloader').delay(600).fadeOut('slow'); // will fade out the white DIV that covers the website. 
  $('body').delay(600).css({'overflow':'visible'});
  }, 1000);
 
})

  $(document).ready(function () {
    $('.sidebar-menu').tree();
      
      
      
      
      function shuffle(string) {
    var parts = string.split('');
    for (var i = parts.length; i > 0;) {
        var random = parseInt(Math.random() * i);
        var temp = parts[--i];
        parts[i] = parts[random];
        parts[random] = temp;
    }
    return parts.join('');
}
      
       /* initialize the external events
     -----------------------------------------------------------------*/
    function init_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        }
       // console.log(eventObject);

        // store the Event Object in the DOM element so we can get to it later
        var tostore = $(this).data('eventObject', eventObject)
       

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex        : 1070,
          revert        : true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        })

      })
    }

    init_events($('#external-events div.external-event'))
      
       /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
    $('#calendar').fullCalendar({
      header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week : 'week',
        day  : 'day'
      },
      //Random default events
        
                                
      events    : [
          
           @if(!empty($getattendance))
        @foreach($getattendance as $attendance)            
          {
          title          : "{!!$attendance['holiday_name']!!}({!! $attendance['holiday_count'] !!} day)",
          start          : "{{$attendance['holiday_date']}}",
          end            : "{{$attendance['holiday_date']}}",
          backgroundColor: '#f39c12', //Primary (light-blue)
          borderColor    : '#f39c12', //Primary (light-blue)
          editable  : false
        },
          
          @endforeach
        @endif
          
          @if(!empty($eventdata['list']))
          
        @foreach($eventdata['list'] as $k => $event)            
          {
          title          : @if($event['partial_days'] == 'full')"{{$event['type'] }} - Full Day"@elseif($event['partial_days'] == 'first_half')"{{$event['type'] }} - First Half"@elseif($event['partial_days'] == 'second_half')"{{$event['type'] }} - Second Half"@else"{{$event['type'] }}"@endif,
          start          : "{{ $event['stdate'] }}",
          end            : "{{ $event['etdate'] }}",
          backgroundColor: @if($event['final_status'] == 'Approved')"#28a745"@elseif($event['final_status'] == 'Pending')"#ffc107"@else"#dc3545"@endif, //Primary (light-blue)
          borderColor    : "#fff", //Primary (light-blue)
          editable  : false,
          className :"{{$event['stdate'] }}"
        },
          
        @endforeach
        @endif
       
       
      ],
      
      droppable : true, // this allows things to be dropped onto the calendar !!!
      drop      : function (date, allDay) { // this function is called when something is dropped
          
        // retrieve the dropped element's stored Event Object
        var originalEventObject = $(this).data('eventObject')

        // we need to copy it, so that multiple events don't have a reference to the same object
        var copiedEventObject = $.extend({}, originalEventObject)
        var newcopiedEventObject = $.extend({}, originalEventObject)
        var min = 20;
        var max = 998;
        var randno = Math.floor(Math.random()*(max-min+1)+min);
          
          
        // assign it the date that was reported
        copiedEventObject.start           = date
        copiedEventObject.allDay          = allDay
        copiedEventObject.backgroundColor = $(this).css('background-color')
        copiedEventObject.borderColor     = $(this).css('border-color')
        copiedEventObject.editable     = false,
        copiedEventObject.className     = shuffle("employeenew{{$employeeid}}"+randno)
          

        // render the event on the calendar
        // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
        
          var selecteddate = copiedEventObject.start.format("YYYY-MM-DD");
          var selectedtitle = copiedEventObject.title;
          var selectedclassid = copiedEventObject.className;
          var selectedbackgroundcolor = copiedEventObject.backgroundColor;
          var selectedclassbordercolor = copiedEventObject.borderColor;
          //console.log(selecteddate);
          
           $.post('/employeezone/holidaycalendar',{_token: '{{csrf_token()}}',selecteddate:selecteddate,selectedtitle:selectedtitle
                                                ,selectedclassid:selectedclassid
                                                ,selectedbackgroundcolor:selectedbackgroundcolor
                                                ,selectedclassbordercolor:selectedclassbordercolor
                                                
                                               }, function(data){
               
              if(data == 200){
                  
                  //$('#calendar').fullCalendar('renderEvent', copiedEventObject, true)
                 window.location.reload();
              }
            if(data == 244){
                  alert('Maximum number of events created on this date');
              }
                
          });
          
        
          
        
          
          
       /* $.post('/employeezone/holidaycalendar',{_token: '{{csrf_token()}}',selecteddate:selecteddate,selectedtitle:selectedtitle
                                                ,selectedclassid:selectedclassid
                                                ,selectedclassid:selectedclassid
                                                ,selectedbackgroundcolor:selectedbackgroundcolor
                                                ,selectedclassbordercolor:selectedclassbordercolor
                                                
                                               }, function(data){
              if(data == 111){
                  window.location.reload();
              }
            if(data == 222){
                  alert('Maximum number of events created on this date');
              }
            
            if(data == 444){
                  alert('Event not created. try again');
              }
                
          });*/
          
          
        // is the "remove after drop" checkbox checked?
        //if ($('#drop-remove').is(':checked')) {
          // if so, remove the element from the "Draggable Events" list
            /* $('#calendar').fullCalendar('removeEvents', function(event) {
    return event.className == "naveen";
});*/
          $(this).remove()
       // }

      }
    })

    /* ADDING EVENTS */
    var currColor = '#3c8dbc' //Red by default
    //Color chooser button
    var colorChooser = $('#color-chooser-btn')
    $('#color-chooser > li > a').click(function (e) {
      e.preventDefault()
      //Save color
      currColor = $(this).css('color')
      //Add color effect to button
      $('#add-new-event').css({ 'background-color': currColor, 'border-color': currColor })
    })
    $('#add-new-event').click(function (e) {
      e.preventDefault()
      //Get value and make sure it is not null
      var val = $('#new-event').val()
      if (val.length == 0) {
        return
      }

      //Create events
      var event = $('<div />')
      event.css({
        'background-color': currColor,
        'border-color'    : currColor,
        'color'           : '#fff'
      }).addClass('external-event')
      event.html(val)
      $('#external-events').prepend(event)

      //Add draggable funtionality
      init_events(event)

      //Remove event from text input
      $('#new-event').val('')
    });
      
    
    $(".fc-day-grid-event").on('click', function(){
       var aa = $(this).attr("class");
        var final = aa.replace('fc-day-grid-event fc-h-event fc-event fc-start fc-end ','');
        if(final.length == 10){
            $("#createdevents").html('');
            
            $.post('/employeezone/getevents',{_token: '{{csrf_token()}}',selecteddate:final}, function(data){
                var aa = JSON.parse(data);
                var newdata = '<h4 style="text-decoration:underline;">'+final+' events: </h4>';
                
                $.each(aa, function(i,e){
                    newdata += '<h5  style="background-color:'+e.bgcolor+';border-color:'+e.bordercolor+';color:#fff;border-radius:6px;padding:3px;white-space:normal;text-align:left;width:180px;padding-left: 10px;padding-right: 6px;">'+e.description+' <i class="fa fa-remove close pull-right"  onClick=closethevent("'+e.classid+'","'+e.date_created+'")> </i></h5>';
                })
                
                $("#createdevents").html(newdata);
                //console.log(data);
                
            });
        }
    });
    
    
      
      
  });
</script>

  @endsection
