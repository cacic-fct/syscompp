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
        Certificamos que <b><?= $user->name; ?></b>, RG: <?= $user->rg ?>, CPF: <?= $user->cpf ?>, participou como ministrante do evento <b><?= $event->name ?></b> realizado na <?= $event->location ?>, correspondente ao ano de <?= $event->year ?>, proferindo os seguintes minicursos:
        <br><br>
        <?php if (count($shortcourses) > 0): ?>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <b>Minicursos:</b>
        <?php foreach($shortcourses as $shortcourse): ?>
        &bull; <?= $shortcourse->name; ?>;
        <?php endforeach; ?> 
        <br><br>
        <?php endif;?>
      </div>
    </div>
  </div>
</div>
