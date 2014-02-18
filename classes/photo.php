<?php

class photos{

	function photos(){
        require('includes/config.php');
    	include_once('classes/database.php');
    	$this->db = new database();
    	$this->config = $config;
		$this->logger = new logger();
	}

	function add_images(){
		for ($i=0; $i<count($_FILES['file']); $i++){
			$filename = $_FILES['file']['name'][$i];
			if($filename!=''){
				$filename='file'.$i;
				//upload original file
				move_uploaded_file($_FILES['file']['tmp_name'][$i],$filename);

				//count layers and flatten if necessary
				$scenes = `identify -verbose -format "%n" $filename`;
				$scenes = explode("\n",$scenes);
				if($scenes[0]=='') $scenes[0]=0;
				if($scenes[0]>1) `convert -flatten $filename $filename`;

				//make filename for new files
				$new_img = date('U').'-'.mt_rand(1, 10000).'.jpg';
				$op_img = '2-'.$new_img;

				//make files and move to appropriate location
				`convert $filename -quality 50 -resize 600x600 $new_img`;
				`jpegtran -copy none $new_img > $op_img`;
				copy($op_img,'../housing_pics/' .$new_img);
				`convert -quality 40 -resize 100x100 $op_img $new_img`;
				copy($new_img,'../housing_pics/thumb/' .$new_img);

				//burn the evidence
				unlink($new_img);
				unlink($op_img);
				unlink($filename);

				//db it
				$sql='insert into images (aid, img) values ("' . $_POST['id'] . '","' . $new_img . '")';
				mysql_query($sql);
			}
		}
	}

}

?>
