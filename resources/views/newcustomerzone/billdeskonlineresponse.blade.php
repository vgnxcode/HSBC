
@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Customer Zone| Online Payment Response Page
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')

@if(session()->has('response_data'))
    <script>
    //window.history.forward(0);
       
  </script>
@else
<script>
    window.location.href="{{url('/customerzone/payonline')}}";
  </script>
@endif

@endsection

@section('bodycontent')
<br><br><br>
<center><strong>Just a moment...! You are being redirected to application site.</strong></center>
<center>[Please do not close/refresh this window]</center>
<center><img src="{{ config('app.AWS_URL')}}/images/formloader.gif" alt="loading" width="75"></center>


@if(session()->has('response_data'))
    <form name="frm2" id="frm2" method=post action="{{ Session::get('response_data.postingurl') }}">
    {{csrf_field()}}
    <input type="hidden" value="{{ Session::get('response_data.appno') }}" name="appno">
    </form>

@else
<?php header('Location: {{ url()->full() }}/customerzone/payonline');?>
@endif


@endsection

@section('script')
@include('newcustomerzone.js.commonjs')

<script>
 $(document).ready(function() {
  //$("#frm2").submit();
});
</script>

@endsection
