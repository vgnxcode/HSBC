@extends('newcustomerzone.layout')

@section('title')
VGN Property Developers |Customer Zone| Homebuilding Survey
@endsection

@section('description')
    <meta name="description" content="">
@endsection

@section('keyword')  
@endsection


@section('style')
@include('newcustomerzone.styles.commoncss')

<style>

  @import url(https://fonts.googleapis.com/css?family=Roboto:400,100,900);

html,
body {
  -moz-box-sizing: border-box;
       box-sizing: border-box;
  height: 100%;
  width: 100%; 
  background: #FFF;
  font-family: 'Roboto', sans-serif;
  font-weight: 400;
  background-color: #dc0000;

}
 
.wrapper {
  display: table;
  height: 100%;
  width: 100%;
}

.container-fostrap {
  display: table-cell;
  padding: 1em;
  text-align: center;
  vertical-align: middle;
}
.fostrap-logo {
  width: 220px;
  margin-bottom:15px
}
h1.heading {
  color: #fff;
  font-size: 1.15em;
  font-weight: 900;
  margin: 0 0 0.5em;
  color: #505050;
}
@media (min-width: 450px) {
  h1.heading {
    font-size: 3.55em;
  }
}
@media (min-width: 760px) {
  h1.heading {
    font-size: 3.15em;
  }
}
@media (min-width: 900px) {
  h1.heading {
    font-size: 3.25em;
    margin: 0 0 0.3em;
  }
} 
.card {
  display: block; 
    margin-bottom: 20px;
    line-height: 1.42857143;
    background-color: #fff;
    
    box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12); 
    transition: box-shadow .25s; 
}
.card:hover {
  box-shadow: 0 8px 17px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
}
.img-card {
  width: 100%;
  height:200px;
  border-top-left-radius:2px;
  border-top-right-radius:2px;
  display:block;
    overflow: hidden;
}
.img-card img{
  width: 100%;
  height: 200px;
  object-fit:cover; 
  transition: all .25s ease;
} 
.card-content {
  padding:15px;
  text-align:left;
  
}
.card-title {
  margin-top:0px;
  font-weight: 700;
  font-size: 1.9em;
}
.card-title a {
  color: #000;
  text-decoration: none !important;
}
.card-read-more {
  border-top: 1px solid #D4D4D4;
}
.card-read-more a {
  text-decoration: none !important;
  padding:10px;
  font-weight:600;
  text-transform: uppercase
}

.para{
  font-size: 1.3em;
}
  
</style>

@endsection

@section('bodycontent')
<body class="hold-transition fixed" >

<!-- Site wrapper -->
<div class="wrapper">

 
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper1">
    <!-- Content Header (Page header) -->
   
    <!-- Main content -->
    <section class="wrapper">
    <div class="container-fostrap">
      <div class="row">
        
        </div>

        <div class="content">
            <div class="container">
                <div class="row">
                    
                    <div class="col-xs-12 col-md-4 col-md-offset-4">
                        <div class="card">
                            <a  href="#">
    <div style="border-bottom: 1px solid #eee; background: #F44336;">
         <img src="{{ config('app.AWS_URL')}}/images/custom/vgn-logo.png" style="padding: 10px;width: 250px;background:#fff;" />
    </div>
         
            
                          </a>
                            <div class="card-content">
                                <h4 class="card-title">
                                    <a href="http://www.fostrap.com/2016/03/5-button-hover-animation-effects-css3.html">Dear Customer,
                                  </a>
                                </h4>
                                @if(!empty($plant_text))
                                <p class="para">
                                    Greetings from VGN! Are you interested in VGN building your dream Home{{$plant_text}}?
                                </p>
                                @else 
                                <p class="para">
                                    Greetings from VGN! Are you interested in VGN building your dream Home?
                                </p>
                                @endif
                            </div>
                            <!-- <div class="card-read-more">
                                <a href="javascript:void(0)" id="interested" class="btn btn-link btn-block col-md-6">
                                    Yes, I'm interested
                                </a>
                            </div> -->
                            <div style="padding:5px;" class="card-read-more">
                              <button id="interested" type="button" class="btn btn-sm btn-danger"><i class="fa fa-thumbs-up"></i> Interested</button>
                              <button id="notinterested" type="button" class="btn btn-sm btn-danger"><i class="fa fa-thumbs-down"></i> Not Interested</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  </div>



@endsection

@section('script')
@include('newcustomerzone.js.commonjs')


<script type="text/javascript">
                      
        $(document).ready(function(){

                        
                       
                       $("#interested").on('click', function(){
                          $(".card-read-more").hide();
                          $.post("/hbs/{{$saleorderno}}", {'_token': "{{csrf_token()}}",'interested': true}, function(data){
                            console.log(data);
                            if (data == '1') {
                          alert('Thanks for your interest. Our team will get in touch with you shortly!');
                          $(".para").html('');    
                          $(".para").html('Thanks for your interest. Our team will get in touch with you shortly!');    
                          //$(".card-read-more").hide();
                            }
                            else{
                              alert('Sorry! Your input not updated. Please try again!');
                              $(".card-read-more").show();
                            }
                          });

                        });

                       $("#notinterested").on("click", function(){
                        $(".para").html('');    
                        $(".para").html('Thanks for your feedback.');    
                          alert('Thanks for your feedback.');
                              $(".card-read-more").hide();
                       });
    
        });       
        </script>
@endsection
