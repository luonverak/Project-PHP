<?php
    include('sidebar.php');
    include('function.php');
    $id = $_GET['id'];
    $sql= "SELECT * FROM `logo` WHERE id='$id'";
    $rs = $connection->query($sql);
    $row= mysqli_fetch_assoc($rs);
    $thumbnail = $row['thumbnail'];

        $header = '';
        $footer = '';
        if($row['status'] == 'Header'){
            $header = 'selected';
        }else{
            $footer = 'selected';
        }
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Add Page Logo</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <label>Show On</label>
                                        <select name="showOn" class="form-select">
                                            <option value="Header" <?php echo $header ?>>Header</option>
                                            <option value="Footer" <?php echo $footer ?>>Footer</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>File</label>
                                        <input name="thumbnial" type="file" class="form-control">
                                        <img src="../admin/assets/image/<?php echo $thumbnail?>" alt="">
                                        <input type="hidden" value="<?php echo $thumbnail?>" name="old_logo">
                                    </div>


                                    <div class="form-group">
                                        <button name="accept_update_logo" type="submit" class="btn btn-success">Update</button>
                                        <a href="./index.php" type="submit" class="btn btn-danger">Cancel</a>
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