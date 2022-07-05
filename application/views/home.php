<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h1><i class="fa fa-home"></i> Página Inicial</h1>
			</div>
			<p class="justify">
				Seja bem-vindo ao sistema SYSCOMPP. Além dos detalhes do evento que você se inscreveu, você poderá se inscrever em outros eventos
				que estão acontecendo na <i>FCT UNESP Presidente Prudente</i>.
				<br>
				Qualquer dúvida estou a disposição.<br>
				Atenciosamente,<br>
				Fábio da Silva Takaki.<br>
				Administrador do Sistema<br>
				<a href="mailto:fabio@takaki.me">fabio@takaki.me</a>
			</p>
		</div>

		<? if($free): ?>
		<div class="col-lg-12">
			<div class="alert alert-info" role="alert">
			  	<b>ATENÇÃO !</b> Você se cadastrou com sucesso para a SECOMPP. Com isso, você tem direito ao evento WRVA <b><u>GRATUITAMENTE</u></b> ! Inscreva-se agora !
			</div>
		</div>
		<? endif; ?>

		<div class="col-lg-12">
			<div class="page-header">
				<h3><i class="fa fa-institution"></i> Eventos</h3>
			</div>
			<table id="eventsTable" class="table table-hover">
				<thead>
					<tr>
						<th>#</th>
						<th>Evento</th>
						<th>Início</th>
						<th>Fim</th>
						<th>Pagamento</th>
						<th>Ações</th>
					</tr>
				</thead>
			</table>
		</div>
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
				<p><b>Tem certeza que deseja se inscrever ?</b></p>
				<p>Após se inscrever não será possível alterar sua decisão e será gerado a fatura para pagamento.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-success" id="confirm-subscribe">Inscrever-se</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
	//dataTables
	var dataTableEvent =
	$('#eventsTable').DataTable({
		"ajax": "<?=base_url('index.php/system/dataTablesEvent');?>",
		"language":{"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Portuguese-Brasil.json"},
		"columns": [
			{ "data": "idEvent" },
			{ "data": "name" },
			{ "data": "start" },
			{ "data": "end" },
			{ "data": "payment" },
			{ "data": "actions" }
		]
	});

	var dataEvent;
	var buttonEvent;
	$('#eventsTable tbody').on( 'click', '#subscribe', function () {
		var tr = $(this).closest('tr');
	    var row = dataTableEvent.row( tr );
	    buttonEvent = $(this).closest('#subscribe');
	    dataEvent = row.data();
		console.log(dataEvent);
		$('#confirm-modal').modal('show');
	});

	$('#confirm-subscribe').click(function(){
		$.post("<?=base_url('index.php/system/registerEvent');?>", {idEvent: dataEvent.idEvent}, function(data, textStatus, xhr) {
			if(data.boolean == true)
			{
				message('success', data.text);

				buttonEvent.removeClass('btn-primary');
				buttonEvent.addClass('btn-success');
				buttonEvent.attr('disabled', 'disabled');
				buttonEvent.html('Inscrito');

				$('#confirm-modal').modal('hide');
			}
			else
			{
				$('#confirm-modal').modal('hide');
				message('error', data.text);
			}
		}, "json");
	});
</script>