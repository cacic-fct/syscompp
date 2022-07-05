<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h1><i class="fa fa-graduation-cap"></i> Palestras</h1>
			</div>

			<table id="lecturesTable" class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Nome</th>
						<th>Evento</th>
						<th>Ações</th>
					</tr>
				</thead>
			</table>
		</div>

		<form method="post" id="submitLecture">
			<div class="col-lg-12">
				<div class="form-group">
					<label for="Nome">Nome da Palestra</label>
					<input type="text" class="form-control" id="name" name="name" placeholder="Nome da Palestra">
				</div>
			</div>
			<div class="col-lg-12">
				<div class="form-group">
					<label for="Palestrantes">Palestrantes</label>
					<select  class="form-control" multiple="multiple" id="panelist" name="panelist">
					</select>
				</div>
			</div>
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
			<div class="col-lg-12">
				<div class="form-group">
					<label for="Nome">Descrição da Palestra</label>
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

	//dataTables
	var dataTable =
	$('#lecturesTable').DataTable({
		"ajax": "<?=base_url('index.php/lectures/dataTables');?>",
		"columns": [
			{ "data": "idLecture" },
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
	idForm = $('#submitLecture');
	idForm.submit(function(event) {
		event.preventDefault();

		var form = new FormData(idForm[0]);
		form.append('panelist', $('#panelist').val());
		form.append('description', CKEDITOR.instances.description.getData());

		$.ajax({
			url: "<?=base_url('index.php/lectures/submitLecture')?>",
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
	var dataRow;

	//Busca de edição
	$('#lecturesTable tbody').on( 'click', '#editbtn', function () {
		var tr = $(this).closest('tr');
	    var row = dataTable.row( tr );
	    dataRow = row.data();
		console.log(dataRow);
		$.post("<?=base_url('index.php/lectures/search');?>", {idLecture: dataRow.idLecture}, function(data, textStatus, xhr) {
			if(data.boolean == true)
			{
				message('information', data.text);
				$('#name').val(data.obj.name);
				$('#panelist').val(data.obj.panelists).trigger('change');
				CKEDITOR.instances.description.setData(data.obj.description);
				$('#event option[value='+ data.obj.idLecture +']').attr('selected', 'selected');

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
		idLecture = dataRow.idLecture;
		$.post("<?=base_url('index.php/lectures/remove');?>", {idLecture: idLecture}, function(data, textStatus, xhr) {
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

	$('#lecturesTable tbody').on( 'click', '#removebtn', function () {
		var tr = $(this).closest('tr');
	    var row = dataTable.row( tr );
	    dataRow = row.data();
		console.log(dataRow);
		$('#confirm-modal').modal('show');
	});

</script>
</body>
</html>