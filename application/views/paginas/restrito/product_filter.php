<div class="wrapper"> 
 <?php $this->load->view('include/header') ?>
  <?php $this->load->view('include/menuLateral') ?>
    

   
    <!-- Bootstrap Core CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link href = "<?php echo base_url(); ?>asset/jquery-ui.css" rel = "stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo base_url(); ?>asset/style.css" rel="stylesheet">

    <!-- Page Content -->
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-3">
    <br />
    <br />
    <br />
                <div class="list-group">
     <h3>Tipo de arquivo</h3>
	   
     <?php
                    foreach($descricao_data->result_array() as $row)
                    {
                    ?>
					 
                    <div class="list-group-item checkbox">
					 <form action="<?php echo base_url('UsuariosController/alterarUsuario') ?>" method="POST">
          <input type="hidden" name="id" value="<?php echo $usuario[0]->id ?>">
          <input type="hidden" name="id_usuario" id="id_usuario" value="<?php echo $id ?>">
                        <label><input type="checkbox" class="common_selector descricao" value="<?php echo $row['descricao']; ?>"  > <?php echo $row['descricao']; ?></label>
						
          
                    </div>
					
					
                    <?php
                    }
                    ?>
					
                </div>
</form>
            </div>

            <div class="col-md-9">
             <h2 align="center">Selecione o tipo de arquivo</h2>
    <br />
    <div align="center" id="pagination_link">

                </div>
    <br />
    <br />
    <br />
                <div class="row filter_data">

                </div>
            </div>
        </div>

    </div>
<style>
#loading
{
 text-align:center; 
 background: url('<?php echo base_url(); ?>asset/loader.gif') no-repeat center; 
 height: 150px;
}
</style>

<script>
$(document).ready(function(){

    filter_data(1);

    function filter_data(page)
    {
        $('.filter_data').html('<div id="loading" style="" ></div>');
        var action = 'fetch_data';
        var descricao = get_filter('descricao');        
        var id = $("#id_usuario").val();		
        $.ajax({
            url:"<?php echo base_url(); ?>RestritoController/fetch_data/"+page,
            method:"POST",
            dataType:"JSON",
            data:{action:action,  descricao:descricao, id:id},
            success:function(data)
            {
                $('.filter_data').html(data.product_list);
                $('#pagination_link').html(data.pagination_link);
            }
        })
    }

    function get_filter(class_name)
    {
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }

    $(document).on('click', '.pagination li a', function(event){
        event.preventDefault();
        var page = $(this).data('ci-pagination-page');
        filter_data(page);
    });

    $('.common_selector').click(function(){
        filter_data(1);
    });

    

});
</script>


