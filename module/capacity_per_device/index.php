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

include("../../header.php");
include("../../side.php");	
?>

<div id="page-wrapper">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo getLabel("label.capacity_per_device.title"); ?></h1>
		</div>
	</div>
	
	<div class="row">
		<form method='GET'>
			<div class="form-group col-md-6">
				<label>Host :</label>
				<?php get_host_listbox_from_cacti();?><br>
			</div>
			<div class="form-group col-md-6">
				<label>Date :</label>
				<select class="form-control" name='date'>
					<option value='1'><?php echo getLabel("label.capacity_per_device.day"); ?></option>
					<option value='2'><?php echo getLabel("label.capacity_per_device.week"); ?></option>
					<option value='3'><?php echo getLabel("label.capacity_per_device.month"); ?></option>
					<option value='4'><?php echo getLabel("label.capacity_per_device.year"); ?></option>
				</select><br><br>
				<input class="btn btn-primary" type="submit" name="submit" value="<?php echo getLabel("action.show_graph"); ?>">
			</div>
		</form>
	</div>
	
	<?php  	
		if(count($_GET)>0)
		{
			global $database_cacti;
			
			echo '<div class="row">';
			# --- Retrieve the selected host id 
			if(isset($_GET['host'])) $graphlocal_hostid = $_GET['host'];
			else message(0," : ".getLabel("message.no_host_value"),"critical");	
		 
			if(isset($_GET['date'])) $graphlocal_dateid = $_GET['date'];
			else message(0," : ".getLabel("message.no_date_value"),"critical");

			# --- Get the graph id from the host id
			if(isset($graphlocal_hostid)){
				$result_graph=  sqlrequest($database_cacti,"SELECT id FROM graph_local WHERE host_id='$graphlocal_hostid' ");
				$nbr_ligne_graph = mysqli_num_rows($result_graph);
				for ($i=0;$i<$nbr_ligne_graph;$i++)
				{
					# --- Print the graph
					$graph_id = mysqli_result($result_graph,$i,"id");
					echo "<img class='img-responsive center-block' src='../../../cacti/graph_image.php?local_graph_id=$graph_id&rra_id=$graphlocal_dateid' alt='graph_cacti'/>";
				}
			}
			echo '</div>';
		}
	?>
</div>

<?php include("../../footer.php"); ?>
