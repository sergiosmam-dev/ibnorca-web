<?Php

class authController extends IdEnController
	{		
		public function __construct(){
                parent::__construct();
            
                $this->vCtrl = $this->LoadModel('ctrl');
            
                $this->vAccessData = $this->LoadModel('access');
                $this->vUsersData = $this->LoadModel('users');
                $this->vProfileData = $this->LoadModel('profile');
                //$this->vFacebookData = $this->LoadModel('facebook');
                //$this->vGoogleData = $this->LoadModel('google');

                $this->vView->vSubNavContent = '';
            
			}
    
            public function index(){
            
				/* BEGIN VALIDATION TIME SESSION USER */
				if(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE)){
                        $this->redirect('profile');
                }
                /* END VALIDATION TIME SESSION USER */            
            
                //$this->vView->visualize('index');
                $this->redirect('auth/signin');                
            }
            public function signin(){
            
				/* BEGIN VALIDATION TIME SESSION USER */
				if(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE)){
                        $this->redirect('profile');
                }
                /* END VALIDATION TIME SESSION USER */            
            
                $this->vView->visualize('signin');
            }             
		public function signup(){
            
				/* BEGIN VALIDATION TIME SESSION USER */
				if(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE)){
                        $this->redirect('profile');
                }
                /* END VALIDATION TIME SESSION USER */            
            
                $this->vView->visualize('signup');
            }
    
        public function LoginMethod(){
            
				/* BEGIN VALIDATION TIME SESSION USER */
				if(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE) == true){
                    $this->redirect('profile');
                }
                /* END VALIDATION TIME SESSION USER */             
            
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    $vEmail = (string) strtolower($_POST['email']);
                    $vPassword = (string) $_POST['password'];
                    $vVerifyUserStatus = $this->vUsersData->getUserEmailExists($vEmail);
                    if($vVerifyUserStatus == 0){
                        // Email not register in database.
                        echo 'no-email';
                    } elseif($vVerifyUserStatus == 1){
                        // Email exists in database.
                        $vValidPassword = $this->vAccessData->getValidPassword($vEmail,$vPassword);
                        
                        if($vValidPassword == 1){
                            $vUserAccountStatus = $this->vUsersData->getUserAccountStatus($vEmail);
                            if($vUserAccountStatus == 0){
                                echo '3';
                            } elseif($vUserAccountStatus == 1){
                                $vAccessStatus = $this->vAccessData->getAccessStatus($vEmail,$vPassword);
                                $vProfileType = 1;
                                $vProfileCode = $this->vProfileData->getProfileCodeFromUserCode($vAccessStatus['n_coduser'], $vProfileType);

                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE, true);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'RandCodeUser', rand(10000, 99999).'-'.$vAccessStatus['n_coduser']);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'UserCode', $vAccessStatus['n_coduser']);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'UserEmail', $vAccessStatus['c_email']);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'UserRole', $vAccessStatus['c_userrole']);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'ProfileName', $vAccessStatus['c_profilename']);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode', $vProfileCode);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'TimeSession', time());
                                
                                /* CONTROL USER SESSION */
                                $this->vCtrl->insertCtrlSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'), 'login', session_id(), $this->getUserIP(), $this->getMAC(), $this->getOS(), $this->getBrowser(), $this->getComputerName());

                                echo 'success';


                            } elseif($vUserAccountStatus == 2){
                                
                                $vAccessStatus = $this->vAccessData->getAccessStatus($vEmail,$vPassword);
                                $vProfileType = 1;
                                $vProfileCode = $this->vProfileData->getProfileCodeFromUserCode($vAccessStatus['n_coduser'], $vProfileType);

                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE, true);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'RandCodeUser', rand(10000, 99999).'-'.$vAccessStatus['n_coduser']);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'UserCode', $vAccessStatus['n_coduser']);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'UserEmail', $vAccessStatus['c_email']);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'UserRole', $vAccessStatus['c_userrole']);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'ProfileName', $vAccessStatus['c_profilename']);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode', $vProfileCode);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'TimeSession', time());

                                /* CONTROL USER SESSION */
                                $this->vCtrl->insertCtrlSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'), 'login', session_id(), $this->getUserIP(), $this->getMAC(), $this->getOS(), $this->getBrowser(), $this->getComputerName());                                
                                
                                echo 'no_active';
                            }                            
                        } else {
                            echo 'password-incorrect';
                        }
                    }
                }
			}
		public function LogoutMethod(){
            
                /* CONTROL USER SESSION */
                $this->vCtrl->insertCtrlSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'), 'logout', session_id(), $this->getUserIP(), $this->getMAC(), $this->getOS(), $this->getBrowser(), $this->getComputerName());
            
                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE, false);
                IdEnSession::sessionDestroy(DEFAULT_USER_AUTHENTICATE);

                IdEnSession::sessionDestroy(DEFAULT_USER_AUTHENTICATE.'AccountingPeriodCode-'.IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode').IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'));
                IdEnSession::sessionDestroy(DEFAULT_USER_AUTHENTICATE.'AccountingPeriodName-'.IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode').IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'));

                IdEnSession::sessionDestroy(DEFAULT_USER_AUTHENTICATE.'RandCodeUser');
                IdEnSession::sessionDestroy(DEFAULT_USER_AUTHENTICATE.'UserCode');
                IdEnSession::sessionDestroy(DEFAULT_USER_AUTHENTICATE.'UserEmail');
                IdEnSession::sessionDestroy(DEFAULT_USER_AUTHENTICATE.'UserRole');
                IdEnSession::sessionDestroy(DEFAULT_USER_AUTHENTICATE.'ProfileName');
                IdEnSession::sessionDestroy(DEFAULT_USER_AUTHENTICATE.'ProfileCode');
                IdEnSession::sessionDestroy(DEFAULT_USER_AUTHENTICATE.'TimeSession');
                unset($_SESSION['miembroDatos']);
                session_destroy();
            
				//$this->redirect('auth','login');
                $this->redirect('index');
			}
    
		/*public function RegisterMethod(){

				// BEGIN VALIDATION TIME SESSION USER
				if(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE) == true){
                    $this->redirect('profile');
                }
                // END VALIDATION TIME SESSION USER
            
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    
                    $vNames = (string) strtolower($_POST['names']);
                    $vLastNames = (string) strtolower($_POST['lastnames']);
                    $vEmail = (string) strtolower($_POST['email']);
                    $vPassword = (string) $_POST['password'];
                    $vRePassword = (string) $_POST['repassword'];
                    $vRole = (string) 'frontend';
                    $vActivationcode = rand(1000000,9999999);
                    $vStatus = (int) 1;
                    $vActive = (int) 2;
                    
                    if($this->vUsersData->getUserEmailExists($vEmail) == 0){
                        $vUserCode = $this->vUsersData->userRegister(0,$vEmail,$vPassword,$vRePassword,$vEmail,$vRole,$vActivationcode,$vStatus,$vActive);                            
                        if($vUserCode != 0){
                            $vOthername = (string) $vEmail;
                            $vProfileName = (string) strtolower(str_replace(' ', '', $vNames).str_replace(' ', '', $vLastNames));
                            
                            if($this->vProfileData->getProfileExists($vProfileName) == 1){
                                $vProfileName = $vProfileName.rand(100,999);
                            }
                            
                            $vProfileType = 1;
                            $vProfileCode = $this->vProfileData->profileRegister($vUserCode, $vProfileName, $vNames, $vLastNames, $vProfileType, $vStatus, $vActive);                                
                            if($vProfileCode != 0){
                                                              
                                
                                $vUserCode = $this->vProfileData->getCodUserFromCodProfile($vProfileCode);
                                $vProfileName = $this->vProfileData->getProfileNameFromCodProfile($vProfileCode);
                                $vUserEmail = $this->vUsersData->getUserEmail($vUserCode);
                                $vUserRole = $this->vUsersData->getUserRole($vUserCode);


                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE, true);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'RandCodeUser', rand(10000, 99999).'-'.$vUserCode);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'UserCode', $vUserCode);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode', $vProfileCode);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'ProfileName', $vProfileName);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'Email', $vUserEmail);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'Role', $vUserRole);
                                IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'TimeSession', time());
                                
                                // CONTROL USER SESSION 
                                $this->vCtrl->insertCtrlSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'), 'Signin', session_id(), $this->getUserIP(), $this->getMAC(), $this->getOS(), $this->getBrowser(), $this->getComputerName());
                                
                                // CONTROL USER ACTION
                                $this->vCtrl->insertCtrlAction($this->vCtrl->getLastSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'),IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode')), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'), 'register', 'auth', 'RegisterMethod', 'userRegister', $vNames.';'.$vLastNames.';'.$vActivationcode.';'.$vActivationcode.';'.$vActive);

                                echo 'success';
                            } else {
                                echo 'fail';
                            }
                        }
                    } else {
                        echo 'email exists';
                    }
                }
			}*/
	}
?>