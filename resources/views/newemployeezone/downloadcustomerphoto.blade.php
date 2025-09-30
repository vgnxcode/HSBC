@extends('newvendorzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Employee Zone| Download Customer Photo
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newvendorzone.styles.commoncss')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<link href="{{ asset('ltr/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">

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
                <h3 class="box-title"><i class="fa fa-download margin-r-5"></i> Download Customer Photo </h3>
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
              
                
                
                <form class="form-horizontal" method="post" action="{{url('/employeezone/downloadcustomerphoto')}}" >
										{{csrf_field()}}
							   
                 <div class="row">
                   
                  
                  <div class="col-md-4 col-md-offset-4">
                  <h5 style="font-weight: bold;"><i class="fa fa-search"></i> Search for Customer Uploaded Files</h5>
                  <select class="js-example-basic-single js-states form-control" id="projectname" name="projectname">
                    @if(count($projects_units_arr) > 0)
                    <option></option>
                      @foreach($projects_units_arr as $keyproj => $proj)
                          <option value="{{$keyproj}}">VGN {{$keyproj}}</option>
                      @endforeach
                    @endif
                </select>
<br><br>
                <select class="js-example-basic-single1 js-states form-control" id="unitname" name="unitname">
                  <option></option>
                </select>
                 
                 <!-- <input type="text" class="form-control" name="saleorderno" id="saleorderno" value="" placeholder="Enter Customer ID"> -->
                            <br><br>

                            <input type="submit" class="btn btn-danger" name="submit" value="Search" style="float: right;">
                     </div>
                   
                   

                 </div>			
										
							</form>



              <br>
              <h4>Note</h4>
              <ol>
                <li>Customer uploaded data will be displayed in the below table based on the customer care executive assigned to them.</li>
                <li>Enable the checkbox after the print is taken.</li>
                <li>Customer can edit or upload the photos until the print taken checkbox is enabled.</li>
              </ol>
              <br>
              @if(!empty($tabledata))
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-bordered" id="file_export">
                    
                    <thead style="color: #FFFFFF;background: #dd4b39;">
                      <tr>
                        <th style="text-align: center;">S.No</th>
                        <th style="text-align: center;">Saleorder Number</th>
                        <th style="text-align: center;">CustomerId</th>
                        <th style="text-align: center;">Customer Name</th>
			<th style="text-align: center;">Unit Name</th>
                        <th style="text-align: center;">No. of BHK</th>
                        <th style="text-align: center;">No. of Car Park</th>
                        <th style="text-align: center;">Uploaded File</th>
                        <th style="text-align: center;">Print Taken</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $i = 1;?>
                      @foreach($tabledata as $kk)
                      <tr>
                        <td style="text-align: center;">{{$i}}</td>
                        <td style="text-align: center;">{{$kk->saleorder}}</td>
                        <td style="text-align: center;">{{$kk->customerid}}</td>
                        <td style="text-align: center;">{{$kk->name}}</td>
			<td style="text-align: center;">{{$kk->unitname}}</td>
                        <td style="text-align: center;">{{$kk->no_of_bhk}}</td>
                        <td style="text-align: center;">{{$kk->no_of_carpark}}</td>
                        <td style="text-align: center;"><a href="/data_mnt/customeridcards/{{$kk->filename}}" download="{{$kk->plantname}}_{{$kk->unitname}}_{{$kk->customerid}}">Download</a></td>
                        <td style="text-align: center;">
                          @if($kk->taken_print_out == 'Y')
                          <input type="checkbox" id="printtaken" name="printtaken" value="{{$kk->id}}" checked=true >
                          @else
                          <input type="checkbox" id="printtaken" name="printtaken" value="{{$kk->id}}">
                          @endif
                        </td>
                      </tr>
                      <?php $i++; ?>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
              @endif
            
            
              
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

 <!--This page plugins -->
    <script src="{{ asset('ltr/assets/extra-libs/DataTables/datatables.min.js') }}"></script>
    <!-- start - This is for export functionality only -->
    <script src="//cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>

<script >
  $(document).ready(function(){

$('#file_export').DataTable({
    order: [ 1, 'asc' ],
    dom: 'Bfrtip',
    buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
    ]
});
$('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');

    $('.js-example-basic-single').select2({
    placeholder: "Select Project",
    allowClear: true
});

    $('.js-example-basic-single1').select2({
    placeholder: "Select Unit",
    allowClear: true
});
    
$('.js-example-basic-single').on('change', function() {
      var selecteddata = $(".js-example-basic-single option:selected").val();
      if (selecteddata != '') {
        var unitsdata = @json($unitsarray);
        $('.js-example-basic-single1').empty();
        //console.log(Object.keys(unitsdata).length);
        if (Object.keys(unitsdata).length > 0) {
          $.each(unitsdata,function (k,v) {
            //console.log(k);
            var unit = '';
            if (k == selecteddata) {

              var newOption;
               $.each(v,function (k1,v1) {
                console.log(v1.unitname);
                newOption = new Option(v1.unitname, v1.unitname, false, false);
                $('.js-example-basic-single1').append(newOption).trigger('change');
               });
              //console.log(newOption);
              //$('.js-example-basic-single1').append(newOption).trigger('change');
            }
          });
        }
        
      }
      else{
        //var newOption = new Option(null, null, false, false);
                //$('.js-example-basic-single1').append(newOption).trigger('change');
                setTimeout(function(){
                  $('.js-example-basic-single1').empty();
                },200);
                
      }
    });

    /*$("#projectname").on("change", function(e){
      //var projectname =  $('.js-example-basic-single').find(':selected');;
      alert('changed');
    });*/
  

    $("#printtaken").on('click', function(){
          if($(this).is(":checked")) {
            $.post('/employeezone/print_taken',{_token: '{{csrf_token()}}', 'takenid': $(this).val(),'taken': 'yes'}, function(data){
              if (data == 1) {
                alert('Marked as printed. Customer cannot edit this photo.');
              }
              else{
               alert('Somthing went wrong!'); 
              }

            });
           
        }
        else{
            
            $.post('/employeezone/print_taken',{_token: '{{csrf_token()}}', 'takenid': $(this).val(),'taken': 'no'}, function(data){
              if (data == 1) {
                alert('Marked as not printed. Customer can edit this photo.');
              }
              else{
               alert('Somthing went wrong!'); 
              }

            });

        }
        //$('#printtaken').val($(this).is(':checked'));
    });
  });
</script>


@endsection
