<?php
class IdEnRequest
	{	
		private $vController;
		private $vMethod;
		private $vArgs;
		
		public function __construct()
			{
				if(isset($_GET[DEFAULT_URL_HTACCESS]))
					{
						$vUrl = filter_input(INPUT_GET, DEFAULT_URL_HTACCESS, FILTER_SANITIZE_URL);
						$vUrl = explode('/', $vUrl);
                        $vUrl = array_filter($vUrl);
	
						$this->vController = strtolower(array_shift($vUrl));						
						$this->vMethod = strtolower(array_shift($vUrl));
						$this->vArgs = $vUrl;
					}       
			
				if(!$this->vController)
					{
						$this->vController = DEFAULT_CONTROLLER;
					}
				
				if(!$this->vMethod)
					{
						$this->vMethod = 'index';
					}
				
				if(!isset($this->vArgs))
					{
						$this->vArgs = array();
					}
				
			}	
		
		public function getController()
			{
				return $this->vController;
			}
		
		public function getMethod()
			{
				return $this->vMethod;
			}
		
		public function getArgs()
			{
				return $this->vArgs;
			}
	}
?>
