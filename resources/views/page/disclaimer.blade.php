<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>VGN:Disclaimer</title>

    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <meta name="google-site-verification" content="sECFO__o3gFBOp5WrIZnWyaB2Cz4i7PEKKzOaLSA3KI" />

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" media="screen" href="/asset/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/asset/css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/asset/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/asset/style.css?v=15">
    <link rel="stylesheet" type="text/css" media="screen" href="/asset/fonts/font.css">
    <link rel="stylesheet" type="text/css" media="screen" href="/asset/css/magnific-popup.css">
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
    <link rel="shortcut icon" href="/asset/img/favicon/favicon.webp" type="image/png">
    <link rel="icon" href="/asset/img/favicon/favicon.webp" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />


    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "RealEstateAgent",
  "name": "VGN Projects Estates Pvt. Ltd.",
  "image": "https://cdn.vgn.in/nodeserver/website/logo/vgn-logo.webp",
  "@id": "https://www.vgn.in/",
  "url": "https://www.vgn.in/",
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
  } ,
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

</head>

<body>
    <header>

        @include('fragments.header')

    </header>

    <div class="holder" style="margin-top: 80px;">


        {{-- <div id="sidebar-wrapper" style="display:none;" class="">
        <div id="menu-toggle" class="">Enquire Now</div>
      
        <a id="menu-close" href="#" class="btn btn-default btn-lg pull-right toggle"><i class="fa fa-close"></i></a>
        <div id="mainform" class="form_box">
          <form name="form1"  id="slidesubmitForm" method="post" action="/project-lead" class="full-form-container main-form" >
           @csrf
            <div class="">
              <div class="col-md-12">
              <div class="form-group">
                <input id="slidename" name="name" type="text" class="form-control form-text user-icon" placeholder="Name">
              </div>
              </div>
            </div>
            <div class="">
             <div class="col-md-12">
               <div class="form-group">
               <input type="text" id="slidephone" name="mobile" class="form-control form-text email-icon" placeholder="Mobile">
               </div>
             </div>
             </div>
             <div class="">
              <div class="col-md-12">
              <div class="form-group">
                <input type="email" id="slideemail" name="email" class="form-control form-text email-icon" placeholder="Email">
              </div>
              </div>
            </div>
            <div class="">
              <div class="col-md-12">
                <div class="form-group">
                <input type="text" id="slidecity"  name="slidecity" class="form-control form-text email-icon" placeholder="City">
                </div>
              </div>
              </div>
             <div class="form-btn">
             <input class="btn" type="submit" value="submit" id="submitbtn">
             </div>
            </form>    
       </div>
      
        </div> --}}



        <div class="" id="">
            <div class="container">
                <div class="row">
                    <div class="clearfix about-inner">


                        <div class="col-sm-12 col-md-12">
                            <div class="person-about">
                                <h3 class="about-subtitle mt-3">Disclaimer</h3>
                                <p class="mb-3" style="text-align:justify;font-size:16px;"><i class="fa fa-diamond"
                                        style="color:red;"></i> All project information and details displayed on the
                                    site, including but not limited to the information and details contained in project
                                    related materials that you may download are for information purposes only and do not
                                    constitute an offer under any law for the time being in force. The Company shall not
                                    be liable for any decisions you may take as a result of or on the basis of such
                                    information and encourages you to contact the Company directly for updated and
                                    accurate information. The artistic work contained in this web site like 360 degree
                                    view, elevations, walk-through, E-Brochures, other similar material may have been
                                    digitally enhanced or altered and may not represent actual views except expressly
                                    stated otherwise. These are for indicative purpose only. Changes may be made during
                                    the development of a real estate project and standard fittings and specifications
                                    are subject to change without notice. Standard fittings and finishes are subject to
                                    availability and vendor's discretion. Fittings, finishes and fixtures shown in the
                                    images contained herein are not standard and will not be provided as part of an
                                    apartment. Soft furnishing/furniture, gadgets are not part of the offering unless
                                    otherwise mentioned. The information contained herein is believed to be correct but
                                    is not guaranteed. Prospective purchasers should make and must rely on their own
                                    enquiries. The colours of the buildings are indicative only. Any of the contents of
                                    this website is a guide only and do not constitute an offer or contract.</p>
                                <p class="mb-3" style="text-align:justify;font-size:16px;"><i class="fa fa-diamond"
                                        style="color:red;"></i> In no event shall VGN PROJECTS ESTATES PRIVATE LIMITED
                                    and its related, affiliated and subsidiary companies be liable for any direct,
                                    indirect, special, incidental, or consequential damages arising out of the use of
                                    the information contained herein.</p>

                            </div>

                        </div>
                        <!-- about me description -->

                        <!-- about me image -->


                        <!-- about me info -->

                    </div>
                </div>
            </div>
        </div>


    </div>

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
                        <a href="tel:04443439999" class="btn"><img src="/asset/img/icons/footer-phone.webp"> Call</a>
                    </div>
                </div>
                <!--   <div class="col-4 p-0">
            <div class="footer-inner-icon">
              <a href="#" class="btn" data-toggle="modal" data-target="#popupform"><img src="/asset/img/icons/enqiry.webp"> Enquiry </a>
            </div>
          </div> -->
                <div class="col-6 p-0">
                    <div class="footer-inner-icons">
                        <a href="#" id="element_id" class="btn"><img src="/asset/img/icons/top-page.webp"> Top
                        </a>
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
                            <form id="popupsubmitForm" method="post" action="/project-lead"
                                class="full-form-container main-form">
                                @csrf
                                <div>
                                    <h3>Request a Callback</h3>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input id="popupname" name="name" type="text"
                                            class="form-control form-text user-icon" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="text" id="popupphone" name="mobile"
                                            class="form-control form-text email-icon" placeholder="Mobile">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="email" id="popupemail" name="email"
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
                        <p class="privacy-text">Privacy Policy: Your personal information (name, email, phone, message)
                            submitted will not be sold, shared, or rented to others. We use this information to send
                            updates about our project and contact you if requested or found necessary.</p>
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
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind('[data-fancybox="siteplan"]', {
            Toolbar: {
                display: {
                    left: ["infobar"],
                    middle: [
                        "zoomIn",
                        "zoomOut",
                        "toggle1to1",
                        "rotateCCW",
                        "rotateCW",
                        "flipX",
                        "flipY",
                    ],
                    right: ["slideshow", "thumbs", "close"],
                },
            },
        });
    </script>
    <script>
        Fancybox.bind('[data-fancybox="floorplans"]', {
            Toolbar: {
                display: {
                    left: ["infobar"],
                    middle: [
                        "zoomIn",
                        "zoomOut",
                        "toggle1to1",
                        "rotateCCW",
                        "rotateCW",
                        "flipX",
                        "flipY",
                    ],
                    right: ["slideshow", "thumbs", "close"],
                },
            },
        });
    </script>
    <script>
        Fancybox.bind('[data-fancybox="gallery"]', {
            Toolbar: {
                display: {
                    left: ["infobar"],
                    middle: [
                        "zoomIn",
                        "zoomOut",
                        "toggle1to1",
                        "rotateCCW",
                        "rotateCW",
                        "flipX",
                        "flipY",
                    ],
                    right: ["slideshow", "thumbs", "close"],
                },
            },
        });
    </script>

</body>

</html>
