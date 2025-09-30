<?php
require_once 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Admin Login</title>
  <meta name="title" content="">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="google-site-verification" content="sECFO__o3gFBOp5WrIZnWyaB2Cz4i7PEKKzOaLSA3KI" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="" />
  <meta property="og:description" content="" />
  <meta property="og:url" content="https://www.vgn.in/projects/kensington-towers-guindy-chennai" />
  <meta property="og:image" content="<?php echo asset_url . 'img/logo.png'; ?>" />
  <meta property="og:site_name" content="VGN" />
  <link rel="canonical" href="https://www.vgn.in/projects/kensington-towers-guindy-chennai" />
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url . 'css/bootstrap.css'; ?>">
  <!-- fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <!-- FAVICONS -->
  <link rel="shortcut icon" href="<?php echo asset_url . 'img/favicon/favicon.png'; ?>" type="image/png">
  <link rel="icon" href="<?php echo asset_url . 'img/favicon/favicon.png'; ?>" type="image/png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css">
  <style>

    .projects-specifications-right-list p{
      font-family: 'Poppins', sans-serif;
      font-size: 25px;
      color: #e02227;
      font-weight: 700;
      margin-bottom: 10px;
    }

    .projects-specifications-right-list .projects-sub-heading {
      font-family: 'Poppins', sans-serif;
      font-size: 18px;
      color: #000;
      font-weight: 700;
      margin-bottom: 16px;
    }  
    .project-faq-section {
      margin-top: -90px;
    }


    .fancybox__footer{
      display: none!important;
    }

    .fancybox__container{
      z-index: 999999!important;
    }


    .project-heighlights ul li {

      padding-right: 32px;

    }


    .project-overview-section {
      padding: 0px 0px 15px 0px!important;
    }

    .ajax-loader {
/* position: fixed; */
z-index: 10000 !important;
width: 100%;
height: 100%;
top: 0;
left: 0;
right: 0;
bottom: 0;
opacity: 1;
display: flex;
align-items: center;
justify-content: center;
}

.ajax-loader .img {
  position: relative;
  width: 50px;
}
.copyrights {
  background-color: #EEEEEE;
  padding: 20px 0px;
  overflow: hidden;
}
</style>

<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "RealEstateAgent",
    "name": "VGN Projects Estates Pvt. Ltd.",
    "image": "https://cdn.vgn.in/nodeserver/website/logo/vgn-logo.png",
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
<script type="application/ld+json">
  {
    "@context": "https://schema.org/",
    "@type": "BreadcrumbList",
    "itemListElement": [{
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "https://www.vgn.in/"  
    },{
      "@type": "ListItem",
      "position": 2,
      "name": "VGN Fairmont",
      "item": "https://www.vgn.in/projects/fairmont-guindy-chennai"  
    }]
  }
</script>


<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZMV8D0MMQS"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-ZMV8D0MMQS');
</script>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-109458235-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-109458235-1');
</script>


<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-P5MLT26');</script>
<!-- End Google Tag Manager -->

</head>
<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P5MLT26"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
     <nav class="navbar navbar-expand-lg navbar-light copyrights">
      <div class="container">
        <div class="header-logo">
          <a href="<?= base_url ?>"><img src="<?php echo asset_url . 'img/logo.png'; ?>" class="img-fluid" alt="logo" /></a>                
        </div>
      </div>
    </nav>

    <div class="row d-flex justify-content-center align-items-center my-5" style="margin-top:10%;">
      <div class="col-md-4 mt-4 p-5 bg-dark text-white rounded">
        <h3 class="text-center" style="font-family:poppins">Admin Login</h3>

        <!-- Modified form action to point to the login processing PHP file -->
        <form method="POST" action="<?php echo base_url . 'auth.php'; ?>">
          <div class="mb-3">
            <label for="email" class="form-label" style="font-family:poppins">Email address</label>
            <input type="email" class="form-control" required id="email" name="email" aria-describedby="emailHelp">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label" style="font-family:poppins">Password</label>
            <input type="password" name="password" required class="form-control" id="password">
          </div>
          <div class="py-3">
            <input type="submit" value="Submit" name="login" class="btn btn-primary form-control" style="font-family:poppins">
          </div>
        </form>

        <!-- Display error/success messages -->
        <?php
          if (isset($_GET['error'])) {
              echo '<p class="text-danger text-center">' . htmlspecialchars($_GET['error']) . '</p>';
          }
          if (isset($_GET['success'])) {
              echo '<p class="text-success text-center">' . htmlspecialchars($_GET['success']) . '</p>';
          }
        ?>

      </div>
    </div>

    <footer> 
      <div class="copyrights text-center">
        <p>Copyright &copy; 2024 VGN Projects Estates Pvt Ltd. All Rights Reserved. Site Map | <a href="#" class="footer-privacy" data-toggle="modal" data-target="#privacypolicy">Privacy Policy </a> | <a href="https://www.vgn.in/disclaimer" class="footer-privacy"> Disclaimer</a> | <a href="https://www.vgn.in/terms_and_conditions" class="footer-privacy"> Terms and Conditions</a></p>
      </div>
    </footer>
    <!-- </div> -->
    <script type="text/javascript" src="<?php echo asset_url . 'js/jquery-3.3.1.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo asset_url . 'js/bootstrap.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo asset_url . 'js/owl.carousel.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo asset_url . 'js/main.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo asset_url . 'js/jquery.magnific-popup.min.js'; ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>
    <script type="text/javascript" src="<?php echo asset_url . 'js/additional-methods2.js'; ?>"></script>
    <script src="<?php echo asset_url . 'js/lottie.min.js'; ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
  </body>
  </html>