<h2>Site News</h2>
<?
    $news = new news();
    $articles = $news->get_all_articles();
    //print_r($articles);
    foreach($articles as $article){
        echo '<h3>'.$article[title].'</h3>';
        echo '<h4>'.$article[post_date].'</h4>';
        echo '<p>'.$article[article].'</p>';
        echo '<hr>';
    }
?>