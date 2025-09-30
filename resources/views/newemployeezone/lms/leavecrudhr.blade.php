@extends('newemployeezone.layout') @section('title') Edit Employee Leave Applications @endsection @section('description')
<meta name="description" content=""> @endsection @section('keyword') @endsection @section('style') @include('newemployeezone.styles.commoncss')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css">
 <!-- bootstrap datepicker -->
 <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-daterangepicker/daterangepicker.css">
 <!-- Select2 -->
 <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/select2/dist/css/select2.min.css">
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
  .select2-container .select2-selection--single {
    height: 35px !important;
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
                    <h3 class="box-title"><i class="fa fa-file margin-r-5"></i>Edit Employee Applications</h3>
                    
                    <span class="pull-right" ><a href="{{ url('/employeezone/leavemanagementsystem') }}" class="btn btn-danger btn-xs"><i class="fa fa-backward margin-r-5"></i>LMS Dashboard</a></span>
                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  
                           
                           <div class="row">
                           <div class="col-md-10 col-md-offset-1">

                           <div class="col-lg-2">
                <div class="form-group">
                <label>Month:</label>

                <div class="form-group">
                  
                  
                  <input type="number" class="form-control" name="month" id="month" value="{{old('month')}}" placeholder="Month" min="01" max="12" >
                  
                  
                  
                </div>
                
                <!-- /.input group -->
              </div>
                </div>

                           <div class="col-lg-2">
                <div class="form-group">
                <label>Year:</label>

                <div class="form-group">
                  
                  
                  
                  <input type="number" class="form-control" name="year" id="year" value="{{old('year')}}" placeholder="Year" min="2018" >
                  
                  
                </div>
                
                <!-- /.input group -->
              </div>
                </div>
                <div class="col-lg-4">

                     <div class="form-group">
                  <label>Employee</label>
                  <select class="form-control select2" name="punch_subid" id="punch_subid">
                    <option value="" >Select</option>
                     @if(count($forpunchlist) > 0)
                      @foreach($forpunchlist as $subordinate_value)
                        <option value="{{$subordinate_value['empid']}}" >{{$subordinate_value['empname']}} ({{$subordinate_value['empid']}})</option>
                      @endforeach
                    @endif

                    
                  </select>
                </div>

                   </div>

                   <div class="col-lg-2" style="margin-top:23px;">
                   <button class="btn btn-primary" class="form-control" id="view_applications">View Applications</button>
                   </div>
                </div>
              </div>

<div class="row">
  <div class="col-md-1"></div>
  <div class="col-md-5">
  <h2>Leave Balance</h2>
  <ul>
    <li>CL - <span class="cl_bal"></span></li>
    <li>SL - <span class="sl_bal"></span></li>
    <li>PL - <span class="pl_bal"></span></li>
    <li>ML - <span class="ml_bal"></span></li>
    <li>RH - <span class="rh_bal"></span></li>
    <li>Onduty - <span class="onduty_bal"></span></li>
    <li>Permission - <span class="permission_bal"></span></li>
    
  </ul>
  </div>
  <div class="col-md-5">
  <h2>&nbsp;</h2>
  <ul>
    
    <li>Tour - <span class="tour_bal"></span></li>
    <li>Compoff - <span class="compoff_bal"></span></li>
    <!-- <li>Mispunch - <span class="mispunch_bal"></span></li> -->
    <li>Present - <span class="present_bal"></span></li>
    <li>LOP - <span class="lop_bal"></span></li>
    <li>Absent - <span class="absent_bal"></span></li>
    <li>Is Editable - <span class="editable"></span></li>
  </ul>
  </div>
</div>
                                                
                                      
                    <br>
                    <br>
                    
                       <div class="row" style="margin-left:3px;">
                           <div class="col-md-12">

                           
                              
                              <div id="table_placement">
                           
                              </div>  
                                                 
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
<!-- Select2 -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/select2/dist/js/select2.full.min.js"></script>
  <script>
     function stripslashes(str) {
str=str.replace(/\\'/g,'\'');
str=str.replace(/\\"/g,'"');
str=str.replace(/\\0/g,'\0');
str=str.replace(/\\\\/g,'\\');
return str;
}



  </script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js" ></script>
<script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js" ></script>

<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js" ></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js" ></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js" ></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js" ></script>

 
 <script type="text/javascript">


  function send_datato_update(clickedid) {
    $("#"+clickedid).prop('disabled',true);
    $("#spin1").show();

    var strplit = clickedid.split("_");
var requesteddate = strplit[0];
var req_empid = strplit[1];
var req_type = strplit[2];
    
    var leavetypeselected = $("#leave_type").val();
    var partialdaysselected = $("#partial_days").val();

    console.log('sending data to admin...'+leavetypeselected+', '+partialdaysselected+', '+requesteddate+', '+req_empid+', '+req_type);

    $.post('/employeezone/lms/postdate_attendancecorrection', {_token:'{{csrf_token()}}',leavetypeselected: leavetypeselected,partialdaysselected:partialdaysselected,requesteddate:requesteddate, req_empid: req_empid,req_type: req_type}, function(data){
    alert(data);
  $("#spin1").hide();
  $("#"+clickedid).prop('disabled',false);
});

  }

  function send_datato_delete(clickedid) {
    $("#"+clickedid).prop('disabled',true);
    $("#spin1").show();

    var strplit = clickedid.split("_");
var requesteddate = strplit[0];
var req_empid = strplit[1];
var req_type = strplit[2];
    
    var leavetypeselected = $("#leave_type").val();
    var partialdaysselected = $("#partial_days").val();

    console.log('sending data to admin...'+leavetypeselected+', '+partialdaysselected+', '+requesteddate+', '+req_empid+', '+req_type);

    $.post('/employeezone/lms/postdate_attendancecorrection', {_token:'{{csrf_token()}}',leavetypeselected: leavetypeselected,partialdaysselected:partialdaysselected,requesteddate:requesteddate, req_empid: req_empid,req_type: req_type}, function(data){
    alert(data);
  $("#spin1").hide();
  $("#"+clickedid).prop('disabled',false);
});

  }
   
  function popmodal(clickedid) {
  
//    console.log(clickedid);
var strplit = clickedid.split("_");
var requesteddate = strplit[0];
var req_empid = strplit[1];
var req_type = strplit[2];
//console.log(req_type);
var result1="";
$(".modal-body").empty();

if (req_type == 'create') {
$("#myModalLabel").html("Create Application "+requesteddate);
result1+= '<div class="box-body"><form class="form-horizontal" name="apprejform" id="apprejform"><div class="row"><div class="col-md-5"><b>Employee Id</b></div>';
result1+= '<div class="col-md-5">:  '+req_empid+'</div></div>';
result1+= '<br><div class="row"> <div class="col-md-5"><b>Date</b></div><div class="col-md-5">:  '+requesteddate+'</div></div>';

result1+= '<br><div class="row"> <div class="col-md-5"><b>Leave Type</b></div><div class="col-md-5" ><select class="form-control" name="leave_type" id="leave_type"><option value="CL">Casual Leave</option><option value="SL">Sick Leave</option><option value="PL">Earn Leave</option><option value="Onduty">Onduty</option><option value="Tour">Tour</option><option value="Permission">Permission</option><option value="Compoff">Compoff</option><option value="LOP">LOP</option></select></div></div>';

result1+= '<br><div class="row"> <div class="col-md-5"><b>Partial Days</b></div><div class="col-md-5" ><select class="form-control" name="partial_days" id="partial_days"><option value="first_half">First Half</option><option value="second_half">Second Half</option><option value="full">Full Day</option></select></div></div>';

result1+= '</div></form><div align="center"><i class="fa fa-refresh fa-spin fa-2x"  id="spin1" ></i></div>';
result1+= '<div class="box-footer"><a class="btn btn-success pull-right" id="'+requesteddate+'_'+req_empid+'_admincreate" onclick="send_datato_update(this.id);">Save</a></div>';
$(".modal-body").html(result1);


}
if (req_type == 'edit') {
$("#myModalLabel").html("Edit Application "+requesteddate); 
result1+= '<div class="box-body"><form class="form-horizontal" name="apprejform" id="apprejform"><div class="row"><div class="col-md-5"><b>Employee Id</b></div>';
result1+= '<div class="col-md-5">:  '+req_empid+'</div></div>';
result1+= '<br><div class="row"> <div class="col-md-5"><b>Date</b></div><div class="col-md-5">:  '+requesteddate+'</div></div>';

result1+= '<br><div class="row"> <div class="col-md-5"><b>Leave Type</b></div><div class="col-md-5" ><select class="form-control" name="leave_type" id="leave_type"><option value="CL">Casual Leave</option><option value="SL">Sick Leave</option><option value="PL">Earn Leave</option><option value="Onduty">Onduty</option><option value="Tour">Tour</option><option value="Permission">Permission</option><option value="Compoff">Compoff</option><option value="LOP">LOP</option></select></div></div>';

result1+= '<br><div class="row"> <div class="col-md-5"><b>Partial Days</b></div><div class="col-md-5" ><select class="form-control" name="partial_days" id="partial_days"><option value="first_half">First Half</option><option value="second_half">Second Half</option><option value="full">Full Day</option></select></div></div>';

result1+= '</div></form><div align="center"><i class="fa fa-refresh fa-spin fa-2x"  id="spin1" ></i></div>';
result1+= '<div class="box-footer"><a class="btn btn-success pull-right" id="'+requesteddate+'_'+req_empid+'_admincreate" onclick="send_datato_update(this.id);">Save</a><a class="btn btn-danger" id="'+requesteddate+'_'+req_empid+'_admindelete" onclick="send_datato_delete(this.id);">Delete</a></div>';
$(".modal-body").html(result1);


}

$('#myModal').modal('show'); 
$("#spin1").hide();
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
    $("#spin").hide();
    $('.select2').select2()
        //Red color scheme for iCheck
        $("#punchlist").hide();
   
        $('#leave_date_range').daterangepicker(
        {
          locale: {
            format: 'MMM/YYYY'
        },
       
       
        
        }
      );

   
    

    $(document).on('click', '#view_applications', function(){
      var month = $("#month").val();
      var year = $("#year").val();
      var subid = $("#punch_subid").val();
      var selectedText = $("#punch_subid option:selected").html();


 $.post("/employeezone/lms/attendancecorrection_bal", {_token:'{{csrf_token()}}',month: month,year:year,employeeid:subid}, function(data){
        
        if (data != '0') {
          var newdata22 = JSON.parse(data);
          console.log(newdata22);
          $(".cl_bal").text(newdata22[0].CL);
          $(".sl_bal").text(newdata22[0].SL);
          $(".pl_bal").text(newdata22[0].PL);
          $(".ml_bal").text(newdata22[0].ML);
          $(".rh_bal").text(newdata22[0].RH);
          $(".onduty_bal").text(newdata22[0].Onduty);
          $(".tour_bal").text(newdata22[0].Tour);
          $(".permission_bal").text(newdata22[0].Permission);
          // $(".mispunch_bal").text(newdata22[0].Mispunch);
          $(".compoff_bal").text(newdata22[0].Compoff);
          $(".present_bal").text(newdata22[0].Present);
          $(".lop_bal").text(newdata22[0].LOP);
          $(".absent_bal").text(newdata22[0].Absent);
          if (newdata22[0].completed == 'Y') {$(".editable").text('No');}else{$(".editable").text('Yes');}
          
        }
        else{
           $(".cl_bal").text('No record');
          $(".sl_bal").text('No record');
          $(".pl_bal").text('No record');
          $(".ml_bal").text('No record');
          $(".rh_bal").text('No record');
          $(".onduty_bal").text('No record');
          $(".tour_bal").text('No record');
          $(".permission_bal").text('No record');
          // $(".mispunch_bal").text('No record');
          $(".compoff_bal").text('No record');
          $(".present_bal").text('No record');
          $(".lop_bal").text('No record');
          $(".absent_bal").text('No record');
          $(".editable").text('No record');
        }
      });
      //console.log(selectedText);
        //console.log('Month Year' +month+ ' ' + year + ' for employee : '+ subid );
        $.post("/employeezone/lms/attendancecorrection", {_token:'{{csrf_token()}}',month: month,year:year,employeeid:subid}, function(data){
         // console.log(data);
          if (data != '0') {

            //start
            var newdata = JSON.parse(data);
          
          var titlearray = [
            {title: 'S.No'},
            {title: 'Employee Id'},
            {title: 'Employee Name'}
          ];

          var arrayvaldata = [1, subid, selectedText];
          var newbtn = '';
          
          $.each(newdata, function(k, v) {
            titlearray.push({title: k});
            var newa = [];
            newbtn = '';
            if ((v.first_half == '')&&(v.second_half == '')&&(v.full == '')) {
              newbtn = '<button class="btn btn-primary btn-xs operation" id="'+k+'_'+subid+'_create" onclick="popmodal(this.id);"><i class="fa fa-plus"></i> Add</button>';
              arrayvaldata.push(newbtn);
            }
            else if((v.first_half != '')&&(v.second_half != '')&&(v.full == ''))
            {
              newbtn = '<button class="btn btn-warning btn-xs operation" id="'+k+'_'+subid+'_edit" onclick="popmodal(this.id);"><i class="fa fa-edit"></i> FH_'+v.first_half+'/SH_'+v.second_half+'</button>';
              arrayvaldata.push(newbtn);
            }
            else if((v.first_half == '')&&(v.second_half == '')&&(v.full != ''))
            {
              newbtn = '<button class="btn btn-warning btn-xs operation" id="'+k+'_'+subid+'_edit" onclick="popmodal(this.id);"><i class="fa fa-edit"></i> '+v.full+'</button>';
              arrayvaldata.push(newbtn);
            }
            else if((v.first_half != '')&&(v.second_half == '')&&(v.full == ''))
            {
              newbtn = '<button class="btn btn-warning btn-xs operation" id="'+k+'_'+subid+'_edit" onclick="popmodal(this.id);"><i class="fa fa-edit"></i> '+'FH_'+v.first_half+'</button>';
              arrayvaldata.push(newbtn);
            }
            else if((v.first_half == '')&&(v.second_half != '')&&(v.full == ''))
            {
              newbtn = '<button class="btn btn-warning btn-xs operation" id="'+k+'_'+subid+'_edit" onclick="popmodal(this.id);"><i class="fa fa-edit"></i> '+'SH_'+v.second_half+'</button>';
              arrayvaldata.push(newbtn);
            }
            else{
              arrayvaldata.push('Missed');
            }

            //arrayvaldata.push(newa);

          });

        
        var tbl = '<table id="example" class="display nowrap" cellspacing="0" width="100%" style="text-align:center;"></table>';
        $("#table_placement").empty();
      $("#table_placement").append(tbl);      
    
    $('#example').DataTable( {
      data: [arrayvaldata],
        columns: titlearray,
              scrollX: true,
              "order": [[1, 'asc']],
              rowReorder: false,
              responsive: false,
              bPaginate: true,
              dom: 'Bfrtip',
              buttons: [
                  'copy', 'csv', 'excel', 'pdf', 'print'
              ]
             
          } );

          //console.log(titlearray);
          //console.log([arrayvaldata]);
          
        
            //end
            
          }
          else{
            var tbl = '<table id="example" class="display nowrap" cellspacing="0" width="100%"></table>';
        $("#table_placement").empty();
      $("#table_placement").append(tbl);  
      alert('Not a valid Input');
          }
    });
          
    });    



   
      
  });
</script>

  @endsection

