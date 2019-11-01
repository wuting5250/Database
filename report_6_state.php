<!--adapted from GT-Online Project-->
<!--by Team 010-->

<?php
include('lib/common.php');
include("lib/header.php");
?>
<title>View State with Highest Volume for each Category</title>
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
                    <div class="subtitle">View State with Highest Volume for each Category</div>
                    <table>
                        <form method='POST' action="report_6_state.php">
                            <tr>
                                <td class="item_label">Year-Month to View</td>
                                <td>
                                    <select name="selected_yearmonth">
                                        <?php
                                        $query = "SELECT DISTINCT LEFT(Transaction.sold_date, 7) AS yearmonth FROM Transaction ORDER BY yearmonth ASC";
                                        $result = mysqli_query($db, $query);
                                        include('lib/show_queries.php');

                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                            $yearmonth = $row['yearmonth'];
                                            print "<option value=\"$yearmonth\">$yearmonth</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <input type='submit' name='submit' value='View Report'>
                                </td>
                            </tr>
                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $selected_yearmonth = $_POST["selected_yearmonth"];
                                print "<tr>";
                                print "<td class=\"item_label\">Chosen Year-Month: </td>";
                                print "<td class=\"heading-green\">$selected_yearmonth</td>";
                                print "</tr>";
                            }
                            ?>
                            <tr>
                                <td class="heading">Category</td>
                                <td class="heading">State with Highest Sold</td>
                                <td class="heading">Total Sold in State</td>
                                <td class="heading">Detail</td>
                            </tr>

                            <?php
                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                $selected_yearmonth = $_POST["selected_yearmonth"]; // can be used as input in query, LIKE "0000-00%"
//                                preg_match ("/^([0-9]{4})-([0-9]{2})$/", $selected_yearmonth, $parts);
//                                $year = $parts[1];
//                                $month = $parts[2];

//                                $query = "CREATE OR REPLACE VIEW totals AS \n"
//
//                                    . "SELECT c.category, b.state, SUM(a.quantity) as top_quantity_sold \n"
//
//                                    . "FROM Transaction a \n"
//
//                                    . "JOIN Store b on a.store_id = b.store_id\n"
//
//                                    . "JOIN ProductCategory c on a.product_id = c.product_id\n"
//
//                                    . "WHERE MONTH(a.sold_date) = $month AND YEAR(a.sold_date) = $year\n"
//
//                                    . "GROUP BY c.category, b.state";


                                //updated on 2019/4/8
                                // need to raise user privilege for 'gatechUser'@'localhost' in PHPMYADMIN
                                $query = "CREATE VIEW totals AS \n"

                                    . "SELECT c.category, b.state, SUM(a.quantity) as top_quantity_sold \n"

                                    . "FROM Transaction a \n"

                                    . "JOIN Store b on a.store_id = b.store_id\n"

                                    . "JOIN ProductCategory c on a.product_id = c.product_id\n"

                                    . "WHERE a.sold_date LIKE '$selected_yearmonth%'\n"

                                    . "GROUP BY c.category, b.state";

                                $result = mysqli_query($db, $query);
                                include('lib/show_queries.php');


                                $query =  "SELECT a.category, a.state, a.top_quantity_sold\n"

                                    . "FROM totals a\n"

                                    . "JOIN (SELECT category, MAX(top_quantity_sold) AS top_quantity_sold\n"

                                    . "FROM totals\n"

                                    . "GROUP BY category) b on a.category = b.category AND a.top_quantity_sold = b.top_quantity_sold\n"

                                    . "ORDER BY a.category ASC, a.state ASC";

                                $result = mysqli_query($db, $query);
                                include('lib/show_queries.php');

//                                /////////////debug/////////////
//                                $rowcount = mysqli_num_rows($result_select);
//                                echo "<tr>" . "<td>";
//                                printf("Total return in %d lines.", $rowcount);
//                                echo "</td>" . "<td>";
//                                echo "$result";
//                                echo "</td>" . "</tr>";
//                                /////////////debug/////////////

                                //updated on 2019/4/8
                                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                    $category = $row['category'];
                                    $state = $row['state'];
                                    $total_sold = $row['top_quantity_sold'];

                                    print "<tr>";
                                    print "<td>$category</td>";
                                    print "<td>$state</td>";
                                    print "<td>$total_sold</td>";
                                    print "<td> <a href=\"report_6_drill_down.php?selected_state=$state&category=$category&yearmonth=$selected_yearmonth\"> View </a> </td>";
                                    print "</tr>";
                                }

                                // drop the view
                                $query ="DROP VIEW totals";
                                $result = mysqli_query($db, $query);
                                include('lib/show_queries.php');

//                                //keep to debug drill down page
//                                print "<tr>";
//                                print "<td>debug category</td>";
//                                print "<td>debug state</td>";
//                                print "<td>debug sold</td>";
//                                print "<td> <a href=\"report_6_drill_down.php?selected_state=CT&category=CD&yearmonth=2001-10\"> View </a> </td>";
//                                print "</tr>";

                            }
                            ?>
                        </form>
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