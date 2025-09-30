@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates |Customer Zone| Customer Rent Unit by VGN
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newcustomerzone.styles.commoncss')
<script src="{{ env('AWS_URL')}}/newcustomerzoneassets/dist/js/defines.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<style>
  .carousel-inner>.item>img
  {
    min-height: 280px;
  }
    #changedetailsForm label.col-sm-2 {
        font-weight: normal;
    }


.swal2-styled.swal2-confirm{
  background-color: #dd4b39;
}

.swal2-modal{
    width: 500px;
}
/* .swal2-content{
  font-size: 1.55em;
} */

.card {
  /* Add shadows to create the "card" effect */
  box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
}


</style>

@endsection

@section('bodycontent')
<body class="hold-transition fixed">

<!-- Site wrapper -->
<div class="wrapper">

@foreach($customerdata as $customer)


 
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper1">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
  
  
  <div class="row" >
    
    <div class="col-md-8 col-md-offset-2 card" >
      
      <div class="box box-danger">
            <div class="box-header with-border" style="margin-bottom: 5px;">
              <img src="{{ env('AWS_URL')}}/images/custom/vgn-logo.png" alt="vgn logo" class="img-responsive pull-right" style="margin-top: 5px;">
                <h3 class="box-title" style="padding-top: 13px;"><i class="fa fa-line-chart margin-r-5"></i> VGN Projects Estates - Rent my unit </h3>
                
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <form id="myForm" method="POST" action="{{ url('/rsu') }}/{{$id}}" class="form-horizontal" onsubmit="return validate(this);">
                   <div class="row" style="text-align:center;">
                       <div>
                        <h3 class="text-bold">I would like VGN to:</h3>

                           <div class="col-md-12 col-sm-12 grow"  style="text-align:center;">
                           <div class="checkbox">
                            <label style="font-weight: bold;">
                           <img src="/forrent.jpg" class="rent img-responsive" alt="renting" style=" height: 260px"><br>
                           <input type="checkbox" name="rent" value="1" id="rent"  class="p3"> Rent my unit.</label>
                            </div>

                           </div>


            
                       </div>
                   </div>
                         <br>

                         <br>

                         
                         <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                     <div class="alert text-justify" style="background-color: #fbc0c0;color: #020202;box-shadow: 4px 4px 8px #eee;">
         <h4 style="font-weight: normal;"><span style="line-height: 2.2em; font-weight: 600;">Dear {{ $customer['Customer_Name'] }},</span><br> We are delighted to inform that we have now introduced a new service where you can rent your home. We will ensure  a hassle free experience in finding you a prospective tenant apart from taking care of the complete documentation . Just let us know what you think by selecting the above checkbox and our facility management team will be in touch with you shortly !</h4>
      </div>
<p class="pull-right text-bold">* Applicable only for possession taken units</p>
    </div>
                         </div>   

                         <div class="row">
                           <div class="col-md-8 col-md-offset-2">
                              
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                                                      
                             <input type="hidden" name="custid" value="{{$customerid}}" required="true">
                                <div class="form-group">
                        <label for="projectid" class="col-sm-2 ">Project Name</label>
                        <div class="col-sm-4">
                          <select class="form-control userdropdown" name="projectid" id="Projects" required>
  <option value="">Select*</option> 
  
</select>
                          {!! $errors->first('projectid', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="unitno" class="col-sm-2 ">Unit No</label>
                        <div class="col-sm-4">
                          <select class="form-control userdropdown" name="unitno" id="Units" required>
      <option value="">Select*</option>
      
      
</select>
                          {!! $errors->first('unitno', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                     

                     

                     

                   
                                        
                      
                      
                      <br/><br/>
                      <div class="form-group">
                        <div class="col-sm-7"> 
                          <input class="submitbtn btn btn-danger" type="submit" value="Submit" id="submit" />
                          <a href="{{ url('/customerzone/customerlogin') }}" class="btn btn-warning">Cancel</a>
                        </div> 
                      </div>
                                 
                                 <br>
                                

              <br>

                                                   
                                             
                       </div>
                   </div>
                            
                                
                
                           </div>
                         </div>
                                
                </form>
              

              
            </div>
            <!-- /.box-body -->
          </div>

    </div>


    

    
  </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  



@endsection

@section('script')
@include('newcustomerzone.js.commonjs')


<script type="text/javascript">
  
 

        $(document).ready(function(){


          $("#rent").on('click',function(){
            var rent = $("#rent").val();
            if (rent == 1) {

              var projj = $('#Projects').val();
                            var unitnoo = $('#Units').val();

                            if ((projj != '') && (unitnoo != '')) {
                            }else{
                              $('#rent').prop('checked', false);
                              $('#sell').prop('checked', false);
                              alert('Please select the Project Name and Unit No!');
                              return false;
                            }

            }
          });

          $("#sell").on('click',function(){
            var rent = $("#rent").val();
            if (rent == 1) {

              var projj = $('#Projects').val();
                            var unitnoo = $('#Units').val();

                            if ((projj != '') && (unitnoo != '')) {
                            }else{
                              $('#rent').prop('checked', false);
                              $('#sell').prop('checked', false);
                              alert('Please select the Project Name and Unit No!');
                              return false;
                            }

            }
          });

                       var data= <?php echo json_encode($getcustomerdata);?>;
                          console.log(data);
                          var length=data.length;
                          var result="<option value=''>Select*</option>";
                          var distinct=[];
                          for(i=0;i<length;i++)
                          {
                            if($.inArray(data[i]['Plant'],distinct)===-1){
                              distinct.push(data[i]['Plant']);
                              result=result+"<option value='"+data[i]['Plant']+"'>"+data[i]['Plant_Name']+"</option>";
                              
                            }
                            
                          }
                          $("#Projects").html(result);
                          $("#Projects").on('change',function(){
                            var result1="<option value=''>Select*</option>";
                            //var distinct1=[];
                            for(i=0;i<length;i++)
                            {
                                                            
                              if($('#Projects').val()==data[i]['Plant'])
                              {
                                console.log(data[i]['Plant']);
                                                                
                                                                if(data[i]['Possession'] == 'X'){
                                                                    
                                result1=result1+"<option value='"+data[i]['Unit']+"'>"+data[i]['Unit_Name']+"</option>";
                                                                }
                                
                              }
                            }
                            $("#Units").html(result1);
                          });


                          $("#Units").on('change',function(){
                            var proj = $('#Projects').val();
                            var unitno = $('#Units').val();

                            if ((proj != '') && (unitno != '')) {
                              $.post("/opencheckrsu/{{$id}}",{_token:'{{csrf_token()}}', plantid: proj, unitid: unitno},function(data){
                                if (data != 0) {
                                  var yy = JSON.parse(data);
                                  if(yy[0].rent == 'X'){
                                    $('#rent').prop('checked', true);
                                  }

                                  if(yy[0].sell == 'X'){
                                    $('#sell').prop('checked', true);
                                  }
                                  
                                }
                                
                              });
                            }

                          });
                       

                       @if(session()->has('suc_msg'))
                       Swal.fire({
      type: 'success',
      html: 'Thanks for your input, we will get back to you shortly!'
    });
                       @endif

@if(session()->has('error_msg'))
                       Swal.fire({
      type: 'error',
      html: 'Please select the checkbox.!'
    });
                        
    @endif
        });       
        </script>
            @endforeach
@endsection
