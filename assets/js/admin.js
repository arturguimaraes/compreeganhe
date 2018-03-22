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

function filter() {
	if($('#reference').val() == "")
		window.location.href = "adminOrders?limit=100";
	else
		window.location.href = "adminOrders?reference=" + $('#reference').val();
	return;
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

$(document).ready(function(){
    $('[data-toggle="offcanvas"]').click(function(){
        $("#navigation").toggleClass("hidden-xs");
    });

    //Set autoload every 300000 milliseconds (5 minutes)
    setTimeout( function() {
    	location.reload();
    }, 300000);
});