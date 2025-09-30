@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Leads Followup Reference Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newemployeezone.styles.commoncss')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css">

<!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/plugins/iCheck/all.css">
 <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
   <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/plugins/timepicker/bootstrap-timepicker.min.css">

<style>
	.carousel-inner>.item>img
	{
		min-height: 280px;
	}
    #changedetailsForm label.col-sm-2 {
        font-weight: normal;
    }
    .modal-header{
        background-color: #EF5350;
        color: #fff;
        font-weight: bold;
    }
    .marg_left{
        margin-left: 10px;
    }
    
    
    .small-box h3 {
    font-size: 22px;
    font-weight: 400;
    margin: 0 0 10px 0;
    white-space: nowrap;
    padding: 0;
}
    
    .card {
  box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23);
}
    .card:hover {
  box-shadow: 0 14px 28px rgba(0,0,0,0.25), 0 10px 10px rgba(0,0,0,0.22);
}
    #test li{
        list-style-type: none;
            margin-bottom: 5px;
    }
   div.info-box-content p {
   margin: 18px 0px;
  
    }
    div.info-box-content{
      margin-left: 0px;
      text-align: center;
    }
    div.info-box.card{
  background-color: #E44747;    
    }
   .dataTables_scrollBody{
      height: auto;
    }
    #part1 li{
      list-style-type: none;
    }
    #loading {position: fixed;width: 100%;height: 100%;left: 0;top: 0;right: 0;bottom: 0;display: block;background: #fff;z-index: 10000;}
      #loading img {position: absolute;top: 50%;left: 50%;margin: -23px 0 0 -23px;}
</style>

<script>
  function Converttimeformat(stime) {
// var time = $("#starttime").val();
var time = stime;
var hrs = Number(time.match(/^(\d+)/)[1]);
var mnts = Number(time.match(/:(\d+)/)[1]);
var format = time.match(/\s(.*)$/)[1];
if (format == "PM" && hrs < 12) hrs = hrs + 12;
if (format == "AM" && hrs == 12) hrs = hrs - 12;
var hours = hrs.toString();
var minutes = mnts.toString();
if (hrs < 10) hours = "0" + hours;
if (mnts < 10) minutes = "0" + minutes;
return hours + ":" + minutes;
}
</script>

@endsection

@section('bodycontent')
<body class="hold-transition skin-red sidebar-collapse sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">

@foreach($getemployeedata as $employee)


 
  @include('newemployeezone.header.index')
  @include('newemployeezone.aside.index')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <div id="loading">
      <img src="{{ url('/images/spinner/loader-dark.gif') }}" alt="Loading...">
    </div>
    <!-- Main content -->
    <section class="content">
	
	<div class="row">
		      	
            <div class="col-sm-6">
      	<div class="panel panel-default">
         
         <div class="panel-body">
           
           <div class="row">
             <div class="col-sm-6 col-sm-offset-3">
               
               <div class="panel panel-default">
         
         <div class="panel-body">
            <ul id="part1">
              <li><input type="checkbox"  name="smsgreet1" id="smsgreet1" value="" disabled="true"> SMS Greetings & E Brouchers</li>
              <li><input type="checkbox"  name="smsgreet2" id="smsgreet2" value="" disabled="true"> Invitation for Site Visit</li>
              <li><input type="checkbox"  name="smsgreet3" id="smsgreet3" value="" disabled="true"> Schedule for Site Visit</li>
              <li><input type="checkbox"  name="smsgreet4" id="smsgreet4" value="" disabled="true"> Completion of Site Visit</li>
              <li><input type="checkbox"  name="smsgreet5" id="smsgreet5" value="" disabled="true"> Quatation Email</li>
            </ul>
         </div>
       </div>

             </div>
           </div>

           <div class="row">
             <div class="col-md-6">
               <ul id="part1">
                 <li><i class="fa fa-hand-o-right"></i>  Date - {{ \carbon\carbon::now()->format('d-m-Y')}}</li>
                 <li><i class="fa fa-hand-o-right"></i>  Emp name - {{ $employee->name}}</li>
                 <li><i class="fa fa-hand-o-right"></i>  Emp no - {{ $employee->id}}</li>
                 <li><i class="fa fa-hand-o-right"></i>  Assigned on - <span id="assigned">{{$asigndate}}</span></li>
                 <li><i class="fa fa-hand-o-right"></i>  Project - <span id="leadplant"></span></li>
                 <li><i class="fa fa-hand-o-right"></i>  Lead Classification - <span id="leadclassify">
                  @if(strtoupper($type) == 'UNDER FOLLOWUP')

                  @if($coldind == 'X') <?php echo 'COLD'; ?> @else @endif
                  @else

                  @if($coldind == 'X') <?php echo 'COLD'; ?> @else <?php echo strtoupper($type); ?>@endif
                  
                   @endif</span></li>
                 <li><i class="fa fa-hand-o-right"></i>  Change Date - <span id="changeddate">{{$cdate}}</span></li>
               </ul>
             </div>
             <div class="col-md-6">
               <ul id="part1">
                 <li><i class="fa fa-hand-o-right"></i>  Lead No - {{$leadno}}</li>
                 <li><i class="fa fa-hand-o-right"></i>  Lead Name - <span id="leadname"></span></li>
                 <li><i class="fa fa-hand-o-right"></i>  Telephone No - <span id="teleno"></span></li>
                 <li><i class="fa fa-hand-o-right"></i>  Email-ID - <span id="mailid"></span></li>
                 <li><i class="fa fa-hand-o-right"></i>  Budget Range - <span id="budgetrange"></span></li>
                 <li><input type="checkbox" id="coldind" name="coldind" "@if($coldind == 'X') checked=true @endif" disabled style="border: 1px solid grey;"> Cold Indicator </li>
                 <li>
                  <select name="coldtext" class="form-control" id="coldtext">
                    <option value="">Request for Cold Reason</option>
            
                   @if(count($coldarray) > 0)
                   @foreach($coldarray as $cold)
                   <option value="{{$cold['Cold']}}" "@if($coldreason == $cold['Cold']) selected=selected @endif">{{$cold['Cold']}}</option>
                   @endforeach
                   @endif
                  </select>
                 </li>
               </ul>
             </div>
           </div>

         </div> 
        </div>      
        </div>
        
            <div class="col-sm-6">
        <div class="panel panel-default">
          <div class="panel-body">
            
            <div class="row">
              <ol>
                <li>Based on the input Plant and employee code ,lead automatically flow here as per the distribution made in transaction ZSD DISTRIBUTE.</li>
<li>Enter the lead number and then select the lead follow up tab to update the lead stage[Mandatory], action to be taken, deadline date and completion indicator.</li>
<li>Completion indi. should be flagged only if the task[Action To Be Taken] is complete.</li>
<li>Once entered and saved action to be taken can#t be changed.</li>
<li>Enter the E sales diary to know the task by date[Dead Line Date Entered in Follow up
tab] all the uncompleted task in the past and the next 45 days tasks can be viewed here.</li>
<li>Cold can’t be selected directly without following the mandatory sales process fixed in transaction ZSD TEMPLATE.If cold is selected then reason for cold should be selected.</li>
              </ol>

            </div>
            <div class="row">
            <div class="col-md-6">
            <button class="btn btn-warning" id="raise_request_for_approval">Request for Cold Approval</button>
            </div>
                     
            <div class="col-md-6">
            <label for="request_for_approval">Status: </label>
            <span id="request_for_approval">
            @if($cold_status == 'REQ_APP')
            Requested for Cold Approval
            @elseif($cold_status == 'REJECTED')
            Rejected
            @elseif($cold_status == 'APPROVED')
            Approved
            @else
            Nil
            @endif
            </span>
            </div>
            </div>

          </div>
        </div>      
        </div>
       
        
	</div>
	
	



	<div class="row">
		
    <div class="col-md-12">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-diamond margin-r-5"></i> Sales Leads Follow Up </h3>
                <span class="pull-right" ><button class="btn btn-danger btn-sm" id="savelead"><i class="fa fa-save margin-r-5"></i>Save</button></span>
                
                
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
               <h5 style="font-weight: 600;">Lead Class: {{ strtoupper($type) }} Leads</h5>

              <h5 style="font-weight: 600;">Employee Name: {{ $employee->name }}</h5>
               <div class="col-sm-6 col-sm-offset-3">
				 @if(session()->has('error_msg'))
				        <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                {{Session::get('error_msg')}}
              </div>
				        <br>
				 @endif
                 @if(session()->has('suc_msg'))
				        
				        <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                {{Session::get('suc_msg')}}
              </div>
				        <br>
				 @endif
              </div>
                
                <form style="overflow:auto;" action="{{ url('/employeezone/complaints')}}" name="closeform" method="post">
		{{ csrf_field()}}
		<input type="hidden" name="close" value="#" id="closevalue">
		</form>
                
                <form id="changedetailsForm" method="POST" action="{{ url('/employeezone/changemydetails') }}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                          <table id="example" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                
                <th>S.No</th>
				<th>Action to be Taken</th>
				<th>Deadline Date</th>
				<th>Created Date</th>
				<th>Completion Indicator</th>
				
				
				
            </tr>
        </thead>
       
        <tbody>
          
          @if(count($leadstable) > 0)
          @foreach($leadstable as $leadsdata)
          <?php $count = 1;?>
           <tr>
             <td>{{$leadsdata['S_No']}}</td>
             <td><input type="text" class="form-control" name="actiontobetaken[]" value="{{$leadsdata['Act_Taken']}}" "@if($leadsdata['Comp_Ind'] == 'X') disabled  @endif"></td>
             <td>
              <input type="text" class="form-control sdatemask" name="deadlinedate[]" 
              @if($leadsdata['Dead_Date'] != '00000000')
              value="<?php 
              echo substr($leadsdata['Dead_Date'], 6,2).'-'.substr($leadsdata['Dead_Date'], 4,2).'-'.substr($leadsdata['Dead_Date'], 0,4); ?>" @else value="" @endif
               "@if($leadsdata['Comp_Ind'] == 'X') disabled @endif">
              </td>
             <td>

              <?php

              if($leadsdata['Cr_Date'] == ''){
              }else{
              // echo substr($leadsdata['Cr_Date'], 0,4).'-'.substr($leadsdata['Cr_Date'], 4,2).'-'.substr($leadsdata['Cr_Date'], 6,2);
                echo substr($leadsdata['Cr_Date'], 6,2).'-'.substr($leadsdata['Cr_Date'], 4,2).'-'.substr($leadsdata['Cr_Date'], 0,4);
               } ?></td>
              
             <td> <input type="checkbox" class="validcheck" name="completioncheck[]" "@if($leadsdata['Comp_Ind'] == 'X') checked=true @endif" > </td>
             

           </tr>  
           <?php $count += 1; ?>
           @endforeach    
            @endif
            @if($count < 21)
            <?php for ($i=$count; $i < 21 ; $i++) { 
              ?>
              <tr>
             <td>&nbsp;</td>
             <td><input type="text" class="form-control" name="actiontobetaken[]" value=""></td>
             <td>
              <input type="text" class="form-control sdatemask" name="deadlinedate[]" value="">
              </td>
             <td>&nbsp;</td>
             <td> <input type="checkbox" class="validcheck" name="completioncheck[]" > </td>
             

           </tr>  
              <?php
            } ?>
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
	


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2017 <a href="http://www.vgn.in">VGN Property Developers Pvt. Ltd</a>.</strong> All rights
    reserved.
  </footer>

  
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



@endforeach
@endsection

@section('script')
@include('newemployeezone.js.commonjs')
<script>
    
    function readCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}
    
   
    var value = readCookie('selectedlead');
    //console.log(value);

        var now = new Date();
var time = now.getTime();
time += 3600 * 1000;
now.setTime(time);

    document.cookie = 
'checkedlead= followup; expires=' + now.toUTCString() + 
'; path=/'; 

    if(value == null){
      window.location.href="/employeezone/getleadstypedata/{{$type}}";
    }
    var data = JSON.parse(value);
       
    
    document.getElementById("smsgreet1").checked = data['smsgreet'];
    document.getElementById("smsgreet2").checked = data['inv_sitevisit'];
    document.getElementById("smsgreet3").checked = data['schedule_sitevisit'];
    document.getElementById("smsgreet4").checked = data['comp_sitevisit'];
    document.getElementById("smsgreet5").checked = data['quo_email'];

  document.getElementById("leadname").innerText = data['leadname'];     
  document.getElementById("leadplant").innerText = data['projectid'];    
  document.getElementById("teleno").innerText = data['teleno'];    
  document.getElementById("mailid").innerText = data['mailid'];   
  document.getElementById("budgetrange").innerText = data['budgetrange'];    


</script>
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
<!-- iCheck 1.0.1 -->
<script src="{{url('/newcustomerzoneassets/plugins/iCheck/icheck.min.js')}}"></script>


<!-- InputMask -->
<script src="{{ asset('newcustomerzoneassets/plugins/input-mask/jquery.inputmask.js')}}"></script>
<script src="{{ asset('newcustomerzoneassets/plugins/input-mask/jquery.inputmask.date.extensions.js')}}"></script>
<script src="{{ asset('newcustomerzoneassets/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<!-- bootstrap datepicker -->
<script src="{{asset('newcustomerzoneassets/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- bootstrap time picker -->
<script src="{{asset('newcustomerzoneassets/plugins/timepicker/bootstrap-timepicker.min.js')}}"></script>
<script>
      $(window).on('load',function(){
             setTimeout(function() {
                 $('#loading').fadeOut( 400, "linear" );
              }, 300);
      });
      
    </script>
<script>
$(document).ready(function() {
    var table = $('#example').DataTable( {
        "order": [[ 4, "desc" ]],
        rowReorder: false,
        responsive: false,
        "scrollX": true,
        "scrollY": "300",
		paging: false
    } );
    
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-red',
      radioClass   : 'iradio_flat-red'
    });
     //$('.sdatemask').inputmask('yyyy-mm-dd', { 'placeholder': 'yyyy-mm-dd' })
     $('.sdatemask').datepicker({
      format: 'dd-mm-yyyy',
      autoclose: true
    });
     //Timepicker
    $('.timepicker').timepicker({
      showInputs: false,
       use24hours: true
    });

    $("#raise_request_for_approval").on('click', function(){
      var req_status = $("#request_for_approval").text();
      var coldtext = $("#coldtext").val();
      
      if (coldtext == '') {
        alert('Select Cold Reason!');
        $("#coldtext").focus();
      }
      else{
          $("#request_for_approval").text('Request for Cold Approval');
      }
      
    });


     $('#projectno').on('change', function(){
          var projectcode = $(this).val();
          $('#punitno').val('') ;
          

          $.post( "{{url('/employeezone/getsingleunits')}}",{_token: "{{csrf_token()}}",projectcode: projectcode}, function( data ) {
            
                        
            var output='<option value="">Select*</option>';

              var newdata = JSON.parse(data);
              if (!$.isArray(newdata)){ newdata = [newdata];} 

            $.each(newdata, function(index,val){
                
                if (val['Unit_No'] != '') {
                output += '<option value="'+val['Unit_No']+'"';
                
                output+='>'+val['Unit_No']+' - '+val['Unit_Description']+'</option>';
                    
                $('#punitno').html(output);
              }

            });


          });

         

        });
    
} );    
    
   

    

    

    

      $("#smscompletion_single").on('click', function(){

        var checkedstatus = $('input[name=leadcheck]:checked').val();
        if(checkedstatus == undefined){
            alert('Select one lead from the table.');
        }
        else{
         

          //alert('clicked scheduled site visit');
          
          $.post('/employeezone/sendsmsforleads',{_token:'{{csrf_token()}}',leadno: checkedstatus,type:'smscompletion_single'}, function(data){
              
                if(data == 1){
                    alert('Completion for Site visit SMS Sent Successfully!');
                    window.location.reload();
                }
            });
        }

     });


$('.validcheck').on('change', function() { 
        if($(this).is(':checked')) 
        {
           var trrow = $(this).closest('tr');
           var action = trrow.find('input[name="actiontobetaken[]"]').attr('readonly', true);
           var action = trrow.find('input[name="deadlinedate[]"]').attr('readonly', true);
           console.log(action);
        }else{
          var trrow = $(this).closest('tr');
          var action = trrow.find('input[name="actiontobetaken[]"]').attr('readonly', false);
          var action = trrow.find('input[name="deadlinedate[]"]').attr('readonly', false);
        }
    });

      $("#savelead").on('click', function(){
        $('#loading').show();
    var myRows = [];
var headersText = [];
var $headers = $("th");
var mainarray = [];

// Loop through grabbing everything
var $rows = $("tbody tr").each(function(index) {
  $cells = $(this).find("td");
  myRows[index] = {};

  $cells.each(function(cellIndex) {
    // Set the header text
    if(headersText[cellIndex] === undefined) {
      headersText[cellIndex] = $($headers[cellIndex]).text();
    }


var datanew = '';


    if ($(this).find('input').length) { 
    
    $(this).find('input[name="actiontobetaken[]"]').each(function() {
      if(this.value != ''){
        datanew = this.value;
      }
    });

    $(this).find('input[name="deadlinedate[]"]').each(function() {
      if(this.value != ''){
        datanew = this.value;
      }
    });

  $(this).find('input[name="completioncheck[]"]').each(function(){
    datanew = $(this).is(':checked');
  });

  }else{
  if ($.trim($(this).text()) != '') {
  datanew = $.trim($(this).text());
  }
}



    // Update the row object with the header/cell combo





    /*myRows[index][headersText[cellIndex]] = $(this).text();*/
    myRows[index][headersText[cellIndex]] = datanew;
  });    
});

       //console.log(myRows);
var postingarray = [];
var valpresent = 0;
var check = '';
      $.each( myRows, function( key, value ) {
        

    if((value['Action to be Taken'] != '') &&(value['Deadline Date'] != '')){
      valpresent = valpresent + 1;
      postingarray.push(value);
    }
    if((value['Action to be Taken'] == '') &&(value['Deadline Date'] != '')){
      //alert('Fill the Action to be taken and Deadline Date');
      //window.location.reload();
      //return false;
      check = '1';
    }
    if((value['Action to be Taken'] != '') &&(value['Deadline Date'] == '')){
      //alert('Fill the Action to be taken and Deadline Date');
      //window.location.reload();
      //return false;
      check = '1';
    }
});




      var coldincheck = $('input[name="coldind"]').is(":checked");
      var request_for_approval = $.trim($("#request_for_approval").text());
      var coldtextcheck = $("#coldtext").val();
      
      if ((request_for_approval == 'Request for Cold Approval') || (request_for_approval == 'Requested for Cold Approval')|| (request_for_approval == 'Rejected')) {
        if(coldtextcheck == ''){
          check = '2';
        }
      }
      // if(coldincheck == true){

      //   if(coldtextcheck == ''){
      //     check = '2';
      //   }
      // }

      // if(coldtextcheck != ''){
      //   if(coldincheck == false){
      //     check = '2';
      //   }
      // }

      if(check == '2'){
  alert('Cold Reason Mandatory!');  
  $('#loading').hide();
}
else if ((check == '1') || (valpresent == 0)) {

      alert('Fill the Action to be taken and Deadline Date');
      $('#loading').hide();

}else{
      var coldind = $('input[name="coldind"]').is(":checked");
      var coldindtext = $('#coldtext').val();
      var leadplant = $.trim($('#leadplant').text());
      var teleno = $.trim($('#teleno').text());
      var mailid = $.trim($('#mailid').text());
      var budgetrange = $.trim($('#budgetrange').text());
      var changeddate = $.trim($('#changeddate').text());
      var leadname = $.trim($('#leadname').text());
      var leadclassify = $.trim($('#leadclassify').text());
      
      var newbudgecode = '';
     
      // if (request_for_approval == 'Request for Approval') {
      //   leadclassify = 'COLD';
      // }

      if (budgetrange != '') {
        var budgetdata = {01:'0-20 Lakhs',02:'21-40 Lakhs',03:'41-60 Lakhs',04:'61-80 Lakhs',05:'81-1 Crore',06:'1-3 Crore',07:'3-5 Crore',08:'5-10 Crore',09:'10 Crore and Above'};
        $.each(budgetdata, function(i,e){
          if(e == budgetrange){
            newbudgecode = '0'+i;
          }
        });
      }

      var finalarray = [];
      var sno = 1;
      $.each(postingarray, function(newi, newe){
        if (newe['S.No'] == '') {
          newe['S.No'] = sno.toString();
        }

        if (newe['Completion Indicator'] == true) {
          newe['Completion Indicator'] = 'X';
        }
        else{
         newe['Completion Indicator'] = ''; 
        }
        if ((newe['Deadline Date'] != '') || (newe['Deadline Date'] != '00000000')) {
          var newDeadlinedate = newe['Deadline Date'].split('-');
        newe['Deadline Date'] = newDeadlinedate[2]+newDeadlinedate[1]+newDeadlinedate[0];
          //newe['Deadline Date'] = newe['Deadline Date'].replace('-','');
        }
        if (newe['Created Date'] != '') {
          //newe['Created Date'] = newe['Created Date'].replace('-','');
            var newCreateddate = newe['Created Date'].split('-');
        newe['Created Date'] = newCreateddate[2]+newCreateddate[1]+newCreateddate[0];
        }
        finalarray.push(newe);
        sno += 1;
      });
      
      

      if (changeddate != '') {
        //changeddate = changeddate.replace('-','');
        var newchangeddate = changeddate.split('-');
        changeddate = newchangeddate[2]+newchangeddate[1]+newchangeddate[0];
      }
      //console.log(changeddate);
          //var newdate = sdate.split("-");

          //sdate = newdate[2]+'-'+newdate[1]+'-'+newdate[0];
      var cold_status = '';
          if ((request_for_approval == 'Request for Cold Approval') || (request_for_approval == 'Requested for Cold Approval')) {
            cold_status = 'REQ_APP'
          }
          if (request_for_approval == 'Rejected') {
            cold_status = 'Rejected'
          }

      if (coldind == true) {
        newcoldind = '';
      }else{
        newcoldind = '';
      }
      //console.log(finalarray);
       $.post('/employeezone/insertleadsfollowup',{_token:'{{csrf_token()}}',leadno: {{$leadno}},
        data:finalarray,
       coldind : newcoldind,
      coldindtext : coldindtext,
      leadplant : leadplant,
      teleno : teleno,
      mailid : mailid,
      budgetrange : newbudgecode,
      changeddate : changeddate,
      leadname : leadname,
      leadclassify: leadclassify,
      cold_status: cold_status

     }, function(data){
              console.log(data);
              $('#loading').hide();
              //console.log(data.Status);
                if(data.Status == 'X'){
                    alert('Successfully Leads followup data updated');
                    window.location.reload();
                }

            });

}




     });


     


     

     



    
</script>




@endsection
