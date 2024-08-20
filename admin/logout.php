<?php
    include('sidebar.php');
    include('function.php');
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Are you sur for logout?</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">

                                    <div class="form-group">
                                        <button name="accept_logout" type="submit" class="btn btn-primary">Yes, Logout</button>
                                        <a href="index.php" type="submit" class="btn btn-danger">Cancel</a>
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