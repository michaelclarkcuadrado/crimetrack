<?php
	include_once('config.php');
	include('api/auth.php');

	$isFinishedSignup = false;
	$op = $_GET['op'];
	if ($op == 'auth') {
        auth($_POST); 
        die(); 
	} elseif ($op == 'signupsuccess'){
        $isFinishedSignup = true;
    }
?>

<html>
<head>
    <title>CrimeTrack | Mapping Chicago's crime</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="static/css/gridAndShadow.css" rel="stylesheet">
    <link href="static/css/landing.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="login_header m-shadow--4dp">
        <h1 class="headerTitle">CrimeTrack</h1>
        <div class="subtitle_container"><h5 class="headerTitle">Chicago</h5></div>
        <nav class="navbar navbar-expand-lg navbar-dark" style="float:right; font-weight: 700; font-size: 17px;">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    		    <span class="navbar-toggler-icon"></span>
  			</button>
  			<div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin: 0 5px">
    			<ul class="navbar-nav mr-auto">
					<li class="nav-item active"><a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a></li>
      				<li class="nav-item"><a class="nav-link" href="crimeType.php">Crimes</a></li>
					<li class="nav-item"><a class="nav-link" href="communityArea.php">Community Areas</a></li>
					<li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
					<form class="form-inline ml-4 my-2 my-lg-0">
      					<input class="form-control mr-sm-2" type="search" placeholder="Crime type / Location" aria-label="Search">
      					<button class="btn btn-danger my-2 my-sm-0" type="submit">Search</button>
    				</form>
				</ul>
			</div>
		</nav>
    </div>
    <div style="background-color: maroon;" class="login_header m-shadow--4dp">  
        <div style="margin-bottom: 10; margin-right: 20px; float:right; display: flex; line-height: 50px" class="login_box">
            <form method="post" style="margin-bottom: 0; margin-right: 5px" class="form-inline" action="index.php?op=auth">
            <div class="form-group" style="display: block;margin-right: 5px">
                <!--<label for="username_input">Username</label>-->
                <input type="text" class="form-control" id="username_input" required name="login_username" placeholder="Username">
                <small class="form-text" style="margin: 0 5px; position: absolute; line-height: 20px; color: white"><?php echo ($isFinishedSignup ? "You have successfully signed up." : "")?></small>
            </div>
            <div class="form-group" style="display: block; margin-right: 5px">
                <!--<label for="password_input">Password</label>-->
                <input type="password" class="form-control" id="password_input" required name="login_password" placeholder="Password">
                <small class="form-text text-muted" style="margin: 0 5px; position: absolute; line-height: 20px"><a style="color:white" href="forgotpassword.html">Forgot Password?</a></small>
            </div>
            <button type="submit" class="btn btn-primary">Log In</button>
            </form>
            <button type="button" class="btn btn-success" onclick="location.href='sign-up.php'">Sign Up</button>
        </div>
    </div>
    <div class="main">
        <div class="jumbotron">
            <h1 class="display-3">Mapping Chicago's Crime</h1>
            <p class="lead">Browse through our interactive visualizations, and explore an up-to-date record of crimes, neighborhood-by-neighborhood.</p>
        </div>
    </div>
    <div class="copyright_footer">
        <div style="color: #ccc;" class="col-sm-6">
            A Gettysburg College Project for Computer Science | <a href="https://github.com/michaelclarkcuadrado/crimetrack">Source Code</a>
        </div>
    </div>
    <script src="vendor/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>