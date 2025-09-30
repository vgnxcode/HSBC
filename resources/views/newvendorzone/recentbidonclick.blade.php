@extends('newvendorzone.layout')

@section('title')
VGN Property Developers |Vendor Zone| My Recent Bids On Click Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newcustomerzone.styles.commoncss')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
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
                <h3 class="box-title"><i class="fa fa-cubes margin-r-5"></i> REFERENCE NO: {{$refno}} </h3><span class="pull-right" ><a href="{{ url('/vendorzone/myrecentbids') }}" class="btn btn-danger btn-xs"><i class="fa fa-arrow-circle-left margin-r-5"></i>Back</a></span>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                  <label for="final_disc_perc" class="col-sm-5 control-label"><i class="fa fa-hand-o-right"></i> Overall Final Discount Percentage for all Materials/Services*</label>

                  <div class="col-sm-4">
                    <div class="input-group">
                    <input type="text" class="form-control" onkeypress="return isNumberKey(this)" name="final_disc_perc" id="final_disc_perc" placeholder="" value="" "@if($opentoeditnew == 'CLOSED') readonly="true" @endif" >
                    @if($opentoeditnew == 'OPEN')<div class="input-group-addon updatedisc_overall" style="background-color: #dd4b39; color: #fff; cursor: pointer;"> <i class="fa fa-check"></i></div>@endif
                    {!! $errors->first('final_disc_perc', '<span class="errortext text-red">:message</span>') !!}
                  </div>
                  </div>
     </div>
                </div>
              </div>
              
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


              
                <div class="col-md-4 col-md-offset-4">
                  <div class="callout callout-danger">
                    <h4 class="callout-header">Quoted Price Details</h4>
                                            <h5><span style="padding-right: 5px;">Overall Final discount percentage</span>: <b class="fin_per"></b></h5>
                                            <h5><span style="padding-right: 5px;">Final Net Value</span>: <b><i class="fa fa-rupee"></i> <span class="fin_tot"></span></b></h5>
                                            
                    </div>
                </div>
              
                
                
              
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                           
                          <table id="bidform" class="display nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                
                <th>Material/Service No</th>
                <th>Description</th>
				<th>UOM</th>
				<th>Brand</th>
				<th>Quantity</th>
				<th>Project No</th>
				<th>Project Name</th>
				<th>Detailed Spec.</th>
				<th>Quoted Rate</th>
        <th>Discount Percent</th>
        <th>Final Rate</th>
            </tr>
        </thead>
         
        <tbody>
           @if(count($getbids) > 0)
           <?php $kk = 0; 
            $bidfull = array();
          if(array_key_exists('0', $getbids['BID_DETAILS_FULL'])){
              $bidfull = $getbids['BID_DETAILS_FULL'];
          }
            else
            {
                $bidfull[0] = $getbids['BID_DETAILS_FULL'];
            }
            ?>
            @foreach($bidfull as $bids)
             @if($bids['Reference_No'] == $refno)
             
                         
             
              <?php $concat  = '' ; $dd = 1;
            $remarkbidfull = array();
          if(array_key_exists('0', $getbids['DETAILED_SPEC'])){
              $remarkbidfull = $getbids['DETAILED_SPEC'];
          }
            else
            {
                $remarkbidfull[0] = $getbids['DETAILED_SPEC'];
            }
            ?>
              
              @foreach($remarkbidfull as $remark)
                  <?php
            if($dd > 20){ break; }
            if($bids['Material_No'] == $remark['MAT_No']){
                
            if(!empty($remark["Line_$dd"])){
                    $concat .= $remark["Line_$dd"];
            }
            }
            
            
                ?>
              @endforeach
               
               <?php
            $bidterms = '';
            //var_dump($getbids);
            
            if(array_key_exists('BID_DETAILS',$getbids))
            {
                
             $bidt = array();   
                if(array_key_exists('0',$getbids['BID_DETAILS'])){
                    $bidt = $getbids['BID_DETAILS'];
                }else{
                    $bidt[0] = $getbids['BID_DETAILS'];
                }
                //var_dump($bidt);
                foreach($bidt as $nbidt){
                  
                    if($nbidt['Bid_Number'] == $refno){
                
                for($i = 01; $i <= 25; $i++){
                    
                    if($i < 10){
                        $i = '0'.$i;
                    }
                    //echo $nbidt['BID_DETAILS']["Line_$i"];
                    if(!empty($nbidt["Line_$i"])){
                        $bidterms .= $nbidt["Line_$i"];
                    }
                }
                   continue;     
                }
                    
                }
            }
            //var_dump($bidterms);
            ?>

             <?php
              $discount_percent = 0.00;
              $opentoedit = 'CLOSED';
              ?>
             @if(count($disc_recentbids) > 0)

             @foreach($disc_recentbids as $disc)
             @if($disc['Discount_edit_status'] == 'OPEN')
              <?php $opentoedit = 'OPEN'; ?>
              @endif
              @if((ltrim($bids['Material_No'],'0') == $disc['Material_no']) && (trim($bids['Brand_name'],'0') == $disc['Brand_Name']))
              
                <?php $discount_percent = $disc['Disc_Perc']; ?>
              @endif
              @endforeach
             @endif
                
                 <tr>
                     
                     <td class="materialno">{{ ltrim($bids['Material_No'], '0') }}</td>
                     <td>{{ $bids['Materila_Text'] }}</td>
                     <td>{{ $bids['Unit'] }}</td>
                     <td class="brandname">{{ $bids['Brand_name'] }}</td>
                     <td class="fin_quant">{{ $bids['Quantity'] }}</td>
                     <td>{{ $bids['Project_no'] }}</td>
                     <td>{{ $bids['Project_name'] }}</td>
                     <td align='center'><a href="#" class="btn btn-danger btn-xs marg_left" onclick="popmodalremarks('{{ $concat }}')"><i class="fa  fa-hand-pointer-o margin-r-5"></i> View</a></td>
                     <td class="quotedrate">{{ $bids['Bid_Rate'] }}</td>
                      <td>
                       <div class="form-group" >
                         
                         <div class="input-group">
                           
                           <input type="text"  name="discountprice"  onkeypress="return isNumberKey(this)" value="{{$discount_percent}}" placeholder="0.00%" class="form-control discountprice" "@if($opentoedit == 'CLOSED') readonly="true" @endif" >
                          @if($opentoedit == 'OPEN') <div class="input-group-addon updatedisc" style="background-color: #dd4b39; color: #fff; cursor: pointer;"> <i class="fa fa-check"></i></div>@endif
                         </div>
                       </div>
                                             
                                         </td>
                     <td class="final_calculated_val"></td>
                 </tr>
                 <?php $kk++; ?>
                 
                 @endif
            @endforeach
                  @endif
        </tbody>
         
        
    </table>
    
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
         $("#myModalLabel1").html("Detailed Specification");		
        
        var content;
        
        content = remarks;
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



  var overall_discountrate = 0;
  var todivideno = 0;
  var cll_quant = 0;
                      $('#bidform tr').each(function() {
                                                
                                                var discountprice = $(this).find(".discountprice").val();
                                                
                                                
                                                //fin_quant
                                                if (discountprice != undefined) {
                                                  //console.log(discountprice);
                                                  var qrate = parseFloat($(this).find(".quotedrate").text()).toFixed(2);
                                                  var perc = (parseFloat(discountprice)).toFixed(2);
                                                  var frate = qrate - (qrate * (perc/100));
                                                  var final_quan = $(this).find(".fin_quant").text();
                                                  var ncl = 0;

                                                  ncl = final_quan * frate.toFixed(2);
                                                  //console.log(ncl.toFixed(2));
                                                  cll_quant += parseFloat(ncl.toFixed(2));
                                                  
                                                  //
                                                  $(this).find(".final_calculated_val").text(frate.toFixed(2));
                                              overall_discountrate += parseFloat(discountprice);
                                            }
                                              todivideno += 1;
                        
                      });
                      todivideno = todivideno -1;
                      var finalval = overall_discountrate / todivideno;
                      
                      $(".fin_per").text(finalval.toFixed(2) + '%');
                      $(".fin_tot").text(cll_quant.toFixed(2));

                      //console.log(overall_discountrate);
                      //console.log(todivideno);


$(".updatedisc").on("click", function(){

  

    var discount = $(this).parent().closest('div').find('input').val();
    
    var refno = "{{$refno}}";
      
    if (discount != '') {
      if (!((discount >= 0) && ((discount <= 100)))) {
        $(this).parent().closest('div').find('input').val('');
        alert("Enter discount value between 0 to 100");
      }
      else{
        Swal.fire({
  title: 'Are you sure?',
  text: "Confirm to submit the final discount price",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, confirm!'
}).then((result) => {
  if (result.value) {


    
                        
                      var array_data = [];
                      var array_datanew = [];
                      var isempty = [];
                      $('#bidform tr').each(function() {
                                                
                                                var materialnew1 = $(this).find(".materialno").text();
                                                var brandtext1 = $(this).find(".brandname").text();
                                                var discountprice = $(this).find(".discountprice").val();
                                                if ((discountprice != '') && (discountprice >= 0) && (discountprice <= 100)) {


                                                //var bratenew1 = $(this).find(".BRate").find("input").val();
                                                
                        
                       // var materialtext1 = $(this).find(".mat_text").text();
                        
                                                
                        
                                                if ((discountprice != undefined) && (materialnew1 != '') && (discountprice != '')) {
                                                        
                                                          array_data.push({
                          "Mat_No" : materialnew1,
                          "Brand_Name" : brandtext1,
                          "Disc_Perc" : discountprice,
                          
                          });
				}


                                                          
                              
                                                    
                                       }
                                       else{
                                        if ((discountprice != undefined) && (materialnew1 != '') && (discountprice != '')) {
                                        isempty.push({
                          "Mat_No" : materialnew1,
                          "Brand_Name" : brandtext1,
                          "Disc_Perc" : discountprice,
                          
                          });
                                      }
                                       }
                                                
                        
                        
                      });
                      
                      if (isempty.length > 0) {
                        Swal.fire(
      'Alert' ,
      'Please check the discount price. The discount value must between 0 to 100.',
      'warning'
    )
                        return false;
                      }
                      else{
                      //console.log(isempty);

      
    //console.log({_token:"{{csrf_token()}}",bidno: refno,array_data: array_data});
    $.post('/vendorzone/negotiated_discountprice', {_token:"{{csrf_token()}}",bidno: refno,array_data: array_data}, function(data){
     //console.log(data);
      if (data == '1') {
        Swal.fire(
      'Success' ,
      'Discount price updated.',
      'success'
    )
        
      }
      else{
        Swal.fire(
      'Alert' ,
      'Discount price not updated',
      'warning'
    )
      }

       setTimeout(function(){
      window.location.reload();
    },8000);

    });
}
    
  }
})

        
      }
    }
    else{
      alert("Discount Value required!");
    }

   

  });



$(".updatedisc_overall").on("click", function(){

  
    var discount = $(this).parent().closest('div').find('input').val();
    
    var refno = "{{$refno}}";
      
    if (discount != '') {
      if (!((discount >= 0) && ((discount <= 100)))) {
        $(this).parent().closest('div').find('input').val('');
        alert("Enter discount value between 0 to 100");
      }
      else{
        Swal.fire({
  title: 'Are you sure?',
  text: "Confirm to submit the final discount price "+discount+"% to all the below materials.",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, confirm!'
}).then((result) => {
  if (result.value) {


    
                        
                      var array_data = [];
                      var array_datanew = [];
                      var isempty = [];
                      $('#bidform tr').each(function() {
                                                
                                                var materialnew1 = $(this).find(".materialno").text();
                                                var brandtext1 = $(this).find(".brandname").text();
                                                
                                                if ((discount != '') && (discount >= 0) && (discount <= 100)) {


                                                //var bratenew1 = $(this).find(".BRate").find("input").val();
                                                
                        
                       // var materialtext1 = $(this).find(".mat_text").text();
                        
                                                
                       if ((discount != undefined) && (materialnew1 != '') && (discount != '')) { 
                                                
                                                        
                                                          array_data.push({
                          "Mat_No" : materialnew1,
                          "Brand_Name" : brandtext1,
                          "Disc_Perc" : discount,
                          
                          });
			
				}


                                                          
                              
                                                    
                                       }
                                       else{
					
                                        if ((discount != undefined) && (materialnew1 != '') && (discount != '')) {
                                        isempty.push({
                          "Mat_No" : materialnew1,
                          "Brand_Name" : brandtext1,
                          "Disc_Perc" : discount,
                          
                          });
                                      }
                                       }
                                                
                        
                        
                      });
                      
                      if (isempty.length > 0) {
                        Swal.fire(
      'Alert' ,
      'Please check the discount price. The discount value must between 0 to 100.',
      'warning'
    )
                        return false;
                      }
                      else{
                      //console.log(isempty);

	//console.log({_token:"{{csrf_token()}}",bidno: refno,array_data: array_data});      
    
    $.post('/vendorzone/negotiated_discountprice', {_token:"{{csrf_token()}}",bidno: refno,array_data: array_data}, function(data){
      //console.log(data);
      if (data == '1') {
        Swal.fire(
      'Success' ,
      'Discount price updated.',
      'success'
    )
        
      }
      else{
        Swal.fire(
      'Alert' ,
      'Discount price not updated',
      'warning'
    )
      }

       setTimeout(function(){
      window.location.reload();
    },3000);

    });
}
    
  }
})

        
      }
    }
    else{
      alert("Discount Value required!");
    }

    

  });

    var table = $('#bidform').DataTable( {
        
        "order": [[ 1, "desc" ]],
        rowReorder: false,
        responsive: false,
        "scrollX": true,
		paging: false
    } );
} );    
</script>


@endsection
