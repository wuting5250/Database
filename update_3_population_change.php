<!--adapted from GT-Online Project-->
<!--by Team 010-->
<?php
include('lib/common.php');
include("lib/header.php");
?>

<title>Change Population</title>
</head>

<body>
<div id="main_container">
    <?php include("lib/menu.php"); ?>

    <div class="center_content">
        <div class="center_left">
            <div class="title_name">

            </div>
            <div class="features">

                <div class="full_section">
                    <form name="manager_edit" action="update_3_population_change.php" method="POST">
                        <div class="subtitle">Current Population</div>

                        <table>
                            <tr>
                                <td class="heading">City Name</td>
                                <td class="heading">City State</td>
                                <td class="heading">Current Population</td>
                            </tr>

                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'GET') {

                                $city_name = mysqli_real_escape_string($db, $_GET["city_name"]);
                                $city_state = mysqli_real_escape_string($db, $_GET["city_state"]);

                                if (empty($city_name) || empty($city_state)) {

                                    print "<tr>";
                                    print "<td class=\"heading-red\">City name or state can't be empty.  Please check your input.</td>";
                                    print "</tr>";

                                } else {

                                    // updated on 2019/4/8
                                    $query = "SELECT city_population " .
                                        "FROM City " .
                                        "WHERE City.city = '$city_name' and City.state = '$city_state'";

                                    $result = mysqli_query($db, $query);
                                    include('lib/show_queries.php');


                                    if (!is_bool($result) && (mysqli_num_rows($result) > 0)) {

                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                            $city_population = $row['city_population'];

                                            print "<tr>";
                                            print "<td>$city_name</td>";
                                            print "<td>$city_state</td>";
                                            print "<td>$city_population</td>";
                                            print "</tr>";

                                            print "<tr>";
                                            print "<td class=\"heading\">New Population</td>";
                                            print "</tr>";

                                            print "<tr>";
                                            print "<td><input type=\"text\" name=\"population_input\" value=\"\"/></td>";
                                            print "</tr>";

                                            print " <td > ";
                                            print " <input type = \"submit\" class=\"heading\" name=\"action\" value=\"Confirm\"/>";
                                            print " </td>";
                                            print " <td>";
                                            print " <input type=\"submit\" class=\"heading\" name=\"action\" value=\"Cancel\"/>";
                                            print " </td>";
                                            print " <td><p></p></td>";
                                            print " <td><p></p></td>";
                                            print " </tr>";

                                        }

                                    } else {
                                        print "<tr>";
                                        print "<td class=\"heading-red\">Can't find the city in database. Please check your input.</td>";
                                        print "</tr>";
                                    }
                                }
                            }
                            ?>

                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $action = $_POST['action'];
                                $city_name = mysqli_real_escape_string($db, $_POST["city_name"]);
                                $city_state = mysqli_real_escape_string($db, $_POST["city_state"]);
                                $new_population = mysqli_real_escape_string($db, $_POST["population_input"]);

                                // update population
                                if ($action == "Confirm") {

                                    if (empty($new_population) || !is_numeric($new_population) || ($new_population < 0)) {

                                        print "<tr>";
                                        print "<td class='heading-red'>Invalid input. New population should be a positive number.</td>";
                                        print "</tr>";

                                    } else {
                                        // query to update city population
                                        $query = "UPDATE City " .
                                            "SET city_population = '$new_population' " .
                                            "WHERE City.city = '$city_name' and City.state = '$city_state'";

                                        $result = mysqli_query($db, $query);
                                        include('lib/show_queries.php');

                                        print "<tr>";
                                        print "<td class='heading-green'>Population updated.</td>";
                                        print "</tr>";
                                    }

                                    // query display again to make sure
                                    $query = "SELECT city_population " .
                                        "FROM City " .
                                        "WHERE City.city = '$city_name' and City.state = '$city_state'";

                                    $result = mysqli_query($db, $query);
                                    include('lib/show_queries.php');

                                    if (!is_bool($result) && (mysqli_num_rows($result) > 0)) {

                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                            $city_population = $row['city_population'];

                                            print "<tr>";
                                            print "<td>$city_name</td>";
                                            print "<td>$city_state</td>";
                                            print "<td>$city_population</td>";
                                            print "</tr>";

                                        }
                                    }


                                } elseif ($action == "Cancel") {

                                    $city_name = mysqli_real_escape_string($db, $_POST["city_name"]);
                                    $city_state = mysqli_real_escape_string($db, $_POST["city_state"]);

                                    // cancel update but display again
                                    $query = "SELECT city_population " .
                                        "FROM City " .
                                        "WHERE City.city = '$city_name' and City.state = '$city_state'";

                                    $result = mysqli_query($db, $query);
                                    include('lib/show_queries.php');

                                    if (!is_bool($result) && (mysqli_num_rows($result) > 0)) {

                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                            $city_population = $row['city_population'];
                                            print "<tr>";
                                            print "<td>$city_name</td>";
                                            print "<td>$city_state</td>";
                                            print "<td>$city_population</td>";
                                            print "</tr>";

                                            print "<tr>";
                                            print "<td class='heading-green'>Population update canceled.</td>";
                                            print "</tr>";

                                        }
                                    }

                                }
                            }
                            ?>

                        </table>

                        <input type="hidden" name="city_name" value="<?php print "$city_name" ?>"/>
                        <input type="hidden" name="city_state" value="<?php print "$city_state" ?>"/>


                    </form>

                </div>

            </div>
        </div>


        <?php include("lib/error.php"); ?>

        <div class="clear"></div>
    </div>

    <?php include("lib/footer.php"); ?>

</div>
</body>
</html>
</html>