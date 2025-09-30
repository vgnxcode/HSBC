@extends('layout.app')

@section('title')
VGN: News Page @isset($_REQUEST['page']) {{$_REQUEST['page']}} @endisset|New Room
@endsection

@section('description')
 <META NAME="Subject" CONTENT="News Room">
<meta name="description" content="News Page @isset($_REQUEST['page']) {{$_REQUEST['page']}} @endisset">
<meta name="keywords" content="News, News Room">
<META NAME="Language" CONTENT="English">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
<META NAME="Revisit-After" CONTENT="7 Days">

<meta property='og:locale' content='en_US'/>
<meta property='og:title' content='News Room'/>
<meta property='og:description' content='VGN News Room'/>
<meta property='og:url' content='http://vgn.in/news'/>
<meta property='og:site_name' content='VGN Projects Estates Pvt Ltd'/>
<meta property='og:type' content='article'/>
@endsection

@section('keyword')
    
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/normalize.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/font/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/materialize/css/materialize.min.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/bootstrap.css" media="screen,projection" />

    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/animate.min.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.transitions.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.theme.css" media="screen,projection" />

    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/main.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/responsive.css">
  
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/colors/color1.css">
    <style>
    .smalltext {
        font-size: 13px;
        font-style: italic;
    }
    .pagination li {
    display: inline-block;
    border-radius: 2px;
    text-align: center;
    vertical-align: top;
    height: 30px;
}
.pagination li.active {
    background-color: #ee6e73;
    color: #fff;
    display: inline-block;
    font-size: 1.2rem;
    padding: 0 10px;
    line-height: 30px;
}

.pagination li a {
    color: #444;
    display: inline-block;
    font-size: 1.2rem;
    padding: 0 10px;
    line-height: 30px;
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

            <div class="col-sm-12 col-md-10 black-text">
              <div class="person-about">
                <h3 class="about-subtitle" style="padding-top: 20px;">News Room</h3>

                  <ul class="collection">
                  @foreach($news as $list)
        <li class="collection-item"><div><i class="fa fa-newspaper-o fa-fw"></i> {{$list->newsname}} - <a href="{{$list->file_link }}">{{ $list->link_name }}</a> <br><h6 class="left-align helper-block grey-text smalltext">Posted On - {{ Carbon\Carbon::parse($list->posted_date)->format('M, Y') }} | Type - {{ $list->newstype }}</h6></div></li>
        @endforeach
      </ul>
      <div class="pull-right">
                 {!! $news->render() !!}               
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
    <script src="{{ config('app.AWS_URL')}}/assets/ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.easing.1.3.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/detectmobilebrowser.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/isotope.pkgd.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/wow.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/waypoints.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.counterup.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.nicescroll.min.js"></script>
  
    <script src="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/libs/materialize/js/materialize.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/milestone.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/common.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/main.js"></script>
	
    <script>
  if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {

  $("body").on('click', function(){
    $("#dropdown1").hide();
    $("#dropdown2").hide();
	  $("#dropdown3").hide();
  });
}
else
{
}
</script>
@endsection
