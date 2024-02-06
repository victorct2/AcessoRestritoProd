<div class="login-box">  
  <div class="login-box-body">
    
    <img src="assets/img/logos/logo_coopas.png"  style="margin-left:37%;" ><br>
	<p class="login-box-msg">Faça login para iniciar sua sessão</p>

    <form action="<?php echo base_url('Login/autentication') ?>" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="login" class="form-control" placeholder="Login">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="senha" class="form-control" placeholder="Senha">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">        
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" style="margin-left:125%;">Entrar</button>
        </div>
        <!-- /.col -->
		
      </div>
	   <p class="login-box-msg">Caso tenha esquecido sua senha, <a href="<?php echo base_url('AlterarSenha/recuperaSenha') ?>"">clique aqui.<a/></p>
    </form>
    <?php $this->load->view('include/alertsMsg') ?>
    <!--<a href="#">Esqueci a minha senha</a><br>
    <a href="register.html" class="text-center">Cadastrar novo usuário</a>-->

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

