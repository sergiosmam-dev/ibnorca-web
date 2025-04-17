<?Php

class novedadesController extends IdEnController
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
        $this->vView->visualize('index');
    }

    public function noticias()
    {
        $vPage = 'noticias';
        $vCodPage = 24;
        $this->vView->seoTitlePage = 'Noticias - Novedades';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $vType = 1;
        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage); 
        $this->vView->DataNews = $this->vFrontEndData->getDataNews($vType); 

        $this->vView->visualize('noticias');
    }

    public function detalle($vCode)
    {
        $vCode = (int) $vCode;
        $this->vView->DataNewsItem = $this->vFrontEndData->getDataNewsItem($vCode);
        $this->vView->visualize('detalle');        
    }    
    
    public function articulos()
    {
        $vPage = 'articulos';
        $vCodPage = 25;
        $this->vView->seoTitlePage = 'Artículos - Novedades';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $vType = 2;
        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
        $this->vView->DataNews = $this->vFrontEndData->getDataNews($vType);

        $this->vView->visualize('articulos');
    }
    
    public function podcast()
    {

        $vPage = 'podcast';
        $vCodPage = 26;
        $this->vView->seoTitlePage = 'Podcast - Novedades';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
        $this->vView->DataYoutube = $this->vFrontEndData->getDataYoutube();

        $this->vView->visualize('podcast');
    }    
  
}
