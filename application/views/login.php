<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo site_url('resources/img/favicon.png'); ?>" />

    <title>Natal Solidário</title>

    <link rel="stylesheet" href="<?php echo site_url('resources/css/bootstrap.min.css'); ?>">
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
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="form-group">
                        <h2 class="form-signin-heading">Login Natal Solidário</h2>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="E-mail" required autofocus
                            name="usuario" />
                        <span class="text-danger"><?php echo form_error('usuario');?></span>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Senha" required name="senha" />
                        <span class="text-danger"><?php echo form_error('senha');?></span>
                    </div>
                </div>
            </div>
            <?php /*<label for="remember"><?php echo form_checkbox('remember', 1, FALSE, 'class="remember"'); ?> Lembrar Usuário</label>*/ ?>
            <div class="row clearfix">
                <div class="col-md-12">
                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Fazer login</button>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-md-12">
                    <?php if($this->session->flashdata('message')): ?>
                    <div class="alert alert-danger" role="alert">
                        <strong><?php echo $this->session->flashdata('message'); ?> </strong>
                        <!-- <?php echo $this->session->flashdata('teste'); ?> -->
                        <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php elseif($this->session->flashdata('message_ok')): ?>
                    <div class="alert alert-success" role="alert">
                        <strong><?php echo $this->session->flashdata('message_ok'); ?> </strong>
                        <!-- <?php echo $this->session->flashdata('teste'); ?> -->
                        <button type="button" class="close" data-dismiss="alert" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php /*<div class="row clearfix">
                <div class="col-md-12 text-right">
                    <div class="form-group">
                        <a href="<?php echo base_url('login/lembrarsenha'); ?>">Esqueceu sua senha?</a>
                    </div>
                </div>
            </div>*/ ?>
        </form>
    </div> <!-- /container -->
    <script src="<?php echo site_url('resources/js/jquery-2.2.3.min.js'); ?>"></script>
    <script src="<?php echo site_url('resources/js/bootstrap.min.js'); ?>"></script>
</body>

</html>