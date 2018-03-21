<?php defined('BASEPATH') OR exit('No direct script access allowed');

class String {
		
	protected $CI;
	
	//Construção da classe
	public function __construct() {
        // Assign the CodeIgniter super-object
        $this->CI =& get_instance();
    }
    
	//Converte Datetime para data visível ao usuário
	public function dateTimeToString($dateTime) {
		$year = substr($dateTime, 0, 4);
		$month = substr($dateTime, 5, 2);
		$day = substr($dateTime, 8, 2);
		$time = substr($dateTime, -8, 5);
		return $day.'/'.$month.'/'.$year.' '.$time;
	}

	//Converte Datetime para data visível ao usuário
	public function dateTimeToStringNoTime($dateTime) {
		$year = substr($dateTime, 0, 4);
		$month = substr($dateTime, 5, 2);
		$day = substr($dateTime, 8, 2);
		return $day.'/'.$month.'/'.$year;
	}
	
	//Converte Datetime do Form para data visível ao usuário
	public function dateTimeFormToString($dateTime, $separate = false) {
		$year = substr($dateTime, 0, 4);
		$month = substr($dateTime, 5, 2);
		$day = substr($dateTime, 8, 2);
		$time = substr($dateTime, -5, 5);
		if(!$separate)
			return $day.'/'.$month.'/'.$year.' '.$time;
		else
			return array('date' => $day.'/'.$month.'/'.$year,
						 'time' => $time);
	}
	
	//Converte Datetime para data visível ao usuário
	public function dateTimeToDate($dateTime) {
		return substr($dateTime,0,-9);
	}

	//Converte Datetime para o formato yyyy-mm-ddThh:mm
	public function dateTimeToFormString($dateTime) {
		return str_replace(" ", "T", substr($dateTime, 0, -3));
	}
	
	//Pega o endereço formatado
	public function getFormattedAddress($address, $data) {
		if($address == 1)
			if($data->cep != "")
				return $data->street . ", " . $data->complement . " - " . $data->area .
					   " - " . $data->city . ", " . $data->state . " - " . $data->cep;
		else if($address == 2)
			if(!isset($data->isFiscalAddress) || $data->isFiscalAddress != 'on')
				return $data->street2 . ", " . $data->complement2 . " - " . $data->area2 .
					   " - " . $data->city2 . ", " . $data->state2 . " - " . $data->cep2; 
		return "";
	}

	//Cria um código de cliente único
	public function uniqueCode($code, $name, $position) {
		//Retira espaços e símbolos
		$name = strtoupper(preg_replace("/[^a-zA-Z]+/", "", $name));
		if($position < strlen($name)) {
			$code = substr($code, 0, 2) . substr($name, $position, 1);
		}
		else {
			$position -= strlen($name);
			$name = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			if($position < strlen($name)) {
				$code = substr($code, 0, 2) . substr($name, $position, 1);
			}
			else {
				$position -= strlen($name);
				$name = "123456789";
				if($position < strlen($name)) {
					$code = substr($code, 0, 2) . substr($name, $position, 1);
				}
				else {
					$position -= strlen($name);
					$name = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
					$code = substr(str_shuffle($name), 0, 3);
				}
			}
		}
		//var_dump("Cod:$code |Pos:$position");
		return $code;
	}

	//Cria um código de cliente único
	public function uniqueColor($color, $position) {
		$colors = array('cc0000',
						'009933',
						'003399',
						'ff9900',
						'663300',
						'ff6699'
						);
		if($position < count($colors))
			return $colors[$position];
		return $this->GenerateRandomColor();
	}

	//Gera cor aleatória
	public function GenerateRandomColor() {
		$color = '';
		$colorHexLighter = array("9","A","B","C","D","E","F" );
		for($x=0; $x < 6; $x++):
    		$color .= $colorHexLighter[array_rand($colorHexLighter, 1)];
		endfor;
		return substr($color, 0, 6);
	}

	public function getStringMax($string, $max) {
		return mb_substr($string,0,$max).(strlen($string)>$max?'...':'');
	}

	public function getStringMaxWithoutSpecial($string, $max) {
		$stringWithMax = $this->getStringMax($string, $max);
		return str_replace("'","\"", preg_replace( "/\r|\n/", " ", $stringWithMax));
	}

	public function getStringWithLineBreakers($string) {
		return preg_replace( "/\n/", "<br>", preg_replace( "/\n\n/", "<br>", $string));
	}

	public function getFileType($filename) {
		return substr($filename, strrpos($filename, "."));
	}

	public function getTaskWithColor($task) {
		$task->class = $task->progress <= 10 ? 'progress-bar-danger' 	: ($task->progress <= 30 ? 'progress-bar-warning' 	: ($task->progress <= 50 ? '' : ($task->progress <= 90 ? 'progress-bar-info' : 'progress-bar-success')));
		$task->color = $task->progress <= 10 ? '(danger)' 				: ($task->progress <= 30 ? '(warning)' 				: ($task->progress <= 50 ? '' : ($task->progress <= 90 ? '(info)' : '(success)')));
		return $task;
	}

	public function addEventsToCalendar($clients, $userId, $adminEditor) {
		$script = "<script>\n" .
						//"\t$(\"#long-data-container\").css(\"display\",\"none\");" .
						"\t$(document).ready(function() {\n" .
						"\t\tvar event = null;\n";
		foreach($clients as $client) { 
			$clientId = $client['client']->id;
			$clientCode = $client['client']->code;
			$clientName = $client['client']->name;
			foreach($client['projects'] as $project) { 
				foreach($project->tasks as $task) {
					//if task not complete, the color is gray
					$color = $task->done == '1' ? 'aaa' : $client['client']->color;
					//if complete not passed in URL parameters, only shows not completed tasks
					if((!isset($_GET['complete']) && $task->done != '1'))
						$script .= $this->addEventScript($task, $color, $project, $client, $clientId, $clientCode, $clientName, $userId, $adminEditor);
					//if complete passed in URL parameters, shows all tasks
					else if(isset($_GET['complete']) && $_GET['complete'])
						$script .= $this->addEventScript($task, $color, $project, $client, $clientId, $clientCode, $clientName, $userId, $adminEditor);
				}
			}
		}

		$script .= "\t\tshowLongData();\n"; 
		$script .= "\t});\n";
		$script .= "</script>";
		return $script;
	}

	public function addEventScript($task, $color, $project, $client, $clientId, $clientCode, $clientName, $userId, $adminEditor) {
		$eventScript = "\t\tevent = {\n" .
							"\t\t\ttitle:			'$task->code: " . $this->getStringMax($task->title,26) . "',\n" .
							"\t\t\tstart:			'$task->deliverDate',\n" . 
							"\t\t\tend:				'$task->deliverDate',\n" . 
							"\t\t\tcolor:			'#$color',\n" . 
							"\t\t\ttextColor:		setContrast('#$color'),\n" . 
							"\t\t\thref:			'task?id=$task->id',\n" .
							"\t\t\tid:				$task->id,\n" .
							"\t\t\tstatus:			'$task->status',\n" .
							"\t\t\tprogress:		'$task->progress',\n" .
							"\t\t\tdone:			'$task->done',\n" .
							"\t\t\tuserAdmin:		'$adminEditor',\n" .
							"\t\t\tloggedUser:		$userId,\n" .
							"\t\t\tresponsibleUser:	$task->responsibleUserId,\n" .
							"\t\t\tclickInfo:		$('<h2 class=\"text-success\">(Clique para ver mais detalhes)</h2>'),\n" . 
							"\t\t\tp0:				$('<p><b>Título:</b> <a href=\"task?id=$task->id\">" . $this->getStringMaxWithoutSpecial($task->title,33) . "</a></p>'),\n" .
							"\t\t\tp1:				$('<p><b>Código:</b> <a href=\"task?id=$task->id\">$task->code</a></p>'),\n" .
							//"\t\t\tp0:				$('<h1><b>$task->code<br>" . $this->getStringMaxWithoutSpecial($task->title,26) . "</b></h1>'),\n" . 
							"\t\t\tp2:				$('<p><b>Projeto:</b> <a href=\"project?id=$project->id\">$project->code: " . $this->getStringMax($project->title,15) . "</a></p>'),\n" . 
			        		"\t\t\tp3:				$('<p><b>Cliente:</b> <i class=\"fa fa-user\" style=\"color:#$color\"></i> <a href=\"client?id=$clientId\">$clientCode - " . $this->getStringMax($clientName,23) . "</a></p>'),\n" .  
			        		"\t\t\tp4:				$('<p><b>Status:</b> $task->status</p>'),\n" . 
			        		"\t\t\tp5:				$('<p><b>Progresso:</b> $task->progress%</p><p><b>Completa:</b> <i class=\"fa fa-" . ($task->done ? 'check text-green' : 'times text-red') . "\"></i></p>'),\n" . 
			        		"\t\t\tp6:				$('<p><b>Descrição:</b> " . $this->getStringMaxWithoutSpecial($task->description,29) . "</p>'),\n" .
			        		"\t\t\tp7:				$('<p><b>Responsável:</b> <a href=\"user?id=$task->responsibleUserId\">" . $task->responsibleUser->names[0] . " (" . $task->responsibleUser->username . ")</a></p>'),\n" . 
			        		"\t\t\tp8:				$('<p><b>Criação:</b> " . $this->dateTimeToString($task->createDate) . "</p>'),\n" . 
			        		"\t\t\tp9:				$('<p><b>Entrega:</b> " . $this->dateTimeToString($task->deliverDate) . "</p>'),\n" . 
			        		"\t\t\tp10:				$('<p><b>Finalização:</b> " . ($task->finishDate == NULL ? "Não Finalizada" : $this->dateTimeToString($task->finishDate)) . "</p>'),\n" . 	
			        		"\t\t\tp11:				$('<p class=\"text-align-center\"><a href=\"task?id=$task->id\" class=\"btn btn-primary btn-lg btn-block\">Ir para tarefa</a></p>'),\n" .
			        		"\t\t\tp12:				$('<p id=\"task-completed-button\"><a onclick=\"taskCompleted($task->id,$project->id);\" class=\"btn btn-success btn-lg btn-block\"><i class=\"fa fa-check\"></i> Marcar como concluída</a></p>'),\n" .
			        		"\t\t\tmaxAtribute:		12,\n" .
		        		"\t\t};\n";
		$eventScript .= "\t\t$('#calendar').fullCalendar('renderEvent', event, true);\n\n";
		return $eventScript;
	}

}