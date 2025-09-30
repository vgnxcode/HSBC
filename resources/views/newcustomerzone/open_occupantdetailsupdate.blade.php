@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates |Customer Zone| Customer Occupants Details Update VGN
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
                <h3 class="box-title" style="padding-top: 13px;"><i class="fa fa-line-chart margin-r-5"></i> VGN Projects Estates - Owner/Tenant Details Update</h3>
                
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            

@foreach($getcustomerdata as $customer)



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="content">
  



  <div class="row">
    
    <div class="col-md-10 col-md-offset-1">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-users margin-r-5"></i> Owner/Tenant Details </h3>
                @if(count($occupantdetails) > 0)<span class="pull-right" ><a href="{{ url('/socpd') }}/{{$id}}" class="btn btn-danger btn-xs"><i class="fa fa-send margin-r-5"></i> Show Occupant Details</a></span>@endif
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
               
           
                
              @if(count($projects) > 0)

                <form id="myForm" method="POST" action="{{ url('/ocpd') }}/{{$id}}" class="form-horizontal" onsubmit="return validate(this);" >
                {{ csrf_field() }}
                   <div class="row" style="margin-left:3px;">
                       <div class="col-md-12">
                                                      
                             
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

                     <!--  <div class="row">
                       <div class="col-md-6"></div>
                       <div class="col-md-6"><a href="/customerzone/rentsellmyunit" type="button" class="btn btn-md btn-danger"><i class="fa fa-exchange"></i> Rent My Unit</a></div>
                     </div> -->
                                         

                      <div class="form-group">
                        <label for="occupanttype" class="col-sm-2 ">Occupant Type</label>
                        <div class="col-sm-4">
                          <select class="form-control userdropdown" name="occupanttype" id="occupanttype" required>
  <option value="">Select*</option>
<option "@if(old('occupanttype') == 'First Owner') selected='selected' @endif" value="First Owner">First Owner</option>  
  <option "@if(old('occupanttype') == 'Second Owner') selected='selected' @endif" value="Second Owner">Second Owner</option> 
  <option "@if(old('occupanttype') == 'Tenant') selected='selected' @endif" value="Tenant">Tenant</option> 
</select>
                          {!! $errors->first('occupanttype', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="no_of_occupants" class="col-sm-2 ">No. of Occupants</label>
                        <div class="col-sm-4">
                          <input type="number" class="form-control" id="no_of_occupants" name="no_of_occupants" value="{{ old('no_of_occupants')}}" placeholder="No. of occupants" min="1" max="20">
                          {!! $errors->first('no_of_occupants', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>

                      <div class="text-center" id="loader1">
                          <img src="{{ config('app.AWS_URL')}}/images/regdetails/loadergif.gif" width="90" alt="loader1">
                          </div>

                      <div class="form-group" id="persondetails">
                        <label for="inputPassword3" class="col-sm-2">Person Details</label>
                        <div class="col-sm-9">
                          <div class="col-sm-10">
      <div class="input_fields_wrap">
    
    <div id="firstdiv">
    <div class="input-group">
    <div class="input-group-addon">1.</div>
     <input type="text" class="form-control" name="occupants[name][]" placeholder="Name*" required maxlength="255">
     <input type="number" class="form-control" name="occupants[mobile][]" placeholder="Mobile Number*" required maxlength="13">
     <input type="email" class="form-control" name="occupants[email][]" placeholder="Email*" required maxlength="60">
     </div>
     <br>
     </div>

    
</div>
    </div>
                        </div>
                      </div>
                                        
                      
                      
                      <br/><br/>
                      <div class="form-group">
                        <div class="col-sm-7"> 
                          <input class="submitbtn btn btn-danger" type="submit" value="Submit" id="submit" />
                          <a href="{{ url('/customerzone/dashboard') }}" class="btn btn-warning">Cancel</a>
                        </div> 
                      </div>
                                 
                                 <br>
                                 <div class="row">
                <div class="col-md-12">
                  <ol>
                    <h4 style="font-weight: bold;">Note:</h4>
                    <li>Maximim number of Occupants are (1 BHK - 3, 2 BHK - 5, 3 BHK - 7, 4 BHK - 9, 5 BHK - 12) allowed.</li>
                  </ol>
                </div>
              </div>

              <br>

                                                   
                                             
                       </div>
                   </div>
                            
                                
                </form>
              @endif
           

              
            </div>
            <!-- /.box-body -->
          </div>

    </div>


    

    
  </div>
@endforeach
              



              
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

                       $("#loader1").hide();
                        $("#persondetails").hide();
                        $("#no_of_occupants").on("change", function(){
                          $("#loader1").fadeIn('slow', () => {
                            $("#loader1").show();
                          });
                          var no_of_occupants = $("#no_of_occupants").val();
                          var plantcode = $("#Projects").val();
                          var unitcode = $("#Units").val();
                          
                          if ((no_of_occupants != '') && (no_of_occupants > 0)) {
                            
                            $.post('/api/getcustomerbhk', {_token: "{{ csrf_token() }}",customerid: "{{$getcustomerdata[0]['Customer_ID']}}",Plant_Code:plantcode,Unit_No:unitcode,no_of_occupants:no_of_occupants}, function(data){
                              console.log(data);
                              if (data == 0) {
                                $("#persondetails").hide();
                                $("#no_of_occupants").val('');
                                alert('Maximum limit exceeded for your unit.');
                              }
                              else{
                                $("#firstdiv")                     //Select the object
   .parent()               //Select the parent of the object
   .children()             //Select all the children of the parent
   .not(':first-child')    //Unselect the first child
   .remove();
                         var newdata = data - 1;
        for(x = 1; x <= newdata; x++){ //max input box allowed
            var dd = x +1;
            $(wrapper).append('<div><div class="input-group"><div class="input-group-addon">'+dd+'.</div><input type="text" name="occupants[name][]" class="form-control" placeholder="Name" maxlength="255" /><input type="number" class="form-control" name="occupants[mobile][]" placeholder="Mobile Number" maxlength="13"><input type="email" class="form-control" name="occupants[email][]" placeholder="Email" maxlength="60"></div></div><br>'); //add input box

        }
        setTimeout(function(){
            $("#persondetails").fadeIn('slow', () => {
          $("#persondetails").show();
        });
        },1000);
        
    

                              }
                              
                            });
                          }
                          else{
                            setTimeout(function(){
                             $("#persondetails").fadeOut('slow', () => {
          $("#persondetails").hide();
        });
                             },1000);
                            $("#no_of_occupants").val('');
                                alert('No of occupants field required.');
                          }

                          $("#loader1").fadeOut('slow', () => {

                          $("#loader1").hide();
                        });

                        });

                          
    var max_fields      = 12; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 3; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment #<a href="#" class="remove_field pull-right">Remove</a>
            $(wrapper).append('<div><div class="input-group"><div class="input-group-addon">'+x+'.</div><input type="text" name="occupants[name][]" class="form-control" placeholder="Name" maxlength="255" /><input type="number" class="form-control" name="occupants[mobile][]" placeholder="Mobile Number" maxlength="13"><input type="email" class="form-control" name="occupants[email][]" placeholder="Email" maxlength="60"></div></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })




                          var data= <?php echo json_encode($projects);?>;
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
                          
                          $('#desc').keydown(function () {
                            var max = 255;
                            $(this).attr('maxlength',max);
                            var len = $(this).val().length+($(this).val().match(/\n/g)||[]).length;
                            if (len >= max) {
                              $('#charNum').text(' You have reached the limit');
                              } else {
                              var char = max - len;
                              $('#charNum').text(char + ' characters left');
                            }
                          });
                          $('#desc').keydown();
        });       
        </script>
            
@endsection
