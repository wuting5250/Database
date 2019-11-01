<!--adapted from GT-Online Project-->
<!--by Team 010-->
<?php
include('lib/common.php');
include("lib/header.php");
?>
<title>View Manager</title>
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
                    <div class="subtitle">View Manager Detail</div>
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

                                } else {
                                    print "<tr>";
                                    print "<td class='heading-red'>Email address does not exist in current database. Please check your input.</td>";
                                    print "</tr>";
                                }

                            }
                        }

                        ?>
                    </table>

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