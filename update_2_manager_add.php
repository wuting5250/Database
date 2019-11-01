<!--adapted from GT-Online Project-->
<!--by Team 010-->
<?php
include('lib/common.php');
include("lib/header.php");
?>

<title>Add Manager</title>
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
                    <form name="manager_edit" action="update_2_manager_add.php" method="POST">
                        <div class="subtitle">Current Manager Detail</div>

                        <table>
                            <tr>
                                <td class="heading">Email</td>
                                <td class="heading">First Name</td>
                                <td class="heading">Last Name</td>
                                <td class="heading">Assigned Store ID</td>
                                <td class="heading">Status</td>
                            </tr>

                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'GET') {

                                $email = mysqli_real_escape_string($db, $_GET["manager_email"]);

                                if (empty($email)) {
                                    print "<tr>";
                                    print "<td class='heading-red'>Email address cannot be empty. Please check your input.</td>";
                                    print "</tr>";

                                } else {

                                    // updated on 2019/4/9
                                    $query = "SELECT\n"

                                        . "   Manager.email,\n"

                                        . "   Manager.first_name,\n"

                                        . "   Manager.last_name,\n"

                                        . "   Manager.status,\n"

                                        . "   Storemanager.store_id\n"

                                        . "FROM\n"

                                        . "    Manager\n"

                                        . "LEFT OUTER JOIN Storemanager ON Manager.email = Storemanager.email\n"

                                        . "WHERE manager.email = '$email'";


                                    $result = mysqli_query($db, $query);
                                    include('lib/show_queries.php');

                                    if (!is_bool($result) && (mysqli_num_rows($result) > 0)) {

                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                            $email = $row['email'];
                                            $first_name = $row['first_name'];
                                            $last_name = $row['last_name'];
                                            $status = $row['status'];
                                            $store_id = $row['store_id'];

                                            print "<tr>";
                                            print "<td>$email</td>";
                                            print "<td>$first_name</td>";
                                            print "<td>$last_name</td>";
                                            print "<td>$store_id</td>";
                                            print "<td>$status</td>";
                                            print "</tr>";

                                        }

                                        print "<tr>";
                                        print "<td class='heading-red'>'$email' exists in current database. \n Cannot add the same manager again. \n Please check your input.</td>";
                                        print "</tr>";

                                    } else {
                                        print "<tr>";
                                        print "<td class='heading-green'>Email address does not exist in current database. You can add '$email' as a new manager now.</td>";
                                        print "</tr>";

                                        // add inputs
                                        //echo "<div class=\"subtitle\">Add Manager Detail</div>";
                                        echo "<table>";
                                        echo "<tr><td class=\"heading\">First Name</td><td class=\"heading\">Last Name</td><td class=\"heading\">Assigned Store ID</td></tr>";
                                        echo "<tr><td><input type=\"text\" name=\"first_name_input\" value=\"\"/></td><td><input type=\"text\" name=\"last_name_input\" value=\"\"/></td><td><input type=\"text\" name=\"store_id_input\" value=\"\"/></td></tr>";
                                        echo "<tr><td><input type=\"submit\" class=\"heading\" name=\"action\" value=\"Add Manager\"/></td></tr>";
                                        echo "<tr><td><p></p></td><td><p></p></td></tr>";
                                        echo "<tr><td><p></p></td><td><p></p></td></tr>";

                                    }
                                }
                            }
                            ?>

                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $action = $_POST['action'];
                                $email = mysqli_real_escape_string($db, $_POST["manager_email"]);
                                $store_id = mysqli_real_escape_string($db, $_POST["store_id_input"]);
                                $last_name = mysqli_real_escape_string($db, $_POST["last_name_input"]);
                                $first_name = mysqli_real_escape_string($db, $_POST["first_name_input"]);

                                // edit store assignment
                                if ($action == "Add Manager") {

                                    // first_name and last_name cannot be empty
                                    if (!empty($first_name) && !empty($last_name)) {

                                        //print "<td>add</td>";
                                        // store_id_input is not empty
                                        if (!empty($email) && !empty($store_id)) {

                                            // if store_id_input is invalid.
                                            if (!is_numeric($store_id) || ($store_id > 1000) || ($store_id < 1)) {

                                                print "<tr>";
                                                print "<td class='heading-red'> Invalid store ID. Please check your input.</td>";
                                                print "</tr>";

                                            } else {

                                                // updated on 2019/4/9
                                                // insert into manager
                                                $query = "INSERT INTO Manager VALUES ('$email', '$first_name', '$last_name', 'A')";
                                                $result = mysqli_query($db, $query);
                                                include('lib/show_queries.php');

                                                // insert into storemanager
                                                $query = "INSERT INTO Storemanager VALUES ('$email', '$store_id')";
                                                $result = mysqli_query($db, $query);
                                                include('lib/show_queries.php');

                                                print "<tr>";
                                                print "<td class='heading-green'>Manager added.</td>";
                                                print "</tr>";
                                            }

                                        } // store_id_input is empty
                                        elseif (!empty($email) && empty($store_id)) {
                                            // updated on 2019/4/9
                                            // insert into manager
                                            $query = "INSERT INTO Manager VALUES ('$email', '$first_name', '$last_name', 'I')";
                                            $result = mysqli_query($db, $query);
                                            include('lib/show_queries.php');

                                            print "<tr>";
                                            print "<td class='heading-green'>Manager added.</td>";
                                            print "</tr>";
                                        }
                                    } //if first_name or last_name empty
                                    else {
                                        print "<tr>";
                                        print "<td class='heading-red'>Firstname or lastname cannot be empty. Please check your input.</td>";
                                        print "</tr>";
                                    }

                                }

                                // display assign info again

                                // updated on 2019/4/9
                                $query = "SELECT\n"

                                    . "   Manager.email,\n"

                                    . "   Manager.first_name,\n"

                                    . "   Manager.last_name,\n"

                                    . "   Manager.status,\n"

                                    . "   Storemanager.store_id\n"

                                    . "FROM\n"

                                    . "    Manager\n"

                                    . "LEFT OUTER JOIN Storemanager ON Manager.email = Storemanager.email\n"

                                    . "WHERE manager.email = '$email'";


                                $result = mysqli_query($db, $query);
                                include('lib/show_queries.php');

                                if (!is_bool($result) && (mysqli_num_rows($result) > 0)) {

                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                        $email = $row['email'];
                                        $first_name = $row['first_name'];
                                        $last_name = $row['last_name'];
                                        $status = $row['status'];
                                        $store_id = $row['store_id'];

                                        print "<tr>";
                                        print "<td>$email</td>";
                                        print "<td>$first_name</td>";
                                        print "<td>$last_name</td>";
                                        print "<td>$store_id</td>";
                                        print "<td>$status</td>";
                                        print "</tr>";
                                    }

                                }

                            }
                            ?>

                        </table>
                        <!---->
                        <!---->
                        <!--                        <div class="subtitle">Add Manager Detail</div>-->
                        <!---->
                        <!--                        <table>-->
                        <!---->
                        <!--                            <tr>-->
                        <!--                                <td class="heading">First Name</td>-->
                        <!--                                <td class="heading">Last Name</td>-->
                        <!--                                <td class="heading">Assigned Store ID</td>-->
                        <!--                            </tr>-->
                        <!---->
                        <!--                            <tr>-->
                        <!--                                -->
                        <!--                                <td><input type="text" name="first_name_input" value=""/></td>-->
                        <!--                                <td><input type="text" name="last_name_input" value=""/></td>-->
                        <!--                                <td><input type="text" name="store_id_input" value=""/></td>-->
                        <!--                            </tr>-->
                        <!---->
                        <!--                            <tr>-->
                        <!---->
                        <!--                                <td>-->
                        <!--                                    <input type="submit" class="heading" name="action" value="Add Manager"/>-->
                        <!--                                </td>-->
                        <!--                            </tr>-->
                        <!---->
                        <!--                            <tr>-->
                        <!--                                <td><p></p></td>-->
                        <!--                                <td><p></p></td>-->
                        <!--                            </tr>-->
                        <!---->
                        <!--                            <tr>-->
                        <!--                                <td><p></p></td>-->
                        <!--                                <td><p></p></td>-->
                        <!--                            </tr>-->
                        <!---->
                        <!--                        </table>-->
                        <input type="hidden" name="manager_email" value="<?php print "$email" ?>"/>

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