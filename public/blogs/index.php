<?php
require_once 'DbConfig.php';
require_once 'config.php';
include 'blog.php';
$blogObj = new Blog();
$tags = $blogObj->tags();
$db = new DbConfig();
$conn = $db->getConnection();
$limit = 9;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$filter = isset($_GET['tag']) ? $_GET['tag'] : '';
# Query to fetch blogs
if (!empty($filter)) {
  $sql = "SELECT * FROM blogs WHERE tag_slug LIKE '%$filter%' AND poststatus = 'active' ORDER BY datecreated DESC LIMIT $limit OFFSET $offset";
} else {
  $sql = "SELECT * FROM blogs WHERE poststatus = 'active' ORDER BY datecreated DESC LIMIT $limit OFFSET $offset";
}
$result = $conn->query($sql);
# Query to count total blogs for pagination
if (!empty($filter)) {
  $count_sql = "SELECT COUNT(*) AS count FROM blogs WHERE tag_slug LIKE '%$filter%' AND poststatus = 'active'";
} else {
  $count_sql = "SELECT COUNT(*) AS count FROM blogs WHERE poststatus = 'active'";
}
$count_result = $conn->query($count_sql);
$total_blogs = $count_result->fetch_assoc()['count'];
$total_pages = ceil($total_blogs / $limit);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Real Estate Industry Blogs and Insights - VGN</title>
  <meta name="description" content="Explore expert insights, property tips, and real estate trends on the VGN Blogs. ">
  <meta name="author" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="google-site-verification" content="sECFO__o3gFBOp5WrIZnWyaB2Cz4i7PEKKzOaLSA3KI" />


  <meta property="og:type" content="website" />
  <meta property="og:title" content="Real Estate Industry Blogs and Insights - VGN" />
  <meta property="og:description" content="Explore expert insights, property tips, and real estate trends on the VGN Blogs. " />
  <meta property="og:url" content="https://www.vgn.in/blogs/" />
  <meta property="og:image" content="<?php echo asset_url . 'img/logo.png'; ?>" />
  <meta property="og:site_name" content="VGN" />



  <link rel="canonical" href="https://www.vgn.in/blogs/" />


  <!-- CSS -->
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url . 'css/bootstrap.css'; ?>">
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url . 'css/owl.carousel.min.css'; ?>">
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url . 'css/owl.theme.default.min.css'; ?>">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url . 'style.css'; ?>">
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url . 'fonts/font.css'; ?>">
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url . 'css/magnific-popup.css'; ?>">
  <!-- fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <!-- FAVICONS -->
  <link rel="shortcut icon" href="<?php echo asset_url . 'img/favicon/favicon.png'; ?>" type="image/png">
  <link rel="icon" href="<?php echo asset_url . 'img/favicon/favicon.png'; ?>" type="image/png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
  <style>
    .projects-specifications-right-list p {
      font-family: Poppins, sans-serif;
      font-size: 25px;
      color: #e02227;
      font-weight: 700;
      margin-bottom: 10px
    }

    .projects-specifications-right-list .projects-sub-heading {
      font-family: Poppins, sans-serif;
      font-size: 18px;
      color: #000;
      font-weight: 700;
      margin-bottom: 16px
    }

    .project-faq-section {
      margin-top: -90px
    }

    .fancybox__footer {
      display: none !important
    }

    .fancybox__container {
      z-index: 999999 !important
    }

    .project-heighlights ul li {
      padding-right: 32px
    }

    .project-overview-section {
      padding: 0 0 15px !important
    }

    .ajax-loader {
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
      justify-content: center
    }

    .ajax-loader .img {
      position: relative;
      width: 50px
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
  <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "BreadcrumbList",
      "itemListElement": [{
        "@type": "ListItem",
        "position": 1,
        "name": "Home",
        "item": "https://www.vgn.in/"
      }, {
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
  <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P5MLT26" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
  <!-- End Google Tag Manager (noscript) -->

  <header>
    <?php include 'header.php'; ?>

    <div class="header-bottom project-bottom-header">
      <div class="item">
        <img src="<?php echo asset_url . 'img/banners/investore-banner.webp'; ?>" class="img-fluid d-lg-block d-md-block d-sm-none d-none" width="100%" alt="banner">
        <img src="<?php echo asset_url . 'img/banners/investore-banner-mob.webp'; ?>" class="img-fluid d-lg-none d-md-none d-sm-block d-block" alt="banner" width="100%">
      </div>
      <div class="inner-careers-heading">
        <h3><span>BLOGS</span></h3>
      </div>
    </div>
  </header>
  <div class="project-overview-section" id="projectOverview">
    <div class="container">
      <br>
      <ul class="breadcrumb">
        <li><a href="https://www.vgn.in/">Home</a></li>
        <li>Blogs</li>
      </ul>
      <div class="main-heading project-overview-section-heading">
        <h2><span>Recent</span> Blogs</h2>
      </div>
    </div>
  </div>

  <div class="blog-tag-sec">
    <div class="container">
      <ul>
        <li><a href="<?= base_url ?>">All</a></li>
        <?php foreach ($tags as $tag) { ?>
          <li><a href="<?= base_url . '?tag=' . $tag['slug'] ?>" class="mx-2 my-5"><?= $tag['tag'] ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>

  <section class="intent-proj">
    <div class="container">
      <div class="wrapper">
        <div class="row justify-content-center">
          <div class="col-md-12">
            <div class="row" id="blog-container">
              <?php if ($result->num_rows > 0) { ?>
                <?php while ($blog = $result->fetch_assoc()) { ?>
                  <div class="col-md-4">
                    <div class="item">
                      <div class="feature-details proj-details blog-card-main">
                        <div class="feature-project-img blog-card">
                          <img src="<?= base_url . 'uploads/' . $blog['images'] ?>" width="100px" class="img-fluid blog-img" alt="<?= $blog['title'] ?>" class="img img-responsive">
                        </div>
                        <div class="blog-sub">
                          <h5><?= date('F j, Y', $blog['datecreated'] / 1000) ?></h5>
                          <h4><a href="<?= base_url . 'blog_details?slug=' . $blog['slug'] ?>"><?= $blog['title'] ?></a></h4>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              <?php } else { ?>
                <p>No blogs found.</p>
              <?php } ?>
            </div>
          </div>
        </div>
        <!-- Pagination -->
        <br><br>
        <div class="pagination light-theme simple-pagination justify-content-center">
          <?php if ($total_pages > 1) { ?>
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
              <a href="?page=<?= $i ?>&tag=<?= $filter ?>" <?= $page == $i ? 'class="active"' : '' ?>><?= $i ?></a>
            <?php } ?>
          <?php } ?>
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
  <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
  <script>
    $(document).ready(function() {
      // Load more posts on button click
      $(".filter_tag").click(function() {
        let url = $(this).data('url');
        window.location.href = url;
      })
    });
  </script>
</body>

</html>