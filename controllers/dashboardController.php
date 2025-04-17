<?Php

class dashboardController extends IdEnController
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
                
                $this->vView->vSessionLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE);
                
                $this->vCtrl = $this->LoadModel('ctrl');
                $this->vMenuData = $this->LoadModel('menu');
                $this->vAccessData = $this->LoadModel('access');
                $this->vUsersData = $this->LoadModel('users');
                $this->vProfileData = $this->LoadModel('profile');
                $this->vAPIIbnorcaData = $this->LoadModel('apiibnorca');
            
                /**********************************/
                /* BEGIN AUTHENTICATE USER ACTIVE */
                /**********************************/
                $this->vCodProfileLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode');
                $this->vCodUserLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
                //$this->vView->vProfileImageNameLogged = 'directory_'.$this->vCodProfileLogged.'/'.$this->vProfileData->getProfileImage($this->vCodProfileLogged);
                $this->vView->vProfileNameLogged = ucwords($this->vProfileData->getNames($this->vCodProfileLogged).' '.$this->vProfileData->getLastNames($this->vCodProfileLogged));
                $this->vView->vProfileNameLetters = substr($this->vProfileData->getNames($this->vCodProfileLogged), 0, 1).substr($this->vProfileData->getLastNames($this->vCodProfileLogged), 0, 1);
                $this->vView->vProfileEmailLogged = $this->vUsersData->getUserEmail($this->vCodUserLogged);
                $this->vView->vProfileEmailValidation = $this->vUsersData->getAccountStatusUserCode($this->vCodUserLogged);
                $this->vView->vUserRoleList = $this->vUsersData->getUserRole($this->vCodUserLogged);
                /********************************/
                /* END AUTHENTICATE USER ACTIVE */
                /********************************/         
            
                $this->vView->vControllerActive = 'dashboard';
                $this->vView->vSubNavContent = '';
            
			}
			
		public function index(){
    
                $this->vView->DataIbnorcaCourses = $this->vAPIIbnorcaData->getIbnorcaCourses();
                $this->vView->DataIbnorcaActiveCommiteesBySector = $this->vAPIIbnorcaData->getIbnorcaActiveCommiteesBySector();
                $this->vView->DataIbnorcaActiveCommitees = $this->vAPIIbnorcaData->getIbnorcaActiveCommitees();
                $this->vView->DataIbnorcaStandardization = $this->vAPIIbnorcaData->getIbnorcaStandardization();
                $this->vView->DataIbnorcaMembersList = $this->vAPIIbnorcaData->getIbnorcaMembersList();
                $this->vView->DataIbnorcaMallaCurricular = $this->vAPIIbnorcaData->getIbnorcaMallaCurricular();
                $this->vView->DataIbnorcaCatalogoDeNormas = $this->vAPIIbnorcaData->getIbnorcaCatalogoDeNormas();
                $this->vView->DataIbnorcaPublicStandards = $this->vAPIIbnorcaData->getIbnorcaPublicStandards();
                $this->vView->DataIbnorcaStandardsInDevelopment = $this->vAPIIbnorcaData->getIbnorcaStandardsInDevelopmentList();
                $this->vView->DataIbnorcaSystemicReview = $this->vAPIIbnorcaData->getIbnorcaSystemicReview();
                

                $this->vView->DataLastSession = $this->vCtrl->getLastSession($this->vCodProfileLogged,$this->vCodUserLogged);
                $this->vView->vMethodActive = 'index';
                $this->vView->visualize('index');
			}     
	}
?>