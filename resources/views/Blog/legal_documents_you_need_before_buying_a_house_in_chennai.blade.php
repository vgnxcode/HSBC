@extends('layout.app')

@section('title')
Legal Documents You Need Before Buying A House in Chennai | VGN
@endsection

@section('description')
<META NAME="Subject" CONTENT="Legal Documents You Need Before Buying A House in Chennai | VGN">
<meta name="description" content="Legal Documents You Need Before Buying A House in Chennai | VGN">
<meta name="keywords" content="Legal Documents You Need Before Buying A House in Chennai | VGN">
<META NAME="Language" CONTENT="English">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Robots" CONTENT="All">
<META NAME="Revisit-After" CONTENT="7 Days">

@endsection

@section('keyword')
   
@endsection

@section('stylesheet')
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/normalize.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/font/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/materialize/css/materialize.min.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/bootstrap.css" media="screen,projection" />


    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/animate.min.css" media="screen,projection" />
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/libs/sweetalert/sweet-alert.css">
  
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/main.css">
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/responsive.css">
  
    <link rel="stylesheet" href="{{ config('app.AWS_URL')}}/assets/css/colors/color1.css">
    <link rel="stylesheet" type="text/css" href="{{ config('app.AWS_URL')}}/mobileflag/css/jquery.ccpicker.css">
    <style>
    #about li.collection-item p {
      line-height: 24px;
    font-size: 14px;
    color: #727272;
    }
    #about li.collection-item h6 {
      font-size: 13px;
    }
.cc-picker {
      float: left;
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
.cc-picker {
  top: 35px;
  }
  .cc-picker-code-select-enabled {
    padding-right: 8px !important;
  }

    </style>
     
@endsection

@section('header')
    @include('header.index')
@endsection

@section('content')


<!-- About Section start -->
    <section id="about" class="scroll-section root-sec padd-tb-60 grey lighten-5 about-wrap breadlist">
      <div class="container-fluid">

        <div class="row bread">
          <div class="clearfix about-inner">
          <ul class="breadcrumb">
  <li><a href="{{ url('/') }}">Home</a></li>
  <li><a href="{{ url('/blog') }}">Blog</a></li>
  <li>Blog Page</li>
</ul>
</div>
        </div>

        
          
        


<section style="position:relative;text-align:center;">
    <div class="col-md-9">
        <picture>
          <source media="(max-width: 768px)" type="image/jpeg" srcset="/blogimg/9mobile.jpg">
          <source media="(min-width: 768px)" type="image/jpeg" srcset="/blogimg/9main.jpg">

          <img src="/blogimg/9main.jpg" alt="live_the_beach_life_in_chennai" title="live_the_beach_life_in_chennai">
        </picture>

<div class="row person-about" style="margin-top: 15px;">
  
  
  <div class="col-md-12">
    <span class="grey-text pull-right" style="font-size: 14px;">October 17, 2020</span>
    <br>
  <p style="font-size: 17px;font-weight: 400;">Chennai, formerly known as Madras, is a bustling metropolitan city that attracts visitors from across India. Over the years, the city’s geographical location, strong infrastructure and thriving economy have made Chennai an ideal destination for real estate developments. To buy a house in Chennai, one can come across a lot of jargon that floats around that needs to get addressed, especially for first-time buyers. Hence, before buying a property, being familiar with the various legal documents save you from landing in a legal soup. The most important home loan legal documents are listed below to help you buy a property in Chennai.</p>
  <h2 style="font-size: 30px;font-weight: 500;">Sale Agreement </h2>
  <p style="font-size: 17px;font-weight: 400;">A sale agreement, also known as a title deed, tops the list of the most important home loan documents in buying a new house in Chennai. As the name suggests, a sale agreement is the core registered document with the rightful owner's details over a particular property. When two parties in a property transaction agree, the property's title is transferred via a sale agreement. The document acts as proof that the property is free from any liens or encumbrances. It is always advisable to verify the ownership of the property and the location and extent of the property before signing any deed.</p>
  <h2 style="font-size: 30px;font-weight: 500;">Encumbrance Certificate </h2>
  <p style="font-size: 17px;font-weight: 400;">EC, an acronym for Encumbrance Certificate, affirms that the property is free from any monetary or legal liabilities. An Encumbrance Certificate is one of the most important documents when applying for a home loan. If the property has any dues or financial liability, the property is subject to get marked as a “charge” on the EC. The certificate can be easily obtained from the sub-registrar’s office where the property is registered or across Govt Portals depending on the state and taluk the property is registered. Hence, it is necessary to verify that the property you choose to buy has no pending liabilities added to the encumbrance certificate. </p>
  <h2 style="font-size: 30px;font-weight: 500;">Power of Attorney </h2>
  <p style="font-size: 17px;font-weight: 400;">A power of attorney is a testimony of the sale purchase deed that authorizes another person to present themselves on behalf of the actual owner. The document is another important document that the lender requires in original format when you apply for a home loan. A power of attorney is merely a signing authority and not the actual owner of the property. Hence, it is essential for buyers to check the validity of a power of attorney before buying a property since the principal/owner can cancel a power of attorney without taking concurrence from the actual owner. </p>
  <h2 style="font-size: 30px;font-weight: 500;">Layout Approval </h2>
  <p style="font-size: 17px;font-weight: 400;">According to the norms set by the Tamil Nadu Government, any residential or commercial property in Chennai can be built after seeking approval of the building plan from the authorizing agency. The layout approval is an essential document that holds an entire description of the building, such as the number of floors, surface area, flats on each floor etc. Before buying a home in Chennai, an individual need to provide documents showing the building plan and layout approvals approved by the CMDA or DTCP to apply for a home loan.</p>
  <h2 style="font-size: 30px;font-weight: 500;">No Objection Certificate </h2>
  <p style="font-size: 17px;font-weight: 400;">A property developer must request various No Objective Certificates or NOCs from different departments while completing a housing project. The number of NOCs varies from region to region. Different government departments and authorities, such as safety, electricity, gas, water boards etc. provide a No Objection Certificate to state that all the necessary approvals related to the property are provided to the builder or seller.</p>
  <h2 style="font-size: 30px;font-weight: 500;">Completion or Occupancy Certificate </h2>
  <p style="font-size: 17px;font-weight: 400;">A completion or occupancy certificate is another important document needed to purchase a house in Chennai. The certificate ensures the construction of the building has been completed in accordance with the laws and regulations of the development authority. The certificate also carries information related to the audit carried out during the completion of the property. Buying a residential or commercial property without a completion certificate puts the buyers at risk in availing of facilities, such as water supply, electricity supply, drainage facilities etc. Furthermore, it must be noted that a completion certificate is not available for an under-construction property.</p>
  <h2 style="font-size: 30px;font-weight: 500;">Patta Certificate </h2>
  <p style="font-size: 17px;font-weight: 400;">A patta certificate is essentially an important revenue document that contains all the details related to the property, such as size, location, area etc., to pay property taxes. The certificate is an identification and is also required when applying for a home loan. The legal document verifies that the property is listed in the local municipal records and that the builder received approval before commencing the construction.</P>
  <h2 style="font-size: 30px;font-weight: 500;">Mutation Register Extract </h2>
  <p style="font-size: 17px;font-weight: 400;">In case you are buying a gram panchayat property, a mutation register extract is an important document to consider while compiling mortgage loan documents. A mutation register extract states all the details related to previous ownership etc. When you apply for a loan, there is no need to submit the mutation register certificate in the original format.</P>
  <h2 style="font-size: 30px;font-weight: 500;">Planning Permit </h2>
  <p style="font-size: 17px;font-weight: 400;">A building planning permit is another important document the respective statutory body provides for any construction activity on a piece of land. While applying for a planning permit, the developers submit a sale deed, EC for a period of 13 years, tax receipts, parent documents, NOCs from various statutory authorities, project estimation, etc. Without a valid building planning permit, any construction activity for residential or commercial purposes stands illegal.</P>
  <h2 style="font-size: 30px;font-weight: 500;">Construction Agreement </h2>
  <p style="font-size: 17px;font-weight: 400;">A construction agreement is a written contract between the developer and buyer regarding the building's construction value, payment schedules, construction timeline, and other important terms and conditions. The agreement also carries important remedies for any legal breach between the two parties.</P>
  <p style="font-size: 17px;font-weight: 400;">Investing in a property in Chennai offers numerous benefits, which makes it an ideal real estate investment destination. Before purchasing a property in Chennai or anywhere else in India, it is important to get familiarized with the legal documents checklist for house buying as mentioned above. Suppose you face any problem related to the property or any clarification regarding the project. In that case, you can raise a query to RERA which is the legal body where developers register their properties for selling purposes.</P>

  </div>
</div>


</div>

<div class="col-md-3">
                <div class="card s12">
                   <div class="card-content" style="text-align: center; margin-bottom: 15px;" >
                 <span class="card-title" style="color: #EF533B;font-size: 18px;
        font-weight: 400;line-height: 28px;">For more information Kindly Fill in</span>
            <form class="col s12" action="/blog/live_the_beach_life_in_chennai" method="post" style="color:#000;">
                      {{ csrf_field() }}
                       @if(session()->has('error_msg'))
            <span style="color:red;">{!! Session::get('error_msg') !!}</span>
          @endif
          @if(session()->has('suc_msg'))
            <span style="color:green;">{!! Session::get('suc_msg') !!}</span>
        @endif
                    <div class="row">
                      <div class="input-field col s10 m12">
                        <input id="Name" type="text" name="Name" class="validate" value="{{ old('Name')}}">
                        {!! $errors->first('Name', '<span class="errortext">:message</span>') !!}
                        <label for="Name">Name</label>
                    </div>                     
                    </div>
        
        <div class="row">
                    <div class="input-field col s7 m9">
                       <input id="Mobile1" type="number" name="Mobile" class="validate" pattern="\d*" value="{{ old('Mobile')}}" style="height: 3rem;padding-left: 70px;">
                       {!! $errors->first('Mobile', '<span class="errortext">:message</span>') !!}
                        <label for="Mobile">Mobile</label>
                    </div>

                    </div>
                    <div class="row">   
                     <div class="input-field col s10 m12">
                        <input id="Email" type="email" name="Email" class="validate" value="{{ old('Email')}}">
                        {!! $errors->first('Email', '<span class="errortext">:message</span>') !!}
                        <label for="Email">Email</label>
                    </div>
                    </div>

                    <div class="row">
                      <div class="input-field col s10 m12">
                         <input id="City" type="text" name="City" class="validate" value="{{ old('City')}}">
                         {!! $errors->first('City', '<span class="errortext">:message</span>') !!}
                        <label for="City">City</label>
                    </div>
                    </div>


                
                    <div class="row">
                    <div class="input-field col s10 m12">
                    <button type="submit" class="waves-effect waves-light btn red white-text" ><i class="fa fa-send"></i> Submit</button>
                    </div>
                    </div>
                    
                    </form>

            </div>
                </div>
              </div>
      </section>


       
        </div>
      </div>
      <!-- .container end -->
      
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
    
    <script src="{{ config('app.AWS_URL')}}/assets/libs/sweetalert/sweet-alert.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/jquery.nicescroll.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/libs/owl-carousel/owl.carousel.min.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/libs/materialize/js/materialize.min.js"></script>
    
    <script src="{{ config('app.AWS_URL')}}/assets/js/common.js"></script>
    <script src="{{ config('app.AWS_URL')}}/assets/js/main.js"></script>
    <script src="{{ config('app.AWS_URL')}}/mobileflag/js/jquery.ccpicker.js" type="text/javascript"></script>
	
	
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

   $("#Mobile1").CcPicker();
        $("#Mobile1").CcPicker("setCountryByCode","IN");
             $('#Name, #City').on('change',function(){
    $(this).val($(this).val().toUpperCase());
});

   $("#mobilecontact_btn").on("click", function(){
			setTimeout(function(){
				window.open('tel:04443439999');
			},3000);
	 });
 
});
</script>

  @if(session()->has('24hours'))
    <script>
    swal({
  title: "Warning",
  text: "You can enquire after {{ Carbon\Carbon::parse(Session::get('24hours'))->format('d,M Y h:i:s A') }}",
  type: "warning"
});
</script>
    @endif

    @if(session()->has('success'))
    <script>
    swal({
  title: "Success",
  text: "{{Session::get('success')}}",
  type: "success"
});
</script>
    @endif
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
