<!-- sidebar -->
			<div class="sidebar app-aside" id="sidebar">
				<div class="sidebar-container perfect-scrollbar">
					<nav>
						<!-- start: SEARCH FORM -->
						<div class="search-form">
							<a class="s-open" href="#">
								<i class="ti-search"></i>
							</a>
							<form class="navbar-form" role="search">
								<a class="s-remove" href="#" target=".navbar-form">
									<i class="ti-close"></i>
								</a>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Search...">
									<button class="btn search-button" type="submit">
										<i class="ti-search"></i>
									</button>
								</div>
							</form>
						</div>
						<!-- end: SEARCH FORM -->
						<!-- start: MAIN NAVIGATION MENU -->
						<!--<div class="navbar-title">
							<span>Main Navigation</span>
						</div>-->
						<ul class="main-navigation-menu">
						<?php if($this->session->userdata('account_role') == '2') {?>
							<li>
								<a href="<?php echo site_url('user');?>">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-home"></i>
										</div>
										<div class="item-inner">
											<span class="title"> Dashboard </span>
										</div>
									</div>
								</a>
							</li>								
							<li>
								<a href="<?php echo site_url('user/account_info');?>">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-user"></i>
										</div>
										<div class="item-inner">
											<span class="title"> Account </span>
										</div>
									</div>
								</a>
							</li>	
							<li>
								<a href="<?php echo site_url('user/new_profile');?>">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-id-badge "></i>
										</div>
										<div class="item-inner">
											<span class="title"> Profile </span>
										</div>
									</div>
								</a>
							</li>	
							<li <?php $open = '';
                          $methods = array('index','review');
                          if($controller == 'tags' && in_array($method,$methods)) {echo "class='open'"; $open = 1;}?>>
							<a href="javascript:void(0)">
							      <div class="item-content">
										<div class="item-media">
											<i class="ti-shopping-cart-full"></i>
										</div>
										<div class="item-inner">
											<span class="title"> Tags </span><i class="icon-arrow"></i>
										</div>
									</div>
									
								</a>
							   <ul class="sub-menu" <?php echo ($open)? "style='display:block'":"";?>>
									<li>
										<a href="<?php echo base_url('tags');?>">
											<span class="title">Ordering Tags</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url('tags/review');?>">
											<span class="title"> Review Tags</span>
										</a>
									</li>
								</ul>
							</li>
                    <li>
							<a href="<?php echo site_url('home/tips');?>">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-hand-point-up "></i>
										</div>
										<div class="item-inner">
										
											<span class="title"> Tips </span>
											
										</div>
									</div>
								</a>							
							</li>	
							<li>
							<a href="<?php echo site_url('feedback');?>">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-thought"></i>
										</div>
										<div class="item-inner">
										
											<span class="title"> Feedback </span>
											
										</div>
									</div>
								</a>							
							</li>	
							<?php } else if($this->session->userdata('account_role') == '1') {?>	
							<li>
							<a href="<?php echo site_url('admin/roles');?>">
							      <div class="item-content">
										<div class="item-media">
											<i class="ti-user"></i>
										</div>
										<div class="item-inner">
											<span class="title"> Roles </span>
										</div>
									</div>
									
								</a>
							  
							</li>
							 <li>
							<a href="<?php echo site_url('admin/tips');?>">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-hand-point-up "></i>
										</div>
										<div class="item-inner">
										
											<span class="title"> Tips </span>
											
										</div>
									</div>
								</a>							
							</li>
							<li <?php $open = '';
                                                            $methods = array('loginReport','activityLog','locationLog');
                                                            if($controller == 'admin' && in_array($method,$methods)) {echo "class='open'"; $open = 1;}?>>
								<a href="javascript:void(0)">
							      <div class="item-content">
										<div class="item-media">
											<i class="ti-layout-grid2-thumb"></i>
										</div>
										<div class="item-inner">
											<span class="title"> Logs </span><i class="icon-arrow"></i>
										</div>
									</div>
									
								</a>	
								<ul class="sub-menu" <?php echo ($open)? "style='display:block'":"";?>>
									<li>
										<a href="<?php echo site_url('admin/loginReport');?>">
											<span class="title">Login Reports</span>
										</a>
									</li>
									<li>
										<a href="<?php echo site_url('admin/activityLog');?>">
											<span class="title">Activity Log</span>
										</a>
									</li>
									<li>
										<a href="<?php echo site_url('admin/locationLog');?>">
											<span class="title">Location Log</span>
										</a>
									</li>
								</ul>					
							</li>
							<li>
							<a href="<?php echo site_url('admin/feedback');?>">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-thought"></i>
										</div>
										<div class="item-inner">
										
											<span class="title"> Feedback </span>
											
										</div>
									</div>
								</a>							
							</li>	
							<li>
							<a href="<?php echo site_url('admin/tagRegister');?>">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-tag"></i>
										</div>
										<div class="item-inner">
										
											<span class="title"> Register Tags </span>
											
										</div>
									</div>
								</a>							
							</li>	
							<li>
							<a href="<?php echo site_url('admin/paypalAddon');?>">
									<div class="item-content">
										<div class="item-media">
											<i class="ti-shopping-cart-full"></i>
										</div>
										<div class="item-inner">
										
											<span class="title"> Paypal Setup </span>
											
										</div>
									</div>
								</a>							
							</li>	
							<li <?php $open = '';
                                                            $methods = array();
                                                            if($controller == 'admin' && in_array($method,$methods)) {echo "class='open'"; $open = 1;}?>>
								<a href="javascript:void(0)">
							      <div class="item-content">
										<div class="item-media">
											<i class="ti-layout-grid3"></i>
										</div>
										<div class="item-inner">
											<span class="title"> Master </span><i class="icon-arrow"></i>
										</div>
									</div>
									
								</a>	
								<ul class="sub-menu" <?php echo ($open)? "style='display:block'":"";?>>
									<li>
										<a href="<?php echo site_url('admin/master/allergyname');?>">
											<span class="title">Allergy Name</span>
										</a>
									</li>
									<li>
										<a href="<?php echo site_url('admin/master/allergytype');?>">
											<span class="title">Allergy Type</span>
										</a>
									</li>
									<li>
										<a href="<?php echo site_url('admin/master/severe');?>">
											<span class="title">Symptoms Severe</span>
										</a>
									</li>
									<li>
										<a href="<?php echo site_url('admin/master/mild');?>">
											<span class="title">Symptoms Mild</span>
										</a>
									</li>
									<li>
										<a href="<?php echo site_url('admin/master/roles');?>">
											<span class="title">Roles</span>
										</a>
									</li>
								</ul>					
							</li>
						<?php } ?>		
						</ul>
					</nav>
				</div>
			</div>
			<!-- / sidebar -->
