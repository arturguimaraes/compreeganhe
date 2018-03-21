function getRGB(hex) {
	
    if (hex.indexOf('#') === 0)
        hex = hex.slice(1);
    // convert 3-digit hex to 6-digits.
    if (hex.length === 3)
        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
    if (hex.length !== 6)
        throw new Error('Invalid HEX color.');
    // invert color components
    return [(parseInt(hex.slice(0, 2), 16)).toString(16),
    		(parseInt(hex.slice(2, 4), 16)).toString(16),
    		(parseInt(hex.slice(4, 6), 16)).toString(16)];
}

function setContrast(color) {
	var rgb = getRGB(color);
  	// http://www.w3.org/TR/AERT#color-contrast
  	var o = Math.round(((parseInt(rgb[0]) * 299) +
  						(parseInt(rgb[1]) * 587) +
  						(parseInt(rgb[2]) * 114)) / 1000);
  	var contrast = (o > 125) ? '#000000' : '#ffffff';
  	return contrast;
}

function taskCompleted(taskId, projectId) {
	//Hides content container
	$('.task-modal-body').children(1).addClass('hidden');
	//Displays loader
	$('#task-modal-loader').removeClass('hidden');
	$.ajax({
		method: "POST",
		url: "updateTask",
		data: { taskId: taskId, 
		        done: 1,
		        projectId: projectId,
		        taskGroupId: 0,
		        token: "small2018Vis",
		        submit: true
		      }
	}).done(function(responseJson) {
		//Hides loader container
		$('#task-modal-loader').addClass('hidden');
		//Displays content container
		$('.task-modal-body').children(1).removeClass('hidden');
		//Converts to JSON
		var response = JSON.parse(responseJson);
		//Error
		if(response.errors.length != 0)
		  console.log(response.errors);
		//Success
		else {
		  console.log(response.response[0]);
		  $("#taskModal").modal("hide");
		  $("#calendar").fullCalendar('removeEvents', taskId);
		  setTimeout( function() {
		  	$("#page-wrapper").prepend($("<div class='alert alert-dismissible alert-success'>" + 
		  									"<button type='button' class='close' data-dismiss='alert'>&times;</button>" + 
		  									"Tarefa marcada como \"Completa\" com sucesso.</div>"));
		  }, 500);
		}
	});
}

function showLongData() {
	$("#long-data-loader").fadeOut("slow", function() {
		$("#long-data-loader").addClass("hidden");
		$("#long-data-container").addClass("animated fadeIn").removeClass("hidden");
		$("#calendar").fullCalendar("render");
  	});
}

$(document).ready(function() {
	$('#calendar').fullCalendar({
		header: {
			left: 'prev,next today',
			center: 'title',
			right: 'month,basicWeek,agendaDay'
		},
		
		defaultView: 'month',
		navLinks: true, // can click day/week names to navigate views
		editable: false,
		eventLimit: true, // allow "more" link when too many events
		displayEventTime: false,
		
		eventClick: function( calEvent, jsEvent, view ) {
  			$('.calendar-info').remove();
  			$("#taskModal").remove();
  			var el = $('<div class="modal fade" id="taskModal" tabindex="-1" role="dialog" aria-labelledby="taskTitle" aria-hidden="true">' +
  							'<div class="modal-dialog modal-task" role="document">' +
  								'<div class="modal-content task-modal-content">' +
  									'<div class="modal-header display-flex">' +
		  								'<h5 class="modal-title text-align-center bold" id="taskTitle" style="width: -webkit-fill-available;"><i class="fa fa-pencil"></i> ' + calEvent.title + '</h5>' +
					        			'<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">' +
					          				'<span aria-hidden="true">&times;</span>' +
					          			'</button>' +
					          		'</div>' +
					          		'<div class="modal-body task-modal-body">' +
					          			'<div id="task-modal-loader" class="loader hidden"></div>' +
					          		'</div>' +
					          	'</div>' +
					        '</div>' +
					    '</div>');
  			$("#event-modals").append(el);
  			//Número de atributos do modal
  			var atributos = calEvent.maxAtribute;
  			for(var i = 0; i <= atributos; i++)
  				if (typeof calEvent['p' + i] !== 'undefined')
				    $(".task-modal-body").append(calEvent['p' + i]);
			if(calEvent.done == "1")
				$("#task-completed-button").addClass("hidden");
  			$("#updateModalTitle").html("").html('<i class="fa fa-pencil"></i> <b>' + calEvent.title + '</b>');
  			//Update event's percentage value
  			//$('#progress option[value="' + calEvent.progress + '"]');
  			//Update event's done value
  			if(calEvent.done == '1')
  				$("#done").prop('checked', true);
  			else
  				$("#done").prop('checked', false);
  			//If user admin or editor, or has task assigned to him
  			/*if((calEvent.userAdmin == '1') || ($calEvent.loggedUser == responsibleUser)) {
  				$(".task-modal-content").append($("<div class=\"modal-footer task-modal-footer display-flex\"></div>"));
  				$(".task-modal-footer").append($("<button type=\"button\" class=\"btn btn-primary btn-block btn-lg margin-auto-horizontal margin-right-20\" onclick=\"showAssignModal();\">Atribuir</button>"));
  				$(".task-modal-footer").append($("<button type=\"button\" class=\"btn btn-success btn-block btn-lg margin-auto-horizontal margin-left-20\" onclick=\"showUpdateModal();\">Atualizar</button>"));
  			}*/
  			$("#taskModal").modal("toggle");
		},
		
		eventMouseover: function( calEvent, jsEvent, view ) {
		    var el = $('<div class="calendar-info"></div>');
		    el.append(calEvent.p0).append(calEvent.p1).append(calEvent.clickInfo);
		    //Case of month view
		    if($(".fc-month-view")[0] != null) {
		    	var top = $(this).parent().parent().parent().parent().parent().parent().position().top + $(this).position().top + 100;
		   		var left = $(this).parent().parent().parent().parent().parent().parent().position().left + $(this).position().left - 50;
		    }
		    //Case of week view
		    if($(".fc-basicWeek-view")[0] != null) {
		    	var top = $(this).parent().position().top + $(this).position().top + 100;
		   		var left = $(this).parent().position().left - 50;
		    }
		    //Case of day view
		    if($(".fc-agendaDay-view")[0] != null) {
		    	var top = $(this).position().top - 50;
		   		var left = $(this).position().left;
		    }
		    //Apply top and left
		    el.css('top',top).css('left',left).css("text-align","center");
		    $('#calendar').append(el);
		    el.height(el.height());
		},
		
		eventMouseout: function( calEvent, jsEvent, view ) {
			$('.calendar-info').remove();
		}
	});
});	

/*function showAssignModal() {
	$("#taskModal").modal("hide");
	setTimeout(function(){ showAssign(); }, 500);
}

function showUpdateModal() {
	$("#taskModal").modal("hide");
	setTimeout(function(){ showUpdate(); }, 500);
}*/