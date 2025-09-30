@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Employee Eligibilities Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newemployeezone.styles.commoncss')

<!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/plugins/iCheck/all.css">


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
                <h3 class="box-title"><i class="fa fa-share-alt margin-r-5"></i> My Eligibilities </h3>
                
                
                
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
                
                <form action="{{ url('/employeezone/empeligibility')}}" name="eligibilityform" method="post">
		{{ csrf_field()}}
              
              
              
               <br>
			<div class="row">
            <div class="col-md-8 col-md-offset-2">
            
            <table class="table table-bordered">
                <tbody><tr>
                  
                  <th>S.No</th>
                  <th>List</th>
                  <th >Eligiblity based on
role</th>
                  <th >Employee received
confirmation</th>
                </tr>
                
              
                <tr>
                 <td>1</td>
                  <td>Mobile</td>
                  <td style="text-align: center;">
                    <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" "@if($orgelig['MOBILE'] == 'X') checked @endif" disabled>
                </label>
                               
              </div>
                  </td>
                  <td style="text-align: center;">
                       <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" name="emp-mobile" "@if($myelig['MOBILE'] == 'X') checked @endif">
                </label>
                               
              </div>
                  </td>
                </tr>
                
                <tr>
                 <td>2</td>
                  <td>Mail</td>
                  <td style="text-align: center;">
                    <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" "@if($orgelig['MAIL'] == 'X') checked @endif" disabled>
                </label>
                               
              </div>
                  </td>
                  <td style="text-align: center;">
                       <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" name="emp-mail" "@if($myelig['MAIL'] == 'X') checked @endif">
                </label>
                               
              </div>
                  </td>
                </tr>
                
                <tr>
                 <td>3</td>
                  <td>Laptop</td>
                  <td style="text-align: center;">
                    <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" "@if($orgelig['LAPTOP'] == 'X') checked @endif" disabled>
                </label>
                               
              </div>
                  </td>
                  <td style="text-align: center;">
                       <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" name="emp-laptop" "@if($myelig['LAPTOP'] == 'X') checked @endif">
                </label>
                               
              </div>
                  </td>
                </tr>
                
                <tr>
                 <td>4</td>
                  <td>Desktop</td>
                  <td style="text-align: center;">
                    <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" "@if($orgelig['DESKTOP'] == 'X') checked @endif" disabled>
                </label>
                               
              </div>
                  </td>
                  <td style="text-align: center;">
                       <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" name="emp-desktop" "@if($myelig['DESKTOP'] == 'X') checked @endif">
                </label>
                               
              </div>
                  </td>
                </tr>
                <tr>
                 <td>5</td>
                  <td>Business Card</td>
                  <td style="text-align: center;">
                    <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" "@if($orgelig['BUSINESSCARD'] == 'X') checked @endif" disabled>
                </label>
                               
              </div>
                  </td>
                  <td style="text-align: center;">
                       <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" name="emp-buisnesscard" "@if($myelig['BUSINESS_CARD'] == 'X') checked @endif">
                </label>
                               
              </div>
                  </td>
                </tr>
                <tr>
                 <td>6</td>
                  <td>ID Card</td>
                  <td style="text-align: center;">
                    <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" "@if($orgelig['IDCARD'] == 'X') checked @endif" disabled>
                </label>
                               
              </div>
                  </td>
                  <td style="text-align: center;">
                       <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" name="emp-idcard" "@if($myelig['ID_CARD'] == 'X') checked @endif">
                </label>
                               
              </div>
                  </td>
                </tr>
                
                <tr>
                 <td>7</td>
                  <td>SAP ID</td>
                  <td style="text-align: center;">
                    <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" "@if($orgelig['SAPID'] == 'X') checked @endif" disabled>
                </label>
                               
              </div>
                  </td>
                  <td style="text-align: center;">
                       <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" name="emp-sapid" "@if($myelig['SAP_ID'] == 'X') checked @endif">
                </label>
                               
              </div>
                  </td>
                </tr>
                
                <tr>
                 <td>8</td>
                  <td>Intercom</td>
                  <td style="text-align: center;">
                    <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" "@if($orgelig['INTERCOM'] == 'X') checked @endif" disabled>
                </label>
                               
              </div>
                  </td>
                  <td style="text-align: center;">
                       <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" name="emp-intercom" "@if($myelig['INTERCOM'] == 'X') checked @endif">
                </label>
                               
              </div>
                  </td>
                </tr>
                
                <tr>
                 <td>9</td>
                  <td>Training Kit</td>
                  <td style="text-align: center;">
                    <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" "@if($orgelig['TRAINING_KIT'] == 'X') checked @endif" disabled>
                </label>
                               
              </div>
                  </td>
                  <td style="text-align: center;">
                       <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" name="emp-trainingkit" "@if($myelig['TRAINING_KIT'] == 'X') checked @endif">
                </label>
                               
              </div>
                  </td>
                </tr>
                
                <tr>
                 <td>10</td>
                  <td>Diary</td>
                  <td style="text-align: center;">
                    <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" "@if($orgelig['DIARY'] == 'X') checked @endif" disabled>
                </label>
                               
              </div>
                  </td>
                  <td style="text-align: center;">
                       <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" name="emp-diary" "@if($myelig['DIARY'] == 'X') checked @endif">
                </label>
                               
              </div>
                  </td>
                </tr>
                <tr>
                 <td>11</td>
                  <td>CUG</td>
                  <td style="text-align: center;">
                    <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" "@if($orgelig['CUG'] == 'X') checked @endif" disabled>
                </label>
                               
              </div>
                  </td>
                  <td style="text-align: center;">
                       <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" name="emp-cug" "@if($myelig['CUG'] == 'X') checked @endif">
                </label>
                               
              </div>
                  </td>
                </tr>
		
		 <tr>
                 <td>12</td>
                  <td>ADDA</td>
                  <td style="text-align: center;">
                    <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" "@if($orgelig['ADDA'] == 'X') checked @endif" disabled>
                </label>
                               
              </div>
                  </td>
                  <td style="text-align: center;">
                       <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" name="emp-adda" "@if($myelig['ADDA'] == 'X') checked @endif">
                </label>
                               
              </div>
                  </td>
                </tr>

                <tr>
                 <td>13</td>
                  <td>NAME BOARD</td>
                  <td style="text-align: center;">
                    <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" "@if($orgelig['Name_Board'] == 'X') checked @endif" disabled>
                </label>
                               
              </div>
                  </td>
                  <td style="text-align: center;">
                       <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" name="emp-nameboard" "@if($myelig['Name_Board'] == 'X') checked @endif">
                </label>
                               
              </div>
                  </td>
                </tr>

		<tr>
                 <td>14</td>
                  <td>Employee Portal Access</td>
                  <td style="text-align: center;">
                    <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" "@if($orgelig['EPA'] == 'X') checked @endif" disabled>
                </label>
                               
              </div>
                  </td>
                  <td style="text-align: center;">
                       <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" name="emp-epa" "@if($myelig['EPA'] == 'X') checked @endif">
                </label>
                               
              </div>
                  </td>
                </tr>

                <tr>
                 <td>15</td>
                  <td>Finger Print Access/Access Card</td>
                  <td style="text-align: center;">
                    <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" "@if($orgelig['FPA'] == 'X') checked @endif" disabled>
                </label>
                               
              </div>
                  </td>
                  <td style="text-align: center;">
                       <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" name="emp-fpa" "@if($myelig['FPA'] == 'X') checked @endif">
                </label>
                               
              </div>
                  </td>
                </tr>

                <tr>
                 <td>16</td>
                  <td>Department Specific Software Logins</td>
                  <td style="text-align: center;">
                    <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" "@if($orgelig['DSL'] == 'X') checked @endif" disabled>
                </label>
                               
              </div>
                  </td>
                  <td style="text-align: center;">
                       <div class="form-group">
                <label>
                  <input type="checkbox" class="minimal-red" name="emp-dsl" "@if($myelig['DSL'] == 'X') checked @endif">
                </label>
                               
              </div>
                  </td>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align:center;"><button type="submit" class="btn btn-danger "><i class="fa fa-thumbs-up margin-r-5"></i>Confirm</button></td>
                </tr>
                
              </tbody></table>
            
            </div>
              <!-- checkbox -->
              </div>
              
                </form>
           
          <br>
										<p class="underline" style="margin-bottom:0;"><b>Note:</b></p>
										<ul style="margin:0;">
										<li>The items flagged above are eligible based on your role. Please coordinate with team HR to get the same.</li>
										<li> In spite of Eligibility , facilities are provided according to business needs of every role.</li>
										<li>The facilities are concerned, management decision is final.</li>
										</ul>
                
                
                
                
                   
                            
                                
                
              

              
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
<!-- iCheck 1.0.1 -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/plugins/iCheck/icheck.min.js"></script>
<script>
   function stripslashes(str) {
str=str.replace(/\\'/g,'\'');
str=str.replace(/\\"/g,'"');
str=str.replace(/\\0/g,'\0');
str=str.replace(/\\\\/g,'\\');
return str;
}
    
    
    
    
</script>

<script>
    
$(document).ready(function() {
               //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
		
    
    
} );    
    
</script>




@endsection
