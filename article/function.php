<!-- @import jquery & sweet alert  -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
    $connection = new mysqli('localhost','root','','web_cms_2');
    function get_logo($status){
        global $connection;
        $sql = "SELECT `thumbnail` FROM `logo` WHERE `status`='$status' ORDER BY id DESC LIMIT 1";
        $rs  = $connection->query($sql);
        $row = mysqli_fetch_assoc($rs);
        echo $row['thumbnail'];
    }
    function get_trending_news(){
        global $connection;
        $sql = "SELECT * FROM `news` ORDER BY id DESC LIMIT 3";
        $rs  = $connection->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            echo '
                <i class="fas fa-angle-double-right"></i>
                <a href="./news-detail.php?id='.$row['id'].'">'.$row['title'].'</a> &ensp;
            ';
        }
    }
    function get_news_detail($post_id){
        global $connection;
        $sql = "SELECT * FROM `news` WHERE id='$post_id' ORDER BY id DESC LIMIT 3";
        $rs  = $connection->query($sql);
        $row = mysqli_fetch_assoc($rs);
        $date = $row['create_at'];
        $date = date('d/M/Y');
        $image = $row['banner'];
        echo '
        <div class="thumbnail">
            <img src="../admin/assets/image/'.$image.'">
            </div>
            <div class="detail">
                <h3 class="title">'.$row['title'].'</h3>
                <div class="date">'.$date.'</div>
                <div class="description">'.$row['description'].'</div>
        </div>
            ';
    }
    function get_news_type($id){
        global $connection;
        $sql = "SELECT * FROM `news` WHERE id='$id'";
        $rs  = $connection->query($sql);
        $row = mysqli_fetch_assoc($rs);
        return $row['type'];
    }
    function get_rate_news($news_id){
        global $connection;
        $news_content = get_news_type($news_id);
        $sql = "SELECT * FROM `news` WHERE `type` = '$news_content' AND id NOT IN ($news_id) ORDER BY id DESC LIMIT 3";
        $rs  = $connection->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            $date = $row['create_at'];
            $date = date('d/M/Y');
            echo '
            <figure>
                <a href="./news-detail.php?id='.$row['id'].'">
                    <div class="thumbnail">
                        <img src="../admin/assets/image/'.$row['thumbnail'].'" alt="">
                    </div>
                    <div class="detail">
                        <h3 class="title">'.$row['title'].'</h3>
                        <div class="date">'.$date.'</div>
                        <div class="description">'.$row['description'].'</div>
                    </div>
                </a>
            </figure>
            ';
        }
    }
    function get_view($id_view){
        global $connection;
        $sql = "UPDATE `news` SET `view`=view+1 WHERE id='$id_view'";
        $rs  = $connection->query($sql);
    }
    function get_min_news($type){
        global $connection;
        if($type == 'Trending'){
            $sql = "SELECT * FROM `news` ORDER BY view DESC LIMIT 1";
            $rs  = $connection->query($sql);
            $row = mysqli_fetch_assoc($rs);
            echo '
            <figure>
                <a href="news-detail.php?id='.$row['id'].'">
                    <div class="thumbnail">
                        <img src="../admin/assets/image/'.$row['banner'].'" alt="">
                        <div class="title">'.$row['title'].'</div>
                    </div>
                </a>
            </figure>
            ';
        }else{
            $sql = "SELECT * FROM `news` WHERE `id` !=(SELECT id FROM `news` ORDER BY view DESC LIMIT 1) ORDER BY `id` DESC LIMIT 2";
            $rs  = $connection->query($sql);
            while($row = mysqli_fetch_assoc($rs)){
                echo '
                    <div class="col-12">
                        <figure>
                            <a href="./news-detail.php?id='.$row['id'].'">
                                <div class="thumbnail">
                                    <img src="../admin/assets/image/'.$row['thumbnail'].'" alt="">
                                    <div class="title">'.$row['title'].'</div>
                                </div>
                            </a>
                        </figure>
                    </div>
                    ';
            }
        }
    }
    function get_news($type){
        global $connection;
        $sql = "SELECT * FROM `news` WHERE category='$type' ORDER BY id DESC LIMIT 3";
        $rs  = $connection->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            echo '
                <div class="col-4">
                    <figure>
                        <a href="./news-detail.php?id='.$row['id'].'">
                            <div class="thumbnail">
                                <img src="../admin/assets/image/'.$row['thumbnail'].'" alt="">
                                <div class="title">'.$row['title'].'</div>
                            </div>
                        </a>
                    </figure>
                </div>
                ';
        }
    }
    function list_news_contents($category,$news_type,$page,$limit){
        global $connection;
        $start = ($page-1)*$limit;
        $sql = "SELECT * FROM `news` WHERE (`category`='$category' AND `type`='$news_type') ORDER BY id LIMIT $start,$limit";
        $rs  = $connection->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            $date = $row['create_at'];
            $date = date('d/M/Y');
            echo '
                <div class="col-4">
                <figure>
                    <a href="./news-detail.php?id='.$row['id'].'">
                        <div class="thumbnail">
                            <img src="../admin/assets/image/'.$row['thumbnail'].'" alt="">
                        </div>
                        <div class="detail">
                            <h3 class="title">'.$row['title'].'</h3>
                            <div class="date">'.$date.'</div>
                            <div class="description">'.$row['description'].'</div>
                        </div>
                    </a>
                </figure>
                </div>
                ';
        }
    }
    function pageination($category,$new_type,$limit){
        global $connection;
        $sql = "SELECT COUNT(id) as total_post FROM news WHERE `category`='$category' AND `type`='$new_type'";
        $rs  = $connection->query($sql);
        $row = mysqli_fetch_assoc($rs);
        $total_post = $row['total_post'];
        $pageination = ceil($total_post/$limit);
        for($i=1; $i<=$pageination; $i++){
            echo '<li>
                    <a href="?page='.$i.'">'.$i.'</a>
                </li>';
        }
    }
    function search_news($query){
        global $connection;
        $sql = "SELECT * FROM  news WHERE title LIKE '%$query%'";
        $rs  = $connection->query($sql);
        while($row=mysqli_fetch_assoc($rs)){
            $date = $row['create_at'];
            $date = date('d/M/Y');
            echo '
                <div class="col-4">
                    <figure>
                        <a href="./news-detail.php?id='.$row['id'].'">
                            <div class="thumbnail">
                                <img src="../admin/assets/image/'.$row['thumbnail'].'" alt="">
                            </div>
                            <div class="detail">
                                <h3 class="title">'.$row['title'].'</h3>
                                <div class="date">'.$date.'</div>
                                <div class="description">'.$row['description'].'</div>
                            </div>
                        </a>
                    </figure>
                </div>
                        ';
        }
    }
?>