<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Etiquetas</title>
        <style type="text/css">
            *{
                margin:0;
                padding:0;
            }
            td{
                height:140px;
                text-align:center;
            }
        </style>
    </head>
    <body>
        <table>
                    <? foreach($users as $key => $user): ?>
                    <? if($key % 2 == 0){ ?><tr><? } ?>
                        <td>
                            <p><?=$user['name']; ?></p>
                            <? if(!empty($user['shortcourses'])): ?>
                            <b style="font-size:10px;">
                            <? foreach($user['shortcourses'] as $shortcourse): ?>
                                <?= $shortcourse->code; ?>
                            <? endforeach; ?>
                            </b>
                            <? endif;?>
                            <br>
                            <img src="<?=base_url()."assets/barcode/barcode.php"; ?>?text=<?=$user['idUser']; ?>" />
                        </td>
                    <? if($key % 2 != 0){ ?></tr><? } ?>
                    <? endforeach; ?>
        </table>
    </body>
</html>