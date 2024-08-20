<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php
    $connection = new mysqli('localhost','root','','web_cms_2');

    function move_image($image){
        $thumbnail = date('dmyhis').'-'. $_FILES[$image]['name'];
        $path = '../admin/assets/image/'.$thumbnail;
        move_uploaded_file($_FILES[$image]['tmp_name'],$path);
        return $thumbnail;
    }
    function register_acc(){
        global $connection;
        if(isset($_POST['btn_register'])){
            $username = $_POST['username'];
            $email    = $_POST['email'];
            $password = $_POST['password'];
            $profile  = move_image('profile');
            // get username for compare
            $getusername = "SELECT * FROM `user` WHERE 1";
            $r = $connection->query($getusername);
            while($row=mysqli_fetch_assoc($r)){
                if($username==$row['username']){
                    $username=null;
                }
            }
            if(!empty($username) && !empty($email) && !empty($password) && !empty($profile)){
                $password = md5($password);
                $sql = "INSERT INTO `user`(`username`, `email`, `password`, `profile`)
                        VALUES ('$username','$email','$password','$profile')";
                $rs  = $connection->query($sql);
                if($rs){
                    echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "SUCCESS!",
                                text: "Data has been insert to system!",
                                icon: "success",
                                button: "Aww yiss!",
                              });
                        })
                    </script>
                    ';
                }
            }else{
                echo '
                <script>
                    $(document).ready(function(){
                        swal({
                            title: "ERROR!",
                            text: "Please complete all field!",
                            icon: "error",
                            button: "Yes !",
                          });
                    })
                </script>
                ';
            }
        }
    }
    register_acc();


    session_start();
    function login_acc(){
        global $connection;
        if(isset($_POST['btn_login'])){
            $name_email = $_POST['name_email'];
            $password   = $_POST['password'];
            $password   = md5($password);
            if(!empty($name_email) && !empty($password)){
                $sql = "SELECT `id` FROM `user` WHERE (`username`='$name_email' OR `email`='$name_email') AND `password`='$password'";
                $rs  = $connection->query($sql);
                $row = mysqli_fetch_assoc($rs);
                if(!empty($row)){
                    $_SESSION['user'] = $row['id'];
                    header('location: index.php');
                }else{
                    echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "ERROR!",
                                text: "Try it again !",
                                icon: "error",
                                button: "Yes !",
                            });
                        })
                    </script>
                    ';
                }
            }
        }
    }
    login_acc();
    function logout_account(){
        global  $connection;
        if(isset($_POST['accept_logout'])){
            unset($_SESSION['user']);
            header('location: login.php');
        }
    }
    logout_account();


    function add_post_logo(){
        global $connection;
        if(isset($_POST['accept_save_logo'])){
            $show_on   = $_POST['showOn'];
            $thumbnail = move_image('thumbnial');
            if(!empty($show_on) && !empty($thumbnail)){
                $sql="INSERT INTO `logo`(`status`, `thumbnail`) VALUES ('$show_on','$thumbnail')";
                $rs = $connection->query($sql);
                if($rs){
                    echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "SUCCESS!",
                                text: "Data has been insert to system!",
                                icon: "success",
                                button: "Aww yiss!",
                              });
                        })
                    </script>
                    ';
                }
            }
        }
    }
    add_post_logo();
    function get_logo_post(){
        global $connection;
        $sql = "SELECT * FROM `logo` ORDER BY id DESC LIMIT 4";
        $rs  = $connection->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            $id        = $row['id'];
            $status    = $row['status'];
            $thumbnail = $row['thumbnail'];
            echo '
            <tr>
                <td>'.$id.'</td>
                <td>'.$status.'</td>
                <td><img src="./assets/image/'.$thumbnail.'"/></td>
                <td width="150px">
                    <a href="./update-logo-post.php?id='.$id.'"class="btn btn-primary">Update</a>
                    <button type="button" remove-id="'.$id.'" class="btn btn-danger btn-remove" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Remove
                    </button>
                </td>
            </tr>
            ';
        }
    }
    function delete_logo_post(){
        global $connection;
        if(isset($_POST['accept_delete_logo'])){
            $id = $_POST['remove_id'];
            $sql = "DELETE FROM `logo` WHERE id='$id'";
            $rs  = $connection->query($sql);
            if($rs){
                echo '
                <script>
                    $(document).ready(function(){
                        swal({
                            title: "DELETED !",
                            text: "Data has been delete from system!",
                            icon: "success",
                            button: "Aww yiss!",
                          });
                    })
                </script>
                ';
            }
        }
    }
    delete_logo_post();
    function update_logo_post(){
        global $connection;
        if(isset($_POST['accept_update_logo'])){
            $show_on   = $_POST['showOn'];
            $thumbnail = $_FILES['thumbnial']['name'];
            $id        = $_GET['id'];
            if(empty($thumbnail)){
                $thumbnail = $_POST['old_logo'];
            }else{
                $thumbnail = move_image('thumbnial');
            }
            if(!empty($show_on) && !empty($thumbnail)){
                $sql = "UPDATE `logo` SET `status`='$show_on',`thumbnail`='$thumbnail' WHERE id='$id'";
                $rs  = $connection->query($sql);
                if($rs){
                    echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "UPDATED !",
                                text: "Data has been update to system!",
                                icon: "success",
                                button: "Aww yiss!",
                              });
                        })
                    </script>
                    ';
                }
            }
        }
    }
    update_logo_post();
    function add_news_post(){
        global $connection;
        if(isset($_POST['accept_save_news'])){
            $title       = $_POST['news_title'];
            $type        = $_POST['news_type'];
            $category    = $_POST['news_category'];
            $thumbnail   = move_image('news_thumbnail');
            $banner      = move_image('news_banner');
            $description = $_POST['news_description'];
            $author      = $_SESSION['user'];
            if(!empty($title) && !empty($type) && !empty($category) && !empty($thumbnail) && !empty($banner) && !empty($description) && !empty($author)){
                $sql = "INSERT INTO `news`(`author_id`, `type`, `category`, `banner`, `thumbnail`, `title`, `description`)
                        VALUES ('$author','$type','$category','$banner','$thumbnail','$title','$description')";
                $rs = $connection->query($sql);
                if($rs){
                    echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "SUCCESS!",
                                text: "Data has been insert to system!",
                                icon: "success",
                                button: "Aww yiss!",
                              });
                        })
                    </script>
                    ';
                }
            }else{
                    echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "ERROR!",
                                text: "Try again!",
                                icon: "error",
                                button: "Aww yiss!",
                              });
                        })
                    </script>
                    ';

            }
        }
    }
    add_news_post();
    function get_news_post(){
        global $connection;
        $sql = "SELECT t_user.username,t_news.* FROM user as t_user INNER JOIN news as t_news ON t_user.id = t_news.author_id ORDER BY id DESC";
        $rs  = $connection->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            $id        = $row['id'];
            $title     = $row['title'];
            $type      = $row['type'];
            $category  = $row['category'];
            $thumbnail = $row['thumbnail'];
            $view      = $row['view'];
            $post_by   = $row['username'];
            $date      = $row['create_at'];
            echo '
            <tr>
                <td>'.$id.'</td>
                <td>'.$title.'</td>
                <td>'.$type.'</td>
                <td>'.$category.'</td>
                <td><img src="./assets/image/'.$thumbnail.'" width="120"/></td>
                <td>'.$view.'</td>
                <td>'.$post_by.'</td>
                <td>'.$date.'</td>
                <td width="150px">
                    <a href="./update-news-post.php?id='.$id.'"class="btn btn-primary">Update</a>
                    <button type="button" remove-id="'.$id.'" class="btn btn-danger btn-remove" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Remove
                    </button>
                </td>
            </tr>
            ';
        }
    }
    function delete_news_post(){
        global $connection;
        if(isset($_POST['accept_delete_news'])){
            $delete_id = $_POST['remove_id'];
            $sql = "DELETE FROM `news` WHERE id='$delete_id'";
            $rs  = $connection->query($sql);
            if($rs){
                echo '
                <script>
                    $(document).ready(function(){
                        swal({
                            title: "DELETED !",
                            text: "Data has been insert to system!",
                            icon: "success",
                            button: "Aww yiss!",
                          });
                    })
                </script>
                ';
            }
        }
    }
    delete_news_post();
    function update_news_post(){
        global $connection;
        if(isset($_POST['accept_update_news'])){
            $title       = $_POST['news_title'];
            $type        = $_POST['news_type'];
            $category    = $_POST['news_category'];
            $thumbnail   = $_FILES['news_thumbnail']['name'];
            $banner      = $_FILES['news_banner']['name'];
            $description = $_POST['news_description'];
            $author      = $_SESSION['user'];
            $id          = $_GET['id'];
            if(empty($thumbnail)){
                $thumbnail = $_POST['old_thumbnail'];
            }else{
                $thumbnail = move_image('news_thumbnail');
            }
            if(empty($banner)){
                $banner = $_POST['old_banner'];
            }else{
                $banner = move_image('news_banner');
            }
            if(!empty($title) && !empty($type) && !empty($category) && !empty($thumbnail) && !empty($banner) && !empty($description) && !empty($author)){
                $sql = "UPDATE `news`
                        SET `author_id`='$author',`type`='$type',`category`='$category',`banner`='$banner',`thumbnail`='$thumbnail',`title`='$title',`description`='$description'
                        WHERE id='$id'";
                $rs  = $connection->query($sql);
                if($rs){
                    echo '
                    <script>
                        $(document).ready(function(){
                            swal({
                                title: "UPDATED !",
                                text: "Data has been update to system!",
                                icon: "success",
                                button: "Aww yiss!",
                              });
                        })
                    </script>
                    ';
                }
            }
        }
    }
    update_news_post();
?>