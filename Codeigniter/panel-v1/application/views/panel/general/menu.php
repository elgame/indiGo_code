			<!-- left menu starts -->
			<div class="span2 main-menu-span">
				<div class="well nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li class="nav-header hidden-tablet">Menú</li>

						<li>
								<a class="ajax-link" href="<?php echo base_url('panel'); ?>">
									<i class="icon-home"></i><span class="hidden-tablet"> Panel principal</span>
								</a>
						</li>

						<?php echo $this->empleados_model->generaMenuPrivilegio(); ?>
						
					</ul>
				</div><!--/.well -->
			</div><!--/span-->
			<!-- left menu ends -->

			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>


