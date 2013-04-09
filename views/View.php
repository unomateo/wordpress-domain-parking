<?php
class View{
	public function __construct(){
		
	}
	
	function display($file, $params = array()){
		
		foreach($params as $key => $value) {
			$$key = $value;
		}
		
		require(DOMAINPARKING_PATH . "views/" . $file.".php");
	}
}