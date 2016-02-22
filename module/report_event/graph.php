<?php
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

include("../../include/config.php");
include("../../include/function.php");
include("../../include/Translator.class.php");

$t = new Translator();
$dictionnary = $t::createPHPDictionnary();

$array_states = array(
	1 => "warning",
	2 => "critical",
	3 => "unknown"
);
/* ~~~~~~~~~~ FUNCTIONS DECLARATION ~~~~~~~~~~ */
/**
 * Define ged time intervals according to the queue
 *
 * @return $intervals -> Array (assoc) of time intervals
 */
function getIntervals($queue)
{
	if($queue == "active")
	{
		$intervals = array(
			"day" => time() - 60*5,
			"week" => time() - 60*15,
			"month" => time() - 60*30,
			"year" => time() - 60*60,
		);
	}
	else{
		$intervals = array(
			"day" => time() - 86400,
			"week" => time() - 86400*7,
			"month" => time() - 86400*30,
			"year" => time() - 86400*365,
		);
	}
	return $intervals;
}

function pieChart($queue, $field, $search, $period)
{
	// all external variables we need
	global $database_ged;
	global $array_states;
	
	// define time_intervals
	$time_intervals = getIntervals($queue);
	extract($time_intervals);
	
	$array_result = array();
	$sql = "SELECT pkt_type_name FROM pkt_type WHERE pkt_type_id!='0' AND pkt_type_id<'100'";
	$pkt_result = sqlrequest($database_ged, $sql);
	
	// set the search clause (according to field and value)
	$search_clause = "";
	if( isset($search) && $search != "" )
	{
		$search_clause = " AND $field LIKE '%$search%'";
	}
	
	// set the period clause (according to checkboxes checked)
	$period_clause = "";
	if( isset($period) && $period != "" )
	{
		switch($period)
		{
			case "day": $period_clause = " AND o_sec >= $day"; break;
			case "week": $period_clause = " AND o_sec >= $week AND o_sec < $day"; break;
			case "month": $period_clause = " AND o_sec >= $month AND o_sec < $week"; break;
			case "year": $period_clause = " AND o_sec >= $year AND o_sec < $month"; break;
		}
	}
	
	while( $pkt = mysqli_fetch_row($pkt_result) )
	{
		foreach($array_states as $key => $state)
		{
			$sql = "SELECT count(id) FROM ".$pkt[0]."_queue_".$queue." WHERE state=".$key." AND queue='".substr($queue{0},0,1)."'";
			$sql .= $search_clause;
			$sql .= $period_clause;
			
			$result = sqlrequest($database_ged, $sql);
			$result = mysqli_fetch_row($result);
			$array_result["$state"] += $result[0];
		}
	}
	return json_encode($array_result);
}

function barChart($queue, $field, $search)
{
	global $database_ged;
	global $array_states;
	
	// define time_intervals
	$time_intervals = getIntervals($queue);
	extract($time_intervals);
	
	$sql = "SELECT pkt_type_name FROM pkt_type WHERE pkt_type_id!='0' AND pkt_type_id<'100'";
	$pkt_result = sqlrequest($database_ged, $sql);
	
	$array_result = array();
	$array_now_day = array();
	$array_day_week = array();
	$array_week_month = array();
	$array_month_year = array();
	$array_year_more = array();
	
	// set the search clause (according to field and value)
	$search_clause = "";
	if( isset($search) && $search != "" )
	{
		$search_clause = " AND $field LIKE '%$search%'";
	}
	
	while( $pkt = mysqli_fetch_row($pkt_result) )
	{
		foreach($array_states as $key => $state)
		{
			$sql = "
				SELECT count(id) FROM ".$pkt[0]."_queue_".$queue." WHERE state=".$key." AND queue='".substr($queue{0},0,1)."' AND o_sec >= $day".$search_clause.
				" UNION ALL
				SELECT count(id) FROM ".$pkt[0]."_queue_".$queue." WHERE state=".$key." AND queue='".substr($queue{0},0,1)."' AND o_sec >= $week AND o_sec < $day".$search_clause.
				" UNION ALL
				SELECT count(id) FROM ".$pkt[0]."_queue_".$queue." WHERE state=".$key." AND queue='".substr($queue{0},0,1)."' AND o_sec >= $month AND o_sec < $week".$search_clause.
				" UNION ALL
				SELECT count(id) FROM ".$pkt[0]."_queue_".$queue." WHERE state=".$key." AND queue='".substr($queue{0},0,1)."' AND o_sec >= $year AND o_sec < $month".$search_clause.
				" UNION ALL
				SELECT count(id) FROM ".$pkt[0]."_queue_".$queue." WHERE state=".$key." AND queue='".substr($queue{0},0,1)."' AND o_sec < $year".$search_clause;
			$result = sqlrequest($database_ged, $sql);
			
			$cpt = 0;
			while( $row = mysqli_fetch_row($result) )
			{
				switch($cpt)
				{
					case 0: $array_now_day["$state"] += $row[0]; break;
					case 1: $array_day_week["$state"] += $row[0]; break;
					case 2: $array_week_month["$state"] += $row[0]; break;
					case 3: $array_month_year["$state"] += $row[0]; break;
					case 4: $array_year_more["$state"] += $row[0]; break;
				}
				$cpt++;
			}
		}
	}
	array_push($array_result, $array_now_day);
	array_push($array_result, $array_day_week);
	array_push($array_result, $array_week_month);
	array_push($array_result, $array_month_year);
	array_push($array_result, $array_year_more);
	
	return json_encode($array_result);
}
/* ~~~~~~~~~~ END OF FUNCTIONS DECLARATION ~~~~~~~~~~ */

# --- If Display
if(isset($_POST["display"])) {
	// define $type
	$type = $_POST["type"];
	
	# --- Search filters
	if(isset($_POST["value"])){
		if($_POST["value"]!=""){
			$myfilter["field"]=$_POST["field"];
			$myfilter["value"]=$_POST["value"];
			echo "<h2>".$myfilter["field"]." : ".$myfilter["value"]."</h2><br>";
		}
		else
			$myfilter=false;
	}
	else
	$myfilter=false;

	# --- If Display
	if(isset($_POST["display"])) {
		// search fields results
		$field = $_POST["field"];
		$value = $_POST["value"];
		
		# --- Display reports
		if($type!="") {
			echo "<h1>".getLabel("label.report_event.sla")."</h1>";
			echo "<script type=\"text/javascript\">getSlaGraph('pie', 'sla_pie', 'report_history_events_pie_sla.xml','','','history', '".$_POST["field"]."', '".$_POST["value"]."');</script>";
			echo "<script type=\"text/javascript\">getSlaGraph('bar', 'sla_bar', 'report_history_events_bar_sla.xml','','','history', '".$_POST["field"]."', '".$_POST["value"]."');</script>";
			echo "<div style=\"margin-bottom:50px; text-align: center;\">";
			echo "<center id=\"sla_pie\" style=\"vertical-align:top;min-width: 350px; height: 300px; max-width: 450px; display: inline-block;margin-right:100px;\"></center>";
			echo "<center id=\"sla_bar\" style=\"min-width: 350px; height: 300px; max-width: 450px; display: inline-block;\"></center>";
			echo "</div>";
			echo "<br><br>";

			if(isset($_POST["by_day"])) {
				echo "<h1>".getLabel("label.report_event.day")."</h1>";
				echo "<i>".date("d/m/Y H:i:s",strtotime("- 1 day"))." - ".date("d/m/Y H:i:s",time())."</i>";
				echo "<script type=\"text/javascript\">getSlaGraph('pie', 'sla_pie_day', 'report_history_events_pie_sla.xml',".strtotime("- 1 day").",".time().",'history', '".$_POST["field"]."', '".$_POST["value"]."');</script>";
				echo "<div style=\"margin-bottom:50px;text-align:center;\">";
				echo "<center id=\"sla_pie_day\" style=\"vertical-align:top;min-width: 350px; height: 300px; max-width: 450px; display: inline-block;margin-right:100px;\"></center>";
				echo "</div>";
				echo "<br><br>";
			}

			if(isset($_POST["by_week"])) {
				echo "<h1>".getLabel("label.report_event.week")."</h1>";
				echo "<i>".date("d/m/Y H:i:s",strtotime("- 1 week"))." - ".date("d/m/Y H:i:s",time())."</i>";
				echo "<script type=\"text/javascript\">getSlaGraph('pie', 'sla_pie_week', 'report_history_events_pie_sla.xml',".strtotime("- 1 week").",".time().",'history', '".$_POST["field"]."', '".$_POST["value"]."');</script>";
				echo "<div style=\"margin-bottom:50px;text-align:center;\">";
				echo "<center id=\"sla_pie_week\" style=\"vertical-align:top;min-width: 350px; height: 300px; max-width: 450px; display: inline-block;margin-right:100px;\"></center>";
				echo "</div>";
				echo "<br><br>";
			}
			if(isset($_POST["by_month"])) {
				echo "<h1>".getLabel("label.report_event.month")."</h1>";
				echo "<i>".date("d/m/Y H:i:s",strtotime("- 1 month"))." - ".date("d/m/Y H:i:s",time())."</i>";
				echo "<script type=\"text/javascript\">getSlaGraph('pie', 'sla_pie_month', 'report_history_events_pie_sla.xml',".strtotime("- 1 month").",".time().",'history', '".$_POST["field"]."', '".$_POST["value"]."');</script>";
				echo "<div style=\"margin-bottom:50px;text-align:center;\">";
				echo "<center id=\"sla_pie_month\" style=\"vertical-align:top;min-width: 350px; height: 300px; max-width: 450px; display: inline-block;margin-right:100px;\"></center>";
				echo "</div>";
				echo "<br><br>";
			}

			if(isset($_POST["by_year"])) {
				echo "<h1>".getLabel("label.report_event.year")."</h1>";
				echo "<i>".date("d/m/Y H:i:s",strtotime("- 1 year"))." - ".date("d/m/Y H:i:s",time())."</i>";
				echo "<script type=\"text/javascript\">getSlaGraph('pie', 'sla_pie_year', 'report_history_events_pie_sla.xml',".strtotime("- 1 year").",".time().",'history', '".$_POST["field"]."', '".$_POST["value"]."');</script>";
				echo "<div style=\"margin-bottom:50px;text-align:center;\">";
				echo "<center id=\"sla_pie_year\" style=\"vertical-align:top;min-width: 350px; height: 300px; max-width: 450px; display: inline-block;margin-right:100px;\"></center>";
				echo "</div>";
				echo "<br><br>";
			}
		}
		else {
			// normal active graphs (pie and bar)
			echo "<h2>".getLabel("label.report_event.act_event")."</h2>";
			$pie_infos = pieChart("active", $field, $value, "");
			$bar_infos = barChart("active", $field, $value);
			echo '
				<div class="row">
					<div class="col-md-6 text-center" id="active_pie"></div>
					<div class="col-md-6 text-center" id="active_bar"></div>
				</div>';
			echo "<script>drawPieChart('active_pie', $pie_infos)</script>";
			echo "<script>drawBarChart('active_bar', $bar_infos, 'active')</script>";
			
			// normal history graphs (pie and bar)
			echo "<h1>".getLabel("label.report_event.his_event")."</h1>";
			$pie_infos = pieChart("history", $field, $value, "");
			$bar_infos = barChart("history", $field, $value);
			echo '
				<div class="row">
					<div class="col-md-6 text-center" id="history_pie"></div>
					<div class="col-md-6 text-center" id="history_bar"></div>
				</div>';
			echo "<script>drawPieChart('history_pie', $pie_infos)</script>";
			echo "<script>drawBarChart('history_bar', $bar_infos, 'history')</script>";
			
			echo '<div class="row">';
			// normal "by_day" graph
			if( isset($_POST["by_day"]) && $_POST["by_day"] == "on" ) {
				echo '<div class="col-md-6">';
				echo "<h1>".getLabel("label.report_event.day")."</h1>";
				echo "<p class='fa fa-info-circle text-info'> ".date("d/m/Y H:i:s",strtotime("- 1 day"))." - ".date("d/m/Y H:i:s",time())."</p>";
				$pie_infos = pieChart("history", $field, $value, "day");
				echo '
					<div class="row text-center">
						<div id="history_pie_day"></div>
					</div>';
				echo '</div>';
				echo "<script>drawPieChart('history_pie_day', $pie_infos)</script>";
			}
			
			// normal "by_week" graph
			if( isset($_POST["by_week"]) && $_POST["by_week"] == "on" ) {
				echo '<div class="col-md-6">';
				echo "<h1>".getLabel("label.report_event.week")."</h1>";
				echo "<p class='fa fa-info-circle text-info'> ".date("d/m/Y H:i:s",strtotime("- 1 week"))." - ".date("d/m/Y H:i:s",time())."</p>";
				$pie_infos = pieChart("history", $field, $value, "week");
				echo '
					<div class="row text-center">
						<div id="history_pie_week"></div>
					</div>';
				echo '</div>';
				echo "<script>drawPieChart('history_pie_week', $pie_infos)</script>";
			}
			
			// normal "by_month" graph
			if( isset($_POST["by_month"]) && $_POST["by_month"] == "on" ) {
				echo '<div class="col-md-6">';
				echo "<h1>".getLabel("label.report_event.month")."</h1>";
				echo "<p class='fa fa-info-circle text-info'> ".date("d/m/Y H:i:s",strtotime("- 1 month"))." - ".date("d/m/Y H:i:s",time())."</p>";
				$pie_infos = pieChart("history", $field, $value, "month");
				echo '
					<div class="row text-center">
						<div id="history_pie_month"></div>
					</div>';
				echo '</div>';
				echo "<script>drawPieChart('history_pie_month', $pie_infos)</script>";
			}
			
			// normal "by_year" graph
			if( isset($_POST["by_year"]) && $_POST["by_year"] == "on" ) {
				echo '<div class="col-md-6">';
				echo "<h1>".getLabel("label.report_event.year")."</h1>";
				echo "<p class='fa fa-info-circle text-info'> ".date("d/m/Y H:i:s",strtotime("- 1 year"))." - ".date("d/m/Y H:i:s",time())."</p>";
				$pie_infos = pieChart("history", $field, $value, "year");
				echo '
					<div class="row text-center">
						<div id="history_pie_year"></div>
					</div>';
				echo '</div>';
				echo "<script>drawPieChart('history_pie_year', $pie_infos)</script>";
			}
			echo '</div>';
		}
	}
}
?>