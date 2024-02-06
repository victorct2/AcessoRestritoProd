<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<form action="<?php echo base_url('ComoAssistirController/alterarCanal') ?>" method="POST">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span></button>   
					<h3><i class="fa fa-tv text-blue"></i> Canal <small>Alterar</small></h3>            
								
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">

						<input type="hidden" name="idOutrosCanais" id="idOutrosCanais" value="<?php echo $idOutrosCanais ?>">

						<div class="form-group">
							<label for="canal">Canal * :</label>
							<input type="text" class="form-control" id="canal" name="canal" placeholder="Informe o nome" value="<?php echo $canal[0]->canal ?>">
						</div>

						<div class="form-group">
								<label for="link">link :</label>
								<textarea name="link" id="link" class="form-control" rows="4" placeholder="Entre 10 a 250 caracteres ..."><?php echo $canal[0]->link ?></textarea>
						</div>

					</div>
					<!-- /.col -->
					<div class="col-md-6">
				
							<div class="form-group">
								<label for="status">Status</label>
								<select name="status" class="form-control" style="width: 100%;"> 					
											<option value="S" <?php echo ($canal[0]->status == 'S' )? 'selected="selected"': '' ?> >Ativo</option>	
											<option value="N" <?php echo ($canal[0]->status == 'N' )? 'selected="selected"': '' ?> >Inativo</option>								                
								</select>
							</div>							
						
					</div>
					<!-- /.col -->					
						
				</div>      
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
				<button type="submit" class="btn btn-warning">Alterar Canal</button>
			</div>
    	</form>
 	</div>
  <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->

