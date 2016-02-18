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
