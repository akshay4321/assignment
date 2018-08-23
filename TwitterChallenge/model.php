<?php
     require "lib/twitteroauth/autoload.php";     
	 require "lib/tcpdf/tcpdf.php";

    
    use Abraham\TwitterOAuth\TwitterOAuth;
	
    include_once 'config.php';
    
    class Model {
        /* === Twitter Connection code  ===  */
        public function twitter_connect() {
            if (!isset($_SESSION['access_token'])) {
                $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
                $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
                $_SESSION['oauth_token'] = $request_token['oauth_token'];
                $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
                $url = $connection->url('oauth/authorize', array('oauth_token' => $_SESSION['oauth_token']));
                header('location:' . $url);
            } 
            else {
                header('Location: home.php');
            }
        }
		
        /* === Callback Function code  ===  */ 
        public function callback(){
            $request_token = [];
            $request_token['oauth_token'] = $_REQUEST['oauth_token'];
            $request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];
            $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $request_token['oauth_token'], $request_token['oauth_token_secret']);
            $access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
            $_SESSION['access_token'] = $access_token;
            header('Location: ./home.php');
        }
		
        /* === get connection from access_token ,,, return The Connection Object === */
        public function getConnect() {
            $access_token = $_SESSION['access_token'];
            $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
            return $connection;
        }
		
        /* === Fetch Current User Object ,,, return The user object of the currently login === */
        public function getUser($connection) {
            $user = $connection->get("account/verify_credentials");
            return $user;
        }
		
		/* === logout === */
        public function logout() {
            session_unset();
            session_destroy();
            header("location:http://twitter.alampata.online/");
            exit();
        }
		
        /* === Fetch most recent 10 tweets of the users === */
        public function getUserTweets($screen_name) {
            $connection = $this->getConnect();
            $tweets = $connection->get("statuses/user_timeline",["count" => 10, "exclude_replies" => true,"screen_name" => $screen_name]);
            foreach( $tweets as $val ) {
                $temp[] = array(
                    'text' => $val->text
                );
            }
            if( count($tweets) == 0 )
                $temp[] = array(
                    'text' => 'No Tweets Found'
                );
            return $temp;
        }
		
        /* === Fetch all followers of the users === */
        public function getFollowers($screen_name) {
            $connection = $this->getConnect();
            $next = -1;
            $max = 0;
            while( $next != 0 ) {
                $friends = $connection->get("followers/list", ["screen_name"=>$screen_name,"next_cursor"=>$next]);
                $followers[] = $friends;
                $next = $friends->next_cursor;
                if($max==0)
                    break;
                $max++;
            }
            foreach( $followers as $val ) {
                foreach( $val->users as $usr ) {
                    $folldetail[] = array(
                        'name' => $usr->name,
                        'screen_name' => $usr->screen_name,
                        'propic' => $usr->profile_image_url_https
                    );
                }
            }
            $json = array(
                'followers' => $folldetail
            );
            echo json_encode($json);
        }
		
        /* === Fetch followers data === */
        public function getFollowerInfo($id) {
            $connection = $this->getConnect();
            $user = $connection->get("users/show",['screen_name'=>$id]);
            $name = $user->name;
            $propic = $user->profile_image_url_https;
            $screen_name = $user->screen_name;
            $tweets = $this->getUserTweets($screen_name);
            $res = array(
                'name' => $name,
                'propic' => $propic,
                'tweets' => $tweets
            );
            $json = json_encode($res);
            echo $json;
        }
		
        /* === Fetch login user data === */
        public function getUserData() {
            $connection = $this->getConnect();
            $user = $this->getUser($connection);
            $tweets = $this->getUserTweets($user->screen_name);
            $screen_name = $user->screen_name;
            $res = array(
                'id' => $user->id,
                'name' => $user->name,
                'screen_name' => $user->screen_name,
                'propic' => $user->profile_image_url_https,
                'tweets' => $tweets,
            );
            $json = json_encode($res);
            echo $json;
        }
        
        /* === Fetch user follower information === */ 
		public function follower_AllInfo($screen_name) {
            $connection = $this->getConnect();
            $next = -1;
            $max = 0;
            while( $next != 0 ) {
                $friends = $connection->get("followers/list", ["count" => 200,"screen_name"=>$screen_name,"next_cursor"=>$next]);
                $followers[] = $friends;
                $next = $friends->next_cursor;
                if($max==0)
                    break;
                $max++;
            }
        	$data=[];
			foreach( $followers as $val ) {
                foreach( $val->users as $usr ) {
                    $name = $usr->name;
					$data[]=$name;
                }
            }
        	return $data;
           
        }

        /* === Fetch public user Follower and download in xml === */
        public function Followers_XML($key) {
            $name="FollowerList";
            $connection = $this->getConnect();
            $user = $this->getUser($connection);
            $followers = $this->follower_AllInfo($key);
            header("Content-type: text/xml");
            header("Content-Disposition: attachment; filename=".$key.".xml");
            header("Pragma: no-cache");
            header("Expires: 0");
            foreach($followers as $data) {
                echo "<". $name .">". $data ."</". $name .">";
                
            }
        }
        
		 /* === Fetch public user followers and download in pdf === */
        public function downloadPublicUserFollowers($screen_name) {
			
            $tweets = $this->getFollowersuser($screen_name);			
            $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
            $obj_pdf->SetCreator(PDF_CREATOR);  
			$obj_pdf->SetTitle("Follower List");  
            $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
			$obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
			$obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
			$obj_pdf->SetDefaultMonospacedFont('helvetica');  
			$obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
			$obj_pdf->SetMargins(PDF_MARGIN_LEFT, '5', PDF_MARGIN_RIGHT);  
			$obj_pdf->setPrintHeader(false);  
			$obj_pdf->setPrintFooter(false);  
			$obj_pdf->SetAutoPageBreak(TRUE, 10);  
			$obj_pdf->SetFont('helvetica', '', 12);  
			$obj_pdf->AddPage();  
			$obj_pdf->writeHTML($tweets);  
            $obj_pdf->Output($screen_name.'.pdf', 'D');  //'D' is for Download PDF
             

			  	
        }
        
        /* === get public user follower information in pdf === */ 
		public function getFollowersuser($screen_name) {
            $connection = $this->getConnect();
            $next = -1;
            $max = 0;
            while( $next != 0 ) {
                $friends = $connection->get("followers/list", ["count" => 200,"screen_name"=>$screen_name,"next_cursor"=>$next]);
                $followers[] = $friends;
                $next = $friends->next_cursor;
                if($max==0)
                    break;
                $max++;
            }
         
			$htmltext = '<center><h1> followers list of '.$screen_name.' </h1></center><hr><br> ';
			foreach( $followers as $val ) {
                foreach( $val->users as $user ) {
                    $name = $user->name;
					$htmltext .= '<h2>'.$name.'</h2><br>';
                }
            }
            
			return $htmltext;
           
        }
        
		/* === upload public user follower in google spreadsheet === */
		public function upload_follower_name($key) {
            $connection = $this->getConnect();
            $user = $this->getUser($connection);
            $tweets = $this->follower_AllInfo($key);
            return $tweets;
        }
        
        /* === get public user autosearch === */ 
        public function searchfun() {
            $connection = $this->getConnect();
            if (isset($_GET['term'])) {
                if (!isset($_SESSION['data'])) {
                   
                    $connection = $this->getConnect();
                    $myprofile_value = $_SESSION['my_profile'];
                    $my_scrren_name = $myprofile_value['screen_name'];
                    $followerslist = $connection->get("followers/ids", array('screen_name' => $my_scrren_name, 'count' => 5000));
                    $cnt = 0;
                    $var_assign = 0;
                    $loop_cnt = '';
                    foreach ($followerslist->ids as $followr_id) {
                        if ($cnt % 100 == 0) {
                            $var_assign = $var_assign + 1;
                            $loop_cnt = $var_assign;
                            ${"var$var_assign"} = '';
                        }
                        ${"var$var_assign"} = ${"var$var_assign"} . "," . $followr_id;    //Concatenate followers id in comma seperated format
                        $cnt = $cnt + 1;
                    }
                    $response_array = array();
                    $new = 1;
                    for ($i = 1; $i <= $loop_cnt; $i++) {
                        $id_lookup = $connection->get("users/lookup", array('user_id' => ${"var$i"}));
                        foreach ($id_lookup as $key => $value) {
                            $response_array[$new]['id'] = $value->id;
                            $response_array[$new]['name'] = $value->screen_name;
                            $new = $new + 1;
                        }
                    }
                    $_SESSION['data'] = $response_array;
                }
                $keyword = $_GET['term'];
                $my_search = array();
                $my_search = $_SESSION['data'];
                $public_user = array();
                for ($i = 1; $i <= 3; $i++) {
                    $followerslist = $connection->get("users/search", array('q' => $keyword, 'count' => 20, 'page' => $i));
                    foreach ($followerslist as $key => $value) {
                        $public_user[] = $value->screen_name;
                    }
                }
                $follower_session = $my_search;
                $followername_array = array();
                foreach ($follower_session as $key => $follw_value) {
                    $followername_array[$key] = $follw_value['name'];
                }
                $input = preg_quote($keyword, '~');
                $result1 = preg_grep('~' . $input . '~', $followername_array);
                $final_result = array_merge($result1, $public_user);
                if (empty($final_result)) {
                    $final_result = array("No user found");
                }
                echo json_encode($final_result);
            }
        }


        
    }
?>