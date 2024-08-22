// Sub tipo atendimento
var tipoAtendimentoSelecionado = "";

function showFormForAtendimento(element) {
  var tipoAtendimento = element.dataset.tipoAtendimento || "";
  var subtipoAtendimento = element.dataset.subtipoAtendimento || "";

  // Esconder todas as opções
  document.getElementById("initialOptions").style.display = "none";
  document.getElementById("reasonOptions").style.display = "none";
  document.getElementById("subCursosOptions").style.display = "none";
  document.getElementById("formForFinanceiro").style.display = "none";
  document.getElementById("matriculaOptions").style.display = "none";
  document.getElementById("formForDocumentacao").style.display = "none";

  // Mostrar o formulário
  document.getElementById("formForFormulario").style.display = "block";

  // Atribuir o valor correto a tipoAtendimentoSelecionado
  tipoAtendimentoSelecionado = subtipoAtendimento || tipoAtendimento;
  document.getElementById("tipoAtendimentoSelecionado").value =
    tipoAtendimentoSelecionado;
}

function enviarFormulario() {
  var tipoAtendimento = document.getElementById(
    "tipoAtendimentoSelecionado"
  ).value;
  var nome = document.getElementById("inputNome").value;
  var sobrenome = document.getElementById("inputSobrenome").value;
  var nomeCompleto = nome + " " + sobrenome;

  if (!nome || !sobrenome) {
    alert("Por favor, insira seu nome e sobrenome.");
    return;
  }

  if (tipoAtendimento) {
    var letraInicial;
    var letraSecundaria = "";

    // Verifica se é "Visitantes" e define a letra inicial como 'V'
    if (tipoAtendimentoSelecionado === "Preferencial") {
      letraInicial = "P";
    } else {
      // Se não for "Visitantes", pega a primeira letra do tipo de atendimento
      letraInicial = tipoAtendimento.charAt(0).toUpperCase();

      // Adiciona prefixo diferente com base no tipo de atendimento
      if (
        tipoAtendimento === "AAPM" ||
        tipoAtendimento === "Negociacoes" ||
        tipoAtendimento === "Boletos"
      ) {
        letraSecundaria = "F";
      } else if (
        tipoAtendimento === "Informacao" ||
        tipoAtendimento === "Cancelamento" ||
        tipoAtendimento === "Entrega" ||
        tipoAtendimento === "Tpagas - Matriculas" ||
        tipoAtendimento === "Gratuitas - Matriculas " ||
        tipoAtendimento === "Online - Matriculas "
      ) {
        letraSecundaria = "C";
      } else if (tipoAtendimento === "Documentação") {
        letraSecundaria = "D";
      }
      if (tipoAtendimentoSelecionado === "Visitantes") {
        letraSecundaria = "V";
      } else {
        letraSecundaria = "";
      }
    }
    function getProximoNumeroSenha() {
      var ultimoNumero = localStorage.getItem("ultimoNumeroSenha");
      if (ultimoNumero === null || isNaN(parseInt(ultimoNumero, 10))) {
        return "001";
      } else {
        var proximoNumero = parseInt(ultimoNumero, 10) + 1;

        return proximoNumero.toString().padStart(3, "0");
      }
    }

    var numeroSenha = getProximoNumeroSenha();
    var senhaGerada = letraSecundaria + letraInicial + numeroSenha;
    var usuariosSenhas =
      JSON.parse(localStorage.getItem("usuariosSenhas")) || [];
    usuariosSenhas.push({ nome: nomeCompleto, senha: senhaGerada });
    localStorage.setItem("usuariosSenhas", JSON.stringify(usuariosSenhas));
    localStorage.setItem(
      senhaGerada,
      JSON.stringify({ nome: nomeCompleto, senha: senhaGerada })
    );

    localStorage.setItem("senhaGerada", senhaGerada);

    localStorage.setItem("ultimoNumeroSenha", numeroSenha);
    var senhaGerada = letraSecundaria + letraInicial + numeroSenha;
    localStorage.setItem("senhaGerada", senhaGerada);

    document.getElementById("senha_output").innerText = senhaGerada;
    document.getElementById("formForFormulario").style.display = "none";
    document.getElementById("formForSenha").style.display = "block";
  } else {
    console.error("Tipo de atendimento não especificado.");
  }
}

// MOSTRAR E DESMOSTRAR AS PÁGINAS

// Botão at_regular
function atdRegular(type) {
  document.getElementById("prioridade").value = "Regular";
  tipoAtendimentoSelecionado = "Regular";
  document.getElementById("initialOptions").style.display = "none";
  document.getElementById("reasonOptions").style.display = "block";
  document.getElementById("tipoAtendimentoSelecionado").value = "Regular";
}

// Botão at_preferencial
function atdPreferencial(type) {
  document.getElementById("prioridade").value = "Preferencial";
  tipoAtendimentoSelecionado = "Preferencial";
  document.getElementById("initialOptions").style.display = "none";
  document.getElementById("reasonOptions").style.display = "block";
  document.getElementById("tipoAtendimentoSelecionado").value = "Preferencial";
}

// Botões página das opções primárias

// 🌹 Acho que essa opção em si não precisa do prefixo nasenha, só as finais

// Botão visitantes
function showFormForVisitantes() {
  document.getElementById("reasonOptions").style.display = "none";
  document.getElementById("formForFormulario").style.display = "block";
  document.getElementById("tipoAtendimentoSelecionado").value = "Visitantes";
}

// Botões cursos

function showFormForCursos() {
  document.getElementById("reasonOptions").style.display = "none";
  document.getElementById("subCursosOptions").style.display = "block";
  document.getElementById("tipoAtendimentoSelecionado").value = "Cursos";
}

// Botão financeiro
function showFormForFinanceiro() {
  document.getElementById("reasonOptions").style.display = "none";
  document.getElementById("formForFinanceiro").style.display = "block";
  document.getElementById("tipoAtendimentoSelecionado").value = "Financeiro";
}

// Botão Documentação
function showFormForDocumentacao() {
  document.getElementById("reasonOptions").style.display = "none";
  document.getElementById("formForDocumentacao").style.display = "block";
  document.getElementById("tipoAtendimentoSelecionado").value = "Documentação";
}

// Página financeiro

// Btão boleto

function showformforBoletos() {
  document.getElementById("formForFinanceiro").style.display = "none";
  document.getElementById("formForFormulario").style.display = "block";
  document.getElementById("tipoAtendimentoSelecionado").value = "Boletos";
}

// Botão Negociações
function showformforNegociacoes() {
  document.getElementById("formForFinanceiro").style.display = "none";
  document.getElementById("formForFormulario").style.display = "block";
  document.getElementById("tipoAtendimentoSelecionado").value = "Negociacoes";
}

// Botão AAPM
function showformforAapm() {
  document.getElementById("formForFinanceiro").style.display = "none";
  document.getElementById("formForFormulario").style.display = "block";
  document.getElementById("tipoAtendimentoSelecionado").value = "AAPM";
}

// opções Cursos

function showFormForInfo() {
  document.getElementById("subCursosOptions").style.display = "none";
  document.getElementById("formForFormulario").style.display = "block";
  document.getElementById("tipoAtendimentoSelecionado").value = "Informacao";
}

function showFormForCancel() {
  document.getElementById("subCursosOptions").style.display = "none";
  document.getElementById("formForFormulario").style.display = "block";
  document.getElementById("tipoAtendimentoSelecionado").value = "Cancelamento";
}

// Arrumei obug dos ID
function showMatriculaOptions() {
  document.getElementById("subCursosOptions").style.display = "none";
  document.getElementById("matriculaOptions").style.display = "block";
  document.getElementById("tipoAtendimentoSelecionado").value = "Matriculas";
}

function showFormForMaterial() {
  document.getElementById("subCursosOptions").style.display = "none";
  document.getElementById("formForFormulario").style.display = "block";
  document.getElementById("tipoAtendimentoSelecionado").value = "Entrega";
}

// Opções Matriculas

function showFormForMPag() {
  document.getElementById("matriculaOptions").style.display = "none";
  document.getElementById("formForFormulario").style.display = "block";
  document.getElementById("tipoAtendimentoSelecionado").value =
    "Pagas - Matriculas";
}

function showFormForMGat() {
  document.getElementById("matriculaOptions").style.display = "none";
  document.getElementById("formForFormulario").style.display = "block";
  document.getElementById("tipoAtendimentoSelecionado").value =
    "Gratuitas - Matriculas ";
}

function showFormForMOn() {
  document.getElementById("matriculaOptions").style.display = "none";
  document.getElementById("formForFormulario").style.display = "block";
  document.getElementById("tipoAtendimentoSelecionado").value =
    "Online - Matriculas ";
}

// Opções documentos

function showFormForCCm() {
  document.getElementById("formForDocumentacao").style.display = "none";
  document.getElementById("formForFormulario").style.display = "block";
  document.getElementById("tipoAtendimentoSelecionado").value =
    "Rápido - Certificado comum";
}

function showFormForCSg() {
  document.getElementById("formForDocumentacao").style.display = "none";
  document.getElementById("formForFormulario").style.display = "block";
  document.getElementById("tipoAtendimentoSelecionado").value =
    "SGSET - Certificados";
}

function showFormForDeclare() {
  document.getElementById("formForDocumentacao").style.display = "none";
  document.getElementById("formForFormulario").style.display = "block";
  document.getElementById("tipoAtendimentoSelecionado").value = "Declaração";
}

// Input

// Fazer botão voltar usando if 👌🤷‍♀️

function showReasonOptions(type) {
  document.getElementById("initialOptions").style.display = "none";
  document.getElementById("reasonOptions").style.display = "block";
}

// COMENTADO ATÉ SEGUNDA ORDEM
// function showFormForAtendimento(element) {
//     var tipoAtendimento = element.dataset.tipoAtendimento;
//     var subtipoAtendimento = element.dataset.subtipoAtendimento || '';

//     document.getElementById('reasonOptions').style.display = 'none';
//      document.getElementById('subCursosOptions').style.display = 'none';
//      document.getElementById('formForFinanceiro').style.display = 'none';
//     document.getElementById('formForDocumentacao').style.display = 'none';

//     document.getElementById('formForFormulario').style.display = 'block';
//    document.getElementById('tipoAtendimentoSelecionado').value = tipoAtendimento || tipoAtendimento;
//  }

// Funções de voltar
function back_home() {
  document.getElementById("reasonOptions").style.display = "none";
  document.getElementById("initialOptions").style.display = "block";
}

function back_opc() {
  document.getElementById("formForFinanceiro").style.display = "none";
  document.getElementById("reasonOptions").style.display = "block";
}

function cBack_opc() {
  document.getElementById("subCursosOptions").style.display = "none";
  document.getElementById("reasonOptions").style.display = "block";
}

function docBack_opc() {
  document.getElementById("formForDocumentacao").style.display = "none";
  document.getElementById("reasonOptions").style.display = "block";
}

function matBack_opc() {
  document.getElementById("matriculaOptions").style.display = "none";
  document.getElementById("subCursosOptions").style.display = "block";
}

function back_() {
  document.getElementById("formForFormulario").style.display = "none";
  document.getElementById("initialOptions").style.display = "block";
}

// Setinha voltar

// main options
function back_home() {
  document.getElementById("reasonOptions").style.display = "none";

  document.getElementById("initialOptions").style.display = "block";
}

// financeiro
function back_opc() {
  document.getElementById("formForFinanceiro").style.display = "none";

  document.getElementById("reasonOptions").style.display = "block";
}

// Cursos
function cBack_opc() {
  document.getElementById("subCursosOptions").style.display = "none";

  document.getElementById("reasonOptions").style.display = "block";
}

// Documentação
function docBack_opc() {
  document.getElementById("formForDocumentacao").style.display = "none";

  document.getElementById("reasonOptions").style.display = "block";
}

// Botão voltar sub telas

// Matricula

function matBack_opc() {
  document.getElementById("matriculaOptions").style.display = "none";

  document.getElementById("subCursosOptions").style.display = "block";
}

// input

function back_() {
  document.getElementById("formForFormulario").style.display = "none";

  document.getElementById("initialOptions").style.display = "block";
}
