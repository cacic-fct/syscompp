<div class="container">
	<div class="row">
		<div class="col-lg-12">

			<div class="page-header">
				<h1><i class="fa fa-check"></i> Presenças por Código de Barras</h3>
			</div>
			<div class="page-header">
				<h3><i class="fa fa-graduation-cap"></i> Palestras</h3>
			</div>
			<select id="code_lectures">
				<? foreach($lectures_select as $lecture): ?>
				<option value="<?=$lecture->idLecture ?>"><?=$lecture->name ?></option>
				<? endforeach; ?>
			</select>
			<input type="text" name="code_lecture" id="code_lecture" />

			<div class="page-header">
				<h3><i class="fa fa-book"></i> Minicursos</h3>
			</div>
			<select id="code_shortcourses">
				<? foreach($shortcourses_select as $shortcourse): ?>
				<option value="<?=$shortcourse->idShortcourse ?>"><?=$shortcourse->code ?> - <?=$shortcourse->name ?></option>
				<? endforeach; ?>
			</select>
			<input type="text" name="code_shortcourse" id="code_shortcourse" />

			<div class="page-header">
				<h1><i class="fa fa-check"></i> Presenças</h1>
			</div>

			<div class="page-header">
				<h3><i class="fa fa-graduation-cap"></i> Palestras</h3>
			</div>
			<table id="eventsTable" class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Usuário</th>
						<th>Palestra</th>
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
		"ajax": "<?=base_url('index.php/presences/lectures');?>",
		"language":{"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"},
		"columns": [
			{ "data": "idUser" },
			{ "data": "user" },
			{ "data": "lecture" },
			{ "data": "actions" }
		],
		"buttons": [
        'copy', 'excel', 'pdf'
    	],
    	dom: 'Bfrtip'
	});

	$('#eventsTable tbody').on( 'click', '#addPresence', function () {
		var tr = $(this).closest('tr');
	    var row = dataTableEvent.row( tr );
	    buttonEvent = $(this).closest('#addPresence');
	    dataRow = row.data();
		console.log(dataRow);

		//idUser e idLecture
		var idUser = dataRow.idUser;
		var idLecture = buttonEvent.attr('idLecture');

		$.post("<?=base_url('index.php/presences/presenceLecture');?>", {idUser: idUser, idLecture:idLecture}, function(data, textStatus, xhr) {
			if(data.boolean == true)
			{
				if(data.button == 'S'){
					message('success', data.text);
					buttonEvent.removeClass('btn-primary');
					buttonEvent.addClass('btn-danger');
					buttonEvent.html('Cancelar Presença');
				}else{
					message('warning', data.text);
					buttonEvent.removeClass('btn-danger');
					buttonEvent.addClass('btn-primary');
					buttonEvent.html('Dar Presença');
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
		"ajax": "<?=base_url('index.php/presences/shortcourses');?>",
		"language":{"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"},
		"columns": [
			{ "data": "idUser" },
			{ "data": "user" },
			{ "data": "shortcourse" },
			{ "data": "actions" }
		],
		"buttons": [
        'copy', 'excel', 'pdf'
    	],
    	dom: 'Bfrtip'
	});

	$('#shortcoursesTable tbody').on( 'click', '#addPresence', function () {
		var tr = $(this).closest('tr');
	    var row = dataTableShortcourse.row( tr );
	    buttonEvent = $(this).closest('#addPresence');
	    dataRow = row.data();
		console.log(dataRow);

		//idUser e idShortcourse
		var idUser = dataRow.idUser;
		var idShortcourse = buttonEvent.attr('idShortcourse');

		$.post("<?=base_url('index.php/presences/presenceShortcourse');?>", {idUser: idUser, idShortcourse:idShortcourse}, function(data, textStatus, xhr) {
			if(data.boolean == true)
			{
				if(data.button == 'S'){
					message('success', data.text);
					buttonEvent.removeClass('btn-primary');
					buttonEvent.addClass('btn-danger');
					buttonEvent.html('Cancelar Presença');
				}else{
					message('warning', data.text);
					buttonEvent.removeClass('btn-danger');
					buttonEvent.addClass('btn-primary');
					buttonEvent.html('Dar Presença');
				}
			}
			else
			{
				message('error', data.text);
			}
		}, "json");
	});

	// Presença codebar
	$('#code_lecture').keyup(function(e){
    if(e.keyCode == 13)
    {
      $.post("<?=base_url('index.php/presences/presenceLecture');?>", {idUser: $(this).val(), idLecture:$('#code_lectures').val()}, function(data, textStatus, xhr) {
      	if(data.boolean == true)
      	{
      		dataTableEvent.ajax.url("<?=base_url('index.php/presences/lectures');?>").load();
      		$('#code_lecture').val('');
      		message('success', data.text);
      	}
      	else
      	{
      		$('#code_lecture').val('');
      		message('error', data.text);
      	}
      }, "json");
    }
	});

		$('#code_shortcourse').keyup(function(e){
	    if(e.keyCode == 13)
	    {
	      $.post("<?=base_url('index.php/presences/presenceShortcourse');?>", {idUser: $(this).val(), idShortcourse:$('#code_shortcourses').val()}, function(data, textStatus, xhr) {
	      	if(data.boolean == true)
	      	{
	      		dataTableShortcourse.ajax.url("<?=base_url('index.php/presences/shortcourses');?>").load();
	      		$('#code_shortcourse').val('');
	      		message('success', data.text);
	      	}
	      	else
	      	{
	      		$('#code_shortcourse').val('');
	      		message('error', data.text);
	      	}
	      }, "json");
	    }
		});

		$(document).ready(function(){
	    $("#code_lecture").keydown(function(e){
	        if(e.which==17 || e.which==74){
	            e.preventDefault();
	        }else{
	            console.log(e.which);
	        }
	    });

	    $("#code_shortcourse").keydown(function(e){
	        if(e.which==17 || e.which==74){
	            e.preventDefault();
	        }else{
	            console.log(e.which);
	        }
	    });
		});

</script>
</body>
</html>