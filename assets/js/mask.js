function cep_callback(conteudo) {
    if (!("erro" in conteudo)) {
        $("#logradouro").val(conteudo.logradouro);
        $("#complemento").val(conteudo.complemento);
        $("#bairro").val(conteudo.bairro);
        $("#cidade").val(conteudo.localidade);
        $("#estado").val(conteudo.uf);
    }
    else {
        limpaEndereco();
        alert("CEP não encontrado.");
    }
}

function limpaEndereco() {
    $("#cep").val("");
    $("#logradouro").val("");
    $("#numero").val("");
    $("#complemento").val("");
    $("#bairro").val("");
    $("#cidade").val("");
    $("#estado").val("");
}

function pesquisaCEP(valor) {
    var cep = valor.replace(/\D/g, '');
    if (cep != "") {
        var validaCEP = /^[0-9]{8}$/;
        if(validaCEP.test(cep)) {
            $("#logradouro").val("...");
            var script = document.createElement("script");
            script.src = '//viacep.com.br/ws/' + cep + '/json/?callback=cep_callback';
            document.body.appendChild(script);
        }
        else {
            limpaEndereco();
            alert("Formato de CEP inválido.");
        }
    }
    else {
        limpaEndereco();
    }
}

$(document).ready(function(){   
    //Aplica a máscara do celular para 8 ou 9 números
    var maskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000 0000' : '(00) 0000 00009';
        },
        options = {onKeyPress: function(val, e, field, options) {
            field.mask(maskBehavior.apply({}, arguments), options);
        }
    };
    //Aplicação de máscaras
    //$('#rg', '#signupForm').mask("99.999.999-9");
    $('#dob', '#signupForm').mask("99/99/9999");
    $('#cep', '#signupForm').mask("99999-999");
    $('#cpf', '#signupForm').mask("999.999.999-99");
    $('#telefone', '#signupForm').mask(maskBehavior, options);
    $('#cpf', '#loginForm').mask("999.999.999-99");
    $('#cpf', '#resetPasswordForm').mask("999.999.999-99");
    $('#dateStart', '#filterForm').mask("99/99/9999");
    $('#dateEnd', '#filterForm').mask("99/99/9999");
    $('#telefone', '#contactForm').mask(maskBehavior, options);
});