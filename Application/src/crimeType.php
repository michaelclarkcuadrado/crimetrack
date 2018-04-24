<?php
require_once 'api/config.php';
$sql = "SELECT IUCR_PK, crime_type, crime_description FROM `crimetrack_crime_type`";
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
      				<li class="nav-item active"><a class="nav-link" href="#">Crimes</a></li>
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
    <table align="center" border='1' cellspacing='0' cellpadding='5'>
        <tr>
            <th>IUCR</th>
            <th>Crime Type</th>
            <th>Crime Description</th>
        </tr>
    <?php
        while($row = $result->fetch()){
            $IUCR = $row['IUCR_PK'];
            $type = $row['crime_type'];
            $description = $row['crime_description'];

            print "<tr>";
			print "<td>".$IUCR."</td>";
            print "<td>".$type."</td>";
            print "<td>".$description."</td>";
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