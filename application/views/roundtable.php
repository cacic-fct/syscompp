<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h1><i class="fa fa-ge"></i> Mesa Redonda</h1>
			</div>

			<table id="roundtableTable" class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Evento</th>
						<th>Ações</th>
					</tr>
				</thead>
			</table>
		</div>

		<form method="post" id="submitRoundtable">
			<div class="col-lg-12">
				<div class="form-group">
					<label for="Evento">Evento</label>
					<select class="form-control" id="event" name="event">
						<? foreach($events as $event): ?>
						<option value="<?= $event->idEvent; ?>"><?= $event->name; ?></option>
						<? endforeach; ?>
					</select>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label for="Data">Data</label>
					<input type="text" class="form-control" id="date" name="date">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label for="Local">Local</label>
					<input type="text" class="form-control" id="location" name="location">
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label for="Inicio">Início</label>
					 <div class="input-group bootstrap-timepicker timepicker">
			            <input id="start" name="start" type="text" class="form-control input-small" data-mask="99:99:99">
			            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
			        </div>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="form-group">
					<label for="Fim">Fim</label>
					 <div class="input-group bootstrap-timepicker timepicker">
			            <input id="end" name="end" type="text" class="form-control input-small" data-mask="99:99:99">
			            <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
			        </div>
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<label for="Nome">Descrição da Atração</label>
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
<script type="text/javascript">

	// carrega datepickers
	$('#date').ftDatePicker();

	//dataTables
	var dataTable =
	$('#roundtableTable').DataTable({
		"ajax": "<?=base_url('index.php/roundtable/dataTables');?>",
		"columns": [
			{ "data": "idRoundtable" },
			{ "data": "event" },
			{ "data": "actions" }
		]
	});

	//ckeditor
	CKEDITOR.replace( 'description' );

	//submit
	idForm = $('#submitRoundtable');
	idForm.submit(function(event) {
		event.preventDefault();

		var form = new FormData(idForm[0]);
		form.append('description', CKEDITOR.instances.description.getData());

		$.ajax({
			url: "<?=base_url('index.php/roundtable/submitRoundtable')?>",
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
	var dataRow;

	//Busca de edição
	$('#roundtableTable tbody').on( 'click', '#editbtn', function () {
		var tr = $(this).closest('tr');
	    var row = dataTable.row( tr );
	    dataRow = row.data();
		console.log(dataRow);
		$.post("<?=base_url('index.php/roundtable/search');?>", {idRoundtable: dataRow.idRoundtable}, function(data, textStatus, xhr) {
			if(data.boolean == true)
			{
				message('information', data.text);
				$('#date').datepicker('update', data.obj.date);
				$('#location').val(data.obj.location);
				$('#start').val(data.obj.start);
				$('#end').val(data.obj.end);
				CKEDITOR.instances.description.setData(data.obj.description);
				$('option[value='+ data.obj.idEventFK +']').attr('selected', 'selected');

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
		idRoundtable = dataRow.idRoundtable;
		$.post("<?=base_url('index.php/roundtable/remove');?>", {idRoundtable: idRoundtable}, function(data, textStatus, xhr) {
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

	$('#roundtableTable tbody').on( 'click', '#removebtn', function () {
		var tr = $(this).closest('tr');
	    var row = dataTable.row( tr );
	    dataRow = row.data();
		console.log(dataRow);
		$('#confirm-modal').modal('show');
	});

</script>
</body>
</html>