<?Php

class landingController extends IdEnController
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

        /**********************************/
        /* BEGIN AUTHENTICATE USER ACTIVE */
        /**********************************/
        //$this->vCodProfileLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode');
        //$this->vCodUserLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode');
        /********************************/
        /* END AUTHENTICATE USER ACTIVE */
        /********************************/

        $this->vView->vSubNavContent = '';

    }

    public function index()
    {
        $this->vView->visualize('index');
    }    

    public function curso($vIdUnico, $vTextWebCourse = '') 
    {
        $this->vView->seoTitlePage = 'Landing - IBNORCA';

        $vIdUnico = (int) $vIdUnico;
        $vTextWebCourse = (string) $vTextWebCourse;

        $this->vView->DataCourse = $this->vAPIIbnorcaData->getIbnorcaCourseIdUnico($vIdUnico);
        $this->vView->DataMalla = $this->vAPIIbnorcaData->getIbnorcaMallaIdMalla($vIdUnico);

        $this->vView->vDataLandingContent = $this->vAPIIbnorcaData->getIbnorcaLandingContent($vIdUnico);
        $this->vView->DataLandingBenefitsList = $this->vAPIIbnorcaData->getDataLandingBenefitsList($vIdUnico);
        $this->vView->DataLandingFaqsList = $this->vAPIIbnorcaData->getDataLandingFaqsList($vCode);
        $this->vView->getDataLandingWithOutDiscount = $this->vAPIIbnorcaData->getDataLandingDiscountsType($vIdUnico, 1);
        $this->vView->getDataLandingWithDiscount = $this->vAPIIbnorcaData->getDataLandingDiscountsType($vIdUnico, 2);

        $this->vView->vDataLandingImgPrincipal = $this->vAPIIbnorcaData->getIbnorcaLandingImage($vIdUnico, 1);//PRINCIPAL
        $this->vView->vDataLandingImgSecundaria = $this->vAPIIbnorcaData->getIbnorcaLandingImage($vIdUnico, 2);//Secundaria
        $this->vView->vDataLandingImgBanner = $this->vAPIIbnorcaData->getIbnorcaLandingImage($vIdUnico, 3);//Banner

        $this->vView->DataCoursePDF = $this->vAPIIbnorcaData->getIbnorcaCoursePDF($vIdUnico);
        
        $this->vView->visualize('curso');
    }
    public function landingCRM(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            //$vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');

            $vIdUnico = (int) $_POST['vIdUnico'];
            $name = (string) $_POST['name'];
            $lastnames = (string) $_POST['lastnames'];
            $mail = (string) $_POST['mail'];
            $whatsapp = (string) $_POST['whatsapp'];
            $country = (string) $_POST['country'];
            
            
            //$vInsert = $this->vFrontEndData->insertLandingContent($vCodUser, $vIdCurso, $vDescLanding, $vStatus, $vActive);
            echo BASE_VIEW_URL.'api/v1/crm/lead/'.$vIdUnico.'/'.$name.'/'.$lastnames.'/'.$mail.'/'.$whatsapp.'/'.$country;
            
        }             
    }
    public function lead($vIdUnico, $vTextWebCourse = '')
    {
        $vIdUnico = (int) $vIdUnico;
        $vTextWebCourse = (string) $vTextWebCourse;

        $this->vView->DataCourse = $this->vAPIIbnorcaData->getIbnorcaCourseIdUnico($vIdUnico);
        $this->vView->DataMalla = $this->vAPIIbnorcaData->getIbnorcaMallaIdMalla($vIdUnico);

        $this->vView->vDataLandingImgPrincipal = $this->vAPIIbnorcaData->getIbnorcaLandingImage($vIdUnico, 1);//PRINCIPAL
        $this->vView->vDataLandingImgSecundaria = $this->vAPIIbnorcaData->getIbnorcaLandingImage($vIdUnico, 2);//Secundaria
        $this->vView->vDataLandingImgBanner = $this->vAPIIbnorcaData->getIbnorcaLandingImage($vIdUnico, 3);//Banner
        
        $this->vView->vDataLandingContent = $this->vAPIIbnorcaData->getIbnorcaLandingContent($vIdUnico);
        
        $this->vView->visualize('lead');
    }    
}
?>