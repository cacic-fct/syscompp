<? if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SYSCOMPP - Painel de Gerenciamento</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/bootstrap/css/bootstrap.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/font-awesome/css/font-awesome.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/style.css')?>">
	<script type="text/javascript" src="<?=base_url('assets/js/jquery.min.js')?>"></script>
	<style type="text/css">
		body{
			margin-top: 200px;
			font-size: 20px;
			background-color: #fff;
			background-image:
			linear-gradient(90deg, transparent 79px, #abced4 79px, #abced4 81px, transparent 81px),
			linear-gradient(#eee .1em, transparent .1em);
			background-size: 100% 1.2em;
		}
		#icon{
			font-size: 200px;
		}
	</style>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-lg-6 text-right">
			<i class="fa fa-optin-monster" id="icon"></i>
		</div>
		<div class="col-lg-6">
			<h1>OOOOPSSS !! Acho que você cometeu um equívoco.</h1>
			Está tentando algo de má fé ? Se não, por favor clique abaixo para retornar a página inicial da SYSCOMPP.<br>
			<a href="<?=base_url(); ?>" class="btn btn-default"><i class="fa fa-user"></i> Retornar à Página de Login</a>
		</div>
	</div>
</div> <!-- /container -->

<script type="text/javascript" src="<?=base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>
</body>
</html>