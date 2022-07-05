<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<html>
    <head>
        <style>
            body {font-family: sans-serif;
                font-size: 10pt;
            }
            p {    margin: 0pt;
            }
            td { vertical-align: top; }
            .items td {
                border-left: 0.1mm solid #000000;
                border-right: 0.1mm solid #000000;
            }
            table thead td { background-color: #EEEEEE;
                text-align: center;
                border: 0.1mm solid #000000;
            }
            .items td.blanktotal {
                background-color: #FFFFFF;
                border: 0mm none #000000;
                border-top: 0.1mm solid #000000;
                border-right: 0.1mm solid #000000;
            }
            .items td.totals {
                text-align: right;
                border: 0.1mm solid #000000;
            }
        </style>
    </head>
    <body>

        <table width="100%" style="font-family: serif;" cellpadding="10">
            <tr>
                <td width="45%" style="border: 0.1mm solid #888888;">
                    <h3>SEMANA DA COMPUTAÇÃO DE PRESIDENTE PRUDENTE</h3>
                    <h3>FICHA DE PAGAMENTO</h3>
                    <h4>Faculdade de Ciências e Tecnologia de Presidente Prudente - FCT/UNESP</h4>
                    <h5>Data da Emissão: <?=date('d/m/Y')?> - Pagamento usuário #<?= $this->session->userdata('id'); ?> - <?= $user->name; ?></h5>
                </td>
            </tr>
        </table>

        <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;" cellpadding="8">
            <thead>
                <tr>
                    <td width="15%">#</td>
                    <td width="10%">QUANTIDADE</td>
                    <td width="45%">ITEM</td>
                    <td width="15%">VALOR</td>
                    <td width="15%">TOTAL</td>
                </tr>
            </thead>
            <tbody>
                <!-- ITEMS HERE -->
                <? $amountShortcourse = 0; $amountEvent = 0; ?>
                <? foreach($shortcourses as $shortcouse): ?>
                <tr>
                    <td align="center">1</td>
                    <td align="center">1</td>
                    <td>Minicurso: <?=$shortcouse->name; ?></td>
                    <? if($shortcouse->amount > 0): ?>
                    <td align="right">R$ <?=$shortcouse->amount; ?></td>
                    <td align="right">R$ <?=$shortcouse->amount; ?></td>
                    <? else: ?>
                    <td align="right">Isento</td>
                    <td align="right">Isento</td>
                    <? endif; ?>
                </tr>
                <? $amountShortcourse += $shortcouse->amount; ?>
                <? endforeach; ?>
                <? foreach($events as $event): ?>
                <tr>
                    <td align="center">2</td>
                    <td align="center">1</td>
                    <td><?=$event->name; ?></td>
                    <? if($event->amount > 0): ?>
                    <td align="right">R$ <?=$event->amount; ?></td>
                    <td align="right">R$ <?=$event->amount; ?></td>
                    <? else: ?>
                    <td align="right">Isento</td>
                    <td align="right">Isento</td>
                    <? endif; ?>
                </tr>
                <? $amountEvent += $event->amount; ?>
                <? endforeach; ?>
                <!-- END ITEMS HERE -->
                <tr>
                    <td class="blanktotal" colspan="3" rowspan="6"></td>
                    <td class="totals">Subtotal:</td>
                    <td class="totals">R$ <?=($amountEvent + $amountShortcourse)?>.00</td>
                </tr>
                <tr>
                    <td class="totals"><b>TOTAL:</b></td>
                    <td class="totals"><b>R$ <?=($amountEvent + $amountShortcourse)?>.00</b></td>
                </tr>
            </tbody>
        </table>
        <br>
        <br>
        <div>
            <b>_____________________________________________________</b>
        </div>
        <div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            &nbsp;&nbsp;<b>AUTENTICAÇÃO FUNDACTE</b>
        </div><br>
        <h5 align="center">1ª Via - Fundact | 2ª Via - Comissão Organizadora | 3ª Via - Participante</h5>
        <h4 align="center">Pagamento apenas pela FUNDACTE - FCT/UNESP</h4>
        <!-- <h4 align="center">Receber após o início do evento</h4> -->
    </body>
</html>
