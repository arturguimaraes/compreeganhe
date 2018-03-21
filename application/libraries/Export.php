<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Export {

	protected $CI;

	public function __construct() {
		// Assign the CodeIgniter super-object
		$this->CI =& get_instance();
		$this->CI->load->model(array('user','order','network','transaction'));
		$this->CI->load->library(array('util'));
	}
	
	//Export to .txt files
	public function export() {
		//Verifica se o usuário está logado
		if(!$this->CI->user->checkLogin()) {
			//$this->login();
			redirect('/login');
			return;
		}

		if(!isset($_GET['content'])) {
			//$this->myaccount();
			redirect('/myaccount');
		}
		else {
			//Pega os dados do usuário logado
			$data['user'] = $this->CI->user->getUserData();
			//Cria arquivo e baixa
			switch($_GET['content']) {
				case 'myorders':
					//Pega os pedidos desse usuário
					$data['orders'] = $this->CI->util->orderOrderArray($this->CI->order->getAll($data['user']->id));
					//Headers do arquivo .csv
					$text = "Data,Referência,Referência do PagSeguro,Descrição,Status,Valor Total,Tipo de Pagamento\n";
					foreach($data['orders'] as $order)
						$text .= $this->CI->util->dateTimeToString($order->createDate) . "," . $order->reference . "," . $order->transactionId . "," .
								$order->description . "," . $order->status . "," . number_format($order->total, 2, '.', '') . "," . $order->payment . "\n";
					$this->writeUTF8File("myorders.csv", $text);
					$this->download("myorders.csv");
					redirect('/myorders');
					break;
				case 'mybudget':
					//Pega todas as transações do usuário
					$data['transactions'] = $this->CI->util->orderTransactionArray($this->CI->transaction->getAll($data['user']->id));
					//Headers do arquivo .csv
					$text = "Data,Descrição,Valor\n";
					$total = 0;
					foreach($data['transactions'] as $transaction) {
						$text .= $this->CI->util->dateTimeToString($transaction->createDate) . "," . $transaction->action . "," . number_format($transaction->value, 2, '.', '') . "\n";
						$total += $transaction->value;
					}
					$text .= ",TOTAL," . number_format($total, 2, '.', '') . "\n";
					$this->writeUTF8File("mybudget.csv", $text);
					$this->download("mybudget.csv");
					redirect('/mybudget');
					break;

				case 'mynetwork':
					//Adiciona as informações do próprio usuário no array da rede
					$node = array('user' => $data['user'], 'level' => 'Dono', 'children' => $this->CI->network->getSons($data['user']->id));
					//Pega todos os usuários da rede do usuário logado
					$data['network'] = $this->CI->util->orderArray($this->CI->util->treeToArray(array(), $node));
					//Headers do arquivo .csv
					$text = "Nome,Usuário,Data de Cadastro,Nível de Indicação,Graduação,Usuário Ativo,Data de Ativação\n";
					foreach($data['network'] as $user) { 
						if(isset($_SESSION['username']) && $user['user']->username != $_SESSION['username']) {
							$text .= $user['user']->name . "," . $user['user']->username . "," . $this->CI->util->dateTimeToString($user['user']->createDate) . "," .
									 $user['level'] . "," . $user['user']->graduation . "," . ($user['user']->userPaymentDate != NULL ? 'Ativo' : 'Não Ativo') . "," . 
									 ($user['user']->userPaymentDate != NULL ? $this->CI->util->dateTimeToString($user['user']->userPaymentDate) : '') . "\n";
						}
					}
					$this->writeUTF8File("mynetwork.csv", $text);
					$this->download("mynetwork.csv");
					redirect('/mynetwork');
					break;
				
			}
		}
	}
	
	//Downloads Files
	public function download($fileName) {
		if (file_exists($fileName)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($fileName).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($fileName));
			readfile($fileName);

			//Deleta o arquivo
			if(file_exists($fileName))
				unlink($fileName);

			exit;
		}		
	}

	//Write UTF-8 File
	private function writeUTF8File($filename, $content) { 
        $f = fopen($filename,"w"); 
        # Now UTF-8 - Add byte order mark 
        fwrite($f, pack("CCC", 0xef, 0xbb, 0xbf)); 
        fwrite($f, $content); 
        fclose($f); 
	}

}




/*MY BUDGET EXPORT 

$file = fopen("mybudget.txt", "w") or die("Não foi possível criar o arquivo!");
					
					//Pega os dados do usuário logado
					$user = $this->CI->user->getUserData();
					$dateNow =  mdate('%d-%m-%Y %H:%i:%s', now('America/Sao_Paulo'));
					$text = "COMPRE E GANHE - Extrato do Usuário\nUsuário: " . $user->name . "\nCPF: " . $user->cpf . "\nHora do extrato: " . $dateNow . "\n\n";
					fwrite($file, $text);

					//Escreve os dados do extrato
					$text = "| Data -------------- | Quantidade | Valor ------ |\n";
					fwrite($file, $text);
					$data['orders'] = $this->CI->order->getAll($user->id);
					$data['total'] = 0.00;
					foreach($data['orders'] as $order) {
						$text = '| ' . $this->CI->util->dateTimeToString($order->createDate) . ' | ' . $order->productAmount . '          | R$ ' . $this->CI->util->getTotalSpace($order->total) . number_format($order->total,2) . "|\n";
						fwrite($file, $text);
						$data['total'] += $order->total;
					}
					$text = "|---------------------|------------|--------------|\n| TOTAL:                             R$ " . $this->CI->util->getTotalSpace($data['total']) . number_format($data['total'],2) . "|\n|-------------------------------------------------|";
					fwrite($file, $text);
					fclose($file);
					$this->download("mybudget.txt");
					redirect('/mybudget');*/

/*MY NETWORKS BUDGET EXPORT

$file = fopen("mynetworksbudget.txt", "w") or die("Não foi possível criar o arquivo!");
					
					//Pega os dados do usuário logado
					$user = $this->CI->user->getUserData();
					$dateNow =  mdate('%d-%m-%Y %H:%i:%s', now('America/Sao_Paulo'));
					$text = "COMPRE E GANHE - Extrato de Rede do Usuário\nUsuário: " . $user->name . "\nCPF: " . $user->cpf . "\nHora do extrato: " . $dateNow . "\n\n";
					fwrite($file, $text);

					//Pega os filhos do usuário
					$node = array('user' => $user, 'level' => 'Dono', 'children' => $this->CI->network->getSons($user->id));
					//Monta o array de filhos
					$childrenArray = $this->CI->util->treeToArray(array(), $node);

					$data['network'] = array();
					//Adiciona os filhos ao array do extrato
					foreach($childrenArray as $child)
						array_push($data['network'], array("user" => $child, "orders" => $this->CI->order->getAll($child['user']->id)));

					//Escreve os dados do extrato
					$text = "| Data\t\t\t\t\t\tNome do Usuário\t\t\t\t\t\t\tNível de Indicação\t\tQuantidade\tValor\t\t |\n|--------------------------------------------------------------------------------------------------------------------|\n";
					fwrite($file, $text);
					
					$data['totalGeral'] = 0.00;
					foreach($data['network'] as $user) {
						if(isset($user['orders']) && count($user['orders']) > 0) {
							$data['total'] = 0.00;
							foreach($user['orders'] as $order) { 
								$levelSpace = ($user['user']['level'] == 'Dono' || $user['user']['level'] == 'Direto') ? "\t" : "";
								$text = '| ' . $this->CI->util->dateTimeToString($order->createDate) . "\t\t" . $user['user']['user']->name . $this->CI->util->getStringSpace($user['user']['user']->name) . $user['user']['level'] . $levelSpace . "\t\t\t\t" . $order->productAmount . "\t\t\tR$" . $this->CI->util->getTotalSpace($order->total) . number_format($order->total,2) . " |\n";
								fwrite($file, $text);
								$data['total'] += $order->total;
							}
							$text = "| Total\t\t\t\t\t\t" . $user['user']['user']->name . $this->CI->util->getStringSpace($user['user']['user']->name) .  "\t\t\t\t\t\t\t\t\tR$" . $this->CI->util->getTotalSpace($data['total']) . number_format($data['total'],2) . " |\n|--------------------------------------------------------------------------------------------------------------------|\n";
							fwrite($file, $text);
						}
						$data['totalGeral'] += $data['total'];
					}
					$text = "| TOTAL GERAL \t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\tR$" . $this->CI->util->getTotalSpace($data['totalGeral']) . number_format($data['totalGeral'],2) . " |\n|--------------------------------------------------------------------------------------------------------------------|";
					fwrite($file, $text);
					fclose($file);
					$this->download("mynetworksbudget.txt");
					redirect('/mynetworksbudget');*/