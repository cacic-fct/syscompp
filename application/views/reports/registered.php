<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h1><i class="fa fa-flag"></i> Inscritos</h1>
			</div>

			<div class="page-header">
				<h3><i class="fa fa-flag"></i> GERAL</h3>
			</div>
			<table id="dataTable" class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>ID</th>
						<th>Usuário</th>
						<th>Email</th>
						<th>Tipo</th>
					</tr>
				</thead>
			</table>

		</div>
	</div>
</div>

<script type="text/javascript">
	//dataTables
	var dataTable =
	$('#dataTable').DataTable({
		dom: 'Bfrtip',
	    buttons: [
	        'copy', 'excel', 'pdf'
	    ],
		"ajax": "<?=base_url('index.php/reports/all');?>",
		"language":{"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"},
     	"buttons": [
        'copy', 'excel', 'pdf'
    	],
		"columns": [
			{ "data": "number"},
			{ "data": "idUser" },
			{ "data": "user" },
			{ "data": "email" },
			{ "data": "type" },
		]
	});



</script>
</body>
</html>