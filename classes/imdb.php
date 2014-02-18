<?

class imdb {

    function imdb() {
        $this->url = 'http://www.imdb.com/title';
    }

    function get_info($number) {
        $imdb_content = $this->get_page_content($this->url . '/' . $number);
        $array = $parse_product_name($imdb_content);
        $array[url] = $this->url . '/' . $number;
        $content = $build_content($array);
        return $content;
    }

    function get_page_content($url) {
        $imdb_content = get_data($url);
        return $imdb_content;
    }

    function parse_product_name($imdb_content) {
        $array[name] = get_match('/<title>(.*)<\/title>/isU', $imdb_content);
        $array[director] = strip_tags(get_match('/<h5[^>]*>Director:<\/h5>(.*)<\/div>/isU', $imdb_content));
        $array[plot] = get_match('/<h5[^>]*>Plot:<\/h5>(.*)<\/div>/isU', $imdb_content);
        $array[release_date] = get_match('/<h5[^>]*>Release Date:<\/h5>(.*)<\/div>/isU', $imdb_content);
        $array[mpaa] = get_match('/<a href="\/mpaa">MPAA<\/a>:<\/h5>(.*)<\/div>/isU', $imdb_content);
        $array[run_time] = get_match('/Runtime:<\/h5>(.*)<\/div>/isU', $imdb_content);
        return $array;
    }

    function build_content($array) {
        $content.= '<h2>Film</h2><p>' . $array[name] . '</p>';
        $content.= '<h2>Director</h2><p>' . $array[director] . '</p>';
        $content.= '<h2>Plot</h2><p>' . substr($array[plot], 0, strpos($array[plot], '<a')) . '</p>';
        $content.= '<h2>Release Date</h2><p>' . substr($array[release_date], 0, strpos($array[release_date], '<a')) . '</p>';
        $content.= '<h2>MPAA</h2><p>' . $array[mpaa] . '</p>';
        $content.= '<h2>Run Time</h2><p>' . $array[run_time] . '</p>';
        $content.= '<h2>Full Details</h2><p><a href="' . $this->url . '" rel="nofollow">' . $this->$url . '</a></p>';
    }

    function get_match($regex, $content) {
        preg_match($regex, $content, $matches);
        return $matches[1];
    }

    function get_data($url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

}

//url
//get the page content
//parse for product name
//build content
//gets the match content
//gets the data from a URL
