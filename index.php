<!--adapted from GT-Online Project-->
<!--by Team 010-->
<?php
include('lib/common.php');
include("lib/header.php");
?>
<title>S&E Data Warehouse Dashboard</title>
</head>

<body>
<div id="main_container">
    <?php include("lib/menu.php"); ?>

    <div class="center_content">
        <div class="center_left">
            <div class="title_name">

            </div>
            <div class="features">

                <div class="profile_section">
                    <div class="subtitle">Display Statistics</div>
                    <table>
                        <tr>
                            <td class="item_label">Stores:</td>
                            <td>
                                <?php
                                // query updated on 2019/4/8
                                $query = "SELECT COUNT(store_id) AS store_count from Store";
                                $result = mysqli_query($db, $query);

                                include('lib/show_queries.php');

//                                if (is_bool($result) && (mysqli_num_rows($result) == 0)) {
//                                    array_push($error_msg, "Query ERROR: Failed to get Store Stats..." . __FILE__ . " line:" . __LINE__);
//                                }

                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                    print $row['store_count'];
                                }
                                ?>
                            </td>

                        </tr>
                        <tr>
                            <td class="item_label">Manufactures:</td>
                            <td>
                                <?php
                                // query updated on 2019/4/8
                                $query = "SELECT COUNT(manufacturer) AS manufacturer_count FROM Manufacturer";
                                $result = mysqli_query($db, $query);

                                include('lib/show_queries.php');

//                                if (is_bool($result) && (mysqli_num_rows($result) == 0)) {
//                                    array_push($error_msg, "Query ERROR: Failed to get Store Stats..." . __FILE__ . " line:" . __LINE__);
//                                }

                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                    print $row['manufacturer_count'];
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="item_label">Products:</td>
                            <td>
                                <?php
                                // query updated on 2019/4/8
                                $query = "SELECT COUNT(product_id) AS product_count FROM Product";
                                $result = mysqli_query($db, $query);

                                include('lib/show_queries.php');

//                                if (is_bool($result) && (mysqli_num_rows($result) == 0)) {
//                                    array_push($error_msg, "Query ERROR: Failed to get Store Stats..." . __FILE__ . " line:" . __LINE__);
//                                }

                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                    print $row['product_count'];
                                }
                                ?>
                            </td>
                        </tr>

                        <tr>
                            <td class="item_label">Managers:</td>
                            <td>
                                <?php
                                // query updated on 2019/4/8
                                $query = "SELECT COUNT(email) AS email_count FROM Manager";
                                $result = mysqli_query($db, $query);

                                include('lib/show_queries.php');

//                                if (is_bool($result) && (mysqli_num_rows($result) == 0)) {
//                                    array_push($error_msg, "Query ERROR: Failed to get Store Stats..." . __FILE__ . " line:" . __LINE__);
//                                }

                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                    print $row['email_count'];
                                }
                                ?>
                            </td>
                        </tr>


                    </table>
                </div>

                <div class="profile_section">
                    <div class="subtitle">Maintainance</div>
                    <table>
                        <table>
                        <tr>
                            <input type="button" class="heading" value="View/Add Holiday"
                                   onclick="window.location.href='update_1_holiday.php'">
                        </tr>
                        <br>
                        <tr>
                            <input type="button" class="heading" value="View/Edit Manager to Store"
                                   onclick="window.location.href='update_2_manager.php'">
                        </tr>
                        <br>
                        <tr>
                            <input type="button" class="heading" value="Update City's Population"
                                   onclick="window.location.href='update_3_population.php'">
                        </tr>

                    </table>
                    </table>
                </div>

            </div>
        </div>
        <div class="center_right">
            <div class="title_name">

            </div>
            <div class="features">


                <div class="report_section">
                    <div class="subtitle">View Reports</div>
                    <table>
                    <table>
                        <tr>
                            <input type="button" class="heading" value="1.View Manufacturer’s Product Report"
                                   onclick="window.location.href='report_1_manufacturer.php'">
                        </tr>
                        <br>
                        <tr>
                            <input type="button" class="heading" value="2.View Category Report"
                                   onclick="window.location.href='report_2_category.php'">
                        </tr>
                        <br>
                        <tr>
                            <input type="button" class="heading" value="3.View Actual vs Predicted Revenue for GPS units"
                                   onclick="window.location.href='report_3_gps.php'">
                        </tr>
                        <br>
                        <tr>
                            <input type="button" class="heading" value="4.View Store Revenue by Year by State"
                                   onclick="window.location.href='report_4_store_revenue.php'">
                        </tr>
                        <br>
                        <tr>
                            <input type="button" class="heading" value="5.View Air Conditioners on Groundhog Day"
                                   onclick="window.location.href='report_5_ac.php'">
                        </tr>
                        <br>
                        <tr>
                            <input type="button" class="heading" value="6.View State with Highest Volume for each Category"
                                   onclick="window.location.href='report_6_state.php'">
                        </tr>
                        <br>
                        <tr>
                            <input type="button" class="heading" value="7.View Revenue by Population"
                                   onclick="window.location.href='report_7_revenue_population.php'">
                        </tr>
                        <br>

                    </table>
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