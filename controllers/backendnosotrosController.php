<?Php

class backendnosotrosController extends IdEnController
{
    public function __construct()
    {

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
        $this->vFrontEndData = $this->LoadModel('frontend');

        /**********************************/
        /* BEGIN AUTHENTICATE USER ACTIVE */
        /**********************************/
        $this->vCodProfileLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode');
        $this->vCodUserLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode');
        /********************************/
        /* END AUTHENTICATE USER ACTIVE */
        /********************************/

        $this->vView->vSubNavContent = '';

    }

    public function index()
    {
        $this->vView->visualize('index');
    }

    public function trayectoria()
    {
        $vPage = 'nosotros';
        $vCodPage = 2;

        $this->vView->DataPages = $this->vFrontEndData->getDataPages();
        //$this->vView->DataIndexList = $this->vFrontEndData->getDataIndexList();
        $this->vView->DataIndexList = $this->vFrontEndData->getDataIndexItemPage($vCodPage);

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataIndexItem = $this->vFrontEndData->getDataIndexItem($vCode);
            $this->vView->visualize('trayectoria');
        } else {
            $this->vView->visualize('trayectoria');
        }
    }    

    public function partners($vAction = null, $vCode = 0)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();
        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataPartnersItem = $this->vFrontEndData->getDataPartnersItem($vCode);
            $this->vView->visualize('partners');
        } else {
            $this->vView->visualize('partners');
        }
    }
    public function addPartnersImage($vCode)
    {
        $vCode = (int) $vCode;
        
        $this->vView->vCode = $vCode;
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();
        $this->vView->visualize('addPartnersImage');
    }       

}
?>