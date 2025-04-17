<?php

/*llama al controlador y al metodo que se envio*/

class IdEnInitialize
	{
		public static function Execute(IdEnRequest $vRequest)
			{
				$noNeedController = $vRequest->getController();
                
				$vController = $vRequest->getController().'Controller';
				$vRouteController = ROOT_APPLICATION.'controllers'.DIR_SEPARATOR.$vController.'.php';
				$vMethod = $vRequest->getMethod();
				$vArgs = $vRequest->getArgs();
				if(is_readable($vRouteController))
					{
						require_once $vRouteController;
						$vController = new $vController;
						if(is_callable(array($vController, $vMethod)))
							{
								$vMethod = $vRequest->getMethod();
							}
						else
							{
								$vMethod = 'index';
							}
							
						if(isset($vArgs))
							{
								call_user_func_array(array($vController, $vMethod), $vArgs);/* EN UN ARREGLO SE ENVIA EL NOMBRE DEL CONTROLADOR/CLASE, EL METODO Y LOS PARAMETROS QUE SE LE PASAN AL METODO QUE SE LLAMA*/
							}
						else
							{
								call_user_func($array($vController, $vMethod));/*SI NO EXISTEN ARGUMENTOS LLAMA A LA CLASE CONTENIDA EN EL CONTROLADOR Y AL METODO QUE SE SOLICITA*/
							}
					}
				else
					{
						//header('Location: '.BASE_VIEW_URL.'account/exists/'.$noNeedController);
                        //header('Location: '.BASE_VIEW_URL.'error/'.$noNeedController);
                        //header('Location: '.BASE_VIEW_URL.'error/controller');
						header('Location: '.BASE_VIEW_URL.'index');
					}
			}
	}
?>