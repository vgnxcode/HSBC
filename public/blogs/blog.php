<?php
include_once 'DbConfig.php';
class Blog extends DbConfig
{
    public function __construct()
    {
        parent::__construct();
    }
    function slug($string)
    {
        $slug = strtolower($string);
        $slug = str_replace(' ', '-', $slug);
        $slug = preg_replace('/[^A-Za-z0-9\-]/', '', $slug);
        return $slug;
    }
    public function unixDateTime()
    {
        date_default_timezone_set("UTC");
        $unixdate = (time() * 1000);
        return $unixdate;
    }
    function debug($ele = array())
    {
        echo "<pre>";
        print_r($ele);
        $data = debug_backtrace();
        echo '<br>File Name =>' . $data[0]['file'];
        echo '<br>Line No   =>' . $data[0]['line'];
        echo "<br>";
    }
    public function checkauth()
    {
        session_start();
        $redirect = '/blogs/login';
        if ($_SESSION['id']) {
            return true;
        } else {
            header("location: $redirect");
        }
    }
   public function save_blog($data)
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    $response = array('status' => 'error', 'st_code' => 400, 'msg' => 'Something went wrong!');

    if (!empty($data['title']) && !empty($data['content'])) {
        $slug = $this->slug($data['title']);
        $title = $this->conn->real_escape_string($data['title']);
        $description = $this->conn->real_escape_string($data['description']);
        $content = $this->conn->real_escape_string($data['content']);
        $tag_s = $this->conn->real_escape_string(trim($data['tags']));
        $status = $this->conn->real_escape_string($data['poststatus']);
        $createdby = $_SESSION['id'] ?? 0;
        $created = $this->unixDateTime();
        $updated = $this->unixDateTime();

        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/blogs/uploads/";
        $fileName = "";

        if (isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"])) {
            $fileName = $this->unixDateTime() . basename($_FILES["image"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
            if (in_array(strtolower($fileType), $allowTypes)) {
                if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                    $response['msg'] = 'File upload failed at move_uploaded_file';
                    return $response;
                }
            } else {
                $response['msg'] = 'Invalid file type.';
                return $response;
            }
        }

        $tags = explode(',', $tag_s);
        $tag_arr = array();
        foreach ($tags as $tag) {
            $tag_slug = $this->slug(trim($tag));
            array_push($tag_arr, array('tag_slug' => $tag_slug));
        }

        $tagslug = implode(',', array_map(function ($item) {
            return $item['tag_slug'];
        }, $tag_arr));

        $sql = "INSERT INTO blogs (title, description, slug, content, tags, tag_slug, images, poststatus, datecreated, createdby, dateupdated) 
                VALUES ('$title', '$description', '$slug', '$content', '$tag_s', '$tagslug', '$fileName', '$status', '$created', '$createdby', '$updated')";

        $result = $this->conn->query($sql);

        if ($result) {
            header('Location: admin/list_blog');
            exit();
        } else {
            $response['msg'] = 'MySQL Error: ' . $this->conn->error;
        }
    } else {
        $response['msg'] = 'Invalid data.';
    }

    return $response;
}
    public function list_blogbk()
    {
        if ($this->checkauth()) {
            $limit = 5;
            $offset = 0;
            $sql1 = "SELECT * FROM blogs";
            $total_count = $this->conn->query($sql1)->num_rows;
            $pages = ceil($total_count / $limit);
            if (isset($_GET['page'])) {
                $page = $_GET['page'] - 1;
                $offset = $page * $limit;
            }
            $sql = "SELECT * FROM blogs  ORDER BY datecreated DESC LIMIT $limit OFFSET $offset";
            $result = $this->conn->query($sql);
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $res_data = array('blogs' => $data, 'pages' => $pages);
            return $res_data;
        }
    }
    public function list_blog()
    {
        if ($this->checkauth()) {
            $sql = "SELECT * FROM blogs  ORDER BY datecreated DESC";
            $result = $this->conn->query($sql);
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $res_data = array('blogs' => $data, 'pages' => '');
            return $res_data;
        }
    }
    public function get_blog($data)
    {
        if ($this->checkauth()) {
            $blog_details = array();
            if (isset($_GET['id'])) {
                $id = $data['id'];
                $sql = "SELECT * FROM blogs WHERE id = '$id'";
                $result = $this->conn->query($sql);
                if ($result->num_rows > 0) {
                    $blog_details = $result->fetch_assoc();
                }
            }
            return $blog_details;
        }
    }
    public function edit_blog($data)
    {
        $blog_details = array();
        if (isset($_GET['slug'])) {
            $slug = $data['slug'];
            $sql = "SELECT * FROM blogs WHERE slug = '$slug'";
            $result = $this->conn->query($sql);
            if ($result->num_rows > 0) {
                $blog_details = $result->fetch_assoc();
            }
        }
        return $blog_details;
    }
    public function update_blog($data)
{
    if ($this->checkauth()) {
        $id = $data['id'];
        $response = array('status' => 'error', 'st_code' => 400, 'msg' => 'Something went wrong!');

        if (isset($id) && !empty($id)) {
            $sql = "SELECT * FROM blogs WHERE id = '$id'";
            $result = $this->conn->query($sql);
            $check_blog = $result->fetch_assoc();

            if (!empty($check_blog)) {
                if (!empty($data['title']) && !empty($data['content'])) {

                    // Sanitize input
                    $title = $this->conn->real_escape_string($data['title']);
                    $description = $this->conn->real_escape_string($data['description']);
                    $content = $this->conn->real_escape_string($data['content']);
                    $tag_s = $this->conn->real_escape_string(trim($data['tags']));
                    $status = $this->conn->real_escape_string($data['poststatus']);
                    $slug = $this->slug($title);
                    $updated = $this->unixDateTime();

                    $fileName = $check_blog['images']; // Default: existing image
                    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
                        $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/blogs/uploads/";
                        $fileName = $this->unixDateTime() . basename($_FILES["image"]["name"]);
                        $targetFilePath = $targetDir . $fileName;
                        $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

                        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
                        if (in_array($fileType, $allowTypes)) {
                            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                                // Delete old image if exists
                                $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . "/blogs/uploads/" . $check_blog['images'];
                                if (file_exists($oldImagePath)) {
                                    unlink($oldImagePath);
                                }
                            } else {
                                return array('status' => 'error', 'st_code' => 400, 'msg' => 'File upload failed.');
                            }
                        } else {
                            return array('status' => 'error', 'st_code' => 400, 'msg' => 'Invalid file type.');
                        }
                    }

                    // Tags processing
                    $tags = explode(',', $tag_s);
                    $tag_arr = array();
                    foreach ($tags as $tag) {
                        $tag_slug = $this->slug(trim($tag));
                        array_push($tag_arr, array('tag_slug' => $tag_slug));
                    }

                    $tagslug = implode(',', array_map(function ($item) {
                        return $item['tag_slug'];
                    }, $tag_arr));

                    // SQL update
                    $sql = "UPDATE blogs SET 
                            title = '$title', 
                            description = '$description', 
                            slug = '$slug', 
                            content = '$content',
                            tags = '$tag_s', 
                            tag_slug = '$tagslug', 
                            images = '$fileName', 
                            poststatus = '$status', 
                            dateupdated = '$updated' 
                            WHERE id = '$id'";

                    $update = $this->conn->query($sql);

                    if ($update) {
                        // Redirect or return success
                        header('Location: admin/list_blog');
                        exit;
                    } else {
                        $response = array(
                            'status' => 'error',
                            'st_code' => 400,
                            'msg' => 'Update failed: ' . $this->conn->error // LOG SQL ERROR
                        );
                    }

                } else {
                    $response = array('status' => 'error', 'st_code' => 400, 'msg' => 'Invalid data!');
                }
            } else {
                $response = array('status' => 'error', 'st_code' => 400, 'msg' => 'Invalid Blog!');
            }
        } else {
            $response = array('status' => 'error', 'st_code' => 400, 'msg' => 'Blog ID is required!');
        }

        return $response;
    }
}
    public function delete_blog($id)
    {
        # Check if user is authenticated
        if ($this->checkauth()) {
            $sql = "SELECT * FROM blogs WHERE id = '$id'";
            $result = $this->conn->query($sql);
            $check_blog = $result->fetch_assoc();
            if (!empty($check_blog)) {
                # Delete blog entry from the database
                $del_sql = "DELETE FROM blogs WHERE id = '$id'";
                $del_result = $this->conn->query($del_sql);
                if ($del_result) {
                    # Build the full path for the image file
                    $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/blogs/uploads/' . $check_blog['images'];
                    # Check if the image file exists before trying to delete it
                    if (file_exists($imagePath)) {
                        # Delete the associated image
                        if (unlink($imagePath)) {
                            $response = array('status' => 'success', 'msg' => 'Blog and image deleted successfully', 'st_code' => 200);
                        } else {
                            $response = array('status' => 'error', 'st_code' => 400, 'msg' => 'Blog deleted, but failed to delete the image.');
                        }
                    } else {
                        # File does not exist
                        $response = array('status' => 'success', 'msg' => 'Blog deleted, but image file not found.', 'st_code' => 200);
                    }
                } else {
                    $response = array('status' => 'error', 'st_code' => 400, 'msg' => 'Failed to delete the blog.');
                }
            } else {
                $response = array('status' => 'error', 'st_code' => 400, 'msg' => 'Blog not found.');
            }
        } else {
            $response = array('status' => 'error', 'st_code' => 403, 'msg' => 'Unauthorized access.');
        }
        return $response;
    }
    public function tags()
    {
        $res_data = array();
        $tag_arr = array();
        $slug_arr = array();
        $sql = "SELECT * FROM blogs WHERE poststatus = 'active'";
        $query = $this->conn->query($sql);
        if ($query->num_rows > 0) {
            $result = array();
            while ($row = $query->fetch_assoc()) {
                $result[] = $row;
            }
            foreach ($result as $key => $value) {
                if (!empty($value['tags'])) {
                    $tags = explode(',', $value['tags']);
                    $slugs = explode(',', $value['tag_slug']);
                    foreach ($tags as $key => $tag) {
                        $data1 = array('tag' => trim($tag),);
                        array_push($tag_arr, $data1);
                    }
                    foreach ($slugs as $key => $slug) {
                        $data2 = array('slug' => trim($slug),);
                        array_push($slug_arr, $data2);
                    }
                }
            }
        }
        $unique_tag_Array = array_map("unserialize", array_unique(array_map("serialize", $tag_arr)));
        $tagsArray = array_values($unique_tag_Array);
        $unique_slug_Array = array_map("unserialize", array_unique(array_map("serialize", $slug_arr)));
        $slugsArray = array_values($unique_slug_Array);
        $resultArray = array();
        foreach ($tagsArray as $key => $tag) {
            $resultArray[] = array('tag' => $tag['tag'], 'slug' => $slugsArray[$key]['slug']);
        }
        return $resultArray;
    }
    public function fetch_blogs($limit, $offset, $slug)
    {
        $res_data = array();
        if (!empty($slug)) {
            $sql = "SELECT * FROM blogs  WHERE tag_slug LIKE '%$slug%' AND poststatus = 'active' ORDER BY datecreated DESC LIMIT $limit OFFSET $offset";
        } else {
            $sql = "SELECT * FROM blogs WHERE poststatus = 'active' ORDER BY datecreated DESC  LIMIT $limit OFFSET $offset";
        }
        $query = $this->conn->query($sql);
        if ($query->num_rows > 0) {
            $result = array();
            while ($row = $query->fetch_assoc()) {
                $result[] = $row;
            }
            foreach ($result as $key => $value) {
                $tags = explode(',', $value['tag_slug']);
                if (in_array($slug, $tags) || empty($slug)) {
                    $data1 = array('id' => $value['id'], 'title' => $value['title'], 'description' => $value['description'],  'slug' => $value['slug'], 'content' => $value['content'], 'category' => $value['category'], 'images' => $value['images'], 'poststatus' => $value['poststatus'], 'datecreated' => date('F j, Y', $value['datecreated'] / 1000),);
                    array_push($res_data, $data1);
                }
            }
        }
        return $res_data;
    }
    public function fetch_count()
    {
        $sql = "SELECT * FROM blogs WHERE poststatus = 'active'";
        $result = $this->conn->query($sql);
        return $result->num_rows;
    }
    public function blog_details($slug)
    {
        $result = array();
        if (empty($slug)) {
        } else {
            $query = $this->db->get_where('blogs', array('slug' => $slug));
            if ($query->num_rows() > 0) {
                $result = $query->result_array();
            }
        }
        return $result;
    }
    public function update_status($data)
    {
        if ((isset($data['status']) && !empty($data['status'])) && isset($data['id']) && !empty($data['id'])) {
            $updated = $this->unixDateTime();
            $status = $data['status'];
            $id = $data['id'];
            $sql = "UPDATE blogs SET poststatus = '$status',dateupdated = '$updated' WHERE id = '$id'";
            $update = $this->conn->query($sql);
            if ($update == true) {
                $response = array('status' => 'success', 'st_code' => 200, 'msg' => 'Status Updated Successfully!');
            }
        } else {
            $response = array('status' => 'error', 'st_code' => 400, 'msg' => 'Something went wrong!');
        }
        return $response;
    }
}
