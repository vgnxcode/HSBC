<?php
require_once '../config.php';
include '../blog.php';
$blogObj = new Blog();
$blog_details = $blogObj->get_blog($_GET);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>VGN Blogs</title>
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
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url . 'css/bootstrap.css'; ?>">
  <link rel="stylesheet" href="<?php echo asset_url . 'richtexteditor/rte_theme_default.css'; ?>" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="<?php echo asset_url . 'img/favicon/favicon.png'; ?>" type="image/png">
  <link rel="icon" href="<?php echo asset_url . 'img/favicon/favicon.png'; ?>" type="image/png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css">
  <style>
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
      justify-content: center;
    }

    .ajax-loader .img {
      position: relative;
      width: 50px;
    }

    .copyrights {
      background-color: #EEEEEE;
      padding: 20px 0px;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light  copyrights">
    <div class="container">
      <div class="header-logo">
        <a href="<?= base_url ?>"><img src="<?php echo asset_url . 'img/logo.png'; ?>" class="img-fluid" alt="logo" /></a>
      </div>
    </div>
  </nav>
  <?php
  $title = "Create a New Blog Post";
  $id = "";
  $type = 'create';
  $button = "Create Post";
  if (!empty($blog_details)) {
    $type = 'update';
    $title = "Update Blog Post";
    $id = $blog_details['id'];
    $button = "Update Post";
  }
  ?>

  <div class="container">
    <h4 class="my-5"><?= $title ?>
      <a href="<?= base_url . 'admin/logout' ?>" class="btn btn-outline-danger float-right btn-sm">Logout</a>
      <br>
      <a href="<?= base_url . 'admin/list_blog' ?>" class="btn btn-outline-primary  btn-sm my-3">All Blogs</a>
      <br>
    </h4>

    <div class="row">
      <div class="card">
        <div class="card-body">
          <form method="post" action="<?= base_url . 'controller.php' ?>" enctype="multipart/form-data">
            <!-- Hidden fields for type and ID -->
            <input type="hidden" name="type" value="<?= $type ?>">
            <input type="hidden" name="id" value="<?= $id ?>">
            <!-- Title Input -->
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" name="title" required
                value="<?php if (!empty($blog_details)) {
                          echo $blog_details['title'];
                        } ?>">
            </div>
             <!-- description Input -->
            <div class="mb-3">
              <label for="description" class="form-label">description</label>
              <input type="text" class="form-control" id="description" name="description" required
                value="<?php if (!empty($blog_details)) {
                          echo $blog_details['description'];
                        } ?>">
            </div>
            <!-- Content Textarea -->
            <div class="mb-3">
              <label for="content" class="form-label">Content</label>
              <textarea class="form-control" id="content" maxlength="10000" name="content" required><?php if (!empty($blog_details)) {
                                                                                    echo $blog_details['content'];
                                                                                  } ?></textarea>
            </div>
            <!-- Tags Input -->
            <div class="mb-3">
              <label for="tags" class="form-label">Tags</label>
              <input type="text" class="form-control" id="tags" name="tags"
                value="<?php if (!empty($blog_details)) {
                          echo $blog_details['tags'];
                        } ?>" placeholder="Enter tags separated by commas">
              <small class="form-text text-muted">Separate tags with commas, e.g., programming, web development, design</small>
            </div>
            <!-- Featured Image Input -->
            <div class="mb-3">
              <label for="featuredImage" class="form-label">Image</label>
              <input type="file" class="form-control" id="featuredImage" name="image" <?php if (empty($blog_details['images'])) {
                                                                                        echo "required";
                                                                                      } ?>>
            </div>

            <!-- Show existing image if available -->
            <?php if (!empty($blog_details['images'])) { ?>
              <img src="<?= base_url . 'uploads/' . $blog_details['images'] ?>" class="img img-responsive img-thumbnail" width="100px" alt="<?= $blog_details['title'] ?>">
            <?php } ?>
            <!-- Post Status Radio Buttons -->
            <div class="mb-3">
              <label class="form-label">Post Status</label>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="poststatus" id="published" value="active" <?php if (empty($blog_details) || $blog_details['poststatus'] == 'active') {
                                                                                                                echo "checked";
                                                                                                              } ?>>
                <label class="form-check-label" for="published">Active</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="poststatus" id="draft" value="inactive" <?php if (!empty($blog_details) && $blog_details['poststatus'] == 'inactive') {
                                                                                                              echo "checked";
                                                                                                            } ?>>
                <label class="form-check-label" for="inactive">Inactive</label>
              </div>
            </div>
            <!-- Submit Button -->
            <input type="submit" name="create_blog" class="btn btn-outline-primary" value="<?= $button ?>">
          </form>
        </div>
      </div>
    </div>
  </div><br>
  <footer>
    <div class="copyrights text-center">
      <p>Copyright &copy; 2025 VGN Projects Estates Pvt Ltd. All Rights Reserved. Site Map | <a href="#" class="footer-privacy" data-toggle="modal" data-target="#privacypolicy">Privacy Policy </a>|<a href="https://www.vgn.in/disclaimer" class="footer-privacy"> Disclaimer</a> |<a href="https://www.vgn.in/terms_and_conditions" class="footer-privacy"> Terms and Conditions</a></p>
    </div>
  </footer>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="<?php echo asset_url . 'js/lottie.min.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo asset_url . 'richtexteditor/rte.js'; ?>"></script>
  <script type="text/javascript" src="<?php echo asset_url .'richtexteditor/plugins/all_plugins.js'; ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
  <script src="<?php echo asset_url . 'js/lottie.min.js'; ?>"></script>
  <script>
    $(function() {
      var editor1 = new RichTextEditor("#content");
      'use strict'
    });
  </script>
</body>

</html>