<?php 
class App{
	private $controller = "home";
	private $action="show";
	private $params=[];
	
	function __construct(){
		$arr = $this->UrlProcess();
		
		if(file_exists("private/controllers/".$arr[0].".php")){
			$this->controller = $arr[0];
		}
		require_once("private/controllers/".$this->controller.".php");
		if(isset($arr[1])){
			if(method_exists($this->controller, $arr[1])){
				$this->action = $arr[1];
			}
		}
	}
	
	function UrlProcess(){
		if(isset($_GET["url"]) ){
			return explode("/",filter_var(trim($_GET["url"], "/")) );
		}
	}
}
?>