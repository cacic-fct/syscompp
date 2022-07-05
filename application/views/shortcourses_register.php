<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h1><i class="fa fa-book"></i> Minicursos</h1>
			</div>
			<div class="alert alert-info" role="alert">
				<b>Informação !</b><br>
				Segue abaixo os minicursos disponíveis para inscrição.<br>
				Lembre-se que só serão aparecerão os minicursos pertencentes ao evento que você se inscreveu.<br>
				As inscrições poderão ser realizadas até o período do evento, porém não há garantia de vagas nos minicursos. <br>
			</div>
			<div class="alert alert-warning" role="alert">
				<b>Problemas de inscrição ?</b> Entre em contato no email <i>fabio@takaki.me</i> que resolveremos pra você.<br>
				<b>Faça a inscrição com sabedoria, pois após realizada, não poderá ser alterada sem entrar em contato conosco.</b>
			</div>
			<div class="alert alert-danger" role="alert">
				<b>Lembre-se !</b> Verifique <u>ANTES</u> de se inscrever em qualquer minicurso, se não irá chocar horário com os demais que você já se inscreveu.<br>
				Acesse <u><a href="http://docs.fct.unesp.br/semanas/secompp/" target="_blank">AQUI</a></u> o site para verificar a programação da SECOMPP 2018.
			</div>
		</div>
	</div>

		<? foreach($events as $eventKey => $event): ?>
		<div class="row">
			<div class="col-lg-12">
				<div class="page-header">
					<h3><i class="fa fa-institution"></i> <?= $event['event']; ?></h3>
				</div>
			</div>
		</div>
		<? foreach($event['shortcourses'] as $key => $shortcourse): ?>
		<? if($key%2 == 0): ?>
		<div class="row">
		<? endif; ?>
		<div class="col-md-6">
			<div class="panel panel-info">
				<div class="panel-heading">
				    <h3 class="panel-title"><i class="fa fa-book"></i> <?= $shortcourse->name; ?></h3>
				</div>
				<div class="panel-body">
					<b>Ministrado por: 
						<? for ($i=0; $i < count($shortcourse->panelists) - 1; $i++): ?>
						<i><?= $shortcourse->panelists[$i]; ?></i>,
						<? endfor; ?>
						<i><?= $shortcourse->panelists[count($shortcourse->panelists) - 1]; ?></i>
					</b>
					<br>
			    	<b>Vagas: <?= $shortcourse->vacancies; ?></b>
			  	</div>
			  	<div class="panel-footer text-right" style="background:#fff;" id="actions">
			  		<button type="button" class="btn btn-default" data-toggle="modal" data-target="#<?= $eventKey.'-'.$key; ?>">
			  		  Informações
			  		</button>
			  		<? if($shortcourse->isRegistered){ ?>
			  		<button class="btn btn-success" disabled>Inscrito</button>
			  		<? }else{ ?>
			  		<button class="btn btn-primary" id="subscribe-shortcourse" idShortcourse="<?=$shortcourse->idShortcourse;?>" idEvent="<?=$event['idEvent'];?>">Inscrever-se</button>
			  		<? } ?>
			  	</div>
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="<?= $eventKey.'-'.$key; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		    <div class="modal-dialog" role="document">
			    <div class="modal-content">
				    <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" id="myModalLabel">Informações</h4>
				    </div>
				    <div class="modal-body">
				        <?= $shortcourse->description; ?>
				    </div>
				    <div class="modal-footer">
				        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
				    </div>
			    </div>
			</div>
		</div>
		<? if($key%2 != 0): ?>
		</div>
		<? endif; ?>
		<? endforeach; ?>
		<? endforeach; ?>
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
				<p>Após se inscrever <b>NÃO</b> será possível alterar sua decisão e será gerado a fatura para pagamento.</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-success" id="confirm-subscribe">Inscrever-se</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
	var idShortcourse;
	var idEvent;
	var buttonEvent;

	$('.panel-footer').on('click', '#subscribe-shortcourse', function () {
		buttonEvent 	= $(this).closest('#subscribe-shortcourse');
		idShortcourse 	= buttonEvent.attr('idShortcourse');
		idEvent 		= buttonEvent.attr('idEvent');
		$('#confirm-modal').modal('show');
	});

	$('#confirm-subscribe').click(function(){
		$.post("<?=base_url('index.php/shortcourses/registerShortcourse');?>", {idEvent: idEvent, idShortcourse: idShortcourse}, function(data, textStatus, xhr) {
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