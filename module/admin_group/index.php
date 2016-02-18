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

include("../../header.php");
include("../../side.php");

?>

<div id="page-wrapper">

	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header"><?php echo getLabel("label.admin_group.title"); ?></h1>
		</div>
	</div>

<?php 
	global $database_eonweb;
	global $database_lilac;
	$action=retrieve_form_data("action",null);
	$group_mgt_list=retrieve_form_data("group_mgt_list",null);
	$group_selected=retrieve_form_data("group_selected",null); 
	
	if 	($action == 'submit')
	{
		switch($group_mgt_list)
		{
			case "add_group":
				echo "<META HTTP-EQUIV=refresh CONTENT='0;URL=add_modify_group.php'>";
				break;
			case "delete_group":
				if (isset($group_selected[0]))
				{
					for ($i = 0; $i < count($group_selected); $i++)
					{
						// Get group name
						$group_res=sqlrequest("$database_eonweb","select group_name from groups where group_id='$group_selected[$i]'");
						$group_name=mysqli_result($group_res,0,"group_name");
						// Get users in group
						$users_in=sqlrequest("$database_eonweb","select user_name from users where group_id='$group_selected[$i]'");
						$users_in_names="";
						while ($line = mysqli_fetch_array($users_in))	
							$users_in_names=$line[0]." ".$users_in_names;

						// Delete group if no users in
						if($users_in_names==""){
							// Delete in eonweb
							sqlrequest("$database_eonweb","delete from groupright where group_id='$group_selected[$i]'");
							sqlrequest("$database_eonweb","delete from groups where group_id='$group_selected[$i]'");
							// Delete in lilac
							$lilac_contactgroupid=mysqli_result(sqlrequest("$database_lilac","select id from nagios_contact_group where name='$group_name'"),0,"id");
							sqlrequest("$database_lilac","delete from nagios_contact_group where name='$group_name'");
							sqlrequest("$database_lilac","delete from nagios_contact_group_member where contactgroup='$lilac_contactgroupid'");
							sqlrequest("$database_lilac","delete from nagios_escalation_contactgroup where contactgroup='$lilac_contactgroupid'");
							sqlrequest("$database_lilac","delete from nagios_host_contactgroup where contactgroup='$lilac_contactgroupid'");
							sqlrequest("$database_lilac","delete from nagios_service_contact_group_member where contact_group='$lilac_contactgroupid'");
							logging("admin_group","DELETE : $group_selected[$i]");
							message(8," : Group $group_name removed",'ok');
						}
						else
							message(8," : Group $group_name contains users : $users_in_names",'warning');
					}
				}
				break;
		}
	}

	//Get the name group and description group
	$group_name_descr=sqlrequest("$database_eonweb","SELECT group_name,group_descr,group_id FROM groups ORDER BY group_name");
?>

	<form action='./index.php' method='GET'>
		<div class="table-responsive">
			<table class="table table-striped">
				<thead>
				<tr>
					<th> <?php echo getLabel("label.admin_group.group_name"); ?> </th>
					<th> <?php echo getLabel("label.admin_group.group_desc"); ?> </th>
					<th class="col-md-2 text-center"> <?php echo getLabel("label.admin_group.select"); ?> </th>
				</tr>
				</thead>
				<tbody>
				<?php
				while ($line = mysqli_fetch_array($group_name_descr))
				{
				?>
				<tr>
					<td>
						<?php
						if($line[2]=="1")
							echo"$line[0]";
						else
							echo"<a href='./add_modify_group.php?group_id=$line[2]'> $line[0] </a>";
						?>
					</td>
					<td>
						<?php echo "$line[1]";?>
					</td>
					<td class="text-center">
						<?php
						if($line[2]=="1")
							echo "<INPUT type='checkbox' name='group_selected[]' value='$line[2]' disabled>";
						else
							echo "<INPUT type='checkbox' name='group_selected[]' value='$line[2]'>";
						?>
					</td>
				</tr>
				<?php
				}
				?>
				</tbody>
			</table>
		</div>
		
		<div class="row">
			<div class="col-md-3">
				<div class="form-group">
			<?php
				// Get the global table
				global $array_group_mgt;

				// Get the first array key
				reset($array_group_mgt);

				// Display the list of management choices
				echo "<SELECT class='form-control' name='group_mgt_list' size=1>";
				while (list($mgt_name, $mgt_url) = each($array_group_mgt)) {
						echo "<OPTION value='$mgt_url'>".getLabel($mgt_name)."</OPTION>";
				}
				echo "</SELECT>";
			?>
				</div>
				<button class="btn btn-primary" type="submit" name="action" value="submit"><?php echo getLabel("action.submit"); ?></button>
			</div>
		</div>
	</form>

</div>
	
<?php include("../../footer.php"); ?>
