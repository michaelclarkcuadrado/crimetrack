<?php
require_once 'api/config.php';
session_start();
if (!isset($_SESSION['uid'])) {
    die("<script>location.href = './'</script>");
}
?>
<html>

<head>
    <title>
        CrimeTrack | About Us
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="static/css/gridAndShadow.css" rel="stylesheet">
    <link href="static/css/home.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="login_header m-shadow--4dp">
        <h1 class="headerTitle">CrimeTrack</h1>
        <div class="subtitle_container">
            <h5 class="headerTitle">Chicago</h5>
        </div>
        <div style="float:right; display: flex; line-height: 23px" class="login_box">
            <nav class="navbar navbar-expand-lg navbar-dark" style="font-weight: 700; font-size: 17px;">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-bottom: 0; margin-right: 10px">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item"><a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a></li>
                        <li class="nav-item active"><a class="nav-link" href="#">About Us</a></li>
                        <span class="navbar-text" style="font-size: 25px;">&emsp;|&emsp;</span>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Welcome,
                                <?= $_SESSION['username']?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="editProfile.php">Edit Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="api/logout.php">Log out</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div id="main">
        <!--<h3 style="max-width: 550px; max-height: fit-content; margin: 10px auto; border: 1px solid black; padding: 5px"><br /> Development Team: <br /> Michael Clark-Cuadrado Tracy Tang Ben Boucher</h3>-->
        <div class="container" style="margin: 10px auto">
            <div class="row">
                <div class="col">
                    <h3 style="text-align: center">Crime Track was created by a team of Gettysburg College students for professor Sunghee Kim's database course.</h3>
                </div>
            </div>
            <div class="row">
                <div class="col-sm" style="background-color: rgba(214, 72, 72, 0.3); height: 100%; margin: 10px; border-radius: .3rem; padding: 10px">
                    <img src="static/img/default-image.png" class="rounded mx-auto d-block" width=300 height=300>
                    <br />
                    <h4>Yidan Tang</h4>
                    <ul>
                        <li>Email: tangyi01@gettysburg.edu</li>
                        <li>Class 2019
                    </ul>
                </div>
                <div class="col-sm" style="background-color: rgba(177, 127, 70, 0.3); height: 100%; margin: 10px; border-radius: .3rem; padding: 10px">
                    <img src="static/img/default-image.png" class="rounded mx-auto d-block" width=300 height=300>
                    <br />
                    <h4>Michael Clark-Cuadrado</h4>
					<ul>
                        <li>Email: clarmi03@gettysburg.edu</li>
                        <li>Class 2018
                    </ul>
                </div>
                <div class="col-sm" style="background-color: rgba(179, 167, 63, 0.3); height: 100%; margin: 10px; border-radius: .3rem; padding: 10px">
                    <img src="static/img/default-image.png" class="rounded mx-auto d-block" width=300 height=300>
                    <br />
                    <h4>Ben Boucher</h4>
					<ul>
                        <li>Email: boucbe01@gettysburg.edu</li>
                        <li>Class 2020
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright_footer">
        <div style="color: #ccc;" class="col-sm-6">
            A Gettysburg College Project for Computer Science | <a href="https://github.com/michaelclarkcuadrado/crimetrack">Source Code</a>
        </div>
    </div>
</body>

</html>
