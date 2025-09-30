@extends('layout.app')

@section('title')
About Us
@endsection

@section('description')
    <META NAME="Subject" CONTENT="Premium builders in Chennai">
<meta name="description" content="We are the most reputed premium real estate builders and developers in chennai offers high quality flats and apartments with good infrastructure.">
<meta name="keywords" content="Nungambakkam flats for sale, Approved plots in ambattur, New flats in thiruverkadu">
<META NAME="Language" CONTENT="English">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
<META NAME="Revisit-After" CONTENT="7 Days">

<meta property='og:locale' content='en_US'/>
<meta property='og:title' content='About Us'/>
<meta property='og:description' content='We are the most Reputed Premium real estate builders and developers in chennai offers high quality flats and apartments with good infrastructure.'/>
<meta property='og:url' content='http://vgn.in/aboutus'/>
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
  
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/main.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/responsive.css">
  
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/colors/color1.css">
    <style>
    #about li.collection-item p {
      line-height: 24px;
    font-size: 14px;
    color: #727272;
    }
    #about li.collection-item h6 {
      font-size: 13px;
    }


    #about ul.breadcrumb {
    padding: 10px 16px;
    list-style: none;
    background-color: #eee;
    font-size: 12px;
    color: #000;
    text-transform: uppercase;
    border-radius: 5px;
}

/* Display list items side by side */
#about ul.breadcrumb li {
    display: inline;
}

/* Add a slash symbol (/) before/behind each list item */
#about ul.breadcrumb li+li:before {
    padding: 8px;
    color: black;
    content: "/\00a0";
}

/* Add a color to all links inside the list */
#about ul.breadcrumb li a {
    text-decoration: none;
}

/* Add a color on mouse-over */
#about ul.breadcrumb li a:hover {
    color: #01447e;
    text-decoration: underline;
}

.bread .about-inner {
  margin: 52px 0px 10px 0px
}

.keypeople, .coreteam-inner .keypeople p{
  text-align: center;
  text-transform: uppercase;
}
.keypeople h3 {
      color: #000;
      text-transform: uppercase;
}

.key .coreteam-inner .card-header {
  min-height: 240px;
    max-height: 240p
}

.key .coreteam-inner .card {
  width: 250px;
}
		
		.coreteam-inner .card-header{
  max-height: 300px !important;
}

.maincore {
    padding-top: 0px;
}


    </style>
     
@endsection

@section('header')
    @include('header.index')
@endsection

@section('content')


<!-- About Section start -->
    <section id="about" class="scroll-section root-sec padd-tb-60 grey lighten-5 about-wrap breadlist">
      <div class="container">

        <div class="row bread">
          <div class="clearfix about-inner">
          <ul class="breadcrumb">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li>About Us</li>
</ul>
</div>
        </div>
        <div class="row">
          <div class="clearfix about-inner" style="margin: 8px 0;">
           

            <div class="col-sm-12 col-md-8">
              <div class="person-about">
                <h3 class="about-subtitle">Who We Are</h3>
                <p>Established in the year 1942, VGN has successfully carved a niche for itself in the ever-dynamic real estate industry over the last 77 years. An ISO 9001:2008 certified company, VGN is known as much for its beautiful, world-class homes as it is for following best practices in the industry, being an Integrated Management System (IMS) certified company by Lloyd's Register.</p>
                <p>VGN is a Multi-Million dollar real estate company headquartered in Chennai, which develops residences, commercial, retail and plots in India. With over 20 million square feet of residential projects under development, VGN is one of the most respected and reputed builders in Chennai. Starting with affordable housing and spreading our wings to ultra-luxury segment, we have catered to all sections of the society. Synonymous with quality, timely delivery, expertise and trust, VGN is a name that is here to stay.</p>
                <p>While we may have numerous achievements under our belt, we take pride in the fact that we have been helping thousands of families realize their dreams, providing exponential returns on their investments. And it is this satisfaction that we derive from what we do that makes us venture into newer and more challenging areas in property development.</p>
                
              </div>

             </div>
            <!-- about me description -->

            <!-- about me image -->

            <div class="col-sm-6 col-md-4">
             
                        

             
            </div>
            <!-- about me info -->

          </div>
        </div>
      </div>
      <!-- .container end -->
      
    </section>
    <!-- #about Section end -->

    
    <section id="coreteam" class="scroll-section root-sec brand-bg padd-tb-60 testimonial-wrap">
      <div class="container">
        <div class="row">
          <div class="coreteam-inner">
            <div class="col-sm-12 card-box-wrap">
              
                <div class="clearfix section-head contact-text">
                  <div class="col-sm-12">
                    <h2 class="title">Core Team</h2>
                   <p>VGN is run by a fine team of professionals with rich experience in the Real Estate and the Infrastructure industries.</p>
                  </div>
                </div> <!-- contact text end -->

                <div class="clearfix contact-form">

                <!--<div class="row">
                  <div class="col-sm-12 col-md-3 wow fadeInUpSmall" >
                    <div class="card">
  <div class="card-header">
    <img src="{{ config('app.AWS_URL')}}/images/coreteam/chairman_pic.jpg"/>
  </div>
 
  
</div>
                  </div>

                   <div class="col-sm-12 col-md-9 wow fadeInUpSmall maincore">
                
    <h2 class="sub-title">MR. V.N. DEVADOSS - <small class="subtext">CHAIRMAN</small></h2>
    
    <p>A seasoned entrepreneur and the vision behind the group, he is known for his sharp business acumen and experience in the field. With over 36 years’ experience in the real estate industry, he has spearheaded the company to great heights and has consistently delivered high returns to all VGN customers for decades, surpassing any other investment avenues available in the market today.</p>
                    
                  </div>
            </div>

<br />-->
             <div class="row">
                  <div class="col-sm-12 col-md-3 wow fadeInUpSmall" >
                    <div class="card">
  <div class="card-header">
    <img src="{{ config('app.AWS_URL')}}/images/coreteam/md_pic.jpg"/>
  </div>
 
  
</div>
                  </div> 

                  <div class="col-sm-12 col-md-9 wow fadeInUpSmall maincore">
                
    <h2 class="sub-title">MR. PRATISH VEDHAPPUDI - <small class="subtext">MANAGING DIRECTOR</small></h2>
    
    <p>Mr. Pratish Vedhappudi entered into the real estate business at a very young age from the year 2004. He wanted to implement his dream of venturing into property development and construction of large residential projects in and around Chennai. Since 2008, he has embarked into large residential townships in various parts of Chennai. His motto is to help thousands of families realize their dream of owning a ‘Home’ and also provide exponential returns on their investments in VGN properties . Under his leadership, VGN group has completed over 600 acres of plotted development, consisting of 20,000 residential plots . The company has also delivered around 10,500 apartments under his dynamic leadership. He is the owner of VGN Group.</p>
                    
                  </div>
            </div>
                

                </div>
              

              
            </div>
          </div>
        </div>

        
      </div> <!-- ./container end -->
    </section>


<!--Section: Team v.1-->
<section id="coreteam" class="scroll-section root-sec brand-bg padd-tb-60 testimonial-wrap" >
  <div class="container">
<div class="row key">
<div class="coreteam-inner">
            <div class="col-sm-12 card-box-wrap">
  <div class="clearfix section-head contact-text">
                  <div class="col-sm-12">
                    <h2 class="title">Key Managerial People</h2>
                   
                  </div>
                </div> <!-- contact text end -->

    <!--First row-->
    <div class="row">


<!-- <div class="col-sm-12 col-md-4 wow fadeInUpSmall keypeople" >
  <div class="card">
    <div class="card-header"  style="max-height:220px !important;">
      <img src="{{ config('app.AWS_URL')}}/images/keymanager/finance_cfo.jpg"/>
    </div>
    <div class="card-content center-align">
      <h3 style="text-transform: capitalize;">Mr. G V Ramana</h3>
      <p>Chief Financial Officer - Finance</p>
    </div>
  </div>
</div> -->
                 
<div class="col-sm-12 col-md-4  wow fadeInUpSmall keypeople" >
  <div class="card">
    <div class="card-header"  style="max-height:220px !important;">
      <img src="{{ config('app.AWS_URL')}}/images/keymanager/dgm_sales.jpg"/>
    </div>
    <div class="card-content center-align">
      <h3 style="text-transform: capitalize;">Mr. H. SURESH KUMAR</h3>
      <p>GM - Sales & CRM</p>
    </div>
  </div>
</div>
                 
       <div class="col-sm-12 col-md-4 wow fadeInUpSmall keypeople" >
                    <div class="card">
  <div class="card-header"  style="max-height:220px !important;">
    <img src="{{ config('app.AWS_URL')}}/images/keymanager/design.jpg"/>
  </div>
  <div class="card-content center-align">
<h3 style="text-transform: capitalize;">Mr. A. RANGAPPAN</h3>
<p>DGM - Projects</p>
  </div>
</div>
                  </div>


    <div class="col-sm-12 col-md-4  wow fadeInUpSmall keypeople" >
    <div class="card">
    <div class="card-header"  style="max-height:220px !important;">
    <img src="{{ config('app.AWS_URL')}}/images/keymanager/dgm_cluster.jpg"/>
    </div>
    <div class="card-content center-align">
    <h3 style="text-transform: capitalize;">Mr. V. ARUMUGAM</h3>
    <p>DGM - Construction</p>
    </div>
    </div>
    </div>


   

       

</div>
    <!--/First row-->

<br>
    <!--First row-->
    <div class="row">
      <div class="col-sm-12 col-md-12 wow fadeInUpSmall keypeople" >
        <div class="card">
          <div class="card-header"  style="max-height:220px !important;">
            <img src="{{ env('AWS_URL')}}/images/keymanager/smfinance.jpg"/>
          </div>
          <div class="card-content center-align">
            <h3 style="text-transform: capitalize;">Mr. T. Moorthy</h3>
            <p>Senior Manager - Finance</p>
          </div>
        </div>
      </div>
    </div>
    <!--/First row-->



</div>
</div>

</div>

</div>
</section>
<!--/Section: Team v.1-->
 
 <!-- Funfacts Section end -->
    <section id="funfacts" class="root-sec grey lighten-5 funfact-wrap">
    <div class="sec-inner padd-tb-120">
      <div class="container">
        
         <div class="col-sm-12 col-md-12">

        

              <div class="person-about">
                <h3 class="about-subtitle">Vision</h3>
                <p>To be one of the largest integrated real estate and infrastructure companies in the country. We will deliver reliable, high quality services to real estate and infrastructure, always ensuring that integrity, quality, safety, timely delivery and sustainability are at the heart of everything we do.</p>
              </div>

              <div class="person-about">
                <h3 class="about-subtitle">BELIEFS & VALUES</h3>
                <h4 class="text-bold black-text">CORE VALUES</h4>
                <p>To realize our vision and mission, we always turn to the corporate values that we hold dear. We will live and deliver these values with uncompromising commitment to safety and sustainability.</p>
                <h4 class="text-bold black-text">PERFORMANCE</h4>
                <p>We are here to make a valuable difference to our stakeholders and clients and we will make it happen against all odds.</p>
                <h4 class="text-bold black-text">PASSION</h4>
                <p>We are differentiated by our ‘Can Do’ attitude and the fire in our belly.</p>
                <h4 class="text-bold black-text">TEAM WORK</h4>
                <p>We can gain from the diversity within our group by sharing knowledge and resources to achieve individual and collective success.</p>
              </div>

              <div class="person-about">
                <h3 class="about-subtitle">OUR PEOPLE</h3>
                <p>VGN has a young, growing and dynamic team of professionals who bring to the table varied strengths and competencies. An equal opportunity employer, VGN constantly conducts training programmes across all verticals and at various levels to improve and upgrade the skill sets of every employee.</p>
                <h4 class="text-bold" style="color: #F44336;font-weight: 500;">OBJECTIVE & PRACTICES</h4>
                <p>To build capabilities and competencies in the organization in order to deliver business results, redefining technology and cycle time of projects</p>
                <p>To create a working environment which enhances performance orientation, creates an atmosphere conducive to learning and to ensure that employees are engaged, committed and stay on for a long time in the company
To maximize human potential through vibrant people processes and practices</p>
              </div>
                     

             </div>
             

      </div>  <!-- .container end -->
    </div>
 
    
    </section>
    <!-- #funfacts Section end -->


    


    <!-- Funfacts Section end -->
    <section id="funfacts" class="root-sec grey lighten-5 funfact-wrap">
    <div class="sec-inner padd-tb-120">
      <div class="container">
        
         <div class="col-sm-12 col-md-12">

        

                      <div class="person-about">
                <h3 class="about-subtitle">ENVIRONMENT, HEALTH & SAFETY (EHS)</h3>
                <p>Our Environment, Health & Safety system ensures consistent and effective management of environmental protection, occupational health, safety of our employees, workers throughout the business establishment and interface with partners, clients and contractors.</p>
                <p>Our EHS system promotes improvement by ongoing monitoring, inspection and internal / external audit, which evaluates the EHS performance against established standards.</p>
                <p>We believe that good health, safety and environmental performance are an integral part of efficient and profitable business management. It recognizes that these matters rank equally in importance with other management responsibilities and that success in these areas depends on the involvement and commitment of everyone in the organization.</p>
                <h4 class="text-bold black-text">COMMITMENT</h4>
                <p>As a consequence of our overall commitment to preserve environment, health and safety is established by;</p>
                <ul >
                  <li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> Providing and maintaining healthy and safe working conditions and systems of work for all employees and contractors</p></li>
                  <li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> Effective communication and encouraging their active participation</p></li>
                  <li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> Recognizing and responding constructively to community concerns about health, safety and environmental aspects of our operation</p></li>
                  <li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> Providing sufficient resources in terms of people, training and equipments to meet EHS requirements</p></li>
                  <li><p><i class="fa fa-hand-o-right" aria-hidden="true"></i> Setting targets for improving occupational health, safety and environmental protection</p></li>
                </ul>
                <p>We regard EHS as mainstream management responsibility and concerned executive’s responsibilities are clearly defined for business operations and control.</p>
                <p>Advice and support is provided from the corporate environment, health and safety function to establish and motivate the EHS activities.</p>
                </div>

                      <div class="person-about">
                <h3 class="about-subtitle">QUALITY POLICY</h3>
                <p>At VGN, we give the utmost importance to the quality of the projects we do. All these years, we have been delivering homes to our customers that meet high standards of quality by adopting quality materials, design and construction techniques.</p>
                <p>We believe that organization development depends on the quality of the products and services. As a part of this we have developed a strong team to monitor the quality at regular intervals of time and quality audits through internal / external agencies.</p>
                </div>
                  
                  <div class="person-about hide-on-med-and-up">

               <p><i class="fa fa-hand-o-right" aria-hidden="true"></i> <a href="{{url('/')}}/disclaimer" class="hide-on-med-and-up">Disclaimer</a></p>
               <p><i class="fa fa-hand-o-right" aria-hidden="true"></i> <a href="{{url('/')}}/privacy_policy" class=" hide-on-med-and-up">Privacy Policy</a></p>
               <p><i class="fa fa-hand-o-right" aria-hidden="true"></i> <a href="{{url('/')}}/terms_and_conditions" class=" hide-on-med-and-up">Terms and Conditions</a></p>
              </div>

             </div>
             

      </div>  <!-- .container end -->
    </div>
 
     <div class="fab-container hide-on-small-only">
  <div class="top fab btn-floating btn-large red" ><i class="fa fa-long-arrow-up" aria-hidden="true"></i></div>
</div>
    </section>
    <!-- #funfacts Section end -->
 

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
    
    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.nicescroll.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/libs/materialize/js/materialize.min.js"></script>
    
    <script src="{{ config('app.AWS_URL')}}/assets/js/common.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/main.js"></script>
	
	
    <script>
 $(document).ready(function() {
 
  var owl = $("#owl-demo");
 
  owl.owlCarousel({
    autoPlay : 6000,
    navigation : false,
    singleItem : true,
    transitionStyle : "fade",
    responsive: true
  });

   $("#mobilecontact_btn").on("click", function(){
			setTimeout(function(){
				window.open('tel:04443439999');
			},3000);
	 });
 
});
</script>
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
