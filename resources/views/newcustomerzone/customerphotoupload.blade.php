@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Customer Zone| Customer Id Card & Vehicle Pass Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newcustomerzone.styles.commoncss')
<link rel="stylesheet" href="/croppie/croppie.css" />
<style>
   /* Preloader */

#preloader {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #fff;
  /* change if the mask should have another color then white */
  z-index: 99;
  /* makes sure it stays on top */
}

#status {
  width: 200px;
  height: 200px;
  position: absolute;
  left: 50%;
  /* centers the loading animation horizontally one the screen */
  top: 50%;
  /* centers the loading animation vertically one the screen */
  background-image: url("{{ config('app.AWS_URL')}}/images/Preloader.gif");
  /* path to your loading animation */
  background-repeat: no-repeat;
  background-position: center;
  margin: -100px 0 0 -100px;
  /* is width and height divided by two */
}

#displayphotodiv p{
  margin-left: 15px;
}
  
</style>
@endsection

@section('bodycontent')
<body class="hold-transition skin-red fixed sidebar-mini">

<!-- Site wrapper -->
<div class="wrapper">

@foreach($getcustomerdata as $customer)


 
  @include('newcustomerzone.header.index')
  @include('newcustomerzone.aside.index')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <div id="preloader">
  <div id="status">&nbsp;</div>
</div>
    <!-- Main content -->
    <section class="content">
  
  <div class="row">
    <div class="col-md-10 col-md-offset-1">

  @include('newcustomerzone.contenttop')


        </div>
  </div>



  <div class="row">
    
    <div class="col-md-10 col-md-offset-1">
      
      <div class="box box-danger">
            <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-image margin-r-5"></i> Customer Id Card & Vehicle Pass </h3><span class="pull-right" ><a href="#" class="btn btn-danger btn-xs"><i class="fa fa-back margin-r-5"></i>Back</a></span>
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
                                 <form class="form-horizontal">                     
                             
                                <div class="form-group">
                        <label for="complaintproject" class="col-sm-2 ">Project Name*</label>
                        <div class="col-sm-4">
                          <select class="form-control userdropdown" name="complaintproject" id="Projects">
                            <option value="">Select*</option> 
                          </select>
                          {!! $errors->first('complaintproject', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 ">Unit No*</label>
                        <div class="col-sm-4">
                          <select class="form-control userdropdown" name="complaintunit" id="Units" required>
                              <option value="">Select</option>
                            </select>
                          {!! $errors->first('complaintunit', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="profile_name" class="col-sm-2 ">Name*</label>
                        <div class="col-sm-4">
                          <input type="text" class="form-control" name="profile_name" id="profile_name" placeholder="Enter Your Name" required>
                          <span class="text-muted">(Name as you would like to print on Id card.)</span>
                          {!! $errors->first('profile_name', '<span class="errortext text-red">:message</span>') !!}
                        </div>
                      </div>

                      <div class="form-group">
                        <label for="upload_image" class="col-sm-2 ">Upload Image*</label>
                        <div class="col-sm-4">
                          <input type="file" class="form-control" name="upload_image" id="upload_image" required>
                          {!! $errors->first('upload_image', '<span class="errortext text-red">:message</span>') !!}
                          <br />
            <div id="uploaded_image"></div>
                        </div>
                      </div>
                                       
                      
                      
                      
                      
                      <br/>
                      
              <div class="row">
                <div class="col-md-12">
                  <ol>
                    <h4 style="font-weight: bold;">Note:</h4>
                    <li>Name and photo uploaded will be printed and given to you at the time of handingover by your customer care executive.</li>
                    <li>Image formats allowed (".jpg",".png").</li>
                    <li>For more details contact your customer care executive.</li>
                    <li>Maximim number of images that can be uploaded (1 BHK - 3 images, 2 BHK - 5 images, 3 BHK - 7 images, 4 BHK - 9 images, 5 BHK - 12 images).</li>
                  </ol>
                </div>
              </div>                   
                                     
                                             
                       </div>
                   </div>
                            
                                
                </form>
                
              

<!--Display Uploaded Images-->

  <div class="row" id="welldiv">
    <div class="col-md-12">
      <div class="well">
        <h4 style="font-weight: 600;text-transform: uppercase;text-decoration: underline;">Uploaded Photos</h4>

            <div class="row" id="displayphotodiv">

             <p>Please select Project Name and Unit No. to view uploaded photos.</p>

  

            </div>


      </div>
    </div>
  </div>

<!--End Display Uploaded Images-->


              
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

  @include('newcustomerzone.footer')
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- Modal -->
<div id="uploadimageModal" class="modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Upload & Crop Image</h4>
          </div>
          <div class="modal-body">
            <div class="row">
            <div class="col-md-8 text-center">
              <div id="image_demo" style="width:350px; margin-top:30px"></div>
              <div class="row"><p class="pull-left" style="font-weight: 500; margin-left:2px;">Zoom Out</p><p class="pull-right">Zoom In</p></div>
              
            </div>
            <div class="col-md-4" style="padding-top:30px;">
              <br />
              <br />
              <br/>
              <button class="btn btn-success crop_image">Crop & Upload Image</button>
          </div>
        </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
      </div>
    </div>
</div>


@endsection

@section('script')
@include('newcustomerzone.js.commonjs')
              <script src="/croppie/croppie.js"></script>
<script type="text/javascript">
$(window).on('load', function() { 
  setTimeout(function() {
     // makes sure the whole site is loaded 
  $('#status').fadeOut(); // will first fade out the loading animation 
  $('#preloader').delay(600).fadeOut('slow'); // will fade out the white DIV that covers the website. 
  $('body').delay(600).css({'overflow':'visible'});
  }, 1000);
 
});

function preloadershow() {
   
     // makes sure the whole site is loaded 
  $('#status').show(); // will first fade out the loading animation 
  
  $('#preloader').show();
  setTimeout(function() {
     // makes sure the whole site is loaded 
  $('#status').fadeOut(); // will first fade out the loading animation 
  $('#preloader').delay(600).fadeOut('slow'); // will fade out the white DIV that covers the website. 
  $('body').delay(600).css({'overflow':'visible'});
  }, 2000);

  $('html, body').animate({
        scrollTop: $("#welldiv").offset().top
    }, 2000);
  
 }

  function deletephoto(arg,plantcode,unitno) {
    if ((arg != '') && (plantcode != '') && (unitno != '')) {
      preloadershow();
      $.post('/customerzone/deleteuploadedphoto', {_token: '{{csrf_token()}}',deleteid: arg,plantcode:plantcode,unitcode:unitno}, function(data){
          if (data != '0') {
            alert('Photo Deleted. Please check the uploaded photo panel.');
             $('#Projects').val('');
          $('#Units').val('');
          $('#profile_name').val('');
          $('#upload_image').val('');

          
          
          $('#Projects').val(plantcode);
          $('#Units').val(unitno);
          $('#Units').trigger("change");
            $("#uploaded_image").html('');

          
          }
          else{
            alert('You cannot delete this photo. Please check with your Customer Care. Your ID card may be processed.');
          }
      });
    }
  }


  function namechange(id) {
    var newname = $("#"+id).val();

    if(newname != ''){
        $.post('/customerzone/customerphoto_nameupdate', {_token: '{{csrf_token()}}', newname: newname,id: id}, function(data){
          if (data == 1) {
            alert('Name changed to '+ newname);
          }
          else{
           alert('Name not changed!'); 
          }
        });
    }
    else{
      alert('Name Should not be empty!');
    }
  }
                  
        $(document).ready(function(){


          $image_crop = $('#image_demo').croppie({
    enableExif: true,
    viewport: {
      width:200,
      height:200,
      type:'square' //circle
    },
    boundary:{
      width:300,
      height:300
    }
  });

  $('#upload_image').on('change', function(){
    var pfname = $("#profile_name").val();
    if (pfname == '') {
      alert('Please enter your name!');
      $("#upload_image").val('');
      $( "#profile_name" ).focus();
    }else{
    var reader = new FileReader();
    reader.onload = function (event) {
      $image_crop.croppie('bind', {
        url: event.target.result
      }).then(function(){
        console.log('bind complete');
      });
    }
    reader.readAsDataURL(this.files[0]);
    $('#uploadimageModal').modal('show');
  }
  });

   $('.crop_image').click(function(event){
    
    $image_crop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
    }).then(function(response){
      var plantcode = $("#Projects").val();
      var unitno = $("#Units").val();
      var profilename = $("#profile_name").val();

      $.ajax({
        url:"/customerzone/photoupload",
        type: "POST",
        data:{"image": response,_token: '{{csrf_token()}}',"plantcode":plantcode,"unitno":unitno,"profilename":profilename},
        success:function(data)
        {
          preloadershow();
          $('#uploadimageModal').modal('hide');
          
          
          $('#Projects').val('');
          $('#Units').val('');
          $('#profile_name').val('');
          $('#upload_image').val('');
           if ((data == '-1')){
            alert('File not uploaded.Please check the instruction notes.');
           }
          else{
            console.log(data);
            $('#uploaded_image').html(data);
          alert('Successfully Uploaded. Please check the uploaded photos panel.');
        }
          
            $('#Projects').val(plantcode);
          $('#Units').val(unitno);
          $('#Units').trigger("change");
            $("#uploaded_image").html('');

          
          


        }
      });
    })
  });
                        
                        $('.sidebar-menu').tree();

var data=<?php echo json_encode($getproject);?>;
                          var length=data.length;
                          var result="<option value=''>Select*</option>";
                          var distinct=[];
                          for(i=0;i<length;i++)
                          {
                            if($.inArray(data[i]['project_id'],distinct)===-1){
                              distinct.push(data[i]['project_id']);
                              result=result+"<option value='"+data[i]['project_id']+"'>"+data[i]['pname']+"</option>";
                              
                            }
                            
                          }
                          $("#Projects").html(result);
                          $("#Projects").on('change',function(){
                            $("#displayphotodiv").html('');
                            $("#displayphotodiv").html('<p>No Photos Uploaded. Please upload photos in above field.</p>');

                            var result1="<option value=''>Select*</option>";
                            //var distinct1=[];
                            for(i=0;i<length;i++)
                            {
                              
                              if($('#Projects').val()==data[i]['project_id'])
                              {
                                
                                result1=result1+"<option value='"+data[i]['unit']+"'>"+data[i]['unit_nm']+"</option>";
                                
                              }
                            }
                            $("#Units").html(result1);
                          });


                          $("#Units").on("change", function(){
                            
                            $("#displayphotodiv").html('');
                            $("#displayphotodiv").html('<p>No Photos Uploaded. Please upload photos in above field.</p>');


                            var proj = $("#Projects").val();
                            var unit = $("#Units").val();
                            
                            if ((proj != '') && (unit != '')) {

                              $.post('/customerzone/getcustomeruploadedphotos', {proj: proj,unit:unit,_token:'{{csrf_token()}}'},function(data){
                                $("#displayphotodiv").html('');
                                if (data == '-1') {
                                  $('#Projects').val('');
          $('#Units').val('');
          $('#profile_name').val('');
          $('#upload_image').val('');
          alert('Photo Upload Option available only for Apartment holders.');
                                 }
                                 if ((data != '0') && (data != '-1')) {
                                  var jsondata = JSON.parse(data);
                                  var divs = '';
                                  $.each(jsondata, function(k,v){

                                    if (v.taken_print_out == 'Y') {
                                      divs += `
                                    <div class="col-md-4">
                <div class="panel panel-danger">
                
    <div class="panel-body" style="text-align:center;"><img src="/data_mnt/customeridcards/`+v.filename+`" alt="Image 2"></div>
     <div class="panel-footer text-center" style="font-size: 1.3em;
    font-weight: 600;text-transform: uppercase;">`+v.name+`</div>
  </div></div>
                                    `;
                                    }
                                    else{


                                    divs += `
                                    <div class="col-md-4">
                <div class="panel panel-danger">
                <div class="panel-header"><button class="badge badge-danger pull-right" style="background-color: #de4646;margin:-10px -10px 10px 0px;" onclick = "deletephoto(`+v.id+`,`+v.plantcode+`,`+v.unitcode+`)">X</button></div>
    <div class="panel-body" style="text-align:center;"><img src="/data_mnt/customeridcards/`+v.filename+`" alt="Image 2"></div>
     <div class="panel-footer text-center" style="font-size: 1.3em;
    font-weight: 600;text-transform: uppercase;"><input type="text" class="form-control" name="editedname" onChange="namechange(`+v.id+`);" id="`+v.id+`" value="`+v.name+`"></div>
  </div></div>
                                    `;
                                  }
                                  });

                                  $("#displayphotodiv").html(divs);

                                 }
                                 else{
                                  $("#displayphotodiv").html('<p>No Photos Uploaded. Please upload photos in above field.</p>');
                                 }
                              });

                            }

                          });



                          

                          
        });       
        </script>
        
@endsection
