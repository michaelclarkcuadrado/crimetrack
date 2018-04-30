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
                    <li class="nav-item"><a class="nav-link" href="AboutUs.html">About Us</a></li>
                    <span class="navbar-text" style="font-size: 25px;">&emsp;|&emsp;</span>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Welcome,
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
    <div id="statisticsPanel">
        SELECTED NEIGHBORHOOD I.D.S:
        <span v-for="id in neighborhoodSelections">
            {{id}}
        </span>
        <br>
        SELECTED CRIME I.D.S:
        <span v-for="id in crimeTypeSelections">
            {{id}}
        </span>
        <div style="border: 1px solid black; padding: 5px;">
            <h4 style="text-align: center;">Export This Data</h4>
            <select id="dataExportSelectMonth">
                <option value="1">
                    January
                </option>
                <option value="2">
                    February
                </option>
                <option value="3">
                    March
                </option>
                <option value="4">
                    April
                </option>
                <option value="5">
                    May
                </option>
                <option value="6">
                    June
                </option>
                <option value="7">
                    July
                </option>
                <option value="8">
                    August
                </option>
                <option value="9">
                    September
                </option>
                <option value="10">
                    October
                </option>
                <option value="11">
                    November
                </option>
                <option value="12">
                    December
                </option>
            </select>
            <select id="dataExportSelectYear">
                <?php
                for ($i = 2001; $i <= date('Y'); $i++) {
                    echo "<option value='$i'>$i</option>";
                }
                ?>
            </select>
            <button v-on:click="downloadCSV()">Download CSV</button>
        </div>
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
            toggleNeighborhoodSelection: function (neighborhood) {
                if (neighborhood.isSelected) {
                    this.neighborhoodSelections = this.neighborhoodSelections.filter(function (val) {
                        return val !== neighborhood.area_id;
                    })
                } else {
                    this.neighborhoodSelections.push(neighborhood.area_id);
                }

                neighborhood.isSelected = !neighborhood.isSelected;
                this.updateStatistics();
            },
            toggleCrimeTypeSelection: function (crimeType) {
                if (crimeType.isSelected) {
                    for (var subcrime in crimeType.subcrimes) {
                        console.log(subcrime);
                        if (this.crimeTypeSelections.includes(subcrime)) {
                            this.crimeTypeSelections = this.crimeTypeSelections.filter(function (val) {
                                return val !== subcrime;
                            });
                        }
                    }
                } else {
                    for (var subcrime in crimeType.subcrimes) {
                        this.crimeTypeSelections.push(subcrime);
                    }
                }
                crimeType.isSelected = !crimeType.isSelected;
                this.updateStatistics();
            },
            updateStatistics: function () {
                let jsonBlob = JSON.stringify({
                    IUCRs: this.crimeTypeSelections,
                    neighborhoods: this.neighborhoodSelections
                });
                $.post('api/getStatisticsMatch.php', {jsonBlob: jsonBlob}, function (data) {
                    //TODO
                }, "json");
            },
            downloadCSV: function(){
                let monthSelect = document.getElementById('dataExportSelectMonth');
                let month = monthSelect.options[monthSelect.selectedIndex].value;
                let yearSelect = document.getElementById('dataExportSelectYear');
                let year = yearSelect.options[yearSelect.selectedIndex].value;
                let argsObj = {
                    crimeType: JSON.stringify(this.crimeTypeSelections),
                    neighborhood: JSON.stringify(this.neighborhoodSelections),
                    month: month,
                    year: year
                };
                let params = $.param(argsObj);
                window.location = 'api/downloadcsv.php?'+params;
            }
        },
        mounted: function () {
            let self = this;
            $.getJSON('api/listNeighborhoods', function (data) {
                self.neighborhoods = data;
            });
            $.getJSON('api/listCrimeTypes', function (data) {
                self.crimeTypes = data;
            });
        }
    });
</script>
</body>
</html>
