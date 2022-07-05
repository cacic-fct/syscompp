<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h1><i class="fa fa-book"></i> Minicursos</h1>
			</div>

			<table id="shortcoursesTable" class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th width="40%">Nome</th>
						<th>Evento</th>
						<th>Ações</th>
					</tr>
				</thead>
			</table>
		</div>

		<form method="post" id="submitShortcourse">
			<div class="col-lg-12">
				<div class="form-group">
					<label for="Nome">Nome do Minicurso</label>
					<input type="text" class="form-control" id="name" name="name" placeholder="Nome do Minicurso">
				</div>
			</div>
			<div class="col-lg-8">
				<div class="form-group">
					<label for="Nome">Ministrantes</label>
					<select  class="form-control" multiple="multiple" id="panelist" name="panelist">
					</select>
				</div>
			</div>
			<div class="col-lg-2">
				<div class="form-group">
					<label for="Código Minicurso">Código do Minicurso</label>
					<input type="text" class="form-control" id="code" name="code" placeholder="Ex: MW2102">
				</div>
			</div>
			<div class="col-lg-2">
				<div class="form-group">
					<label for="Carga Horária">Carga Horária</label>
					<input type="text" class="form-control" id="workload" name="workload" placeholder="Ex: 4">
				</div>
			</div>
			<div class="col-lg-10">
				<div class="form-group">
					<label for="Evento">Evento</label>
					<select class="form-control" id="event" name="event">
						<? foreach($events as $event): ?>
						<option value="<?= $event->idEvent; ?>"><?= $event->name; ?></option>
						<? endforeach; ?>
					</select>
				</div>
			</div>
			<div class="col-lg-2">
				<div class="form-group">
					<label for="Vagas">Vagas</label>
					<input type="text" class="form-control" id="vacancies" name="vacancies" placeholder="Quantidade de vagas">
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<label for="Nome">Descrição do Minicurso</label>
					<textarea class="form-control" id="description" name="description"></textarea>
				</div>
			</div>
			<div class="col-lg-12 text-right">
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
					<form method="post" id="pricesShortcourses">
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

	//dataTables
	var dataTable =
	$('#shortcoursesTable').DataTable({
		"ajax": "<?=base_url('index.php/shortcourses/dataTables');?>",
		"columns": [
			{ "data": "idShortcourse" },
			{ "data": "name" },
			{ "data": "event" },
			{ "data": "actions" }
		]
	});

	//select2
	var users = <?=$users;?>;
	$("#panelist").select2({
		placeholder: "Ministrantes..",
		data: users
	});

	//ckeditor
	CKEDITOR.replace( 'description' );

	//submit
	idForm = $('#submitShortcourse');
	idForm.submit(function(event) {
		event.preventDefault();

		var form = new FormData(idForm[0]);
		form.append('panelist', $('#panelist').val());
		form.append('description', CKEDITOR.instances.description.getData());

		$.ajax({
			url: "<?=base_url('index.php/shortcourses/submitShortcourse')?>",
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
					CKEDITOR.instances.description.setData('');
					$('#panelist').val(null).trigger('change');
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
	$('#shortcoursesTable tbody').on( 'click', '#editbtn', function () {
		var tr = $(this).closest('tr');
	    var row = dataTable.row( tr );
	    dataRow = row.data();
		console.log(dataRow);
		$.post("<?=base_url('index.php/shortcourses/search');?>", {idShortcourse: dataRow.idShortcourse}, function(data, textStatus, xhr) {
			if(data.boolean == true)
			{
				message('information', data.text);
				$('#name').val(data.obj.name);
				$('#vacancies').val(data.obj.vacancies);
				$('#workload').val(data.obj.workload);
				$('#code').val(data.obj.code);
				$('#panelist').val(data.obj.panelists).trigger('change');
				CKEDITOR.instances.description.setData(data.obj.description);
				$('#event option[value='+ data.obj.idShortcourse +']').attr('selected', 'selected');

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
		idShortcourse = dataRow.idShortcourse;
		$.post("<?=base_url('index.php/shortcourses/remove');?>", {idShortcourse: idShortcourse}, function(data, textStatus, xhr) {
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

	$('#shortcoursesTable tbody').on( 'click', '#removebtn', function () {
		var tr = $(this).closest('tr');
	    var row = dataTable.row( tr );
	    dataRow = row.data();
		console.log(dataRow);
		$('#confirm-modal').modal('show');
	});

	/* PRICES */

	//dataTables
	var pricesDataTable =
	$('#pricesTable').DataTable({
		"processing": true,
		"serverSide": true,
		"ajax": {
			"url": "<?=base_url('index.php/shortcourses/pricesDataTables');?>",
			"type": "POST",
			"data": function(d){ d.idShortcourseFK = dataRow.idShortcourse }
		},
		"columns": [
			{ "data": "idAmount" },
			{ "data": "type" },
			{ "data": "amount" },
			{ "data": "actions" }
		],
		paging: false,
	});

	$('#shortcoursesTable tbody').on( 'click', '#pricebtn', function () {
		var tr = $(this).closest('tr');
	    var row = dataTable.row( tr );
	    dataRow = row.data();
		console.log(dataRow);
		pricesDataTable.ajax.reload();
		$('#prices-modal').modal('show');
	});

	//submitPrices
	idFormPrices = $('#pricesShortcourses');
	idFormPrices.submit(function(event) {
		event.preventDefault();

		var form = new FormData(idFormPrices[0]);
		form.append('idShortcourseFK', dataRow.idShortcourse);

		$.ajax({
			url: "<?=base_url('index.php/shortcourses/submitPrice')?>",
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
		$.post("<?=base_url('index.php/shortcourses/removePrice');?>", {idAmount: idAmount}, function(data, textStatus, xhr) {
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
		$.post("<?=base_url('index.php/shortcourses/searchPrice');?>", {idAmount: dataRowPrice.idAmount}, function(data, textStatus, xhr) {
			if(data.boolean == true)
			{
				message('information', data.text);
				$('#price').val(data.obj.amount);
				$('#type option[value='+ data.obj.idTypeFK +']').attr('selected', 'selected');

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