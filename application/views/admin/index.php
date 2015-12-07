<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/normalize.css">
      <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/style.css">
        <script src="<?php echo base_url();?>assets/admin/js/prefixfree.min.js"></script>
      <script src="<?php echo base_url();?>assets/admin/js/index.js"></script>
    
  </head>

  <body>

    <div class="login">
	<h1>Login</h1>
    <form method="POST" action='<?php echo site_url('Admin/validarUsuario'); ?>'>
    	<input type="text" name="user" placeholder="Usuario" required="required" />
        <input type="password" name="password" placeholder="Password" required="required" />
        <button type="submit" class="btn btn-primary btn-block btn-large">Entrar</button>
    </form>
</div>
    


    
    
    
  </body>
</html>
