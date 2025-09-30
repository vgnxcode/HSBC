
@extends('newcustomerzone.layout')

@section('title')
VGN Projects Estates Pvt Ltd |Payment Link
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')

@if(session()->has('paymentlinkbilldesk_posting_data'))
    <script>
    window.history.forward(0);
       
  </script>
@else
<script>
    window.location.href="{{url('/customerzone/customerzone')}}";
  </script>
@endif

@endsection

@section('bodycontent')
<br><br><br>
<center><strong>Just a moment...! You are being redirected to merchant site.</strong></center><br>
<center>[Please do not close/refresh this window]</center>
<center><img src="{{ config('app.AWS_URL')}}/images/formloader.gif" alt="loading" width="75"></center>


@if(session()->has('paymentlinkbilldesk_posting_data'))
    <form name="frm" id="frm1" method=post action="{{ Session::get('paymentlinkbilldesk_posting_data.postingurl') }}">
    {{csrf_field()}}
    <input type="hidden" value="{{ Session::get('paymentlinkbilldesk_posting_data.postingval') }}" name="msg">
    </form>

@else
<?php header('Location: {{ url()->full() }}/customerzone/customerzone');?>
@endif


@endsection

@section('script')
@include('newcustomerzone.js.commonjs')

<script>
 $(document).ready(function() {
  $("#frm1").submit();
});
</script>

@endsection