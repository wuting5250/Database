
			<div id="header">
                <div class="logo"><img src="img/logo.png" style="opacity:0.6;background-color:E9E5E2;" border="0" alt="" title="Logo"/></div>
			</div>

			<div class="nav_bar">
				<ul>
                    <li><a href="index.php" <?php if($current_filename=='index.php') echo "class='active'"; ?>>Dashboard</a></li>
<!--                    --><?php //if((strpos($current_filename, 'drill_down') > 0) ||(strpos($current_filename, 'manager_') > 0)) print "<li><a href=\"javascript:;\" onClick=\"javascript:history.back(-1);\">Back</a></li>"; ?>
<!--                    --><?php //if(strpos($current_filename, 'update_2_manager_') === True ) print "<li><a href=\"update_2_manager.php\">Update Manager</a></li>"; ?>
<!--                    --><?php //if($current_filename != 'index.php') print "<li><a href=\"javascript:;\" onClick=\"javascript:history.back(-1);\">Back</a></li>"; ?>

				</ul>
			</div>
