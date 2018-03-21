window.onload = function(){ $("#loading").addClass("inactive") };  

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

// Landing home 

var numBlocks = $('[data-section]').length,
	$curBlock,
	curBlockNum,
	lastUpdate = new Date();

window.addEventListener('wheel', function(e) {
	var thisUpdate = new Date();
    if( thisUpdate - lastUpdate < 750 ) {
        e.preventDefault();
        e.stopPropagation();
        return;
    }
    lastUpdate = thisUpdate;

		var delta = e.deltaY;

		if(delta< 0){ //scrollup
			scrollUp();
		} else if(delta > 0){//scroll down
			scrollDown();
		}
});

// var lastY
// window.addEventListener('touchmove', function(e){
// 	var currentY = e.originalEvent.touches[0].clientY;
// 	if(currentY > lastY){
// 		scrollDown();
// 	}else if(currentY < lastY){
// 		scrollUp();
// 	}
// });

var ts;
$(document).bind('touchstart', function (e){
   ts = e.originalEvent.touches[0].clientY;
});

$(document).bind('touchend', function (e){
   var te = e.originalEvent.changedTouches[0].clientY;
   if(ts > te+5){
      scrollDown();
   }else if(ts < te-5){
      scrollUp();
   }
});
function scrollUp(){
	$curBlock = $('[data-section].active'),
	curBlockNum = $curBlock.data('section');
	if(curBlockNum != 1){
		var $prevBlock = $curBlock.prev(),
		prevBlockNum = $prevBlock.data('section');

		$curBlock.removeClass('active prev-section').addClass('next-section');
		$prevBlock.addClass('active').removeClass('next-section prev-section');
	}
}

function scrollDown(){
	$curBlock = $('[data-section].active'),
	curBlockNum = $curBlock.data('section');

	if(curBlockNum != numBlocks){
		var $nextBlock = $curBlock.next();
		// nextEffect = $nextBlock.data('effect');

		$curBlock.removeClass('active next-section').addClass('prev-section');
		$nextBlock.removeClass('prev-section next-section').addClass('active');
	}
}

function contact(){
	scrollDown();
	scrollDown();
	scrollDown();
	scrollDown();
}

function checkCPF(cpf) {
	if(!validateCPF(cpf)) {
		$("#cpf").val("");
		alert("CPF inválido!");
		$("#rg").focus();
	}
}

function validateCPF(cpf) {
	var strCPF = cpf.replaceAll(".","").replaceAll("-","");
    var Soma = 0, Resto;
	if (strCPF == "00000000000") 
		return false;
    
	for (i=1; i<=9; i++) 
		Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
	Resto = (Soma * 10) % 11;
	
    if ((Resto == 10) || (Resto == 11))  
    	Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) ) 
    	return false;
	
	Soma = 0;
    for (i = 1; i <= 10; i++) 
    	Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;
	
    if ((Resto == 10) || (Resto == 11))  
    	Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11) ) ) 
    	return false;
    return true;
}

function checkDOB(dob) {
	if(!checkIfDate(dob)) {
		alert("Data inválida.");
		$("#dob").val("");
		$("#cep").focus();
	}
	else if(getAge(dob) < 18) {
		alert("Você precisa ser maior de 18 anos para se cadastrar.");
		$("#dob").val("");
		$("#cep").focus();
	}
}

function getAge(dob) {
	dob = getDateFromDateString(dob);
    var today = new Date();
    var birthDate = new Date(dob);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }    
    return age;
}

function checkIfDate(dob) {
	var day = parseInt(dob.substring(0,2));
	if(day < 1 || day > 31)
		return false;
	var month = parseInt(dob.substring(3,5));
	if(month < 1 || month > 12)
		return false;
	var year = parseInt(dob.substring(6,10));
	if(year < 1900 || year > 2500)
		return false;  
    return true;
}

function getDateFromDateString(dateString) {
	var day = dateString.substring(0,2);
	var month = dateString.substring(3,5);
	var year = dateString.substring(6,10);
	return year + "-" + month + "-" + day;
}

String.prototype.replaceAll = function(search, replacement) {
    var target = this;
    return target.split(search).join(replacement);
};