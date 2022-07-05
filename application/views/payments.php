<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h1><i class="fa fa-money"></i> Pagamentos</h1>
			</div>

			<div class="page-header">
				<h3><i class="fa fa-institution"></i> Eventos</h3>
			</div>
			<table id="eventsTable" class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Usuário</th>
						<th>Evento</th>
						<th>Valor</th>
						<th>Ações</th>
					</tr>
				</thead>
			</table>

			<div class="page-header">
				<h3><i class="fa fa-book"></i> Minicursos</h3>
			</div>
			<table id="shortcoursesTable" class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Usuário</th>
						<th>Minicurso</th>
						<th>Valor</th>
						<th>Ações</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	//dataTables
	var dataTableEvent =
	$('#eventsTable').DataTable({
		"ajax": "<?=base_url('index.php/payments/eventsPayment');?>",
		"language":{"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"},
		"columns": [
			{ "data": "idUser" },
			{ "data": "user" },
			{ "data": "event" },
			{ "data": "amount" },
			{ "data": "actions" }
		]
	});

	$('#eventsTable tbody').on( 'click', '#pay', function () {
		var tr = $(this).closest('tr');
	    var row = dataTableEvent.row( tr );
	    buttonEvent = $(this).closest('#pay');
	    dataRow = row.data();
		console.log(dataRow);

		//idUser e idEvent
		var idUser = dataRow.idUser;
		var idEvent = buttonEvent.attr('idEvent');

		$.post("<?=base_url('index.php/payments/payEvent');?>", {idUser: idUser, idEvent:idEvent}, function(data, textStatus, xhr) {
			if(data.boolean == true)
			{
				if(data.payment == 'S'){
					message('success', data.text);
					buttonEvent.removeClass('btn-primary');
					buttonEvent.addClass('btn-danger');
					buttonEvent.html('Cancelar Pagamento');
				}else{
					message('warning', data.text);
					buttonEvent.removeClass('btn-danger');
					buttonEvent.addClass('btn-primary');
					buttonEvent.html('Dar Baixa');
				}
			}
			else
			{
				message('error', data.text);
			}
		}, "json");
	});

	//dataTables
	var dataTableShortcourse =
	$('#shortcoursesTable').DataTable({
		"ajax": "<?=base_url('index.php/payments/shortcoursesPayment');?>",
		"language":{"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"},
		"columns": [
			{ "data": "idUser" },
			{ "data": "user" },
			{ "data": "shortcourse" },
			{ "data": "amount" },
			{ "data": "actions" }
		]
	});

	$('#shortcoursesTable tbody').on( 'click', '#pay', function () {
		var tr = $(this).closest('tr');
	    var row = dataTableShortcourse.row( tr );
	    buttonEvent = $(this).closest('#pay');
	    dataRow = row.data();
		console.log(dataRow);

		//idUser e idShortcourse
		var idUser = dataRow.idUser;
		var idShortcourse = buttonEvent.attr('idShortcourse');

		$.post("<?=base_url('index.php/payments/payShortcourse');?>", {idUser: idUser, idShortcourse:idShortcourse}, function(data, textStatus, xhr) {
			if(data.boolean == true)
			{
				if(data.payment == 'S'){
					message('success', data.text);
					buttonEvent.removeClass('btn-primary');
					buttonEvent.addClass('btn-danger');
					buttonEvent.html('Cancelar Pagamento');
				}else{
					message('warning', data.text);
					buttonEvent.removeClass('btn-danger');
					buttonEvent.addClass('btn-primary');
					buttonEvent.html('Dar Baixa');
				}
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