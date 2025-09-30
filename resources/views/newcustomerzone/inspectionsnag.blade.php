@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Customer Zone| Inspection Snag Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newcustomerzone.styles.commoncss')

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

@foreach($getcustomerdata as $customer)


 
  @include('newcustomerzone.header.index')
  @include('newcustomerzone.aside.index')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
	
	<div class="row">
		<div class="col-md-10 col-md-offset-1">

	@include('newcustomerzone.contenttop')


      	</div>
	</div>



	<div class="row">
		
    <div class="col-md-12">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-commenting margin-r-5"></i> Inspection Snag </h3>
                
                
                 @if(count($projects) > 0)
                
									<?php
                                    $valid = 0;
                                    $overallsnagperproject_created = 0;
                                     ?>
									@foreach($projects as $pro)
									@if(($pro->milestone == 'X')&&($pro->posession == null)&&($pro->snagcreatedbyuser == null)&&(Carbon\Carbon::now()->lte(Carbon\Carbon::parse($pro->dlp_end_date))))
										<?php $valid += 1; ?>
										@endif
									@endforeach
                                        
                                    
									@if($valid != 0)
                <span class="pull-right" ><a href="{{ url('/customerzone/createsnag') }}" class="btn btn-danger btn-xs"><i class="fa fa-plus margin-r-5"></i> Create Snag</a></span>
																		
									@endif
											
									@else
									<script>alert("Not a Valid to create Snag!");
										window.location.href="/customerzone/dashboard";
										</script>

                 @endif
               
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
             <th>Project Name</th>
             <th>Flat Number</th>
			 <th>Snag Description</th>
			 <th>Overall Completion Status</th>
             <th>Snag Created Date</th>
             <th>Update Snag</th>
             <th>Expected Date of Completion</th>
            </tr>
        </thead>
       
        <tbody>
           @if((count($projects) > 0)&&(count($snag) > 0))
													@foreach($projects as $proj)
														@if($proj->snagcreatedbyuser != null)
															<tr>
															<td>{{$proj->pname}}</td>
															<td>{{$proj->unit_nm}}</td>
															<td align='center'><a href="#" class="btn btn-danger btn-xs" onclick="popmodel('{{$proj->unit}}', {{$proj->project_id}})" >Click to View</a></td>
															<td>
															<?php
                                                            $overall = 0;
                                                            foreach ($snag as $value) {
                                                                if (($value->project_id == $proj->project_id) && ($value->unit_no == $proj->unit)) {
                                                                    if ($value->vgn_status == 'OPEN') {
                                                                        $overall += 1;
                                                                    }
                                                                }
                                                            }

                                                            if ($overall == 0) {
                                                                echo 'CLOSED';
                                                            }
                                                            if ($overall > 0) {
                                                                echo 'OPEN';
                                                            }
                                                            ?>
															
															</td>
															<td>
															
															<?php
                                                                foreach ($snag as $value1) {
                                                                    if (($value1->project_id == $proj->project_id) && ($value1->unit_no == $proj->unit)) {
                                                                        echo $value1->snag_created_date;
                                                                    }
                                                                    break;
                                                                }
                                                            ?>
															
															</td>
															<td align='center'>
															<?php
                                                                foreach ($snag as $value2) {
                                                                    if (($value2->project_id == $proj->project_id) && ($value2->unit_no == $proj->unit)) {
                                                                        $date = date_create($value2->snag_created_date);
                                                                        date_add($date, date_interval_create_from_date_string('1 days'));
                                                                        $converteddate = date_format($date, 'Y-m-d H:i:s');

                                                                        $todaydatetime = date('Y-m-d H:i:s');

                                                                        if ($todaydatetime > $converteddate) {
                                                                            echo '-';
                                                                        } else {
                                                                            ?>
																		<a href="{{ url('/customerzone/updatesnag')}}/{{$proj->project_id}}/{{$proj->unit}}" class="btn btn-danger btn-xs">Update Snag</a>
																		<?php
                                                                        }
                                                                    }
                                                                    break;
                                                                }
                                                            ?>
															</td>
															@if($snag[0]->Expecteddateofcomp != '0000-00-00')
															<td>{{$snag[0]->Expecteddateofcomp}}</td>
															@else
															<td>-</td>
															@endif
															
															
															</tr>
														@endif
													@endforeach
												@endif         
        </tbody>
    </table>          
                                            
                                             
                                              <br/><br/>
											<div class="well">
											<h5 style="text-decoration: underline;"><b>Note:</b></h5>
												<ul>
													<li>Snag points created can be edited within 24 hours from the date of snag created for the flat.</li>
												</ul>
											</div> 
                                             
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

  @include('newcustomerzone.footer')
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->



@endsection

@section('script')
@include('newcustomerzone.js.commonjs')
<script>
    function stripslashes(str) {
str=str.replace(/\\'/g,'\'');
str=str.replace(/\\"/g,'"');
str=str.replace(/\\0/g,'\0');
str=str.replace(/\\\\/g,'\\');
return str;
}
    
    function popmodel(unit,projid){
        var data=<?php echo json_encode($snag); ?>;
        var length=data.length;
        
        $("#myModalLabel").html("Snag Description");
        var result1="";
        var k;
				var ss = 1;
				for(i=0;i<length;i++)
					{
							
				if((unit==data[i]['unit_no'])&& projid==data[i]['project_id'])
					{
												
				result1+= ss+". "+stripslashes(data[i]['snag_desc'])+" : VGN Status - "+data[i]['vgn_status']+"<br>";
												
				ss++;
                    }
					}
				
        $(".modal-body").html(result1);
        $('#myModal').modal('show'); 
    }
    
    
    
   
</script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js" ></script>
<script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js" ></script>
<script>
$(document).ready(function() {
    var table = $('#example').DataTable( {
        rowReorder: false,
        responsive: true
    } );
    
    
} );    
    
</script>




@endsection
