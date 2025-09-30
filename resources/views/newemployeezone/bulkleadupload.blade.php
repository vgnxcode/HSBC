@extends('newemployeezone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Bulklead Upload Page
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

    .dataTables_scrollBody {
      height: auto !important;;
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
                <h3 class="box-title"><i class="fa fa-upload margin-r-5"></i> Bulk Lead Upload </h3>                
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              
               <div class="col-sm-6 col-sm-offset-3">

                 @if(session()->has('invalidids'))
                <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                @foreach (Session::get('invalidids') as $error)
                  {{$error}}<br />
              @endforeach
              </div>
                <br>
         @endif
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
                       <div class="col-md-10 col-md-offset-1">
                           
                          <table id="example" class="display nowrap" style="width:100%" >
        <thead style="background: #dd4b39;color: #fff;">
            <tr style="text-align: center;">
                              <th>S.No</th>
                              <th>Plant Code</th>
                              <th>Plant Description</th>
                              <th>Name of Campaign</th>
                              <th>Campaign Code</th>
            </tr>
        </thead>
       
        <tbody>
           <?php $i = 1;?>
                            @if(count($getactivecampaigns_list) > 0)
                      @foreach($getactivecampaigns_list['Details'] as $k => $v)
                      <tr style="text-align: center;">
                              <td>{{$i}}</td>
                              <td>{{$v['PLANT']}}</td>
                              <td>{{$v['PLANT_DESCRIPTION']}}</td>
                              <td>{{$v['MARKETING_CAMPAIGN_NAME']}}</td>
                              <td>{{$v['MARKETING_CAMPAIGN_CODE']}}</td>
                            </tr>
                            <?php $i++; ?>
                      @endforeach
                      @endif
                    
        </tbody>
    </table>           
                                             
                       </div>
                   </div>
                            
                                
                


                <div class="row">
                  <div class="col-md-10 col-md-offset-1">
                    <h5 class="text-bold">Note:</h5>
          <ol>
            <li>The above table displays plant wise all the active campaign codes that are created under the marketing channel (12 : EXHIBITIONS in SAP).Active campaign code means the proposed end date of the campaign is not in the past.</li>

<li>Click on the down load sample file to view the sample for uploading the lead data in to the SAP system. Lead name, Telephone number, email, plant and campaign code and Employee ID to be uploaded from the excel. In the above email id alone is optional and others are mandatory.</li>
<li>Click on choose file to select the excel file from the folder. Once loaded, system will pop up with lead uploaded successful message. While uploading system will check if the campaign code assigned to the lead is an active campaign code or not and also system will check if the active campaign code is of the same plant if not system will throw error message. Also system will allow to use campaign codes that are created under the marketing channel (12 : EXHIBITIONS in SAP)</li>
<li>Please note while uploading the system will validate the employee code and if the same is available in L0 of that plant in SAP transaction ZSD_SALES_SITE in that sales organization tab. If the employee code is not available in the L0 of the plant then system will throw error message. Instead of lead getting auto distributed by the system here once the employee code is directly assigned to the lead. System will go through the lead distribute (zsd_distribute) but since the executive is assigned from here it self-there no changes will happen.</li>
          </ol>
                  </div>
                </div>
              

              <div class="row">
                  
              
                
                
          <form class="form-horizontal" method="post" action="{{url('/employeezone/bulkleadupload')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                 
                 <div class="row" >
                       <div class="col-md-10 col-md-offset-1">

 <div class="form-group">
                        <label for="file_upload" class="col-sm-2">File Upload</label>
                        
                          <div class="col-sm-4">
                            
                          <input type="file" name="file_upload" class="form-control" id="file_upload" required="true">
                          <p>File format: .xlsx allowed, <a href="{{asset('/Bulklead Upload File Format.xlsx')}}" download>(<i class="fa fa-download"></i> Download Sample File)</a></p>
                          
                          {!! $errors->first('file_upload', '<span class="errortext text-red">:message</span>') !!}
                          </div>                  
                        
                      </div>
                  
                  <div class="form-group" style="margin-left:15%;">
                    <div class="col-sm-12">
                        <div class="col-sm-3">
                        
                        <input class="submitbtn btn btn-danger" id="submit" type="submit" value="Upload"/>
                        </div>                
                      </div>
                    </div> 



        
                           
                     
                                 
                                     
                                             
                       </div>
                   </div>
                    
              </form>
            
                </div>

              
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
