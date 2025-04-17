<?php

class IdEnView  extends IdEnController
	{				
		private $vController;
		
		public function __construct(IdEnRequest $vRequest)
			{
				$this->vController = $vRequest->getController();
				$this->vJavaScript = array();      

			}
			
		public function index(){}
			
		public function visualize($vNameView, $vItem = FALSE)
			{

				$vParamsViewBootstrap = array(
                                        'root_bootstrap_css'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/bootstrap/css/',
                                        'root_bootstrap_fonts'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/bootstrap/fonts/',
                                        'root_bootstrap_js'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/bootstrap/js/'
									 );
                
				$vParamsViewFrontEndLayout = array(
                                        'root_frontend_img'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/frontend/img/',
										'root_frontend_js'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/frontend/js/',
                                        'root_frontend_css'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/frontend/css/',
										'root_frontend_vendors'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/frontend/vendors/'
									 );							 

				$vParamsViewBackEndLayout = array(
										'root_backend_css'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/backend/css/',
										'root_backend_media'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/backend/media/',
                                        'root_backend_js'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/backend/js/',
                                        'root_backend_plugins'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/backend/plugins/',
										'root_backend_scripts'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/backend/scripts/',
									 );

				$vParamsViewStoreLayout = array(
                                        'root_store_img'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/store/img/',
										'root_store_js'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/store/js/',
                                        'root_store_css'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/store/css/',
										'root_store_fonts'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/store/fonts/',
										'root_store_vendor'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/store/vendor/',
									 );									 

				$vParamsViewWizardLayout = array(
                                        'root_wizard_img'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/wizard/img/',
										'root_wizard_js'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/wizard/js/',
                                        'root_wizard_css'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/wizard/css/',
										'root_wizard_fonts'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/wizard/fonts/',
										'root_wizard_vendor'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/wizard/vendor/',
									 );									 									 
									
				$vParamsViewLandingLayout = array('root_landing_assets'=>BASE_VIEW_URL.'views/layout/'.DEFAULT_VIEW_LAYOUT.'/landing/assets/');
									 
				$vRouteViewFrontEnd = ROOT_APPLICATION.'views'.DIR_SEPARATOR.'frontend'.DIR_SEPARATOR.$this->vController.DIR_SEPARATOR.$vNameView.'.php';

				$vRouteViewLanding = ROOT_APPLICATION.'views'.DIR_SEPARATOR.'landing'.DIR_SEPARATOR.$this->vController.DIR_SEPARATOR.$vNameView.'.php';

				$vRouteViewStore = ROOT_APPLICATION.'views'.DIR_SEPARATOR.'store'.DIR_SEPARATOR.$this->vController.DIR_SEPARATOR.$vNameView.'.php';

				$vRouteViewWizard = ROOT_APPLICATION.'views'.DIR_SEPARATOR.'wizard'.DIR_SEPARATOR.$this->vController.DIR_SEPARATOR.$vNameView.'.php';

				$vRouteViewBackEnd = ROOT_APPLICATION.'views'.DIR_SEPARATOR.'backend'.DIR_SEPARATOR.$this->vController.DIR_SEPARATOR.$vNameView.'.php';
            
                $vRouteViewAuth = ROOT_APPLICATION.'views'.DIR_SEPARATOR.'auth'.DIR_SEPARATOR.$this->vController.DIR_SEPARATOR.$vNameView.'.php';
                
                $vRouteViewError = ROOT_APPLICATION.'views'.DIR_SEPARATOR.'error'.DIR_SEPARATOR.$this->vController.DIR_SEPARATOR.$vNameView.'.php';

				if(is_readable($vRouteViewFrontEnd))
					{
						include_once ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.'header1.frontend.php';
						//include_once ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.'header2.frontend.php';
						include_once ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.'header3.frontend.php';
						include_once $vRouteViewFrontEnd;
                        include_once ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.'footer1.frontend.php';
						include_once ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.'footer2.frontend.php';
					}
				elseif(is_readable($vRouteViewLanding))
					{
						include_once ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.'header.landing.php';
						include_once $vRouteViewLanding;
						include_once ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.'footer.landing.php';
					}					
				elseif(is_readable($vRouteViewBackEnd))
					{
						include_once ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.'header.backend.php';
						include_once $vRouteViewBackEnd;
						include_once ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.'footer.backend.php';
					}
				elseif(is_readable($vRouteViewAuth))
					{
						include_once ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.'header.auth.php';
						include_once $vRouteViewAuth;
						include_once ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.'footer.auth.php';
					}
				elseif(is_readable($vRouteViewStore))
					{
						include_once ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.'header.store.php';
						include_once $vRouteViewStore;
						include_once ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.'footer.store.php';
					}
				elseif(is_readable($vRouteViewWizard))
					{
						//include_once ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.'header.store.php';
						include_once $vRouteViewWizard;
						//include_once ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.'footer.store.php';
					}										
				elseif(is_readable($vRouteViewError))
					{
						include_once ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.'header.error.php';
						include_once $vRouteViewError;
						include_once ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.'footer.error.php';
					}
				else
					{
                        header('Location: '.BASE_VIEW_URL.'error/view');
						exit;
					}								
			}			
	}
?>
