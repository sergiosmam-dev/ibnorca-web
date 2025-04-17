<?Php

class apiibnorcaController extends IdEnController
{
    public function __construct()
    {
				/* BEGIN VALIDATION TIME SESSION USER */
				if(!IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE)){
                    $this->redirect('auth');
                } else {
                    IdEnSession::timeSession();                    
                }
                /* END VALIDATION TIME SESSION USER */        

        parent::__construct();

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
        $this->vCodProfileLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode');
        $this->vCodUserLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode');
        //$this->vView->vProfileImageNameLogged = 'directory_' . $this->vCodProfileLogged . '/' . $this->vProfileData->getProfileImage($this->vCodProfileLogged);
        //$this->vView->vProfileNameLogged = ucwords($this->vProfileData->getNames($this->vCodProfileLogged) . ' ' . $this->vProfileData->getLastNames($this->vCodProfileLogged));
        //$this->vView->vProfileNameLetters = substr($this->vProfileData->getNames($this->vCodProfileLogged), 0, 1) . substr($this->vProfileData->getLastNames($this->vCodProfileLogged), 0, 1);
        //$this->vView->vProfileEmailLogged = $this->vUsersData->getUserEmail($this->vCodUserLogged);
        //$this->vView->vProfileEmailValidation = $this->vUsersData->getAccountStatusUserCode($this->vCodUserLogged);
        /********************************/
        /* END AUTHENTICATE USER ACTIVE */
        /********************************/
        $this->vView->vControllerActive = 'index';
        $this->vView->vSubNavContent = '';

    }

    public function index()
    {
        $this->vView->visualize('index');
    }
    public function courses()
    {
        $this->vView->DataCourses = $this->vAPIIbnorcaData->getIbnorcaCoursesList();
        $this->vView->visualize('courses');
    }
    public function standardsPublic()
    {
        $this->vView->visualize('standardsPublic');
    }
    public function standardsInDevelopment()
    {
        $this->vView->visualize('standardsInDevelopment');
    }
    public function activeCommittees()
    {
        //$this->vView->visualize('activeCommittees');
        $this->vView->visualize('activeCommitteesV2');
    }
    public function meetingsCommittee()
    {
        $this->vView->visualize('meetingsCommittee');
    }
    public function standardization()
    {
        $this->vView->visualize('standardization');
    }                        
}