<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>About Us - Real Estate & Infrastructure Company in Chennai | VGN</title>


    <meta name="description"
        content="VGN is the top real estate & infrastructure comapny in chennai to sell/purchase property? Get details for all real estate property for sale in Chennai at reasonable cost.">

    <meta name="google-site-verification" content="sECFO__o3gFBOp5WrIZnWyaB2Cz4i7PEKKzOaLSA3KI" />


    <meta property="og:type" content="website" />
    <meta property="og:title" content="About Us - Real Estate & Infrastructure Company in Chennai | VGN" />
    <meta property="og:description"
        content="VGN is the top real estate & infrastructure comapny in chennai to sell/purchase property? Get details for all real estate property for sale in Chennai at reasonable cost." />
    <meta property="og:url" content="{{ url()->full() }}/about-us" />
    <meta property="og:image" content="{{ url()->full() }}/asset/img/logo.webp" />
    <meta property="og:site_name" content="VGN" />


    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="canonical" href="{{ url()->full() }}/about-us" />

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" media="screen" href="/asset/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/asset/css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/asset/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/asset/style.css?v=15">
    <link rel="stylesheet" type="text/css" media="screen" href="/asset/fonts/font.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/magnific-popup.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script> -->

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <!-- FAVICONS -->
    <link rel="shortcut icon" href="/asset/img/favicon/favicon.webp" type="image/webp">
    <link rel="icon" href="/asset/img/favicon/favicon.webp" type="image/webp">

    <style>
        .timeline {
            background-image: url("/asset/img/others/completed-projects-bg.webp");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            background-attachment: fixed;
            padding: 50px 0px;
        }

        .timeline ul {
            /*  background: #fff;*/
            padding: 50px 0;
        }

        .timeline ul li {
            list-style-type: none;
            position: relative;
            width: 5px;
            margin: 0 auto;
            padding-top: 50px;
            background: #939393;
        }

        .timeline ul li::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background: inherit;
            z-index: 1;
        }

        .timeline ul li div {
            position: relative;
            bottom: 0;
            width: 400px;
            padding: 15px;
            /*  background: #eee;*/
            line-height: 27px;
        }

        .timeline ul li div::before {
            /* content: "";
  position: absolute;
  bottom: 7px;
  width: 0;
  height: 0;
  border-style: solid;*/
        }

        .timeline ul li:nth-child(odd) div {
            left: 16px;
            top: 50px;
        }

        .timeline ul li:nth-child(odd) div::before {
            left: -15px;
            border-width: 8px 16px 8px 0;
            border-color: transparent #eee transparent transparent;
        }

        .timeline ul li:nth-child(even) div {
            left: -410px;
            text-align: right;
            top: 53px;
        }

        .timeline ul li:nth-child(even) div::before {
            right: -15px;
            border-width: 8px 0 8px 16px;
            border-color: transparent transparent transparent #eee;
        }

        time {
            display: block;
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 8px;
            font-family: poppins;
        }


        /* EFFECTS
–––––––––––––––––––––––––––––––––––––––––––––––––– */

        .timeline ul li::after {
            transition: background 0.5s ease-in-out;
        }

        .timeline ul li.in-view::after {
            background: #e02227;
        }

        .timeline ul li div {
            visibility: hidden;
            opacity: 0;
            transition: all 0.5s ease-in-out;
        }

        .timeline ul li:nth-child(odd) div {
            transform: translate3d(200px, 0, 0);
        }

        .timeline ul li:nth-child(even) div {
            transform: translate3d(-200px, 0, 0);
        }

        .timeline ul li.in-view div {
            transform: none;
            visibility: visible;
            opacity: 1;
            color: #000;
            font-family: poppins;
            border-radius: 10px;

        }

        .timeline ul li:nth-child(even) div {
            /*  box-shadow: -10px 10px 15px -6px #000;*/
        }

        .timeline ul li:nth-child(odd) div {
            /*  box-shadow: 10px 10px 15px -6px #000;*/
        }

        /*.timeline ul li:nth-child(2n+1) div {
  box-shadow: 2px 3px 9px -1px #000;
}*/


        /* GENERAL MEDIA QUERIES
–––––––––––––––––––––––––––––––––––––––––––––––––– */

        @media screen and (max-width: 900px) {
            .timeline ul li div {
                width: 250px;
            }

            .timeline ul li:nth-child(even) div {
                left: -289px;
                /*250+45-6*/
            }
        }

        @media screen and (max-width: 600px) {

            time {
                font-size: 18px;
            }

            .timeline ul li {
                margin-left: 20px;
            }

            .timeline ul li div {
                width: calc(100vw - 91px);
                font-size: 14px;
            }

            .timeline ul li:nth-child(even) div {
                left: 18px;
                /*    box-shadow: 15px 15px 20px -15px #000;*/
                text-align: left;
                top: 50px;
            }

            .timeline ul li:nth-child(even) div::before {
                left: -15px;
                border-width: 8px 16px 8px 0;
                border-color: transparent #eee transparent transparent;
            }
        }


        /* EXTRA/CLIP PATH STYLES
–––––––––––––––––––––––––––––––––––––––––––––––––– */
        .timeline-clippy ul li::after {
            width: 40px;
            height: 40px;
            border-radius: 0;
        }

        .timeline-rhombus ul li::after {
            clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
        }

        .timeline-rhombus ul li div::before {
            bottom: 12px;
        }

        .timeline-star ul li::after {
            clip-path: polygon(50% 0%,
                    61% 35%,
                    98% 35%,
                    68% 57%,
                    79% 91%,
                    50% 70%,
                    21% 91%,
                    32% 57%,
                    2% 35%,
                    39% 35%);
        }

        .timeline-heptagon ul li::after {
            clip-path: polygon(50% 0%,
                    90% 20%,
                    100% 60%,
                    75% 100%,
                    25% 100%,
                    0% 60%,
                    10% 20%);
        }

        .timeline-infinite ul li::after {
            animation: scaleAnimation 2s infinite;
        }

        @keyframes scaleAnimation {
            0% {
                transform: translateX(-50%) scale(1);
            }

            50% {
                transform: translateX(-50%) scale(1.25);
            }

            100% {
                transform: translateX(-50%) scale(1);
            }
        }
    </style>


    <script type="application/ld+json">
        {
            "@context": "https://schema.org/",
            "@type": "BreadcrumbList",
            "itemListElement": [{
                "@type": "ListItem",
                "position": 1,
                "name": "Home",
                "item": "{{ url()->full() }}/"
            }, {
                "@type": "ListItem",
                "position": 2,
                "name": "VGN About Us",
                "item": "{{ url()->full() }}/about-us"
            }]
        }
    </script>


    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "RealEstateAgent",
            "name": "VGN Projects Estates Pvt. Ltd.",
            "image": "https://cdn.vgn.in/nodeserver/website/logo/vgn-logo.webp",
            "@id": "{{ url()->full() }}/",
            "url": "{{ url()->full() }}/",
            "telephone": "044-43439977",
            "address": {
                "@type": "PostalAddress",
                "streetAddress": "Y-222, VGN Kimberly Towers, 2nd Avenue, Anna Nagar",
                "addressLocality": "Chennai",
                "postalCode": "600040",
                "addressCountry": "IN"
            },
            "geo": {
                "@type": "GeoCoordinates",
                "latitude": 13.0851358,
                "longitude": 80.2105602
            },
            "sameAs": [
                "https://www.facebook.com/VGNProjectsEstates",
                "https://twitter.com/VGNProjects",
                "https://www.instagram.com/vgn_projects_estates/",
                "https://www.youtube.com/user/vgndevelopers",
                "https://www.linkedin.com/company/27106479",
                "https://www.pinterest.ru/vgnprojectsestatespvtltd/"
            ]
        }
    </script>

    <script src="https://www.kenyt.ai/botapp/ChatbotUI/dist/js/bot-loader.js" type="text/javascript" data-bot="28583901">
    </script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZMV8D0MMQS"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-ZMV8D0MMQS');
    </script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109458235-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-109458235-1');
    </script>
    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-P5MLT26');
    </script>
    <!-- End Google Tag Manager -->
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P5MLT26" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
    <header>
        @include('fragments.header')

        <div class="header-bottom project-bottom-header">
            <!-- <div class="owl-carousel owl-theme owl-carousel-banner"> -->
            <div class="item">
                <img src="/asset/img/banners/about-banner.webp" class="img-fluid" width="100%"
                    alt="VGN Group - Property Developers in Chennai">
            </div>
            <div class="about-top-main">
                <div class="about-main-img">
                    <img src="/asset/img/others/about-main-top-img.webp" class="img-fluid" alt="About Us - VGN">
                </div>
                <div class="about-list-art" id="aboutmyDIV">
                    <ul class="list-unstyled">
                        <li>
                            <a href="#leadership" class="aboutbtn">
                                <img src="/asset/img/others/about-wings1.webp" class="in-second-wings-img img-fluid"
                                    alt="about-list-img1">
                                <img src="/asset/img/others/red-about-wings1.webp"
                                    class="active-second-wings-img img-fluid" alt="about-list-img1">
                            </a>
                            <div class="inner-one inner-one-text">
                                <h3>VGN Leadership</h3>
                                <p>V. Gurusamy is the founder of VGN groups. In the year 1942 he started a brick kiln
                                    factory and manufactured</p>
                            </div>
                        </li>
                        <li>
                            <a href="#vision" class="aboutbtn">
                                <img src="/asset/img/others/about-wings2.webp" class="in-second-wings-img img-fluid"
                                    alt="about-list-img1">
                                <img src="/asset/img/others/red-about-wings2.webp"
                                    class="active-second-wings-img img-fluid" alt="about-list-img1">
                            </a>
                            <div class="inner-one inner-two-text">
                                <h3>Our Vision</h3>
                                <p>To be one of the largest integrated real estate and infrastructure companies in the
                                    country. </p>
                            </div>
                        </li>
                        <li>
                            <a href="#beliefs" class="aboutbtn">
                                <img src="/asset/img/others/about-wings3.webp" class="in-second-wings-img img-fluid"
                                    alt="about-list-img1">
                                <img src="/asset/img/others/red-about-wings3.webp"
                                    class="active-second-wings-img img-fluid" alt="about-list-img1">
                            </a>
                            <div class="inner-one inner-three-text">
                                <h3>Beliefs & Values</h3>
                                <p>We strive to uphold these principles in all aspects of our business, fostering
                                    lasting relationships. </p>
                            </div>
                        </li>
                        <li>
                            <a href="#managerial" class="aboutbtn">
                                <img src="/asset/img/others/about-wings4.webp" class="in-second-wings-img img-fluid"
                                    alt="about-list-img1">
                                <img src="/asset/img/others/red-about-wings4.webp"
                                    class="active-second-wings-img img-fluid" alt="about-list-img1">
                            </a>
                            <div class="inner-one inner-four-text">
                                <h3>Key People</h3>
                                <p>In VGN, there are key managerial people who play crucial roles in the overall
                                    operation and success of the organisation.</p>
                            </div>

                        </li>
                        <li>
                            <a href="#awards" class="aboutbtn">
                                <img src="/asset/img/others/about-wings5.webp" class="in-second-wings-img img-fluid"
                                    alt="about-list-img1">
                                <img src="/asset/img/others/red-about-wings5.webp"
                                    class="active-second-wings-img img-fluid" alt="about-list-img1">
                            </a>
                            <div class="inner-one inner-five-text">
                                <h3>Awards</h3>
                                <p>The awards collectively demonstrate VGN's commitment to excellence, innovation,
                                    customer satisfaction, sustainability, and overall industry leadership.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- <div class="item">
            <img src="/asset/img/banners/project-banner.jpg" class="img-fluid" width="100%" alt="banner">
          </div> -->
            <!-- </div> -->

        </div>


        </div>
    </header>
    <div class="holder">
        <!-- <div id="sidebar-wrapper" class="">
        <div id="menu-toggle" class="">Enquire Now</div>
      
        <a id="menu-close" href="#" class="btn btn-default btn-lg pull-right toggle"><i class="fa fa-close"></i></a>
        <div id="mainform" class="form_box">
          
          <form name="form1"  id="slidesubmitForm" method="post" action="send2.php" class="full-form-container main-form" >
           
            <div class="">
              <div class="col-md-12">
              <div class="form-group">
                <input id="slidename" name="slidename" type="text" class="form-control form-text user-icon" placeholder="Name">
              </div>
              </div>
            </div>
            <div class="">
             <div class="col-md-12">
               <div class="form-group">
               <input type="text" id="slidephone" name="slidephone" class="form-control form-text email-icon" placeholder="Mobile">
               </div>
             </div>
             </div>
             <div class="">
              <div class="col-md-12">
              <div class="form-group">
                <input type="email" id="slideemail" name="slideemail" class="form-control form-text email-icon" placeholder="Email">
              </div>
              </div>
            </div>
             <div class="form-btn">
             <input class="btn" type="submit" value="submit" id="submitbtn">
             </div>
            </form>
               </div>
      
      </div>  -->


        <div class="inner-about-whoweare-section" id="whoweare">
            <div class="container">
                <ul class="breadcrumb">
                    <li><a href="/">Home</a></li>
                    <li>About Us</li>
                </ul>
                <br>
                <div class="about-whoweare-warp">
                    <div class="main-heading about-whoweare-heading">
                        <h1><span>Who</span> We Are</h1>
                        <p style="text-align: justify">The VGN Group is one of Chennai's leading property developers,
                            with over eight decades of expertise in residential buildings and plotted developments in
                            Chennai. Instituted in 1947, the company has developed many landmark buildings and
                            transformed the skyline of Chennai. VGN has successfully carved a niche for itself in the
                            ever-dynamic real estate industry over the last 83 years. Since its inception, VGN has
                            completed 250+ buildings, amounting to over 20 million sq. ft. of developed space across a
                            diverse real estate portfolio. VGN assures best-in-class design and top-of-the-line
                            facilities that exude elegance and sophistication. The residential developments include
                            premium residences, luxury apartments, value homes, plotted developments, and mixed-use
                            lifestyle enclaves and townships. Over the years, the projects have been one-of-a-kind in
                            the sector; for example, VGN developed VGN Notting Hill, a luxury lifestyle enclave next to
                            Hotel Taj Coromandel in Nungambakkam, and VGN Coasta, a luxury sea-facing apartment complex
                            bang on ECR, Chennai. VGN also enjoys a reputation for developing over 600 acres of plotted
                            developments, amongst a few developers in Chennai. The commercial segment has seen
                            consistent growth over the last few years; hence, VGN is also venturing into office spaces,
                            retail, and industrial warehouses under development.</p>
                    </div>
                </div>
                <div class="project-inner-download" style="text-align:center">
                    <div class="mainfaq-heading"
                        style="font-size:1.6rem; font-weight:bold; font-family:'Poppins', sans-serif; margin-bottom:20px; margin-top:20px;">
                        Our Corporate Brochure</div>
                    <a href="/brochure/vgn-corporate-brochure.pdf" download
                        style="max-width:200px;margin:auto; border-radius:5px;">Download <i class="fa fa-download"
                            aria-hidden="true"></i></a>
                </div>
                <div class="project-inner-download" style="text-align:center">
                    <div class="mainfaq-heading"
                        style="font-size:1.6rem; font-weight:bold; font-family:'Poppins', sans-serif; margin-bottom:20px; margin-top:20px;">
                        Our Newsletter</div>
                    <a href="/brochure/vgn-newsletter.pdf" download
                        style="max-width:200px;margin:auto; border-radius:5px;">Download <i class="fa fa-download"
                            aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
        <div class="inner-leadership-section" id="leadership">
            <div class="container">
                <div class="inner-leadership-wrap">
                    <div class="main-heading about-whoweare-heading">
                        <h2><span>VGN</span> Leadership</h2>
                    </div>
                    <div class="row">

                        <div class="col-md-12">

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="about-main-lt">
                                        <img src="/asset/img/others/abt1.webp"
                                            alt="VGN Managing Director & Owner - Mr. Pratish Vedhappudi">
                                    </div>

                                </div>

                                <div class="col-md-8">

                                    <div class="about-main-rt">
                                        <h3>Mr. Pratish Vedhappudi</h3>
                                        <h5>Managing Director & Owner - VGN Group</h5>
                                        <br>
                                        <p>Mr. Pratish Vedhappudi, Managing Director of VGN Projects Estates, studied
                                            Construction Engineering at Cambridge University, England, UK. He entered
                                            the real estate business in 2004. His eye for detail, engineering prowess,
                                            and business acumen have resulted in the construction of large residential
                                            projects in and around Chennai. Since 2008, he has been developing large
                                            residential townships in various parts of Chennai. Under his leadership,
                                            many prime projects catering to the evolving needs of homebuyers have been
                                            developed. A few recent multi-storyed landmark residential projects include
                                            VGN Notting Hill in Nungambakkam, VGN Fairmont in Guindy, VGN Coasta on East
                                            Coast Road (ECR), and other notable projects in Ambattur.
                                            <br>
                                            Under his leadership, VGN Group has completed over 250 residential projects
                                            and developed more than 600 acres of plotted land, comprising 20,000
                                            residential plots—offering highly lucrative investment opportunities to
                                            VGN's customers. VGN has also delivered around 10,500 premium and luxury
                                            homes under his dynamic leadership, with approximately 1,500 high-quality
                                            homes currently in various stages of development.
                                            <br>
                                            VGN has been recognized and honored with numerous credible awards and
                                            accolades. The company has also sponsored Chennai Super Kings in the IPL
                                            (Indian Premier League). However, the journey is far from over. With a
                                            mission to consistently improve, implement the latest technology in
                                            construction engineering, and provide nothing short of the best for its
                                            customers, VGN's journey continues.
                                        </p>
                                    </div>

                                </div>

                            </div>

                        </div>


                        <div class="col-md-12">

                            <div class="about-main2-bg">

                                <div class="row rev-col">

                                    <div class="col-md-8">

                                        <div class="about-main2-rt">
                                            <h3>Mr. V. Gurusamy (1896 to 1966)</h3>
                                            <h5>Founder</h5>
                                            <br>
                                            <p>V. Gurusamy is the founder of the VGN Group. In 1942, he started a brick
                                                kiln factory and manufactured bricks under the name of VGN. He acquired
                                                land parcels mainly to manufacture bricks in various locations. He
                                                worked hard to build good will and earned a name for the VGN brand.</p>
                                        </div>

                                    </div>

                                    <div class="col-md-4">

                                        <div class="about-main2-lt">
                                            <img src="/asset/img/others/abt2.webp">
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>



                        <!-- <div class="col-md-6">
                <div class="main-leadership-full-wrap">
                            <div class="leadership-main-content">
                                
                                <div class="main-leader">
                                     <div class="leadeship-img-wrap">
                                    <div class="row">
                                        <div class="col-md-4 col-4">
                                            <div class="leadership-img">
                                                <img src="/asset/img/others/leader-img1.webp" class="img-fluid" alt="VGN Founder - Mr. V. Gurusamy">
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-8 align-self-center">
                                            <div class="leadership-content-heading">
                                                <h4>Mr. V. Gurusamy (1896 to 1966) </h4>
                                                <h5>Founder</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="leadership-full-main-content">
                                    <p>V. Gurusamy is the founder of the VGN Group. In 1942, he started a brick kiln factory and manufactured bricks under the name of VGN. He acquired land parcels mainly to manufacture bricks in various locations. He worked hard to build good will and earned a name for the VGN brand.<br> </p>
                                </div>
      
    </div>
                            </div>
                        </div>
                       
                    </div>
                    <div class="col-md-6">
                        <div class="main-leadership-full-wrap">
                                    <div class="leadership-main-content">
                                        
                                        <div class="main-leader">
                                             <div class="leadeship-img-wrap">
                                            <div class="row">
                                                <div class="col-md-4 col-4">
                                                    <div class="leadership-img">
                                                        <img src="/asset/img/others/leader-img2.webp" class="img-fluid" alt="VGN Managing Director & Owner - Mr. Pratish Vedhappudi">
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-8 align-self-center">
                                                    <div class="leadership-content-heading">
                                                        <h4>VGN Managing Director & Owner - Mr. Pratish Vedhappudi</h4>
                                                        <h5>Managing Director</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="leadership-full-main-content">
                                            <p>VGN Managing Director & Owner - Mr. Pratish Vedhappudi is the owner of VGN Group and holds a Master's degree in Construction
                                              Engineering from Cambridge University, UK.
                                              He entered into the real estate business at a very young age.
                                              <p class="more-cont" style="display:none;">
                                              In 2004, he wanted to implement his dream by venturing into property development and the construction of large residential projects in and around Chennai. Since 2008, he has been developing large residential townships in various parts of Chennai. Under his leadership, the VGN group has completed over 250 residential projects and over 600 acres of plotted development, consisting of 20,000 residential plots. VGN has also delivered around 10,500 homes under his dynamic leadership, and around 1500 homes are in the pipeline.
                                              </p>
                                              <a href="#" class="more about-readmore">Know More</a>
                                               </p>
                                        </div>
              
            </div>
                                    </div>
                                </div>
                               
                            </div>  -->
                    </div>
                </div>
            </div>
        </div>
        <div class="inner-about-vision-section" id="vision">
            <div class="container">
                <div class="inner-about-vision-wrap">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="inner-about-vision-img">
                                <img src="/asset/img/others/vision-img.webp" class="img-fluid" alt="VGN Vision">
                            </div>
                        </div>
                        <div class="col-md-8 align-self-center">
                            <div class="inner-about-vision-content">
                                <p>VGN is already a household name in Chennai. We envision a future where VGN is a
                                    household name across the world. Apart from creating a dream home for our customers
                                    and helping many people to own a home to lead a better life, VGN ventures into
                                    creating landmark buildings in offices, retail, malls, industrial warehouses, and
                                    hospitals. A vision to create a future wherein VGN symbolizes unique landmarks and
                                    superior community living of the highest standards of quality and customer
                                    satisfaction.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="inner-about-beliefs-section" id="beliefs">
            <div class="main-heading beliefs-heading">
                <h2><span>Beliefs</span> and Values</h2>
            </div>
            <div class="inner-about-beliefs-wrap">
                <div class="inner-belief-line">
                    <div class="inner-belief-dot">
                        <img src="/asset/img/others/beliefs-dot.webp" class="img-fluid" alt="beliefs-dot">
                    </div>
                    <div class="inner-belief-dot-one">
                        <img src="/asset/img/others/beliefs-dot.webp" class="img-fluid" alt="beliefs-dot">
                    </div>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="inner-about-beliefs-content-main">
                                <div class="row">
                                    <div class="col-md-4 col-4">
                                        <div class="about-beliefs-img">
                                            <img src="/asset/img/others/beliefs-icon1.webp" class="img-fluid"
                                                alt="Corporate Values">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-8">
                                        <div class="about-beliefs-details">
                                            <h3>Core Values</h3>
                                            <p>To realize our vision and mission, we always turn to the corporate values
                                                that we hold dear. We will live and deliver these values with an
                                                uncompromising commitment to safety and sustainability.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="inner-about-beliefs-content-main extra-margin-top">
                                <div class="row">
                                    <div class="col-md-4 col-4">
                                        <div class="about-beliefs-img">
                                            <img src="/asset/img/others/beliefs-icon2.webp" class="img-fluid"
                                                alt="Performance">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-8">
                                        <div class="about-beliefs-details">
                                            <h3>Performance</h3>
                                            <p>We are here to make a valuable difference to our stakeholders and
                                                clients, and we will make it happen against all odds.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="inner-about-beliefs-content-main">
                                <div class="row">
                                    <div class="col-md-4 col-4">
                                        <div class="about-beliefs-img">
                                            <img src="/asset/img/others/beliefs-icon3.webp" class="img-fluid"
                                                alt="Passion">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-8">
                                        <div class="about-beliefs-details">
                                            <h3>Passion</h3>
                                            <p>We are differentiated by our 'Can Do' attitude and the fire in our belly.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="inner-about-beliefs-content-main extra-margin-top">
                                <div class="row">
                                    <div class="col-md-4 col-4">
                                        <div class="about-beliefs-img">
                                            <img src="/asset/img/others/beliefs-icon4.webp" class="img-fluid"
                                                alt="Team Work">
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-8">
                                        <div class="about-beliefs-details">
                                            <h3>Team Work</h3>
                                            <p>We can gain from the diversity within our group by sharing knowledge and
                                                resources to achieve individual and collective success.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="inner-about-managerial-section" id="managerial">
            <div class="inner-about-managerial-wrap">
                <div class="main-heading managerial-heading">
                    <h2><span>Key</span> Managerial People</h2>
                </div>
                <div class="container">
                    <div class="owl-carousel owl-theme owl-carousel-managerial">
                        <div class="item">
                            <div class="inner-about-managerial-img">
                                <img src="/asset/img/others/img11.webp" class="img-fluid">
                                <p class="managerialP">Mr. Suresh Kumar H</p>
                                <p>Head-Sales, Marketing, CRM</p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="inner-about-managerial-img">
                                <img src="/asset/img/others/img6.webp" class="img-fluid">
                                <p class="managerialP">Mr. Moorthy T</p>
                                <p>Head-Finance and Admin</p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="inner-about-managerial-img">
                                <img src="/asset/img/others/img10.webp" class="img-fluid">
                                <p class="managerialP">Mr. Solomon Rajesh S.</p>
                                <p>Head-Public Relations</p>
                            </div>
                        </div>
                        <div class="item">
                            <div class="inner-about-managerial-img">
                                <img src="/asset/img/others/img7.webp" class="img-fluid">
                                <p class="managerialP">Mr. Rangappan A</p>
                                <p>DGM-Public Relations</p>
                            </div>
                        </div>
                        <!-- <div class="item">
                        <div class="inner-about-managerial-img">
                            <img src="/asset/img/others/img5.webp" class="img-fluid">
                            <p class="managerialP">Mr. Lokesh V</p>
                            <p>Head-HR</p>
                        </div>
                    </div> -->
                        <div class="item">
                            <div class="inner-about-managerial-img">
                                <img src="/asset/img/others/img8.webp" class="img-fluid">
                                <p class="managerialP">Mr. Santhosh C R</p>
                                <p>Head-Legal</p>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <div class="inner-about-environment-section" id="environment">
            <div class="main-heading environment-heading">
                <h2><span>Health,</span> Environment & Safety</h2>
            </div>
            <div class="container">
                <div class="inner-about-environment-wrap">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="/asset/img/others/environment-img.webp" class="img-fluid"
                                alt="VGN - Environmental Protection">
                        </div>
                        <div class="col-md-8 align-self-center">
                            <div class="environment-content-main">
                                <p>Our environment, health, and safety system ensures consistent and effective
                                    management of environmental protection, occupational health, and safety of our
                                    employees and workers throughout the business establishment and interfaces with
                                    partners, clients, and contractors.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="inner-about-policy-section" id="policy">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="inner-about-policy-img">
                            <img src="/asset/img/others/about-policy-img.webp" class="img-fluid"
                                alt="VGN Quality Policy">
                        </div>
                    </div>
                    <div class="col-md-9 align-self-center">
                        <div class="about-policy-left-text">
                            <p>At VGN, we give the utmost importance to the quality of the projects we do. All these
                                years, we have been delivering homes to our customers that meet high standards of
                                quality by adopting quality materials, design, and construction techniques.</p>
                            <p>We believe that organisational development depends on the quality of the products and
                                services. As a part of this, we have developed a strong team to monitor quality at
                                regular intervals of time and conduct quality audits through internal / external
                                agencies.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="inner-about-awards-section" id="awards">
            <div class="main-heading environment-heading">
                <h2><span>Our</span> Awards</h2>
            </div>
            <div class="container">
                <div class="inner-about-awards-wrap">
                    <div class="owl-carousel owl-theme owl-carousel-awards">



                        <div class="item">
                            <div class="inner-about-awards-main-details">
                                <img src="/asset/img/awards/about-award-img2.webp" class="img-fluid"
                                    alt="Aircel Super Cup">
                                <div class="inner-about-awards-details">
                                    <h3>Aircel Super Cup</h3>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="inner-about-awards-main-details">
                                <img src="/asset/img/awards/about-award-img3.webp" class="img-fluid"
                                    alt="Chennai Super Kings Super Cup winner">
                                <div class="inner-about-awards-details">
                                    <h3>Chennai Super Kings Super Cup winner</h3>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="inner-about-awards-main-details">
                                <img src="/asset/img/awards/about-award-img4.webp" class="img-fluid"
                                    alt="V Raman Memorial Cup 2017">
                                <div class="inner-about-awards-details">
                                    <h3>V Raman Memorial Cup 2017</h3>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="inner-about-awards-main-details">
                                <img src="/asset/img/awards/about-award-img5.webp" class="img-fluid"
                                    alt="Zenith Cultural Fest Award">
                                <div class="inner-about-awards-details">
                                    <h3>Zenith Cultural Fest Award</h3>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="inner-about-awards-main-details">
                                <img src="/asset/img/awards/about-award-img6.webp" class="img-fluid"
                                    alt="Vijayavani Property Expo Awards 2015">
                                <div class="inner-about-awards-details">
                                    <h3>Vijayavani Property Expo Awards 2015</h3>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="inner-about-awards-main-details">
                                <img src="/asset/img/awards/about-award-img7.webp" class="img-fluid"
                                    alt="Indian Express Property Expo Awards">
                                <div class="inner-about-awards-details">
                                    <h3>Indian Express Property Expo Awards</h3>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="inner-about-awards-main-details">
                                <img src="/asset/img/awards/about-award-img8.webp" class="img-fluid"
                                    alt="India Bulls Premier League Awards 2016">
                                <div class="inner-about-awards-details">
                                    <h3>India Bulls Premier League Awards 2016</h3>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="inner-about-awards-main-details">
                                <img src="/asset/img/awards/about-award-img9.webp" class="img-fluid"
                                    alt="Prince of Arcot Trophy Runners Up 2013">
                                <div class="inner-about-awards-details">
                                    <h3>Prince of Arcot Trophy Runners Up 2013</h3>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="inner-about-awards-main-details">
                                <img src="/asset/img/awards/about-award-img10.webp" class="img-fluid"
                                    alt="Prince of Arcot Trophy Runners Up 2014">
                                <div class="inner-about-awards-details">
                                    <h3>Prince of Arcot Trophy Runners Up 2014</h3>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="inner-about-awards-main-details">
                                <img src="/asset/img/awards/about-award-img11.webp" class="img-fluid"
                                    alt="SAP invitational F15 Cricket Cup winner">
                                <div class="inner-about-awards-details">
                                    <h3>SAP invitational F15 Cricket Cup winner</h3>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="inner-about-awards-main-details">
                                <img src="/asset/img/awards/about-award-img1.webp?v=2" class="img-fluid"
                                    alt="Economic Times BB Reality 2021">
                                <div class="inner-about-awards-details">
                                    <h3>Economic Times BB Reality 2021</h3>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="inner-about-awards-main-details">
                                <img src="/asset/img/awards/about-award-img12.webp" class="img-fluid"
                                    alt="LIC HFL Ungal Illam Awards 2017">
                                <div class="inner-about-awards-details">
                                    <h3>LIC HFL Ungal Illam Awards 2017</h3>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="inner-about-awards-main-details">
                                <img src="/asset/img/awards/about-award-img13.webp" class="img-fluid"
                                    alt="Economic Times Reality Convention Awards">
                                <div class="inner-about-awards-details">
                                    <h3>Economic Times Reality Convention Awards</h3>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="inner-about-awards-main-details">
                                <img src="/asset/img/awards/about-award-img14.webp" class="img-fluid"
                                    alt="HDFC Preferred Developer Award">
                                <div class="inner-about-awards-details">
                                    <h3>HDFC Preferred Developer Award</h3>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="inner-about-awards-main-details">
                                <img src="/asset/img/awards/about-award-img15.webp" class="img-fluid"
                                    alt="Aircel Super Cup">
                                <div class="inner-about-awards-details">
                                    <h3>Aircel Super Cup</h3>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="inner-about-awards-main-details">
                                <img src="/asset/img/awards/about-award-img16.webp" class="img-fluid"
                                    alt="LIC HFL Ungal Illam awards 2013">
                                <div class="inner-about-awards-details">
                                    <h3>LIC HFL Ungal Illam awards 2013</h3>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="inner-about-awards-main-details">
                                <img src="/asset/img/awards/about-award-img17.webp" class="img-fluid"
                                    alt="TV and Radio Awards 2017">
                                <div class="inner-about-awards-details">
                                    <h3>Maddys - Advertising Club Madras Daily Thanthi - TV and Radio Awards 2017</h3>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="inner-about-awards-main-details">
                                <img src="/asset/img/awards/about-award-img18.webp?v=2" class="img-fluid"
                                    alt="TV and Radio Awards 2017">
                                <div class="inner-about-awards-details">
                                    <h3>FICCI Award for the best Integrated Township, 2024</h3>
                                </div>
                            </div>
                        </div>

                        <div class="item">
                            <div class="inner-about-awards-main-details">
                                <img src="/asset/img/awards/about-award-img19.webp" class="img-fluid"
                                    alt="TV and Radio Awards 2017">
                                <div class="inner-about-awards-details">
                                    <h3>FICCI Certificate of Recognition for the best Integrated Township, 2024</h3>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>



        </div>



        <section class="timeline">
            <div class="main-heading">
                <h2><span>Major</span> Milestones</h2>

                <div class="container">
                    <p class="milestonePara">VGN's major milestones in real estate and property development mark
                        significant achievements in our journey to create exceptional living and Commercial spaces. From
                        acquiring prime land parcels to delivering iconic projects.</p>
                </div>

            </div>
            <ul id="milestoneList">

                <li>
                    <div>
                        <time>2025</time>VGN Richmond Towers,
                        Guindy - 252 units.
                    </div>
                </li>

                <li>
                    <div>
                        <time>2024</time>VGN Kensington Towers,
                        Guindy - 122 units.
                    </div>
                </li>

                <li>
                    <div>
                        <time>2022</time>VGN Fairmont Phase-l,
                        Guindy - 681 units.
                    </div>
                </li>

                <li>
                    <div>
                        <time>2021</time>VGN Notting Hill, Nungambakkam - 166 units
                    </div>
                </li>

                <li>
                    <div>
                        <time>2020</time>VGN Mayfield Park, Tambaram - 342 units
                    </div>
                </li>

                <li>
                    <div>
                        <time>2020</time>VGN Oval Gardens, Ambattur - 164 units
                    </div>
                </li>


                <li>
                    <div>
                        <time>2019</time>VGN Melrose Gardens,
                        Tambaram - 208 units
                    </div>
                </li>

                <li>
                    <div>
                        <time>2019</time>VGN Coasta, ECR - 119 units
                    </div>
                </li>

                <li>
                    <div>
                        <time>2019</time>VGN Victoria Park, Ambattur - 231 units
                    </div>
                </li>

                <li>
                    <div>
                        <time>2019</time>VGN Crofton Gardens, Avadi - 561 units
                    </div>
                </li>


                <li>
                    <div>
                        <time>2018</time>VGN Temple Town, Thiruverkadu - 524 units
                    </div>
                </li>

                <li>
                    <div>
                        <time>2018</time>VGN Brent Park,
                        Ambattur - 231 units
                    </div>
                </li>

                <li>
                    <div>
                        <time>2017</time>VGN Stafford, Ambattur - 1286 units
                    </div>
                </li>

                <li>
                    <div>
                        <time>2017</time>VGN Trinity Gardens, Tambaram - 39 units
                    </div>
                </li>

                <li>
                    <div>
                        <time>2017</time>VGN Cosmopolis, Ambattur - 221 units
                    </div>
                </li>

                <li>
                    <div>
                        <time>2017</time>VGN Krona - II, Gerugambakkam - 82 units
                    </div>
                </li>

                <li>
                    <div>
                        <time>2016</time>VGN Brixton,
                        Irungattukottai - 818 units
                    </div>
                </li>

                <li>
                    <div>
                        <time>2015</time>VGN Krona - I , Gerugambakkam - 359 units
                    </div>
                </li>

                <li>
                    <div>
                        <time>2014</time>VGN Platina, Ayapakkam - 682 units
                    </div>
                </li>

                <li>
                    <div>
                        <time>2013</time>VGN Ferndale, Nolambur - 160 units
                    </div>
                </li>

                <li>
                    <div>
                        <time>2011</time>VGN Minerva, Nolambur - 581 units
                    </div>
                </li>


            </ul>

        </section>


        <script>
            (function(w, d, s, c, r, a, m) {
                w['KiwiObject'] = r;
                w[r] = w[r] || function() {
                    (w[r].q = w[r].q || []).push(arguments)
                };
                w[r].l = 1 * new Date();
                a = d.createElement(s);
                m = d.getElementsByTagName(s)[0];
                a.async = 1;
                a.src = c;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', "https://app.interakt.ai/kiwi-sdk/kiwi-sdk-17-prod-min.js?v=" + new Date().getTime(),
                'kiwi');
            window.addEventListener("load", function() {
                kiwi.init('', 'AkCnPOJFo2tKJc0trZP0NlalEm1gB9r5', {});
            });
        </script>

        @include('fragments.footer')


        <div class="footer-main-menu d-lg-none d-md-none d-sm-block d-block">
            <div class="footer-main-wrap">
                <div class="row">
                    <div class="col-6 p-0">
                        <div class="footer-inner-icon">
                            <a href="tel:04443439999" class="btn"><img src="/asset/img/icons/footer-phone.webp">
                                Call</a>
                        </div>
                    </div>
                    <!-- <div class="col-4 p-0">
          <div class="footer-inner-icon">
            <a href="#" class="btn" data-toggle="modal" data-target="#popupform"><img src="/asset/img/icons/enqiry.webp"> Enquiry </a>
          </div>
        </div> -->
                    <div class="col-6 p-0">
                        <div class="footer-inner-icons">
                            <a href="#" id="element_id" class="btn"><img
                                    src="/asset/img/icons/top-page.webp"> Top </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="popupform">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <!-- <h4 class="modal-title text-primary">AUDITION</h4> -->

                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body mx-auto w-100">
                        <div class="">
                            <div id="popupmainform" class="form_box">

                                <form id="popupsubmitForm" method="post" action="send3.php"
                                    class="full-form-container main-form">
                                    <div>
                                        <h3>Request a Callback</h3>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input id="popupname" name="popupname" type="text"
                                                class="form-control form-text user-icon" placeholder="Name">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" id="popupphone" name="popupphone"
                                                class="form-control form-text email-icon" placeholder="Mobile">
                                        </div>
                                    </div>



                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="email" id="popupemail" name="popupemail"
                                                class="form-control form-text email-icon" placeholder="Email">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input type="text" id="popupcity" name="popupcity"
                                                class="form-control form-text email-icon" placeholder="City">
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <input class="btn form-control form-text submitBtn" type="submit"
                                                value="SUBMIT" id="popupsubmitbtn" />
                                        </div>
                                    </div>


                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="privacypolicy">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <!-- <h4 class="modal-title text-primary">AUDITION</h4> -->

                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body mx-auto w-100">
                        <div class="">
                            <p class="privacy-text">Privacy Policy: Your personal information (name, email, phone,
                                message) submitted will not be sold, shared, or rented to others. We use this
                                information to send updates about our project and contact you if requested or found
                                necessary.</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- JavaScript Libraries -->
        <script type="text/javascript" src="/asset/js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="/asset/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/asset/js/owl.carousel.min.js"></script>
        <script type="text/javascript" src="/asset/js/main.js?v=3"></script>
        <script type="text/javascript" src="/asset/js/jquery.magnific-popup.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>
        <script type="text/javascript" src="/asset/js/additional-methods2.js"></script>
        <!-- <script>
            var ltn__active_item = $('.feature-sub-heading')
            ltn__active_item.mouseover(function() {
                ltn__active_item.removeClass('active');
                $(this).addClass('active');
            });
        </script> -->


        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const ul = document.getElementById('milestoneList');
                const items = Array.from(ul.children); // Convert HTMLCollection to Array

                // Reverse the array
                items.reverse();

                // Append items in reversed order
                items.forEach(item => ul.appendChild(item));
            });
        </script>

        <script>
            //     $(document).ready(function() {
            //     $(".main-one").click(function () {
            //         if(!$(this).hasClass('active'))

            //         {
            //             $(".main-one.active").removeClass("active");
            //             $(this).addClass("active");  
            //             $(".status-extra-list").addClass("actives")     
            //         }
            //     });
            // });
            $(".main-one").click(function() {
                $(".main-one").removeClass('actives')
                $(this).addClass('actives')
            });
        </script>
        <script>
            /* magnificPopup img view */
            $('.projects-image').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        </script>
        <script>
            /* magnificPopup img view */
            $('.projects-location').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        </script>
        <script>
            /* magnificPopup img view */
            $('.projects-amenities').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        </script>
        <script>
            /* magnificPopup img view */
            $('.site-map').magnificPopup({
                type: 'image',
                gallery: {
                    enabled: true
                }
            });
        </script>
        <script type="text/javascript">
            $("#menu-close").click(function(e) {
                e.preventDefault();
                $("#sidebar-wrapper").toggleClass("active");
            });
            $("#menu-toggle").click(function(e) {
                e.preventDefault();
                $("#sidebar-wrapper").toggleClass("active");
            });
        </script>
        <script>
            // Add aboutactive class to the current button (highlight it)
            var header = document.getElementById("aboutmyDIV");
            var aboutbtns = header.getElementsByClassName("aboutbtn");
            for (var i = 0; i < aboutbtns.length; i++) {
                aboutbtns[i].addEventListener("click", function() {
                    var current = document.getElementsByClassName("aboutactive");
                    current[0].className = current[0].className.replace(" aboutactive", "");
                    this.className += " aboutactive";
                });
            }
        </script>
        <script>
            $('.more').click(function(e) {
                e.preventDefault();
                $(this).text(function(i, t) {
                    // return t == 'close' ? 'Know more' : 'Less more';
                }).prev('.more-cont').slideToggle()
            });
        </script>


        <script>
            (function() {
                "use strict";

                // define variables
                var items = document.querySelectorAll(".timeline li");

                // check if an element is in viewport
                // http://stackoverflow.com/questions/123999/how-to-tell-if-a-dom-element-is-visible-in-the-current-viewport
                function isElementInViewport(el) {
                    var rect = el.getBoundingClientRect();
                    return (
                        rect.top >= 0 &&
                        rect.left >= 0 &&
                        rect.bottom <=
                        (window.innerHeight || document.documentElement.clientHeight) &&
                        rect.right <= (window.innerWidth || document.documentElement.clientWidth)
                    );
                }

                function callbackFunc() {
                    for (var i = 0; i < items.length; i++) {
                        if (isElementInViewport(items[i])) {
                            items[i].classList.add("in-view");
                        }
                    }
                }

                // listen for events
                window.addEventListener("load", callbackFunc);
                window.addEventListener("resize", callbackFunc);
                window.addEventListener("scroll", callbackFunc);
            })();
        </script>


</body>

</html>