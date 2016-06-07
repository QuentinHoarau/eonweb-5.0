<?php 
/*
#########################################
#
# Copyright (C) 2016 EyesOfNetwork Team
# DEV NAME : Quentin HOARAU
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

include("../../include/config.php");
include("../../include/arrays.php");
include("../../include/function.php"); 
include("ged_functions.php");

// create variables from $_GET
extract($_GET);

if(isset($action) && $action != "" && isset($selected_events) && count($selected_events) > 0){
	switch ($action) {
		case 'details':
			details($selected_events, $queue);
			break;
		case 'edit':
			edit($selected_events, $queue);
			break;
		case 'edit_event':
			editEvent($selected_events, $queue, $comments);
			break;
		case 'edit_all_event':
			editAllEvents($selected_events, $queue, $comments);
			break;
		case 'confirm':
			ownDisown($selected_events, $queue, $global_action);
			break;
	}
}
?>