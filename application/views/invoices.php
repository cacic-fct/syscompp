<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <h1><i class="fa fa-money"></i> Ficha de Pagamento</h1>
            <div class="alert alert-info" role="alert">
                <?php if($encardio){ ?>
                <b>Atenção !</b> O pagamento deverá ser realizado por meio de depósito identificado na seguinte conta bancária:<br><br>
                <b>BANCO SANTANDER<br>
                <b>Agência:</b> 0033 <br>
                <b>Conta Poupança:</b> 60-051216-5 <br>                        
                <b>Carolina Takahashi</b> <br>                      
                Enviar comprovante por e-mail com assunto <b>Confirmação de Pagamento</b> para o destinatário <b style="color:red">poslabestresse@yahoo.com.br</b>
                <br><br><br>
                <b style="font-size:20px; color:red;">VALOR: R$ <?= $amount; ?></b>
                <?php } else { ?>
                <b>Atenção !</b> A ficha de pagamento deverá ser impressa, e o pagamento realizado exclusivamente na sede da FUNDACTE 
                (Fundação de Ciência, Tecnologia e Ensino), nas  dependências da FCT/UNESP, ou deverá realizar o pagamento por meio de depósito 
                identificado na seguinte conta bancária:<br><br>
                <b>BANCO SANTANDER<br>
                AG. 4299<br>
                C/C. 13001302-0<br>
                Fundação de Ciência Tecnologia e Ensino</b>
                <br><br>
                No caso de depósito bancário, um e-mail contendo em anexo o comprovante de pagamento (identificado e digitalizado) deve ser então enviado ao endereço fundacte@fct.unesp.br com o assunto “Inscrição SECOMPP - [Nome do inscrito]”.
                <br><br>
<!--                 A Via da Comissão pode ser entregue no LaPesCA ou LaPESA em que se encontram os integrantes da comissão. Segue alguns integrantes:<br>
                <ul>
                    <li>Fábio da Silva Takaki</li>
                    <li>Marco Antônio da Silva Rocha</li>
                    <li>Pedro Gomes</li>
                    <li>Leandro Ungari</li>
                    <li>Bruno Lima</li>
                </ul>
                <br> -->
				<i>1ª Via - Fundacte | 2ª Via - Comissão | 3ª Via - Participante</i><br>
                <u>Entregar 2a Via para a comissão (Professores Danilo Eler ou Celso Olivete) quando fizer o pagamento ou durante o evento para que sua inscrição seja efetivada no sistema.</u>
                <br>
			    <a class="btn btn-lg btn-default" href="<?=base_url('index.php/system/invoice');?>" target="_blank">Gerar Ficha</a>
                <?php } ?>
			</div>
        </div>
        <?php if(!$encardio){ ?>
        <div class="col-lg-12">
            <h3><i class="fa fa-map"></i> Localização da FUNDACTE</h3>
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d14784.481369775802!2d-51.407434!3d-22.1213869!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xcd14201988c730f!2sFunda%C3%A7%C3%A3o+de+Ci%C3%AAncia%2C+Tecnologia+e+Ensino!5e0!3m2!1spt-BR!2sbr!4v1445291696295" frameborder="0" style="border:0; height:200px; width:100%;" allowfullscreen></iframe>
        </div>
        <?php } ?>
    </div>
</div>