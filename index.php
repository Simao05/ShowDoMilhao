<?php

session_start();

include('Conexao.php');

?>
<html>
    <head>
        <title> Show do Milhão </title>
        <meta charset="UTF-8">
        <link rel="icon" href="img/icone-etec.png" />
        <link rel="stylesheet" href="css/Reset.css" />
        <link rel="stylesheet" href="css/estilos.css" />
    </head>
    <body>
   
    <div class="SdM_imagem_fundo">
        <img src="img/logo.jpg">
    </div>
    
    <div class="SdM_imagem_logo">
        <img src="img/logo2.jpg">
    </div>
    <audio id="audio" onended="stop()">
        <source src="audio/0.mp3" type="audio/mpeg" />
    </audio> 
<script>
    audio = document.getElementById('audio');

    function play(){

        audio.play();
        $('#label').css({'display':'none'});
        
    }

    function stop(){

        $('#button').click();
        
    }

    function stop_questao(){

        audio = document.getElementById('questao_audio');
        audio.play();
        
    }

</script>
<?php
    
    if(isset($_POST['enviar'])){

        if($_POST['enviar']=='comecar'){
            
            $_SESSION['SdM_Questoes_Respondidas'] = 1;
            $acao = 'questao';

        }

        if($_POST['enviar']=='responder'){
			
			if((isset($_POST['SdM_Resposta']))and(isset($_POST['SdM_Questao_ID']))){
				
				$resposta = $_POST['SdM_Resposta'];
				$questao_id = $_POST['SdM_Questao_ID'];
				
				$sql = "SELECT Alternativa_correta FROM alternativas WHERE ID_Alternativa = ".$questao_id." AND Letra = '".$resposta."'";

           		$resultado = mysqli_query($conexao,$sql);
            	if (!$resultado){ die("Falha na consulta: ".mysqli_error($conexao) ); }
				
				$Resultado_Questao = mysqli_fetch_array( $resultado, MYSQLI_NUM);
				
				if($Resultado_Questao[0] == 'Sim'){
				    
                    $questoes = $_SESSION['SdM_Questoes_Respondidas'];

                    if($questoes == 16){

                        echo "<audio autoplay=\"autoplay\">";
                        echo "<source src=\"audio/19.wav\" type=\"audio/wav\" />";
                        echo "</audio>";
                        $acao = 'inicio';

                    }
                    else{
                        
                        echo "<audio autoplay=\"autoplay\" onended=\"stop_questao()\">";
                        echo "<source src=\"audio/18.wav\" type=\"audio/wav\" />";
                        echo "</audio>";

                        $_SESSION['SdM_Questoes_Respondidas'] = $questoes + 1;

					   $acao = 'questao';
                    }
				}
				else{
				    echo "<audio autoplay=\"autoplay\">";
                    echo "<source src=\"audio/17.wav\" type=\"audio/wav\" />";
                    echo "</audio>";
                    $acao = 'inicio';
				}
				
				
			}
			
        }

        if($acao == 'questao'){
        
            $questoes = $_SESSION['SdM_Questoes_Respondidas'];

            if($questoes != 1){
                
                echo "<audio id=\"questao_audio\">";
                
            }else{

                echo "<audio autoplay=\"autoplay\">";

            }
            echo "<source src=\"audio/".$questoes.".wav\" type=\"audio/wav\" />";
            echo "</audio>";

            if($questoes <= 5){
                $nivel = 1;
            }

            if(($questoes > 5)and($questoes <= 10)){
                $nivel = 2;
            }

            if($questoes > 10){
                $nivel = 3;
            }
        
            if($questoes % 5 != 0){
                if($questoes == 16){
                    $recompensa = "Valendo R$ 1.000.000 Reais!";
                }else{
                    $recompensa = "Valendo ".($questoes % 5) * (10 ** ($nivel + 2))." Reais!";
                }
            }
            else{
                $recompensa = "Valendo ".(5 * (10 ** ($nivel + 2)))." Reais!";
            }
        
            $sql = "SELECT * FROM perguntas WHERE Nivel = ".$nivel." ORDER BY RAND() LIMIT 1";

            $resultado = mysqli_query($conexao,$sql);
            if (!$resultado){ die("Falha na consulta: ".mysqli_error($conexao) ); }
        
            $questao = mysqli_fetch_array( $resultado, MYSQLI_NUM);

            $sql = "SELECT * FROM alternativas WHERE ID_Alternativa = ".$questao[0]." ORDER BY Letra ASC";

            $resultado = mysqli_query($conexao,$sql);
            if (!$resultado){ die("Falha na consulta: ".mysqli_error($conexao) ); }
        
            $i = 0;
            while($alternativas = mysqli_fetch_array( $resultado, MYSQLI_NUM)){
                $letra[$i] = $alternativas[2];
                $i++;
            }

?>

    <form name="questoes" action ="#" method="post">
        
        <div class="SdM_Form_Questoes">

            <div class="SdM_Valor">

                <?php

                    echo $recompensa;
                
                ?>

            </div>

            <div class="SdM_Questao">

                <div class="SdM_Questao_text">

                    <?php

                        echo $questao[1];

                    ?>
                
                </div>

            </div>

            <div class="SdM_Alternativas">   
        
                <div class="SdM_Alternativa">
                    
                    <label for="SdM_Alternativa_A">

                        <div id="SdM_Alternativa_Selecionada_A">

                            A

                        </div>

                    </label>

                    <?php

                        echo $letra[0];

                    ?>

                    <input name="SdM_Resposta" id="SdM_Alternativa_A" type="radio" value="A">
                
                </div>

                <div class="SdM_Alternativa">
                    
                    <label for="SdM_Alternativa_B">

                        <div id="SdM_Alternativa_Selecionada_B">

                            B

                        </div>
                        
                    </label>

                    <?php

                        echo $letra[1];

                    ?>

                    <input name="SdM_Resposta" id="SdM_Alternativa_B" type="radio" value="B">
                
                </div>

                <div class="SdM_Alternativa">
                    
                    <label for="SdM_Alternativa_C">

                        <div id="SdM_Alternativa_Selecionada_C">

                            C

                        </div>
                        
                    </label>

                    <?php

                        echo $letra[2];

                    ?>

                    <input name="SdM_Resposta" id="SdM_Alternativa_C" type="radio" value="C">
               
                </div>

                <div class="SdM_Alternativa">
                    
                    <label for="SdM_Alternativa_D">

                        <div id="SdM_Alternativa_Selecionada_D">

                            D

                        </div>
                        
                    </label>

                    <?php

                        echo $letra[3];

                    ?>

                    <input name="SdM_Resposta" id="SdM_Alternativa_D" type="radio" value="D" >
                
                </div>
            
            </div>
            
            <div class="SdM_Responder" >
                <label for="button_escolha">
                    <div class="SdM_button_escolha">
                        Enviar
                    </div>
                </label>
                <input name="enviar" id="button_escolha" type="submit" value="responder" >
            </div>

        </div>
		
        <input name="SdM_Questao_ID" type="hidden" value="<?php echo $questao[0]; ?>">
    </form>
    
<?php
        }
        
    }
    else{
        $acao = 'inicio';
    }

    if($acao == 'inicio'){

?>
    <form name="comecar_jogo" action="#" method="POST">
        <label onclick="play()" id="label">
            <div class="SdM_button">
                Começar!
            </div>
        </label>
        <input name="enviar" id="button" type="submit" value="comecar">
    </form>
<?php
    }
?>
    <div class="SdM_rodape">
        <div class="SdM_ETEC">
            Etec João Baptista de Lima Figueiredo - Eletrô
        </div>
        <div class="SdM_Alunos">
            Desenvolvido pelos alunos do 2º ano de informática
        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/show_do_milhao.js"></script>

    </body>

</html>