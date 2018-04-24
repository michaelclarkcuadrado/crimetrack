<?php
require_once 'api/config.php';
$sql = "SELECT area_id, community_name FROM `crimetrack_chicago_community_areas`";
$result = $db->query($sql);
?>
<html>
<head>
    <title>CrimeTrack | Community Areas</title>
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
					<li class="nav-item"><a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a></li>
      				<li class="nav-item"><a class="nav-link" href="crimeType.php">Crimes</a></li>
					<li class="nav-item active"><a class="nav-link" href="#">Community Areas</a></li>
					<li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
					<form class="form-inline ml-4 my-2 my-lg-0">
      					<input class="form-control mr-sm-2" type="search" placeholder="Crime type / Location" aria-label="Search">
      					<button class="btn btn-danger my-2 my-sm-0" type="submit">Search</button>
    				</form>
				</ul>
			</div>
		</nav>
    </div>
    <table align="center" border='1' cellspacing='0' cellpadding='5'>
        <tr>
            <th>Area ID</th>
            <th>Area Name</th>
        </tr>
    <?php
        $row = $result->fetch();
        while($row = $result->fetch()){
            $id = $row['area_id'];
            $name = $row['community_name'];

            print "<tr>";
			print "<td>".$id."</td>";
			print "<td>".$name."</td>";
			print "</tr>\n";
        }
    ?> 
    </table>
    <div class="copyright_footer">
        <div style="color: #ccc;" class="col-sm-6">
            A Gettysburg College Project for Computer Science | <a href="https://github.com/michaelclarkcuadrado/crimetrack">Source Code</a>
        </div>
    </div>
</body>
</html>