<?php
    include('sidebar.php');
    include('function.php');

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
                                        <input type="text" class="form-control" name="news_title">
                                    </div>
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-select" name="news_type">
                                            <option value="National">National</option>
                                            <option value="Internetional">Internetional</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-select" name="news_category">
                                            <option value="Sport">SPORT</option>
                                            <option value="Social">SOCIAL</option>
                                            <option value="Entertainment">ENTERTAINMENT</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Thumbnail <p>(Thumbnail size 350x200)</p></label>
                                        <input type="file" class="form-control" name="news_thumbnail">
                                    </div>
                                    <div class="form-group">
                                        <label>Banner<p>(Banner size 730x415)</p></label>
                                        <input type="file" class="form-control" name="news_banner">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="news_description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button name="accept_save_news" type="submit" class="btn btn-primary">Save</button>
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