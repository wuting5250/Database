<!--adapted from GT-Online Project-->
<!--by Team 010-->
<?php
include('lib/common.php');
include("lib/header.php");
?>
<title>View Revenue by Population</title>
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
                    <div class="subtitle">View Revenue by Population</div>
                    <table>
                        <tr>
                            <td class="heading">Year</td>
                            <td class="heading">Average Revenue of Small Cities</td>
                            <td class="heading">Average Revenue of Medium Cities</td>
                            <td class="heading">Average Revenue of Large Cities</td>
                            <td class="heading">Average Revenue of Extra Large Cities</td>
                        </tr>
                        <?php

                        //updated on 2019/4/14
                        $query = "SELECT YEAR(a.sold_date) AS year,
    ROUND(SUM(IF(c.city_population < 3700000, IF(d.sale_date IS NULL, e.retail_price, d.sale_price) * a.quantity, NULL))/(SELECT count(*) FROM cs6400_sp19_team010.City WHERE city_population < 3700000), 2) AS avg_small_city_revenue,
    ROUND(SUM(IF(c.city_population >= 3700000 AND c.city_population < 6700000, IF(d.sale_date IS NULL, e.retail_price, d.sale_price) * a.quantity, NULL))/(SELECT count(*) FROM cs6400_sp19_team010.City WHERE city_population >= 3700000 AND city_population < 6700000), 2) AS avg_medium_city_revenue,
    ROUND(SUM(IF(c.city_population >= 6700000 AND c.city_population < 9000000, IF(d.sale_date IS NULL, e.retail_price, d.sale_price) * a.quantity, NULL))/(SELECT count(*) FROM cs6400_sp19_team010.City WHERE city_population >= 6700000 AND city_population < 9000000), 2) AS avg_large_city_revenue,
    ROUND(SUM(IF(c.city_population > 9000000, IF(d.sale_date IS NULL, e.retail_price, d.sale_price) * a.quantity, NULL))/(SELECT count(*) FROM cs6400_sp19_team010.City WHERE city_population > 9000000), 2) AS avg_extra_large_city_revenue
FROM cs6400_sp19_team010.Transaction a
JOIN cs6400_sp19_team010.Store b ON a.store_id = b.store_id
JOIN cs6400_sp19_team010.City c ON b.city = c.city AND b.state = c.state
LEFT JOIN cs6400_sp19_team010.Sale d on a.sold_date = d.sale_date AND a.product_id = d.product_id
JOIN cs6400_sp19_team010.Product e on a.product_id = e.product_id
GROUP BY YEAR(a.sold_date)";

                        $result = mysqli_query($db, $query);
                        include('lib/show_queries.php');

                        //updated on 2019/4/8
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $year = $row['year'];
                            $small = $row['avg_small_city_revenue'];
                            $medium = $row['avg_medium_city_revenue'];
                            $large = $row['avg_large_city_revenue'];
                            $extra = $row['avg_extra_large_city_revenue'];

                            print "<tr>";
                            print "<td>$year</td>";
                            print "<td>$small</td>";
                            print "<td>$medium</td>";
                            print "<td>$large</td>";
                            print "<td>$extra</td>";
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