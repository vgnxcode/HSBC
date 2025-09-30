<?php 
require_once '../config.php';
include '../blog.php';
$blogObj = new Blog();
$all_blogs = $blogObj->list_blog(); 
$blogs=$all_blogs['blogs'];
$pages= $all_blogs['pages'];
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
  <meta property="og:image" content="<?php echo asset_url.'img/logo.png'; ?>" />
  <meta property="og:site_name" content="VGN" />
  <link rel="canonical" href="https://www.vgn.in/projects/kensington-towers-guindy-chennai" />
  <link rel="stylesheet" type="text/css" media="screen" href="<?php echo asset_url.'css/bootstrap.css';?>">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bree+Serif&family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <!-- FAVICONS -->
  <link rel="shortcut icon" href="<?php echo asset_url.'img/favicon/favicon.png';?>" type="image/png">
  <link rel="icon" href="<?php echo asset_url.'img/favicon/favicon.png';?>" type="image/png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css">
  <style>
    .copyrights {
      background-color:#EEEEEE;
      padding: 20px 0px;
    }
    .status
    {
      width: 120px;
      border-radius: 0px;
      border: 1px dashed #dee2e6;
    }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light  copyrights">
    <div class="container">
      <div class="header-logo">
        <a href="<?=base_url?>"><img src="<?php echo asset_url.'img/logo.png';?>" class="img-fluid" alt="logo" /></a>                
      </div>
    </div>
  </nav>
  <div class="container">
    <h4 class="my-5">All Blogs<a href="<?=base_url.'admin/logout'?>" class="btn btn-outline-danger float-right btn-sm">Logout</a><br><a href="<?=base_url.'admin/create_blog'?>" class="btn btn-outline-primary  btn-sm my-3">Create Blog</a><br></h4>    
    <div class="row d-flex justify-content-center align-items-center my-5">
      <div class="card">
        <div class="card-body">
          <table id="myTable" class="table table-bordered">
            <thead>
              <tr>
                <th>Sl No</th>
                <th>Date</th>
                <th>Image</th>
                <th>Title</th>
                <th>Content</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1; foreach ($blogs as $key => $blog) {
                ?>
                <tr>
                  <td><?=$i?></td>
                  <td><?php echo date('F j, Y', $blog['datecreated']/1000); ?></td>
                  <td><a target="_blank"  href="<?= base_url . 'uploads/' . $blog['images'] ?>"><img src="<?= base_url . 'uploads/' . $blog['images'] ?>" width="100px" class="img-fluid blog-img" alt="<?= $blog['images'] ?>" class="img img-responsive"></a></td>
                  <td><a target="_blank" href="<?php echo base_url.'blog_details?slug='.$blog['slug']; ?>"><?=$blog['title']?></a></td>
                  <td class="content_div"><?php echo substr(strip_tags($blog['content']),0,110) . "..."; ?>
                </td>
                <td>
                  <select class="status form-control" blog_id="<?=$blog['id']?>" onchange="updatestatus(this,<?=$blog['id']?>)">
                    <option <?php if($blog['poststatus']=='active'){ ?> selected <?php } ?> value="active">Active</option>
                    <option <?php if($blog['poststatus']=='inactive'){ ?> selected <?php } ?>  value="inactive">Inactive</option>
                  </select>
                </td>
                <td><a href="<?php echo base_url.'admin/create_blog?id='.$blog['id'] ?>" class="btn btn-outline-warning btn-sm mb-2 w-100">Edit</a><br>
                  <a href="javascript:void(0)" blog_id="<?=$blog['id']?>" onclick="deleteblog(<?=$blog['id']?>)"  class="btn btn-outline-danger btn-sm w-100 delete_blogs">Delete</a></td>
                </tr>
                <?php $i++ ; } ?>
              </tbody>
            </table>
            <!-- <p class="float-left">Showing 1 of <?=$pages?></p> -->
            <nav aria-label="Page navigation example" style="display:none">
              <ul class="pagination justify-content-end">
                <li class="page-item">
                  <?php if(isset($_GET['page']) && $_GET['page']>1){ ?>
                    <a class="page-link" href="?page=1" tabindex="-1" ><<</a>
                  <?php } else { ?>
                    <span class="page-link"><<</span>
                  <?php } ?>
                </li>
                <li class="page-item">
                  <?php 
                  if(isset($_GET['page']) && $_GET['page']>1){
                    ?>
                    <a class="page-link" href="?page=<?=$_GET['page']-1?>" tabindex="-1"><</a>
                  <?php } else { ?>
                    <span class="page-link"><</span>
                  <?php } ?>
                </li>
                <?php  for($counter=1; $counter<=$pages; $counter++){  
                  ?>
                  <li class="page-item page_count" count="<?=$counter?>" id="page_<?=$counter?>"><a class="page-link" href="?page=<?=$counter?>"><?=$counter?></a></li>
                <?php } ?>
                <li class="page-item">
                  <?php if(!isset($_GET['page'])){
                    ?>
                    <a class="page-link" href="?page=2">></a>
                  <?php } else { 
                    if($_GET['page']>=$pages){ 
                      ?>
                      <span class="page-link">></span>
                    <?php  }  else{  ?>
                      <a class="page-link" href="?page=<?=$_GET['page']+1?>" tabindex="-1">></a>
                    <?php }  } ?>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="?page=<?=$pages?>">>></a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
      <footer> 
        <div class="copyrights text-center">
          <p>Copyright &copy; 2024 VGN Projects Estates Pvt Ltd. All Rights Reserved. Site Map | <a href="#" class="footer-privacy" data-toggle="modal" data-target="#privacypolicy" >Privacy Policy </a>|<a href="https://www.vgn.in/disclaimer" class="footer-privacy"> Disclaimer</a> |<a href="https://www.vgn.in/terms_and_conditions" class="footer-privacy"> Terms and Conditions</a></p>
        </div>
      </footer>
      <script type="text/javascript" src="<?php echo asset_url.'js/jquery-3.3.1.min.js';?>"></script>
      <script type="text/javascript" src="<?php echo asset_url.'js/bootstrap.min.js';?>"></script>
      <script type="text/javascript" src="<?php echo asset_url.'js/jquery.dataTables.min.js';?>"></script>
      <script type="text/javascript" src="<?php echo asset_url.'js/dataTables.bootstrap5.min.js';?>"></script>
      <script type="text/javascript" src="<?php echo asset_url.'js/owl.carousel.min.js';?>"></script>
      <script type="text/javascript" src="<?php echo asset_url.'js/main.js';?>"></script>
      <script type="text/javascript" src="<?php echo asset_url.'js/jquery.magnific-popup.min.js';?>"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/additional-methods.min.js"></script>
      <script type="text/javascript" src="<?php echo asset_url.'js/additional-methods2.js';?>"></script>
      <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
      <script>
        new DataTable('#myTable');
        $(document).ready(function(){
        })
      </script>
      <script>
        function updatestatus(obj,id)
        {
          let status= obj.value;
          $.ajax({
            url: '<?php echo base_url.'controller' ?>',
            method:'POST',
            data:{status:status,id:id,update_status:1},
            success:function(data)
            {
              data = JSON.parse(data);
              if (data.status == 'success') {
                toastr.success(data.msg);
                setTimeout(function(){
                  location.reload();
                },1000); 
              }
              else
              {
                toastr.error(data.msg);
              }
            },
            error:function(err)
            {
              err=err.responseJSON;
              toastr.error(err.message);
            }
          })
        }
        function deleteblog(id)
        {
          if (confirm("Are you sure?")){
            $.ajax({
              url: '<?php echo base_url.'controller'?>?delid='+id,
              method:'GET',
              success:function(data)
              {
                data = JSON.parse(data);
                if (data.status == 'success') {
                  toastr.success(data.msg);
                  setTimeout(function(){
                    location.reload();
                  },1000); 
                }
                else
                {
                  toastr.error(data.msg);
                }
              },
              error:function(err)
              {
                err=err.responseJSON;
                toastr.error(err.message);
              }
            })
          }
        }
      </script>
    </body>
    </html>