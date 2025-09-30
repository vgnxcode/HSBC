<?php
require_once 'config.php';
include 'blog.php';
$blogObj = new Blog();
$blog_details = $blogObj->edit_blog($_GET);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title><?php echo $blog_details['title']; ?></title>
  <meta name="description" content="<?php echo $blog_details['description']; ?>">
  <meta name="author" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="google-site-verification" content="sECFO__o3gFBOp5WrIZnWyaB2Cz4i7PEKKzOaLSA3KI" />
  <meta property="og:type" content="website" />
  <meta property="og:title" content="<?php echo $blog_details['title']; ?>" />
  <meta property="og:description" content="<?php echo $blog_details['description']; ?>" />
  <meta property="og:url" content="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
  <meta property="og:image" content="<?php echo asset_url . 'img/logo.png'; ?>" />
  <meta property="og:site_name" content="VGN" />
  <link rel="canonical" href="<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url . 'css/bootstrap.css'; ?>">
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url . 'css/owl.carousel.min.css'; ?>">
  <link rel="stylesheet" type="text/css" media="screen"
    href="<?php echo asset_url . 'css/owl.theme.default.min.css'; ?>">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url . 'style.css'; ?>">
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url . 'fonts/font.css'; ?>">
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url . 'css/magnific-popup.css'; ?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">
  <!-- FAVICONS -->
  <link rel="shortcut icon" href="<?php echo asset_url . 'img/favicon/favicon.png'; ?>" type="image/png">
  <link rel="icon" href="<?php echo asset_url . 'img/favicon/favicon.png'; ?>" type="image/png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
  <style>
    .projects-specifications-right-list p {
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

    .blog-details h3,
    p,
    span,
    b,
    li,
    a,
    strong,
    em {
      font-family: "poppins";
    }

    .project-faq-section {
      margin-top: -90px;
    }

    .fancybox__footer {
      display: none !important;
    }

    .fancybox__container {
      z-index: 999999 !important;
    }

    .project-heighlights ul li {

      padding-right: 32px;

    }

    .project-overview-section {
      padding: 0px 0px 15px 0px !important;
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
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"
  },
  "headline": "<?php echo htmlspecialchars($blog_details['title'], ENT_QUOTES, 'UTF-8'); ?>",
  "description": "<?php echo htmlspecialchars($blog_details['description'], ENT_QUOTES, 'UTF-8'); ?>",
  "image": "<?php echo htmlspecialchars('https://www.vgn.in/blogs/uploads/' . $blog_details['images'], ENT_QUOTES, 'UTF-8'); ?>",
  "author": {
    "@type": "Organization",
    "name": "VGN",
    "url": "https://www.vgn.in/"
  },
  "publisher": {
    "@type": "Organization",
    "name": "VGN",
    "logo": {
      "@type": "ImageObject",
      "url": "https://www.vgn.in/asset/img/logo.png"
    }
  },
  "datePublished": "2025-07-01",
  "dateModified": "2025-07-01"
}
</script>
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-ZMV8D0MMQS"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', 'G-ZMV8D0MMQS');
  </script>
  <!-- Google tag (gtag.js) -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109458235-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', 'UA-109458235-1');
  </script>

  <!-- Google Tag Manager -->
  <script>(function (w, d, s, l, i) {
      w[l] = w[l] || []; w[l].push({
        'gtm.start':
          new Date().getTime(), event: 'gtm.js'
      }); var f = d.getElementsByTagName(s)[0],
        j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
          'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-P5MLT26');</script>
  <!-- End Google Tag Manager -->
</head>

<body>
  <!-- Google Tag Manager (noscript) -->
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P5MLT26" height="0" width="0"
      style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->
  <header>
    <?php include 'header.php'; ?>

    <div class="header-bottom project-bottom-header">
      <div class="item">
        <img src="<?= base_url . 'uploads/' . $blog_details['images'] ?>" class="img-fluid" width="100%"
          alt="<?= $blog_details['title'] ?>">
      </div>
      <div class="inner-careers-heading">
        <!-- <h3>Blog Details</span></h3> -->
      </div>
    </div>
    </div>
  </header>
  <div class="project-overview-section" id="projectOverview">
    <div class="container">
      <br>
      <ul class="breadcrumb">
        <li><a href="https://www.vgn.in/">Home</a></li>
        <li><a href="<?= base_url ?>">Blogs </a></li>
        <li><?php echo $blog_details['title']; ?></li>
      </ul>
    </div>
  </div>
  <section class="intent-proj">
    <div class="container">
      <div class="wrapper">
        <div class="row">
          <div class="col-md-12">
            <div class="blog-details">
              <br>
              <h1><?php echo $blog_details['title']; ?></h1>
              <?php echo $blog_details['content']; ?>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>


  <?php include 'footer.php'; ?>


  <!-- JavaScript Libraries -->
  <script src="https://www.kenyt.ai/botapp/ChatbotUI/dist/js/bot-loader.js" type="text/javascript" data-bot="28583901">
  </script>
  <script type="text/javascript" src="<?php echo asset_url . 'js/jquery-3.3.1.min.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo asset_url . 'js/bootstrap.min.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo asset_url . 'js/owl.carousel.min.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo asset_url . 'js/main.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo asset_url . 'js/jquery.magnific-popup.min.js'; ?>"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>
  <script type="text/javascript" src="<?php echo asset_url . 'js/additional-methods2.js'; ?>"></script>
  <script src="<?php echo asset_url . 'js/lottie.min.js'; ?>"></script>
</body>

</html>