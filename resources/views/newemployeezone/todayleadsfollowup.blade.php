@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Today Leads Followup Page
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
                <h3 class="box-title"><i class="fa fa-file margin-r-5"></i> Today's Leads Followup Report </h3> 
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
                
               
                
                <form id="changedetailsForm" method="POST" action="" class="form-horizontal" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                          <table id="example" class="display nowrap" style="width:100%" >
        <thead>
            <tr>
                <th>S.No</th>
                <th>Lead No</th>
              <th>Name of the Lead</th>
        <th>Lead Classification</th>
        <th>Email Id</th>
        <th>Action</th>
        <th>Time</th>
        <th>Sales Executive ID</th>
        <th>Sales Executive Name</th>
        <th>Plant Code</th>
            </tr>
        </thead>
       
        <tbody>
           
            @if(count($result) > 0)
                          <?php $count = 1; ?>
                          @foreach($result['Details'] as $data)
                          @if($selectedplant != $data['Plant'])
                            @continue
                          @endif
                            <tr>
                            <td>{{$count}}</td>
                            <td>{{$data['Lead_No']}}</td>
                            <td>{{$data['Lead_Name']}}</td>
                            <td>{{$data['Lead_Class']}}</td>
                            <td>{{$data['Email']}}</td>
                            <td>{{$data['Action']}}</td>
                            <td>{{$data['Time']}}</td>
                            <td>{{$data['Employee_ID']}}</td>
                            <td>{{$data['Employee_Name']}}</td>
                            <td>{{$data['Plant']}}</td>
                                                      
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
    } );
    
    
} );    
    
</script>




@endsection
