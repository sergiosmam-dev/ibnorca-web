<?Php

class storeController extends IdEnController
	{		
		public function __construct(){

                parent::__construct();
                
                $this->vView->vSessionLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE);
        
                $this->vCtrl = $this->LoadModel('ctrl');
                $this->vMenuData = $this->LoadModel('menu');
                $this->vAccessData = $this->LoadModel('access');
                $this->vUsersData = $this->LoadModel('users');
                $this->vProfileData = $this->LoadModel('profile');
                $this->vAPIIbnorcaData = $this->LoadModel('apiibnorca');
                $this->vFrontEndData = $this->LoadModel('frontend');

                $this->vView->vSubNavContent = '';
			}
			
                        public function index(){

                                $this->vView->DataWebSectors = $this->vFrontEndData->getSectors();
                
                                $this->vView->vMethodActive = 'index';
                                $this->vView->visualize('index');
                                        }                                           
                                                                 
	}
?>