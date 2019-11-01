<!--adapted from GT-Online Project-->
<!--by Team 010-->
<?php
include('lib/common.php');
include("lib/header.php");
?>
<title>View Category Report</title>
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
                    <div class="subtitle">View Category Report</div>
                    <table>
                        <tr>
                            <td class="heading">Category</td>
                            <td class="heading">Product Count</td>
                            <td class="heading">Manufacturer Count</td>
                            <td class="heading">Average Retail Price</td>
                        </tr>
                        <?php
                        // updated on 2019/4/14
                        $query = "SELECT ProductCategory.category AS category, count(ProductCategory.product_id) AS product_number, count(distinct Product.manufacturer) AS manufacturers, ROUND(avg(Product.retail_price), 2) AS avg_price 
FROM ProductCategory 
LEFT JOIN Product ON ProductCategory.product_id = Product.product_id 
GROUP BY ProductCategory.category 
ORDER BY ProductCategory.category ASC";

                        $result = mysqli_query($db, $query);
                        include('lib/show_queries.php');

                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            print "<tr>";
                            print "<td>{$row['category']}</td>";
                            print "<td>{$row['product_number']}</td>";
                            print "<td>{$row['manufacturers']}</td>";
                            print "<td>{$row['avg_price']}</td>";
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