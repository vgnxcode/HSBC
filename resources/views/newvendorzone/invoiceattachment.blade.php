@extends('newvendorzone.layout')
@section('title')
VGN Projects Estates Pvt Ltd |Vendor Zone| New Bid Corner Page
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
<!-- Select2 -->
<link rel="stylesheet" href="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/select2/dist/css/select2.min.css">
<style>
   .quadrat {
   -webkit-animation: NAME-YOUR-ANIMATION 1s infinite;  /* Safari 4+ */
   -moz-animation: NAME-YOUR-ANIMATION 1s infinite;  /* Fx 5+ */
   -o-animation: NAME-YOUR-ANIMATION 1s infinite;  /* Opera 12+ */
   animation: NAME-YOUR-ANIMATION 1s infinite;  /* IE 10+, Fx 29+ */
   }
   @-webkit-keyframes NAME-YOUR-ANIMATION {
   0%, 49% {
   background-color: rgb(117, 209, 63);
   border: 3px solid #e50000;
   }
   50%, 100% {
   background-color: #e50000;
   border: 3px solid rgb(117, 209, 63);
   }
   }
   .carousel-inner>.item>img
   {
   min-height: 280px;
   }
   #changedetailsForm label.col-sm-2 {
   font-weight: normal;
   }
   .modal-header {
   background-color: #EF5350;
   color: #fff;
   font-weight: bold;
   }
   .select2-container .select2-selection--single {
    height: 35px !important;
    width: 100% !important;
    min-width: 260px !important;
  }
  
</style>
@endsection
@section('bodycontent')
<body class="hold-transition skin-red fixed sidebar-mini">
   <!-- Site wrapper -->
   <div class="wrapper">
      @foreach($getvendordata as $vendor)
      @include('newvendorzone.header.index')
      @include('newvendorzone.aside.index')
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
         <!-- Content Header (Page header) -->
         <!-- Main content -->
         <section class="content">
            <div class="row">
               <div class="col-md-10 col-md-offset-1">
                  @include('newvendorzone.contenttop')
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="box box-danger">
                     <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-diamond margin-r-5"></i> Submit Invoice</h3>
                        <span class="pull-right"><a href="#" id="invoiceModel" class="btn btn-danger btn-xs"><i class="fa fa-edit margin-r-5"></i>Attach Invoice</a></span>
                     </div>
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
                           @if(count($errors) > 0)
                           <div class="alert alert-danger alert-dismissible">
                              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                              <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                              <ul>
                                 @foreach($errors->all() as $error)
                                 <li> {{ $error }}</li>
                                 @endforeach
                              </ul>
                           </div>
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
                                       <th>Serial No</th>
                                       <th>Plant </th>
                                       <th>PO No </th>
                                       <th>Vendor Invoice No</th>
                                       <th>Attachment</th>
                                       <th>Status</th>
                                       <th>Remarks</th>
                                    </tr>
                                 </thead>
                                 <tbody>
                                 @if(count($invoicedata) > 0)
                                    @foreach($invoicedata as $index => $invoice)
                                       @if(!empty($invoice['Attachemant']))
                                          <tr>
                                             <td class="">{{$index+1}}</td>
                                             <td class="">{{ $invoice['Plant_No'] }}</td>
                                             <td class="">{{ $invoice['PO_No'] }}</td>
                                             <td class="">{{ $invoice['Vendor_Invoice_No'] }}</td>
                                             <td class=""><a href="{{$invoice['Attachemant']}}" target="_blank" >Invoice Documents</a></td>
                                             <td class="">{{ $invoice['Status'] }}</td>
                                             <td class="">{{ $invoice['Remarks'] }}</td>
                                          </tr>
                                       @endif
                                    @endforeach
                                 @endif
                                 </tbody>
                              </table>
                              <br/><br/>           
                           </div>
                        </div>
                     </div>
                     <!-- /.box-body -->
                  </div>
               </div>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="myModal1" role="dialog" aria-labelledby="myModalLabel1">
               <div class="modal-dialog" role="document">
                  <form class="form-horizontal" id="vendorrinvoiceattachment" action="{{ url('/vendorzone/invoiceattachment') }}" method="post" enctype="multipart/form-data">
                     {{ csrf_field() }}
                     <div class="modal-content">
                        <div class="modal-header">
                           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                           <h4 class="modal-title" id="myModalLabel1">Invoice Attachment</h4>
                        </div>
                        <div class="modal-body">
                           <div class="row" style="margin-left:3px;">
                              <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="plantname" class="col-sm-3">Plant Name</label>
                                       <div class="col-sm-6">
                                       <select class="form-control  select2 smalldrop" name="plantname" id="plantname">
                                       <option value="">Choose Project Name</option>
                                       @if(count($projectlist) > 0)
                                          @foreach($projectlist as $index => $plantname)
                                             <option value="{{ $plantname['Plant_Code'] }}">{{ $plantname['Project_Name'] }} ({{ $plantname['Plant_Code'] }}) </option>
                                          @endforeach
                                       @endif
                                       </select>
                                       {!! $errors->first('plantname', '<span class="errortext text-red">:message</span>') !!}
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="ponumber" class="col-sm-3">PO Number</label>
                                       <div class="col-sm-6">
                                       <input type="text" id="ponumber" class="form-control" name="ponumber" required></input>
                                       {!! $errors->first('ponumber', '<span class="errortext text-red">:message</span>') !!}
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="invoicenumber" class="col-sm-3">Invoice Number</label>
                                       <div class="col-sm-6">
                                       <input type="text" id="invoicenumber" class="form-control" name="invoicenumber" required></input>
                                       {!! $errors->first('invoicenumber', '<span class="errortext text-red">:message</span>') !!}
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label for="attachment" class="col-sm-3">Attachment</label>
                                       <div class="col-sm-6">
                                       <input type="file" id="attachment"  name="attachment" required>
                                       {!! $errors->first('attachment', '<span class="errortext text-red">:message</span>') !!}
                                       </div>
                                    </div>
                              </div>
                           </div>
                        </div>
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-danger" >Send</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
            @endforeach
         </section>
         <!-- /.content -->
      </div>
      <!-- /.content-wrapper -->
      @include('newvendorzone.footer')
      <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
   </div>
   <!-- ./wrapper -->
   @endsection
   @section('script')
   @include('newvendorzone.js.commonjs')
    <!-- Select2 -->
<script src="{{ config('app.AWS_URL')}}/newcustomerzoneassets/bower_components/select2/dist/js/select2.full.min.js"></script>
   <script>
    
    $('#invoiceModel').on('click',function(){
      // $('.select2').select2();
        $('#myModal1').modal('show');
    });

   </script>
  
   <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
   <script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js" ></script>
   <script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js" ></script>
   <script>
      $(document).ready(function() {
         $('.footer_bg ').hide();
         $('.select2').select2({ dropdownAutoWidth: true, width: 'auto' });
          var table = $('#example').DataTable( {
              "order": [[ 0, "asc" ]],
              rowReorder: false,
              responsive: false,
              "scrollX": true,
      		paging: false
          });
      } );    
   </script>
   @endsection