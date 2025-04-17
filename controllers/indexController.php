<?Php

class indexController extends IdEnController
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
        $this->vAPIIbnorcaData = $this->LoadModel('apiibnorca');
        $this->vFrontEndData = $this->LoadModel('frontend');

        /**********************************/
        /* BEGIN AUTHENTICATE USER ACTIVE */
        /**********************************/
        $this->vCodProfileLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode');
        $this->vCodUserLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode');
        $this->vProfileCompleteName = ucwords($this->vProfileData->getNames($this->vCodProfileLogged).' '.$this->vProfileData->getLastNames($this->vCodProfileLogged));
        /********************************/
        /* END AUTHENTICATE USER ACTIVE */
        /********************************/
        $this->vView->vControllerActive = 'index';
        $this->vView->vSubNavContent = '';

    }

    public function index()
    {
        $vPage = 'index';
        $vCodPage = 1;
        $this->vView->seoTitlePage = 'Home - IBNORCA Instituto Boliviano de Normalización y Calidad';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);
        
        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);

        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
        $this->vView->DataIndexSectionServices = $this->vFrontEndData->getDataIndexSectionServices($vCodPage);

        $this->vView->DataAnclajeServicio = $this->vFrontEndData->getDataAnclajeServicio($vCodPage);

        $this->vView->DataWebSectors = $this->vFrontEndData->getSectors();
        $this->vView->visualize('index');
    }

    public function index2()
    {
        $vPage = 'index';
        $vCodPage = 1;
        $this->vView->seoTitlePage = 'Home - IBNORCA Instituto Boliviano de Normalización y Calidad';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);
        
        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);

        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
        $this->vView->DataIndexSectionServices = $this->vFrontEndData->getDataIndexSectionServices($vCodPage);

        $this->vView->DataAnclajeServicio = $this->vFrontEndData->getDataAnclajeServicio($vCodPage);

        $this->vView->DataWebSectors = $this->vFrontEndData->getSectors();
        $this->vView->visualize('index2');
    }    

    public function evaluaciondelaconformidad()
    {
        $this->vView->visualize('evaluaciondelaconformidad');
    }    
}
