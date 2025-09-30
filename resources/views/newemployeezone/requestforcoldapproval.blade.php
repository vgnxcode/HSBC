@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Employee Request For Cold Approval Page
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
    #loading {position: fixed;width: 100%;height: 100%;left: 0;top: 0;right: 0;bottom: 0;display: block;background: #fff;z-index: 10000;}
      #loading img {position: absolute;top: 50%;left: 50%;margin: -23px 0 0 -23px;}
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
    <div id="loading">
      <img src="{{ config('app.AWS_URL')}}/images/spinner/loader-dark.gif" alt="Loading...">
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
                <h3 class="box-title"><i class="fa fa-tag margin-r-5"></i> Request For Cold Approval </h3>
                
                <span class="pull-right"><a href="/employeezone/leadsfollowup" class="btn btn-danger btn-xs"><i class="fa fa-backward margin-r-5"></i>Leads Followup Homepage</a></span>
                
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
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
                
                
                
                
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                          <table id="example" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>S. No.</th>
				<th>Lead No.</th>
				<th>Name of the Prospect</th>
				<th>COLD Req App Status</th>
				<th>COLD Req App Date</th>
                <th>Request for Cold Reason</th>
				<th>Telephone No.</th>
        <th>Email Id</th>
        <th>Plant</th>
        <th>Lead Source</th>
        <th>Sub Lead Type</th>
        <th>Budget Range</th>
        <th>Assigned to Executive</th>
        <th>L1 Emp No</th>
        <th>L1 Emp Name</th>
        <th>L2 Emp No</th>
        <th>L2 Emp Name</th>
        <th>L3 Emp No</th>
        <th>L3 Emp Name</th>
        <th>Created Date</th>
        <th>Lead Ageing</th>
        <th>Created By</th>
            </tr>
        </thead>
       
        <tbody>
           
           
                                                @if(!empty($mngrdata))
                                                
                                                    @foreach($mngrdata as $k => $data)
													                         @if($selectedplant != $data['Plant'])
                                                    @continue
                                                   @endif
                                                   <tr>     
													
                               <td>{{$data['S_No']}}</td>   
                               <td id="leadno">{{$data['Lead_No']}}</td>   
                               <td>{{$data['Lead_Name']}}</td>   
                               <td>
                                <select class="form-control forapproval" >
                                  <option value="REQ_APP" "@if($data['Cold_Status'] == 'REQ_APP') selected= selected @endif">Requested For Cold Approval</option>
                                  <option value="APPROVED" "@if($data['Cold_Status'] == 'APPROVED') selected= selected @endif">Approved</option>
                                  <option value="REJECTED" "@if($data['Cold_Status'] == 'REJECTED') selected= selected @endif">Rejected</option>
                                </select>
                               </td>   
                               <td>{{$data['Req_Appr_Date']}}</td>   
                               <td>{{$data['K_Cold']}}</td>
                               <td>{{$data['Tel_No']}}</td>   
                               <td>{{$data['Email_ID']}}</td>   
                               <td>{{$data['Plant']}}</td>                         
                               <td>{{$data['Lead_Source']}}</td>   
                               <td>{{$data['Sub_Lead_Type']}}</td>   
                               <td>{{$data['Budget_Range']}}</td>   
                               <td>{{$data['L0_Emp_Name']}}</td>   
                               <td>{{$data['L1_Emp_No']}}</td>   
                               <td>{{$data['L1_Emp_Name']}}</td>   
                               <td>{{$data['L2_Emp_No']}}</td>   
                               <td>{{$data['L2_Emp_Name']}}</td>   
                               <td>{{$data['L3_Emp_No']}}</td>   
                               <td>{{$data['L3_Emp_Name']}}</td>   
                               <td>{{$data['Created_Date']}}</td>   
                               <td>{{$data['Lead_Ageing']}}</td>  
                               <td>{{$data['Created_By']}}</td>   
                                               
                             </tr>

                                                        
													@endforeach
                          @endif        
        </tbody>
    </table>           
                                             
                       </div>
                   </div>
                            
                                
                
              

              
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
        <h4 class="modal-title" id="myModalLabel"></h4>
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

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2019 <a href="http://www.vgn.in">VGN Property Developers Pvt. Ltd</a>.</strong> All rights
    reserved.
  </footer>

  
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



@endsection

@section('script')
@include('newemployeezone.js.commonjs')
<script>
   function stripslashes(str) {
str=str.replace(/\\'/g,'\'');
str=str.replace(/\\"/g,'"');
str=str.replace(/\\0/g,'\0');
str=str.replace(/\\\\/g,'\\');
return str;
}
    
    /*function popmodal(complaintid){
        var data=<?php //echo json_encode($policy_array);?>;
        var length=data.length;
        
        $("#myModalLabel").html("Policy Description");
        var result1="";
        var k;
				//var distinct1=[];
				for(i=0;i<length;i++)
				{
                    //console.log(data[i]['HR_Policy_Ref_No']);
				if(complaintid == data[i]['HR_Policy_Ref_No'])
					{
                        k = i+1;
                        for(j=1; j<=200; j++){
				        if(data[i]['LINE'+j] != ''){
                            
                        result1+= stripslashes(data[i]['LINE'+j])+"<br>";
                        }
                        }
																
				
					}
				}
				
        $(".modal-body").html(result1);
        $('#myModal').modal('show'); 
    }*/
    
    
</script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js" ></script>
<script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js" ></script>
<script>
$(document).ready(function() {
    var table = $('#example').DataTable( {
       "order": [[ 0, "asc" ]],
        rowReorder: false,
        responsive: false,
        "scrollX": true,
        "scrollY": "300",
    paging: false
    } );
    
    
     $('.forapproval').on('change', function(){
      
      var row = $(this).closest('tr');
           var leadno = $.trim(row.find('#leadno').text());
           var forapproval = $(this).val();
           console.log(leadno+'----'+forapproval);
            if ((leadno != '') && (forapproval != '') && (forapproval != 'REQ_APP')) {
              $('#loading').show();
              var r = confirm("Please confirm to update lead:" + leadno+' with Status: '+forapproval);
        if (r == true) {
              $.post('/employeezone/forapproval_mngr',{_token:'{{csrf_token()}}',leadno: leadno,forapproval:forapproval}, function(data){
              $('#loading').hide();
              
                 if(data == 1){
                  
                     alert('Updated Successfully!');
                     window.location.reload();
                 }
                 else{
                  alert('Failed to update. Try Again');
                     window.location.reload();
                 }
            });   
        }
        $('#loading').hide();
            }
           
    });
    
    
} );    
    
</script>

<script>
      $(window).on('load',function(){
             setTimeout(function() {
                 $('#loading').fadeOut( 400, "linear" );
              }, 300);
      });
      
    </script>


@endsection
