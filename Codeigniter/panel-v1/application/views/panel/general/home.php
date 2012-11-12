		<div id="content" class="span10">
			<!-- content starts -->
			
			<div>
				<ul class="breadcrumb">
					<li>
						<a href="<?php echo base_url('panel'); ?>">Inicio</a> <span class="divider">/</span>
					</li>
					<li>
						Panel principal
					</li>
				</ul>
			</div>

			<div class="sortable row-fluid">
				<a data-rel="tooltip" title="122" class="well span3 top-block" href="#">
					<span class="icon32 icon-red icon-user"></span>
					<div>Total de Usuarios</div>
					<div>22</div>
					<span class="notification">2</span>
				</a>

				<a data-rel="tooltip" title="32" class="well span3 top-block" href="#">
					<span class="icon32 icon-color icon-star-on"></span>
					<div>Usuarios tic</div>
					<div>12</div>
					<span class="notification green">1</span>
				</a>

				<a data-rel="tooltip" title="123" class="well span3 top-block" href="<?php echo base_url('panel/ventas'); ?>">
					<span class="icon32 icon-color icon-cart"></span>
					<div>Ventas</div>
					<div>2312</div>
					<span class="notification yellow">12312</span>
				</a>
				
				<a data-rel="tooltip" title="12 new messages." class="well span3 top-block" href="<?php echo base_url('panel/mensajes'); ?>">
					<span class="icon32 icon-color icon-envelope-closed"></span>
					<div>Mensajes</div>
					<div>12</div>
					<span class="notification red">22</span>
				</a>
			</div>
					
			<div class="row-fluid sortable">
				<div class="box span6">
					<div class="box-header well">
						<h2><i class="icon-shopping-cart"></i> Ventas por confirmar</h2>
						<div class="box-icon">
							<a href="#" class="btn btn-minimize btn-round"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped datatable">
						  <thead>
							  <tr>
								  <th>Folio</th>
								  <th>Cliente</th>
								  <th>F. creacion</th>
								  <th>Tipo</th>
								  <th>Costo</th>
								  <th>Estado</th>
								  <th>Opciones</th>
							  </tr>
						  </thead>   
						  <tbody>
						  </tbody>
					  </table>
					</div>
				</div><!--/span-->
						
					
			</div><!--/row-->
				  

		  
       
					<!-- content ends -->
	</div><!--/#content.span10-->









<!-- Bloque de alertas -->
<?php if(isset($frm_errors)){
	if($frm_errors['msg'] != ''){ 
?>
<script type="text/javascript" charset="UTF-8">
	$(document).ready(function(){
		noty({"text":"<?php echo $frm_errors['msg']; ?>", "layout":"topRight", "type":"<?php echo $frm_errors['ico']; ?>"});
	});
</script>
<?php }
}?>
<!-- Bloque de alertas -->