<!DOCTYPE html>
<html dir="ltr" lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ==== Document Title ==== -->
    <title>Twitter Challenge</title>
    
    <!-- ==== Document Meta ==== -->
    <meta name="author" content="ThemeLooks">
    <meta name="description" content="Multipurpose Social Network HTML5 Template">
    <meta name="keywords" content="social media, social network, forum, shop, bootstrap, html5, css3, template, responsive, retina ready">
<!--<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/themes/base/minified/jquery-ui.min.css" type="text/css"/>-->
    <!-- ==== Favicon ==== -->
    <link rel="icon" href="images/twitter.png" type="image/png">

    <!-- ==== Google Font ==== -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:400,500,600,700%7CRoboto:300,400,400i,500,700">
	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

    <!-- ==== Plugins Bundle ==== -->
    <link rel="stylesheet" href="css/plugins.min.css">
    
    <!-- ==== Main Stylesheet ==== -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- ==== Responsive Stylesheet ==== -->
    <link rel="stylesheet" href="css/responsive-style.css"/>
	
	<!-- ==== Own Stylesheet ==== -->
	<link rel="stylesheet" href="css/default.css"/>
    <link rel="stylesheet" href="css/search.css" type="text/css" />

	<!-- ==== slider js file ==== -->
	<script src="js/jquery-3.2.1.js"></script>
    <script src="js/jquery.bxslider.js"></script>
	
	<style>
	
	</style>
</head>
<body>

    

    <!-- Wrapper Start -->
    <div class="wrapper">
        <!-- Header Section Start -->
        <header class="header--section style--2">
            <!-- Header Topbar Start -->
            <div class="header--topbar">
                <div class="container">
                    <!-- Logo Start -->
                    <div class="header--topbar-logo float--left">
                        <a href="index.html"><img src="images/twitimg138.jpg" alt=""></a>
                    </div>
                    <!-- Logo End -->

                    <!-- Header Topbar Links Start -->
                    <ul class="header--topbar-links nav ff--primary float--right">
                        
                        
                        <li>
                            <a class="dropdown-toggle" data-toggle="dropdown"> <b id="loginname"></b> <img id="loginpic" src="" style="border-radius: 50%" /> </a>
                        </li>
                    </ul>
                    <!-- Header Topbar Links End -->
                </div>
            </div>
            <!-- Header Topbar End -->

            <!-- Header Navbar Start -->
            <div class="header--navbar navbar bg-dark" data-trigger="sticky" style="background-color: lightskyblue;
              box-shadow: 0px 10px 5px grey;">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle style--2 collapsed" data-toggle="collapse" data-target="#headerNav">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    
					
					<!-- Download tweets start  -->
                    <div id="headerNav" class="navbar-collapse collapse float--left">
                        <!-- Header Nav Links Start -->
                        <ul class="header--nav-links style--2 nav ff--primary" style="color: black;font-size: 16px;margin-top: 10px;">
                            
                            
                            
                            <li><a href="" data-toggle="modal" data-target="#myModal">Download Followers<i class="fa fa-download"></i> </a></li>
                            <li><a href="controller.php?logout=true">Logout<i class="fas fa-sign-out-alt"></i> </a></li>
							
                        </ul>
                        <!-- Header Nav Links End -->
                    </div>
					<!-- Download tweets End -->
                </div>
            </div>
            <!-- Header Navbar End -->
        </header>
        <!-- Header Section End -->
		<br/>
		
        <div class="container-fluid">
			<div class="row">
				<div class="col-md-3 left">
					<h1>My Followers</h1>
					
					<br/>
					<div class="col-md-12">
						<form>
							<input type="text" class="form-control" placeholder="Search Here..." id="searchbox" name="followers_search" autocomplete="off" />
						</form>
					</div>
					<div class="col-md-12" id="search"></div>
					<div class="col-md-12">
						<div id="hr_line"></div>
						<br />
					</div>
					<div id="followers" style="cursor:pointer;"></div>
				</div>

				<div class="col-md-9">
					<center>
						<br>
						<div id="myCarousel" class="carousel slide" data-ride="carousel" style="margin-top: 70px;">
							<!-- Wrapper for slides -->
							<div class="carousel-inner">
								<div class="item active" style="height:100px"> Loading </div>
							</div>
							<!-- Left and right controls -->
							<a class="left carousel-control" href="#myCarousel" data-slide="prev">
								<span class="glyphicon glyphicon-chevron-left"></span>
								<span class="sr-only">Previous</span>
							</a>
							<a class="right carousel-control" href="#myCarousel" data-slide="next">
								<span class="glyphicon glyphicon-chevron-right"></span>
								<span class="sr-only">Next</span>
							</a>
						</div>
					</center>

					<br />
					
				<div class="container">				
					  <!-- Modal -->
					  <div class="modal fade" id="myModal" role="dialog">
						<div class="modal-dialog">
						
						  <!-- Modal content-->
						  <div class="modal-content">
							<div class="modal-header">
							  <button type="button" class="close" data-dismiss="modal">&times;</button>
							  <h4 class="modal-title">Enter Valid Screenname And Download Public user Followers</h4>
							</div>
							<div class="modal-body">
							<form method="post" action="controller.php">
								<input type="text" name="key" placeholder="Enter Screenname" class="form-control search-box" id='search-box' required>
								<!--<span class="searchMessage" style="display: none;"><i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>--><br/>
								
							<label for="sel1">Select option for download Format:</label>
                            <select class="form-control" name="format">
                                <option value="#">Select Format</option>
								<option value="pdf">PDF (All Followers)</option>
                                <option value="xml">XML (ONLY 200 Followers)</option>
								<option value="drive">Google SpreedSheet (ONLY 200 Followers)</option>
                                
                            </select>
								<br/>
								<button type="submit" class="btn btn-primary" name="search_public_user">Download<i class="fa fa-search"></i></button>
								
								<!--<span style="color:black;font-size:16px;"></span>-->
							</form>
							</div>
							<div class="modal-footer">
							  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						  </div>
						  
						</div>
					  </div>
					  </div>
					<div class="col-md-4"></div>

				</div> 
			</div>
		</div>      
        
    </div>
    <!-- Wrapper End -->

    <!-- Back To Top Button Start -->
    <div id="backToTop">
        <a href="#" class="btn"><i class="fa fa-caret-up"></i></a>
    </div>
	
    <!-- Back To Top Button End -->
	
	<!-- ==== js for follower and slider ==== -->    
	<script src="js/script.js"></script>
   

    <!-- ==== Plugins Bundle ==== -->
    <script src="js/plugins.min.js"></script>
    
    <!-- ==== Main Script ==== -->
    <script src="js/main.js"></script>

    <script type="text/javascript" src="https://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>
	
</body>

</html>