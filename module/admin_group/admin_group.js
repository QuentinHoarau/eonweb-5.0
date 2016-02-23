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

$(document).ready(function() {
	$("#group_location").autocomplete({
		source: "search.php?request=search_group",
		minLength: 3
	});
});

function disable(){
	if(document.form_group.group_name.disabled){
		document.form_group.group_name.disabled=false;
		document.form_group.group_location.disabled=true;
	}
	else{
		document.form_group.group_name.disabled=true;
		document.form_group.group_location.disabled=false;
	}
}
