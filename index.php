<!DOCTYPE html>
<html lang="pt-br">

<?php

require_once("API/common.php");
require_once("API/conn.php");

$var0 = file_get_contents("API/senhas.json");
$var1 = json_decode($var0, true);

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Atendimento</title>
    <link rel="stylesheet" href="atend.css">
</head>

<body>

    <main>

        <div class="content-um">
            <!-- Selecionar guiche -->
            <div class="guicheBorderBox">
                <div class="guicheBox">
                    <h1>SELECIONE SEU GUICHÊ:</h1>

                    <div class="todosGuiches">
                        <button class="guiche" data-guiche="1" onclick="selecionarGuiche('1')">

                            <img src="img/1.png">
                        </button>
                        <button class="guiche" data-guiche="2" onclick="selecionarGuiche('2')">
                            <img src="img/2.png">
                        </button>
                        <button class="guiche" data-guiche="3" onclick="selecionarGuiche('3')">
                            <img src="img/3.png">
                        </button>
                        <button class="guiche" data-guiche="4" onclick="selecionarGuiche('4')">
                            <img src="img/4.png">
                        </button>
                    </div>

                </div>
            </div>


            <!-- Próximos -->
            <div class="proximosBox">
                <h1>PRÓXIMOS:</h1>

                <div id="filaUsuarios">
                    <div class="proximos categorias">
                        <div class="prox-nome">
                            <h3>Nome:</h3>

                        </div>
                        <div class="prox-tipo">
                            <h3>Tipo:</h3>

                        </div>
                        <div class="prox-senha">
                            <h3>Senha:</h3>
                        </div>
                    </div>

                    <?php if (isset($var1)): ?>

                        <?php

                        $var4 = func02($var1, "atend.status", "Na fila");

                        ?>

                        <?php foreach ($var4 as $var2): ?>
                            <form method="post" action="API/process-server.php" class="proximos">
                                <div class="prox-nome">
                                    <p class="proximo-nome"><?= $var2["nome_completo"] ?></p>

                                </div>
                                <div class="prox-tipo">
                                    <p class="proximo-tipo" style="color:' + cor + ';"><?= $var2["tipo_atend"] ?></p>
                                </div>
                                <div class="prox-senha">
                                    <p><?= $var2["senha"] ?></p>
                                </div>

                                <input type="hidden" name="guiche" id="guiche" value="" required>
                                <input type="hidden" name="senha" value="<?= $var2["senha"] ?>">
                                <input type="hidden" name="proctype" value="callpass">

                                <div class="botoes-chamar">
                                    <button class="button-chamar">Chamar</button>
                                </div>
                            </form>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <div class="content-two">
            <!-- atendimento -->
            <div class="atendimentoBox">
                <h1>EM ATENDIMENTO</h1>

                <?php if ($var1): ?>

                    <?php

                    $var2 = func02($var1, "atend.status", 'Atendendo');

                    ?>

                    <?php if (isset($var2[0])): ?>

                        <?php $var3 = $var2[0]; ?>

                        <div class="inputAtendimentoList">
                            <div class="atendimento">
                                <div class="atend">
                                    <h3>Nome:</h3>
                                    <p class="nome-atendimento"><?= $var3["nome_completo"] ?></p>
                                </div>

                                <div class="atend">
                                    <h3>Tipo de Solicitação:</h3>
                                    <p class="tipo-atendimento"><?= $var3["tipo_atend"] ?></p>
                                </div>
                            </div>
                        </div>

                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <!-- Histórico -->

            <?php

            $var5 = func02($var1, "atend.status", "Atendendo");

            ?>

            <div class="historicoBox">
                <h1>HISTÓRICO:</h1>

                <div class="historico">
                    <div class="hist historico-nome">
                        <h3>Nome:</h3>

                        <?php foreach ($var5 as $var2): ?>

                        <p><?= $var2["nome_completo"] ?></p>

                        <?php endforeach; ?>
                    </div>

                    <div class="hist historico-senha">
                        <h3>Senha:</h3>

                        <?php foreach ($var5 as $var2): ?>

                            <p><?= $var2["senha"] ?></p>

                        <?php endforeach; ?>

                    </div>
                </div>
                <span>Ver tudo</span>
            </div>

        </div>
        </div>

        <button class="button-atendido"> <a href="user.html"> Página TV </a></button>
        <button class="button-atendido"> <a href="tv.html"> user </a></button>
    </main>

    <!-- Script -->
    <script type="text/javascript">
        var guicheSelecionado = '';

        function enviarParaTV(senha, nome) {
            if (!guicheSelecionado) {
                alert('Por favor, selecione um guichê antes de chamar a senha.');
                return;
            }

            console.log('Enviando senha para a TV: ' + senha + ' - Guichê: ' + guicheSelecionado);
            localStorage.setItem('senhaAtual', JSON.stringify({ senha: senha, guiche: guicheSelecionado }));

            // Adicionar a senha ao histórico
            adicionarAoHistorico(senha);

            // Exibir o nome na área de atendimento
            document.getElementById('nomeAtendimento').innerText = nome;

            removerSenhaChamada(senha);
        }

        function adicionarAoHistorico(senha) {
            var historicoNomeElement = document.getElementById('historicoNome');
            var historicoSenhaElement = document.getElementById('historicoSenha');

            // Obter o nome do próximo da fila
            var proximoNomeElement = document.querySelector('.proximo-nome');
            var proximoNome = proximoNomeElement ? proximoNomeElement.innerText : 'Nome Desconhecido';

            if (historicoNomeElement && historicoSenhaElement) {
                // Obter o conteúdo existente do histórico
                var historicoNomeConteudo = historicoNomeElement.innerHTML;
                var historicoSenhaConteudo = historicoSenhaElement.innerHTML;

                // Adicionar a nova senha ao histórico
                historicoNomeElement.innerHTML = historicoNomeConteudo + '<h3></h3><p>' + proximoNome + '</p>';
                historicoSenhaElement.innerHTML = historicoSenhaConteudo + '<h3></h3><p>' + senha + '</p>';
            }
        }

        function removerSenhaChamada(senhaChamada) {
            var usuariosSenhas = JSON.parse(localStorage.getItem('usuariosSenhas')) || [];
            var indexUsuarioChamado = usuariosSenhas.findIndex(usuarioSenha => usuarioSenha.senha === senhaChamada);
            if (indexUsuarioChamado !== -1) {
                usuariosSenhas.splice(indexUsuarioChamado, 1);
                localStorage.setItem('usuariosSenhas', JSON.stringify(usuariosSenhas));
                atualizarTela();
            }
        }

        function chamarSenha() {
            var senhaAtual = document.getElementById('senhaExibida').innerText;

            if (!guicheSelecionado) {
                alert('Por favor, selecione um guichê antes de chamar a senha.');
                return;
            }

            if (!senhaAtual) {
                alert('Não há senha para ser chamada.');
                return;
            }

            // Obter o nome do próximo da fila
            var proximoNomeElement = document.querySelector('.proximo-nome');
            var proximoNome = proximoNomeElement ? proximoNomeElement.innerText : 'Nome Desconhecido';

            // Atualizar a área de atendimento com o nome
            document.getElementById('nomeAtendimento').innerText = proximoNome;

            // Adicionar o nome ao histórico
            var historicoNomeElement = document.getElementById('historicoNome');
            if (historicoNomeElement) {
                historicoNomeElement.innerHTML = '<h3>Nome:</h3><p>' + proximoNome + '</p>';
            }

            // Adicionar a senha ao histórico
            var historicoSenhaElement = document.getElementById('historicoSenha');
            if (historicoSenhaElement) {
                historicoSenhaElement.innerHTML = '<h3>Senha:</h3><p>' + senhaAtual + '</p>';
            }

            // Limpar a senha atual
            document.getElementById('senhaExibida').innerText = '';

            // Restante do seu código...

            // Atualizar o histórico na TV ou onde quer que você precise

            // Aqui você pode adicionar o redirecionamento para a outra página, se necessário
            // window.location.href = 'sua_pagina.html';
        }

        function obterSenhaDoLocalStorage() {
            return localStorage.getItem('senhaGerada');
        }

        function exibirSenha() {
            var senha = obterSenhaDoLocalStorage();
            if (senha) {
                document.getElementById('senhaExibida').innerHTML = senha;
            }
        }

        window.onload = exibirSenha;

        function selecionarGuiche(numero) {

            var var0 = document.getElementById("guiche");
            var0.value = numero;

            var todosGuiches = document.querySelectorAll('.guiche');
            todosGuiches.forEach(function (guiche) {
                guiche.classList.remove('guiche-selecionado');
            });


            guicheSelecionado = numero;
            console.log('Guichê selecionado: ' + guicheSelecionado);
            var guicheSelecionadoElement = document.querySelector('.guiche[data-guiche="' + guicheSelecionado + '"]');
            guicheSelecionadoElement.classList.add('guiche-selecionado');
        }



        window.onload = exibirSenha;


        function obterSenhaDoLocalStorage() {
            return localStorage.getItem('senhaGerada');
        }


        function exibirSenha() {
            var senha = obterSenhaDoLocalStorage();
            if (senha) {
                document.getElementById('senhaExibida').innerHTML = senha;
            }
        }

        window.addEventListener('storage', function (e) {
            if (e.key === 'nomeUsuario') {
                var elementoNome = document.querySelector('.proximo-nome');
                if (elementoNome) {
                    elementoNome.innerText = e.newValue;
                }
            } else if (e.key === 'senhasGeradas') {
                var senhasAnteriores = JSON.parse(e.newValue);
                var senhaGerada = senhasAnteriores[senhasAnteriores.length - 1];
                var elementoSenha = document.getElementById('senha_output');
                if (elementoSenha) {
                    elementoSenha.innerText = senhaGerada;
                }
            }
        });

        window.onload = function () {
            var nomeUsuario = localStorage.getItem('nomeUsuario');
            if (nomeUsuario) {
                document.getElementById('nomeAtendente').innerText = nomeUsuario;
            }
        }

        function atualizarTela() {
            var usuarioSenha = JSON.parse(localStorage.getItem('usuarioSenha'));
            if (usuarioSenha) {
                document.querySelector('.proximo-nome').innerText = usuarioSenha.nome;
                document.getElementById('senhaExibida').innerText = usuarioSenha.senha;
            }
        }
        window.onload = atualizarTela;

        window.addEventListener('storage', function (event) {
            if (event.key === 'usuarioSenha') {
                atualizarTela();
            }
        });

        window.addEventListener('storage', function (event) {
            if (event.key === 'usuariosSenhas') {
                atualizarTela();
            }
        });

        window.onload = atualizarTela;

        // Função para obter o tipo baseado na primeira letra da senha
        function obterTipo(senha) {
            var primeiraLetra = senha.charAt(0).toUpperCase();
            var tipo;
            var cor = 'preto';  // cor padrão

            if (primeiraLetra === 'P') {
                tipo = 'Preferencial';
                cor = 'red';
            } else {
                switch (primeiraLetra) {
                    case 'V':
                        tipo = 'Visita';
                        break;
                    case 'F':
                    case 'A':
                    case 'B':
                    case 'N':
                        tipo = 'Financeiro';
                        break;
                        break;
                    case 'C':
                    case 'I':
                    case 'E':
                    case 'T':
                    case 'G':
                    case 'O':
                        tipo = 'Curso';
                        break;
                    case 'M':
                        tipo = 'Matricula';
                        break;
                    case 'D':
                    case 'R':
                    case 'S':
                        tipo = 'Documentação';
                        break;
                    case 'P':
                        tipo = 'preferencial'

                    default:
                        tipo = 'Tipo não reconhecido';
                        break;

                }
            }

            return {
                tipo: tipo,
                cor: cor
            };
        }

        // Chame a função exibirTipo quando necessário
        exibirTipo();
        // comeco da senha e nome que vieram do usuario
        // function atualizarTela() {
        //     var usuariosSenhas = JSON.parse(localStorage.getItem('usuariosSenhas'));
        //     var container = document.getElementById('filaUsuarios');
        //     container.innerHTML = '';

        //     var blocoCategorias = document.createElement('div');
        //     blocoCategorias.className = 'proximos categorias';

        //     var divNome = document.createElement('div');
        //     divNome.className = 'prox-nome';
        //     divNome.innerHTML = '<h3>Nome:</h3>';

        //     var divTipo = document.createElement('div');
        //     divTipo.className = 'prox-tipo';
        //     divTipo.innerHTML = '<h3>Tipo:</h3>';

        //     var divSenha = document.createElement('div');
        //     divSenha.className = 'prox-senha';
        //     divSenha.innerHTML = '<h3>Senha:</h3>';

        //     blocoCategorias.appendChild(divNome);
        //     blocoCategorias.appendChild(divTipo);
        //     blocoCategorias.appendChild(divSenha);
        //     container.appendChild(blocoCategorias);

        //     if (usuariosSenhas) {
        //         usuariosSenhas.forEach(function (usuarioSenha, index) {
        //             var blocoUsuario = document.createElement('div');
        //             blocoUsuario.className = 'proximos';

        //             // Nome que veio do usuario
        //             var divNomeUsuario = document.createElement('div');
        //             divNomeUsuario.className = 'prox-nome';
        //             divNomeUsuario.innerHTML = '<p class="proximo-nome">' + usuarioSenha.nome + '</p>';

        //             // tipo que veio do usuario
        //             var resultado = obterTipo(usuarioSenha.senha);  // Agora, obtendo a senha correta com usuarioSenha.senha
        //             var tipo = resultado.tipo;
        //             var cor = resultado.cor;

        //             var divTipoUsuario = document.createElement('div');
        //             divTipoUsuario.className = 'prox-tipo';
        //             divTipoUsuario.innerHTML = '<p class="proximo-tipo" style="color:' + cor + ';">' + tipo + '</p>';  // Use a variável tipo e cor aqui

        //             // senha que veio do usuario
        //             var divSenhaUsuario = document.createElement('div');
        //             divSenhaUsuario.className = 'prox-senha';
        //             divSenhaUsuario.innerHTML = '<p>' + usuarioSenha.senha + '</p>';

        //             // botão para levar a senha para a TV
        //             var divBotoes = document.createElement('div');
        //             divBotoes.className = 'botoes-chamar';
        //             divBotoes.innerHTML = '<button onclick="enviarParaTV(\'' + usuarioSenha.senha + '\', \'' + usuarioSenha.nome + '\')" class="button-chamar">Chamar</button>';

        //             blocoUsuario.appendChild(divNomeUsuario);
        //             blocoUsuario.appendChild(divTipoUsuario);
        //             blocoUsuario.appendChild(divSenhaUsuario);
        //             blocoUsuario.appendChild(divBotoes);

        //             container.appendChild(blocoUsuario);
        //         });
        //     }
        // }


        // fim das senhas que vieram do usuario
        function exibirSenhaNaTV() {
            var senhaID = localStorage.getItem('senhaAtualID');
            if (senhaID) {
                var senhaInfo = JSON.parse(localStorage.getItem(senhaID));
                if (senhaInfo) {
                    document.getElementById('senhaExibida').innerText = senhaInfo.senha;
                }
            }
        }

        // para o scroll do historico
        document.querySelector('.historico').scrollTop = document.querySelector('.historico').scrollHeight;
    </script>

</body>

</html>