<!--adapted from GT-Online Project-->
<!--by Team 010-->
<?php
include('lib/common.php');
include("lib/header.php");
?>
<title>View Actual vs Predicted Revenue for GPS units</title>
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
                    <div class="subtitle">View Actual vs Predicted Revenue for GPS units</div>
                    <table>
                        <tr>
                            <td class="heading">Product ID</td>
                            <td class="heading">Product Name</td>
                            <td class="heading">Retail Price</td>
                            <td class="heading">Total Sold Quantity</td>
                            <td class="heading">Total Sold Quantity at Discount</td>
                            <td class="heading">Total Sold Quantity at Retail Price</td>
                            <td class="heading">Actual Revenue</td>
                            <td class="heading">Predicted Revenue</td>
                            <td class="heading">Revenue Difference between Actual and Predicted</td>
                        </tr>
                        <?php

                        //updated on 2019/4/8
                        $query = "SELECT product_id, product_name, retail_price, SUM(quantity) AS total_quantity_sold, 
SUM(IF(on_sale = 1, quantity, 0)) AS quantity_sold_at_discount,
SUM(IF(on_sale = 0, quantity, 0)) AS quantity_sold_at_retail,
ROUND(SUM(IF(on_sale = 1, actual_price, 0) * quantity), 2) AS total_discount_revenue,
ROUND(SUM(IF(on_sale = 0, retail_price, 0) * quantity), 2) AS total_retail_revenue,
ROUND(SUM(actual_price * quantity), 2) AS actual_revenue,
ROUND(SUM(IF(on_sale = 0, quantity, quantity * 0.75) * retail_price), 2) AS predicted_revenue,
ROUND(SUM(actual_price * quantity - IF(on_sale = 0, quantity, quantity * 0.75) * retail_price), 2) AS revenue_difference
FROM (SELECT a.product_id, a.product_name, c.quantity, IF(d.sale_date IS NULL, 0, 1) AS on_sale, a.retail_price,
IF(d.sale_date IS NULL, a.retail_price, d.sale_price) AS actual_price 
FROM Product a
JOIN Manufacturer b on a.manufacturer = b.manufacturer
JOIN Transaction c on a.product_id = c.product_id
LEFT JOIN Sale d on c.product_id = d.product_id AND c.sold_date = d.sale_date
JOIN ProductCategory e on a.product_id = e.product_id
WHERE e.category = \"GPS\") all_rows
GROUP BY product_id
HAVING ABS(revenue_difference) > 5000
ORDER BY revenue_difference DESC";

                        $result = mysqli_query($db, $query);
                        include('lib/show_queries.php');

                        // updated on 2019/4/8
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $product_id = $row['product_id'];
                            $product_name = $row['product_name'];
                            $retail_price = $row['retail_price'];
                            $total_quantity_sold = $row['total_quantity_sold'];
                            $quantity_sold_at_discount = $row['quantity_sold_at_discount'];
                            $quantity_sold_at_retail = $row['quantity_sold_at_retail'];
                            $actual_revenue = $row['actual_revenue'];
                            $predicted_revenue = $row['predicted_revenue'];
                            $revenue_difference = $row['revenue_difference'];

                            print "<tr>";
                            print "<td>$product_id</td>";
                            print "<td>$product_name</td>";
                            print "<td>$retail_price</td>";
                            print "<td>$total_quantity_sold</td>";
                            print "<td>$quantity_sold_at_discount</td>";
                            print "<td>$quantity_sold_at_retail</td>";
                            print "<td>$actual_revenue</td>";
                            print "<td>$predicted_revenue</td>";
                            print "<td>$revenue_difference</td>";
                            print "</tr>";
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