<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>SYSCOMPP - Painel de Gerenciamento</title>
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/bootstrap/css/bootstrap.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/jasny/css/jasny-bootstrap.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/font-awesome/css/font-awesome.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/style.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/animate.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/date-picker/css/bootstrap-datepicker.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/dataTables/datatables.min.css')?>">
	<link rel="stylesheet" type="text/css" href="<?=base_url('assets/select2/css/select2.min.css')?>">

	<script type="text/javascript" src="<?=base_url('assets/js/jquery.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/jasny/js/jasny-bootstrap.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/js/functions.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/noty/js/noty/packaged/jquery.noty.packaged.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/date-picker/js/bootstrap-datepicker.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/dataTables/datatables.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/select2/js/select2.min.js')?>"></script>
</head>
<body>
<header>
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<nav class="navbar navbar-default">
					<div class="container-fluid">
						<!-- Brand and toggle get grouped for better mobile display -->
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
							<a class="navbar-brand" href="<?=base_url('index.php/system/home');?>"><i class="fa fa-desktop"></i> SYSCOMPP</a>
						</div>

						<!-- Collect the nav links, forms, and other content for toggling -->
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav">
								<li><a href="<?=base_url('index.php/system/home');?>"><i class="fa fa-home"></i> Página Inicial</a></li>
								<li><a href="<?=base_url('index.php/users/profile');?>"><i class="fa fa-user"></i> Profile</a></li>
								<li><a href="<?=base_url('index.php/shortcourses/register');?>"><i class="fa fa-book"></i> Minicursos</a></li>
								<li><a href="<?=base_url('index.php/certificates');?>"><i class="fa fa-certificate"></i> Certificados</a></li>
								<li><a href="<?=base_url('index.php/system/invoices');?>"><i class="fa fa-money"></i> Ficha de Pagamento</a></li>
								<? if($this->session->userdata('role') != 'U'): ?>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user-secret"></i> Administrar <b class="caret"></b></a>
									<ul class="dropdown-menu">
										<li class="dropdown-header">Módulos</li>
										<? if($this->session->userdata('role') == 'E' || $this->session->userdata('role') == 'A'): ?>
										<li><a href="<?=base_url('index.php/presences');?>">Presenças</a></li>
										<? endif; ?>
										<? if($this->session->userdata('role') == 'A'): ?>
										<li><a href="<?=base_url('index.php/payments');?>">Pagamentos</a></li>
										<li><a href="<?=base_url('index.php/events');?>">Eventos</a></li>
										<li><a href="<?=base_url('index.php/shortcourses');?>">Minicursos</a></li>
										<li><a href="<?=base_url('index.php/lectures');?>">Palestras</a></li>
										<li class="divider"></li>
										<li class="dropdown-header">Atração Específica</li>
										<li><a href="<?=base_url('index.php/roundtable');?>">Mesa Redonda</a></li>
										<li class="divider"></li>
										<li class="dropdown-header">Relatórios</li>
										<li><a href="<?=base_url('index.php/reports/payingusers');?>">Pagantes</a></li>
										<li><a href="<?=base_url('index.php/reports/debtorsusers');?>">NÃO Pagantes</a></li>
										<li><a href="<?=base_url('index.php/reports/registered');?>">Inscritos GERAL</a></li>
										<li><a href="<?=base_url('index.php/reports/registeredusers');?>">Inscritos Eventos</a></li>
										<li><a href="<?=base_url('index.php/reports/registeredshortcourses');?>">Inscritos Minicursos</a></li>
										<? endif; ?>
									</ul>
								</li>
								<? endif; ?>
								<li><a href="<?=base_url('index.php/system/logout'); ?>"><i class="fa fa-sign-out"></i> Sair</a></li>
							</ul>
						</div><!-- /.navbar-collapse -->
					</div><!-- /.container-fluid -->
				</nav>
			</div>
		</div>
	</div>
</header>