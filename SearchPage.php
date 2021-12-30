<?php
    session_start();
?>
<html>
    <head>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <script src="Chart.bundle.js"></script>
        <script src="utils.js"></script>
        <title>Search Page</title>
    </head>
    <body>
        <div class="searchNavBar w3-container w3-display-container">
            <form action="SearchController.php" method="get" class="formSearch">
                <div class="w3-margin-bottom w3-margin-right location-picker-div">
                    <h2>Pick Location:</h2>

                    <?php 
                        //get dates and locations from csv
                        $location = exec("python getLocationFromCSV.py");
                        $location = json_decode($location);
                    ?>

                    <select id="location" name="location" style="height: 30px; width: 150px;">
                        <?php foreach($location as $key => $value) { ?>
                            <option value="<?php echo $value ?>"><?php echo $value ?></option>
                        <?php }?>
                    </select>
                </div>
                <div>
                    <div>
                        <h2>Pick Date:</h2>
                    </div>    

                    <div class="formDate">
                        From:
                        <input type="date" id="dateFrom" name="dateFrom" min="2008-12-01" max="2017-06-25" style="margin-right: 10px">

                        To:
                        <input type="date" id="dateTo" name="dateTo" min="2008-12-02" max="2017-06-25" style="margin-right: 10px">

                        <input type="submit" style="" value="Go"></input>
                    </div>
                </div>
            </form>

            <div class="search-nav-div">
                <a class="search-navbtn btn" href="HomePage.php">Home</a>
                <a class="search-navbtn btn" href="SearchPage.php">Search</a>
                <a class="search-navbtn btn" href="predict.php">Predict</a>
            </div>
        </div>
        <div class="w3-container" id="main-content">
            <div class="w3-quarter">
                <h1 id="tes"></h1>
                <h1 class="w3-border-bottom w3-border-black">Weather for <?php
                        if(isset($_SESSION['location'])){
                            echo $_SESSION['location'];
                        }
                    ?>:
                </h1>

                <input type="date" id="singleDate" name="singleDate" min="2008-12-01" max="2017-06-25">

                <div class="w3-border-bottom w3-border-black">
                    <div style="position: relative;">
                        <p id="minTemp">MinTemp: </p>
                        <p id="maxTemp">MaxTemp: </p>
                        <p id="rainfall">Rainfall: </p>
                        <p id="evaporation">Evaporation: </p>
                        <p id="sunshine">Sunshine: </p>
                        <p id="windGustDir">WindGustDir: </p>
                        <p id="windGustSpeed">WindGustSpeed: </p>
                        <p id="rainToday">RainToday: </p>
                        <p id="rainTomorrow">RainTomorrow: </p>
                    </div>
                </div>
                <div class="w3-border-bottom w3-border-black">
                    <div div style="float: left;">
                        <h2>Morning:</h2>
                    </div>
                    <div style="margin-left: 170px; position: relative; top: 20px; margin-bottom: 50px;">
                        <p id="windDir9am">WindDir: </p>
                        <p id="windSpeed9am">WindSpeed: </p>
                        <p id="humidity9am">Humidity: </p>
                        <p id="pressure9am">Pressure: </p>
                        <p id="cloud9am">Cloud: </p>
                        <p id="temp9am">Temp: </p>
                    </div>
                </div>

                <div class="w3-border-bottom w3-border-black">
                    <div style="float: left;">
                        <h2>Evening:</h2>
                    </div>
                    <div style="margin-left: 170px; position: relative; top: 20px; margin-bottom: 50px;">
                        <p id="windDir3pm">WindDir: </p>
                        <p id="windSpeed3pm">WindSpeed: </p>
                        <p id="humidity3pm">Humidity: </p>
                        <p id="pressure3pm">Pressure: </p>
                        <p id="cloud3pm">Cloud: </p>
                        <p id="temp3pm">Temp: </p>
                    </div>
                </div>
            </div>
            
            <div class="search-chart w3-threequarter" style="width: 50%; margin-left: 15%; margin-top: 3%; background-color: #fff1d7;">
                <canvas id="canvas"></canvas>
            </div>
        </div>

        <script>
            //create graph
            window.onload = function(){
                var ctx = document.getElementById("canvas").getContext("2d");
                new Chart(ctx, myChart);
            }
            var dataPemasukan = [
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor(),
                randomScalingFactor()
            ];
            var dataPengeluaran = [
                            randomScalingFactor() ,
                            randomScalingFactor() ,
                            randomScalingFactor() ,
                            randomScalingFactor() ,
                            randomScalingFactor() ,
                            randomScalingFactor() ,
                            randomScalingFactor()
            ];
            var myChart = {
                type: 'line',
                data: {
                    datasets : [
                        {/*objek dataset1*/
                            label: "Pengeluaran",
                            backgroundColor: window.chartColors.grey,
                            borderColor: window.chartColors.red,
                            data: dataPengeluaran,
                            fill: true
                        },
                        {/*objek dataset2*/
                            label: "Pemasukan",
                            backgroundColor: window.chartColors.white,
                            borderColor: window.chartColors.blue,
                            data: dataPemasukan,
                            fill: true
                        } 
                    ],
                    labels: ["January", "February", "March", "April", "May", "June", "July"],
                },
                options: {
                    scales:{
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Month'
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Month'
                            }
                        }]
                    },
                    title:{
                        display: true,
                        text:'Chart.js Line Char',
                    },
                    responsive: true
                }
            };

            //set calendar default value
            var dateFrom = document.getElementById('dateFrom');
            dateFrom.value = "2008-12-01";
            var dateTo =  document.getElementById('dateTo');
            dateTo.value = "2008-12-02";

            dateFrom.addEventListener("change", changeToMax);

            function changeToMax(){
                var dateFrom = document.getElementById('dateFrom');
                var dateTo =  document.getElementById('dateTo');
                var minDate = new Date(dateFrom.value);
                minDate.setDate(minDate.getDate() + 1);
                minDate = minDate.toISOString().split('T')[0];
                dateTo.setAttribute("min", minDate);
                if(dateTo.value < minDate){
                    dateTo.value = minDate;
                }
            }
            function changeFromValue(){
                var dateFrom = document.getElementById('dateFrom');
                var minDate = dateFrom.getAttribute("min");
                var maxDate = dateFrom.getAttribute("max");
                if(dateFrom.value < minDate){
                    dateFrom.value = minDate;
                }
                if(dateFrom.value > maxDate){
                    dateFrom.value = maxDate;
                }
            }

            <?php 
                if(isset($_SESSION['dateFrom'])){
                    echo "document.getElementById('dateFrom').value = '$_SESSION[dateFrom]';";
                    echo "document.getElementById('dateTo').value = '$_SESSION[dateTo]';";
                    echo "changeToMax();";

                    //set singledatepicker min and value
                    $singleMinDate = $_SESSION['dateFrom'];
                    echo "document.getElementById('singleDate').setAttribute('min', '$singleMinDate');";
                    echo "document.getElementById('singleDate').value = '$singleMinDate';";
                    echo "getRowValue('$singleMinDate');";
                }
                if(isset($_SESSION['dateTo'])){
                    //set singledatepicker max
                    $singleMaxDate = $_SESSION['dateTo'];
                    echo "document.getElementById('singleDate').setAttribute('max', '$singleMaxDate');";
                }
                if(!isset($_SESSION['dateFrom']) && !isset($_SESSION['dateTo'])){
                    echo "document.getElementById('main-content').style.visibility = 'hidden';";
                }
            ?>

            document.getElementById('singleDate').onchange = function getValues(){
                var singleDate =  document.getElementById('singleDate').value;
                getRowValue(singleDate);
            }

            function getRowValue(singleDate) {
                if (singleDate) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            var arrVal = this.responseText;
                            if(arrVal){
                                arrVal = JSON.parse(arrVal);
                                document.getElementById('minTemp').innerHTML = "MinTemp: "+arrVal[2];
                                document.getElementById('maxTemp').innerHTML = "MaxTemp: "+arrVal[3];
                                document.getElementById('rainfall').innerHTML = "Rainfall: "+arrVal[4];
                                document.getElementById('evaporation').innerHTML = "Evaporation: "+arrVal[5];
                                document.getElementById('sunshine').innerHTML = "Sunshine: "+arrVal[6];
                                document.getElementById('windGustDir').innerHTML = "WindGustDir: "+arrVal[7];
                                document.getElementById('windGustSpeed').innerHTML = "WindGustSpeed: "+arrVal[8];
                                document.getElementById('windDir9am').innerHTML = "WindDir: "+arrVal[9];
                                document.getElementById('windDir3pm').innerHTML = "WindDir: "+arrVal[10];
                                document.getElementById('windSpeed9am').innerHTML = "WindSpeed: "+arrVal[11];
                                document.getElementById('windSpeed3pm').innerHTML = "WindSpeed: "+arrVal[12];
                                document.getElementById('humidity9am').innerHTML = "Humidity: "+arrVal[13];
                                document.getElementById('humidity3pm').innerHTML = "Humidity: "+arrVal[14];
                                document.getElementById('pressure9am').innerHTML = "Pressure: "+arrVal[15];
                                document.getElementById('pressure3pm').innerHTML = "Pressure: "+arrVal[16];
                                document.getElementById('cloud9am').innerHTML = "Cloud: "+arrVal[17];
                                document.getElementById('cloud3pm').innerHTML = "Cloud: "+arrVal[18];
                                document.getElementById('temp9am').innerHTML = "Temp: "+arrVal[19];
                                document.getElementById('temp3pm').innerHTML = "Temp: "+arrVal[20];
                                document.getElementById('rainToday').innerHTML = "RainToday: "+arrVal[21];
                                document.getElementById('rainTomorrow').innerHTML = "RainTomorrow: "+arrVal[22];
                            }
                        }
                    }
                    xmlhttp.open("GET", "getRowValue.php?date="+singleDate, true);
                    xmlhttp.send();
                }
            }

            var locationSelect = document.getElementById("location");
            locationSelect.addEventListener("change", getDateMinMax);

            function getDateMinMax() {
                var location = this.options[this.selectedIndex].value;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var arrRes = this.responseText;
                        console.log(arrRes);
                        if(arrRes){
                            arrRes = JSON.parse(arrRes);
                            document.getElementById('dateTo').setAttribute("min",arrRes[0]);
                            document.getElementById('dateTo').setAttribute("max",arrRes[1]);
                            document.getElementById('dateFrom').setAttribute("min",arrRes[0]);
                            document.getElementById('dateFrom').setAttribute("max",arrRes[1]);
                            changeFromValue();
                            changeToMax();
                        }
                    }
                }
                xmlhttp.open("GET", "getDateMinMax.php?location="+location, true);
                xmlhttp.send();
            }
        </script>
    </body>
</html>