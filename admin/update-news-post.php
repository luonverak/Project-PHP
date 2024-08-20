<?php
    include('sidebar.php');
    include('function.php');
    $news_id = $_GET['id'];
    $sql = "SELECT * FROM `news` WHERE id='$news_id'";
    $rs  = $connection->query($sql);
    $row = mysqli_fetch_assoc($rs);
    if($row['type'] == 'National'){
        $select_national = 'selected';
    }else{
        $select_internetional = 'selected';
    }
    if($row['category']=='Sport'){
        $select_sport = 'selected';
    }else if($row['category']=='Social'){
        $select_social = 'selected';
    }else{
        $select_entertainment = 'selected';
    }

?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Add News</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" class="form-control" name="news_title" value="<?php echo $row['title']?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-select" name="news_type">
                                            <option value="National" <?php echo $select_national ?>>National</option>
                                            <option value="Internetional" <?php echo $select_internetional; ?>>Internetional</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-select" name="news_category">
                                            <option value="Sport" <?php echo $select_sport; ?>>SPORT</option>
                                            <option value="Social"<?php echo $select_social; ?>>SOCIAL</option>
                                            <option value="Entertainment" <?php echo $select_entertainment; ?>>ENTERTAINMENT</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Thumbnail <p>(Thumbnail size 350x200)</p></label>
                                        <input type="file" class="form-control" name="news_thumbnail">
                                    </div>
                                    <img src="./assets/image/<?php echo $row['thumbnail'];?>" width="120" alt="">
                                    <!-- Hidden Thumbnail -->
                                    <input type="hidden" name="old_thumbnail" value="<?php echo $row['thumbnail'];?>">
                                    <div class="form-group">
                                        <label>Banner<p>(Banner size 730x415)</p></label>
                                        <input type="file" class="form-control" name="news_banner">
                                    </div>
                                    <img src="./assets/image/<?php echo $row['banner'];?>" width="120" alt="">
                                    <!-- Hidden Banner -->
                                    <input type="hidden" name="old_banner" value="<?php echo $row['banner'];?>">
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="news_description"><?php echo $row['description']?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button name="accept_update_news" type="submit" class="btn btn-success">Update</button>
                                        <button type="submit" class="btn btn-danger">Cancel</button>
                                    </div>
                                </form>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>