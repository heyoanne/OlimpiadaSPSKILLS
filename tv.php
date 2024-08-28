<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="tv.css">
    <title>tela da TV</title>
</head>

<?php

require_once("API/common.php");
require_once("API/conn.php");

$var0 = file_get_contents("API/senhas.json");
$var1 = json_decode($var0, true);

$var2 = func02($var1, "atend.status", "Atendendo");

?>

<body>
    <nav class="nav">
        <img src="img/senai logo.png" class="senai">
    </nav>
    <div class="conteudo">
        <div class="senhas_qr">
            <div id="senhaChamada">
                <div class="senhaChamada_sub" id="esquerda">
                    <h1 class="senhaGuichê">Senha:</h1><br>
                    <?php if (isset($var2[0])): ?>
                        <p class="chamadoS"><b><?= $var2[0]["senha"] ?></b></p>
                    <?php endif; ?>
                </div>
                <div class="senhaChamada_sub" id="direita">
                    <h1 class="senhaGuichê">Guichê:</h1><br>
                    <?php if (isset($var2[0])): ?>
                        <p class="chamadoG"><b><?= $var2[0]["atend"]["guiche"] ?></b></p>
                    <?php endif; ?>
                </div>
            </div><br>
            <div id="qr">
                <div class="api-frontend">
                    <div class="monday">
                        <p id="temp"></p>
                    </div>
                    <div class="tuesday">
                        <p id="temp"></p>
                    </div>
                    <div class="wednesday">
                        <p id="temp"></p>
                    </div>
                    <div class="thursday">
                        <p id="temp"></p>
                    </div>
                    <div class="friday">
                        <p id="temp"></p>
                    </div>
                    <div class="saturday">
                        <p id="temp"></p>
                    </div>
                    <div class="sunday">
                        <p id="temp"></p>
                    </div>

                </div>

                <script>
                    var temperature = document.querySelectorAll("#temp")

                    fetch("https://api.open-meteo.com/v1/forecast?latitude=-23.66&longitude=-46.52&hourly=temperature_2m,precipitation_probability&timezone=America%2FSao_Paulo").then(res => res.json()).then(data => {

                        console.log(data)

                        const d = new Date();

                        setValues(temperature, data, d)

                        setInterval(() => {

                            setValues(temperature, data, d)

                        }, 3.6e+6);

                    })

                    function setValues(temperature, data, d) {

                        i = 0
                        timeskip = 24

                        temperature.forEach(element => {

                            var0 = timeskip * i

                            element.innerText = data["hourly"]["temperature_2m"][d.getHours() + var0] + data["hourly_units"]["temperature_2m"]

                            i++

                        });

                    }
                </script>
            </div>
        </div>
        <div class="historico">
            <div class="historico_sub" id="titulo">
                <h1 id="titulo_sub" style="text-align: center;">Historico de Senhas <br> Senha - Guichê</h1>
            </div>
            <div class="chamaSenha">
                <div id="senhasGuiche">
                    <?php if (isset($var2)): ?>
                        <div class="senhaGuiche_sub" id="chamadaSenha">
                            <?php foreach ($var2 as $var3): ?>
                                <p><?= $var3["senha"] ?></p>
                            <?php endforeach; ?>
                        </div>
                        <br>
                        <hr class="linhaH">
                        <div class="senhaGuiche_sub">

                            <?php foreach ($var2 as $var3): ?>
                                <p><?= $var3["atend"]["guiche"] ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <audio src="next-pass.mpeg" autoplay controls></audio>

    <script type="text/javascript">
        async function reloadOnUpdate() {

            j = 0;

            setInterval(() => {

                fetch("API/senhas.json").then(response => response.json()).then(data => {

                    if (j == 0) {
                        oldData = data[0]["senha"];
                    }

                    console.log(data[0]["senha"] + "------" + oldData)

                    if (data[0]["senha"] != oldData) {
                        location.reload()
                    }

                    j++

                    oldData = data[0]["senha"]
                })

            }, 2000);


        }

        reloadOnUpdate();

        window.addEventListener('storage', function(event) {
            console.log('Evento storage disparado:', event);
            if (event.key === 'senhaAtual') {
                atualizarTela();
            }
        });

        function atualizarTela() {
            var senhaChamada = JSON.parse(localStorage.getItem('senhaAtual'));
            if (senhaChamada) {
                var senhaAntiga = document.querySelector('.chamadoS b').innerText;
                var guicheAntigo = document.querySelector('.chamadoG b').innerText;


                document.querySelector('.chamadoS b').innerText = senhaChamada.senha;
                document.querySelector('.chamadoG b').innerText = senhaChamada.guiche;


                if (senhaAntiga && guicheAntigo && (senhaAntiga !== senhaChamada.senha || guicheAntigo !== senhaChamada.guiche)) {
                    var historico = JSON.parse(localStorage.getItem('historico')) || [];
                    historico.unshift({
                        senha: senhaAntiga,
                        guiche: guicheAntigo
                    });
                    localStorage.setItem('historico', JSON.stringify(historico));
                }

                var historico = JSON.parse(localStorage.getItem('historico')) || [];
                var divChamadaSenha = document.getElementById('chamadaSenha');
                var divGuiche = document.querySelector('.senhaGuiche_sub:not(#chamadaSenha)');
                divChamadaSenha.innerHTML = '';
                divGuiche.innerHTML = '';
                historico.forEach(item => {
                    var novoElementoSenha = document.createElement('p');
                    var novoElementoGuiche = document.createElement('p');
                    novoElementoSenha.innerText = item.senha;
                    novoElementoGuiche.innerText = item.guiche;
                    divChamadaSenha.appendChild(novoElementoSenha);
                    divGuiche.appendChild(novoElementoGuiche);
                });
            }
        }

        window.addEventListener('storage', function(event) {
            if (event.key === 'senhaAtual') {
                atualizarTela();
            }
        });

        atualizarTela();

        function limparHistorico() {
            localStorage.removeItem('historico');
            localStorage.removeItem('senhaAtual');

            var divChamadaSenha = document.getElementById('chamadaSenha');
            var divGuiche = document.querySelector('.senhaGuiche_sub:not(#chamadaSenha)');
            var chamadoS = document.querySelector('.chamadoS b');
            var chamadoG = document.querySelector('.chamadoG b');

            divChamadaSenha.innerHTML = '';
            divGuiche.innerHTML = '';
            chamadoS.innerText = '';
            chamadoG.innerText = '';
        }
    </script>
</body>

</html>