<?php
include 'blog.php';
include 'auth.php';
$blogObj = new Blog();
$authObj = new Auth();
if (isset($_POST['login'])) {
    $response = $authObj->doLogin($_POST);
    echo json_encode($response);
}
if (isset($_POST['type'])) {
    if ($_POST['type'] == 'create') {
        $response = $blogObj->save_blog($_POST);
    } else {
        $response = $blogObj->update_blog($_POST);
    }
    echo json_encode($response);
}
if (isset($_GET['offset'])) {
    $slug = '';
    if (isset($_GET['slug'])) {
        $slug = $_GET['slug'];
    }
    $limit = 9;
    $offset = $_GET['offset'];
    $data['blogs'] = $blogObj->fetch_blogs($limit, $offset, $slug);
    $data['blog_count'] = count($data['blogs']);
    $data['total_count'] = $blogObj->fetch_count();
    $data['limit'] = $limit;
    echo json_encode($data);
}
if (isset($_GET['delid'])) {
    $delete = $blogObj->delete_blog($_GET['delid']);
    echo json_encode($delete);
}
if (isset($_POST['update_status'])) {
    $update = $blogObj->update_status($_POST);
    echo json_encode($update);
}
?>