<?Php

class normalizacionController extends IdEnController
{
    public function __construct()
    {

        parent::__construct();

        //$this->vView->vSessionLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE);

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

    }

    public function index()
    {
        $this->vView->DataStandardizationList = $this->vAPIIbnorcaData->getIbnorcaStandardization();
        $this->vView->visualize('index');
    }

    public function sector($vCodSector, $vSector)
    {
        $vCodSector = (int) $vCodSector;
        $vSector = (string) $vSector;
        $this->vIdSector = $this->vFrontEndData->getIdSector($vCodSector);
        $this->vView->DataSector = $this->vFrontEndData->getSector($vCodSector);
        $this->vView->DataSectorRelationshipGroupServices = $this->vFrontEndData->getDataSectorRelationshipGroup(1,$vCodSector);
        $this->vView->DataSectorRelationshipGroupNormas = $this->vFrontEndData->getDataSectorRelationshipGroup(2,$vCodSector);
        $this->vView->DataSectorRelationshipGroupCourses = $this->vFrontEndData->getDataSectorRelationshipGroup(3,$vCodSector);

        $this->vView->DataActiveCommiteesList = $this->vAPIIbnorcaData->getSectorActiveCommitees($this->vIdSector);

        $this->vView->visualize('sector');

    }
    
    public function sector2($vCodSector, $vSector)
    {
        $vCodSector = (int) $vCodSector;
        $vSector = (string) $vSector;
        $this->vIdSector = $this->vFrontEndData->getIdSector($vCodSector);
        $this->vView->DataSector = $this->vFrontEndData->getSector($vCodSector);
        $this->vView->DataSectorRelationshipGroupServices = $this->vFrontEndData->getDataSectorRelationshipGroup(1,$vCodSector);
        $this->vView->DataSectorRelationshipGroupNormas = $this->vFrontEndData->getDataSectorRelationshipGroup(2,$vCodSector);
        $this->vView->DataSectorRelationshipGroupCourses = $this->vFrontEndData->getDataSectorRelationshipGroup(3,$vCodSector);

        $this->vView->DataActiveCommiteesList = $this->vAPIIbnorcaData->getSectorActiveCommitees($this->vIdSector);

        $this->vView->visualize('sector2');

    }    

    public function normalizacion()
    {
        $vPage = 'normalizacion';
        $vCodPage = 9;
        $this->vView->seoTitlePage = 'Normas Técnicas - Normalización';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);
        $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);

        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);  
        $this->vView->visualize('normalizacion');
    }
    public function servicios()
    {
        $this->vView->visualize('serviciosnormalizacion');
    }    
    public function desarrolloDeNormas()
    {
        $vPage = 'desarrolloDeNormas';
        $vCodPage = 10;
        $this->vView->seoTitlePage = 'Desarrollo de Normas Técnicas - Normalización';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);
        $this->vView->DataDetalle = $this->vFrontEndData->getDataDetalle($vCodPage);

        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);  
        $this->vView->visualize('desarrolloDeNormas');
    }

    public function comitesDeNormalizacion()
    {
        $vPage = 'comitesDeNormalizacion';
        $vCodPage = 11;
        $this->vView->seoTitlePage = 'Comités Técnicos de Normalización - Normalización';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);

        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);          
        $this->vView->DataActiveCommiteesList = $this->vAPIIbnorcaData->getIbnorcaActiveCommitees();
        //$this->vView->DataActiveCommiteesBySectorList = $this->vAPIIbnorcaData->getIbnorcaActiveCommiteesBySector();     
        $this->vView->visualize('comitesDeNormalizacion');
    }         
    public function revisionSistematica()
    {
        $vPage = 'revisionSistematica';
        $vCodPage = 12;
        $this->vView->seoTitlePage = 'Revisión Sistemática - Normalización';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);

        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);          

        $this->vView->DataGroupSectorRevisionSistemica = $this->vAPIIbnorcaData->getGroupSectorRevisionSistemica();
        $this->vView->DataRevisionSistemicaList = $this->vAPIIbnorcaData->getRevisionSistemica();
        $this->vView->visualize('revisionSistematica');
    }
    public function consultaPublica()
    {
        $vPage = 'consultaPublica';
        $vCodPage = 13;
        $this->vView->seoTitlePage = 'Normas en Consulta Pública - Normalización';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);

        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);          

        $this->vView->DataGroupSectorStandardsPublic = $this->vAPIIbnorcaData->getGroupSectorStandardsPublic();
        $this->vView->DataStandardsPublicList = $this->vAPIIbnorcaData->getIbnorcaStandardsPublic();
        $this->vView->visualize('consultaPublica');
    }
    public function fortalecimientoPoliticasPublicas()
    {
        $vPage = 'fortalecimientoPoliticasPublicas';
        $vCodPage = 14;
        $this->vView->seoTitlePage = 'Fortalecimiento de Políticas Públicas - Normalización';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);

        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);   

        $this->vView->visualize('fortalecimientoPoliticasPublicas');
    }        
    public function laAcademiayLasNormas()
    {
        $vPage = 'laAcademiayLasNormas';
        $vCodPage = 15;
        $this->vView->seoTitlePage = 'La Academia y las Normas - Normalización';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);

        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);  

        $this->vView->visualize('laAcademiayLasNormas');
    }
    public function especificacionesTecnicas()
    {
        $vPage = 'especificacionesTecnicas';
        $vCodPage = 16;
        $this->vView->seoTitlePage = 'Especificaciones Técnicas a Medida ETM - Normalización';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);
        $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);

        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);  

        $this->vView->visualize('especificacionesTecnicas');
    }

    public function ibnoteca()
        {
        $vPage = 'ibnoteca';
        $vCodPage = 28;
        $this->vView->seoTitlePage = 'IBNOTECA - Normalización';
        $this->vView->DataPageKeywords = $this->vFrontEndData->getDataPageKeywords($vCodPage);
        $this->vView->DataPageDescriptionSEO = $this->vFrontEndData->getDataPageDescriptionSEO($vCodPage);

        $this->vView->DataTitlesPage = $this->vFrontEndData->getDataTitlesPage($vCodPage);
        $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);

        $this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);  

        $this->vView->visualize('ibnoteca');
    }        
    




















    public function sectores()
    {
        $this->vView->DataActiveCommiteesList = $this->vAPIIbnorcaData->getIbnorcaActiveCommitees();
        $this->vView->DataActiveCommiteesBySectorList = $this->vAPIIbnorcaData->getIbnorcaActiveCommiteesBySector();
        $this->vView->visualize('sectores');
    }    
    
    public function comitesActivos($vSectorComiteActivo = '')
    {
        //strtolower(strtr(strtr(strtr($this->eliminar_acentos($rowActiveCommiteesBySectorList['Sector']), "/", "-"), ":", "-"), " ", "-"))
        $vSectorComiteActivo = (string) $vSectorComiteActivo;
        $vSectorComiteActivo = strtoupper(strtr($vSectorComiteActivo, "-", " "));

        if($this->vAPIIbnorcaData->getIbnorcaActiveCommiteesBySectorExists($vSectorComiteActivo) >= 1){
            $this->vView->DataSectorComiteActivo = $vSectorComiteActivo;
            $this->vView->DataActiveCommitee = $this->vAPIIbnorcaData->getIbnorcaActiveCommiteeBySector($vSectorComiteActivo);
            $this->vView->visualize('comitesActivos');            
        } else {
            $this->redirect('normalizacion/sectores');
        }
    }
    
    public function comiteActivo($vCodIdComite, $vNombreComiteActivo = '', $vFilter = 'nb')
    {
        $vCodIdComite = (string) $vCodIdComite;
        $vStringNombreComiteActivo = (string) $vNombreComiteActivo;
        $vNombreComiteActivo = ucfirst(strtr($vStringNombreComiteActivo, "-", " "));

        $this->vView->DataNombreComiteActivo = $vNombreComiteActivo;
        $this->vView->DataActiveCommitee = $this->vAPIIbnorcaData->getIbnorcaActiveCommiteeByCod($vCodIdComite);
        
        $vNumComite = $this->vAPIIbnorcaData->getIbnorcaStandardizationNumeroComite($vCodIdComite);
        
        $this->vView->vCodIdComite = $vCodIdComite;
        $this->vView->vNombreComiteActivo = $vStringNombreComiteActivo;

        $this->vView->vComitePDFName = $this->vFrontEndData->getDataComitePDFItem($vCodIdComite);

        $this->vView->DataIbnorcaStandardsEQNB = $this->vAPIIbnorcaData->getEQNB($vNumComite);
        $this->vView->DataIbnorcaStandardsAPNB = $this->vAPIIbnorcaData->getAPNB($vNumComite);
        $this->vView->DataIbnorcaStandardsPNB = $this->vAPIIbnorcaData->getPNB($vNumComite);
        $this->vView->DataIbnorcaStandardsNB = $this->vAPIIbnorcaData->getNB($vNumComite);

        $this->vView->vNumComite = $vNumComite;

        $this->vView->visualize('comiteActivo');
    }    

    public function norma($vParam = '', $vCode = 0, $vTextNombreNorma = null)
    {
        $vParam = (string) $vParam;
        $vCode = (int) $vCode;
        $vTextNombreNorma = (string) $vTextNombreNorma;

        $vCodComiteActivo = $this->vAPIIbnorcaData->getIdComiteFromCodNorma($vCode);
        $this->vView->DataActiveCommitee = $this->vAPIIbnorcaData->getIbnorcaActiveCommiteeByCod($vCodComiteActivo);

        if($vParam == 'eqnb'){
            $this->vView->DataNormaList = $this->vAPIIbnorcaData->getNormaEQNB($vCode);
            $this->vView->visualize('normaeqnb');
        } else if($vParam == 'apnb'){
            $this->vView->DataNormaList = $this->vAPIIbnorcaData->getNormaAPNB($vCode);
            $this->vView->visualize('normaapnb');
        } else if($vParam == 'pnb'){
            $this->vView->DataNormaList = $this->vAPIIbnorcaData->getNormaPNB($vCode);
            $this->vView->visualize('normapnb');
        }     

        
    }

    public function reuniones()
    {
        $this->vView->visualize('reuniones');
    }

    public function ics($vCodICS)
    {
        $vCodICS = (string) $vCodICS;
        $vNumCodICS = str_replace ('ics','',$vCodICS);
        $this->vView->DataICS = $this->vAPIIbnorcaData->getDataICS($vNumCodICS);
        $this->vView->DataICSAsociados = $this->vAPIIbnorcaData->getDataICSAsociados($vNumCodICS);

        $this->vView->visualize('ics');
    }    
    
    public function beneficios()
    {
        $this->vView->visualize('beneficios');
    }
    public function planificacion()
    {
        $this->vView->visualize('planificacion');
    }

}