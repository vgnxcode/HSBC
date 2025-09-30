@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Holiday Calendar Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newemployeezone.styles.commoncss')
 <!-- fullCalendar -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/fullcalendar/dist/fullcalendar.min.css">
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/fullcalendar/dist/fullcalendar.print.min.css" media="print">
   <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<style>
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
</style>

@endsection

@section('bodycontent')
<body class="hold-transition skin-red fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

@foreach($getemployeedata as $employee)
 
  @include('newemployeezone.header.index')
  @include('newemployeezone.aside.index')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">

	@include('newemployeezone.contenttop')


      	</div>
	</div>



	<div class="row">
		
		<div class="col-md-12">
			<div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-calendar-check-o margin-r-5"></i> Holiday Calendar</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
             
             <div class="row">
             
             
         
             
             
             
             
             <div class="col-md-10 col-md-offset-1">
          <div class="box box-danger">
            <div class="box-body no-padding">
            <div id="calendar"></div>
              </div>
                 </div>
                </div>
                
                 
         
        
                
                </div>  
            
            </div>
            <!-- /.box-body -->
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



@endsection

@section('script')
@include('newemployeezone.js.commonjs')
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
          title          : "{{count($event)}} Events Created",
          start          : "{{$k}}",
          end            : "{{$k}}",
          backgroundColor: "#f39c12", //Primary (light-blue)
          borderColor    : "#f39c12", //Primary (light-blue)
          editable  : false,
          className :"{{$k}}"
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
