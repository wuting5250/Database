<!--adapted from GT-Online Project-->
<!--by Team 010-->
<?php
include('lib/common.php');
include("lib/header.php");
?>

<title>Edit Manager</title>
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
                    <form name="manager_edit" action="update_2_manager_edit.php" method="POST">
                        <div class="subtitle">Current Manager Detail</div>

                        <table>
                            <tr>
                                <td class="heading">Manager Email</td>
                                <td class="heading">Manager First Name</td>
                                <td class="heading">Manager Last Name</td>
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

                                    //updated on 2019/4/9
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

                                        //echo "<div class=\"subtitle\">Assign / Unassign to Store</div>";
                                        echo "<table>";
                                        echo "<tr><td class=\"heading\">Store ID to edit</td><td><input type=\"text\" name=\"store_id_input\" value=\"\" /></td></tr>";
                                        echo " <tr><td><p></p></td><td><input type=\"submit\" class=\"heading\" name=\"action\" value=\"Add Store\"/><input type=\"submit\" class=\"heading\" name=\"action\" value=\"Delete Store\"/></td></tr>";
                                        echo "<tr><td><p></p></td><td><p></p></td></tr>";
                                        echo "<tr><td><p></p></td><td><p></p></td></tr>";
                                        echo "</table>";

                                    } else {

                                        print "<tr>";
                                        print "<td class='heading-red'>Email address does not exist in current database. Please check your input.</td>";
                                        print "</tr>";
                                    }

                                }
                            }
                            ?>

                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $action = $_POST['action'];
                                $email = mysqli_real_escape_string($db, $_POST["manager_email"]);
                                $store_id = mysqli_real_escape_string($db, $_POST["store_id_input"]);

                                //check if store_id is numeric and <= 1000
                                if (!is_numeric($store_id) || ($store_id > 1000) || ($store_id < 1)) {
                                    print "<tr>";
                                    print "<td class='heading-red'> Invalid store ID. Please check your input.</td>";
                                    print "</tr>";

                                } else {

                                    // edit store assignment
                                    if ($action == "Add Store") {
                                        //print "<td>add</td>";
                                        if (!empty($email) && !empty($store_id)) {

                                            //check if this assignment exists
                                            $query = "SELECT * From Storemanager WHERE email = '$email' AND store_id = '$store_id'";

                                            $result = mysqli_query($db, $query);
                                            include('lib/show_queries.php');

                                            // if exist cannot add
                                            if (!is_bool($result) && (mysqli_num_rows($result) > 0)) {

                                                print "<tr>";
                                                print "<td class='heading-red'>Store '$store_id' is already assigned to '$email' in current database. Cannot assign again.</td>";
                                                print "</tr>";

                                                // no exist, can add
                                            } else {

                                                $query = "INSERT INTO StoreManager VALUES ('$email', '$store_id')";

                                                $result = mysqli_query($db, $query);
                                                include('lib/show_queries.php');

                                                print "<tr>";
                                                print "<td class='heading-green'>Store '$store_id' assignment added</td>";
                                                print "</tr>";

                                                // check if manager is marked as inactive after this assignment
                                                $query = "SELECT * From Manager WHERE email = '$email' AND status = 'I'";

                                                $result = mysqli_query($db, $query);
                                                include('lib/show_queries.php');

                                                // if inactive then change to active
                                                if (!is_bool($result) && (mysqli_num_rows($result) > 0)) {
                                                    $query = "UPDATE Manager SET status = 'A' WHERE email = '$email'";
                                                    $result = mysqli_query($db, $query);
                                                    include('lib/show_queries.php');

                                                    print "<tr>";
                                                    print "<td class='heading-green'>The manager is marked as active.</td>";
                                                    print "</tr>";
                                                }

                                            }

                                        }

                                    } elseif ($action == "Delete Store") {
                                        //print "<td>del</td>";
                                        if (!empty($email) && !empty($store_id)) {

                                            //check if this assignment exists
                                            $query = "SELECT * From Storemanager WHERE email = '$email' AND store_id = '$store_id'";

                                            $result = mysqli_query($db, $query);
                                            include('lib/show_queries.php');

                                            // if exits then can delete.
                                            if (!is_bool($result) && (mysqli_num_rows($result) > 0)) {

                                                //to delete the assignment
                                                $query = "DELETE FROM StoreManager WHERE store_id = '$store_id' AND email = '$email' ";

                                                $result = mysqli_query($db, $query);
                                                include('lib/show_queries.php');

                                                print "<tr>";
                                                print "<td class='heading-green'>Store '$store_id' assignment deleted.</td>";
                                                print "</tr>";

                                                // check if this manager is active/inactive
                                                $query = "SELECT * FROM Storemanager WHERE email = '$email'";
                                                $result = mysqli_query($db, $query);
                                                include('lib/show_queries.php');

                                                // manager not assigned to other store, is inactive, then need to mark as "I"
                                                if (is_bool($result) || (mysqli_num_rows($result) == 0)) {
                                                    $query = "UPDATE Manager SET status = 'I' WHERE email = '$email'";
                                                    $result = mysqli_query($db, $query);
                                                    include('lib/show_queries.php');

                                                    print "<tr>";
                                                    print "<td class='heading-green'>The manager is marked as inactive.</td>";
                                                    print "</tr>";
                                                }

                                            } // not exist, cannot delete
                                            else {

                                                print "<tr>";
                                                print "<td class='heading-red'>Store assignment does not exist in current database. Not able to perform deletion. Please check your input.</td>";
                                                print "</tr>";

                                            }
                                        }
                                    }
                                }


                                // display assign info again after edition

                                //updated on 2019/4/10
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

                                    echo "<div class=\"subtitle\">Assign / Unassign to Store</div>";
                                    echo "<table>";
                                    echo "<tr><td class=\"heading\">Store ID to edit</td><td><input type=\"text\" name=\"store_id_input\" value=\"\" /></td></tr>";
                                    echo " <tr><td><p></p></td><td><input type=\"submit\" class=\"heading\" name=\"action\" value=\"Add Store\"/><input type=\"submit\" class=\"heading\" name=\"action\" value=\"Delete Store\"/></td></tr>";
                                    echo "<tr><td><p></p></td><td><p></p></td></tr>";
                                    echo "<tr><td><p></p></td><td><p></p></td></tr>";
                                    echo "</table>";

                                } else {
                                    print "<tr>";
                                    print "<td class='heading-red'>Email address does not exist in current database. Please check your input.</td>";
                                    print "</tr>";
                                }
                            }
                            ?>

                        </table>

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