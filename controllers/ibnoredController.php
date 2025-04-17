<?Php

class ibnoredController extends IdEnController
{
    public function __construct()
    {

        parent::__construct();

        $this->vView->vSessionLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE);

        $this->vCtrl = $this->LoadModel('ctrl');
        $this->vMenuData = $this->LoadModel('menu');
        $this->vAccessData = $this->LoadModel('access');
        $this->vUsersData = $this->LoadModel('users');
        $this->vProfileData = $this->LoadModel('profile');      

        /**********************************/
        /* BEGIN AUTHENTICATE USER ACTIVE */
        /**********************************/
        $this->vCodProfileLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode');
        $this->vCodUserLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode');
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
}
?>