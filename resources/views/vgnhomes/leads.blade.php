@extends('vgnhomes.homeslayout')


@section('style')
    
     <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.3/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.0/css/responsive.dataTables.min.css">
     <style>
        body {
  min-height: 75rem;
  padding-top: 4.5rem;
    }
    .errortext
    {
        color: red;
    }
    </style>
@endsection

@section('content')

<nav class="navbar navbar-expand-md navbar-dark fixed-top" style="background-color: #e31d24;">
      <a class="navbar-brand" href="#">VGN Homes Leads report</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          
        </ul>
        <ul class="navbar-nav ">
          <li class="nav-item">
            <a class="nav-link text-white" href="{{url('/vgnhomes/changepassword')}}">Change Password</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="{{url('/vgnhomes/logout')}}">Signout</a>
          </li>
          
        </ul>
        
        
      </div>
    </nav>


    <div class="container">

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
            
      <div class="container">
          <form class="form-inline" action = "{{ url('/vgnhomes/leads') }}" method="post">
          {{ csrf_field() }}
  <div class="form-group">
    <label for="leaddate">Enter Lead Start Date</label>&nbsp;
    <input type="date" class="form-control" id="leadstdate" name="leadstdate" required="true">
    
  </div>
  &nbsp;
  <div class="form-group">
    <label for="leaddate">Enter Lead End Date</label>&nbsp;
    <input type="date" class="form-control" id="leadetdate" name="leadetdate" required="true">
    
  </div>
  &nbsp;
  <button type="submit" name="submit" class="btn btn-default">Search</button>
  <br>
  {!! $errors->first('leadstdate', '<span class="errortext">:message</span>') !!}
  <br>
  {!! $errors->first('leadetdate', '<span class="errortext">:message</span>') !!}
</form>

<br>
<br>
<div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col">
                 @if(session()->has('error_msg'))
        <div class="alert alert-danger" role="alert">No leads Found!</div>
        @endif

         @if(session()->has('suc_msg'))
        <div class="alert alert-success" role="alert">Password has been updated successfully!</div>
        @endif
            </div>
            <div class="col"></div>
        </div>
    </div>
<br>


<table class="table table-hover" id="myTable">
    <thead><th>S.No</th><th>Campaign Name</th><th>Project Name</th><th>Name</th><th>Email</th><th>Mobile</th><th>Lead Datetime</th></thead>
    
        @if(isset($homesleads))
        <tbody>
        @if(count($homesleads) > 0) 
        <?php $i = 1; ?>        
            @foreach($homesleads as $leads)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $leads->Source_type }}</td>
                <td>{{ $leads->Project_Name }}</td>
                <td>{{ $leads->Name }}</td>
                <td>{{ $leads->Email }}</td>
                <td>{{ $leads->Mobile }}</td>
                <td>{{ $leads->lead_datetime }}</td>

            </tr>
            <?php  $i++; ?>
            @endforeach
        @endif
        </tbody>
        @endif
    
</table>
	







      </div>

    </div>


@endsection


@section('script')
 <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
  <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){
   $('#myTable').DataTable( {
    dom: 'Bfrtip',
    buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
    ]
  } );
});
    </script>
@endsection

