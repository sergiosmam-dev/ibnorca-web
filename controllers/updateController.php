<?Php

class updateController extends IdEnController
{
    public function __construct()
    {

        parent::__construct();

        /**************************************/
        /* BEGIN VALIDATION TIME SESSION USER */
        /**************************************/

        if (!IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE)) {
            $this->redirect('auth');
        } else {
            IdEnSession::timeSession();
        }
        /* END VALIDATION TIME SESSION USER */

        $this->vMenuData = $this->LoadModel('menu');
        $this->vAccessData = $this->LoadModel('access');
        $this->vUsersData = $this->LoadModel('users');
        $this->vProfileData = $this->LoadModel('profile');
        $this->vAPIIbnorcaData = $this->LoadModel('apiibnorca');
        $this->vFrontEndData = $this->LoadModel('frontend');

        /**********************************/
        /* END AUTHENTICATE USER ACTIVE */
        /**********************************/
        $this->vView->vSubNavContent = '';
    }

    public function index()
    {
        $this->vView->visualize('index');
    }
    
    public function updateDataAPIIbnorca()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vCodSupplier = (int) $_POST['vCodSupplier'];
            $vCodTypeSupplier = (int) $_POST['vCodTypeSupplier'];
            $vBusinessName = (string) $_POST['vBusinessName'];
            $vNameSupplier = (string) $_POST['vNameSupplier'];
            $vNITSupplier = (string) $_POST['vNITSupplier'];
            $vBankAccountSupplier = (string) $_POST['vBankAccountSupplier'];
            $vNameAccountSupplier = (string) $_POST['vNameAccountSupplier'];
            $vTypeAccountSupplier = (string) $_POST['vTypeAccountSupplier'];
            $vAccountSupplier = (string) $_POST['vAccountSupplier'];

            $vStatus = 1;
            $vActive = 1;

            $vCodSupplier = $this->vWarehousesData->updateSupplier($vCodSupplier,$vCodTypeSupplier,$vBusinessName,$vNameSupplier,$vNITSupplier,$vBankAccountSupplier,$vNameAccountSupplier,$vTypeAccountSupplier,$vAccountSupplier,$vStatus,$vActive);
            echo 'success';
        }
    }
    public function profileInfo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vCodProfile = (int) $_POST['vCodProfile'];
            $vName = (string) $_POST['vName'];
            $vLastName = (string) $_POST['vLastName'];
            $vDesc = (string) $_POST['vDesc'];
            $vAddress = (string) $_POST['vAddress'];
            $vWhatsApp = (string) $_POST['vWhatsApp'];

            $vCodSupplier = $this->vProfileData->updateProfile($vCodProfile,$vName,$vLastName,$vDesc,$vAddress,$vWhatsApp);
            echo 'success';
        }
    }

    public function updateIndexHeader()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vCode = (int) $_POST['vCode'];
            $vTitle = (string) $_POST['vTitle'];
            $vDesc = (string) $_POST['vDesc'];

            $this->vFrontEndData->updateIndexHeader($vCode,$vTitle,$vDesc);
            echo 'success';
        }
    }

    public function updateIndexHeaderImage($vCode,$vCodeImage)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $this->vFrontEndData->updateIndexHeaderImage($vCode,$vCodeImage);
            //echo 'success';
            $this->redirect('backendIbnorca/indexHeader');
        //}
    }
    
    public function updateSectorImage($vCode,$vCodeImage)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $this->vFrontEndData->updateSectorImage($vCode,$vCodeImage);
            //echo 'success';
            $this->redirect('frontend/sectors');
        //}
    }
    
    public function updateSectorImage2($vCode,$vCodeImage)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $this->vFrontEndData->updateSectorImage2($vCode,$vCodeImage);
            //echo 'success';
            $this->redirect('frontend/sectors');
        //}
    }

    public function updateSectorBanner($vCode,$vCodeImage)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $this->vFrontEndData->updateSectorBanner($vCode,$vCodeImage);
            //echo 'success';
            $this->redirect('frontend/sectors');
        //}
    }

    public function updateImageIndexSectionService($vCode,$vCodeImage)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $this->vFrontEndData->updateImageIndexSectionService($vCode,$vCodeImage);
            //echo 'success';
            $this->redirect('backendinicio/sectionServices');
        //}
    }

    public function updateIndexDetail()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vCode = (int) $_POST['vCode'];
            $vCodPage = (int) $_POST['vCodPage'];
            $vTitle = (string) $_POST['vTitle'];
            $vDesc = (string) $_POST['vDesc'];

            $this->vFrontEndData->updateIndexDetail($vCode,$vCodPage,$vTitle,$vDesc);
            echo 'success';
        }
    }
    
    public function updateIndexBenefits()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vCode = (int) $_POST['vCode'];
            $vTitle = (string) $_POST['vTitle'];
            $vDesc = (string) $_POST['vDesc'];

            $this->vFrontEndData->updateIndexBenefits($vCode,$vTitle,$vDesc);
            echo 'success';
        }
    }
    
    public function updateIndexBenefitsImage($vCode,$vCodeImage)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $this->vFrontEndData->updateIndexBenefitsImage($vCode,$vCodeImage);
            //echo 'success';
            $this->redirect('backendibnorca/indexBenefits');
        //}
    }
    
    public function updateIndexServices()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {             

            $vCode = (int) $_POST['vCode'];
            $vCodPage = (int) $_POST['vCodPage'];
            $vTitle = (string) $_POST['vTitle'];
            $vHeader = (string) $_POST['vHeader'];
            $vDesc = (string) $_POST['vDesc'];

            $this->vFrontEndData->updateIndexServices($vCode,$vCodPage,$vTitle,$vHeader, $vDesc);
            echo 'success';
        }
    }
    
    public function updateIndexServicesImage($vCode,$vCodeImage)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $this->vFrontEndData->updateIndexServicesImage($vCode,$vCodeImage);
            //echo 'success';
            $this->redirect('backendibnorca/indexServices');
        //}
    }

    public function updateIndexServicesImage2($vCode,$vCodeImage)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $this->vFrontEndData->updateIndexServicesImage2($vCode,$vCodeImage);
            //echo 'success';
            $this->redirect('backendibnorca/indexServices');
        //}
    }
    
    public function updateIndexBenefitsServices()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vCode = (int) $_POST['vCode'];
            $vCodServicesIndex = (int) $_POST['vCodServicesIndex'];
            $vTitle = (string) $_POST['vTitle'];
            $vDesc = (string) $_POST['vDesc'];

            $this->vFrontEndData->updateIndexBenefitsServices($vCode, $vCodServicesIndex,$vTitle,$vDesc);
            echo 'success';
        }
    }
    
    public function updateIndexBenefitsServicesImage($vCode,$vCodeImage)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $this->vFrontEndData->updateIndexBenefitsServicesImage($vCode,$vCodeImage);
            //echo 'success';
            $this->redirect('backendibnorca/indexBenefitsServices');
        //}
    }
    
    public function updateImageIndexServiceAnchoring($vCode,$vCodeImage)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $this->vFrontEndData->updateImageIndexServiceAnchoring($vCode,$vCodeImage);
            //echo 'success';
            $this->redirect('backendinicio/serviceAnchoring');
        //}
    }
    
    public function updateIndexSectionServices()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vCodPage = (int) $_POST['vCodPage'];
            $vCode = (int) $_POST['vCode'];
            $vURL = (string) $_POST['vURL'];
            $vTitle = (string) $_POST['vTitle'];
            $vText = (string) $_POST['vText'];

            $this->vFrontEndData->updateIndexSectionServices($vCode, $vCodPage, $vURL, $vTitle, $vText);
            echo 'success';
        }
    }
    
    public function updateTitles()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vCode = (int) $_POST['vCode'];
            $vCodPage = (int) $_POST['vCodPage'];
            $vCodSection = (int) $_POST['vCodSection'];
            $vTitleA = (string) $_POST['vTitleA'];
            $vTitleB = (string) $_POST['vTitleB'];
            $vText = (string) $_POST['vText'];

            $this->vFrontEndData->updateTitles($vCode, $vCodPage, $vCodSection, $vTitleA, $vTitleB, $vText);
            echo 'success';
        }
    }
    
    public function updatePartners()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vCode = (int) $_POST['vCode'];
            $vCodPage = (int) $_POST['vCodPage'];
            $vType = (int) $_POST['vType'];
            $vTitle = (string) $_POST['vTitle'];
            $vURL = (string) $_POST['vURL'];

            $this->vFrontEndData->updatePartners($vCode, $vCodPage, $vType, $vTitle, $vURL);
            echo 'success';
        }
    }
    
    public function updateImagePartners($vCode,$vCodeImage)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $this->vFrontEndData->updateImagePartners($vCode,$vCodeImage);
            //echo 'success';
            $this->redirect('backendnosotros/partners');
        //}
    }
    
    public function updateSorter()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vCode = (int) $_POST['vCode'];
            $vOrder = (int) $_POST['vOrder'];
            $vNameWeb = (string) $_POST['vNameWeb'];
            $vTextWeb = (string) $_POST['vTextWeb'];

            $this->vFrontEndData->updateSorter($vCode, $vOrder, $vNameWeb, $vTextWeb);
            echo 'success';
        }
    }

    public function updateImageServiceServicesAnchoring($vCode,$vCodeImage)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $this->vFrontEndData->updateImageServiceServicesAnchoring($vCode,$vCodeImage);
            //echo 'success';
            $this->redirect('backendinicio/serviceServicesAnchoring');
        //}
    }

    public function updateNews()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vCode = (int) $_POST['vCode'];
            $vType = (int) $_POST['vType'];
            $vDateNews = $_POST['vDateNews'];
            $vTitle = (string) $_POST['vTitle'];
            $vText = (string) $_POST['vTextNews'];

            $vInsert = $this->vFrontEndData->updateNews($vCode, $vType, $vDateNews, $vTitle, $vText);
            echo 'success';
        }
    }    
    
    public function updateNewsImage($vCode,$vCodeImage)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $this->vFrontEndData->updateNewsImage($vCode,$vCodeImage);
            //echo 'success';
            $this->redirect('backendibnorca/news');
        //}
    }
    
    public function updateSorterIco($vCode,$vCodeImage)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $this->vFrontEndData->updateSorterIco($vCode,$vCodeImage);
            //echo 'success';
            $this->redirect('backendSoluciones/oferta');
        //}
    }

    public function updateSorterImage($vCode,$vCodeImage)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $this->vFrontEndData->updateSorterImage($vCode,$vCodeImage);
            //echo 'success';
            $this->redirect('backendSoluciones/oferta');
        //}
    }    
    
    public function updateWebCourseImagePri($vCode,$vCodeImage)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $this->vFrontEndData->updateWebCourseImagePri($vCode,$vCodeImage);
            //echo 'success';
            $this->redirect('backendSoluciones/webCourses');
        //}
    }
    public function updateWebCourseImageSec($vCode,$vCodeImage)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $this->vFrontEndData->updateWebCourseImageSec($vCode,$vCodeImage);
            //echo 'success';
            $this->redirect('backendSoluciones/webCourses');
        //}
    }

    public function updateKeywords()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vCode = (int) $_POST['vCode'];
            $vCodPage = (int) $_POST['vCodPage'];
            $vText = (string) $_POST['vText'];

            $this->vFrontEndData->updateKeywords($vCode,$vCodPage,$vText);
            echo 'success';
        }
    }

    public function updateDescriptionSEO()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vCode = (int) $_POST['vCode'];
            $vCodPage = (int) $_POST['vCodPage'];
            $vText = (string) $_POST['vText'];

            $this->vFrontEndData->updateDescriptionSEO($vCode,$vCodPage,$vText);
            echo 'success';
        }
    }
    
    public function updateRegistrationProcess()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vCode = (int) $_POST['vCode'];
            $vTitle = (string) $_POST['vTitle'];
            $vDesc = (string) $_POST['vDesc'];

            $this->vFrontEndData->updateRegistrationProcess($vCode,$vTitle,$vDesc);
            echo 'success';
        }
    }
    
    public function updateRegistrationProcessImage($vCode,$vCodeImage)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $this->vFrontEndData->updateRegistrationProcessImage($vCode,$vCodeImage);
            //echo 'success';
            $this->redirect('backendSoluciones/registrationProcess');
        //}
    }
    
    public function updateTestimonials()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vCode = (int) $_POST['vCode'];
            $vCodPage = (int) $_POST['vCodPage'];
            $vName = (string) $_POST['vName'];
            $vBusiness = (string) $_POST['vBusiness'];
            $vText = (string) $_POST['vText'];
            $vURL = (string) $_POST['vURL'];

            $this->vFrontEndData->updateTestimonials($vCode, $vCodPage, $vName, $vBusiness, $vText, $vURL);
            echo 'success';
        }
    }

    public function updateTestimonialImage($vCode,$vCodeImage)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $this->vFrontEndData->updateTestimonialImage($vCode,$vCodeImage);
            //echo 'success';
            $this->redirect('backendSoluciones/testimonials');
        //}
    }
    
    public function updateSector()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {            

            $vCode = (int) $_POST['vCode'];
            $vNameSector = (string) $_POST['vNameSector'];
            $vHeaderSector = (string) $_POST['vHeaderSector'];
            $vDescSector = (string) $_POST['vDescSector'];

            $this->vFrontEndData->updateSector($vCode, $vNameSector, $vHeaderSector, $vDescSector);
            echo 'success';
        }
    }
    
    public function updateComiteCodPDF($vCodPDF, $vIdComite)
    {
        $this->vFrontEndData->updateComiteCodPDF($vCodPDF, $vIdComite);
    }
    
    public function updateStatusAdvertisement($vCode)
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$vCode = (int) $_POST['vCode'];
            //$vCodeImage = (int) $_POST['vCodeImage'];

            $vStatus = $this->vFrontEndData->getAdvertisementStatus($vCode);

            if($vStatus == 1){
                $this->vFrontEndData->updateStatusAdvertisement($vCode,0);
            } else if($vStatus == 0){
                $this->vFrontEndData->updateStatusAdvertisement($vCode,1);
            }
            
            echo 'success';
        //}
    }

    public function updateDataImage()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {            

            $vCode = (int) $_POST['vCode'];
            $vOldName = (string) $_POST['vOldName'];
            $vNameImage = (string) $_POST['vNameImage'];
            $vDescImage = (string) $_POST['vDescImage'];

            $vRootDirectory = ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.DEFAULT_VIEW_LAYOUT.DIR_SEPARATOR.'frontend'.DIR_SEPARATOR.'img'.DIR_SEPARATOR.'ibnorca'.DIR_SEPARATOR;

            $vChangeNameProcess = rename($vRootDirectory.$vOldName, $vRootDirectory.$vNameImage);

            $this->vFrontEndData->updateImage($vCode, $vNameImage, $vDescImage);
            echo 'success';
        }
    }
}
