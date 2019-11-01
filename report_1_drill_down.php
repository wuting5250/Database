<!--adapted from GT-Online Project-->
<!--by Team 010-->
<?php
include('lib/common.php');
include("lib/header.php");
?>
<title>View Manufacturer’s Product Report - Drill Down</title>
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
                    <div class="subtitle">Summary from Parent Report</div>
                    <table>
                        <tr>
                            <td class="heading">Name</td>
                            <td class="heading">Maximum Discount</td>
                        </tr>

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

                            $manufacturer = mysqli_real_escape_string($db, $_GET["selected_manufacturer"]);

                            $query = "SELECT Manufacturer.max_discount " .
                                "FROM Manufacturer " .
                                "WHERE Manufacturer.manufacturer='$manufacturer' " .
                                "LIMIT 1";

                            $result = mysqli_query($db, $query);
                            include('lib/show_queries.php');

                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $max_discount = $row['max_discount'];
                                print "<tr>";
                                print "<td>$manufacturer</td>";
                                print "<td>$max_discount</td>";
                                print "</tr>";

                            }

                        }

                        ?>
                    </table>

                    <div class="subtitle">Product Summary</div>
                    <table>
                        <tr>
                            <td class="heading">Manufacturer</td>
                            <td class="heading">Product Count</td>
                            <td class="heading">Average Retail Price</td>
                            <td class="heading">Maximum Retail Price</td>
                            <td class="heading">Minimum Retail Price</td>
                        </tr>


                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

                            // data are passed from last page. no need to request database again.
                            $count = mysqli_real_escape_string($db, $_GET["count"]);
                            $avg = mysqli_real_escape_string($db, $_GET["avg"]);
                            $max = mysqli_real_escape_string($db, $_GET["max"]);
                            $min = mysqli_real_escape_string($db, $_GET["min"]);

                            print "<tr>";
                            print "<td>$manufacturer</td>";
                            print "<td>$count</td>";
                            print "<td>$avg</td>";
                            print "<td>$max</td>";
                            print "<td>$min</td>";
                            print "</tr>";

                        }
                        ?>
                    </table>

                    <div class="subtitle">Product Detail</div>
                    <table>
                        <tr>
                            <td class="heading">Product ID</td>
                            <td class="heading">Name</td>
                            <td class="heading">Categories</td>
                            <td class="heading">Price</td>
                        </tr>

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                            $manufacturer = mysqli_real_escape_string($db, $_GET["selected_manufacturer"]);

                            //updated on 2019/4/8
                            $query = "SELECT a.product_id, a.product_name, GROUP_CONCAT(b.category SEPARATOR ', ') AS categories, a.retail_price " .
                                "FROM Product a " .
                                "JOIN ProductCategory b on a.product_id = b.product_id " .
                                "WHERE a.manufacturer = '$manufacturer' " .
                                "GROUP BY a.product_id " .
                                "ORDER BY a.retail_price DESC";
                            ////////////////////////////////////////////////////////////////////////////////

                            $result = mysqli_query($db, $query);
                            include('lib/show_queries.php');

                            //updated on 2019/4/8
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $product_id = $row['product_id'];
                                $product_name = $row['product_name'];
                                $categories = $row['categories'];
                                $retail_price = $row['retail_price'];

                                print "<tr>";
                                print "<td>$product_id</td>";
                                print "<td>$product_name</td>";
                                print "<td>$categories</td>";
                                print "<td>$retail_price</td>";
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