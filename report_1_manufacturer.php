<!--adapted from GT-Online Project-->
<!--by Team 010-->
<?php
include('lib/common.php');
include("lib/header.php");
?>
<title>View Manufacturer’s Product Report</title>
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
                    <div class="subtitle">View Manufacturer’s Product Report</div>
                    <form method='post' action="report_1_drill_down.php">
                    <table>
                        <tr>
                            <td class="heading">Manufacturer</td>
                            <td class="heading">Product Count</td>
                            <td class="heading">Average Retail Price</td>
                            <td class="heading">Maximum Retail Price</td>
                            <td class="heading">Minimum Retail Price</td>
                            <td class="heading">Detail</td>
                        </tr>

                        <?php
                        // updated on 2019/4/14
                        $query = "SELECT Product.manufacturer, COUNT(Product.product_id) AS product_count, ROUND(AVG(Product.retail_price), 2) AS avg_price, MAX(Product.retail_price) AS max_price,
MIN(Product.retail_price) AS min_price 
FROM cs6400_sp19_team010.Product
GROUP BY Product.manufacturer
ORDER BY avg_price DESC LIMIT 100";

                        $result = mysqli_query($db, $query);
                        include('lib/show_queries.php');

                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $manufacturer = $row['manufacturer'];
                            $count = $row['product_count'];
                            $avg = $row['avg_price'];
                            $max = $row['max_price'];
                            $min = $row['min_price'];
                            print "<tr>";
                            print "<td>$manufacturer</td>";
                            print "<td>$count</td>";
                            print "<td>$avg</td>";
                            print "<td>$max</td>";
                            print "<td>$min</td>";
                            print "<td> <a href=\"report_1_drill_down.php?selected_manufacturer=$manufacturer&count=$count&avg=$avg&max=$max&min=$min\">View</a> </td>";
                            print "</tr>";
                        }
                        ?>
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