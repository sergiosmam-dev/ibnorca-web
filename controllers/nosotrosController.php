<?Php

class nosotrosController extends IdEnController
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
        $vPage = 'nosotros';
        $vCodPage = 2;
        $this->vView->seoTitlePage = 'Nuestra Trayectoria - Nosotros';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);

        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
        $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);
        $this->vView->visualize('index');
    }

    public function proyectosinternacionales($vProject = null, $vCodProject = null)
    {
        $vProject = (string) $vProject;
        $vCodProject = (int) $vCodProject;
        $vPage = 'proyectosinternacionales';
        $vCodPage = 3;
        $this->vView->seoTitlePage = 'Proyectos Internacionales - Nosotros';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        if($vProject == 'medioambiente'){
            if($vCodProject == 1){
                $this->vView->visualize('proyecto1');
            } else if($vCodProject == 2){
                $this->vView->visualize('proyecto2');
            } else if($vCodProject == 3){
                $this->vView->visualize('proyecto3');
            } else if($vCodProject == 4){
                $this->vView->visualize('proyecto4');
            } else {
                $this->vView->visualize('medioambiente');
            }
        } else if($vProject == 'desarrolloeconomico'){
            if($vCodProject == 5){
                $this->vView->visualize('proyecto5');
            } else if($vCodProject == 6){
                $this->vView->visualize('proyecto6');
            } else {
                $this->vView->visualize('desarrolloeconomico');
            }            
        } else if($vProject == 'innovacion'){
            if($vCodProject == 7){
                $this->vView->visualize('proyecto7');
            } else if($vCodProject == 8){
                $this->vView->visualize('proyecto8');
            } else {
                $this->vView->visualize('innovacion');
            }            
        } else {
            $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);
            $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
            $this->vView->visualize('proyectosinternacionales');            
        }
    }

    public function afiliaciones()
    {
        $vPage = 'afiliaciones';
        $vCodPage = 4;
        $this->vView->seoTitlePage = 'Afiliaciones - Nosotros';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);
        $this->vView->DataDetalle = $this->vFrontEndData->getDataDetalle($vCodPage);
        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
        $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);
        $this->vView->visualize('afiliaciones');
    }    
    
    public function acreditaciones()
    {
        $vPage = 'acreditaciones';
        $vCodPage = 5;
        $this->vView->seoTitlePage = 'Acreditaciones - Nosotros';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);

        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
        $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);
        $this->vView->visualize('acreditaciones');
    }
    
    public function trabajaconnosotros()
    {
        $vPage = 'trabajaconnosotros';
        $vCodPage = 6;
        $this->vView->seoTitlePage = 'Trabaja con Nosotros - Nosotros';
        $this->vView->DataPageKeywords = null; //$this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = null; //$this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);

        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
        $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);
        $this->vView->visualize('trabajaconnosotros');
    }
    
    public function contacto()
    {
        $vPage = 'contacto';
        $vCodPage = 7;
        $this->vView->seoTitlePage = 'Contacto - Nosotros';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);

        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
        $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);
        
        $this->vView->visualize('contacto');
    } 
    
    public function quejas()
    {
        $vPage = 'quejas';
        $vCodPage = 8;
        $this->vView->seoTitlePage = 'Quejas y Apelaciones - Nosotros';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);

        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
        $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);
        $this->vView->visualize('quejas');
    }     
}
