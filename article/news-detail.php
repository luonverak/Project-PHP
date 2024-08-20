<?php include('header.php');
    $post_id = $_GET['id'];
?>
<main class="news-detail">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <div class="main-news">
                        <?php get_news_detail($post_id)?>
                        <?php get_view($post_id)?>
                    </div>
                </div>
                <div class="col-4">
                    <div class="relate-news">
                        <h3 class="main-title">Related News</h3>
                        <?php get_rate_news($post_id)?>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include('footer.php'); ?>