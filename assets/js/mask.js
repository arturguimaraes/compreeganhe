$(document).ready(function(){	
	//Aplicação de máscaras
	$("[name='cnpj']").mask("99.999.999/9999-99");
	$("[name='cep']").mask("99999-999");
	$("[name='cep2']").mask("99999-999");
	//Aplica a máscara do celular para 8 ou 9 números
	var maskBehavior = function (val) {
		return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
		},
		options = {onKeyPress: function(val, e, field, options) {
			field.mask(maskBehavior.apply({}, arguments), options);
		}
	};		 
	$("[name='phone']").mask(maskBehavior, options);
	$("[name='contact1Phone']").mask(maskBehavior, options);
	$("[name='contact2Phone']").mask(maskBehavior, options);
	$("[name='contact3Phone']").mask(maskBehavior, options);
	$("[name='contact4Phone']").mask(maskBehavior, options);
});

function advance(step) {
    switch(step) {
		case 2:
			$('#info').addClass('fadeOut');
			setTimeout(function(){
				$('#info').addClass('hidden').removeClass('fadeOut');
				$('#address').removeClass('hidden');
			}, 500);
			break;
		case 3:
			$('#address').addClass('fadeOut');
			setTimeout(function(){
				$('#address').addClass('hidden').removeClass('fadeOut');
				$('#contact').removeClass('hidden');
			}, 500);
			break;
	}
}

function back(step) {
	switch(step) {
		case 1:
			$('#address').addClass('fadeOut');
			setTimeout(function(){
				$('#address').addClass('hidden').removeClass('fadeOut');
				$('#info').removeClass('hidden');
			}, 500);
			break;
		case 2:
			$('#contact').addClass('fadeOut');
			setTimeout(function(){
				$('#contact').addClass('hidden').removeClass('fadeOut');
				$('#address').removeClass('hidden');
			}, 500);
			break;
	}
}

function verificaEnderecoFiscal(isFiscalAddress) {
	if(isFiscalAddress) {
		$("#fiscalAddress").addClass("fadeOut");
		setTimeout(function(){
    		$("#fiscalAddress").addClass("hidden");
		}, 500);
		limpa_formulário_cep2();
	}
	else {
		setTimeout(function(){
			$("#fiscalAddress").removeClass("fadeOut hidden");
		}, 500);
	}
}

function verificaContato(contact, enabled) {
	if(!enabled) {
		$("#contact" + contact).addClass("fadeOut");
		setTimeout(function(){
    		$("#contact" + contact).addClass("hidden");
			limpa_contato(contact);
		}, 500);
	}
	else {
		setTimeout(function(){
			$("#contact" + contact).removeClass("fadeOut hidden");
		}, 500);
	}
}

function limpa_contato(contact) {
	switch(contact) {
		case 2:
			$('#contact2Name').val("");
    		$('#contact2Email').val("");
    		$('#contact2Phone').val("");
			break;
		case 3:
			$('#contact3Name').val("");
    		$('#contact3Email').val("");
    		$('#contact3Phone').val("");
			break;
		case 4:
			$('#contact4Name').val("");
    		$('#contact4Email').val("");
    		$('#contact4Phone').val("");
			break;
	}
}

function verificaNome(value) {
	if(value == null || value == "") 
		$("#submit").prop('disabled', true)
	else 
		$("#submit").prop('disabled', false)
}

function limpa_formulário_cep() {
    //Limpa valores do formulário de cep.
    $('#cep').val("");
    $('#street').val("");
    $('#complement').prop('readonly', true).val("");
    $('#area').val("");
    $('#city').val("");
    $('#state').val("");
}

function limpa_formulário_cep2() {
    //Limpa valores do formulário de cep.
    $('#cep2').val("");
    $('#street2').val("");
    $('#complement2').prop('readonly', true).val("");
    $('#area2').val("");
    $('#city2').val("");
    $('#state2').val("");
}

function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        $('#street').val(conteudo.logradouro);
        $('#complement').prop('readonly', false).val(conteudo.complemento);
        $('#area').val(conteudo.bairro);
        $('#city').val(conteudo.localidade);
        $('#state').val(conteudo.uf);
    }
    else {
        //CEP não Encontrado.
        limpa_formulário_cep();
        alert("CEP não encontrado.");
    }
}

function meu_callback2(conteudo) {
    if (!("erro" in conteudo)) {
        //Atualiza os campos com os valores.
        $('#street2').val(conteudo.logradouro);
        $('#complement2').prop('readonly', false).val(conteudo.complemento);
        $('#area2').val(conteudo.bairro);
        $('#city2').val(conteudo.localidade);
        $('#state2').val(conteudo.uf);
    }
    else {
        //CEP não Encontrado.
        limpa_formulário_cep2();
        alert("CEP não encontrado.");
    }
}
        
function pesquisacep(valor) {
    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');
    //Verifica se campo cep possui valor informado.
    if (cep != "") {
        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;
        //Valida o formato do CEP.
        if(validacep.test(cep)) {
            //Preenche os campos com "..." enquanto consulta webservice.
            $('#street').val("...");
    		$('#complement').val("...");
            $('#area').val("...");
            $('#city').val("...");
            $('#state').val("...");
            //Cria um elemento javascript.
            var script = document.createElement('script');
            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';
            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);
        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep();
    }
};

function pesquisacep2(valor) {
    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');
    //Verifica se campo cep possui valor informado.
    if (cep != "") {
        //Expressão regular para validar o CEP.
        var validacep = /^[0-9]{8}$/;
        //Valida o formato do CEP.
        if(validacep.test(cep)) {
            //Preenche os campos com "..." enquanto consulta webservice.
            $('#street2').val("...");
    		$('#complement2').val("...");
            $('#area2').val("...");
            $('#city2').val("...");
            $('#state2').val("...");
            //Cria um elemento javascript.
            var script = document.createElement('script');
            //Sincroniza com o callback.
            script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback2';
            //Insere script no documento e carrega o conteúdo.
            document.body.appendChild(script);
        } //end if.
        else {
            //cep é inválido.
            limpa_formulário_cep2();
            alert("Formato de CEP inválido.");
        }
    } //end if.
    else {
        //cep sem valor, limpa formulário.
        limpa_formulário_cep2();
    }
};

function validarCNPJ(element) {
    var response = true;
    var cnpj = element.value.replace(/[^\d]+/g,'');
 
    if(cnpj == '') response = false;
     
    if (cnpj.length != 14) response = false;
 
    // Elimina CNPJs invalidos conhecidos
    if (cnpj == "00000000000000" || 
        cnpj == "11111111111111" || 
        cnpj == "22222222222222" || 
        cnpj == "33333333333333" || 
        cnpj == "44444444444444" || 
        cnpj == "55555555555555" || 
        cnpj == "66666666666666" || 
        cnpj == "77777777777777" || 
        cnpj == "88888888888888" || 
        cnpj == "99999999999999")
        response = false;
         
    // Valida DVs
    tamanho = cnpj.length - 2
    numeros = cnpj.substring(0,tamanho);
    digitos = cnpj.substring(tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(0))
        response = false;
         
    tamanho = tamanho + 1;
    numeros = cnpj.substring(0,tamanho);
    soma = 0;
    pos = tamanho - 7;
    for (i = tamanho; i >= 1; i--) {
      soma += numeros.charAt(tamanho - i) * pos--;
      if (pos < 2)
            pos = 9;
    }
    resultado = soma % 11 < 2 ? 0 : 11 - soma % 11;
    if (resultado != digitos.charAt(1))
          response = false;
           
    if(response == false) {
    	alert("CNPJ Inválido.")
    	$('#cnpj').val("");
        if(!(element.parentElement.parentElement.nextElementSibling.children[1].firstElementChild === undefined))
            $(element.parentElement.parentElement.nextElementSibling.children[1].firstElementChild).focus();
    }
}