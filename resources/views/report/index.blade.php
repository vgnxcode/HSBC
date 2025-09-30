@extends('layout.app')

@section('title')
Lead Report Page
@endsection

@section('description')
    
@endsection



@section('stylesheet')
    <link rel="stylesheet" href="{{ asset('assets/css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/font/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/libs/materialize/css/materialize.min.css') }}" media="screen,projection" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.css') }}" media="screen,projection" />

    <link rel="stylesheet" href="{{ asset('assets/css/animate.min.css') }}" media="screen,projection" />
    <link rel="stylesheet" href="{{ asset('assets/libs/owl-carousel/owl.carousel.css') }}" media="screen,projection" />
    <link rel="stylesheet" href="{{ asset('assets/libs/owl-carousel/owl.transitions.css') }}" media="screen,projection" />
    <link rel="stylesheet" href="{{ asset('assets/libs/owl-carousel/owl.theme.css') }}" media="screen,projection" />

    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
  
    <link rel="stylesheet" href="{{ asset('assets/css/colors/color1.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css">
    <style>
    #myTable_wrapper select {
    display: block;
}
.sub-title {
        font-size: 28px;
    font-family: Roboto;
    font-weight: bold;
    color: #F44336;
    padding: 15px 0px;
    text-decoration: underline;
}
    </style>
@endsection

@section('header')
    @include('header.index')
@endsection

@section('content')


<!-- About Section start -->
    <section id="about" class="scroll-section root-sec padd-tb-60 grey lighten-5 about-wrap">
      <div class="container">
        <div class="row">
          <div class="clearfix about-inner">

            <div class="col-sm-12 col-md-12 black-text">
              <div class="person-about">
                <h3 class="about-subtitle">Lead Report</h3>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
                <form class="form-inline" action = "{{url('/leadreport')}}" method="post">
                {{ csrf_field() }}
  <div class="form-group">
    <label for="exampleInputName2">Enter Lead Date</label>
    <input type="date" class="datepicker" id="leaddate" name="leaddate" value="{{ old('leaddate')}}">
    {!! $errors->first('leaddate', '<span class="errortext">:message</span>') !!}
  </div>
  
  <button type="submit" name="submit" class="btn btn-default">Search</button>
</form>
</div>
</div>




<div class="row">
    @if($check == 1)
    @if(count($data) > 0)
    <div class="col-md-12">
<h3 class="sub-title center-align">Leads for {{ Carbon\Carbon::parse($leaddate)->format('l, d M Y') }}</h3>
    <table class="mdl-data-table" cellspacing="0" width="100%" id="myTable">
        <thead>
            <tr>
                <th>Project Name</th>
                <th>Source Type</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>City</th>
                <th>Message</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Project Name</th>
                <th>Source Type</th>
                <th>Name</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>City</th>
                <th>Message</th>
            </tr>
        </tfoot>
        <tbody>

            @foreach($data as $dt)
            <tr>
                <td>{{$dt->Project_name}}</td>
                <td>{{$dt->Source_type}}</td>
                <td>{{$dt->Name}}</td>
                <td>{{$dt->Email}}</td>
                <td>{{$dt->Mobile}}</td>
                <td>{{$dt->City}}</td>
                <td>{{$dt->msg}}</td>
                
            </tr>
          
           @endforeach
         
        </tbody>
    </table>

    </div>
   @else
   <h3>No results found!</h3>
    @endif
    @endif
</div>





                  
              </div>

             </div>
            <!-- about me description -->

            <!-- about me image -->

            <div class="col-sm-6 col-md-2">
     

            
            </div>
            <!-- about me info -->

          </div>
        </div>
      </div>
      <!-- .container end -->
       <div class="fab-container">
  <div class="top fab btn-floating btn-large red" ><i class="fa fa-long-arrow-up" aria-hidden="true"></i></div>
</div>
    </section>
    <!-- #about Section end -->

    

@endsection

@section('footer')
    @include('footer.index')
@endsection

@section('scripts')
    <script src="{{ asset('assets/ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('assets/js/detectmobilebrowser.js') }}"></script>
    <script src="{{ asset('assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('assets/js/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/waypoints.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.nicescroll.min.js') }}"></script>
  
    <script src="{{ asset('assets/libs/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/libs/materialize/js/materialize.min.js') }}"></script>
    
    <script src="{{ asset('assets/js/common.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function(){

         $('.datepicker').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 15, // Creates a dropdown of 15 years to control year
    format: 'yyyy-mm-dd'
  });


   $('#myTable').DataTable();
       
    });
    </script>
@endsection