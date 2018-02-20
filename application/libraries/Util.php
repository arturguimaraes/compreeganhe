<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Util {

	protected $CI;

	public function __construct() {
		// Assign the CodeIgniter super-object
		$this->CI =& get_instance();
	}
	
	//Converts array into object
	public function arrayToObject($array) {
    	return (object) $array;
	}

	//Converts object into array
	public function objectToArray($object) {
    	return (array) $object;
	}
	
	//Converts tree into array
	public function treeToArray($array, $node) {
		$children = $node['children'];
		unset($node['children']);
		array_push($array, $node);

		foreach($children as $child)
			$array = $this->treeToArray($array, $child);
		
		return $array;
	}

	public function orderArray($array) {
		//Order by name
		function cmpName($a, $b) {
	    	return strcmp(strtolower($a['user']->name), strtolower($b['user']->name));
	    }
	    //Order by payment date
	    function cmpPaymentDate($a, $b) {
	    	if ($a['user']->userPaymentDate == NULL && $b['user']->userPaymentDate == NULL)
	    		return 0;
	    	if ($a['user']->userPaymentDate == NULL)
	    		return 1;
	    	if ($b['user']->userPaymentDate == NULL)
	    		return -1;
	    	return strtotime($a['user']->userPaymentDate) > strtotime($b['user']->userPaymentDate);
		}
		//Order by create date
		function cmpCreateDate($a, $b) {
	    	return strtotime($a['user']->createDate) > strtotime($b['user']->createDate);		
		}

		if(isset($_GET['order']) && $_GET['order'] == 'name')
			usort($array, "cmpName");
		else if(isset($_GET['order']) && $_GET['order'] == 'paymentDate')
			usort($array, "cmpPaymentDate");
		else
			usort($array, "cmpCreateDate");

		return $array;
	}

	public function orderOrderArray($array) {
		//Order by name
		function cmpReference($a, $b) {
	    	return strcmp(strtolower($a->reference), strtolower($b->reference));
	    }
		//Order by create date
		function cmpCreateDate($a, $b) {
	    	return strtotime($a->createDate) > strtotime($b->createDate);		
		}

		if(isset($_GET['order']) && $_GET['order'] == 'reference')
			usort($array, "cmpReference");
		else if(isset($_GET['order']) && $_GET['order'] == 'createDate')
			usort($array, "cmpCreateDate");

		return $array;
	}
	
	public function orderOrderArrayByName($array) {
		//Order by name
		function cmpName($a, $b) {
	    	return strcmp(strtolower($a['user']->name), strtolower($b['user']->name));
	    }
		usort($array, "cmpName");
		return $array;
	}

	//Passes Datetime to user's view type date
	public function dateTimeToString($dateTime) {
		if($dateTime == NULL)
			return "";
		$year = substr($dateTime, 0, 4);
		$month = substr($dateTime, 5, 2);
		$day = substr($dateTime, 8, 2);
		$time = substr($dateTime, -8);
		return $day . '/' . $month . '/' . $year . ' ' . $time;
	}

	public function dateStringToDate($dateString) {
		if($dateString == NULL || $dateString == "")
			return NULL;
		return substr($dateString, -4) . '-' . substr($dateString, -7, 2) . '-' . substr($dateString, -10, 2);
	}

	//Gets total space
	public function getTotalSpace($value) {
		if($value > 1000000)
			return '';
		if($value > 100000)
			return ' ';
		if($value > 10000)
			return '  ';
		if($value > 1000)
			return '   ';
		if($value > 100)
			return '    ';
		if($value > 10)
			return '     ';
		return '      ';
	}

	//Gets string space
	public function getStringSpace($string) {
		if(strlen($string) > 40)
			return "\t";
		if(strlen($string) > 35)
			return "\t";
		if(strlen($string) > 30)
			return "\t\t";
		if(strlen($string) > 25)
			return "\t\t";
		if(strlen($string) > 20)
			return "\t\t\t";
		if(strlen($string) > 15)
			return "\t\t\t\t\t\t";
		if(strlen($string) > 10)
			return "\t\t\t\t\t\t\t";
		if(strlen($string) > 5)
			return "\t\t\t\t\t\t\t\t";
		return "\t\t\t\t\t\t\t\t\t";
	}
	
	//Gera Senha Aleatória
	public function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false) {
		$lmin = 'abcdefghijklmnopqrstuvwxyz';
		$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$num = '1234567890';
		$simb = '!@#$%*-';
		$retorno = '';
		$caracteres = '';
		$caracteres .= $lmin;
		if ($maiusculas) $caracteres .= $lmai;
		if ($numeros) $caracteres .= $num;
		if ($simbolos) $caracteres .= $simb;
		$len = strlen($caracteres);
		for ($n = 1; $n <= $tamanho; $n++) {
			$rand = mt_rand(1, $len);
			$retorno .= $caracteres[$rand-1];
		}
		return $retorno;
	}

	//Pega cores de fundo do array de pedidos
	public function getOrderBackgroundColors($orders) {
		//Seta a cor da linha da tabela
		foreach($orders as $order)
			$order = $this->getOrderBackgroundColor($order);
		return $orders;
	}

	//Pega cores de fundo do pedido
	public function getOrderBackgroundColor($order) {
		//Seta a cor da linha da tabela
		if($order->status == "Aprovada" || $order->status == "Aprovado")
			$order->backgroundColor = "background: lightgreen;";
		else if($order->status == "Aguardando Pagto")
			$order->backgroundColor = "background: lightgoldenrodyellow;";
		else if($order->status == "Cancelada" || $order->status == "Cancelado")
			$order->backgroundColor = "background: lightcoral;";
		else
			$order->backgroundColor = "";
		return $order;
	}
	
	//Pega cor da graduação
	public function getGraduationColor($graduation) {
		switch($graduation) {
			case 'DIAMANTE':
				return '#B9F2FF';
				break;
			case 'OURO':
				return '#D9D919';
				break;
			case 'PRATA':
				return '#E6E8FA';	
				break;
			case 'BRONZE':
				return '#A67D3D';
				break;
			case 'INICIANTE':
			default:
				return '#FFFFFF';
				break;
		}
	}
	
	//Pega string com limitações
	public function getStringMax($string, $max) {
		return mb_substr($string,0,$max).(strlen($string)>$max?'...':'');
	}

}