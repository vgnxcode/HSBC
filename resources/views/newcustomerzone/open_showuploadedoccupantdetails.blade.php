@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates |Customer Zone| Customer Show Occupants Details Update VGN
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
                <h3 class="box-title"><i class="fa fa-users margin-r-5"></i> Rental/Second Owner Details </h3><span class="pull-right" ><a href="{{ url('/ocpd') }}/{{$id}}" class="btn btn-danger btn-xs"><i class="fa fa-backward margin-r-5"></i> Back</a></span>
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

               
                              @if(count($occupantdetails) > 0)
                              @foreach($occupantdetails as $occup)
                              <blockquote>
                                <p>Project Name - {{$occup->projectname}}</p>
                                <p>Unit Name - {{$occup->unitname}}</p>
                                <p>Occupant Type - {{$occup->typename}}</p>
                                <p>No. of Occupants - {{$occup->occupantcount}}</p>
                                <h4 style="text-decoration: underline; font-weight: bold;">Occupant Details</h4>
                                <ol>
                                @foreach(json_decode($occup->occupantdata) as $occ)
                                <li>@if ($occ->name != '') <p>Name: {{$occ->name}}</p> @endif
                              @if ($occ->mobile != '') <p>Mobile: {{$occ->mobile}}</p> @endif
                              @if ($occ->email != '') <p>Email: {{$occ->email}}</p> @endif</li>
                              <br>
                                @endforeach
                                </ol>

                              </blockquote>
                              @endforeach                        
                              @endif

                    
                                        
                      
                      
                      <br/><br/>
                      
                                 
                             
              @endif

    </div>

</div>
</div>
</div>
</section>
    

    
  
@endforeach




 
  
</div>
  



@endsection

@section('script')
@include('newcustomerzone.js.commonjs')


<script type="text/javascript">
  
 

        $(document).ready(function(){

                     
        });       
        </script>
            
@endsection