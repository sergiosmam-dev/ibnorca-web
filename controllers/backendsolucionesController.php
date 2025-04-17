<?Php

class backendsolucionesController extends IdEnController
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
  
    public function landing(){
        $this->vView->visualize('landing');
    }

    public function addInfo($vIdUnico, $vAction = null, $vCode = 0)
    {
        $vIdUnico = (string) $vIdUnico;

        $this->vView->DataCourse = $this->vAPIIbnorcaData->getIbnorcaCourseIdUnico($vIdUnico);
        $this->vView->DataMalla = $this->vAPIIbnorcaData->getIbnorcaMallaIdMalla($vIdUnico);

        $this->vView->DataLandingContent = $this->vAPIIbnorcaData->getDataLandingContent($vIdUnico);
        $this->vView->DataLandingInfo = $this->vAPIIbnorcaData->getDataLandingInfo($vIdUnico);
        $this->vView->DataLandingBenefitsList = $this->vAPIIbnorcaData->getDataLandingBenefitsList($vIdUnico);

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataLandingBenefitsItem = $this->vAPIIbnorcaData->getDataLandingBenefitsItem($vCode);
            $this->vView->visualize('addInfo');
        } else {
            $this->vView->visualize('addInfo');
        }        
        
    }

    public function addDiscounts($vIdUnico, $vAction = null, $vCode = 0)
    {
        $vIdUnico = (string) $vIdUnico;

        $this->vView->vCourseName = $this->vAPIIbnorcaData->getIbnorcaCourseName($vIdUnico);

        $this->vView->DataLandingDiscountsList = $this->vAPIIbnorcaData->getDataLandingDiscountsList($vIdUnico);
        $this->vView->vIdUnico = $vIdUnico;

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataLandingDiscountsItem = $this->vAPIIbnorcaData->getDataLandingDiscountsItem($vCode);
            $this->vView->visualize('addDiscounts');
        } else {
            $this->vView->visualize('addDiscounts');
        }        
        
    }

    public function landingfaqs($vAction = null, $vCode = 0)
    {
        $this->vView->DataLandingFaqsList = $this->vAPIIbnorcaData->getDataLandingFaqsList($vCode);

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataLandingFaqsItem = $this->vAPIIbnorcaData->getDataLandingFaqsItem($vCode);
            $this->vView->visualize('landingfaqs');
        } else {
            $this->vView->visualize('landingfaqs');
        }        
        
    }    
    public function addPDF($vIdUnico)
    {
        $vIdUnico = (string) $vIdUnico;

        $this->vView->DataCourse = $this->vAPIIbnorcaData->getIbnorcaCourseIdUnico($vIdUnico);
        $this->vView->DataMalla = $this->vAPIIbnorcaData->getIbnorcaMallaIdMalla($vIdUnico);
        $this->vView->DataCoursePDF = $this->vAPIIbnorcaData->getIbnorcaCoursePDF($vIdUnico);
        
        $this->vView->visualize('addPDF');
    }
    public function addImageCourse($vIdUnico)
    {
        $vIdUnico = (string) $vIdUnico;

        $this->vView->DataCourse = $this->vAPIIbnorcaData->getIbnorcaCourseIdUnico($vIdUnico);
        $this->vView->DataMalla = $this->vAPIIbnorcaData->getIbnorcaMallaIdMalla($vIdUnico);
        $this->vView->DataCourseImages = $this->vAPIIbnorcaData->getIbnorcaCourseImages($vIdUnico);
        
        $this->vView->visualize('addImageCourse');
    }

    public function sorter($vAction = null, $vCode = 0){

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataSorterItem = $this->vFrontEndData->getDataSorterItem($vCode);
            $this->vView->visualize('sorter');
        } else {
            $this->vView->visualize('sorter');
        }
    }
    
    public function webCourses($vAction = null, $vCode = 0){

        $this->vView->DataSorterList = $this->vFrontEndData->getDataSorterList();

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            //$this->vView->DataSorterItem = $this->vFrontEndData->getDataSorterItem($vCode);
            $this->vView->visualize('webCourses');
        } else {
            $this->vView->visualize('webCourses');
        }
    }    

    /****************************************************/
    
    public function oferta($vAction = null, $vCode = 0){
        
        $vPage = 'formacion';
        $vCodPage = 17;
        $vSection = 2;

        $this->vView->DataPages = $this->vFrontEndData->getDataPages();
        $this->vView->DataTitleSectionPage = $this->vFrontEndData->getDataTitleSectionPage($vSection, $vCodPage);

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataSorterItem = $this->vFrontEndData->getDataSorterItem($vCode);
            $this->vView->visualize('oferta');
        } else {
            $this->vView->visualize('oferta');
        }        

        /*$this->vView->DataCabecera = $this->vFrontEndData->getDataCabecera($vCodPage);
        $this->vView->DataDetalle = $this->vFrontEndData->getDataDetalle($vCodPage);
        $this->vView->DataBeneficios = $this->vFrontEndData->getDataBeneficios($vCodPage);

        $this->vView->DataIbnorcaSorterCourses = $this->vAPIIbnorcaData->getIbnorcaSorterCourses();
        
        $this->vView->DataCoursesList = $this->vAPIIbnorcaData->getIbnorcaCourses();
        $this->vView->DataMallaAreaList = $this->vAPIIbnorcaData->getIbnorcaMallaArea();
        $this->vView->visualize('oferta');*/
    }
    
    public function addSorterIco($vCode)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        $vCode = (int) $vCode;
        
        $this->vView->vCode = $vCode;
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();
        $this->vView->visualize('addSorterIco');
    }
    
    public function addSorterImage($vCode)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        $vCode = (int) $vCode;
        
        $this->vView->vCode = $vCode;
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();
        $this->vView->visualize('addSorterImage');
    }

    public function addWebCourseImage($vCode)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        $vCode = (int) $vCode;
        
        $this->vView->vCode = $vCode;
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();
        $this->vView->visualize('addWebCourseImage');
    } 
    public function addWebCourseImageSec($vCode)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        $vCode = (int) $vCode;
        
        $this->vView->vCode = $vCode;
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();
        $this->vView->visualize('addWebCourseImageSec');
    }           

    public function registrationProcess($vAction = null, $vCode = 0)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataRegistrationProcessItem = $this->vFrontEndData->getDataRegistrationProcessItem($vCode);
            $this->vView->DataPages = $this->vFrontEndData->getDataPages();
            $this->vView->visualize('registrationProcess');
        } else {
            $this->vView->visualize('registrationProcess');
        }
    }
    
    public function addRegistrationProcessImage($vCode)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        $vCode = (int) $vCode;
        
        $this->vView->vCode = $vCode;
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();
        $this->vView->visualize('addRegistrationProcessImage');
    }

    public function testimonials($vAction = null, $vCode = 0)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataTestimonialsItem = $this->vFrontEndData->getDataTestimonialsItem($vCode);
            $this->vView->DataPages = $this->vFrontEndData->getDataPages();
            $this->vView->visualize('testimonials');
        } else {
            $this->vView->visualize('testimonials');
        }
    }
    
    public function addTestimonialImage($vCode)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        $vCode = (int) $vCode;
        
        $this->vView->vCode = $vCode;
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();
        $this->vView->visualize('addTestimonialImage');
    }
    
    public function registrationProcessInspection($vAction = null, $vCode = 0)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataRegistrationProcessItem = $this->vFrontEndData->getDataRegistrationProcessItem($vCode);
            $this->vView->DataPages = $this->vFrontEndData->getDataPages();
            $this->vView->visualize('registrationProcessInspection');
        } else {
            $this->vView->visualize('registrationProcessInspection');
        }
    }    
}
?>