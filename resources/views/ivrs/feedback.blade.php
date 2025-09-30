@extends('ivrs.ivrslayout')


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
      <a class="navbar-brand" href="#">IVRS Feedback report</a>
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
          <form class="form-inline" action = "{{ url('/ivrs/feedback') }}" method="post">
          {{ csrf_field() }}
  <div class="form-group">
    <label for="leaddate">Start Date</label>&nbsp;
    <input type="date" class="form-control" id="leaddate1" name="leaddate1">
    
  </div>
  &nbsp;
  <div class="form-group">
    <label for="leaddate">End Date</label>&nbsp;
    <input type="date" class="form-control" id="leaddate2" name="leaddate2">
    
  </div>
  &nbsp;
  <button type="submit" name="submit" class="btn btn-default">Search</button>
  <br>
  {!! $errors->first('leaddate1', '<span class="errortext">:message</span>') !!}
  <br>
  {!! $errors->first('leaddate2', '<span class="errortext">:message</span>') !!}
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

@if(isset($ivrsfeedback))
<div class="row"><div class="text-center"></div><h4>Feedback Report for the Date Range Between {{ $date1 }} and {{ $date2 }}</h4></div>
@if(count($ivrsfeedback) > 0) 
<?php $good = 0; $bad = 0; $overall = 0; $unknowncodes = 0; ?>
@foreach($ivrsfeedback as $ofeedback)
<?php $overall += 1; ?>
@if($ofeedback->status == '1')
<?php $good += 1; ?>
@elseif($ofeedback->status == '2')
<?php $bad += 1; ?>
@else
<?php $unknowncodes += 1; ?>
@endif
@endforeach
@endif
<div class="row"><div class="text-center"></div>
<br />
<h5>Overall Count - {{$overall}}</h5>, 
<br/>
<h5>Good count - {{$good}}</h5>, 
<br />
<h5>Bad count - {{$bad}}</h5>, 
<br />
<h5>Unknown Feedback Codes - {{$unknowncodes}}</h5>
<br />
</div>
<br>
@endif

<table class="table table-hover" id="myTable">
    <thead><th>S.No</th><th>Customer Mobile No</th><th>Feedback Given</th><th>Recorded Datetime</th></thead>
    
        @if(isset($ivrsfeedback))
        <tbody>
        @if(count($ivrsfeedback) > 0) 
        <?php $i = 1; ?>        
            @foreach($ivrsfeedback as $feedback)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $feedback->mobile }}</td>
                <td>@if($feedback->status == '1') Good @elseif($feedback->status == '2') Bad @else Unknown Status Code @endif</td>
                <td>{{ $feedback->created_datetime }}</td>
  
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
 <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){
    $('#myTable').DataTable();
});
    </script>
@endsection
