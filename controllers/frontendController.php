<?Php

class frontendController extends IdEnController
{
    public function __construct()
    {

        parent::__construct();
        parent::__construct();

        /* BEGIN VALIDATION TIME SESSION USER */
        if (!IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE)) {
            $this->redirect('auth');
        } else {
            IdEnSession::timeSession();
        }
        /* END VALIDATION TIME SESSION USER */
        $this->vCtrl = $this->LoadModel('ctrl');
        $this->vMenuData = $this->LoadModel('menu');
        $this->vAccessData = $this->LoadModel('access');
        $this->vUsersData = $this->LoadModel('users');
        $this->vProfileData = $this->LoadModel('profile');
        $this->vPrivilegeData = $this->LoadModel('privilege');
        $this->vModuleData = $this->LoadModel('module');
        $this->vAPIIbnorcaData = $this->LoadModel('apiibnorca');
        $this->vFrontEndData = $this->LoadModel('frontend');

        /**********************************/
        /* BEGIN AUTHENTICATE USER ACTIVE */
        /**********************************/
        $this->vCodProfileLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode');
        $this->vCodUserLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode');
        //$this->vView->vProfileImageNameLogged = 'directory_' . $this->vCodProfileLogged . '/' . $this->vProfileData->getProfileImage($this->vCodProfileLogged);
        $this->vView->vProfileNameLogged = ucwords($this->vProfileData->getNames($this->vCodProfileLogged) . ' ' . $this->vProfileData->getLastNames($this->vCodProfileLogged));
        $this->vView->vProfileNameLetters = substr($this->vProfileData->getNames($this->vCodProfileLogged), 0, 1) . substr($this->vProfileData->getLastNames($this->vCodProfileLogged), 0, 1);
        $this->vView->vProfileEmailLogged = $this->vUsersData->getUserEmail($this->vCodUserLogged);
        $this->vView->vProfileEmailValidation = $this->vUsersData->getAccountStatusUserCode($this->vCodUserLogged);
        /********************************/
        /* END AUTHENTICATE USER ACTIVE */
        /********************************/

        $this->vView->vControllerActive = 'system';
        $this->vView->vSubNavContent = '';

    }

    public function index(){
        $this->vView->visualize('index');
    }
    public function groups(){
        $this->vView->visualize('groups');
    } 

    public function titles($vAction = null, $vCode = 0){

        $this->vView->DataPages = $this->vFrontEndData->getDataPages();
        
        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataIndexItem = $this->vFrontEndData->getDataTitlesItem($vCode);
            $this->vView->visualize('titles');
        } else {
            $this->vView->visualize('titles');
        }        
    }     
    public function images($vAction = null, $vCode = 0){
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataImageItem = $this->vFrontEndData->getDataImageItem($vCode);
            $this->vView->visualize('images');
        } else {
            $this->vView->visualize('images');
        }
    }

    public function sectors($vAction = null, $vCode = 0)
    {
        $this->vView->DataSectorsIbnorca = $this->vAPIIbnorcaData->getIbnorcaSectors();

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataSectorItem = $this->vFrontEndData->getDataSectorItem($vCode);
            $this->vView->visualize('sectors');
        } else {
            $this->vView->visualize('sectors');
        }
    }

    public function sectorRelationship($vCodSector){
        $vCodSector = (int) $vCodSector;
        $this->vView->DataWebSectors = $this->vFrontEndData->getSectors();
        $this->vView->DataSectorItem = $this->vFrontEndData->getSectorItem($vCodSector);
        $this->vView->DataGroupActiveComiteSectors = $this->vFrontEndData->getGroupActiveComiteSectors();
        $this->vView->DataIbnorcaServices = $this->vFrontEndData->getDataIbnorcaServices();
        $this->vView->DataIbnorcaCourses = $this->vFrontEndData->getDataIbnorcaCourses();

        $this->vView->DataSectorRelationship = $this->vFrontEndData->getDataSectorRelationship();

        /*
        $this->vView->DataIbnorcaNormas = $this->vFrontEndData->getDataIbnorcaNormas();
        $this->vView->DataIndexServicesList = $this->vFrontEndData->getDataIndexServicesList();
        */

        $this->vView->visualize('sectorRelationship');
    }
    
    public function menuWeb(){
        $this->vView->vFrontEndMenuLevelAndParent = $this->vFrontEndData->getFrontEndMenuLevelAndParent();
        $this->vView->visualize('menuWeb');
    }        
        
    public function inspection(){
        $this->vView->visualize('inspection');
    }
    public function inspectionContent($vCodInspection){
        $vCodInspection = (int) $vCodInspection;
        $this->vView->DataIbnorcaInspection = $this->vAPIIbnorcaData->getIbnorcaInspectionService($vCodInspection);
        $this->vView->visualize('inspectionContent');
    }

    public function addImageSector($vCode)
    {
        $vCode = (int) $vCode;
        
        $this->vView->vCode = $vCode;
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();
        $this->vView->visualize('addImageSector');
    }

    public function addImageSector2($vCode)
    {
        $vCode = (int) $vCode;
        
        $this->vView->vCode = $vCode;
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();
        $this->vView->visualize('addImageSector2');
    }

    public function addBannerSector($vCode)
    {
        $vCode = (int) $vCode;
        
        $this->vView->vCode = $vCode;
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();
        $this->vView->visualize('addBannerSector');
    }    
    
    public function anuncios($vAction = null, $vCode = 0)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataNewsItem = $this->vFrontEndData->getDataNewsItem($vCode);
            $this->vView->visualize('anuncios');
        } else {
            $this->vView->visualize('anuncios');
        }
    }
}