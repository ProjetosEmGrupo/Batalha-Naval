<!DOCTYPE html>
<html>
<head>
	<title>Batalha Naval - Jogo</title>
	<link rel="icon" href="img/icon.ico">
	<link rel="stylesheet" type="text/css" href="css/cores.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">

<!-- CSSs REFERENTES AO JOGO.
  <link rel="stylesheet" href="css/normalizacao.css">
  <link rel="stylesheet" href="css/estrutura.css">
-->

<link rel="stylesheet" href="css/game.css">
</head>

<body>
<!--
BARRA SUPERIOR
-->
<nav class="navbar cor-barra">
  <a class="navbar-brand" href="http://localhost/sistema/aluno/menu-jogo"><img class="img-responsive" src="img/logo.png" alt="LOGO" width="165" height="72"></a>
</nav>
<!--
CORPO DA PAGINA
-->
<div class="container-fluid">
    <div class="container col-sm-12">
        <div class="text-center">
            <br>
            <br>
            <h1 class="h3 mb-2 font-weight-normal">Jogo</h1>
            <br>
            <br>
            <!--TABULEIRO-->
            <section id="game" ></section>
        </div>
        <div class="text-center">
            <br>
            <label id="sound-checkbox">
                <input type="checkbox" checked>
                <span class="label-body">Som</span>
            </label>&ensp;
            <a href="#"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#desistirJogo">Desistir</button></a>
        </div>
        <audio id="melody" loop>
            <source src="sounds/melody.mp3"/>
            <source src="sounds/melody.wav"/>
        </audio>
        <audio id="miss">
            <source src="sounds/miss.mp3"/>
            <source src="sounds/miss.wav"/>
        </audio>
        <audio id="hit">
            <source src="sounds/hit.mp3"/>
            <source src="sounds/hit.wav"/>
        </audio>
        <audio id="win">
            <source src="sounds/win.mp3"/>
            <source src="sounds/win.wav"/>
        </audio>
        <audio id="click">
            <source src="sounds/click.mp3"/>
            <source src="sounds/click.wav"/>
        </audio>
    </div>

    <nav class="navbar fixed-bottom navbar-light">
      <a href="#bannerformmodal" data-toggle="modal" data-target="#ajuda">Ajuda</a>
  </nav>
</div>
<br>

<div class="modal" tabindex="-1" id="desistirJogo" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sair</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Deseja sair da partida?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">N&atilde;o</button>
                <a href="http://localhost/sistema/aluno/desiste-jogo"><button type="button" class="btn btn-info" >Sim</button></a>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">Ok</button>
        </div>
    </div>
</div>
</body>
<div class="modal" tabindex="-1" id="ajuda" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ajuda</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div>
  <div class="modal-body">
    <p>Esse é o seu jogo. Aqui você jogar a batalha naval conta o sistema. Para conseguir uma boa pontuação basta não errar nenhuma questão na prova e derrubar todas as embarcações inimigas usando poucas bombas.</p>
    <p>Seu adversário já posicionou todas suas embarcações, então basta apenas começar a atacá-lo.
    Você possui uma pontuação, e a cada vez que você o ataca ela diminui. Sua pontuação só poderá ser consultada no fim da partida (Pontuação = (10000 - (100 * nº  bombas na água)) * (questões corretas * 10)%).</p>
    <p>Para atacar basta com que você escolha e clique em alguma a posição no tabuleiro. Ao acertar um tiro na água, a posição do tabuleiro fica azul. Sinalizando que você errou o tiro, já ao acertar a posição ficará na cor preta.</p>
    <br>
    <p>O jogo possui som, caso você queira desabilitá-lo, clique no na opção Som.</p>
    <p>Você deverá joga-lo até derrubar todas as embarcações do seu inimigo.</p>
    <p>Caso você queira desistir basta clicar em Desistir e confirmar a mensagem.</p>
    <div class="modal-footer">
      <button type="button" class="btn btn-info" data-dismiss="modal">Ok</button>
  </div>
</div>
</div>
</div>



<!-- SCRIPTS REFERENTES AO JOGO -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="js/game.js"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>
