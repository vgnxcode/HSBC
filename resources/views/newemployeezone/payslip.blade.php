@extends('newvendorzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Employee Payslip Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newvendorzone.styles.commoncss')

<style>
	.carousel-inner>.item>img
	{
		min-height: 280px;
	}
    #changedetailsForm label.col-sm-2 {
        font-weight: normal;
    }
     .box-header.with-border {
    border-bottom: 1px solid #f4f4f4;
    background: #dd4b39;
    color: #fff;
}
    
    .titl h2 {
    font-size: 18px;
    text-align: center;
    font-weight: 400;
    margin-top: 0px;
        
    /*line-height: 1.5;*/
    /*color: #01427a;*/
}
    
    .invoice{
        border: 0px;
            border-top: 3px solid #dd4b39;
    }
    .fweight600{
        font-weight: 600;
    }
    .greycolor{
        background: #f9f9f9;
    }
    .table-bordered>tbody>tr>td{
            border: 1px solid #A9A9A9;
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
		
    <div class="col-md-10 col-md-offset-1">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-file margin-r-5"></i> My Payslip </h3>
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
                
                
                <form class="form-horizontal" method="post" action="{{url('/employeezone/viewpayslip')}}" style="margin:0 5% !important;text-align:none !important;">
										{{csrf_field()}}
										
											<div class="form-group">												
												<div class="col-sm-12">
													<label for="paymonth" class="col-sm-2 ">Month / Year</label>
													<div class="col-sm-4">
														<select class="form-control userdropdown" name="paymonth" id="title" required>
															<option value="">Select</option>
				<option value="January" "@if($premonth == 'January') selected=selected @endif " >January</option>
                <option value="February" "@if($premonth == 'February') selected=selected @endif ">February</option>
				<option value="March" "@if($premonth == 'March') selected=selected @endif ">March</option>
				<option value="April" "@if($premonth == 'April') selected=selected @endif ">April</option>
				<option value="May" "@if($premonth == 'May') selected=selected @endif ">May</option>
				<option value="June" "@if($premonth == 'June') selected=selected @endif "> June</option>
				<option value="July" "@if($premonth == 'July') selected=selected @endif ">July</option>
				<option value="August" "@if($premonth == 'August') selected=selected @endif ">August</option>
				<option value="September" "@if($premonth == 'September') selected=selected @endif ">September</option>
				<option value="October" "@if($premonth == 'October') selected=selected @endif ">October</option>
				<option value="November" "@if($premonth == 'November') selected=selected @endif ">November</option>
				<option value="December" "@if($premonth == 'December') selected=selected @endif ">December</option>
															
															
														</select>
													</div>
													<div class="col-sm-4">
														<select class="form-control userdropdown" name="payyear" id="title" required>
															
															<?php 
															
																for($year=date('Y');$year>2011;$year--)
																{								?>								
				<option value="{{$year}}" "@if($current_year == $year) selected=selected @endif " >{{$year}}</option>
                                                            <?php
																}
															?>
														</select>
													</div>
													<input class="submitbtn btn btn-danger" name="submit" style="float: left;" type="submit" value="Submit">
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



@endsection

@section('script')
@include('newemployeezone.js.commonjs')
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/dist/js/printPreview.js"></script>
<script type="text/javascript">
        $(function(){
            $("#printbtn").printPreview({
                obj2print:'#invoiceprint',
                width:'877',
                title:'Payslip',
                resizable : 'yes'
                
                /*optional properties with default values*/
                //obj2print:'body',     /*if not provided full page will be printed*/
                //style:'',             /*if you want to override or add more css assign here e.g: "<style>#masterContent:background:red;</style>"*/
                //width: '670',         /*if width is not provided it will be 670 (default print paper width)*/
                //height:screen.height, /*if not provided its height will be equal to screen height*/
                //top:0,                /*if not provided its top position will be zero*/
                //left:'center',        /*if not provided it will be at center, you can provide any number e.g. 300,120,200*/
                //resizable : 'yes',    /*yes or no default is yes, * do not work in some browsers*/
                //scrollbars:'yes',     /*yes or no default is yes, * do not work in some browsers*/
                //status:'no',          /*yes or no default is yes, * do not work in some browsers*/
                //title:'Print Preview' /*title of print preview popup window*/
                
            });
              
        });
    </script>
@endsection
