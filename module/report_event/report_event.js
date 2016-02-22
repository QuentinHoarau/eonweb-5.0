/*
#########################################
#
# Copyright (C) 2016 EyesOfNetwork Team
# DEV NAME : Quentin HOARAU
# VERSION 5.0
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

/* ~~~~~~~~~~~~~~~~~~~~ NORMAL GRAPH ~~~~~~~~~~~~~~~~~~~~ */
/**
 * Will display the graph for normal reports
 *
 * @params graph_type	(String)	-> The type of the graph (pie or bar)
 * @params id_html		(String)	-> The html tag's id
 * @params file			(String)	-> The file which define graph's infos (legends, ect...)
 * @params start_date	(timestamp) -> The begin of the report time range
 * @params end_date		(timestamp) -> The end of the report time range
 * @params event_state	(String) 	-> The state of events (active or history)
 * @params filter_field	(String)	-> The name of the field we want to filter
 * @params filter_value	(String)	-> The value of the field we have filtered
 * @params special		(String)	-> Is this a special graph(for legends) ??
 */
function getGraph(graph_type, id_html, file, start_date, end_date, event_state, filter_field, filter_value, special)
{
	$.ajax({
		url: "report.php",
		cache: false,
		data: {
			"file": file,
			"start_date": start_date,
			"end_date": end_date,
			"event_state": event_state,
			"filter_field": filter_field,
			"filter_value": filter_value
		},
		dataType: "JSON",
		success: function(response){
			var length = 0;
			for(i in response){ length++; }
			if(length > 1)
			{
				if(graph_type == "pie"){ drawPieChart(id_html, response); }
				else{
					if(special == "yes"){ drawBarChartHistory(id_html, response); }
					else{ drawBarChart(id_html, response); }
				}
			}
			else
			{
				$('#'+id_html).append("<h2 style=\"text-align:center;vertical-align:middle;display:inline-block;margin-top:200px;\">No data to display ...</h2>");
			}
		},
		error: function(){ }
	});
}

/**
 * Draw the pie chart with selected title, values, in a HTML target
 *
 * @param div_id (String)	-> The HTML target's id
 * @param datas	 (Json)		-> Chart's values in a json array, that's the Ajax response
 */
function drawPieChart(div_id, datas)
{
	//alert(graph_color.warning);
	$('#'+div_id).highcharts({
		chart: {
			backgroundColor: 'rgba(255, 255, 255, 0.01)',
			plotShadow: false,
			width: 430,
			height: 350
		},
		exporting: {
			enabled: false
		},
		credits: {
			enabled: false
		},
		title: {
			text: null
		},
		tooltip: {
			pointFormat: '{series.name} : <b>{point.percentage:.1f}%</b>'
		},
		plotOptions: {
			pie: {
				size: 170,
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b> : {point.y:.0f}',
					style: {
						color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
					}
				}
			},
			connectorColor: 'silver'
		},
		series: [{
			type: 'pie',
			name: 'Value',
			data: [
				{
					name: 'WARNING',
					y: datas.warning,
					color: {
						radialGradient: { cx: 0.5, cy: 0.5, r: 0.8 },
						stops: [
							[0, graph_color.warning],
							[1, Highcharts.Color(graph_color.warning).brighten(-0.3).get('rgb')] // darken
						]
					}
				},
				{
					name: 'CRITICAL',
					y: datas.critical,
					color: {
						radialGradient: { cx: 0.5, cy: 0.5, r: 0.8 },
						stops: [
							[0, graph_color.critical],
							[1, Highcharts.Color(graph_color.critical).brighten(-0.3).get('rgb')] // darken
						]
					}
				},
				{
					name: 'UNKNOWN',
					y: datas.unknown,
					color: {
						radialGradient: { cx: 0.5, cy: 0.5, r: 0.8 },
						stops: [
							[0, graph_color.unknown],
							[1, Highcharts.Color(graph_color.unknown).brighten(-0.3).get('rgb')] // darken
						]
					}
				}
			]
		}]
	})
}

/**
 * Draw the column chart with selected title, values, in a HTML target
 *
 * @param div_id (String)	-> The HTML target's id
 * @param datas  (Json)		-> Chart's values in a json array, that's the Ajax response
 */
function drawBarChart(div_id, datas, queue)
{
	// define categories for xAxis
	var categories = ['0 ~ 5min','5 ~ 15min','15 ~ 30min','30min ~ 1h','more'];
	if(queue == "history")
	{
		categories = ['day','week','month','year','more'];
	}
	
	$('#'+div_id).highcharts({
		chart: {
			type: 'column',
			backgroundColor: 'rgba(255, 255, 255, 0.01)',
			plotShadow: false,
			width: 400,
			height: 350
		},
		exporting: {
			enabled: false
		},
		credits: {
			enabled: false
		},
		title: {
			text: null
		},
		xAxis: {
			title: {
				text: false
			},
			categories: categories,
			label: {
				overflow: 'justify'
			}
		},
		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {
				text: false
			}
		},
		tooltip: {
			headerFormat: '<span style="font-size:10px">{point.key}</span><table style="min-width: 150px;">',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
			'<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
		series: [{
			name: 'WARNING',
			data: [datas[0].warning, datas[1].warning, datas[2].warning, datas[3].warning, datas[4].warning],
			color: graph_color.warning
		}, {
			name: 'CRITICAL',
			data: [datas[0].critical, datas[1].critical, datas[2].critical, datas[3].critical, datas[4].critical],
			color: graph_color.critical
		}, {
			name: 'UNKNOWN',
			data: [datas[0].unknown, datas[1].unknown, datas[2].unknown, datas[3].unknown, datas[4].unknown],
			color: graph_color.unknown
		}]
	});
}



/* ~~~~~~~~~~~~~~~~~~~~ SLA GRAPH ~~~~~~~~~~~~~~~~~~~~ */
/**
 * Will display the graph for sla reports
 *
 * @params graph_type	(String)	-> The type of the graph (pie or bar)
 * @params id_html		(String)	-> The html tag's id
 * @params file			(String)	-> The file which define graph's infos (legends, ect...)
 * @params start_date	(timestamp)	-> The begin of the report time range
 * @params end_date		(timestamp)	-> The end of the report time range
 * @params event_state	(String)	-> The state of events (active or history)
 * @params filter_field	(String)	-> The name of the field we want to filter
 * @params filter_value	(String)	-> The value of the field we have filtered
 */
function getSlaGraph(graph_type, id_html, file, start_date, end_date, event_state, filter_field, filter_value)
{
	$.ajax({
		url: "report.php",
		cache: false,
		data: {
			"file": file,
			"start_date": start_date,
			"end_date": end_date,
			"event_state": event_state,
			"filter_field": filter_field,
			"filter_value": filter_value
		},
		dataType: "JSON",
		success: function(response){
			var length = 0;
			for(i in response){ length++; }
			if(length > 1)
			{
				if(graph_type == "pie"){ drawSlaPieChart(id_html, response); }
				else{ drawSlaBarChart(id_html, response); }
			}
			else
			{
				$('#'+id_html).append("<h2 style=\"text-align:center;vertical-align:middle;display:inline-block;margin-top:200px;\">No data to display ...</h2>");
			}
		},
		error: function(){ }
	});
}

/**
 * Draw the pie chart with selected title, values, in a HTML target
 *
 * @param div_id (String)	-> The HTML target's id
 * @param datas  (Json)		-> Chart's values in a json array, that's the Ajax response
 */
function drawSlaPieChart(div_id, datas)
{
	$('#'+div_id).highcharts({
		chart: {
			backgroundColor: 'rgba(255, 255, 255, 0.01)',
			plotShadow: false,
			width: 430,
			height: 350
		},
		exporting: {
			enabled: false
		},
		credits: {
			enabled: false
		},
		title: {
			text: null
		},
		tooltip: {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		},
		plotOptions: {
			pie: {
				size: 170,
				dataLabels: {
					enabled: true,
					format: '<b>{point.name}</b>: {point.y:.0f}',
					style: {
						color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
					}
				}
			},
			connectorColor: 'silver'
		},
		series: [{
			type: 'pie',
			name: 'Value',
			data: [
				{
					name: '0-5min',
					y: datas["0-5min"],
					color: {
						radialGradient: { cx: 0.5, cy: 0.5, r: 0.8 },
						stops: [
							[0, '#00CC33'],
							[1, Highcharts.Color('#00CC33').brighten(-0.3).get('rgb')] // darken
						]
					}
				},
				{
					name: '5-10min',
					y: datas["5-10min"],
					color: {
						radialGradient: { cx: 0.5, cy: 0.5, r: 0.8 },
						stops: [
							[0, '#FFA500'],
							[1, Highcharts.Color('#FFA500').brighten(-0.3).get('rgb')] // darken
						]
					}
				},
				{
					name: '10-20min',
					y: datas["10-20min"],
					color: {
						radialGradient: { cx: 0.5, cy: 0.5, r: 0.8 },
						stops: [
							[0, '#CC77C6'],
							[1, Highcharts.Color('#CC77C6').brighten(-0.3).get('rgb')] // darken
						]
					}
				},
				{
					name: '>=20min',
					y: datas[">=20min"],
					color: {
						radialGradient: { cx: 0.5, cy: 0.5, r: 0.8 },
						stops: [
							[0, '#FF3300'],
							[1, Highcharts.Color('#FF3300').brighten(-0.3).get('rgb')] // darken
						]
					}
				}
			]
		}]
	})
}

/**
 * Draw the column chart for history events
 *
 * @param div_id (String)	-> The HTML target's id
 * @param datas  (Json)		-> Chart's values in a json array, that's the Ajax response
 */
function drawSlaBarChart(div_id, datas)
{
	$('#'+div_id).highcharts({
		chart: {
			type: 'column',
			backgroundColor: 'rgba(255, 255, 255, 0.01)',
			plotShadow: false,
			width: 400,
			height: 350
		},
		exporting: {
			enabled: false
		},
		credits: {
			enabled: false
		},
		title: {
			text: null
		},
		xAxis: {
			title: {
				text: 'Plage Horaire'
			},
			categories: [
				'day',
				'week',
				'month',
				'year',
				'more'
			],
			label: {
				overflow: 'justify'
			}
		},
		yAxis: {
			allowDecimals: false,
			min: 0,
			title: {
				text: 'Nbr Events'
			}
		},
		tooltip: {
			headerFormat: '<span style="font-size:10px">{point.key}</span><table style="min-width: 150px;">',
			pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
			'<td style="padding:0"><b>{point.y:.0f}</b></td></tr>',
			footerFormat: '</table>',
			shared: true,
			useHTML: true
		},
		plotOptions: {
			column: {
				pointPadding: 0.2,
				borderWidth: 0
			}
		},
		series: [{
			name: '0-5min',
			data: [datas["0-5min"].day, datas["0-5min"].week, datas["0-5min"].month, datas["0-5min"].year, datas["0-5min"].more],
			color: '#00CC33'
		}, {
			name: '5-10min',
			data: [datas["5-10min"].day, datas["5-10min"].week, datas["5-10min"].month, datas["5-10min"].year, datas["5-10min"].more],
			color: '#FFA500'
		}, {
			name: '10-20min',
			data: [datas["10-20min"].day, datas["10-20min"].week, datas["10-20min"].month, datas["10-20min"].year, datas["10-20min"].more],
			color: '#CC77C6'
		}, {
			name: '>20min',
			data: [datas[">20min"].day, datas[">20min"].week, datas[">20min"].month, datas[">20min"].year, datas[">20min"].more],
			color: '#FF3300'
		}]
	});
}


$("#report-form").on('submit', function(event){
	event.preventDefault();
	
	var type = $("#type").val();
	var field = $("#field").val();
	var field_value = $("#value").val();
	
	var by_day = "";
	var by_week = "";
	var by_month = "";
	var by_year = "";
	
	//alert($("#by_day").is(':checked'));
	if($("#by_day").is(':checked')){
		by_day = $("#by_day").val();
	}
	if($("#by_week").is(':checked')){
		by_week = $("#by_week").val();
	}
	if($("#by_month").is(':checked')){
		by_month = $("#by_month").val();
	}
	if($("#by_year").is(':checked')){
		by_year = $("#by_year").val();
	}
	
	//alert("AJAX !!!");
	$.ajax({
		url: 'graph.php',
		type: 'POST',
		data: {
			type: type,
			field: field,
			'value': field_value,
			by_day: by_day,
			by_week: by_week,
			by_month: by_month,
			by_year: by_year,
			display: "Display"
		},
		success: function(response){
			$("#result").html(response);
		},
		error: function(){
			
		}
	});
	//$("#result").html("on a fait un AJAX");	
});