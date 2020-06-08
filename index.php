<?php
include("includes/init.php");
$title = "Cornell Dairy Ice Cream";
?>

<!DOCTYPE html>
<html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Cornell Dairy Ice Cream</title>
        <link rel="stylesheet" type="text/css" href="styles/theme.css" media="all"/>
    </head>
    <body>

        <?php include("includes/header.php"); ?>

            <blockquote>
                <h2> About the Cornell Dairy </h2>
                <!-- Source: https://foodscience.cals.cornell.edu/cornell-dairy/ -->
                <p>The Cornell Dairy includes a licensed dairy processing plant. It supports dairy foods teaching, research and extension programs, processes milk from the Cornell dairy herd, and supplies dairy products to the campus.</p>
                Source: <cite><a href="https://foodscience.cals.cornell.edu/cornell-dairy/">Cornell Dairy</a></cite>
            </blockquote>

            <blockquote>
                <h2> Where To Get </h2>
                <ul>
                    <li><em>The Cornell Dairy, 180 Stocking Hall</em></li>
                    <li>North Star Dining Hall</li>
                    <li>Robert Purcell Community Center Dining Hall</li>
                    <li>All West Dorm Dining Halls</li>
                    <li>Okenshields Dining Hall</li>
                </ul>
            </blockquote>

        <?php include("includes/footer.php"); ?>
    </body>
</html>
