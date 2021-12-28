<!DOCTYPE html>
<?php
    session_start();
?>
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
    <form action="PredictController.php" method="get">
        <fieldset style="width:20%"  class="form1">
            <legend>Will it rain?</legend>
            <form>
                <table>
                    <tr>
                        <td>Rainfall</td>
                        <td>
                            <input type="text" name="rainfall" id="rainfall" placeholder="Rainfall">
                        </td>
                    </tr>
                    <tr>
                        <td>Humidity 3PM</td>
                        <td>
                            <input type="text" name="humid3" id="humid3" placeholder="Humidity 3 PM">
                        </td>
                    </tr>
                    <tr>
                        <td>Humidity 9AM</td>
                        <td>
                            <input type="text" name="humid9" id="humid9" placeholder="Humidity 9 AM">
                        </td>
                    </tr>
                </table>
                <input type="submit" name="submit" value="Predict">
            </form>
        </fieldset>
    </form>

    <?php
        if(isset($_SESSION['Today'])){
            if($_SESSION['Today'][0] == 1){
                echo "Hujan bro!";
            }
            else{
                echo "Ga hujan bro!";
            }
        }
    ?>
</body>
</html>