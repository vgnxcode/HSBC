@extends('vgnhomes.homeslayout')


@section('style')
    
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
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
            <a class="nav-link text-white" href="{{url('/ivrs/changepassword')}}">Change Password</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="{{url('/ivrs/logout')}}">Signout</a>
          </li>
          
        </ul>
        
        
      </div>
    </nav>


    <div class="container">

            
      <div class="container">
          <form class="form-inline" action = "{{ url('/ivrs/changepassword') }}" method="post">
          {{ csrf_field() }}
  <div class="form-group">
    <label for="newpassword">Enter New Password</label>&nbsp;
    <input type="password" class="form-control" id="newpassword" name="newpassword">
    
  </div>&nbsp;
  <div class="form-group">
    <label for="retypepassword">Re-Type Password</label>&nbsp;
    <input type="password" class="form-control" id="retypepassword" name="retypepassword">
    
  </div>
  &nbsp;
  <div class="form-group">
  <button type="submit" name="submit" class="btn btn-default">Change</button>
  
  </div>
  <br>
  
</form>

<br>
{!! $errors->first('newpassword', '<span class="errortext">:message</span>') !!}<br>
  {!! $errors->first('retypepassword', '<span class="errortext">:message</span>') !!}
<br>
<div class="container">
        <div class="row">
            <div class="col"></div>
            <div class="col">
                 @if(session()->has('error_msg'))
        <div class="alert alert-danger" role="alert">No leads Found!</div>
        @endif
            </div>
            <div class="col"></div>
        </div>
    </div>
<br>









      </div>

    </div>


@endsection


@section('script')
@endsection
