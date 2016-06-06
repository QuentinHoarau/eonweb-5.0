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

$(document).ready(function () {
	$('.tree-toggle').parent().children('ul.tree').hide();
	$('.tree-toggle').click(function () {
		$(this).parent().children('ul.tree').toggle(200);
	});
	$("[data-toggle=tooltip]").tooltip();

	$(document).keypress(function press_enter(e){
    	if(e.which == 13){
			e.preventDefault();
			findIt();
    	}
	});
});

$('#FindIt').on('click', findIt());

function findIt(){
	$('.tree-toggle').parent().children('ul.tree').show();
	$search_text = $('#SearchFor').val();
	$('.tree-toggle').jmRemoveHighlight();
    $('.tree-toggle').jmHighlight($search_text);
	var offset = $("ul:contains('" + $search_text +"')").offset();
	//var offset = $('ul[id^="' + $search_text +'"]').offset();
	console.log(offset);
	offset.left -= 20;
	offset.top -= 20;

	$('html, body').animate({
    	scrollTop: offset.top,
    	scrollLeft: offset.left
	});
}

var n = 0;

function ShowAll(){
	$('.tree-toggle').parent().children('ul.tree').show();
}

function HideAll(){
	$('.tree-toggle').parent().children('ul.tree').hide();
}

function AddingApplication(){
	$(location).attr('href',"./add_application.php");
}

function DeleteBP(bp){
    $('body').append('<div id="popup_confirmation" title="Suppression"></div>');
    $("#popup_confirmation").html('Supprimer le BP ' + bp);

    $("#popup_confirmation").dialog({
        autoOpen: false,
        width: 400,
        buttons: [
            {
                text: "Oui",
                click: function () {
                    $(this).dialog("close");
					$('div[id="' + bp + '"]').remove();

					$.get(
						'./php/function_bp.php',
						{
							action: 'delete_bp',
							bp_name: bp
						},
						function ReturnAction(){
								location.reload();
						}
					);
                }
            },
            {
                text: "Non",
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    }).dialog("open");
}

function ApplyConfiguration(){
	$('body').append('<div id="popup_confirmation" title="Suppression"></div>');
    $("#popup_confirmation").html("Appliquer la configuration ?");

    $("#popup_confirmation").dialog({
        autoOpen: false,
        width: 400,
        buttons: [
            {
                text: "Oui",
                click: function () {
                    $(this).dialog("close");
					$.get(
						'./php/function_bp.php',
						{
							action: 'build_file'
						},
						function ReturnValue(value){
							console.log(value);
						}
					);
                }
            },
            {
                text: "Non",
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    }).dialog("open");
}

function editApplication(bp_name){
	var url = "./add_application.php?bp_name=" + bp_name;
	$(location).attr('href',url);
}
