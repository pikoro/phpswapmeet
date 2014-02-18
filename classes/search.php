<?

	class search{

		function search(){
			require('includes/config.php');
			$this->config = $config;
			$this->db = new database();
			$this->logger = new logger();
		}

		function do_search($keyword){
            $sql = 'select * from '.$this->config[database][prefix].'items where `name` like "%'.mysql_real_escape_string($keyword).'%" or `description` like "%'.mysql_real_escape_string($keyword).'%" or `notes` like "%'.mysql_real_escape_string($keyword).'%"';
			$results = $this->db->get_array($sql);
			if(count($results) > 0){
                $this->logger->logit("[search] User $_SESSION[id] searched for $keyword and received ".count($results)." results");
				return $results;
			} else {
				$this->logger->logit("[search] User $_SESSION[id] searched for $keyword and received 0 results");
			}
		}
        
        function add_notification($email,$search_term){
            $sql = 'insert into fs_notify (`email`,`search_term`) values ("'.mysql_real_escape_string($email).'","'.mysql_real_escape_string($search_term).'")';
            $this->db->query($sql);
            
        }



	}

?>