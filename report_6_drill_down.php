<!--adapted from GT-Online Project-->
<!--by Team 010-->
<?php
include('lib/common.php');
include("lib/header.php");
?>
<title>View State with Highest Volume for each Category - Drill Down</title>
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
                            <td class="heading">Selected State</td>
                            <td class="heading">Category</td>
                            <td class="heading">Year-Month</td>
                        </tr>

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

                            $state = mysqli_real_escape_string($db, $_GET["selected_state"]);
                            $category = mysqli_real_escape_string($db, $_GET["category"]);
                            $yearmonth = mysqli_real_escape_string($db, $_GET["yearmonth"]);

                            print "<tr>";
                            print "<td>$state</td>";
                            print "<td>$category</td>";
                            print "<td>$yearmonth</td>";
                            print "</tr>";
                        }
                        ?>
                    </table>

                    <div class="subtitle">Store Details of <?php print "$state"?> in <?php print "$yearmonth"?></div>
                    <table>
                        <tr>
                            <td class="heading">Store ID</td>
                            <td class="heading">Address</td>
                            <td class="heading">City</td>
                            <td class="heading">Manager First Name</td>
                            <td class="heading">Manager Last Name</td>
                            <td class="heading">Manager Email</td>
                        </tr>

                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

                            //updated on 2019/4/8
//                            $query = "SELECT DISTINCT Store.store_id, Store.street_address, Store.city, Manager.first_name, Manager.last_name, Manager.email
//FROM Store
//INNER JOIN StoreManager ON Store.store_id = StoreManager.store_id
//INNER JOIN Manager on StoreManager.email = Manager.email
//INNER JOIN Transaction on Store.store_id = Transaction.store_id
//INNER JOIN ProductCategory on Transaction.product_id = ProductCategory.product_id
//WHERE Manager.status = \"A\" AND Store.state = '$state' AND ProductCategory.category = '$category' AND LEFT(Transaction.sold_date, 7) = '$yearmonth'";


                            $query = "SELECT DISTINCT Store.store_id, Store.street_address, Store.city, Manager.first_name, Manager.last_name, Manager.email
FROM Store
INNER JOIN StoreManager ON Store.store_id = StoreManager.store_id
INNER JOIN Manager on StoreManager.email = Manager.email
INNER JOIN Transaction on Store.store_id = Transaction.store_id
INNER JOIN ProductCategory on Transaction.product_id = ProductCategory.product_id
WHERE Manager.status = \"A\" AND Store.state = '$state' AND ProductCategory.category = '$category' AND Transaction.sold_date LIKE '$yearmonth%'
ORDER BY Store.store_id ASC";

                            $result = mysqli_query($db, $query);
                            include('lib/show_queries.php');

                            //updated on 2019/4/8
                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $store_id = $row['store_id'];
                                $street_address = $row['street_address'];
                                $city = $row['city'];
                                $first_name = $row['first_name'];
                                $last_name = $row['last_name'];
                                $email = $row['email'];

                                print "<tr>";
                                print "<td>$store_id</td>";
                                print "<td>$street_address</td>";
                                print "<td>$city</td>";
                                print "<td>$first_name</td>";
                                print "<td>$last_name</td>";
                                print "<td>$email</td>";
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