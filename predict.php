<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
<title>Predict Page</title>

</head>
<body>
    <div class="NavBar">

        <h1 class="weather">Weather</h1>

        <div class="Buttons">
            <a class="btn" href="HomePage.php">Home</a>
            <a class="btn" href="SearchPage.php">Search</a>
            <a class="btn" href="predict.php">Predict</a>
        </div>
    </div>

    <div class="predictContent">
        <div class="predictInput">
            <h2>
                Input data to predict weather: 
            </h2>
            <form action="PredictController.php" method="get" class="formPredict">

                Rainfall: <input type="text" name="rainfall" id="rainfall" placeholder="Rainfall"> <br>

                Humidity 3 PM: <input type="text" name="humid3" id="humid3" placeholder="Humidity 3 PM"> <br>

                Humidity 9 AM: <input type="text" name="humid9" id="humid9" placeholder="Humidity 9 AM"> <br>
       
                Sunshine: <input type="text" name="sunshine" id="sunshine" placeholder="Sunshine"> <br>

                Cloud 3 PM: <input type="text" name="cloud3" id="cloud3" placeholder="Cloud 3 PM"> <br>

                <input type="submit" name="submit" value="Predict" style="width: 25%">
            </form>
        </div>


        <div class="predictResultDiv">
            <?php
                if(isset($_GET['resultToday'])){
                    if($_GET['resultToday'] == 1){
                        echo "
                        <h3>Weather for Today:</h3>
                        <h1>Raining</h1>
                        ";
                    }else if($_GET['resultToday'] == 0){
                        echo "
                        <h3>Weather for Today:</h3>
                        <h1>Sunny</h1>
                        ";                    
                    }
                }

                echo "<br>";

                if(isset($_GET['resultTomorrow'])){
                    if($_GET['resultTomorrow'] == 1){
                        echo "
                        <h3>Weather for Tomorrow:</h3>
                        <h1>Raining</h1>
                        ";
                    }else if($_GET['resultTomorrow'] == 0){
                        echo "
                        <h3>Weather for Tomorrow:</h3>
                        <h1>Sunny</h1>
                        ";                    
                    }
                }
            ?>
        </div>

    </div>
</body>
</html>

