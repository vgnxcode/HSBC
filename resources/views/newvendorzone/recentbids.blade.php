@extends('newvendorzone.layout')

@section('title')
VGN Property Developers |Vendor Zone| My Recent Bids Page
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
    
    .modal-header {
    background-color: #EF5350;
    color: #fff;
    font-weight: bold;
}

</style>
<script type="text/javascript">
      function isNumberKey(evt)
      {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode == 46)
            return true
        if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
        
        return true;
      }


</script>
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
                <h3 class="box-title"><i class="fa fa-cubes margin-r-5"></i> My Recent Bids </h3>
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
                
                <th>Bid Number</th>
                <th>Bid Created On</th>
				<th>Bid Deadline Date</th>
				<th>Vendor Remarks</th>

            </tr>
        </thead>
         
        <tbody>
           @if(count($recentbids) > 0)
           
           <?php
           /* $getrecentbidsarray = array();
            if(!array_key_exists("0", $recentbids)){
                $getrecentbidsarray[0] = $recentbids;
            }
            else{
                $getrecentbidsarray = $recentbids;
            }*/
            
            $kk = 0;
            $concat  = array();
            ?>
          
            @foreach($recentbids as $bids)
             
              <?php
            if(!empty($bids['Bid_Number'])){
             $dd = 1;  ?>
              
              @foreach($newremarks as $remark)
                  <?php
            
            if($bids['Bid_Number'] == $remark['Bid_Number']){
                
            if(!empty($remark["Remark$dd"])){
                    $concat[$bids['Bid_Number']][] = $remark["Remark$dd"];
            }
            }
                ?>
              @endforeach
                
                 <tr>
                     
                     <td class="bidno"><a href="{{ url('/vendorzone/myrecentbids')}}/{{$bids['Bid_Number']}}" >{{ $bids['Bid_Number'] }}</a></td>
                     <td><a href="{{ url('/vendorzone/myrecentbids')}}/{{$bids['Bid_Number']}}">{{ substr($bids['Bid_Created_On'], 0,4).'-'.substr($bids['Bid_Created_On'], 4,2).'-'.substr($bids['Bid_Created_On'], 6,2) }}</a></td>
                     <td><a href="{{ url('/vendorzone/myrecentbids')}}/{{$bids['Bid_Number']}}">{{ substr($bids['Bid_Deadline'], 0,4).'-'.substr($bids['Bid_Deadline'], 4,2).'-'.substr($bids['Bid_Deadline'], 6,2) }}</a></td>
                     
                     <td align='center'><a href="#" class="btn btn-danger btn-xs marg_left" onclick="popmodalremarks('{{ $bids['Bid_Number'] }}')"><i class="fa  fa-hand-pointer-o margin-r-5"></i> View</a></td>
                 </tr>
                 <?php $kk++; } ?>
            @endforeach
                  @endif
        </tbody>
         
        
    </table>
    
											<br/><br/>                       
        
											<br/><br/>           
                                             
                       </div>
                   </div>
                            
                                
                
              

              
            </div>
            <!-- /.box-body -->
          </div>

    </div>


		

		
	</div>
	
	


<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1">
 
 
  <div class="modal-dialog" role="document">
   
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel1"></h4>
      </div>
      <div class="modal-body">
       
           
        
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
    <strong>Copyright &copy; 2019 <a href="http://www.vgn.in">VGN Projects Estates Pvt. Ltd</a>.</strong> All rights
    reserved.
  </footer>

  
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
    
    
    
    function popmodalremarks(remarks){
         $("#myModalLabel1").html("Vendor Remarks");		
        $("#vendorremarks").val(remarks);
        var content;
        var remarksjson = <?php echo json_encode($concat); ?>;
        content = ''; 
        if(remarksjson[remarks] != undefined){
            for(var k = 0; k< remarksjson[remarks].length; k++){
                if(remarksjson[remarks][k] != undefined){
                content += remarksjson[remarks][k] + ' ';
                }
            }
        }
        
        
        
        $(".modal-body").html(content);
        
        //$("#bidno").val(bidno);
        $('#myModal1').modal('show'); 
    }
    
    
    
   
</script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js" ></script>
<script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js" ></script>
<script>
$(document).ready(function() {

 

    var table = $('#example').DataTable( {
        
        "order": [[ 1, "desc" ]],
        rowReorder: false,
        responsive: false,
        "scrollX": true,
		paging: false
    } );
} );    
</script>


@endsection
