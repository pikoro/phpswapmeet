<?
// Just a place to dump a few misc functions that don't really belong anywhere else

class functions {

    function functions() {
        require('includes/config.php');
        $this->config = $config;
    }

    function print_pre($array) {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }

}
