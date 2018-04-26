<?php
require_once 'api/config.php';
session_start();
$uid = $_SESSION['uid'];
?>

<html>
<head>
    <title>CrimeTrack Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="static/css/gridAndShadow.css" rel="stylesheet">
    <link href="static/css/home.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="login_header m-shadow--4dp">
    <h1 class="headerTitle">CrimeTrack</h1>
    <div class="subtitle_container"><h5 class="headerTitle">Chicago</h5></div>
    <div style="float:right; display: flex; line-height: 23px" class="login_box">
        <nav class="navbar navbar-expand-lg navbar-dark" style="font-weight: 700; font-size: 17px;">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-bottom: 0; margin-right: 10px">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active"><a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
                    <form class="form-inline ml-4 my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="Crime type / Location" aria-label="Search">
                        <button class="btn btn-danger my-2 my-sm-0" type="submit">Search</button>
                    </form>
                    <span class="navbar-text" style="font-size: 25px;">&emsp;|&emsp;</span>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Welcome, <?php echo $_SESSION['username']?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="editProfile.php">Edit Profile</a>
                            <a class="dropdown-item" href="#">View Favorites</a>
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
    <div class="sidebar" id="crimesList">
        <ul class="list-group list-group-flush">
            <li class="list-group-item" v-for="crimeType in crimeTypes" v-bind:class="{ active : crimeType.isSelected }" v-on:click="toggleCrimeTypeSelection(crimeType)">
                {{crimeType.name}}
                <ul class="subtext">
                    <li v-for="subcrime, index in crimeType.subcrimes">
                        {{subcrime}}
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="sidebar" id="NeighborhoodsList">
        <ul class="list-group list-group-flush">
            <li class="list-group-item" v-for="neighborhood in neighborhoods" v-bind:class="{ active : neighborhood.isSelected }" v-on:click="toggleNeighborhoodSelection(neighborhood)">
                {{neighborhood.community_name}}
            </li>
        </ul>
    </div>
    <div>
        SELECTED NEIGHBORHOOD I.D.S:
        <span v-for="id in neighborhoodSelections">
            {{id}}
        </span>
        <br>
        SELECTED CRIME I.D.S:
        <span v-for="id in crimeTypeSelections">
            {{id}}
        </span>
    </div>
</div>
<div class="copyright_footer">
    <div style="color: #ccc;" class="col-sm-6">
        A Gettysburg College Project for Computer Science | <a href="https://github.com/michaelclarkcuadrado/crimetrack">Source Code</a>
    </div>
</div>
<script src="vendor/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/vue.min.js"></script>
<script>
    let appVue = new Vue({
        el: "#main",
        data: {
            neighborhoods: {},
            crimeTypes: {},
            neighborhoodSelections: [],
            crimeTypeSelections: [],
        },
        methods: {
            toggleNeighborhoodSelection: function(neighborhood){
                if(neighborhood.isSelected){
                    this.neighborhoodSelections = this.neighborhoodSelections.filter(function(val){
                        return val !== neighborhood.area_id;
                    })
                } else {
                    this.neighborhoodSelections.push(neighborhood.area_id);
                }

                neighborhood.isSelected = !neighborhood.isSelected;
            },
            toggleCrimeTypeSelection: function(crimeType){
                if(crimeType.isSelected){
                    //TODO ARRAY DIFFERENCE HERE
                } else {
                    for(var subcrime in crimeType.subcrimes){
                        this.crimeTypeSelections.push(subcrime);
                    }
                }
                crimeType.isSelected = !crimeType.isSelected;
            }
        },
        mounted: function() {
            let self = this;
            $.getJSON('api/listNeighborhoods', function(data){
                 self.neighborhoods = data;
            });
            $.getJSON('api/listCrimeTypes', function(data){
                self.crimeTypes = data;
            });
        }
    });
</script>
</body>
</html>
