<!--adapted from GT-Online Project-->
<!--by Team 010-->
<?php
include('lib/common.php');
include("lib/header.php");
?>

<title>Delete Manager</title>
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
                    <form name="manager_edit" action="update_2_manager_delete.php" method="POST">
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
                                        $is_active = true;

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

                                            if ($status == 'I') {
                                                $is_active = false;
                                            }
                                        }

                                        if ($is_active == false) {
                                            // add confirmation
                                            print " <tr>";
                                            print " <td class=\"heading-green\">Manager details are shown above. Are you sure to delete this manager?</td>";
                                            print " </tr>";

                                            print " <tr> ";
                                            print " <td > ";
                                            print " <input type = \"submit\" class=\"heading\" name=\"action\" value=\"Confirm\"/>";
                                            print " </td>";
                                            print " <td>";
                                            print " <input type=\"submit\" class=\"heading\" name=\"action\" value=\"Cancel\"/>";
                                            print " </td>";

                                            print " <tr>";
                                            print " <td><p></p></td>";
                                            print " <td><p></p></td>";
                                            print " </tr>";
                                        } else {
                                            print " <tr>";
                                            print " <td class=\"heading-red\">Cannot delete an active manager. Please un-assign all stores first.</td>";
                                            print " </tr>";
                                        }


                                    } else {
                                        print "<tr>";
                                        print "<td class=\"heading-red\">Email address does not exist in current database. Not able to perform deletion.</td>";
                                        print "</tr>";
                                    }

                                }
                            }
                            ?>

                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $action = $_POST['action'];
                                $email = mysqli_real_escape_string($db, $_POST["manager_email"]);

                                // delete manager
                                if ($action == "Confirm") {

                                    if (!empty($email)) {

                                        // updated on 2019/4/10

                                        // check if manager is marked as active
                                        $query = "SELECT * FROM manager WHERE email = '$email' AND status = 'A'";

                                        $result = mysqli_query($db, $query);
                                        include('lib/show_queries.php');

                                        // still active
                                        if (!is_bool($result) && (mysqli_num_rows($result) > 0)) {

                                            print "<tr>";
                                            print "<td class='heading-red'>Manager '$email' is active. Cannot delete an active manager.</td>";
                                            print "</tr>";

                                        } // inactive then can delete
                                        else {
                                            $query = "DELETE FROM manager WHERE email = '$email'";
                                            $result = mysqli_query($db, $query);
                                            include('lib/show_queries.php');

                                            print "<tr>";
                                            print "<td class='heading-green'>Manager '$email' is deleted.</td>";
                                            print "</tr>";

                                        }

                                    }

                                } elseif ($action == "Cancel") {

                                    // display assign info again
                                    // updated on 2019/4/10
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

                                            print "<tr>";
                                            print "<td class='heading-green'>Manager deletion canceled.</td>";
                                            print "</tr>";
                                        }

                                    }

                                }

                            }
                            ?>
                            <input type="hidden" name="manager_email" value="<?php print "$email" ?>"/>

                        </table>
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