<!--adapted from GT-Online Project-->
<!--by Team 010-->
<?php
include('lib/common.php');
include("lib/header.php");
?>
<title>View Air Conditioners on Groundhog Day</title>
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
                    <div class="subtitle">View Air Conditioners on Groundhog Day</div>
                    <table>
                        <tr>
                            <td class="heading">Year</td>
                            <td class="heading">Total Sold of AC</td>
                            <td class="heading">Average Sold per Day</td>
                            <td class="heading">Total Sold on Groundhog Day</td>
                        </tr>
                        <?php

                        // updated on 2019/4/14
                        $query = "SELECT c.year, c.total_AC_sold, ROUND(c.avg_AC_daily_sold) as avg_AC_daily_sold, d.AC_Groundhog_Day_sold
FROM
 (SELECT YEAR(a.sold_date) AS year, SUM(a.quantity) AS total_AC_sold, SUM(a.quantity)/365 AS avg_AC_daily_sold 
FROM Transaction a JOIN ProductCategory b ON a.product_id = b.product_id 
WHERE b.category = 'Air Conditioner'
GROUP BY year) c 
JOIN (SELECT YEAR(a.sold_date) AS year, SUM(a.quantity) AS AC_Groundhog_Day_sold 
FROM Transaction a
JOIN ProductCategory b ON a.product_id = b.product_id
WHERE MONTH(a.sold_date)=2 AND DAY(a.sold_date)=2 AND b.category = 'Air Conditioner'
GROUP BY year) d ON  c.year = d.year
ORDER BY c.year ASC";

                        $result = mysqli_query($db, $query);
                        include('lib/show_queries.php');

                        // updated on 2019/4/8
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            $year = $row['year'];
                            $total_ac_sold = $row['total_AC_sold'];
                            $avg_ac_daily_sold = $row['avg_AC_daily_sold'];
                            $ac_groundhog_day_sold = $row['AC_Groundhog_Day_sold'];

                            print "<tr>";
                            print "<td>$year</td>";
                            print "<td>$total_ac_sold</td>";
                            print "<td>$avg_ac_daily_sold</td>";
                            print "<td>$ac_groundhog_day_sold</td>";
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