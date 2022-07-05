<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h1><i class="fa fa-money"></i> Relatório de Pagantes</h1>
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
		"ajax": "<?=base_url('index.php/reports/payingEventUsers');?>",
		"language":{"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"},
		"columns": [
			{ "data": "idUser" },
			{ "data": "user" },
			{ "data": "event" },
			{ "data": "amount" }
		],
		dom: 'Bfrtip',
		"buttons": [
        'copy', 'excel', 'pdf'
    	]
	});

	//dataTables
	var dataTableShortcourse =
	$('#shortcoursesTable').DataTable({
		"ajax": "<?=base_url('index.php/reports/payingShortcoursesUsers');?>",
		"language":{"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"},
		"columns": [
			{ "data": "idUser" },
			{ "data": "user" },
			{ "data": "shortcourse" },
			{ "data": "amount" }
		],
		dom: 'Bfrtip',
		"buttons": [
        'copy', 'excel', 'pdf'
    	],
	});



</script>
</body>
</html>