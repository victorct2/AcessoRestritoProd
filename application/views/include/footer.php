<?php if($this->router->fetch_class() != 'Login' ){?>
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2022 <a href="http://coopas.tv.br/">COOPAS</a>.</strong> All rights reserved.
  </footer>
<?php } ?>

</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url()?>assets/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url()?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url()?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<?php


    if (isset($assetsJsBower) && $assetsJsBower != ""){
	  $assetsJsBower = explode(",",$assetsJsBower);
	  for ($i=0; $i<count($assetsJsBower); $i++)
		echo '<script src="' . base_url() . 'assets/bower_components/' . $assetsJsBower[$i] . '" type="text/javascript"></script>' . "\n";
	}


	if (isset($distJS) && $distJS != ""){
	  $distJS = explode(",",$distJS);
	  for ($i=0; $i<count($distJS); $i++)
		echo '<script src="' . base_url() . 'assets/dist/js/' . $distJS[$i] . '" type="text/javascript"></script>' . "\n";
	}


	if (isset($pluginJS) && $pluginJS != ""){
	  $pluginJS = explode(",",$pluginJS);
	  for ($i=0; $i<count($pluginJS); $i++)
		echo '<script src="' . base_url() . 'assets/plugins/' . $pluginJS[$i] . '" type="text/javascript"></script>' . "\n";
	}

    if (isset($assetsJs) && $assetsJs != ""){
	  $assetsJs = explode(",",$assetsJs);
	  for ($i=0; $i<count($assetsJs); $i++)
		echo '<script src="' . base_url() . 'assets/js/' . $assetsJs[$i] . '" type="text/javascript"></script>' . "\n";
	}
?>

<!-- Slimscroll -->
<script src="<?php echo base_url()?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url()?>assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url()?>assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes)
<script src="<?php echo base_url()?>assets/dist/js/pages/dashboard.js"></script> -->
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url()?>assets/dist/js/demo.js"></script>


</body>
</html>
