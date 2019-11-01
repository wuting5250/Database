<!--adapted from GT-Online Project-->
<!--by Team 010-->
<?php
include('lib/common.php');
include("lib/header.php");
?>
<title>View/Edit Manager to Store</title>
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
                    <div class="subtitle">View/Edit Manager</div>

                    <form name="manager_form" action="" method="GET">
                        <table>
                            <tr>
                                <td class="item_label">Manager's Email:</td>
                                <td>
                                    <input type="text" name="manager_email" value="" placeholder="team010@gatech.edu"/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="button" class="heading" value="View Manager"
                                           onclick="manager_form.action='update_2_manager_view.php';manager_form.submit()">
                                </td>
                                <td>
                                    <input type="button" class="heading" value="Edit Manager"
                                           onclick="manager_form.action='update_2_manager_edit.php';manager_form.submit()">
                                </td>

                                <td>
                                    <input type="button" class="heading" value="Add Manager"
                                           onclick="manager_form.action='update_2_manager_add.php';manager_form.submit()">
                                </td>

                                <td>
                                    <input type="button" class="heading" value="Delete Manager"
                                           onclick="manager_form.action='update_2_manager_delete.php';manager_form.submit()">
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