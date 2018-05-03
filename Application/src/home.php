<?php
require_once 'api/config.php';
session_start();
if (!isset($_SESSION['uid'])) {
    die("<script>location.href = './'</script>");
}
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
                    <li class="nav-item"><a class="nav-link" href="AboutUs.php">About Us</a></li>
                    <span class="navbar-text" style="font-size: 25px;">&emsp;|&emsp;</span>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Welcome, <?=$_SESSION['username']?>

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
    <div v-show="neighborhoodSelections.length == 0 || crimeTypeSelections.length == 0" style="position: relative; top: 0; right: 0;width: 100%; padding: 15px; text-align: center">
        Select some crimes and neighborhoods to get started.
    </div>
    <div class="sidebar" style="max-width: 49em" id="statisticsPanel" v-show="neighborhoodSelections.length > 0 && crimeTypeSelections.length > 0">
        <h4 style="text-align: center; margin: auto;">Selection Fast Facts</h4>
        <table class="table table-striped">
            <tr>
                <td>Population</td>
                <td>{{ Number(neighborhoodStats.totalPopulation).toLocaleString() }}</td>
            </tr>
            <tr>
                <td>Total Crimes (2001 - <?= date('Y') ?>)</td>
                <td>{{ Number(neighborhoodStats.totalCrimes).toLocaleString() }}</td>
            </tr>
            <tr>
                <td>Average Income</td>
                <td>{{ '$' + Number(neighborhoodStats.averageIncome).toLocaleString() }}</td>
            </tr>
            <tr>
                <td>Crimes per 100,000 people</td>
                <td>{{ neighborhoodStats.crimesPerHundredThousand }}</td>
            </tr>
        </table>
        <canvas class="infoChart" id="racialPieChart"></canvas>
        <canvas class="infoChart" id="arrestsChart"></canvas>
        <canvas class="infoChart" id="domesticChart"></canvas>
        <canvas class="infoChart" id="top10IUCRBarChart"></canvas>
        <canvas class="infoChart" id="locationDescriptionsChart"></canvas>
        <div style="border: 1px solid black; padding: 5px; margin: auto;">
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
        </div> <!-- Export Data Box -->
    </div>
    <div id="statisticsPanel" v-show="neighborhoodSelections.length > 0 && crimeTypeSelections.length > 0">
        <div align="center" style="display: inline-block">
            
            <img id="map" v-bind:src="getMapURL">
        </div>
    </div>
    <div v-show="updateMutex" id="loadingScreen">
        <span style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%); font-size: xx-large; background-color: rgba(255,255,255,.5); border-radius: 3px; padding: 6px;">Loading...</span>
    </div>
</div>
<script src="vendor/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/vue.min.js"></script>
<script src="vendor/Chart.bundle.min.js"></script>
<script>
    let appVue = new Vue({
        el: "#main",
        data: {
            neighborhoods: {},
            crimeTypes: {},
            neighborhoodSelections: [],
            crimeTypeSelections: [],
            updateMutex: false,
            neighborhoodStats: {},
            crimeStats: {},
            racialPieChartInstance: {},
            top10IUCRBarChartInstance: {},
            locationDescriptionsChart: {},
            arrestPieChart: {},
            domesticPieChart: {},

        },
        methods: {
            toggleNeighborhoodSelection: function (neighborhood) {
                if (this.updateMutex) {
                    return;
                }
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
                if (this.updateMutex) {
                    return;
                }
                if (crimeType.isSelected) {
                    for (var subcrime in crimeType.subcrimes) {
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
                if (this.neighborhoodSelections.length == 0 || this.crimeTypeSelections.length == 0) {
                    return false;
                }
                if (this.updateMutex) {
                    return false;
                }
                this.updateMutex = true;
                let jsonBlob = JSON.stringify({
                    IUCRs: this.crimeTypeSelections,
                    neighborhoods: this.neighborhoodSelections
                });
                let self = this;
                $.post('api/getStatisticsMatch.php', {jsonBlob: jsonBlob}, function (data) {
                    self.crimeStats = data.crimeStats;
                    self.neighborhoodStats = data.neighborhoodStats;

                    //update charts
                    //update racial pie chart
                    self.racialPieChartInstance.config.data.datasets[0].data = data.neighborhoodStats.racialBreakdown;
                    self.racialPieChartInstance.update();

                    //update top IUCRS
                    let newIUCRDataObj = {
                        title: "Most Common Crimes",
                        labels: [],
                        datasets: [{
                            data: [],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(255,99,132,1)',
                                'rgba(255,99,132,1)',
                                'rgba(255,99,132,1)',
                                'rgba(255,99,132,1)',
                                'rgba(255,99,132,1)',
                                'rgba(255,99,132,1)',
                                'rgba(255,99,132,1)',
                                'rgba(255,99,132,1)',
                                'rgba(255,99,132,1)',
                            ],
                            borderWidth: 1
                        }],
                    };
                    newIUCRDataObj.labels = data.crimeStats.top10IUCR.map(crime => crime.crime_type);
                    newIUCRDataObj.datasets[0].data = data.crimeStats.top10IUCR.map(crime => crime.TOTAL);
                    self.top10IUCRBarChartInstance.data = newIUCRDataObj;
                    self.top10IUCRBarChartInstance.update();

                    //update location descriptions
                    let newLocationDescDataObj = {
                        labels: [],
                        datasets: [{
                            data: [],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(255,99,132,1)',
                                'rgba(255,99,132,1)',
                                'rgba(255,99,132,1)',
                                'rgba(255,99,132,1)',
                                'rgba(255,99,132,1)',
                                'rgba(255,99,132,1)',
                                'rgba(255,99,132,1)',
                                'rgba(255,99,132,1)',
                                'rgba(255,99,132,1)',
                            ],
                            borderWidth: 1
                        }]
                    };
                    newLocationDescDataObj.labels = data.crimeStats.locationDescs.map(loc => loc.LOCATION_DESCRIPTION);
                    newLocationDescDataObj.datasets[0].data = data.crimeStats.locationDescs.map(loc => loc.TOTAL);
                    self.locationDescriptionsChart.data = newLocationDescDataObj;
                    self.locationDescriptionsChart.update();

                    //update arrests
                    self.arrestPieChart.config.data.datasets[0].data = [data.crimeStats.arrestCount.true, data.crimeStats.arrestCount.false];
                    self.arrestPieChart.update();

                    //update domestics
                    self.domesticPieChart.config.data.datasets[0].data = [data.crimeStats.domesticCount.true, data.crimeStats.domesticCount.false];
                    self.domesticPieChart.update();

                    self.updateMutex = false;
                }, "json").fail(function () {
                    self.updateMutex = false;
                });
            },
            downloadCSV: function () {
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
                window.location = 'api/downloadcsv.php?' + params;
            }
        },
        computed: {
            getMapURL: function () {
                return 'api/mapPinGenerator.php?neighborhoods=' + JSON.stringify(this.neighborhoodSelections);
            },
        },
        mounted: function () {
            let self = this;
            $.getJSON('api/listNeighborhoods', function (data) {
                self.neighborhoods = data;
            });
            $.getJSON('api/listCrimeTypes', function (data) {
                self.crimeTypes = data;
            });

            //init charts
            //create race piechart
            let racePieChartElement = document.getElementById("racialPieChart");
            self.racialPieChartInstance = new Chart(racePieChartElement, {
                type: 'pie',
                data: {
                    title: "Race",
                    labels: ["Latino", "Black", "Asian", "White", "Other"],
                    datasets: [{
                        data: [],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 159, 64, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(255, 159, 64, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Racial Breakdown'
                    },
                    responsive: true
                }
            });

            //create top 10 IUCR chart
            let top10IUCRChartElement = document.getElementById("top10IUCRBarChart");
            self.top10IUCRBarChartInstance = new Chart(top10IUCRChartElement, {
                type: 'horizontalBar',
                data: {
                    title: "Most Common Crimes",
                    labels: ["", "", "", "", "", "", "", "", "", ""],
                    datasets: [{
                        data: [],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(255,99,132,1)',
                            'rgba(255,99,132,1)',
                            'rgba(255,99,132,1)',
                            'rgba(255,99,132,1)',
                            'rgba(255,99,132,1)',
                            'rgba(255,99,132,1)',
                            'rgba(255,99,132,1)',
                            'rgba(255,99,132,1)',
                            'rgba(255,99,132,1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    legend: false,
                    title: {
                        display: true,
                        text: 'Top Crimes'
                    },
                    responsive: true
                }
            });

            //create location descriptions chart
            let locationDescriptionChartElement = document.getElementById("locationDescriptionsChart");
            self.locationDescriptionsChart = new Chart(locationDescriptionChartElement, {
                type: 'horizontalBar',
                data: {
                    title: "Most Dangerous Areas",
                    labels: ["", "", "", "", "", "", "", "", "", ""],
                    datasets: [{
                        data: [],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(255,99,132,1)',
                            'rgba(255,99,132,1)',
                            'rgba(255,99,132,1)',
                            'rgba(255,99,132,1)',
                            'rgba(255,99,132,1)',
                            'rgba(255,99,132,1)',
                            'rgba(255,99,132,1)',
                            'rgba(255,99,132,1)',
                            'rgba(255,99,132,1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    legend: false,
                    title: {
                        display: true,
                        text: 'Most Dangerous Locations'
                    },
                    responsive: true
                }
            });

            //create arrests chart
            let arrestsPieChartElement = document.getElementById("arrestsChart");
            self.arrestPieChart = new Chart(arrestsPieChartElement, {
                type: 'pie',
                data: {
                    labels: ["True", "False"],
                    datasets: [{
                        data: [],
                        backgroundColor: [
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Arrested'
                    },
                    responsive: true
                }
            });

            //create domestic chart
            let domesticPieChartElement = document.getElementById("domesticChart");
            self.domesticPieChart = new Chart(domesticPieChartElement, {
                type: 'pie',
                data: {
                    labels: ["True", "False"],
                    datasets: [{
                        data: [],
                        backgroundColor: [
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                        ],
                        borderColor: [
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'Domestic'
                    },
                    responsive: true
                }
            });


            //todo: preselect user-saved data

        }
    });
</script>
</body>
</html>
