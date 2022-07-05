<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h1><i class="fa fa-institution"></i> Eventos</h1>
			</div>

			<table id="eventsTable" class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Evento</th>
						<th>Início</th>
						<th>Fim</th>
						<th>Inscrições</th>
						<th>Ações</th>
					</tr>
				</thead>
			</table>
		</div>

		<form method="post" id="submitEvent">
			<div class="col-lg-12">
				<div class="form-group">
					<label for="Nome">Nome do Evento</label>
					<input type="text" class="form-control" id="name" name="name" placeholder="Nome do Evento">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label for="Início">Início</label>
					<input type="text" class="form-control" id="start" name="start">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label for="Fim">Fim</label>
					<input type="text" class="form-control" id="end" name="end">
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<label for="Link">Link WebSite</label>
					<input type="text" class="form-control" id="link" name="link" placeholder="http://">
				</div>
			</div>
			<div class="col-lg-8">
				<div class="form-group">
					<label for="Local">Local do Evento</label>
					<input type="text" class="form-control" id="location" name="location" placeholder="Ex: FCT UNESP">
				</div>
			</div>
			<div class="col-lg-4">
				<div class="form-group">
					<label for="Ano">Ano do Evento</label>
					<input type="text" class="form-control" id="year" name="year" placeholder="Ano">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label for="Inscrições">Inscrições Abertas ?</label>
					<input type="checkbox" class="form-control" id="enrollments" name="enrollments">
				</div>
			</div>
			<div class="col-lg-6 text-right">
				<button class="btn btn-primary" type="submit" id="add"><i class="fa fa-plus"></i> Adicionar</button>
			</div>
		</form>
	</div>
</div>

<div class="modal fade" id="confirm-modal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Confirmação</h4>
			</div>
			<div class="modal-body">
				<p><b>Tem certeza que deseja deletar ?</b></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-danger" id="confirm-remove">Deletar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="prices-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Preços</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12">
						<table id="pricesTable" class="table table-hover">
							<thead>
								<tr>
									<th>#</th>
									<th>Tipo</th>
									<th>Preço</th>
									<th>Ações</th>
								</tr>
							</thead>
						</table>
					</div>

					<div class="col-lg-12" style="margin-top:30px;">
						<h4>Formulário de Inserção</h4>
					</div>
					<form method="post" id="pricesEvents">
						<div class="col-lg-12">
							<div class="form-group">
								<label for="Tipo">Tipo</label>
								<select class="form-control" id="type" name="type">
									<? foreach($types as $type): ?>
									<option value="<?= $type->idType; ?>"><?= $type->name; ?></option>
									<? endforeach; ?>
								</select>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="input-group">
								<span class="input-group-addon">R$</span>
								<input type="text" class="form-control" id="price" name="price">
							</div>
						</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-primary" type="submit" id="addPrice">Adicionar</button>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="confirm-modalPrice">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Confirmação</h4>
			</div>
			<div class="modal-body">
				<p><b>Tem certeza que deseja deletar ?</b></p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-danger" id="confirm-removePrice">Deletar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">

	// carrega datepickers
	$('#start').ftDatePicker();
	$('#end').ftDatePicker();

	//dataTables
	var dataTable =
	$('#eventsTable').DataTable({
		"ajax": "<?=base_url('index.php/events/dataTables');?>",
		"columns": [
			{ "data": "idEvent" },
			{ "data": "name" },
			{ "data": "start" },
			{ "data": "end" },
			{ "data": "enrollments" },
			{ "data": "actions" }
		]
	});

	//submit
	idForm = $('#submitEvent');
	idForm.submit(function(event) {
		event.preventDefault();

		var form = new FormData(idForm[0]);

		$.ajax({
			url: "<?=base_url('index.php/events/submitEvent')?>",
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
					idForm[0].reset();
					//refresh dataTables
					dataTable.ajax.reload();

					//reseta botão do form
					$('#add').removeClass('btn-success');
					$('#add').addClass('btn-primary');
					$('#add').html('<i class="fa fa-plus"></i> Adicionar');
				}
				else
				{
					message('error', data.text);
				}
			}
		});
	});

	//armazena dados da linha dataTables
	var dataRow = 1;

	//Busca de edição
	$('#eventsTable tbody').on( 'click', '#editbtn', function () {
		var tr = $(this).closest('tr');
	    var row = dataTable.row( tr );
	    dataRow = row.data();
		console.log(dataRow);
		$.post("<?=base_url('index.php/events/search');?>", {idEvent: dataRow.idEvent}, function(data, textStatus, xhr) {
			if(data.boolean == true)
			{
				message('information', data.text);
				$('#name').val(data.obj.name);
				$('#start').datepicker('update', data.obj.start);
				$('#end').datepicker('update', data.obj.end);
				$('#link').val(data.obj.link);
				$('#location').val(data.obj.location);
				$('#year').val(data.obj.year);
				if(data.obj.enrollments == 'S')
				$('#enrollments').prop( "checked", true );
				else
				$('#enrollments').prop( "checked", false );

				$('#add').removeClass('btn-primary');
				$('#add').addClass('btn-success');
				$('#add').html('<i class="fa fa-refresh"></i> Atualizar');
			}
			else
			{
				message('error', data.text);
			}
		}, "json");
	});

	//Remover
	$('#confirm-remove').click(function(){
		idEvent = dataRow.idEvent;
		$.post("<?=base_url('index.php/events/remove');?>", {idEvent: idEvent}, function(data, textStatus, xhr) {
			if(data.boolean == true)
				{
					message('success', data.text);
					//refresh dataTables
					dataTable.ajax.reload();
					$('#confirm-modal').modal('hide');
				}
				else
				{
					message('error', data.text);
				}
		}, "json");
	});

	$('#eventsTable tbody').on( 'click', '#removebtn', function () {
		var tr = $(this).closest('tr');
	    var row = dataTable.row( tr );
	    dataRow = row.data();
		console.log(dataRow);
		$('#confirm-modal').modal('show');
	});

	/* PRICES */
	$('#eventsTable tbody').on( 'click', '#pricebtn', function () {
		var tr = $(this).closest('tr');
	    var row = dataTable.row( tr );
	    dataRow = row.data();
		console.log(dataRow);
		pricesDataTable.ajax.reload();
		$('#prices-modal').modal('show');
	});

	//dataTables
	var pricesDataTable =
	$('#pricesTable').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": "<?=base_url('index.php/events/pricesDataTables');?>",
			"type": "POST",
			"data": function(d){ d.idEventFK = dataRow.idEvent }
		},
		"columns": [
			{ "data": "idAmount" },
			{ "data": "type" },
			{ "data": "amount" },
			{ "data": "actions" }
		],
		paging: false,
	});


	//submitPrices
	idFormPrices = $('#pricesEvents');
	idFormPrices.submit(function(event) {
		event.preventDefault();

		var form = new FormData(idFormPrices[0]);
		form.append('idEventFK', dataRow.idEvent);

		$.ajax({
			url: "<?=base_url('index.php/events/submitPrice')?>",
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
					idFormPrices[0].reset();
					//refresh dataTables
					pricesDataTable.ajax.reload();

					//reseta botão do form
					$('#addPrice').removeClass('btn-success');
					$('#addPrice').addClass('btn-primary');
					$('#addPrice').html('<i class="fa fa-plus"></i> Adicionar');
				}
				else
				{
					message('error', data.text);
				}
			}
		});
	});

	var dataRowPrice = 1;

	//Remover Preço
	$('#confirm-removePrice').click(function(){
		idAmount = dataRowPrice.idAmount;
		$.post("<?=base_url('index.php/events/removePrice');?>", {idAmount: idAmount}, function(data, textStatus, xhr) {
			if(data.boolean == true)
				{
					message('success', data.text);
					//refresh dataTables
					pricesDataTable.ajax.reload();
					$('#confirm-modalPrice').modal('hide');
					$('#prices-modal').modal('show');
				}
				else
				{
					message('error', data.text);
				}
		}, "json");
	});

	$('#pricesTable tbody').on( 'click', '#removePricebtn', function () {
		var tr = $(this).closest('tr');
	    var row = pricesDataTable.row( tr );
	    dataRowPrice = row.data();
		$('#prices-modal').modal('hide');
		$('#confirm-modalPrice').modal('show');
	});

	//Busca de edição
	$('#pricesTable tbody').on( 'click', '#editPricebtn', function () {
		var tr = $(this).closest('tr');
	    var row = pricesDataTable.row( tr );
	    dataRowPrice = row.data();
		$.post("<?=base_url('index.php/events/searchPrice');?>", {idAmount: dataRowPrice.idAmount}, function(data, textStatus, xhr) {
			if(data.boolean == true)
			{
				message('information', data.text);
				$('#price').val(data.obj.amount);
				$('option[value='+ data.obj.idTypeFK +']').attr('selected', 'selected');

				$('#addPrice').removeClass('btn-primary');
				$('#addPrice').addClass('btn-success');
				$('#addPrice').html('<i class="fa fa-refresh"></i> Atualizar');
			}
			else
			{
				message('error', data.text);
			}
		}, "json");
	});

</script>
</body>
</html>