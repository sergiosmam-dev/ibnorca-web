<?Php

class errorController extends IdEnController
	{		
		public function __construct(){
            
                parent::__construct();
            
				/* BEGIN VALIDATION TIME SESSION USER */
				if(!IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE)){
                    $this->redirect('auth');
                } else {
                    IdEnSession::timeSession();
                }
                /* END VALIDATION TIME SESSION USER */
            
                $this->vCtrl = $this->LoadModel('ctrl');            
                $this->vMenuData = $this->LoadModel('menu');
                $this->vAccessData = $this->LoadModel('access');
                $this->vUsersData = $this->LoadModel('users');
                $this->vProfileData = $this->LoadModel('profile');
            
                /**********************************/
                /* BEGIN AUTHENTICATE USER ACTIVE */
                /**********************************/
                $this->vCodProfileLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode');
                $this->vCodUserLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
                //$this->vView->vProfileImageNameLogged = 'directory_'.$this->vCodProfileLogged.'/'.$this->vProfileData->getProfileImage($this->vCodProfileLogged);
                //$this->vView->vProfileNameLogged = ucwords($this->vProfileData->getNames($this->vCodProfileLogged).' '.$this->vProfileData->getLastNames($this->vCodProfileLogged));
                //$this->vView->vProfileNameLetters = substr($this->vProfileData->getNames($this->vCodProfileLogged), 0, 1).substr($this->vProfileData->getLastNames($this->vCodProfileLogged), 0, 1);
                //$this->vView->vProfileEmailLogged = $this->vUsersData->getUserEmail($this->vCodUserLogged);
                //$this->vView->vProfileEmailValidation = $this->vUsersData->getAccountStatusUserCode($this->vCodUserLogged);
                //$this->vView->vProfileNotifications = $this->vNotificationsData->getProfileNotifications($this->vCodProfileLogged, 0);
                /********************************/
                /* END AUTHENTICATE USER ACTIVE */
                /********************************/            
                $this->vView->vControllerActive = 'error';

                $this->vView->vSubNavContent = '';
                }
			
		public function index(){
                $this->vView->visualize('index');
			}
        
		public function controller(){
                $this->vView->visualize('controller');
			}

		public function view(){
                $this->vView->visualize('view');
			} 
    
		public function sessionTimeExpired(){
            
                /* CONTROL USER SESSION */
                $this->vCtrl->insertCtrlSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'), 'session-time-Expired', session_id(), $this->getUserIP(), $this->getMAC(), $this->getOS(), $this->getBrowser(), $this->getComputerName());
            
                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE, false);
                IdEnSession::sessionDestroy(DEFAULT_USER_AUTHENTICATE);
                IdEnSession::sessionDestroy(DEFAULT_USER_AUTHENTICATE.'UserCode');
                IdEnSession::sessionDestroy(DEFAULT_USER_AUTHENTICATE.'UserEmail');
                IdEnSession::sessionDestroy(DEFAULT_USER_AUTHENTICATE.'UserRole');
                IdEnSession::sessionDestroy(DEFAULT_USER_AUTHENTICATE.'ProfileName');
                IdEnSession::sessionDestroy(DEFAULT_USER_AUTHENTICATE.'ProfileCode');
                IdEnSession::sessionDestroy(DEFAULT_USER_AUTHENTICATE.'TimeSession');
            
                $this->vView->visualize('sessionTimeExpired');
			}     
	}
?>