<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
<title>predict</title>

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
                        <td>Temperature</td>
                        <td>
                            <input type="text" name="temp" id="temp" placeholder="Temperature">
                        </td>
                    </tr>
                    <tr>
                        <td>Humidity</td>
                        <td>
                            <input type="text" name="humid" id="humid" placeholder="Humidity">
                        </td>
                    </tr>
                    <tr>
                        <td>Wind</td>
                        <td>
                            <input type="text" name="wind" id="wind" placeholder="Windy">
                        </td>
                    </tr>
                </table>
                <input type="submit" name="submit" value="Predict">
            </form>
        </fieldset>
    </form>
</body>
</html>
