<?php

class IdEnModel
	{
		protected $vDataBase;
		
		public function __construct()
			{
				$this->vDataBase = new IdEnDatabaseConnection();
			}
	}
?>
