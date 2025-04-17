<?Php

class backendinicioController extends IdEnController
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

    public function sectionServices($vAction = null, $vCode = 0)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();
        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataIndexItem = $this->vFrontEndData->getDataIndexSectionServicesItem($vCode);
            $this->vView->visualize('sectionServices');
        } else {
            $this->vView->visualize('sectionServices');
        }
    }
    public function addImageIndexSectionService($vCode)
    {
        $vCode = (int) $vCode;
        
        $this->vView->vCode = $vCode;
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();
        $this->vView->visualize('addImageIndexSectionService');
    }

    public function serviceAnchoring(){
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();
        $this->vView->DataIbnorcaServices = $this->vFrontEndData->getDataIbnorcaServices();
        $this->vView->DataIbnorcaNormas = $this->vFrontEndData->getDataIbnorcaNormas();
        $this->vView->DataIndexServicesList = $this->vFrontEndData->getDataIndexServicesList();
        $this->vView->DataIbnorcaCourses = $this->vFrontEndData->getDataIbnorcaCourses();
        $this->vView->visualize('serviceAnchoring');
    }

    public function serviceServicesAnchoring(){
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();
        $this->vView->DataIbnorcaServices = $this->vFrontEndData->getDataIbnorcaServices();
        $this->vView->DataIbnorcaNormas = $this->vFrontEndData->getDataIbnorcaNormas();
        $this->vView->DataIndexServicesList = $this->vFrontEndData->getDataIndexServicesList();
        $this->vView->DataIbnorcaCourses = $this->vFrontEndData->getDataIbnorcaCourses();
        $this->vView->visualize('serviceServicesAnchoring');
    }    

    public function addIndexServiceAnchoringImage($vCode)
    {
        $vCode = (int) $vCode;
        
        $this->vView->vCode = $vCode;
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();
        $this->vView->visualize('addIndexServiceAnchoringImage');
    }    
    public function addServiceServicesAnchoringImage($vCode)
    {
        $vCode = (int) $vCode;
        
        $this->vView->vCode = $vCode;
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();
        $this->vView->visualize('addServiceServicesAnchoringImage');
    }
}
?>