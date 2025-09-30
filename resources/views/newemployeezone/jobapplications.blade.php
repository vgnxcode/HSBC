@extends('newvendorzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Job Applications Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newvendorzone.styles.commoncss')

<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css">


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
                <h3 class="box-title"><i class="fa fa-briefcase margin-r-5"></i> Job Applications </h3>
                
            </div>
            <!-- /.box-header -->
            <div class="box-body">

<div class="row" style="margin-left: 5px;">
              <div class="callout callout-danger col-md-8 col-md-offset-2">
<h4>Note:</h4>
<ul>
  <li>Applicants who have applied for the job postings will be displayed here, please download their resume using download option.</li>
  <li>Once the applicant applied in the portal their Applicant ID will be generated in SAP.</li>
  <li>If the applicant is suitable for the applied job posting then please process the Invite Applicant Action with status code "34"-Applicant initial call in Transaction code PB40 in SAP. Also, if the applicant is not suitable for the position then please process the Reject Applicant action with status code "21"-Rejected Applicaiton initial screening.</li>
  <li>On completing this action, the applicant details will be removed from the below list.</li>
  <li>The tab incoming job application only visible for the employee who is in department code "50000062" - HR.</li>

</ul>

</div>    
</div>
              
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
                
                <form id="changedetailsForm" method="POST" action="{{ url('/vendorzone/changemydetails') }}" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                          <table id="example" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>S. No.</th>
				
				
				<th>Applicant Name</th>
				<th>Age</th>
        <th>Gender</th>
        <th>City</th>
        <th>Total Experience</th>
        <th>Department Applied For</th>
        <th>Designation Applied For</th>
        <th>Resume</th>
        <th>Details</th>
        <th>Applied Date</th>

            </tr>
        </thead>
       
        <tbody>
           @if(count($getapplications) > 0)
           <?php $count = 1?>
           @foreach($getapplications as $appl)
            <tr>
              <td>{{$count}}</td>
              <td>{{$appl->Title}} {{$appl->First_Name}} {{$appl->Last_Name}}</td>
              <td>{{ Carbon\Carbon::createFromDate(substr($appl->Date_of_Birth,0,4), substr($appl->Date_of_Birth,4,2), substr($appl->Date_of_Birth,6,2))->diff(Carbon\Carbon::now())->format('%y years') }}</td>
              <td>{{$appl->Gender }}</td>
              <td>{{$appl->City}}</td>
              <td>{{$appl->Total_Years_of_Experience}} years</td>
              <td>{{$appl->Department}}</td>
              <td>{{$appl->Designation}}</td>
              <td><a href="{{ url()->full() }}/portal/employee-zone/{{$appl->uploaded_url}}" download="{{$appl->app_id}}.<?php echo pathinfo($appl->uploaded_url, PATHINFO_EXTENSION); ?>"><i class="fa fa-download"></i> Download</a></td>
              <td align='center'><a href="#" class="btn btn-danger btn-xs marg_left" onclick="popmodalremarks('{{$appl->app_id}}')"><i class="fa  fa-hand-pointer-o margin-r-5"></i> View</a></td>
              <td>{{ Carbon\Carbon::parse($appl->created_datetime)->format('d, M Y h:i:s a')}}</td>

              
              
              
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
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel1"></h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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



@endsection

@section('script')
@include('newvendorzone.js.commonjs')
<script>
    function stripslashes(str) {
str=str.replace(/\\'/g,'\'');
str=str.replace(/\\"/g,'"');
str=str.replace(/\\0/g,'\0');
str=str.replace(/\\\\/g,'\\');
return str;
}
    
    

    function popmodalremarks(appid){
      var data= <?php echo json_encode($getapplications); ?>;
      console.log(data.length);
         $("#myModalLabel1").html("Application Number : "+ appid);    
        
        var content;
        
if (data.length != 0) {
  $.each(data, function(k,v){
    
      if(v.app_id == appid){
        if (v.Employee_No == '') {v.Employee_No = 'Nil';}
        content = `<div style="height:300px;overflow-y:scroll;">
          <ul>
            <li><b>Referred Employee No./Name:</b> `+ v.Employee_No+`</li>
            <li><b>Applicant Name:</b> `+v.Title +` `+v.First_Name+` `+v.Last_Name+`</li>
            <li><b>Applicant Job Code:</b> `+ v.Job_Code+`</li>
            <li><b>Date of Birth:</b> `+ (v.Date_of_Birth).substring(8,6)+`-`+(v.Date_of_Birth).substring(6,4)+`-`+(v.Date_of_Birth).substring(0,4)+`</li>
            <li><b>Gender:</b> `+ v.Gender+`</li>
            <li><b>Marital Status:</b> `+ v.Marital_Status+`</li>
            <li><b>Nationality:</b> `+ v.Nationality+`</li>
            <li><b>Languages Known:</b> `+ v.Correspondence_Language+`</li>
            <li><b>House No and Street:</b> `+ v.House_No_and_Street+`</li>
            <li><b>Address Line 2:</b> `+ v.Address_Line_2+`</li>
            <li><b>City:</b> `+ v.City+`</li>
            <li><b>Region:</b> `+ v.Region+`</li>
            <li><b>District:</b> `+ v.District+`</li>
            <li><b>Postal Code:</b> `+ v.Postal_Code+`</li>
            <li><b>Country:</b> `+ v.Country+`</li>
            <li><b>Mobile Number:</b> `+ v.Telephone_Number+`</li>
            <li><b>E-Mail Address:</b> `+ v.Mail_Address+`</li>
            <li><b>Education Establishment:</b> `+ v.EDUCATION_ESTABLISHMENT+`</li>
            <li><b>Education From date:</b> `+ (v.Edu_From_date).substring(8,6)+`-`+(v.Edu_From_date).substring(6,4)+`-`+(v.Edu_From_date).substring(0,4) +`</li>
            <li><b>Education To date:</b> `+ (v.Edu_To_date).substring(8,6)+`-`+(v.Edu_To_date).substring(6,4)+`-`+(v.Edu_To_date).substring(0,4) +`</li>
            <li><b>Institute:</b> `+ v.Institute +`</li>
            <li><b>Country Education:</b> `+ v.Country_Edu +`</li>
            <li><b>Certification:</b> `+ v.Certification +`</li>
            <li><b>Mark:</b> `+ v.Mark +`</li>
            <li><b>Last Employer:</b> `+ v.EMPLOYER +`</li>
            <li><b>Last Emp From date:</b> `+ (v.Emp_From_date).substring(8,6)+`-`+(v.Emp_From_date).substring(6,4)+`-`+(v.Emp_From_date).substring(0,4)+`</li>
            <li><b>Last Emp To date:</b> `+ (v.Emp_To_date).substring(8,6)+`-`+(v.Emp_To_date).substring(6,4)+`-`+(v.Emp_To_date).substring(0,4)+`</li>
            <li><b>City Emp:</b> `+ v.City_Emp+`</li>
            <li><b>Country Emp:</b> `+ v.Country_Emp+`</li>
            <li><b>Industry:</b> `+ v.Industry+`</li>
            <li><b>Employment Type:</b> `+ v.Employment_Contract+`</li>
            <li><b>Designation Applied For:</b> `+ v.Designation+`</li>
            <li><b>Department Applied For:</b> `+ v.Department+`</li>
            <li><b>Current Designation:</b> `+ v.Current_Designation+`</li>
            <li><b>Current CTC:</b> `+ v.Current_CTC+`</li>
            <li><b>Reason for Leaving:</b> `+ v.Reason_for_Leaving+`</li>
            <li><b>Total Years of Experience:</b> `+ v.Total_Years_of_Experience+`</li>
            <li><b>Applied Date:</b> `+ v.created_datetime+`</li>
          </ul>
        </div>`;
      }
  });
        
      }
        $(".modal-body").html(content);
        
        //$("#bidno").val(bidno);
        $('#myModal').modal('show'); 
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

<script>
$(document).ready(function() {
    var table = $('#example').DataTable( {
        rowReorder: false,
        responsive: false,
        "scrollX": true,
        paging: true,
         dom: 'Bfrtip',
         buttons: [
             'copy', 'csv', 'excel', 'pdf', 'print'
         ],
         pageLength: 10
    } );
    
    
} );    
    
</script>




@endsection
