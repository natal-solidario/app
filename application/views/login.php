
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo site_url('resources/img/favicon.png'); ?>" />

    <title>Natal Solidário</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="<?php echo site_url('resources/css/bootstrap.min.css'); ?>">
    
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url('assets/css/signin.css'); ?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="container">

      <form class="form-signin" role="form" method="post" action="<?php echo base_url('login/logar'); ?>">
        <h2 class="form-signin-heading">Login Natal Solidário</h2>
        <input type="email" class="form-control" placeholder="E-mail" required autofocus name="usuario">
        <input type="password" class="form-control" placeholder="Senha" required name="senha">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Fazer login</button>
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger" role="alert" style="margin-top: 10px;"><?php echo $erro; ?></div>
        <?php endif; ?>
      </form>
    </div> <!-- /container -->
  </body>
</html>
