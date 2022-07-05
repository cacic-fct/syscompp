<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<br><br><br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div style="text-align: justify;">

				Certificamos, para os devidos fins, que,
				<b><?= $user->name; ?></b>, portador do RG. <?= $user->rg ?> e do CPF. <?= $user->cpf ?>,
				participou durante o evento <b><?= $event->name ?></b>, correspondente ao ano de <?= $event->year ?>, sediado na <?= $event->location ?>.

			</div>
		</div>
	</div>
</div>

<?php if (count($lectures) > 0): ?>
<hr style="height:1px;border-width:0;color:gray;background-color:gray">
<br>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?php if (count($lectures) > 1): ?>
			Participando das seguintes palestras: <br>
			<?php foreach($lectures as $lecture): ?>
				<small>&nbsp;&nbsp;&nbsp;&nbsp;<?= $lecture->name; ?></small>
				<br>
			<?php endforeach; ?>
			<br>
			<?php endif; ?>
			<?php if (count($lectures) == 1): ?>
			Participando das seguinte palestra: <br>
			<?php foreach($lectures as $lecture): ?>
				<small>&nbsp;&nbsp;&nbsp;&nbsp;<?= $lecture->name; ?></small>
				<br>
			<?php endforeach; ?>
			<br>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php endif ?>

<?php if (count($shortcourses) > 0): ?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<?php if (count($shortcourses) > 1): ?>
			E dos seguintes minicursos: <br>
			<?php foreach($shortcourses as $shortcourse): ?>
				<small>&nbsp;&nbsp;&nbsp;&nbsp;<?= $shortcourse->name; ?></small>
				<br>
			<?php endforeach; ?>
			<br>
			<?php endif; ?>
			<?php if (count($shortcourses) == 1): ?>
			E dos seguinte minicurso: <br>
			<?php foreach($shortcourses as $shortcourse): ?>
				<small>&nbsp;&nbsp;&nbsp;&nbsp;<?= $shortcourse->name; ?></small>
				<br>
			<?php endforeach; ?>
			<br>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php endif ?>