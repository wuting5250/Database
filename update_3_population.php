<!--adapted from GT-Online Project-->
<!--by Team 010-->
<?php
include('lib/common.php');
include("lib/header.php");
?>


<title>Update City's Population</title>
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
                    <div class="subtitle">Update City's Population</div>
                    <form method='GET' action="update_3_population_change.php">
                        <table>
                            <tr>
                                <td class="item_label">City:</td>
                                <td>
                                    <input type="text" name="city_name" value=""/>
                                </td>
                            </tr>

                            <tr>
                                <td class="item_label">State:</td>
                                <td>
                                    <input type="text" name="city_state" value=""/>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <input type='submit' name='submit' value='Change Population'>
                                </td>
                            </tr>

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