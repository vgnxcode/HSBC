@extends('newvendorzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Vendor Zone| New Bid Rateupdate Page
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
                <h3 class="box-title"><i class="fa fa-diamond margin-r-5"></i> REFERENCE NO: {{ $refno}} </h3><span class="pull-right" ><a href="{{ url('/vendorzone/newbidcorner') }}" class="btn btn-danger btn-xs"><i class="fa fa-arrow-circle-left margin-r-5"></i>Back</a></span>
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
                           <form action="#" name="bidform" id="bidform">
                           {{csrf_field()}}
                          <table id="example" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Material/Service No</th>
                <th>Description</th>
                <th>UOM</th>
                <th>Detailed Drawing</th>
				<th>Brand</th>
				<th>Quantity</th>
				
				<th>Detailed Spec.</th>
				<th>Rate</th>
				<th>Net Value</th>
           <th>Project No</th>
				<th>Project Name</th>
            </tr>
        </thead>
         
        <tbody>
         
           @if(count($getbids['Bid_Details']) > 0)
           <?php $kk = 0; ?>
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
               
            @foreach($main as $bids)
               
               <?php
             $getmaterial = array();
            
            if(array_key_exists('Bid_Details_full',$getbids) === true)
            {

                $newmatbids=array();
                if(array_key_exists('0',$getbids['Bid_Details_full'])){
                   $newmatbids = $getbids['Bid_Details_full'];
                }else{
                    $newmatbids[0] = $getbids['Bid_Details_full'];
                }

                //dd($newmatbids);
                
                $test = 0;
                foreach($newmatbids as $matbids){

                    if($refno == $matbids['Reference_No']){
                        if($matbids['Show_Indicator'] == 'X'){
                            $test +=1;
                        $getmaterial[] = $matbids;
                        }
                        
                    }
                }
                
                if($test == 0){
                     foreach($newmatbids as $matbids){
                    if($refno == $matbids['Reference_No']){
                        if($matbids['Show_Indicator'] == ''){
                            $test +=1;
                        $getmaterial[] = $matbids;
                        }
                        
                    }
                }
                }
            }
            ?>
            @endforeach
            
             <?php /*echo '<pre>';
            var_dump($getmaterial);
            echo '</pre>';*/
            ?>
            
                <?php 
            $sumgross = 0;
            $kval = 110;
            //var_dump($getmaterial);
            ?>
                @foreach($getmaterial as $material)
                
               
               <?php
            $multiplyval = ((float)$material['Bid_Rate']) * ((float)$material['Quantity']);
             $specarray = array();
            
            if(array_key_exists('Detailed_Spec',$getbids) === true)
            {
                $newspec = array();
                if(array_key_exists('0',$getbids['Detailed_Spec'])){
                   $newspec = $getbids['Detailed_Spec'];
                }else{
                    $newspec[0] = $getbids['Detailed_Spec'];
                }
                foreach($newspec as $spec){
                    if($material['Material_No'] == $spec['MAT_No']){
                        $specarray = $spec;
                    }
                }
            }
            
            $concat = '';
            if(count($specarray) > 0){
                $count = count($specarray) - 2;
                for($i = 1; $i <= $count; $i++){
                    
                    if(!empty($specarray["Line_$i"])){
                        $concat .= $specarray["Line_$i"];
                    }
                }
            }
            
            
            
            $bidterms = '';
            //var_dump($getbids);
            if(array_key_exists('Bid_Details',$getbids) === true)
            {
                 $bidt = array();   
                if(array_key_exists('0',$getbids['Bid_Details'])){
                    $bidt = $getbids['Bid_Details'];
                }else{
                    $bidt[0] = $getbids['Bid_Details'];
                }
                
                 foreach($bidt as $nbidt){
                  
                    if($nbidt['Bid_Number'] == $refno){
                
                for($i = 01; $i <= 25; $i++){
                    
                    if($i < 10){
                        $i = '0'.$i;
                    }
                    if(!empty($nbidt["Line_$i"])){
                        $bidterms .= $nbidt["Line_$i"];
                    }
                    
                }
                        continue; 
                    }
                 }
            
            }
            
            
            
            
            
            ?>
                
                 <tr>
                     
                     <td class="materialno">{{ ltrim($material['Material_No'], '0') }}</td>
                     <td class="mat_text">{{ $material['Materila_Text'] }}</td>
                     <td>{{ $material['Unit'] }}</td>
                     <?php
                        if(array_key_exists($refno, $detailedspec_attachments)){

                            if(count($detailedspec_attachments) > 0){
                                $linktoshow = '';
                                foreach($detailedspec_attachments[$refno] as $kk =>$vv){
                                    
                                    if($vv['br_name'] == $material['Brand_name'] ){
                                        $linktoshow = '<a href="'.$vv['br_link'].'" class="btn btn-danger btn-sm quadrat" style="font-weight: bold;" target="_blank"><i class="fa  fa-image margin-r-5"></i> View Detailed Drawing</a>';
                                    }
                                }
                            }

                        }
                        else{
                            $linktoshow = '-';
                        }
                     ?>
                     <td class="detaileddrawing">{!! $linktoshow !!}</td>
                     <td class="brandname">{{ $material['Brand_name'] }}</td>
                     <td class='quantitybid' id='q{{ ltrim($material["Material_No"], "0") }}'>{{ $material['Quantity'] }}</td>
                    
                     <td align='center'><a href="#" class="btn btn-danger btn-xs marg_left" onclick="popmodal('{{ $concat }}')"><i class="fa  fa-hand-pointer-o margin-r-5"></i> View</a></td>
                     <td class="BRate"><input type='text' size='8' name='bids[{{$kk}}][Rate]' class='bidratevalue' onkeypress='return isNumberKey(this)' value="{{ $material['Bid_Rate'] }}" bidid="{{ ltrim($material['Material_No'], '0') }}" newtitle='{{$kval}}'></td>

                     <td id='net{{ ltrim($material["Material_No"], "0") }}{{$kval}}'>{{ $multiplyval }}</td>   
                     
                     <td>{{ $material['Project_no'] }}</td>
                     <td>{{ $material['Project_name'] }}</td>                  
                 </tr>
                 <?php
                $kk++;
                $kval++;
                $sumgross += $multiplyval;
            ?>
            @endforeach
                  @endif
        </tbody>
         
        
    </table>
    </form>
    <br>
    <div class="row">
    
    <div class="col-md-4 col-md-offset-4">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-rupee"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Gross Total</span>
              <span class="info-box-number" id="gross">{{$sumgross}}</span>
              <button type="button" class="btn btn-danger pull-right" id="updatebid"><i class="fa fa-thumbs-up margin-r-5"></i>Update Rate</button>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        </div>
    
											<br/><br/>                       

       <div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Bid Terms</h3>
    
    <!-- /.box-tools -->
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    {{$bidterms}}
  </div>
  
</div>
<!-- /.box -->
        
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
        <p id="para"></p>
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
    
    function popmodal(detailspec){
         $("#myModalLabel").html("Detailed Specification");
        
        
                
        
        result1 = detailspec;
        
       
				
        $(".modal-body").html(result1);
        $('#myModal').modal('show'); 
    }

      
    
   
</script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js" ></script>
<script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js" ></script>
<script>
$(document).ready(function() {
    
    
    
    $("#updatebid").on('click',function(){

        var bids = <?php echo json_encode($getmaterial); ?>;
												
											var array_data = [];
											var array_datanew = [];
											$('#bidform tr').each(function() {
                                                
                                                var materialnew1 = $(this).find(".materialno").text();
                                                var bratenew1 = $(this).find(".BRate").find("input").val();
                                                var refno = "{{$refno}}";
												
												var materialtext1 = $(this).find(".mat_text").text();
												var brandtext1 = $(this).find(".brandname").text();
                                                
												
												
												
                                                $.each( bids, function( key, value ) {
                                                  //console.log( key + ": " + value.mat_no );
                                                    var mat_no = bids[key].Material_No;
                                                mat_no = mat_no.replace(/^0+/, '');
                                                    if((mat_no == materialnew1)&&(value.Brand_name == brandtext1)&&(value.Materila_Text == materialtext1))
                                                    {
                                                        //console.log(value.mat_no+' '+value.brand_name+''+bratenew1);
                                                        
                                                        	array_data.push({
													"Rate" : bratenew1,
													"Reference_No" : refno,
													"Material_No" : mat_no,
													'Materila_Text' : value.Materila_Text,
													'Unit' : value.Unit,
													'Brand_name' : value.Brand_name,
													'Quantity' : value.Quantity,
													'Project_no' : value.Project_no,
													'Project_name' : value.Project_name,

													});
															
                                                    }
                                                });
												
    										
 											});
 											
 											//console.log(array_data);
								
										$.ajax({
									    type: "POST",
									    url: "/vendorzone/rateupdate/{{$refno}}",
									    data:{_token: "{{ csrf_token() }}",bidataArray : array_data },
									    //dataType: "json",
									    success: function(data) {  
                      console.log(data); 							
                                            alert(data);
    										//swal({ title: "<h3>Vendor update status</h3>",   text: data,   html: true });
									    }
									});


									

									

										});

     $(".bidratevalue").on("change",function(){
      console.log('change');
                        var cval = parseFloat($(this).val());
                                                                  
                        var matno = $(this).attr("bidid");
                        var uniqueno = $(this).attr("newtitle");
                        var qval = parseFloat($("#q"+matno).text());
                        var concatnet = 'net'+matno+uniqueno;
                                  console.log(concatnet) ;
                                  
					if($.isNumeric( cval))
					{
                        //console.log(qval*cval) ;
                                       $("#"+concatnet).text(qval*cval);
                                       console.log($("#"+concatnet).val());
					}
					else{
						$("#"+concatnet).text("0");
					}
                                            //console.log(matno);
                                            
                    });
    
    function getgross(){
          var bids = <?php echo json_encode($getmaterial); ?>;
              
                                            var addvalue = 0;
                                              var kval = 110;
                                            $.each(bids,function(index,value){
                                                var matno = bids[index].Material_No;
                                                matno = matno.replace(/^0+/, '');
                                                
                                                var concatgross = 'net'+matno+kval;
                                                var total = parseFloat($("#"+concatgross).text());
                                                if($.isNumeric( total))
												{
													addvalue = addvalue + total;
												}
												else{
													addvalue = addvalue + 0;
												}
                                                
                                                kval++;
                                               
                                            });
                                            
                                            return addvalue;
                                        }

                                             $(".bidratevalue").on("change",function(){
                                                var grossval = getgross();
												if($.isNumeric( grossval))
												{
                                                $("#gross").text(grossval);
												}
												else{
													$("#gross").text("0");
												}
                                            });
  
    
    var table = $('#example').DataTable( {
        
        "order": [[ 0, "desc" ]],
        rowReorder: false,
        responsive: false,
         "scrollX": true,
		paging: false
    } );
} );    
</script>


@endsection
