$( document ).ready(function() {
	$("#mainNav").addClass("navbar-shrink");

	// Collapse Navbar
	var navbarCollapse = function() {
		$("#mainNav").addClass("navbar-shrink");
	};
	// Collapse now if page is not at top
	navbarCollapse();
	// Collapse the navbar when page is scrolled
	$(window).scroll(navbarCollapse);
});

function generateCode() {
	var code = Math.random().toString();
	code = code.substring(2, code.length);
	window.location.search = '?id=' + $("#id").val() + "&code=" + code + "&override=true";
	//var url = "http://www.compreeganhe.net/signup?id=" + $("#id").val() + "&code=" + code;
	//$("#code").val(url);
}

function copyToClipboard() {
	var copyText = document.getElementById("code");
	$('#copyMesssage').html('');
	if(copyText.value == null || copyText.value == "") {
		$('<p class="text-align-center text-red">Não foi possível copiar o código.</p>').appendTo($('#copyMesssage'));
	}
	else {
		copyText.select();
		document.execCommand("Copy");
		$('<p class="text-align-center text-green">URL copiada!</p>').appendTo($('#copyMesssage'));
	}
}

function checkPassword() {
	$('#passwordMessage').html('');
	if($('#password').val() == $('#repeatPassword').val()) {
		$("<p class='text-align-center text-green'>Senha OK</p>").appendTo($('#passwordMessage'));
		$('#password').css("background-color", "white");
		$('#repeatPassword').css("background-color", "white");
		$('#submit').removeAttr("disabled");
	}
	else {
		$("<p class='text-align-center text-red'>As senhas inseridas não são iguais!</p>").appendTo($('#passwordMessage'));
		$('#password').css("background-color", "#ffcccc");
		$('#repeatPassword').css("background-color", "#ffcccc");
		$('#submit').attr("disabled", "disabled");
	}
}

function printPage() {
	$('.img-header').css('position','initial');
	window.print();
	$('.img-header').css('position','absolute');
}