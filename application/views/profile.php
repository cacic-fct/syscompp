<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h1><i class="fa fa-user"></i> Profile</h1>
			</div>
		</div>
		<form method="post" id="updateProfile">
			<div class="col-lg-12">
				<div class="form-group">
					<label for="Nome">Nome Completo</label>
					<input type="text" class="form-control" id="name" name="name" placeholder="Nome Completo" value="<?=$user->name; ?>">
				</div>
			</div>
			<div class="col-lg-8">
				<div class="form-group">
					<label for="RG">RG</label>
					<input type="text" class="form-control" id="rg" name="rg" placeholder="Documento RG" value="<?=$user->rg; ?>">
				</div>
			</div>
			<div class="col-lg-4">
				<div class="form-group">
					<label for="Emissor">Órgão Emissor</label>
					<input type="text" class="form-control" id="issuing" name="issuing" placeholder="XXX/XX" data-mask="aaa/aa" value="<?=$user->issuing; ?>">
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<label for="CPF">CPF</label>
					<input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" data-mask="999.999.999-99" value="<?=$user->cpf; ?>">
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<label for="Email">Email</label>
					<input type="email" class="form-control" id="email_form" name="email_form" placeholder="Email" value="<?=$user->email; ?>">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label for="Senha">Senha</label>
					<input type="password" class="form-control" id="password_form" name="password_form" placeholder="Senha">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label for="Senha">Confirmação de Senha</label>
					<input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirmação de Senha">
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<label for="Vínculo">Vínculo</label>
					<select class="form-control" id="type" name="type">
						<? foreach($types as $type): ?>
						<? if($type->idType == $user->idTypeFK): ?>
						<option value="<?= $type->idType; ?>" selected><?= $type->name; ?></option>
						<? else: ?>
						<option value="<?= $type->idType; ?>"><?= $type->name; ?></option>
						<? endif; ?>
						<? endforeach; ?>
					</select>
				</div>
			</div>
			<div class="col-lg-12 text-right">
				<button type="submit" class="btn btn-success"><i class="fa fa-refresh"></i> Atualizar</button>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$('input[type=text]').addClass('uppercase');

	idForm = $('#updateProfile');
	idForm.submit(function(event) {
		event.preventDefault();

		var form = new FormData(idForm[0]);

	    $.ajax({
	        url: "<?=base_url('index.php/users/updateProfile')?>",
	        type: 'POST',
	        data: form,
	        async: false,
	        dataType: 'json',
	        cache: false,
	        contentType: false,
	        processData: false,
	        success: function (data) {
	            if(data.boolean == true)
				{
					message('success', data.text);
					//Limpar os campos
					$('#password_form').val('').change();
					$('#password_confirmation').val('').change();
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