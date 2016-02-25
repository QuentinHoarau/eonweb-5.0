<?php
/*
#########################################
#
# Copyright (C) 2016 EyesOfNetwork Team
# DEV NAME : Jean-Philippe LEVY
# VERSION : 5.0
# APPLICATION : eonweb for eyesofnetwork project
#
# LICENCE :
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
#########################################
*/

include("header.php"); 

logging("logout","User logged out");
if(isset($_COOKIE["session_id"])) { 
	$sessid=$_COOKIE["session_id"]; 
	sqlrequest($database_eonweb,"DELETE FROM sessions where session_id='$sessid'");
}
setcookie("session_id",FALSE);
setcookie("user_name",FALSE);
setcookie("user_id",FALSE);
setcookie("user_limitation",FALSE);
setcookie("group_id",FALSE);
setcookie("nagvis_session",FALSE,0,"/nagvis");
setcookie("Cacti",FALSE);
setcookie("clickedFolder",FALSE);
setcookie("highlightedTreeviewLink",FALSE);

?>

<div class="container">
	<div class="row">
		<div class="img col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">
					<img class="img-responsive" src="images/logo.png" alt="logo eyesofnetwork">
				</div>
				<div class="panel-body">
					<div class="alert alert-info">
						<?php echo getLabel("label.message.logout.success"); ?>
					</div>
					<a class="btn btn-lg btn-success btn-block" href="login.php"><?php echo getLabel("action.connect"); ?></a>
				</div>
			</div>
		</div>
	</div>
</div>
		
<?php include("footer.php"); ?>
