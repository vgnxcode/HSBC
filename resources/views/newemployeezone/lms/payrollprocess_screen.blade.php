@extends('newemployeezone.layout') @section('title') VGN Projects Estates Pvt Ltd |Employee Zone| Leave Management System | Payroll Process
Page @endsection @section('description')
<meta name="description" content=""> @endsection @section('keyword') @endsection @section('style') @include('newemployeezone.styles.commoncss')
<link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
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

.card {
    border: 1px solid;
    padding: 5px;
    box-shadow: 5px 10px #888888;
}
.box-body{
  padding: 0px;
}

.box-body h3{
  font-size:20px;
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
                    <h3 class="box-title"><i class="fa fa-bullhorn margin-r-5"></i>Payroll Process Data</h3>
                    
                    <a href="{{ url('/employeezone/leavemanagementsystem') }}" class="btn btn-danger btn-xs"><i class="fa fa-backward margin-r-5"></i>LMS Dashboard</a></span>
                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
			<form role="form" id="payrollform" autocomplete="off">
            {{csrf_field()}}
			<div class="row">
				<div class="col-md-12">

					<div class="row" id="leave_date_range_div">
            <div class="col-lg-2"></div>
                <div class="col-lg-4">
                <div class="form-group">
                <label>Select Payroll Month/Year:</label>

                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" name="leave_date_range" readonly='true' id="leave_date_range" value="{{old('leave_date_range')}}" >


                </div>
                {!! $errors->first('leave_date_range', '<span class="errortext text-red">:message</span>') !!}
                <!-- /.input group -->
              </div>
                </div>

                 <div class="col-lg-4">
                <div class="form-group">
                <label>Company:</label>

                <div class="form-group">
                  <select class="form-control"  name="company" id="company">
                    <option value="">Select</option>
                    <option value="4000">VGN Projects Estates Pvt Ltd</option>
                    <option value="5000">VGN Infra India Pvt Ltd</option>
                    <option value="7200">VGN Home Building India Pvt Ltd</option>
                    <option value="6300">VGN Interiors One Pvt Ltd</option>
                  </select>

                </div>
                {!! $errors->first('leave_date_range', '<span class="errortext text-red">:message</span>') !!}
                <!-- /.input group -->
              </div>
                </div>
<div class="col-lg-2"></div>

                </div>
				</div>
			</div>			
		</form>


    <br><br>
    <div class="row">
      <div class="col-md-4">
        
        
<div class="box box-solid card text-center" style="background-color: #f56954; cursor: pointer; color: #fff;" id="clear_duplicatesappl">

<!-- /.box-header -->
<div class="box-body" style="border: 3px solid #fff;background-color: #f56954;">
  
    <h3>1. Application Validation.</h3>
  
</div>
<!-- /.box-body -->
</div>

<div class="row" id="clr_dupldiv">
      <div class="col-md-12">
      <div class="box box-solid card" style="height:250px;overflow-y: scroll;">
        <h3 style="text-decoration: underline; text-align:center;">Duplicate records</h3>
        <div class="dupl_rec">
          
        </div>
      </div>
      </div>
    </div>


      </div>

       <div class="col-md-4">
        
        
<div class="box box-solid card text-center" style="background-color: #f56954; cursor: pointer; color: #fff;" id="approve_pendingappl">

<!-- /.box-header -->
<div class="box-body" style="border: 3px solid #fff;background-color: #f56954;">
  
    <h3>2. Approve Pending Appl.</h3>
  
</div>
<!-- /.box-body -->
</div>


      </div>

       <div class="col-md-4">
        
        
<div class="box box-solid card text-center" style="background-color: #f56954; cursor: pointer; color: #fff;" id="approve_autorejectedappl">

<!-- /.box-header -->
<div class="box-body" style="border: 3px solid #fff;background-color: #f56954;">
  
    <h3>3. Approve Autorejection Appl.</h3>
  
</div>
<!-- /.box-body -->
</div>


      </div>
    </div>

    
     <div class="row">

      <div class="col-md-4">
        
<div class="box box-solid card text-center" style="background-color: #f56954; cursor: pointer; color: #fff;" id="startpayrollprocessinportal">

<!-- /.box-header -->
<div class="box-body" style="border: 3px solid #fff;background-color: #f56954;">
  
    <h3>4. Send Late/LOP to SAP</h3>
    @if(count($payrolldata) > 0)
    @foreach($payrolldata as $kk => $vv)@if(count($vv) > 0)<p class="pendinglist" style="color:#fff;">{{count($vv)}} to process...</p>@endif
    @endforeach
    @endif
  
</div>
<!-- /.box-body -->
</div>


      </div>
     

<div class="col-md-4">
  
<div class="box box-solid card text-center" style="background-color: #f56954; cursor: pointer; color: #fff;" id="sendapprovedappltosap">

<!-- /.box-header -->
<div class="box-body" style="border: 3px solid #fff;background-color: #f56954;">

<h3>5. Send Approved Appl. to SAP</h3>
@if(count($approveddata) > 0)
@foreach($approveddata as $kk => $vv)@if(count($vv) > 0)<p class="pendinglist" style="color:#fff;">{{count($vv)}} to process...</p>@endif
@endforeach
@endif

</div>
<!-- /.box-body -->
</div>
</div>

<div class="col-md-4">
  
<div class="box box-solid card text-center" style="background-color: #f56954; cursor: pointer; color: #fff;" id="downloadleavebalance">

<!-- /.box-header -->
<div class="box-body" style="border: 3px solid #fff;background-color: #f56954;">

<h3>6. Download Leave Balance Days</h3>


</div>
<!-- /.box-body -->
</div>
<div id="dvjson"></div>

</div>



</div>




<div class="row">
<div class="col-md-4">
  
  <div class="box box-solid card text-center" style="background-color: #f56954; cursor: pointer; color: #fff;" id="downloadleaveappl">
  
  <!-- /.box-header -->
  <div class="box-body" style="border: 3px solid #fff;background-color: #f56954;">
  
  <h3>7. Download Leave Applications</h3>
  
  
  </div>
  <!-- /.box-body -->
  </div>
  <div id="dvjson1"></div>
  <div id="dvjson2"></div>
  
  </div>

  <div class="col-md-4">
  
  <div class="box box-solid card text-center" style="background-color: #f56954; cursor: pointer; color: #fff;" id="downloadlateappl">
  
  <!-- /.box-header -->
  <div class="box-body" style="border: 3px solid #fff;background-color: #f56954;">
  
  <h3>8. Download Late Applications</h3>
  
  
  </div>
  <!-- /.box-body -->
  </div>
  <div id="dvjson3"></div>
  
  </div>


  <div class="col-md-4">
  
  <div class="box box-solid card text-center" style="background-color: #f56954; cursor: pointer; color: #fff;" id="resynchactiveemp">
  
  <!-- /.box-header -->
  <div class="box-body" style="border: 3px solid #fff;background-color: #f56954;">
  
  <h3>9. Resynch New Active Employee</h3>
  
  
  </div>
  <!-- /.box-body -->
  </div>
  
  
  </div>

</div>

<div class="row">
<div class="col-md-4">
  
  <div class="box box-solid card text-center" style="background-color: #f56954; cursor: pointer; color: #fff;" id="resynchactiveemp">
  
  <!-- /.box-header -->
  <div class="box-body" style="border: 3px solid #fff;background-color: #f56954;">
  
  <h3>10. Intercompany Transfer</h3>
  <input type="text" name="oldempnumber" class="form-control" id="oldempnumber" placeholder="Old Employee Number"><br>
  <input type="text" name="newempnumber" class="form-control" id="newempnumber" placeholder="New Employee Number"><br>
  <button class="btn btn-warning" id="transfer">Transfer</button>
  
  
  </div>
  <!-- /.box-body -->
  </div>
  
  
  </div>

  <div class="col-md-4">
  
  <div class="box box-solid card text-center" style="background-color: #f56954; cursor: pointer; color: #fff;" id="addrestrictedholiday">
  
  <!-- /.box-header -->
  <div class="box-body" style="border: 3px solid #fff;background-color: #f56954;">
  
  <h3>11. Add Restricted Holiday</h3>
  <input type="text" name="empnumber" class="form-control" id="restempnumber" placeholder="Enter Employee Number"><br>
  <select name="restmonth" class="form-control" id="restmonth">
    <option value="">Select Month</option>
  <option name="January" value="01">January</option>
  <option name="February" value="02">February</option>
  <option name="March" value="03">March</option>
  <option name="April" value="04">April</option>
	<option name="May" value="05">May</option>
  <option name="June" value="06">June</option>
  <option name="July" value="07">July</option>
  <option name="August" value="08">August</option>
	<option name="September" value="09">September</option>
  <option name="October" value="10">October</option>
  <option name="November" value="11">November</option>
  <option name="December" value="12">December</option>
  </select><br>
  <button class="btn btn-warning" id="addrestrictholiday">Add</button>
  
  
  </div>
  <!-- /.box-body -->
  </div>
  
  
  </div>

  <div class="col-md-4">
  
  <div class="box box-solid card text-center" style="background-color: #f56954; cursor: pointer; color: #fff;" id="downloadpayrollview">
  
  <!-- /.box-header -->
  <div class="box-body" style="border: 3px solid #fff;background-color: #f56954;">
  
  <h3>12. Download Payroll Report</h3>
  
  @if(count($payrollviewsession) > 0)
<p class="pendinglist" style="color:#fff;">Processing Please wait...</p>
@endif
  
  </div>
  <!-- /.box-body -->
  </div>
  <div id="dvjson44"></div>
  
  </div>

</div>

</div>  





                                
                                    
                    </form>
                  
    
                  
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



  @endsection @section('script') @include('newemployeezone.js.commonjs')

  <script>
     function stripslashes(str) {
str=str.replace(/\\'/g,'\'');
str=str.replace(/\\"/g,'"');
str=str.replace(/\\0/g,'\0');
str=str.replace(/\\\\/g,'\\');
return str;
}

  </script>



<script src="{{ config('app.AWS_URL')}}/js/excelexportjs.js"></script>

<!-- ChartJS -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/chart.js/Chart.js"></script>
<!-- FastClick -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/fastclick/lib/fastclick.js"></script>

<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/moment/min/moment.min.js"></script>
   <!-- bootstrap datepicker -->
   <script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

  
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
   

$('#leave_date_range').datepicker(
        {
                       
            autoclose: true,
      format: 'mm/yyyy',
      minViewMode: "months"
            
        }
      );
   

$("#clr_dupldiv").hide();

$("#clear_duplicatesappl").on("click", function(){
  var monthyear = $("#leave_date_range").val();
  var company = $("#company").val();
  $("#clr_dupldiv").hide();

  if ((monthyear != '') && (company != '')) {
    $.post("/employeezone/lms/payrollprocess_clrduplicterecords", {"_token": "{{csrf_token()}}", monthyear: monthyear, company: company}, function(data){
      var maindata = JSON.parse(data);
      if (maindata.length >= 1) {
        $(".dupl_rec").html('');
        var dup = '<ol>';
        $.each(maindata[0], function(k, v){
          dup += '<li><p>'+v.employeeid + '|'+ v.date+ '|'+ v.type+ '|'+ v.partial_days+ '|'+ v.start_end_time+ '|'+ v.shift_code+'</p></li>';
        });
        dup += '</ol>';
        console.log(dup);
        $(".dupl_rec").html(dup);
        $("#clr_dupldiv").show();

      }else{
        alert('No Duplicate records found!');
      }
      
    });
  }
  else{
    alert('Please select the Payroll month/year and company');
  }
});


$("#approve_pendingappl").on("click", function(){
  var monthyear = $("#leave_date_range").val();
  var company = $("#company").val();

  if ((monthyear != '') && (company != '')) {
    $.post("/employeezone/lms/runautoapprove_forpending", {"_token": "{{csrf_token()}}", monthyear: monthyear, company: company}, function(data){
      //console.log(data);
      var maindata = JSON.parse(data);
      //console.log(maindata);
      if (maindata.length != 0) {
        alert('Pending Application updated count - '+maindata.pendingapp);

      }else{
        alert('No Pending Application found!');
      }
      
    });
  }
  else{
    alert('Please select the Payroll month/year and company');
  }
});

$("#approve_autorejectedappl").on("click", function(){
  var monthyear = $("#leave_date_range").val();
  var company = $("#company").val();

  if ((monthyear != '') && (company != '')) {
    $.post("/employeezone/lms/runautoapprove_forautorejection", {"_token": "{{csrf_token()}}", monthyear: monthyear, company: company}, function(data){
      console.log(data);
      var maindata = JSON.parse(data);
      console.log(maindata);
      if (maindata.length != 0) {
        alert('Auto rejection Application updated count - '+maindata.autoapproved_rejected);

      }else{
        alert('No Auto rejection Application found!');
      }
      
    });
  }
  else{
    alert('Please select the Payroll month/year and company');
  }
});

//resynchactiveemp

$("#resynchactiveemp").on("click", function(){
  var monthyear = $("#leave_date_range").val();
  var company = $("#company").val();

  if ((monthyear != '') && (company != '')) {
    $.post("/employeezone/saveactive_emplisttodb", {"_token": "{{csrf_token()}}", monthyear: monthyear, company: company}, function(data){
      
      if (data == 1) {
        alert('Active Employee Record Resynched!');

      }else{
        alert('Not resynched!');
      }
      
    });
  }
  else{
    alert('Please select the Payroll month/year and company');
  }
});

//startpayrollprocessinportal



$("#startpayrollprocessinportal").on("click", function(){
  var monthyear = $("#leave_date_range").val();
  var company = $("#company").val();

  if ((monthyear != '') && (company != '')) {
    $.post("/employeezone/lms/startpayrollprocessinportal", {"_token": "{{csrf_token()}}", monthyear: monthyear, company: company}, function(data){
      console.log(data);
      var maindata = JSON.parse(data);
      //console.log(maindata);
      if (maindata.length != 0) {
        if(maindata == 11){
          alert('Late Deduction Process expired!');
        }
        
        window.location.reload();

      }else{
        
        alert('No Payroll records found!');
      }
      
    });
  }
  else{
    alert('Please select the Payroll month/year and company');
  }
});




var payrollrecords = @json($payrolldata);

if(payrollrecords.length != 0){
  $.each(payrollrecords, function(k,v){
    
    var a = false;
    $.each(v, function(k1, v1){
      //console.log(v1.length);
      if(a == false){
        if(v1.payrollprocessed == "0"){
          $.post('/employeezone/lms/sendlatetosapviaportal', {"_token": "{{csrf_token()}}", "recordstoprocess": v1, "recordkey": k }, function(data){
            console.log(data);
             if(data == 1){
               setTimeout(() => {
                 window.location.reload();
               }, 10000);
             }
          });
        }
        
      }
      a = true;
    });
  });
}


$("#sendapprovedappltosap").on("click", function(){
  var monthyear = $("#leave_date_range").val();
  var company = $("#company").val();

  if ((monthyear != '') && (company != '')) {
    $.post("/employeezone/lms/sendapprovedappltosapviaportal", {"_token": "{{csrf_token()}}", monthyear: monthyear, company: company}, function(data){
      
      var maindata = JSON.parse(data);
      
      //console.log(maindata);
      if (maindata.length != 0) {
        if(maindata == 11){
          alert('Approved Application Process expired!');
        }
        window.location.reload();

      }else{
        
        alert('No Approved Application records found!');
      }
      
    });
  }
  else{
    alert('Please select the Payroll month/year and company');
  }
});


var approvedrecords = @json($approveddata);

if(approvedrecords.length != 0){
  $.each(approvedrecords, function(k,v){
    
    var a = false;
    
    $.each(v, function(k1, v1){
      //console.log(v1);
      if(a == false){
        
           $.post('/employeezone/lms/sendapprovedapplicationsprocess', {"_token": "{{csrf_token()}}", "recordstoprocess": v1, "recordkey": k }, function(data){
             console.log(data);
              if(data == 1){
                setTimeout(() => {
                  window.location.reload();
                }, 10000);
              }
           });
        
        
      }
      a = true;
    });
  });
}
//downloadleavebalance

$("#downloadleavebalance").on("click", function(){
  var monthyear = $("#leave_date_range").val();
  var company = $("#company").val();

  if ((monthyear != '') && (company != '')) {
    $.post("/employeezone/lms/downloadleavebalance", {"_token": "{{csrf_token()}}", monthyear: monthyear, company: company}, function(data){
      console.log(data);
      var maindata = JSON.parse(data);
      
      console.log(maindata);
      if (maindata.length != 0) {
        
        $("#dvjson").excelexportjs({
  containerid:"dvjson",
  datatype:'json',
  dataset: maindata,
  columns: getColumns(maindata)
});

        //window.location.reload();

      }else{
        
        alert('No Leave records found!');
      }
      
    });
  }
  else{
    alert('Please select the Payroll month/year and company');
  }
});

//downloadlateappl
$("#downloadlateappl").on("click", function(){
  var monthyear = $("#leave_date_range").val();
  var company = $("#company").val();

  if ((monthyear != '') && (company != '')) {
    $.post("/employeezone/lms/downloadlateappl", {"_token": "{{csrf_token()}}", monthyear: monthyear, company: company}, function(data){
      //console.log(data);
      var maindata4 = JSON.parse(data);
      
      //console.log(maindata);
      if (maindata4.length != 0) {
        
        $("#dvjson3").excelexportjs({
  containerid:"dvjson3",
  datatype:'json',
  dataset: maindata4,
  columns: getColumns(maindata4)
});

        //window.location.reload();

      }else{
        
        alert('No Late records found!');
      }
      
    });
  }
  else{
    alert('Please select the Payroll month/year and company');
  }
});

//downloadleaveappl

$("#downloadleaveappl").on("click", function(){
  var monthyear = $("#leave_date_range").val();
  var company = $("#company").val();

  if ((monthyear != '') && (company != '')) {
    $.post("/employeezone/lms/downloadleaveappl", {"_token": "{{csrf_token()}}", monthyear: monthyear, company: company}, function(data){
      
      var maindata = JSON.parse(data);
      
      console.log(maindata);
      if (maindata.length != 0) {
        
        $("#dvjson1").excelexportjs({
  containerid:"dvjson1",
  datatype:'json',
  dataset: maindata,
  columns: getColumns(maindata)
});


setTimeout(() => {

$.post("/employeezone/lms/downloadleavedatetimeref", {"_token": "{{csrf_token()}}", monthyear: monthyear, company: company}, function(data){

var maindata1 = JSON.parse(data);

//console.log(maindata);
if (maindata1.length != 0) {
  
  $("#dvjson2").excelexportjs({
containerid:"dvjson2",
datatype:'json',
dataset: maindata1,
columns: getColumns(maindata1)
});

  //window.location.reload();

}else{
  
  alert('No Leave Datetime reference table Applications found!');
}

});

}, 3000);
        //window.location.reload();

      }else{
        
        alert('No Leave Applications found!');
      }
      
    });

    

    
  }
  else{
    alert('Please select the Payroll month/year and company');
  }
});

$("#transfer").on("click", function(){
  var oldemp = $("#oldempnumber").val();
  var newemp = $("#newempnumber").val();
  if ((oldemp != '')&& (newemp != '')) {
    if (oldemp == newemp) {
      alert('Two fields should not be same!');
    }
    else{
      $.post("/employeezone/lms/intercompanytransfer", {"_token": "{{csrf_token()}}", oldemp: oldemp, newemp: newemp}, function(data){
        console.log(data);
        if(data == 1){
          alert('Transferred Successfully!');
        }
        else if(data == 2){
          alert('New Record Already exist!');
        }
        else{
          alert('Not Transferred Try Again!');
        }
        $("#oldempnumber").val('');
        $("#newempnumber").val('');
        
      });
    }
    
  }
  else{
    alert('Two fields value required!');
  }

});

//addrestrictholiday

$("#addrestrictholiday").on("click", function(){
  var emp = $("#restempnumber").val();
  var restmonth = $("#restmonth").val();
  if ((emp != '')&& (restmonth != '')) {
    
      $.post("/employeezone/lms/addrestrictholiday", {"_token": "{{csrf_token()}}", emp: emp, restmonth: restmonth}, function(data){
        console.log(data);
        if(data == 1){
          alert('Added Successfully!');
        }
        else if(data == 2){
          alert('Record Already exist!');
        }
        else{
          alert('Failed. Try Again!');
        }
        $("#restempnumber").val('');
        $("#restmonth").val('');
        
      });
    
    
  }
  else{
    alert('Two fields value required!');
  }

});

//downloadpayrollview
$("#downloadpayrollview").on("click", function(){
  var monthyear = $("#leave_date_range").val();
  var company = $("#company").val();

  if ((monthyear != '') && (company != '')) {
    $.post("/employeezone/lms/downloadpayrollview", {"_token": "{{csrf_token()}}", monthyear: monthyear, company: company}, function(data){
      console.log(data);
      var maindata44 = JSON.parse(data);
      //console.log(maindata);
      if (maindata44.length != 0) {
        if(maindata44 == 11){
          alert('Payroll Process expired!');
        }
        else if(maindata44 == 2){
          alert('No Payroll records found!. Process Started to Generate.Please wait...');
        }
        else if(maindata44 == 111){
          alert('Unauthorized!');
        }
        else if(maindata44 == 22){
          alert('Process running. Please wait!');
        }
        else if(maindata44 == 114){
          alert('Process Started. Please wait!');
        }
        else{

        $("#dvjson44").excelexportjs({
containerid:"dvjson44",
datatype:'json',
dataset: maindata44,
columns: getColumns(maindata44)
});
        
        
        }
        window.location.reload();

      }else{
        
        alert('No Payroll records found!.');
      }
      
    });
  }
  else{
    alert('Please select the Payroll month/year and company');
  }
});

//payrollviewsession

var payrollviewsession = @json($payrollviewsession);
//console.log(payrollviewsession);
if(payrollviewsession.length != 0){
  $.each(payrollviewsession, function(k,v){
    
    var a = false;
      //console.log(v1.length);
      if(a == false){
        
          $.post('/employeezone/lms/payrollviewsession', {"_token": "{{csrf_token()}}" }, function(data){
            console.log(data);
             if(data == 1){
               setTimeout(() => {
                 window.location.reload();
               }, 10000);
             }
          });
        
        
      }
      a = true;
  
  });
}

      
  });
</script>

  @endsection
