function changeIcon(id) {
	if($('#collapse' + id).hasClass('in'))
		$('#icon' + id).removeClass('fa-caret-square-o-down').addClass('fa-caret-square-o-right');
	else
		$('#icon' + id).removeClass('fa-caret-square-o-right').addClass('fa-caret-square-o-down');
}

function checkRelative(id) {
	if($('input[name=relative' + id + ']').prop('checked')) {
		$('input[name=value' + id + ']').prop('readonly',true).val(0);
		$('input[name=cents' + id + ']').prop('readonly',true).val(0);
		$('input[name=percentage' + id + ']').prop('readonly',false);
	}
	else {
		$('input[name=value' + id + ']').prop('readonly',false);
		$('input[name=cents' + id + ']').prop('readonly',false);
		$('input[name=percentage' + id + ']').prop('readonly',true).val(0);
	}
}

function changeStatus(orderId, status) {
	window.location.href = "adminOrders?id=" + orderId + "&status=" + status;
}

function changeGraduation(userId, graduation) {
	window.location.href = "adminUsers?id=" + userId + "&graduation=" + graduation;
}

function changePaymentReference(userId, reference) {
	window.location.href = "adminUsers?id=" + userId + "&paymentReference=" + reference;
}

function deleteOrder(orderId, reference) {
	if (confirm("Tem certeza que deseja deletar o pedido " + reference + "?")) {
	    alert("Deletou " + reference + "(id: " + orderId + ")");
	    window.location.href = "adminOrders?delete=true&orderId=" + orderId;
	}
}

function filter() {
	var parameters = []
	if($('#reference').val() != "")
		parameters.push(["reference",$('#reference').val()]);
	if($('#dateStart').val() != "" && $('#dateEnd').val() != "")
		parameters.push(["dateStart",$('#dateStart').val()],["dateEnd",$('#dateEnd').val()]);
	if(parameters.length == 0)
		window.location.href = "adminOrders?limit=100";
	else {
		var redirect = "?";
		for(var i = 0; i < parameters.length; i++) {
			redirect += parameters[i][0] + "=" + parameters[i][1];
			if(i < (parameters.length-1))
				redirect += "&";
		}
		window.location.href = "adminOrders" + redirect;
	}
	return;
}

function setDateMin() {
	$('#dateEnd').attr('min', $('#dateStart').val());
}

function filterUser() {
	if($('#username').val() == "")
		window.location.href = "adminUsers?limit=100";
	else
		window.location.href = "adminUsers?username=" + $('#username').val();
	return;
}

function autoFillReference() {
	$('#reference').val('CG-');
}

function modal(size, title, content) {
	$('#modal-home').remove();
	$("body").append($("<div id=\"modal-home\" class=\"modal fade\">" + 
  							"<div class=\"modal-dialog " + size + "\" role=\"document\">" + 
    							"<div class=\"modal-content\">" + 
    								"<div class=\"modal-header\">" + 
								        "<h5 class=\"modal-title text-align-center w-100\">" + title + "</h5>" + 
								        "<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\">" + 
								          "<span aria-hidden=\"true\">&times;</span>" + 
								        "</button>" +
								      "</div>" +
								      "<div class=\"modal-body display-inline-block\">" +
								      	"<div class=\"col-md-12\">" + 
								      		content +
								        "</div>" +
								      "</div>" +
								"</div>" +
							"</div>" +
						"</div>")
					);
	$('#modal-home').modal("toggle");
}

function modalHide() {
	$('#modal-home').modal("hide");
}

function checkForm(form) {
	var error = false;
	$.each(form, function(i, field){
		var input = $("[name='" + field.name + "']");
		if(input.attr("required")) {
			if(field.value == "") {
				error = true;
			}
		}
    });
    return error;
}

function checkField(field) {
	if (typeof field !== 'undefined' && field != null)
		return field;
	return "";
}

function modalDadosUsuario(userId) {
	//Perform AJAX request
	$.ajax({
		method: "GET",
		url: "admin/getUserData",
		data: { userId : userId }
	}).done(function(responseJson) {
		var response = JSON.parse(responseJson);
		var title = "Alterar Dados Cadastrais";
		var content = 	"<form id=\"modalForm\" class=\"form-horizontal\">" + 
							"<div class=\"form-group row col-sm-12\">" + 
								"<label class=\"control-label no-padding\">CPF</label>&nbsp;<span class=\"text-danger\">*</span>" + 
								"<div class=\"col-sm-12 no-padding\">" + 
									"<input type=\"text\" class=\"form-control\" name=\"cpf\" placeholder=\"Ex: 266.543.234-98\" value=\"" + checkField(response.cpf) + "\" required>" +
								"</div>" +
							"</div>" +
							"<div class=\"form-group col-sm-12\">" + 
								"<label class=\"control-label no-padding\">RG</label>&nbsp;<span class=\"text-danger\">*</span>" + 
								"<div class=\"col-sm-12 no-padding\">" + 
									"<input type=\"text\" class=\"form-control\" name=\"rg\" placeholder=\"Ex: 24.871.923-8\" value=\"" + checkField(response.rg) + "\" maxlength=\"25\" required>" +
								"</div>" +
							"</div>" +
							"<div class=\"form-group col-sm-12\">" + 
								"<label class=\"control-label no-padding\">E-mail</label>" + 
								"<div class=\"col-sm-12 no-padding\">" + 
									"<input type=\"text\" class=\"form-control\" name=\"email\" placeholder=\"Ex: joao_da_silva@email.com.br\" value=\"" + checkField(response.email) + "\" required>" +
								"</div>" +
							"</div>" +
							"<div class=\"form-group col-sm-12\">" + 
								"<label class=\"control-label no-padding\">Telefone</label>" + 
								"<div class=\"col-sm-12 no-padding\">" + 
									"<input type=\"text\" class=\"form-control\" name=\"telefone\" placeholder=\"Ex: (21) 98945-5421\" value=\"" + checkField(response.telefone) + "\" required>" +
								"</div>" +
							"</div>" +
							"<input type=\"hidden\" name=\"id\" value=" + userId + ">" +
							"<div class=\"form-group col-sm-12\">" + 
								"<div class=\"col-sm-12 no-padding\">" + 
									"<a class=\"btn btn-warning btn-block btn-lg text-white margin-top-10\" onclick=\"alterarDadosUsuario();\">Alterar</a>" +
								"</div>" +
							"</div>" +
						"</form>" + 
						"<div class=\"loader hidden\">" +
							"<div class=\"loader-track \"></div>" +
							"<p class=\"loader-text\">Atualizando dados</p>" +
						"</div>";
		//Show modal
		modal("modal-md", title, content);
		//Aplicação de máscaras
		$("[name='cpf']").mask("999.999.999-99");
		//$("[name='rg']").mask("99.999.999-9");
		var maskBehavior = function (val) {
			return val.replace(/\D/g, '').length === 11 ? '(00) 00000 0000' : '(00) 0000 00009';
			},
			options = {onKeyPress: function(val, e, field, options) {
				field.mask(maskBehavior.apply({}, arguments), options);
			}
		};		 
		$("[name='telefone']").mask(maskBehavior, options);
	});
}

function modalMessage(messageId) {
	//Perform AJAX request
	$.ajax({
		method: "GET",
		url: "admin/getMessage",
		data: { messageId : messageId }
	}).done(function(responseJson) {
		var response = JSON.parse(responseJson);
		var title = "Mensagem de " + response.name.split(" ")[0];
		var content = "<p><b>Data:</b> " + response.messageCreateDate + "</p>" +
					  "<p><b>Nome:</b> " + response.name + "</p>" +
					  "<p><b>Usuário:</b> " + response.username + "</p>" +
					  "<p><b>E-mail:</b> " + response.email + "</p>" +
					  "<p><b>Mensagem:</b></p>" + 
					  "<textarea class=\"form-control\" rows=\"10\" readonly>" + response.message + "</textarea>"; //+ 
					  /*"<div class=\"col-md-12 display-grid margin-top-20\">" + 
			            "<div class=\"margin-auto\">" + 
			                "<a href=\"adminMessages?id=" + response.id + "\" class=\"btn btn-success btn-block btn-lg\">Responder</a>" + 
			            "</div>" + 
			          "</div>";*/
		//Show modal
		modal("modal-lg", title, content);
	});
}

function eraseMessage(messageId) {
	var title = "Apagar mensagem";
	var content = "<p>Tem certeza de que deseja apagar esta mensagem? Esta ação não poderá ser desfeita.</p>" + 
				  "<a class=\"pointer btn btn-danger btn-lg btn-block\" onclick=\"confirmEraseMessage(" + messageId + ");\">Apagar</a>";
	//Show modal
	modal("modal-sm", title, content);
}

function confirmEraseMessage(messageId) {
	//Perform AJAX request
	$.ajax({
		method: "GET",
		url: "admin/eraseMessage",
		data: { messageId : messageId }
	}).done(function(responseJson) {
		location.reload();
	});
}

function loader(show) {
	if(show) {
		$("#modalForm").addClass("hidden");
		$(".loader").removeClass("hidden");
	}
	else{		
		$(".loader").addClass("hidden");
		$("#modalForm").removeClass("hidden");
	}
}

function alterarDadosUsuario() {
	var form = $("#modalForm").serializeArray();
	//Remove previous messages
	$("#modal-message").remove();
	//Checks if all elements from form are filled out
	if(checkForm(form)) {
		$("#modalForm").prepend($("<p id=\"modal-message\" class=\"modal-message-error\"><i class=\"fa fa-remove\"></i> Você deve preencher todos os campos.</p>"));
	}
	else {
		loader(true);
		//Perform AJAX request
		$.ajax({
			method: "POST",
			url: "admin/changeUserData",
			data: form
		}).done(function(responseJson) {
			//Show message
			if(responseJson == "cpf")
				$("#modalForm").prepend($("<p id=\"modal-message\" class=\"modal-message-error\"><i class=\"fa fa-remove\"></i> CPF já cadastrado.</p>"));
			else if(responseJson == "email")
				$("#modalForm").prepend($("<p id=\"modal-message\" class=\"modal-message-error\"><i class=\"fa fa-remove\"></i> E-mail já cadastrado.</p>"));
			else if(responseJson == "rg")
				$("#modalForm").prepend($("<p id=\"modal-message\" class=\"modal-message-error\"><i class=\"fa fa-remove\"></i> RG já cadastrado.</p>"));
			else if(responseJson == "error")
				$("#modalForm").prepend($("<p id=\"modal-message\" class=\"modal-message-error\"><i class=\"fa fa-remove\"></i> Ocorreu um erro. Por favor, tente novamente mais tarde.</p>"));
			else
				$("#modalForm").prepend($("<p id=\"modal-message\" class=\"modal-message-success\"><i class=\"fa fa-check\"></i> Dados cadastrais atualizados com sucesso.</p>"));
			//Hides modal loader
			loader(false);
		}).fail(function(error) {
			//Show message
			$("#modalForm").prepend($("<p id=\"modal-message\" class=\"modal-message-error\"><i class=\"fa fa-remove\"></i> Ocorreu um erro. Por favor, tente novamente mais tarde.</p>"));
			//Hides modal loader
			loader(false);
		});
	}
}

function getDateStringFromDate(date) {
	var year = date.substring(0,4);
	var month = date.substring(5,7);
	var day = date.substring(8,10);
	return day + "/" + month + "/" + year;
}

function getDateTimeStringFromDate(date) {
	var year = date.substring(0,4);
	var month = date.substring(5,7);
	var day = date.substring(8,10);
	var time = date.substring(11,19);
	return day + "/" + month + "/" + year + " " + time;
}

function startPrint(option) {
	var printContainer = $("<div id=\"printContainer\"></div>");
	$("body").append(printContainer);
	switch(option) {
		case 1:
			$("#printContainer").append($("<div id=\"printHeader\" class=\"page\"><div class=\"container-no-border h-min-100\"><h1 class=\"text-align-center\">Exportação de Cadastros</h1></div></div>"));
			break;
		case 2:
			$("#printContainer").append($("<div id=\"printHeader\" class=\"page\"><div class=\"container-no-border h-min-100\"><h1 class=\"text-align-center\">Exportação de Compras</h1></div></div>"));
			break;
	}
}

function endPrint() {
	$("#printContainer").remove();
}

function exportAdmin1() {
	//Perform AJAX request
	$.ajax({
		method: "GET",
		url: "admin/export1",
		data: {
			reference : $("#reference").val(),
			dateStart : $("#dateStart").val(),
			dateEnd : $("#dateEnd").val()
		}
	}).done(function(responseJson) {
		var response = JSON.parse(responseJson);
		console.log(response);
		startPrint(1);
		var maxIndex = 0;
		$(response).each(function(index, element) {
			$("#printContainer").append($("<div id=\"element" + index  +"\" class=\"page\"></div>"));
			$("#element" + index).append($("<div class=\"container h-500\">" +
												"<p class=\"text-align-center\">DADOS CADASTRAIS COMPLETOS</p>" +
												"<div class=\"flex\">" +
													"<div class=\"w-50\">" +
														"<p><b>Nome:</b> " 					+ element.name + "</p>" + 
														"<p><b>CPF:</b> " 					+ element.cpf + "</p>" + 
														"<p><b>RG:</b> " 					+ element.rg + "</p>" + 
														"<p><b>E-mail:</b> " 				+ element.email + "</p>" + 
														"<p><b>Data de Nascimento:</b> " 	+ getDateStringFromDate(element.dob) + "</p>" +
														"<p><b>Telefone:</b> " 				+ element.telefone + "</p>" + 
													"</div>" +
													"<div class=\"w-50\">" +
														"<p><b>Nome da Mãe:</b> " 			+ element.motherName + "</p>" +
														"<p><b>Nome do Pai:</b> " 			+ element.fatherName + "</p>" + 
														"<p><b>Estado Civil:</b> " 			+ element.estadoCivil + "</p>" +
														"<p><b>Sexo:</b> " 					+ element.sexo + "</p>" + 
														"<p><b>Escolaridade:</b> " 			+ element.escolaridade + "</p>" + 
														"<p><b>Profissão:</b> " 			+ element.profissao + "</p>" +
													"</div>" +
												"</div>" +
											"</div>" +
											"<div class=\"container h-150\">" +
												"<p class=\"text-align-center\">" + element.name + " | " + element.cpf + "</p>" +
												"<p>" + element.logradouro + ", " + element.numero + (element.complemento != "" ? (", " + element.complemento) : "") + 
												", " + element.bairro + " - " + element.cidade + ", " + element.estado + " - CEP: " + element.cep + "</p>" + 
												"<p>Telefone p/ Contato: " + element.telefone + " - Data:" + getDateTimeStringFromDate(element.orderCreateDate) + "</p>" +
											"</div>"
										));
			maxIndex = index;
		});
		var elements = "#printHeader, ";
		for(var i = 0; i <= maxIndex; i++) {
			elements += "#element" + i;
			if(i < maxIndex)
				elements += ", ";
		}
		$(elements).printThis({
	    	importCSS: true,
	    	loadCSS: "assets/css/printThis.css"
		});
		endPrint();
	});
}

function exportAdmin2() {
	//Perform AJAX request
	$.ajax({
		method: "GET",
		url: "admin/export2",
		data: {
			reference : $("#reference").val(),
			dateStart : $("#dateStart").val(),
			dateEnd : $("#dateEnd").val()
		}
	}).done(function(responseJson) {
		var response = JSON.parse(responseJson);
		console.log(response);
		startPrint(2);
		var maxIndex = 0;
		$(response).each(function(index, element) {
			$("#printContainer").append($("<div id=\"element" + index  +"\" class=\"w-100\"></div>"));
			$("#element" + index).append($("<div class=\"container h-150\">" +
												"<p class=\"text-align-center\">" + element.name + " | " + element.cpf + "</p>" +
												"<p>" + element.logradouro + ", " + element.numero + (element.complemento != "" ? (", " + element.complemento) : "") + 
												", " + element.bairro + " - " + element.cidade + ", " + element.estado + " - CEP: " + element.cep + "</p>" + 
												"<p>Telefone p/ Contato: " + element.telefone + " - Data:" + getDateTimeStringFromDate(element.orderCreateDate) + "</p>" +
											"</div>"
										));
			maxIndex = index;
		});
		var elements = "#printHeader, ";
		for(var i = 0; i <= maxIndex; i++) {
			elements += "#element" + i;
			if(i < maxIndex)
				elements += ", ";
		}
		$(elements).printThis({
	    	importCSS: true,
	    	loadCSS: "assets/css/printThis.css"
		});
		endPrint();
	});
}

$(document).ready(function(){
    $('[data-toggle="offcanvas"]').click(function(){
        $("#navigation").toggleClass("hidden-xs");
    });

    //Mask
    $('#reference').mask("999999999999");

    //Set autoload every 300000 milliseconds (5 minutes)
    setTimeout( function() {
    	location.reload();
    }, 300000);
});