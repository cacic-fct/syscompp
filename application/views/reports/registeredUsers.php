<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h1><i class="fa fa-flag"></i> Inscritos</h1>
			</div>

      <div class="page-header">
        <h3><i class="fa fa-institution"></i> SECOMPP 2019</h3>
      </div>
      <table id="eventsTableSECOMPP2018" class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Usuário</th>
            <th>Email</th>
            <th>Tipo</th>
            <th>Valor</th>
          </tr>
        </thead>
      </table>

      <div class="page-header">
        <h3><i class="fa fa-institution"></i> II SIMFISC</h3>
      </div>
      <table id="eventsTableIISIMFISC" class="table table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Usuário</th>
            <th>Email</th>
            <th>Tipo</th>
            <th>Valor</th>
          </tr>
        </thead>
      </table>
		</div>
	</div>
</div>

<script type="text/javascript">
	//dataTables

	var dataTableEventSECOMPP2018 =
	$('#eventsTableSECOMPP2018').DataTable({
		dom: 'Bfrtip',
	    buttons: [
	        'copy', 'excel', 'pdf'
	    ],
		"ajax": "<?=base_url('index.php/reports/registeredEvent/9');?>",
		"language":{"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"},
		"columns": [
			{ "data": "idUser" },
			{ "data": "user" },
			{ "data": "email" },
			{ "data": "type" },
			{ "data": "amount" },
		]
	});

	var dataTableEventIISIMFISC =
	$('#eventsTableIISIMFISC').DataTable({
		dom: 'Bfrtip',
	    buttons: [
	        'copy', 'excel', 'pdf'
	    ],
		"ajax": "<?=base_url('index.php/reports/registeredEvent/7');?>",
		"language":{"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"},
		"columns": [
			{ "data": "idUser" },
			{ "data": "user" },
			{ "data": "email" },
			{ "data": "type" },
			{ "data": "amount" },
		]
	});

</script>
</body>
</html>