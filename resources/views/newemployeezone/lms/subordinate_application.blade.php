@extends('newemployeezone.layout') @section('title') VGN Projects Estates Pvt Ltd |Employee Zone| Leave Management System | View Subordinates Applications
Page @endsection @section('description')
<meta name="description" content=""> @endsection @section('keyword') @endsection @section('style') @include('newemployeezone.styles.commoncss')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css">
 <!-- bootstrap datepicker -->
 <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
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


<div class="row">
		
        <div class="col-md-12">
          
          <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bullhorn margin-r-5"></i>Team Application Workflow</h3>
                    
                    <span class="pull-right" ><a href="{{ url('/employeezone/leavemanagementsystem') }}" class="btn btn-danger btn-xs"><i class="fa fa-backward margin-r-5"></i>LMS Dashboard</a></span>
                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
        
                       <div class="row" style="margin-left:3px;">
                           <div class="col-md-12">

                           @if($show_selectall_btn > 0)
                               <div class='pull-left'>
                               
                               <button class="btn btn-primary" id="selectall"><i class="fa fa-check"></i> Select All</button>
                               <button class="btn btn-success" id="approveselected"><i class="fa fa-thumbs-up"></i> Approve Selected</button>
                               &nbsp;
                               <i class="fa fa-refresh fa-spin fa-2x"  id="spin" ></i>
                               
                               </div>
                               @endif
                              <table id="example" class="display nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>S. No.</th>
                    <th>Select</th>
                    <th>Employee Id</th>
                    
                    <th>Employee Name</th>
                    <th>Application Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    
                    
                    <th>HOD Status</th>
                    
                    <th>Application</th>
                    <th>Created Date</th>
                    
                </tr>
            </thead>
           
            <tbody>
               
                @if(count($getallapplications) > 0)
                                                        <?php $count = 1; ?>
                                                        @foreach($getallapplications as $appliedkey => $appliedvalue)
                                                        <tr>
                                                        <td>{{$count}}</td>
                                                        @if($appliedvalue['hod_status'] == 'Pending')
                                                        <td class="selectedbox">
                                                        <input type="checkbox" class="action_check" name="action_check" value="{{$appliedvalue['id']}}-{{$appliedvalue['employeeid']}}" >
                                                        </td>
                                                        @else
                                                        <td >
                                                        -
                                                        </td>
                                                        @endif
                                                        
                                                        <td>{{$appliedvalue['employeeid']}}</td>
                                                        <td>{{$appliedvalue['employeename']}}</td>
          <td>
          
          
          {{$appliedvalue['type']}}
          
          </td>
          <td>
            
            {{ \Carbon\Carbon::parse($appliedvalue['stdate'])->format('d, M Y H:i:s') }}
            
          </td>
          <td>
            {{ \Carbon\Carbon::parse($appliedvalue['etdate'])->format('d, M Y H:i:s') }}
            </td>
          
          <td>
            @if($appliedvalue['hod_status'] == 'Pending')
            <span class="label label-warning">Pending</span>
            @elseif ($appliedvalue['hod_status'] == 'Approved')
            <span class="label label-success">Approved</span>
            @else
            <span class="label label-danger">Rejected</span>
            @endif
          </td>
         


          <td>
            <a href="#" class="btn btn-primary btn-xs marg_left" onclick="popmodal('{{$appliedvalue['id']}}')"><i class="fa  fa-hand-pointer-o margin-r-5"></i> View</a>
          </td>
        
         
          <td>{{ $appliedvalue['created_date'] }}</td>

          
        </tr>
                                                            <?php $count++; ?>
                                                        @endforeach
                                                        @endif            
            </tbody>
        </table>           
                                                 
                           </div>
                       </div>
                                
                                    
                    </form>
                  
    
                  
                </div>
                <!-- /.box-body -->
              </div>
    
        </div>
    
    
            
    
            
        </div>

        		<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-red">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
        ...
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
  <script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/moment/min/moment.min.js"></script>
   <!-- bootstrap datepicker -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
  <script>
     function stripslashes(str) {
str=str.replace(/\\'/g,'\'');
str=str.replace(/\\"/g,'"');
str=str.replace(/\\0/g,'\0');
str=str.replace(/\\\\/g,'\\');
return str;
}


@if(!empty($getallapplications))
    
    function popmodal(id){
        var data=<?php echo json_encode($getallapplications);?>;
        var length=data.length;
        console.log(data);
        
        
         var result1="";
         var k;
		 		//var distinct1=[];
		 		for(i=0;i<length;i++)
		 		{
		 		if(id == data[i]['id'])
		 			{
                        
				        $("#myModalLabel").html(data[i]['type'] + " Application");
                         result1+= '<div class="box-body"><form class="form-horizontal" name="apprejform" id="apprejform"><div class="row"><div class="col-md-5"><b>Employee Id</b></div>';
                         result1+= '<div class="col-md-5">:  '+data[i]['employeeid']+'</div></div>';

                 result1+= '<div class="row"> <div class="col-md-5"><b>Start Date</b></div><div class="col-md-5">:  '+data[i]['stdate']+'</div></div>';

                 result1+= '<div class="row"><div class="col-md-5"><b>End Date</b></div><div class="col-md-5">:  '+data[i]['etdate']+'</div></div>';

                 result1+= '<div class="row"><div class="col-md-5"><b>Partial Days</b></div><div class="col-md-5">:  '+data[i]['partial_days']+'</div></div>';

                if(data[i]['no_of_days'] != null){
                    result1+= '<div class="row"><div class="col-md-5"><b>No. of days</b></div><div class="col-md-5">:  '+data[i]['no_of_days']+'</div></div>';
                }

               /* if(data[i]['type'] == 'Compoff'){

                    result1+= '<br><div class="row"><div class="col-md-5"><b>Compoff Shift</b></div><div class="col-md-5">:  '+data[i]['compoff_worked_shift']+'</div></div>';
                    result1+= '<div class="row"><div class="col-md-5"><b>Compoff Worked Start Date</b></div><div class="col-md-5">:  '+data[i]['compoff_worked_stdate']+'</div></div>';
                    result1+= '<div class="row"><div class="col-md-5"><b>Compoff Worked End Date</b></div><div class="col-md-5">:  '+data[i]['compoff_worked_etdate']+'</div></div>';
                    result1+= '<div class="row"><div class="col-md-5"><b>Total Hours Worked</b></div><div class="col-md-5">:  '+data[i]['compoff_worked_hours']+'</div></div>';
                }
                */

                 result1+= '<div class="row"><div class="col-md-5"><b>Subordinate Reason</b></div><div class="col-md-5">:  '+data[i]['emp_reason']+'</div></div>';
                
                 if(data[i]['saved_file_path'] != null){
                     
                        if (data[i]['type'] == 'ML') {
                            var folder = 'maternityfileupload';
                        }
                        if(data[i]['type'] == 'Mispunch'){
                          var folder = 'mispunchuploads';
                        }
                        if(data[i]['type'] == 'SL'){
                            var folder = 'sickfileupload';
                        }
                         
                     
                     
                    result1+= '<div class="row"><div class="col-md-5"><b>Attachement</b></div><div class="col-md-5">: <a href="/newcustomerzoneassets/'+folder+'/'+data[i]['saved_file_path']+'" target="_blank">View File</a></div></div>';
                }

                 if(data[i]['hod_status'] == 'Pending'){
                result1+= '<br><input type="hidden" name="subid" id="subid" value="'+data[i]["employeeid"]+'" required><input type="hidden" name="id" id="id" value="'+data[i]["id"]+'" required><div class="form-group" id="rejection_reason"><label for="reason">Rejection Reason: </label><textarea class="form-control" rows="3" name="reason" id="reason" placeholder="Enter rejection reason ..."></textarea></div>';
                 }else{
                   if (data[i]['hod_reason'] != null) {
                    result1+= '<div class="row"><div class="col-md-5"><b>HOD Reason</b></div><div class="col-md-5">:  '+data[i]['hod_reason']+'</div></div>'; 
                   }
                    
                    
                    result1+= '<div class="row"><div class="col-md-5"><b>HOD Status</b></div><div class="col-md-5">:  '+data[i]['hod_status']+'</div></div>';
                 }

                 if (data[i]['compoff'] != '') {
                  for (var k = 0; k < data[i]['compoff'].length; k++) {
                  result1+= '<div class="row"><div class="col-md-5"><b>Compoff Worked Date</b></div><div class="col-md-5">:  '+data[i]['compoff'][k]['compoff_worked_date']+'</div></div>';
                  result1+= '<div class="row"><div class="col-md-5"><b>Compoff Worked Hours</b></div><div class="col-md-5">:  '+data[i]['compoff'][k]['compoff_worked_hours']+'</div></div>';
                  result1+= '<div class="row"><div class="col-md-5" style="text-decoration:underline;"><b>Punch Reference</b></div><div class="col-md-5">  </div></div>';
                  
                  for (j = 1; j < data[i]['compoff'][k]['punches_taken'].length; j++) {
                      result1+= '<div class="row"><div class="col-md-5"><b>'+data[i]['compoff'][k]['punches_taken'][j].key+'</b></div><div class="col-md-5">- '+data[i]['compoff'][k]['punches_taken'][j].terminal_name+'  </div></div>';
                    }
                  }

                 }

                   if (data[i]['od'] != '') {
                    for (var k = 0; k < data[i]['od'].length; k++) {
                  result1+= '<div class="row"><div class="col-md-5"><b>Onduty Datetime</b></div><div class="col-md-5">:  '+data[i]['od'][k]['od_datetime']+'</div></div>';
                  
                  result1+= '<div class="row"><div class="col-md-5" style="text-decoration:underline;"><b>Punch Reference</b></div><div class="col-md-5">  </div></div>';
                  //console.log(data[i]['od'][i]['puncheslist']);
                  for (j = 0; j < data[i]['od'][k]['puncheslist'].length; j++) {
                    console.log();
                    
                      result1+= '<div class="row"><div class="col-md-5"><b>'+data[i]['od'][k]['puncheslist'][j].key+'</b></div><div class="col-md-5">- '+data[i]['od'][k]['puncheslist'][j].terminal_name+'  </div></div>';
                    
                  }
                }

                 }
               
                result1+= '</div></form><div align="center"><i class="fa fa-refresh fa-spin fa-2x"  id="spin1" ></i></div>';

                if(data[i]['hod_status'] == 'Pending'){

              result1+= '<div class="box-footer"><a class="btn btn-danger pull-right" id="hod_reject">Reject</a><a class="btn btn-success" id="hod_approve">Approve</a></div>';
                }						
				
		 			}
		 		}
				
        $(".modal-body").html(result1);

        
        $('#myModal').modal('show'); 
        $("#spin1").hide();
        $("#rejection_reason").hide();
    }

    @endif
  </script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js" ></script>
<script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js" ></script>
<!-- iCheck 1.0.1 -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/plugins/iCheck/icheck.min.js "></script>
  
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
    $("#spin").hide();
        //Red color scheme for iCheck
        $("#punchlist").hide();
   
        $('#leave_date_range').daterangepicker(
        {
          locale: {
            format: 'DD/MM/YYYY'
        },
        ranges   : {
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Today'       : [moment(), moment()],
          'Tommorow'   : [moment().add(1, 'days'), moment().add(1, 'days')],          
        },
        @if(old('leave_date_range') != '')
        <?php $sp = explode('-', old('leave_date_range')); ?>
        startDate: "{{$sp[0]}}",
        endDate  : "{{$sp[1]}}"
        @else
        startDate: moment(),
        endDate  : moment()
        @endif
        
        }
      );

    var table = $('#example').DataTable( {
        "order": [ 9, "desc" ],
        rowReorder: false,
        responsive: false,
        bPaginate: false,
        "scrollY": 500,
        "scrollX": true
    } );
    

     

 $('#selectall').on('click',function() {
  $(".action_check").prop('checked',true);
   
     });

$("#approveselected").on('click', function(){
  $("#spin").show();
  $('#example tbody > tr').each(function() {
    var checkboxrow = $(this).find(".selectedbox").find("input").is(':checked');
    if (checkboxrow == true) {
      var list = $(this).find(".selectedbox").find("input").val();
      var split = list.split('-')
      var id = split[0];
      var subid = split[1];
      console.log(subid);
      var hodreason = '';
      $.post("/employeezone/lms/subordinate_application", {_token:'{{csrf_token()}}',id: id,reason:hodreason,subordinateid: subid, status: 1}, function(data){
       
        //
    });
    
    }
    
  });

  
    window.location.reload();
$("#spin").hide();

});
    
        

    $(document).on("click", "#hod_approve", function(event){
        $("#spin1").show();
    var id = $("#id").val();
    $("#rejection_reason").hide();
    $("#reason").prop('required',false);
    var hodreason = '';
    
    
    var subid = $("#subid").val();
    $.post("/employeezone/lms/subordinate_application", {_token:'{{csrf_token()}}',id: id,reason:hodreason,subordinateid: subid, status: 1}, function(data){
        //console.log(data);
        if (data.status == 1) {
            alert('Updated Successfully!');
            window.location.reload();
        }else{
            alert('Failed Try Again!');
        }
        $("#spin1").hide();
    });
    
    
});


$(document).on('click', '#view_punches', function(){

var daterange = $("#leave_date_range").val();
var subid = $("#punch_subid").val();

if ((daterange != '') && (subid != '') ) {

  $("#punches_output").html('');
  $.post("/employeezone/lms/getsubordinatepunches", {_token:'{{csrf_token()}}',daterange: daterange,employeeid:subid}, function(data){
    console.log(data);
    if (data.punches.length != 0) {
      var res = '';
      $("#punchlist").fadeIn( "slow", function() {
      });
      $.each( data.punches, function( key, value ) {
        
        if(value.val_name != undefined){
          res += value.val_name+' - '+value.terminal_name+'<br />';
        }

        $("#punches_output").html(res);

      });
    }
    else{
      $("#punchlist").fadeOut( "slow", function() {
      });
      alert('No Punches found for this selected duration!');
    }
  });
}
else{
  $("#punches_output").html('');
  $("#punchlist").fadeOut( "slow", function() {
      });
  alert('Date Range and Employee must be selected!');
}

});

$(document).on("click", "#hod_reject", function(event){
       $("#spin1").show();
    var id = $("#id").val();
    var hodreason = $("#reason").val();
    var subid = $("#subid").val();
    $("#rejection_reason").show();
    $("#reason").prop('required',true);
    if (hodreason != '') {
    $.post("/employeezone/lms/subordinate_application", {_token:'{{csrf_token()}}',id: id,reason:hodreason,subordinateid: subid, status: 0}, function(data){
        console.log(data);
        if (data.status == 1) {
            alert('Updated Successfully!');
            window.location.reload();
        }else{
            alert('Failed Try Again!');
            window.location.reload();
        }
        $("#spin1").hide();
    })
}else{
        alert('Rejection Reason required!');
        $("#spin1").hide();
    }
    
});
      
  });
</script>

  @endsection
