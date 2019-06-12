<!-- begin #sidebar -->

		<div id="sidebar" class="sidebar">

			<!-- begin sidebar scrollbar -->

			<div data-scrollbar="true" data-height="100%">

				<!-- begin sidebar nav -->

				<ul class="nav">

				    <li class="nav-user">

				        <div class="image">

				            <img src="<?php echo file_check(@$this->admin_data->user_image); ?>" alt="" />

				        </div>

				        <div class="info">

				            <div class="name dropdown">

				                <a href="javascript:;" data-toggle="dropdown"><?php echo ucwords($this->admin_data->user_full_name); ?> <b class="caret"></b></a>

                                <ul class="dropdown-menu">

                                    <li><a href="<?php echo base_url("profile/form/".$this->user_id) ?>">Edit Profile</a></li>

                                    <!--<li><a href="javascript:;"><span class="badge badge-danger pull-right">2</span> Inbox</a></li>

                                    <li><a href="javascript:;">Calendar</a></li>

                                    <li><a href="javascript:;">Setting</a></li>-->

                                    <li class="divider"></li>

                                    <li><a href="<?php echo base_url('login/logout'); ?>">Log Out</a></li>

                                </ul>

				            </div>

				            <div class="position">Pets admin</div>

				        </div>

				    </li>

					<li class="nav-header">Navigation</li>

					<li class="has-sub <?php echo $this->uri->segment(1) == "dashboard" ? "active" : ""; ?>">

						<a href="javascript:;">

						    <b class="caret pull-right"></b>

						    <i class="fa fa-home"></i>

						    <span>Dashboard <span class="label label-theme m-l-3">NEW</span></span>

					    </a>

					    <ul class="sub-menu">

					        <li class="<?php echo $this->uri->segment(1) == "dashboard" ? "active" : ""; ?>"><a href="<?php echo base_url('dashboard'); ?>">Dashboard</a></li>

					    </ul>

					</li>

                    

                    

                    

                    <?php

					if(isset($this->panel_view) && !empty($this->panel_view)){

						foreach($this->panel_view as $val){

							foreach($val as $panel){

							if(isset($panel["modules"]) && !empty($panel["modules"]) && is_array($panel["modules"])){

								$menu_active = isset($panel["expand"]) && $panel["expand"] == 1 ? 'active' : '';

								$panel_icon = trim($panel['img_url']) != "" ? trim($panel['img_url']) : 'fa fa-align-left';

								echo '<li class="has-sub '.$menu_active.'">';

									echo '<a href="javascript:;">';

										echo '<b class="caret pull-right"></b>';

										echo '<i class="'.$panel_icon.'"></i>';

										echo '<span>'.ucwords($panel['panel_name']).'</span>';

									echo '</a>';

									echo '<ul class="sub-menu">';

										foreach($panel["modules"] as $mal){

											$module_active = isset($mal["expand"]) && $mal["expand"] == 1 ? 'active' : '';

											echo '<li class="'.$module_active.'"><a href="'.base_url($mal['module_url']).'">'.ucwords($mal['module_name']).'</a></li>';

										}

									echo '</ul>';

								echo '</li>';

							}

							}

						}

					}

					?>

                    

                    <li class="divider has-minify-btn">

                        <!-- begin sidebar minify button -->

                        <a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="fa fa-angle-left"></i></a>

                        <!-- end sidebar minify button -->

					</li>


				</ul>

				<!-- end sidebar nav -->

			</div>

			<!-- end sidebar scrollbar -->

		</div>

		<div class="sidebar-bg"></div>

		<!-- end #sidebar -->