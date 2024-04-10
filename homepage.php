<?php include 'loginchecker.php';?>

<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8" />
    <title>Okanagan College Research</title>
    <script src='header.js'></script>
    <link rel='stylesheet' href='index.css'/>
</head>
<body onload='displayHeader()'>
    <div class='header' id='header' name='header'></div>
    <!---->
    <div class="homepage">
        <img src="img/OC_Tertiary_Logo_Black_RGB_Digital_1080px@72ppi.png" class="homeLogo" />
        <div class="home">
            <div class="links" id="links" name="links">
                <table class="homeBTNs">
                    <tr>
                        <td><a href="fundersList.php">Funders</a></td>
                        <td><a href="clientsList.php">Clients</a></td>
                    </tr>
                    <tr>
                        <td><a href="contractorsList.php">Contractors</a></td>
                        <td><a href="researchersList.php">Researchers</a></td>
                    </tr>
                    <tr>
                        <td><a href="projectList.php">Projects</a></td>
                        <td><a href="reports.php">Reports</a></td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td><a href="projectPosting.php" id="crBTN">Create</a></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</body>
</html>