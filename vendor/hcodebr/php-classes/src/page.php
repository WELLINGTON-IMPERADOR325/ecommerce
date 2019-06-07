<?php
namespace Hcode;

use Rain\TpL;

class Page{
	private $tpl;
	private $options = [];
	private $defaults = [
		"header"=>true,
		"footer"=>true,
		"data"=>[]
	];
	public function __construct($opts = array(),$tpl_dir = "/views/"){
		
		$this->defaults["data"]["session"] = $_SESSION;
		$this->options = array_merge($this->defaults, $opts);// aqui o metodo __construct vai fazer o merge das paginas
		
		$config = array(
			"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"].$tpl_dir,
			"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
			"debug"			=> false
		);

		Tpl::configure( $config );
		$this->tpl = new TpL;
		$this->setData($this->options["data"]);
		if($this->options["header"] === true) $this->tpl->draw("header");//cabecalho
	}
	private function setData($data = array())
	{
		foreach($data as $key => $value){
			$this->tpl->assign($key,$value);
		}
	}
	public function setTpl($name,$data = array(),$returnHTML = false)//BODY
	{
		$this->setData($data);
		return $this->tpl->draw($name, $returnHTML);
	}
	
	public function __destruct(){//FOOTER
		if($this->options["footer"] === true ) $this->tpl->draw("footer");
		
	}
}

?>