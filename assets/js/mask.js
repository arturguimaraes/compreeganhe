//CPF Mask
$('#cpf', '#signupForm').keydown(function (e) {
    var key = e.charCode || e.keyCode || 0;
    $cpf = $(this);

    // Auto-format- do not expose the mask as the user begins to type
    if (key !== 8 && key !== 9) {
        if ($cpf.val().length === 3) {
            $cpf.val($cpf.val() + '.');
        }
        if ($cpf.val().length === 7) {
            $cpf.val($cpf.val() + '.');
        }           
        if ($cpf.val().length === 11) {
            $cpf.val($cpf.val() + '-');
        }
    }

    // Allow numeric (and tab, backspace, delete) keys only
    return (key == 8 || 
            key == 9 ||
            key == 46 ||
            (key >= 48 && key <= 57) ||
            (key >= 96 && key <= 105)); 
}).bind('focus click', function () {
        $cpf = $(this);
		var val = $cpf.val();
        $cpf.val('').val(val); // Ensure cursor remains at the end
});

//RG Mask
$('#rg', '#signupForm').keydown(function (e) {
    var key = e.charCode || e.keyCode || 0;
    $rg = $(this);

    // Auto-format- do not expose the mask as the user begins to type
    if (key !== 8 && key !== 9) {
        if ($rg.val().length === 2) {
            $rg.val($rg.val() + '.');
        }
        if ($rg.val().length === 6) {
            $rg.val($rg.val() + '.');
        }           
        if ($rg.val().length === 10) {
            $rg.val($rg.val() + '-');
        }
    }

    // Allow numeric (and tab, backspace, delete) keys only
    return (key == 8 || 
            key == 9 ||
            key == 46 ||
            (key >= 48 && key <= 57) ||
            (key >= 96 && key <= 105)); 
}).bind('focus click', function () {
        $rg = $(this);
		var val = $rg.val();
        $rg.val('').val(val); // Ensure cursor remains at the end
});

//Data Mask
$('#dob', '#signupForm').keydown(function (e) {
    var key = e.charCode || e.keyCode || 0;
    $data = $(this);

    // Auto-format- do not expose the mask as the user begins to type
    if (key !== 8 && key !== 9) {
        if ($data.val().length === 2) {
            $data.val($data.val() + '/');
        }
        if ($data.val().length === 5) {
            $data.val($data.val() + '/');
        }
    }

    // Allow numeric (and tab, backspace, delete) keys only
    return (key == 8 || 
            key == 9 ||
            key == 46 ||
            (key >= 48 && key <= 57) ||
            (key >= 96 && key <= 105)); 
}).bind('focus click', function () {
    	$data = $(this);
        var val = $data.val();
        $data.val('').val(val); // Ensure cursor remains at the end
});

//Data Mask
$('#dateStart', '#filterForm').keydown(function (e) {
    var key = e.charCode || e.keyCode || 0;
    $data = $(this);

    // Auto-format- do not expose the mask as the user begins to type
    if (key !== 8 && key !== 9) {
        if ($data.val().length === 2) {
            $data.val($data.val() + '/');
        }
        if ($data.val().length === 5) {
            $data.val($data.val() + '/');
        }
    }

    // Allow numeric (and tab, backspace, delete) keys only
    return (key == 8 || 
            key == 9 ||
            key == 46 ||
            (key >= 48 && key <= 57) ||
            (key >= 96 && key <= 105)); 
}).bind('focus click', function () {
        $data = $(this);
        var val = $data.val();
        $data.val('').val(val); // Ensure cursor remains at the end
});

//Data Mask
$('#dateEnd', '#filterForm').keydown(function (e) {
    var key = e.charCode || e.keyCode || 0;
    $data = $(this);

    // Auto-format- do not expose the mask as the user begins to type
    if (key !== 8 && key !== 9) {
        if ($data.val().length === 2) {
            $data.val($data.val() + '/');
        }
        if ($data.val().length === 5) {
            $data.val($data.val() + '/');
        }
    }

    // Allow numeric (and tab, backspace, delete) keys only
    return (key == 8 || 
            key == 9 ||
            key == 46 ||
            (key >= 48 && key <= 57) ||
            (key >= 96 && key <= 105)); 
}).bind('focus click', function () {
        $data = $(this);
        var val = $data.val();
        $data.val('').val(val); // Ensure cursor remains at the end
});

//CEP Mask
$('#cep', '#signupForm').keydown(function (e) {
    var key = e.charCode || e.keyCode || 0;
    $cep = $(this);

    // Auto-format- do not expose the mask as the user begins to type
    if (key !== 8 && key !== 9) {
        if ($cep.val().length === 5) {
            $cep.val($cep.val() + '-');
        }
    }

    // Allow numeric (and tab, backspace, delete) keys only
    return (key == 8 || 
            key == 9 ||
            key == 46 ||
            (key >= 48 && key <= 57) ||
            (key >= 96 && key <= 105)); 
}).bind('focus click', function () {
       $cep = $(this);
	    var val = $cep.val();
        $cep.val('').val(val); // Ensure cursor remains at the end
});

//Telefone Mask
$('#telefone', '#signupForm').keydown(function (e) {
    var key = e.charCode || e.keyCode || 0;
    $telefone = $(this);

    // Auto-format- do not expose the mask as the user begins to type
    if (key !== 8 && key !== 9) {
        if ($telefone.val().length === 0) {
            $telefone.val($telefone.val() + '(');
        }
		if ($telefone.val().length === 3) {
            $telefone.val($telefone.val() + ') ');
        }
		if ($telefone.val().length === 9) {
            $telefone.val($telefone.val() + ' ');
        }
		if ($telefone.val().length === 14) {
            $telefone.val($telefone.val().substring(0, 9) + $telefone.val().substring(10, 11) + ' ' + $telefone.val().substring(11, 14));
        }
    }

    // Allow numeric (and tab, backspace, delete) keys only
    return (key == 8 || 
            key == 9 ||
            key == 46 ||
            (key >= 48 && key <= 57) ||
            (key >= 96 && key <= 105)); 
}).bind('focus click', function () {
       $telefone = $(this);
	    var val = $telefone.val();
        $telefone.val('').val(val); // Ensure cursor remains at the end
});

//Telefone Mask
$('#telefone', '#contactForm').keydown(function (e) {
    var key = e.charCode || e.keyCode || 0;
    $telefone = $(this);

    // Auto-format- do not expose the mask as the user begins to type
    if (key !== 8 && key !== 9) {
        if ($telefone.val().length === 0) {
            $telefone.val($telefone.val() + '(');
        }
        if ($telefone.val().length === 3) {
            $telefone.val($telefone.val() + ') ');
        }
        if ($telefone.val().length === 9) {
            $telefone.val($telefone.val() + ' ');
        }
        if ($telefone.val().length === 14) {
            $telefone.val($telefone.val().substring(0, 9) + $telefone.val().substring(10, 11) + ' ' + $telefone.val().substring(11, 14));
        }
    }

    // Allow numeric (and tab, backspace, delete) keys only
    return (key == 8 || 
            key == 9 ||
            key == 46 ||
            (key >= 48 && key <= 57) ||
            (key >= 96 && key <= 105)); 
}).bind('focus click', function () {
       $telefone = $(this);
        var val = $telefone.val();
        $telefone.val('').val(val); // Ensure cursor remains at the end
});

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