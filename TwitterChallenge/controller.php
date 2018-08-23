<?php
    session_start();
    require 'model.php';
	
    $model = new Model();
	
    // Login With Twitter
    if( isset($_POST['login']) ) {
        $model->twitter_connect();
    }
	// Logout
    if( isset($_GET['logout']) && $_GET['logout']==true ) {
        $model->logout();
    }
    // CallBack
    if ( isset($_REQUEST['oauth_verifier'], $_REQUEST['oauth_token']) ) {
        $model->callback();
    }
    //GetSelected User Profile
    if(isset($_GET['followers']) ) {
        $id = $_GET['usr_id'];
        $model->getFollowerInfo($id);
    }
    //GetFollower List
    if( isset($_GET['fetchFollowers']) ) {
        $screen_name = $_GET['fetchFollowers'];
        $model->getFollowers($screen_name);
    }
	//Fetch User Data
    if( isset($_GET['userdata']) && $_GET['userdata']==true ) {
        $model->getUserData();
    }
    
    // Download Public User Followers
    if( isset($_POST['search_public_user']) ) {
        $key = $_POST['key'];
		$format=$_POST['format'];
		switch ($format) {
            case "drive":
                $_SESSION['user-tweets'] = $model->upload_follower_name($key);
				header('location:lib\google-drive-api/index.php');
                break;
            case "pdf":    
				$model->downloadPublicUserFollowers($key);
				header('location: home.php');
                break;
            case "xml":
                $model->Followers_XML($key);
                break;    
        }
		
    
    }
    
    // autosearch for follower name 
    if( isset($_GET['autosearch']) && $_GET['autosearch']==true ) {
        $model->searchfun();
    }
    
?>