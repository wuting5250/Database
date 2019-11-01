<!--adapted from GT-Online Project-->
<!--by Team 010-->

<?php
include('lib/common.php');
include("lib/header.php");
?>
<title>View Store Revenue by Year by State</title>
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
                    <div class="subtitle">View Store Revenue by Year by State</div>
                    <table>
                        <tr>
                            <form method='POST' action="report_4_store_revenue.php">
                                <td class="item_label">State to View</td>
                                <td>
                                    <select name="select_state">
                                        <?php
                                        $query = "SELECT DISTINCT state FROM city ORDER BY state ASC";

                                        $result = mysqli_query($db, $query);
                                        include('lib/show_queries.php');

                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                            $state = $row['state'];
                                            print "<option value=\"$state\">$state</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <input type='submit' name='submit' value='View Report'>
                                </td>
                            </form>
                        </tr>

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            $selected_state = $_POST["select_state"];
                            print "<tr>";
                            print "<td class=\"item_label\">Chosen State: </td>";
                            print "<td class=\"heading-green\">$selected_state</td>";
                            print "</tr>";
                        }
                        ?>
                        <tr>
                            <td class="heading">State</td>
                            <td class="heading">Store ID</td>
                            <td class="heading">Store Address</td>
                            <td class="heading">City Name</td>
                            <td class="heading">Sales Year</td>
                            <td class="heading">Total Revenue</td>
                        </tr>

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            $selected_state = $_POST["select_state"];

                            // updated on 2019/4/8
                            $query = "SELECT c.store_id, c.street_address, c.city, YEAR(b.sold_date) as revenue_year,
SUM(IF(d.sale_date IS NULL, a.retail_price, d.sale_price) * b.quantity) as total_revenue
FROM Product a
JOIN Transaction b on a.product_id = b.product_id
JOIN Store c on b.store_id = c.store_id
LEFT JOIN Sale d on b.product_id = d.product_id
WHERE c.state = '$selected_state'
GROUP BY b.store_id, YEAR(b.sold_date)
ORDER BY revenue_year ASC, total_revenue DESC";

                            $result = mysqli_query($db, $query);
                            include('lib/show_queries.php');

                            // updated on 2019/4/8
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $store_id = $row['store_id'];
                                $street_address = $row['street_address'];
                                $city = $row['city'];
                                $sale_year = $row['revenue_year'];
                                $total_revenue = $row['total_revenue'];

                                print "<tr>";
                                print "<td>$selected_state</td>";
                                print "<td>$store_id</td>";
                                print "<td>$street_address</td>";
                                print "<td>$city</td>";
                                print "<td>$sale_year</td>";
                                print "<td>$total_revenue</td>";
                                print "</tr>";
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