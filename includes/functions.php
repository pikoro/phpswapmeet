<?

class functions{

	function functions(){
	   	  require('includes/config.php');
	   	  $this->config = $config;
	}

	function print_pre($array){
		echo '<pre>';
		print_r($array);
		echo '</pre>';
	}




}

?>