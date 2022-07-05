<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h1><i class="fa fa-flag"></i> Inscritos Minicursos</h1>
			</div>

			<div class="page-header">
				<h3><i class="fa fa-institution"></i> SECOMPP 2018</h3>
			</div>
			<table id="shortcoursesTableSECOMPP2018" class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Minicurso</th>
						<th>Usuário</th>
						<th>Email</th>
					</tr>
				</thead>
			</table>

			<div class="page-header">
				<h3><i class="fa fa-institution"></i> II SIMFISC</h3>
			</div>
			<table id="shortcoursesTableIISIMFISC" class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Minicurso</th>
						<th>Usuário</th>
						<th>Email</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>

<script type="text/javascript">
	//dataTables
	var dataTableShortcoursesSECOMPP2018 =
	$('#shortcoursesTableSECOMPP2018').DataTable({
		dom: 'Bfrtip',
	    buttons: [
	        'copy', 'excel', 'pdf'
	    ],
		"ajax": "<?=base_url('index.php/reports/registeredShortcourse/8');?>",
		"language":{"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"},
		"columns": [
			{ "data": "idUser" },
			{ "data": "shortcourse" },
			{ "data": "user" },
			{ "data": "email" },

		]
	});

	var dataTableShortcoursesIISIMFISC =
	$('#shortcoursesTableIISIMFISC').DataTable({
		dom: 'Bfrtip',
	    buttons: [
	        'copy', 'excel', 'pdf'
	    ],
		"ajax": "<?=base_url('index.php/reports/registeredShortcourse/7');?>",
		"language":{"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"},
		"columns": [
			{ "data": "idUser" },
			{ "data": "shortcourse" },
			{ "data": "user" },
			{ "data": "email" },

		]
	});

</script>
</body>
</html>