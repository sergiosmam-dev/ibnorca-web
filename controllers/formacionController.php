<?Php

class formacionController extends IdEnController
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
        /********************************/
        /* END AUTHENTICATE USER ACTIVE */
        /********************************/

        $this->vView->vSubNavContent = '';        

    }

    public function index()
    {
        $this->vView->DataCoursesAreaList = $this->vAPIIbnorcaData->getIbnorcaCoursesArea();
        
        $this->vView->DataCoursesList = $this->vAPIIbnorcaData->getIbnorcaCourses();
        $this->vView->DataMallaAreaList = $this->vAPIIbnorcaData->getIbnorcaMallaArea();
        $this->vView->visualize('index');
    }

    public function vigentes()
    {
        $this->vView->DataCoursesList = $this->vAPIIbnorcaData->getIbnorcaCourses();
        $this->vView->DataMallaAreaList = $this->vAPIIbnorcaData->getIbnorcaMallaArea();
        $this->vView->visualize('vigentes');
    }    

    public function buscador()
    {
        $this->vView->DataCoursesGroupList = $this->vAPIIbnorcaData->getIbnorcaCoursesGroup();
        $this->vView->DataCoursesList = $this->vAPIIbnorcaData->getIbnorcaCourses();
        $this->vView->visualize('buscador');
    }    

    public function area($vIdArea, $vArea)
    {
        $vIdArea = (int) $vIdArea;
        $vArea = (string) $vArea;

        //$this->vView->DataMallaGroupList = $this->vAPIIbnorcaData->getIbnorcaMallaGroup(strtr($vArea, "-", " "));
        //$this->vView->DataMallaPorAreaList = $this->vAPIIbnorcaData->getIbnorcaMallaPorArea(strtr($vArea, "-", " "));
        $this->vView->DataCoursesPorAreaList = $this->vAPIIbnorcaData->getIbnorcaCourseArea($vIdArea);


        $this->vView->Area = strtr(strtoupper($vArea), "-", " ");
        $this->vView->visualize('area');
    }

    public function tipo($vSorterGroup)
    {        
        $vSorterGroup = (int) $vSorterGroup;
        $vTipo = (string) $this->vAPIIbnorcaData->getIbnorcaSorterGroupName($vSorterGroup);

        $vIdTipo = $this->vAPIIbnorcaData->getIbnorcaIdTipoFromSorterGroup($vSorterGroup);        

        $this->vView->DataWebCourses = $this->vFrontEndData->getDataWebCourses($vIdTipo);
        $this->vView->DataIbnorcaCourseTipo = $this->vAPIIbnorcaData->getIbnorcaCourseTipo($vSorterGroup);

        $this->vView->DataCoursesNameSorter = $this->vFrontEndData->getDataCoursesTypeNameSorter($vIdTipo);
        $this->vView->DataIbnorcaSorterCourses = $this->vAPIIbnorcaData->getIbnorcaSorterCoursesItem($vIdTipo);

        $vCodPage = 17;
        $this->vView->DataRegistrationProcess = $this->vFrontEndData->getDataRegistrationProcess($vCodPage);
        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);
        $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);

        $this->vView->Tipo = $vTipo;
        $this->vView->vSorterGroup = $vSorterGroup;
        $this->vView->seoTitlePage = $vTipo.' - Servicios';
        $this->vView->visualize('tipo');
    }     

    public function curso($vType = '', $vIdUnico, $vTextWebCourse = '')
    {
        $vType = (string) $vType;
        $vIdUnico = (string) $vIdUnico;

        $vTextWebCourse = (string) $vTextWebCourse;

        $this->vView->DataSorterGroup = $this->vFrontEndData->getDataSorterGroup($this->vAPIIbnorcaData->getIbnorcaCourseIdTipo($vIdUnico));

        if($vType == 'prg'){
            $this->vView->DataCoursesList = $this->vAPIIbnorcaData->getIbnorcaCourses();
            $this->vView->DataCourse = $this->vAPIIbnorcaData->getIbnorcaCourseIdUnico($vIdUnico);
    
            $this->vView->vIdTipo = $this->vAPIIbnorcaData->getIbnorcaCourseIdTipo($vIdUnico);
    
            $this->vView->DataMalla = $this->vAPIIbnorcaData->getIbnorcaMallaIdMalla($vIdUnico);
            $this->vView->DataCoursesAreaList = $this->vAPIIbnorcaData->getIbnorcaCoursesArea();
            $this->vView->DataIbnorcaCoursesLevelGroupList = $this->vAPIIbnorcaData->getIbnorcaCoursesLevelGroup($vIdUnico);
            $this->vView->DataModulesXCoursesList = $this->vAPIIbnorcaData->getModulesXCourses($vIdUnico);
            $this->vView->DataCoursesModulosList = $this->vAPIIbnorcaData->getIbnorcaCoursesModulos($vIdUnico);
    
            $this->vView->vDataLandingImgPrincipal = $this->vAPIIbnorcaData->getIbnorcaLandingImage($vIdUnico, 1);//PRINCIPAL
            $this->vView->vDataLandingImgSecundaria = $this->vAPIIbnorcaData->getIbnorcaLandingImage($vIdUnico, 2);//Secundaria
            $this->vView->vDataLandingImgBanner = $this->vAPIIbnorcaData->getIbnorcaLandingImage($vIdUnico, 3);//Banner
            
            $this->vView->DataUpcomingCoursesList = $this->vAPIIbnorcaData->getIbnorcaUpcomingCourses();
            $this->vView->DataIbnorcaCoursesBySectorList = $this->vAPIIbnorcaData->getIbnorcaCoursesBySector();
            $this->vView->visualize('curso');
        } else if($vType == 'web'){
            $this->vView->DataWebCourses = $this->vFrontEndData->getDataWebCourseItem($vIdUnico);

            $this->vView->DataCoursesAreaList = $this->vAPIIbnorcaData->getIbnorcaCoursesArea();
            $this->vView->DataUpcomingCoursesList = $this->vAPIIbnorcaData->getIbnorcaUpcomingCourses();
            $this->vView->DataIbnorcaCoursesBySectorList = $this->vAPIIbnorcaData->getIbnorcaCoursesBySector();
            $this->vView->visualize('cursoweb');
        }

        
    }
    
    public function seleccionar($vTipo)
    {
        $vTipo = (string) $vTipo;

        if($vTipo == 'diplomados'){
            $vCodTipo = '1717';
            $vTipoText = 'Diplomados';
            $this->vView->DataIbnorcaCoursesByTipoList = $this->vAPIIbnorcaData->getIbnorcaCoursesByTipo($vCodTipo);
        } else if($vTipo == 'programasdeformacion'){
            $vCodTipo = '1717';
            $vTipoText = 'Programas de Formación';
            $this->vView->DataIbnorcaCoursesByTipoList = $this->vAPIIbnorcaData->getIbnorcaCoursesByTipo($vCodTipo);
        } else if($vTipo == 'cursoscortos'){
            $vCodTipo = '115';
            $vTipoText = 'Cursos Cortos';
            $this->vView->DataIbnorcaCoursesByTipoList = $this->vAPIIbnorcaData->getIbnorcaCoursesByTipo($vCodTipo);
        } else if($vTipo == 'certificacioninternacional'){
            $vCodTipo = '';
            $vTipoText = 'Certificación Internacional';
            $this->vView->DataIbnorcaCoursesByTipoList = $this->vAPIIbnorcaData->getIbnorcaCoursesByTipo($vCodTipo);
        } else if($vTipo == 'vigentes'){
            $vCodTipo = '';
            $vTipoText = 'Planificación Mensual';
            $this->vView->DataIbnorcaCoursesByTipoList = $this->vAPIIbnorcaData->getIbnorcaCourses();
        }

        $this->vView->vTipo = $vTipoText;
        
        $this->vView->visualize('seleccionar');
    }    
}