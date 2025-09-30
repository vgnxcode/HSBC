@extends('newemployeezone.layout') @section('title') VGN Projects Estates Pvt Ltd |Employee Zone| Leave Management System | HOD Delete Applications
Page @endsection @section('description')
<meta name="description" content=""> @endsection @section('keyword') @endsection @section('style') @include('newemployeezone.styles.commoncss')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css">
   <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<style>
  .carousel-inner>.item>img {
    min-height: 280px;
  }
  .maximg{
    max-width:120px;
    max-height:120px;
  }
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
 
  
</style>

@endsection @section('bodycontent')

<body class="hold-transition skin-red fixed sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">

    @foreach($getemployeedata as $employee) 
    @include('newemployeezone.header.index') 
    @include('newemployeezone.aside.index')

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

	@include('newemployeezone.contenttop')


      	</div>
  </div>


<div class="row">
		
        <div class="col-md-12">
          
          <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bullhorn margin-r-5"></i>Delete Application Workflow</h3>
                    
                    <span class="pull-right" ><a href="{{ url('/employeezone/leavemanagementsystem') }}" class="btn btn-danger btn-xs"><i class="fa fa-backward margin-r-5"></i>LMS Dashboard</a></span>
                    
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                  
                                       
                                      
                    
                    
                       <div class="row" style="margin-left:3px;">
                           <div class="col-md-12">

                           
                               
                              <table id="example" class="display nowrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>S. No.</th>
                    <th>Delete Appl.</th>
                    <th>Employee Id</th>
                    
                    <th>Employee Name</th>
                    <th>Application Type</th>

                    <th>Start Date</th>
                    <th>End Date</th>

                    
                    <th>Employee Reason</th>
                    <th>Appl. Created Date</th>
                    <th>Del. Req. Created Date</th>
                    
                </tr>
            </thead>
           
            <tbody>
               
                @if(count($getallapplications) > 0)
                                                        <?php $count = 1; ?>
                                                        @foreach($getallapplications as $appliedkey => $appliedvalue)
                                                        <tr>
                                                        <td>{{$count}}</td>
                                                        
                                                        <td class="selectedbox">
                                                        
                                                        <a href="#" class="label label-danger" id="delete" onclick="send_datato_delete('{{$appliedvalue["hash_key"]}}');" >Delete</a>
                                                        </td>

                                                        
                                                        <td>{{$appliedvalue['requested_empid']}}</td>
                                                        <td>{{$appliedvalue['empname']}}</td>
          <td>
          
          {{$appliedvalue['leave_type']}}
          
          </td>
          <td>
          {{ \Carbon\Carbon::parse($appliedvalue['stdate'])->format('d, M Y H:i:s') }}
          </td>
          <td>
          {{ \Carbon\Carbon::parse($appliedvalue['etdate'])->format('d, M Y H:i:s') }}
            </td>
          
         
          
          <td>
          	@if($appliedvalue['emp_reason'] != '')
          		{{$appliedvalue['emp_reason']}}
          	@endif
          </td>

          
        
          <td>{{ $appliedvalue['appl_created_date'] }}</td>
          <td>{{ $appliedvalue['delete_req_raised_date'] }}</td>

          
        </tr>
                                                            <?php $count++; ?>
                                                        @endforeach
                                                        @endif            
            </tbody>
        </table>           

        
                                                 
                           </div>
                       </div>
                                
                                    
                    </form>
                  
    
                  
                </div>
                <!-- /.box-body -->
              </div>
    
        </div>
    
    
            
    
            
        </div>

        		<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-red">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body">
        ...
      </div>
     
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



  @endsection @section('script') @include('newemployeezone.js.commonjs')

  <script>
     function stripslashes(str) {
str=str.replace(/\\'/g,'\'');
str=str.replace(/\\"/g,'"');
str=str.replace(/\\0/g,'\0');
str=str.replace(/\\\\/g,'\\');
return str;
}


function send_datato_delete(hashkey){
  
  $("#delete").prop('disabled',true);
  
  $('#preloader').show();
  $('#status').show();
  

  $.get('/employeezone/lms/hoddeleteleaveurl/'+hashkey, {test: 1}, function(data){
    alert(data);
    $("#delete").prop('disabled',false);
    
    $('#preloader').hide();
  $('#status').hide();
    window.location.href="/employeezone/lms/applications_delete_request";
});

}



  </script>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.3/js/dataTables.rowReorder.min.js" ></script>
<script src="https://cdn.datatables.net/responsive/2.2.0/js/dataTables.responsive.min.js" ></script>

<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js" ></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js" ></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js" ></script>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js" ></script>
  
<script>
 $(window).on('load', function() { 
  setTimeout(function() {
     // makes sure the whole site is loaded 
  $('#status').fadeOut(); // will first fade out the loading animation 
  $('#preloader').delay(600).fadeOut('slow'); // will fade out the white DIV that covers the website. 
  $('body').delay(600).css({'overflow':'visible'});
  }, 1000);
 
})
  $(document).ready(function () {
    $('.sidebar-menu').tree();
    $("#spin").hide();
    var table = $('#example').DataTable( {
        "order": [[ 9, "desc" ]],
        rowReorder: false,
        responsive: true,
        "scrollX": true,
		    paging: true,
         dom: 'Bfrtip',
         buttons: [
             'copy', 'csv', 'excel', 'pdf', 'print'
         ]
    } );


    

    $('#selectall').on('click',function() {
  $(".action_check").prop('checked',true);
   
     });
        

   
   $("#sdsd").on('click', function(){
  $("#spin").show();
  $('#example tbody > tr').each(function() {
    var checkboxrow = $(this).find(".selectedbox").find("input").is(':checked');
    if (checkboxrow == true) {
      var list = $(this).find(".selectedbox").find("input").val();
      var split = list.split('-')
      var id = split[0];
      var subid = split[1];
      console.log(subid);
      var hodreason = '';
      $.post("/employeezone/lms/admin_application", {_token:'{{csrf_token()}}',id: id,reason:hodreason,subordinateid: subid, status: 1}, function(data){
       
        //
    });
    
    }
    
  });

  
    window.location.reload();
$("#spin").hide();

});
    
        

    $(document).on("click", "#hod_approve", function(event){
        $("#spin1").show();
    var id = $("#id").val();
    $("#rejection_reason").hide();
    $("#reason").prop('required',false);
    var hodreason = '';
    
    
    var subid = $("#subid").val();
    $.post("/employeezone/lms/admin_application", {_token:'{{csrf_token()}}',id: id,reason:hodreason,subordinateid: subid, status: 1}, function(data){
        console.log(data);
        if (data.status == 1) {
            alert('Updated Successfully!');
            window.location.reload();
        }else{
            alert('Failed Try Again!');
        }
        $("#spin1").hide();
    });
    
    
});

$(document).on("click", "#hod_reject", function(event){
       $("#spin1").show();
    var id = $("#id").val();
    var hodreason = $("#reason").val();
    var subid = $("#subid").val();
    $("#rejection_reason").show();
    $("#reason").prop('required',true);
    if (hodreason != '') {
    $.post("/employeezone/lms/admin_application", {_token:'{{csrf_token()}}',id: id,reason:hodreason,subordinateid: subid, status: 0}, function(data){
        console.log(data);
        if (data.status == 1) {
            alert('Updated Successfully!');
            window.location.reload();
        }else{
            alert('Failed Try Again!');
            window.location.reload();
        }
        $("#spin1").hide();
    })
}else{
        alert('Rejection Reason required!');
        $("#spin1").hide();
    }
    
});
      
  });
</script>

  @endsection
