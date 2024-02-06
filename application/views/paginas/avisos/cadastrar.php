
<div class="modal-dialog">
  <hr>  
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close fecharModalAviso" id="fecharModalAviso" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Cadastrar Aviso</h4>
    </div>
    <div class="modal-body">
      <form action="<?php echo base_url() ?>AvisosController/cadastrarBanco" method="post" >
                                  	
         <div class="form-group">                 	
             <label for="descricao">Descrição:</label>
             <div class="input-group">
                 <div class="input-group-addon">
                    <i class="fa fa-commenting-o"></i>
                  </div>
                 <input type="text" name="descricao" class="form-control" id="descricao" placeholder="digite o aviso" value="">
             </div>
         </div>	   
         
          <div class="form-group">                 	
             <label for="prioridade">Prioridade:</label>
             <div class="input-group">
                 <div class="input-group-addon">
                    <i class="fa fa-balance-scale"></i>
                  </div>
                 <select name="prioridade" id="prioridade" class="form-control">
                    <option value="1">Alta</option>
                    <option value="2">Média</option>
                    <option value="3">Baixa</option>
                  </select>
             </div>
         </div>	  
         
         <div class="box-footer">
            <button type="submit" class="btn btn-primary">Cadastrar Aviso</button>
          </div>            
    
    	</form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default fecharModalAviso" data-dismiss="modal">Close</button>
    </div>
  </div>
  
  
</div>


   