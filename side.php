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
?>

<!-- Nav menu -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="/index.php">
			<img id="logo_eon" src="/images/logo.png" alt="logo eyesofnetwork" style="width: 125px; height: 40px; margin-top: -10px;"/>
		</a>
	</div>
	<!-- /.navbar-header -->
	
	<ul class="nav navbar-top-links navbar-right">
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu dropdown-user">
				<li><a href="/module/monitoring_passwd/index.php"><i class="fa fa-user fa-fw"></i> <?php echo getLabel("menu.user.profile"); ?></a>
				</li>
				<li class="divider"></li>
				<li><a href="/logout.php"><i class="fa fa-sign-out fa-fw"></i> <?php echo getLabel("menu.user.disconnect"); ?></a>
				</li>
			</ul>
			<!-- /.dropdown-user -->
		</li>
		<!-- /.dropdown -->
	</ul>
	<!-- /.navbar-top-links -->
	
	<div class="navbar-default sidebar" role="navigation">
		<div class="sidebar-nav navbar-collapse">
			<ul id="side-menu" class="nav in">
				<li class="sidebar-search">
					<form id="sideMenuSearch" method="get" action="<?php echo $path_frame; ?>" style="margin-bottom: 0;">
						<div class="input-group custom-search-form">
							<input name="s0_value" id="s0_value" class="form-control" type="text" placeholder="<?php echo getLabel("label.input.placeholder.search"); ?>" autocomplete="off" onFocus="my_ajax_search();">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit">
									<i class="fa fa-search" style="padding: 3px 0;"></i>
								</button>
							</span>
						</div>
					</form>
				</li>
				<?php
					$cpt = 1;
					$tabs = sqlrequest("eonweb", "SELECT * from menu_tab");
					while( $tab = mysqli_fetch_array($tabs) ){
						$tab_right = sqlrequest("eonweb", "SELECT tab_".$cpt." FROM groupright WHERE group_id=".$_COOKIE['group_id']);
						$test = mysqli_fetch_array($tab_right);
						
						if($test[0] == 0){
							$cpt++;
							continue;
						} ?>
						<li>
							<a href="#">
								<i class="<?php echo $tab["image"]; ?>"></i>
								<?php echo getLabel($tab["name"]); ?>
								<span class="fa arrow"></span>
							</a>
							<ul class="nav nav-second-level collapse">
								<?php
									$subtabs = sqlrequest("eonweb", "SELECT * FROM menu_subtab WHERE id_tab = ". $tab["id"]);
									while( $subtab = mysqli_fetch_array($subtabs) ){ ?>
										<li>
											<a href="#"><?php echo getLabel($subtab["name"]); ?> <span class="fa arrow"></span> </a>
											<ul class="nav nav-third-level collapse">
												<?php 
													$links = sqlrequest("eonweb", "SELECT * FROM menu_link WHERE id_subtab = ". $subtab["id"]);
													while( $link = mysqli_fetch_array($links) ){ ?>
														<li>
															<a href="
															<?php 
																if((strpos($link["url"],'/module') === false) && (strpos($link["url"],'http://') === false) && $link["target"]!="_blank"){
																	echo getFrameURL($link["url"]);
																}
																else {
																	echo $link["url"];
																}
																echo "\" ";
																if($link["target"]=="_blank"){echo 'target="_blank"';}
																echo ">".getLabel($link["name"]) ;
															?>
															</a>
														</li>
												<?php } ?>
											</ul>
										</li>
								<?php } ?>
							</ul>
						</li>
					<?php 
						$cpt++;
					}
				?>
			</ul>
		</div>
		<!-- /.sidebar-collapse -->
	</div>
	<!-- /.navbar-static-side -->
</nav>
