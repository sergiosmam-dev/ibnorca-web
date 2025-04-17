<?Php

class profileController extends IdEnController
	{		
		public function __construct(){
                parent::__construct();        
				/* BEGIN VALIDATION TIME SESSION USER */
				if(!IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE)){
                    $this->redirect('auth');
                } else {
                    IdEnSession::timeSession();
                    $this->redirect('dashboard');
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
                $this->vView->vProfileNameLogged = ucwords($this->vProfileData->getNames($this->vCodProfileLogged).' '.$this->vProfileData->getLastNames($this->vCodProfileLogged));
                $this->vView->vProfileEmailLogged = $this->vUsersData->getUserEmail($this->vCodUserLogged);
                $this->vView->vProfileEmailValidation = $this->vUsersData->getAccountStatusUserCode($this->vCodUserLogged);
                //$this->vView->vProfileNotifications = $this->vNotificationsData->getProfileNotifications($this->vCodProfileLogged, 0);
                /********************************/
                /* END AUTHENTICATE USER ACTIVE */
                /********************************/

                $this->vView->vControllerActive = 'profile';
                $this->vView->vSubNavContent = '';
            
			}
		public function index(){
            
				/* BEGIN VALIDATION TIME SESSION USER */
				if(!IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE)){
                    $this->redirect('auth');
                } else {
                    IdEnSession::timeSession();
                }
                /* END VALIDATION TIME SESSION USER */
			}
		/*public function updateProfileName(){            
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    
                    $vProfileNameURL = (string) $_POST['vProfileNameURL'];
                    
                    if(preg_match('/[^a-z_\-0-9]/i', $vProfileNameURL)){
                        echo 'only-letters';
                    } else {
                        if($this->vProfileData->getProfileExists($vProfileNameURL) == 1){
                            echo 'profilename-exists';
                        } else {
                            
                            IdEnSession::sessionDestroy(DEFAULT_USER_AUTHENTICATE.'ProfileName');
                            
                            $vCodProfile = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode');
                            $vCodUser = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');                            
                            
                            $vUpdateProfileName = $this->vProfileData->updateProfileName($vCodProfile, $vCodUser,$vProfileNameURL);
                            
                            IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'ProfileName', $vProfileNameURL);
                            
                            echo $vUpdateProfileName;
                        }
                    }
                }
        } */   
		public function person($vProfileName = null){
            if($this->vProfileData->getProfileExists($vProfileName) == 0){
                $this->redirect('profile/person/'.$this->vProfileData->getProfileName($this->vCodProfileLogged, $this->vCodUserLogged));
            }
            
            /*****************/
            /* BEGIN PROFILE */
            /*****************/            
            $vProfileName = (string) $vProfileName;
            
            $this->vView->vProfileName = (string) $vProfileName;
            $this->vView->vProfileCompleteName = ucwords($this->vProfileData->getNames($this->vCodProfileLogged).' '.$this->vProfileData->getLastNames($this->vCodProfileLogged));
            $this->vView->vCodProfile = $this->vCodProfileLogged;            
            /************************/
            /* END PERSON PROFILE */
            /************************/

        
            $this->vView->visualize('person');
        }
		public function personEdit($vProfileName = null){
            if($this->vProfileData->getProfileExists($vProfileName) == 0){
                $this->redirect('profile/personEdit/'.$this->vProfileData->getProfileName($this->vCodProfileLogged, $this->vCodUserLogged));
            }
            
            /*****************/
            /* BEGIN PROFILE */
            /*****************/
            
            /*$this->vView->vProfileName = (string) $vProfileName;
            $this->vView->vProfileCompleteName = ucwords($this->vProfileData->getNames($this->vCodProfileLogged).' '.$this->vProfileData->getLastNames($this->vCodProfileLogged));
            $this->vView->vProfileNames = ucwords($this->vProfileData->getNames($this->vCodProfileLogged));
            $this->vView->vProfileLastNames = ucwords($this->vProfileData->getLastNames($this->vCodProfileLogged));
            $this->vView->vCodProfile = $this->vCodProfileLogged;*/
            /************************/
            /* END PERSON PROFILE */
            /************************/

            $vCodProfile = $this->vProfileData->getProfileCodFromProfileName($vProfileName);

            $this->vView->vDataProfile = $this->vProfileData->getProfile($vCodProfile);
        
            $this->vView->visualize('personEdit');
        }
		public function password($vProfileName = null){
            if($this->vProfileData->getProfileExists($vProfileName) == 0){
                $this->redirect('profile/password/'.$this->vProfileData->getProfileName($this->vCodProfileLogged, $this->vCodUserLogged));
            }
            
            /*****************/
            /* BEGIN PROFILE */
            /*****************/
            
            /*$this->vView->vProfileName = (string) $vProfileName;
            $this->vView->vProfileCompleteName = ucwords($this->vProfileData->getNames($this->vCodProfileLogged).' '.$this->vProfileData->getLastNames($this->vCodProfileLogged));
            $this->vView->vProfileNames = ucwords($this->vProfileData->getNames($this->vCodProfileLogged));
            $this->vView->vProfileLastNames = ucwords($this->vProfileData->getLastNames($this->vCodProfileLogged));
            $this->vView->vCodProfile = $this->vCodProfileLogged;*/
            /************************/
            /* END PERSON PROFILE */
            /************************/

            $vCodProfile = $this->vProfileData->getProfileCodFromProfileName($vProfileName);

            $this->vView->vDataProfile = $this->vProfileData->getProfile($vCodProfile);
        
            $this->vView->visualize('password');
        }        
    }
?>