<?php
/*
#########################################
#
# Copyright (C) 2016 EyesOfNetwork Team
# DEV NAME : Michael Aubertin
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

include("../../header.php");
include("../../side.php");
?>

<div id="page-wrapper">

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo getLabel("label.admin_bp.title"); ?></h1>
		</div>
	</div>

	<?php
	global $database_nagios;
	global $database_host;
	global $database_username;
	global $database_password;

	$t_bp_racine = array();

	function display_bp($bp,$bp_racine) {
		
		global $database_nagios;
		global $database_host;
		global $database_username;
		global $database_password;
		$db = new mysqli($database_host, $database_username, $database_password, $database_nagios);

		if($db->connect_errno > 0){
			die('Unable to connect to database [' . $db->connect_error . ']');
		}

		$rule_type = "";
		$desc_bp = "";
		$min_value = "";
		$priority = "";

		$sql_type = "
		SELECT type, description, min_value , priority
		FROM bp 
		WHERE name='".$bp."'
		";

		if(!$result_type = $db->query($sql_type)){
			die('There was an error running the query [' . $db->error . ']');
		}

		while($row = $result_type->fetch_assoc()){   
			$rule_type = $row['type'];
			$desc_bp = $row['description'];
			$min_value = $row['min_value'];
			$priority = $row['priority'];
		} 

		if($min_value > 0) {
			$min_value = " ".$min_value;
		}

		$result_type->free();
		mysqli_close($db);

		print "\n";
		print "<label class=\"tree-toggle nav-header glyphicon-link glyphicon\" id=\"$desc_bp\"><font size=\"3\" color=\"black\">\n";
		print "<font size=\"1\" color=\"#262635\"> Display:".$priority."</font> <b class=\"condition_presentation\">".$rule_type.$min_value."</b> ".$bp."</font>&nbsp;&nbsp;\n";
		//if($priority == 0){
		print "<a href=\"add_services.php?bp_name=$bp&display=$priority\"><img src=\"./images/add_list.png\" height=\"18\" width=\"18\"></a>&nbsp;\n";
		print "<font size=\"2\" color=\"#262635\">(".$desc_bp.")</font></label>&nbsp;\n";
		//print "<a class=\"img-hover\" onclick=\"DeleteBP('$bp');\"><img src=\"./images/link_delete.png\" height=\"25\" width=\"25\"></a>&nbsp;\n";
		print "<button type=\"button\" class=\"btn-group light-round btn-info marge-left\" onclick=\"editApplication('$bp');\"><span class=\"glyphicon glyphicon-pencil\"></span></button>";
		print "<button type=\"button\" class=\"light-round btn-group btn-danger\" onclick=\"DeleteBP('$bp');\"><span class=\"glyphicon glyphicon-trash\"></span></button>";
		echo "\n";
	}

	function display_service($host_service,$bp_racine)
	{
		$service_name = split(";", $host_service);
		$service_name = strtolower($service_name[1]);

		print "\n";
		print "<ul id=\"$bp_racine::$host_service\"><label class=\"tree-toggle nav-header glyphicon glyphicon-eye-open\"> ".$host_service;

		print "</label></ul>";
		print "\n";
	}

	function display_son($bp_racine)
	{

		global $database_nagios;
		global $database_host;
		global $database_username;
		global $database_password;
		$db = new mysqli($database_host, $database_username, $database_password, $database_nagios);

		if($db->connect_errno > 0){
			die('Unable to connect to database [' . $db->connect_error . ']');
		}

		$t_bp_son = array();
		$t_service_son = array();

		$sql_bp = "
		SELECT bp_link 
		FROM bp_links 
		WHERE bp_name = '".$bp_racine."'
		";

		$sql_service = "
		SELECT host,service 
		FROM bp_services 
		WHERE bp_name = '".$bp_racine."'  ORDER BY id
		";

		if(!$result_bp = $db->query($sql_bp)){
			die('There was an error running the query [' . $db->error . ']');
		}

		while($row = $result_bp->fetch_assoc()){   
			array_push($t_bp_son,$row['bp_link']);
		} 

		$result_bp->free();

		if(!$result_service = $db->query($sql_service)){
			die('There was an error running the query [' . $db->error . ']');
		}

		while($row = $result_service->fetch_assoc()){   
			array_push($t_service_son,$row['host'].";".$row['service']);
		}
		$result_service->free();
		mysqli_close($db);

		if(sizeof($t_bp_son) > 0 ) {
			for ($i = 0; $i < sizeof($t_bp_son); $i++) {
				echo "<ul class=\"nav nav-list tree\">";
				echo "\n";
				display_bp($t_bp_son[$i],$bp_racine);
				display_son($t_bp_son[$i]);
				echo "</ul>";
				echo "\n";
			}
		}
		if(sizeof($t_service_son) > 0 ) {
			for ($i = 0; $i < sizeof($t_service_son); $i++) {
				echo "<li>";
				display_service($t_service_son[$i],$bp_racine);
				echo "</li>\n";
			}
		}
	}

	$HTMLTREE ="";
	$db = new mysqli($database_host, $database_username, $database_password, $database_nagios);

	if($db->connect_errno > 0){
		die('Unable to connect to database [' . $db->connect_error . ']');
	}

	$sql = "
	  SELECT name 
	  FROM bp  
	  WHERE name 
	  NOT IN (SELECT bp_link FROM bp_links) 
	  ORDER BY priority
	";

	if(!$result = $db->query($sql)){
		die('There was an error running the query [' . $db->error . ']');
	}
	while($row = $result->fetch_assoc()){   
		array_push($t_bp_racine,$row['name']);
	} 

	$result->free();
	mysqli_close($db);

	?>
    
	<form class="form-vertical">
		<div class="row" style="padding-top:20px;padding-left:15px;">
			<div class="col-xs-4">
				<div class="input-group">
					<span class="input-group-btn">
						<button class="btn btn-info" type="button" onclick="ShowAll();">Show All</button>
						<button class="btn btn-info" type="button" onclick="HideAll();">Hide All</button>
					</span>
					<input type="text" class="form-control" id="SearchFor" placeholder="Search for...">
					<span class="input-group-btn">
						<button class="btn btn-info" id="FindIt" type="button">Find it!</button>
					</span>
				</div><!-- /input-group -->
			</div>

			<div class="col-xs-4">		                   
				<button type="button" class="btn btn-success btn-block" onclick="AddingApplication();">
					<span class="glyphicon glyphicon-plus" style="color:#4f4;"></span>
					Add new application
				</button>
			</div>
			<div class="col-xs-4">
				<button type="button" class="btn btn-danger btn-block" onclick="ApplyConfiguration();">
					<span class="glyphicon glyphicon-plus" style="color:#4f4;"></span>
					Apply Configuration
				</button>
			</div> 
		</div>

		<div id="body" class="pad-top">
		<?php 
			for ($i = 0; $i < sizeof($t_bp_racine); $i++) {
				echo "<div class=\"well well-sm\" id=\"$t_bp_racine[$i]\">";
					echo "<ul class=\"nav nav-list tree\">";
						display_bp($t_bp_racine[$i],$t_bp_racine[$i]);
						display_son($t_bp_racine[$i]);
					echo "</ul>";
				echo "</div>";
			}
		?>
		</div>
	</form>

<?php include("../../footer.php"); ?>
