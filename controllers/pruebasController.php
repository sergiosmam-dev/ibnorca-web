<?Php

class pruebasController extends IdEnController
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

                        $this->vView->vSubNavContent = '';
                }
                        
                public function index(){
                        $this->vView->vMethodActive = 'index';
                        $this->vView->visualize('index');
                        } 
                        public function bienvenida()
                        {
                                $this->vView->visualize('bienvenida');
                        } 
                        public function forms()
                        {
                                $this->vView->visualize('forms');
                        }                                                    
	}
?>