<?Php

class solucionesController extends IdEnController
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
        $this->vView->DataWebSectors = $this->vFrontEndData->getSectors();
        $this->vView->visualize('index');
    }

    public function formacion()
    {
        $vPage = 'formacion';
        $vCodPage = 17;
        $this->vView->seoTitlePage = 'Formación - Servicios';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);

        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
        $this->vView->DataDetalle = $this->vFrontEndData->getDataDetalle($vCodPage);
        $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);

        $this->vView->DataRegistrationProcess = $this->vFrontEndData->getDataRegistrationProcess($vCodPage);

        $this->vView->DataTestimonials = $this->vFrontEndData->getDataTestimonials($vCodPage);

        $this->vView->DataIbnorcaSorterCourses = $this->vAPIIbnorcaData->getIbnorcaSorterCourses();
        
        $this->vView->DataCoursesList = $this->vAPIIbnorcaData->getIbnorcaCourses();
        $this->vView->DataMallaAreaList = $this->vAPIIbnorcaData->getIbnorcaMallaArea();
        $this->vView->visualize('formacion');
    }    

    public function oi($vService = '', $vCodService = 0)
    {
        $vService = (string) $vService; 
        $vCodService = (int) $vCodService;

        $vPage = 'oi';
        $vCodPage = 18;
        $this->vView->seoTitlePage = 'Organismo de Inspección - Servicios';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);

        $this->vView->DataRegistrationProcess = $this->vFrontEndData->getDataRegistrationProcess($vCodPage);

        if($vService == ''){
    
            $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
            $this->vView->DataDetalle = $this->vFrontEndData->getDataDetalle($vCodPage);
            $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);
            $this->vView->DataServicios = $this->vFrontEndData->getDataServicios($vCodPage);
            //$this->vView->DataServicios = $this->vFrontEndData->getDataAnclajeServicio($vCodPage);
            

            $this->vView->visualize('oi');  
        } else if($vService == 'servicio') {
            $this->vView->DataServicio = $this->vFrontEndData->getDataServicio($vCodService);
            $this->vView->DataBeneficiosDeServicios = $this->vFrontEndData->getDataBeneficiosDeServicios($vCodService);
            $this->vView->DataAnclajeServiciosPorServicio = $this->vFrontEndData->getDataAnclajeServiciosPorServicio($vCodService);
            $this->vView->visualize('serviciooi');
        }        
    }

    public function sistemadegestion($vService = '', $vCodService = '')
    {
        $vService = (string) $vService; 
        $vCode = (int) $vCode;

        $vPage = 'sistemadegestion';
        $vCodPage = 19;
        $this->vView->seoTitlePage = 'Certificación de Sistemas de Gestión - Servicios';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);

        if($vService == ''){

            $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
            $this->vView->DataDetalle = $this->vFrontEndData->getDataDetalle($vCodPage);
            $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);
            $this->vView->DataServicios = $this->vFrontEndData->getDataServicios($vCodPage);

            $this->vView->visualize('sistemadegestion');
        } else if($vService == 'servicio') {
            $vCodService = (int) $vCodService;
            $this->vView->DataServicio = $this->vFrontEndData->getDataServicio($vCodService);
            $this->vView->DataBeneficiosDeServicios = $this->vFrontEndData->getDataBeneficiosDeServicios($vCodService);
            $this->vView->DataAnclajeServiciosPorServicio = $this->vFrontEndData->getDataAnclajeServiciosPorServicio($vCodService);
            $this->vView->visualize('serviciosistemadegestion');
        }

    }

    public function servicios($vService = '', $vCodService = '')
    {
        $vPage = 'servicios';
        $vCodPage = 20;
        $this->vView->seoTitlePage = 'Certificación a Servicios - Servicios';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);

        if($vService == ''){

    
            $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
            $this->vView->DataDetalle = $this->vFrontEndData->getDataDetalle($vCodPage);
            $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);
            $this->vView->DataServicios = $this->vFrontEndData->getDataServicios($vCodPage);

            $this->vView->visualize('servicios');
        } else if($vService == 'servicio') {
            $vCodService = (int) $vCodService;
            $this->vView->DataServicio = $this->vFrontEndData->getDataServicio($vCodService);
            $this->vView->DataBeneficiosDeServicios = $this->vFrontEndData->getDataBeneficiosDeServicios($vCodService);
            $this->vView->DataAnclajeServiciosPorServicio = $this->vFrontEndData->getDataAnclajeServiciosPorServicio($vCodService);
            $this->vView->visualize('servicioservicios');
        }

    }

    public function procesos($vService = '', $vCodService = '')
    {
        $vPage = 'procesos';
        $vCodPage = 29;
        $this->vView->seoTitlePage = 'Certificación a Procesos - Servicios';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);

        if($vService == ''){

    
            $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
            $this->vView->DataDetalle = $this->vFrontEndData->getDataDetalle($vCodPage);
            $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);
            $this->vView->DataServicios = $this->vFrontEndData->getDataServicios($vCodPage);

            $this->vView->visualize('procesos');
        } else if($vService == 'servicio') {
            $vCodService = (int) $vCodService;
            $this->vView->DataServicio = $this->vFrontEndData->getDataServicio($vCodService);
            $this->vView->DataBeneficiosDeServicios = $this->vFrontEndData->getDataBeneficiosDeServicios($vCodService);
            $this->vView->DataAnclajeServiciosPorServicio = $this->vFrontEndData->getDataAnclajeServiciosPorServicio($vCodService);
            $this->vView->visualize('servicioprocesos');
        }

    }

    public function producto($vService = '', $vCodService = '')
    {
        $vPage = 'producto';
        $vCodPage = 30;
        $this->vView->seoTitlePage = 'Certificación a Producto - Servicios';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);

        if($vService == ''){

    
            $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
            $this->vView->DataDetalle = $this->vFrontEndData->getDataDetalle($vCodPage);
            $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);
            $this->vView->DataServicios = $this->vFrontEndData->getDataServicios($vCodPage);

            $this->vView->visualize('producto');
        } else if($vService == 'servicio') {
            $vCodService = (int) $vCodService;
            $this->vView->DataServicio = $this->vFrontEndData->getDataServicio($vCodService);
            $this->vView->DataBeneficiosDeServicios = $this->vFrontEndData->getDataBeneficiosDeServicios($vCodService);
            $this->vView->DataAnclajeServiciosPorServicio = $this->vFrontEndData->getDataAnclajeServiciosPorServicio($vCodService);
            $this->vView->visualize('servicioproducto');
        }

    }
    
    public function personas($vService = '', $vCodService = '')
    {

        $vPage = 'personas';
        $vCodPage = 21;
        $this->vView->seoTitlePage = 'Certificación de Personas - Servicios';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);
        
        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);
        $this->vView->DataRegistrationProcess = $this->vFrontEndData->getDataRegistrationProcess($vCodPage);        

        if($vService == ''){    

            $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
            $this->vView->DataDetalle = $this->vFrontEndData->getDataDetalle($vCodPage);
            $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);
            $this->vView->DataServicios = $this->vFrontEndData->getDataServicios($vCodPage);
            $this->vView->visualize('personas');
        } else if($vService == 'servicio') {
            $vCodService = (int) $vCodService;
            $this->vView->DataServicio = $this->vFrontEndData->getDataServicio($vCodService);
            $this->vView->DataBeneficiosDeServicios = $this->vFrontEndData->getDataBeneficiosDeServicios($vCodService);
            $this->vView->DataAnclajeServiciosPorServicio = $this->vFrontEndData->getDataAnclajeServiciosPorServicio($vCodService);
            $this->vView->visualize('serviciopersonas');
        }

    }
    
    public function verificacion($vService = '', $vCodService = '')
    {

        $vPage = 'verificacion';
        $vCodPage = 22;
        $this->vView->seoTitlePage = 'Verificación - Servicios';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);

        if($vService == ''){

            $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
            $this->vView->DataDetalle = $this->vFrontEndData->getDataDetalle($vCodPage);
            $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);
            $this->vView->DataServicios = $this->vFrontEndData->getDataServicios($vCodPage);

            $this->vView->visualize('verificacion');
        } else if($vService == 'servicio') {
            $vCodService = (int) $vCodService;
            $this->vView->DataServicio = $this->vFrontEndData->getDataServicio($vCodService);
            $this->vView->DataBeneficiosDeServicios = $this->vFrontEndData->getDataBeneficiosDeServicios($vCodService);
            $this->vView->DataAnclajeServiciosPorServicio = $this->vFrontEndData->getDataAnclajeServiciosPorServicio($vCodService);
            $this->vView->visualize('servicioverificacion');            
        }

    }
    
    public function ensayos($vService = '', $vCodService = '')
    {
        $vPage = 'ensayos';
        $vCodPage = 23;
        $this->vView->seoTitlePage = 'Ensayos - Servicios';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);
        
        if($vService == ''){

            $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
            $this->vView->DataDetalle = $this->vFrontEndData->getDataDetalle($vCodPage);
            $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);
            $this->vView->DataServicios = $this->vFrontEndData->getDataServicios($vCodPage);

            $this->vView->visualize('ensayos');
        } else if($vService == 'servicio') {
            $vCodService = (int) $vCodService;
            $this->vView->DataServicio = $this->vFrontEndData->getDataServicio($vCodService);
            $this->vView->DataBeneficiosDeServicios = $this->vFrontEndData->getDataBeneficiosDeServicios($vCodService);
            $this->vView->DataAnclajeServiciosPorServicio = $this->vFrontEndData->getDataAnclajeServiciosPorServicio($vCodService);
            $this->vView->visualize('servicioensayos');
        }

    }
    
    
}
