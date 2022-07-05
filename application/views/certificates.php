<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="page-header">
				<h1><i class="fa fa-certificate"></i> Certificados</h1>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="alert alert-info" role="alert">
				<b>Informação !</b> Segue abaixo os certificados disponíveis para geração.<br>
				<b>Lembre-se:</b> Só será possível gerar o certificado, se você participou de <u>pelo menos</u> uma palestra ou um minicurso.<br>
			</div>
			<? foreach($events as $event): ?>
			<div class="page-header">
				<h3><i class="fa fa-institution"></i> <?= $event->name; ?></h3>
			</div>
			<a class="btn btn-default btn-lg" href="<?= base_url('index.php/certificates/certificate/'.$event->idEvent); ?>" target="_blank">Participação</a>
			<a class="btn btn-default btn-lg" href="<?= base_url('index.php/certificates/certificateLecture/'.$event->idEvent); ?>" target="_blank">Palestrante</a>
			<a class="btn btn-default btn-lg" href="<?= base_url('index.php/certificates/certificateShortcourse/'.$event->idEvent); ?>" target="_blank">Ministrante</a>
			<? endforeach; ?>
		</div>
	</div>
</div>