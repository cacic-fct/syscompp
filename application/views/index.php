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

	<script type="text/javascript" src="<?=base_url('assets/js/jquery.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/bootstrap/js/bootstrap.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/jasny/js/jasny-bootstrap.min.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/js/functions.js')?>"></script>
	<script type="text/javascript" src="<?=base_url('assets/noty/js/noty/packaged/jquery.noty.packaged.min.js')?>"></script>
	<style type="text/css">
		body {
		  padding-top: 40px;
		  padding-bottom: 40px;
		  background-color: #eee;
		}

		.form-signin {
		  max-width: 330px;
		  padding: 15px;
		  margin: 0 auto;
		}
		.form-signin .form-signin-heading,
		.form-signin .checkbox {
		  margin-bottom: 10px;
		}
		.form-signin .checkbox {
		  font-weight: normal;
		}
		.form-signin .form-control {
		  position: relative;
		  height: auto;
		  -webkit-box-sizing: border-box;
			 -moz-box-sizing: border-box;
				  box-sizing: border-box;
		  padding: 10px;
		  font-size: 16px;
		}
		.form-signin .form-control:focus {
		  z-index: 2;
		}
		.form-signin input[type="email"] {
		  margin-bottom: -1px;
		  border-bottom-right-radius: 0;
		  border-bottom-left-radius: 0;
		}
		.form-signin input[type="password"] {
		  margin-bottom: 10px;
		  border-top-left-radius: 0;
		  border-top-right-radius: 0;
		}

		.scroll-modal {
		    max-height: calc(100vh - 210px);
		    overflow-y: auto;
		}

		#email, #password{
			text-transform: none;
		}

	</style>
</head>
<body>
<div class="container">
	<form class="form-signin">
		<h2 class="form-signin-heading"><i class="fa fa-user"></i> Login</h2>
		<div class="alert alert-info" role="alert" style="padding:5px 20px;">
			Seja bem-vindo(a) ao Sistema <b>SYSCOMPP</b>.
		</div>
		<label for="inputEmail" class="sr-only">Email</label>
		<input type="email" id="email" class="form-control" placeholder="Email" autofocus>
		<label for="inputPassword" class="sr-only">Senha</label>
		<input type="password" id="password" class="form-control" placeholder="Senha">
		<br>
		<button class="btn btn-lg btn-primary btn-block" type="button" id="login">Entrar</button>
		<br>
		<div class="text-center">
			<div class="btn-group" role="group">
				<a class="btn btn-success" href="#" id="register"><b>Registre-se</b></a>
				<a class="btn btn-default" href="#" id="forget-password">Esqueceu a Senha ?</a>
			</div>
		</div>
	</form>
	<br>
	<br>
	<p class="text-center">Sistema Desenvolvido por <a href="http://www.takaki.me/" target="_blank">Fábio Takaki</a></p>
</div> <!-- /container -->

<!-- MODAL DE REGISTRO -->
<div class="modal fade register">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Formulário de Registro</h4>
			</div>
			<div class="modal-body scroll-modal">
				<div class="alert alert-info" role="alert">
					<b>Atenção !</b>
					Prezados participantes,<br><br>
					Ao realizar o cadastro, respeite as restrições impostas a cada campo e evite utilizar o autocompletar</b>, pois ele poderá trazer problemas durante o preenchimento do formulário.<br>
					<b>Verifique primeiro se você já não possui cadastro conosco tentando recuperar a senha, pois migramos todos os usuários do sistema do ano passado.</b><br><br>
					Atenciosamente,<br>
					Comissão Organizadora SYSCOMPP
				</div>
				<form method="post" id="register-form">
					<div class="form-group">
						<label for="Nome">Nome Completo</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Nome Completo">
					</div>
					<div class="form-group">
						<label for="RG">RG</label>
						<input type="text" class="form-control" id="rg" name="rg" placeholder="Documento RG">
					</div>
					<div class="form-group">
						<label for="Emissor">Órgão Emissor</label>
						<input type="text" class="form-control" id="issuing" name="issuing" placeholder="XXX/XX" data-mask="aaa/aa">
					</div>
					<div class="form-group">
						<label for="CPF">CPF</label>
						<input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" data-mask="999.999.999-99">
					</div>
					<div class="form-group">
						<label for="Email">Email</label>
						<input type="email" class="form-control" id="email_form" name="email_form" placeholder="Email">
					</div>
					<div class="form-group">
						<label for="Email">Confirmação do Email</label>
						<input type="email" class="form-control" id="email_confirmation" name="email_confirmation" placeholder="Confirmação de Email">
					</div>
					<div class="form-group">
						<label for="Senha">Senha</label>
						<input type="password" class="form-control" id="password_form" name="password_form" placeholder="Senha">
					</div>
					<div class="form-group">
						<label for="Senha">Confirmação de Senha</label>
						<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmação de Senha">
					</div>
					<div class="form-group">
						<label for="Vínculo">Vínculo</label>
						<select class="form-control" id="type" name="type">
							<? foreach($types as $type): ?>
							<option value="<?= $type->idType; ?>"><?= $type->name; ?></option>
							<? endforeach; ?>
						</select>
					</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				<button type="submit" class="btn btn-primary">Registrar</button>
			</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- FIM MODAL DE REGISTRO -->

<script type="text/javascript">

	$('input[type=text]').addClass('uppercase');

	$("#password, #email").keyup(function(event){
		if(event.keyCode == 13){
	        $("#login").click();
	    }
	});

	$("#forget-password").click(function(event) {
		var email = $('#email').val();
				$('#password').val('');
		if($.isEmptyObject(email))
		{
			message('error', 'Preencha seu e-mail.');
		}
		else
		{
			$.post('<?=base_url('index.php/system/password')?>', {email: email}, function(data) {
				if(data.boolean)
				{
					message('success', 'Enviamos uma nova senha para <b>'+email+'</b>, verifique seu e-mail e sua caixa de spam.');
				}
				else message('error', 'Ocorreu um erro ao enviar o e-mail. Você é mesmo usuário da SYSCOMPP ?');
			},"json");
		}

	});

	$("#login").click(function(event) {
		var email = $('#email').val();
		var password = $('#password').val();

		if($.isEmptyObject(email) || $.isEmptyObject(password))
		{
			message('error', 'Preencha seu e-mail e sua senha corretamente.');
		}
		else
		{
			$.post('<?=base_url('index.php/system/login')?>', {email: email, password: password}, function(data) {
				if(data.boolean==true)
				{
					window.location.replace("<?=base_url('index.php/system/home')?>");
				}
				else message('error', 'Os dados informados estão incorretos! Confira seu e-mail e senha e tente novamente.<br>Caso tenha esquecido sua senha, preencha apenas o e-mail e clique em \"esqueci minha senha\".');

			},"json");
		}
	});

	$('#register').click(function(){
		$('.register').modal();
	});

	$('#register-form').submit(function(event) {
		event.preventDefault();

		var form = new FormData($('#register-form')[0]);

	    $.ajax({
	        url: "<?=base_url('index.php/system/register')?>",
	        type: 'POST',
	        data: form,
	        async: false,
	        dataType: 'json',
	        cache: false,
	        contentType: false,
	        processData: false,
	        success: function (data) {
	        	console.log(data);
	            if(data.boolean == true)
				{
					message('success', data.text);
					//Limpar os campos
					$(':input','#register-form')
						.val('').change()
						.removeAttr('checked')
						.removeAttr('selected');
				}
				else
				{
					message('error', data.text);
				}
	        }
	    });
	});
</script>
</body>
</html>