<?php
namespace Hcode;
use Rain\TpL;
class Mailer {
	
	const USERNAME = "manutvgamaaraujo@gmail.com";
	const PASSWORD = "";
	const NAME_FROM = "Emnauelle teste ";
	
	private $mail;
	
	public function __costruct($toAdress,$toName,$subject,$tplname,$data = array())
	{
		
		$config = array(
			"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/email/",
			"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
			"debug"			=> false
		);

		Tpl::configure( $config );
		$tpl = new TpL;
		
		foreach ($data as $key => $value){
			$tpl->assign($key, $value);
		}
		$html = $tpl->draw($tplName, true);
		
		$this->mail = new \PHPMailer;	
				//$mail = new PHPMailer\PHPMailer\PHPMailer();

		// Diga ao PHPMailer para usar o SMTP
		$This->$mail->isSMTP();

		// Ativar depuração de SMTP
		// 0 = off (para uso em produção)
		// 1 = mensagens do cliente
		// 2 = mensagens do cliente e do servidor
		$This->mail->SMTPDebug = 0;

		$This->mail->Debugoutput = 'html';

		// Definir o nome do host do servidor de email
		$This->mail->Host = 'smtp.gmail.com'; //ip do servidor
		// usar
		//$mail-> Host = gethostbyname ('smtp.gmail.com');
		// se sua rede não suporta SMTP sobre IPv6

		// Defina o número da porta SMTP - 587 para o TLS autenticado, também conhecido como envio SMTP RFC4409
		$This->mail->port = 587;// muda-se a porta

		//forma mais simplificada $mail->Host = 'tls: //smtp.gmail.com:587';

		// Definir o sistema de criptografia para usar - ssl (reprovado) ou tls
		$This->mail->SMTPSecure = 'tls';

		// Se deseja usar a autenticação SMTP
		$This->mail->SMTPAuth = true;

		// Nome de usuário para usar na autenticação SMTP - use o endereço de e-mail completo para o gmail
		$This->mail->Username = Mailer::USERNAME;

		// Senha para usar para autenticação SMTP
		$This->mail->Password = Mailer::PASSWORD;

		// Defina para quem a mensagem deve ser enviada
		$this->mail->setFrom(Mailer::USERNAME, Mailer::NAME_FROM);

		// Definir um endereço de resposta alternativo
		//$ mail-> addReplyTo ('replyto@example.com ',' Primeiro Último ');

		// Defina para quem a mensagem deve ser enviada
		$this->mail->addAddress ($toAddress,$toName);

		// Definir a linha de assunto
		$this->mail->Subject = $subject;

		// Leia um corpo de mensagem HTML de um arquivo externo, converta imagens referenciadas em
		// converte HTML em um corpo alternativo de texto simples básico
		$this->mail->msgHTML($html);

		// Substitua o corpo do texto simples por um criado manualmente
		$this->mail->AltBody = 'Este é um corpo de mensagem de texto simples';
	}
		public function send() 
		{
			return $this->mail->send();
		}
}

?>