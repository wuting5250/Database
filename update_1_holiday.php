<!--adapted from GT-Online Project-->
<!--by Team 010-->
<?php
include('lib/common.php');
include("lib/header.php");
?>


<title>View/Add Holiday</title>
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
                    <div class="subtitle">Add Holiday</div>
                    <form method='POST' action="update_1_holiday.php">
                        <table>

                            <tr>
                                <td class="item_label">Holiday Name:</td>
                                <td>
                                    <input type="text" name="holiday_name" value=""/>
                                </td>
                            </tr>
                            <tr>
                                <td class="item_label">Holiday Date:</td>
                                <td>
                                    <input type="text" name="holiday_date" value="" placeholder="2000-11-11"/>
                                </td>
                            </tr>
                            <tr>

                                <td>
                                    <input type='submit' name='submit' class="heading" value='Add Holiday'>
                                </td>
                            </tr>

                        </table>
                    </form>
                </div>

            </div>
        </div>
        <div class="center_right">
            <div class="title_name"></div>
            <div class="features">


                <div class="report_section">
                    <div class="subtitle">View Holidays</div>
                    <form method='POST' action="update_1_holiday.php">
                        <table>
                            <tr>
                                <td class="heading">Holiday Name</td>
                                <td class="heading">Holiday Date</td>

                            </tr>
                            <?php

                            function checkDateFormat($date)
                            {
                                if (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts)) {
                                    if (checkdate($parts[2], $parts[3], $parts[1])) {
                                        return true;
                                    } else {
                                        return false;
                                    }

                                } else {
                                    return false;
                                }

                            }

                            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                                $holiday_name = mysqli_real_escape_string($db, $_POST['holiday_name']);
                                $holiday_date = mysqli_real_escape_string($db, $_POST['holiday_date']);
                                $holiday_name_display = $_POST['holiday_name'];

                                $action = $_POST['submit'];

                                if ($action == 'Add Holiday') {

                                    if (empty($holiday_name) || empty($holiday_date)) {

                                        print "<tr>";
                                        print "<td class='heading-red'>Input cannot be empty. Please enter something.</td>";
                                        print "</tr>";

                                    } else {

                                        if (!checkDateFormat($holiday_date)) {

                                            print "<tr>";
                                            print "<td class='heading-red'>Invalid date format.</td>";
                                            print "</tr>";

                                        } else {

                                            //check if date existing.
                                            $query = "SELECT * From Holiday WHERE Holiday.holiday_date = '$holiday_date'";

                                            $result = mysqli_query($db, $query);
                                            include('lib/show_queries.php');

                                            if (mysqli_num_rows($result) > 0) {

                                                print "<tr>";
                                                print "<td class='heading-red'>Holiday date exists.</td>";
                                                print "</tr>";

                                                print "<tr>";
                                                print "<td class='heading-red'>Do you want to concatenate $holiday_name_display to $holiday_date?</td>";
                                                print "</tr>";

                                                print "<tr>";
                                                print "<td><input type='submit' name='submit' class=\"heading\" value='Confirm'>";
                                                print "<input type='submit' name='submit' class=\"heading\" value='Cancel'></td>";
                                                print "</tr>";


                                            } else {

                                                //insert new holiday
                                                $query = "INSERT INTO Holiday VALUES ('$holiday_date', '$holiday_name')";

                                                $result = mysqli_query($db, $query);
                                                include('lib/show_queries.php');

                                                print "<tr>";
                                                print "<td class='heading-green'>Holiday added.</td>";
                                                print "</tr>";

                                            }
                                        }
                                    }
                                } elseif ($action == 'Confirm') {

                                    // concatenate holiday_name to existing name
                                    $input_holiday_name_display = $_POST['input_holiday_name_display'];
                                    $input_holiday_name = $_POST['input_holiday_name'];
                                    $input_holiday_date = $_POST['input_holiday_date'];

                                    // check if input_holiday_name exists on input_holiday_date
                                    $query = "SELECT IF(LOWER(holiday_name) LIKE CONCAT('%',LOWER('$input_holiday_name'),'%'), 'YES', 'NO') as holiday_exists \n"

                                        . "FROM holiday \n"

                                        . "WHERE holiday_date = '$input_holiday_date'";

                                    $result = mysqli_query($db, $query);
                                    include('lib/show_queries.php');

                                    $is_existing = null;

                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

                                        if ($row['holiday_exists'] == 'YES') {
                                            $is_existing = true;
                                        } elseif($row['holiday_exists'] == 'NO') {
                                            $is_existing = false;
                                        }
                                    }

                                    if ($is_existing == true) {

                                        print "<tr>";
                                        print "<td class='heading-red'>$input_holiday_name_display on $input_holiday_date is already a holiday in current database. Cannot add it again.</td>";
                                        print "</tr>";

                                    } elseif ($is_existing == false ) {

                                        // query to concatenate holiday_name
                                        $query = "UPDATE holiday SET holiday_name = CONCAT(holiday_name,', $input_holiday_name') WHERE holiday_date= '$input_holiday_date'";
                                        $result = mysqli_query($db, $query);
                                        include('lib/show_queries.php');

                                        print "<tr>";
                                        print "<td class='heading-green'>$input_holiday_name_display is concatenated to $input_holiday_date.</td>";
                                        print "</tr>";
                                    }

                                } elseif ($action == 'Cancel') {
                                    print "<tr>";
                                    print "<td class='heading-green'>Add holiday canceled.</td>";
                                    print "</tr>";

                                }
                            }

                            $query = "SELECT holiday_name, holiday_date FROM Holiday";

                            $result = mysqli_query($db, $query);
                            include('lib/show_queries.php');

                            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                print "<tr>";
                                print "<td>{$row['holiday_name']}</td>";
                                print "<td>{$row['holiday_date']}</td>";
                                print "</tr>";
                            }
                            ?>

                            <input type="hidden" name="input_holiday_name"
                                   value="<?php print "$holiday_name" ?>"/>
                            <input type="hidden" name="input_holiday_date"
                                   value="<?php print "$holiday_date" ?>"/>
                            <input type="hidden" name="input_holiday_name_display"
                                   value="<?php print "$holiday_name_display" ?>"/>

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
