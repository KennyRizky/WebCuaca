<html>
    <head>
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <script src="Chart.bundle.js"></script>
        <script src="utils.js"></script>
    </head>
    <body>
        <div class="searchNavBar w3-container w3-display-container">
            <div class="w3-margin-bottom w3-margin-right location-picker-div">
                <h2>Pick Location:</h2>

                <?php 
                //get dates and locations from csv
                $row = 0;
                $location = [];
                $date = [];
                if (($handle = fopen("weatherAUS.csv", "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $num = count($data);
                        for ($c=0; $c < $num; $c++) {
                            if ($row != 0 && $c == 0 && !in_array($data[$c], $date))
                            {
                                array_push($date,$data[$c]);
                            }
                            if ($row != 0 && $c == 1 && !in_array($data[$c], $location))
                            {
                                array_push($location,$data[$c]);
                                break;
                            }
                        }
                        $row++;
                    }
                    fclose($handle);
                }
                ?>

                <select style="height: 30px; width: 150px;">
                    <?php foreach($location as $key => $value) { ?>
                        <option value="<?php echo $key ?>"><?php echo $value ?></option>
                    <?php }?>
                </select>
            </div>
            <div style="margin-left: 2%; width: 40%;">
                <h2>Pick Date:</h2>

                <span>From: </span>
                <select style="height: 30px; width: 150px;">
                    <?php foreach($date as $key => $value) { ?>
                        <option value="<?php echo $key ?>"><?php echo $value ?></option>
                    <?php }?>
                </select>

                <span style="margin-left: 2%;">To: </span>
                <select style="height: 30px; width: 150px;">
                    <?php foreach($date as $key => $value) { ?>
                        <option value="<?php echo $key ?>"><?php echo $value ?></option>
                    <?php }?>
                </select>

                <button style="margin-left: 2%;">GO</button>
            </div>

            <div class="search-nav-div">
                <a class="search-navbtn btn" href="HomePage.php">Home</a>
                <a class="search-navbtn btn" href="SearchPage.php">Search</a>
                <a class="search-navbtn btn" href="predict.php">Predict</a>
            </div>
        </div>
        <div class="w3-container">
            <div class="w3-quarter">
                <h1 style="margin-left:2px">
                    <?php
                        $var1=1;
                        $var2=23;
                        $output=passthru("python test.py");

                        echo $output;
                    ?>
                </h1>

                <h1 class="w3-border-bottom w3-border-black">Weather for Sydney:</h1>

                <div class="w3-border-bottom w3-border-black">
                    <div div style="float: left;">
                        <h2>Morning:</h2>
                    </div>
                    <div style="margin-left: 170px; position: relative; top: 20px; margin-bottom: 50px;">
                        <p>Temperature: 21 °C</p>
                        <p>Humidity: 99%</p>
                        <p>Wind: 6 km/h</p>
                    </div>
                </div>
                
                <div class="w3-border-bottom w3-border-black">
                    <div div style="float: left;">
                        <h2>Afternoon:</h2>
                    </div>
                    <div style="margin-left: 170px; position: relative; top: 20px; margin-bottom: 50px;">
                        <p>Temperature: 21 °C</p>
                        <p>Humidity: 99%</p>
                        <p>Wind: 6 km/h</p>
                    </div>
                </div>

                <div class="w3-border-bottom w3-border-black">
                    <div style="float: left;">
                        <h2>Evening:</h2>
                    </div>
                    <div style="margin-left: 170px; position: relative; top: 20px; margin-bottom: 50px;">
                        <p>Temperature: 21 °C</p>
                        <p>Humidity: 99%</p>
                        <p>Wind: 6 km/h</p>
                    </div>
                </div>
            </div>
            
            <div class="search-chart w3-threequarter" style="width: 50%; margin-left: 15%; margin-top: 3%; background-color: #fff1d7;">
                <canvas id="canvas"></canvas>
            </div>
        </div>

        <script>
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
        </script>
    </body>
</html>