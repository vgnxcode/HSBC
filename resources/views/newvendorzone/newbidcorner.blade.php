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
                <h3 class="box-title"><i class="fa fa-diamond margin-r-5"></i> New Bid Corner </h3>
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
                
                <th>Bid Number</th>
                <th>Bid Created On</th>
				<th>Bid Deadline Date</th>
				<th>Detailed Drawing Attachment</th>
				<th>Technical Eligibility</th>
				<th>Vendor Remarks</th>
            </tr>
        </thead>
         
        <tbody>
        @if(count($getbids['Bid_Details']) > 0)
           <?php $kk = 0; 
            $main = array();
            if(array_key_exists('0',$getbids['Bid_Details'])){
                $main = $getbids['Bid_Details'];
            }
            else
            {
                $main[0] = $getbids['Bid_Details'];
            }
            $concat = '';
            
                ?>
            @foreach($main as $bids)
              
               @if(!empty($bids['Bid_Number']))
               
               
               <?php
		if (count($detailedspec_attachments[$bids['Bid_Number']]) > 0) {
      $kkv = '/vendorzone/rateupdate/'.$bids['Bid_Number'];
      $detailedspec = '<a href="'.$kkv.'" class="btn btn-danger btn-sm quadrat" style="font-weight: bold;"><i class="fa  fa-image margin-r-5"></i> View Detailed Drawing</a>';
      
               }
               else{
                $detailedspec = '-';
               }
             $remarksmain = array();
            
            if(array_key_exists('Vendor_Remarks',$getbids) === true)
            {
                $newrem = array();
            if(array_key_exists('0',$getbids['Vendor_Remarks'])){
                $newrem = $getbids['Vendor_Remarks'];
            }
            else
            {
                $newrem[0] = $getbids['Vendor_Remarks'];
            }
                
                foreach($newrem as $remarks){
                    
                    if($bids['Bid_Number'] == $remarks['Bid_Number']){
                        $remarksmain = $remarks;
                    }
                }
            }
            
           
            
            if(count($remarksmain) > 0){
                $count = count($remarksmain) - 1;
                for($i = 1; $i <= $count; $i++){
                    
                    if(!empty($remarksmain["Remark$i"])){
                        $concat .= $remarksmain["Remark$i"];
                    }
                }
            }
            
            
            
            ?>
                
                 <tr>
                     
                     <td><a href="{{ url('/vendorzone/rateupdate')}}/{{$bids['Bid_Number']}}">{{ $bids['Bid_Number'] }}</a></td>
                     <td><a href="{{ url('/vendorzone/rateupdate')}}/{{$bids['Bid_Number']}}">{{ substr($bids['Bid_Created_On'], 0,4).'-'.substr($bids['Bid_Created_On'], 4,2).'-'.substr($bids['Bid_Created_On'], 6,2) }}</a></td>
                     <td><a href="{{ url('/vendorzone/rateupdate')}}/{{$bids['Bid_Number']}}">{{ substr($bids['Bid_Deadline'], 0,4).'-'.substr($bids['Bid_Deadline'], 4,2).'-'.substr($bids['Bid_Deadline'], 6,2) }}</a></td>
			<td>{!! $detailedspec !!}</td>
                     <td align='center'><a href="#" class="btn btn-danger btn-xs marg_left" onclick="popmodal('{{ $bids['Bid_Number'] }}')"><i class="fa  fa-hand-pointer-o margin-r-5"></i> View</a></td>
                     <td align='center'><a href="#" class="btn btn-danger btn-xs marg_left" onclick="popmodalremarks('{{ $concat }}', '{{ $bids['Bid_Number'] }}')"><i class="fa  fa-hand-pointer-o margin-r-5"></i> View/Update Remarks</a></td>
                 </tr>
                 <?php $kk++; ?>
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

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1">
 
 
  <div class="modal-dialog" role="document">
   <form class="form-horizontal" id="vendorremarksform" action="{{ url('/vendorzone/newbidcorner') }}" method="post">
   {{ csrf_field() }}
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel1"></h4>
      </div>
      <div class="modal-body">
       
           
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-default" >Send</button>
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

<script>
    function stripslashes(str) {
str=str.replace(/\\'/g,'\'');
str=str.replace(/\\"/g,'"');
str=str.replace(/\\0/g,'\0');
str=str.replace(/\\\\/g,'\\');
return str;
}
    
    function popmodal(clickedbid){
         $("#myModalLabel").html("Technical Eligibility");
        var result1="";
        var k;
        var mat_text1;
        var mat_text2;
        var mat_text3;
        var mat_text4;
        var mat_text5;
        var mat_text6;
        var mat_text7;
        var mat_text8;
        var mat_text9;
        var mat_text10;
        var mat_text11;
        
        
        <?php
        if(count($getbids['Bid_Details']) > 0){
            $i = 0; ?>
           <?php
            $main = array();
            if(array_key_exists('0',$getbids['Bid_Details']) === true){
                $main = $getbids['Bid_Details'];
            }
            else
            {
                $main[0] = $getbids['Bid_Details'];
            }
                ?>
        var jsonval=<?php echo json_encode($main);?>;
        
         $.each(jsonval,function(index,value){
             
             
                        if(clickedbid == value.Bid_Number){
                            
                            mat_text1 = "&nbsp; <strong>Minimum years of Experience - </strong> "+value.RO_TECH01+"<br/>";
                            mat_text2 = "&nbsp; <strong>Authorised Dealer Certificate - </strong> "+value.RO_TECH02+"<br/>";
                            mat_text3 = "&nbsp; <strong>Minimum Amount/Month Value - </strong> "+value.RO_TECH03+"<br/>";
                            mat_text4 = "&nbsp; <strong>Advance % - </strong> "+value.RO_TECH04+"<br/>";
                            mat_text5 = "&nbsp; <strong>ABG value if value of work above(in Lakhs) - </strong> "+value.RO_TECH05+"<br/>";
                            mat_text6 = "&nbsp; <strong>Performance BG % - </strong> "+value.RO_TECH06+"<br/>";
                            mat_text7 = "&nbsp; <strong>PBG if value of work above Retention% (in Lakhs) - </strong> "+value.RO_TECH07+"<br/>";
                            mat_text8 = "&nbsp; <strong>Warranty period (in months) - </strong> "+value.RO_TECH08+"<br/>";
                            mat_text9 = "&nbsp; <strong>Billing Submission periodicity(In Months) - </strong> "+value.RO_TECH09+"<br/>";
                            mat_text10 = "&nbsp; <strong>Credit Period from date of bill Submission - </strong> "+value.RO_TECH10+"<br/>";
                            mat_text11 = "&nbsp; <strong>Payment Terms - </strong> "+value.RO_TECH11+"<br/>";
                        /*   for(var i=1; i<=11; i++){
                                if(i<10){
                                   //console.log('RO_TECH'+i);
                                    content += value['RO_TECH0'+i]+' ';
                                    
                                }
                                else{
                                   
                                    content += value['RO_TECH'+i]+' ';
                                    
                                }
                        
                            }*/
                        }
                    });
        result1 = mat_text1 + mat_text2 + mat_text3 + mat_text4 + mat_text5 +mat_text6+
            mat_text7 + mat_text8 + mat_text9 + mat_text10 +mat_text11;
        
       <?php
    }else{
            ?>
        result1 = '';
        <?php
    }?>
				
        $(".modal-body").html(result1);
        $('#myModal').modal('show'); 
    }
    
    function popmodalremarks(remarks, bidno){
         $("#myModalLabel1").html("Vendor Remarks");		
        $("#vendorremarks").val(remarks);
        var content;
        
        content = ` <div class="row">
            
           <div class="col-md-12">
            
            <textarea name="vendorremarks" class="form-control" id="vendorremarks" cols="5" rows="5">{{$concat}}</textarea>
            <input type="hidden" class="form-control" name="bidno" id="bidno" value="`+bidno+`">
            </div>
            </div>`;
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
  $('.footer_bg ').hide();
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
