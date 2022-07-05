<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<br><br><br>
<div class="container">
	<div class="row">
		<div class="col-md-12" style="text-align:center;">
			<h1 style="font:50px Verdana; font-weight: bold;">Certificado</h1>
		</div>
		<div class="col-md-12">
			<div style="text-align: justify; font:13px Arial !important;">

				<!--Certificamos, para os devidos fins, que,
				<b><?= $user->name; ?></b>, portador do RG. <?= $user->rg ?> e do CPF. <?= $user->cpf ?>,
				participou durante o evento <b><?= $event->name ?></b>, correspondente ao ano de <?= $event->year ?>, sediado na <?= $event->location ?>.-->

				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Certificamos que <b><?= $user->name; ?></b>, RG: <?= $user->rg ?>, CPF: <?= $user->cpf ?>, participou do evento <b><?= $event->name ?></b> realizado na <?= $event->location ?>, correspondente ao ano de <?= $event->year ?>, com presença nas seguintes atividades:
				<br><br>

				<?php if (count($lectures) > 0): ?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<b>Palestras:</b>
				<?php foreach($lectures as $lecture): ?>
				&bull; <?= $lecture->name; ?> - <u>Carga Horária:</u> 2h;
				<?php endforeach; ?> 
				<br><br>
				<?php endif;?>

				<?php if (count($shortcourses) > 0): ?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<b>Minicursos:</b>
				<?php foreach($shortcourses as $shortcourse): ?>
				&bull; <?= $shortcourse->name; ?> - <u>Carga Horária:</u> <?=$shortcourse->workload;?> h;
				<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
