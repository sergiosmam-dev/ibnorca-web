<?Php

class deleteController extends IdEnController
{
    public function __construct()
    {

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
        $this->vFrontEndData = $this->LoadModel('frontend');
        $this->vAPIIbnorcaData = $this->LoadModel('apiibnorca');

        /**********************************/
        /* BEGIN AUTHENTICATE USER ACTIVE */
        /**********************************/
        $this->vView->vSubNavContent = '';
    }

    public function index()
    {
        $this->vView->visualize('index');
    }

    public function deleteLandingImage($vCodLandingImg)
    {
        $vCodLandingImg = (int) $vCodLandingImg;
        $vNameImage = $this->vAPIIbnorcaData->getIbnorcaCourseNameImage($vCodLandingImg);
        $vRootDirectory = ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.DEFAULT_VIEW_LAYOUT.DIR_SEPARATOR.'frontend'.DIR_SEPARATOR.'img'.DIR_SEPARATOR.'courses'.DIR_SEPARATOR;
        unlink($vRootDirectory.$vNameImage);
        $this->vAPIIbnorcaData->deleteLandingImage($vCodLandingImg);
        echo 'success';
    }

    public function deleteLandingInfo($vCodLandingInfo, $IdUnico)
    {
        $vCodLandingInfo = (int) $vCodLandingInfo;
        $IdUnico = (int) $IdUnico;
        $this->vAPIIbnorcaData->deleteLandingInfo($vCodLandingInfo);
        //echo 'success';
        $this->redirect('frontend/addInfo/'.$IdUnico);
    }

    public function deleteLandingPDF($vCodLandingPDF)
    {
        $vCodLandingPDF = (int) $vCodLandingPDF;
        $vNameImage = $this->vAPIIbnorcaData->getIbnorcaCourseNamePDF($vCodLandingPDF);
        $vRootDirectory = ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.DEFAULT_VIEW_LAYOUT.DIR_SEPARATOR.'frontend'.DIR_SEPARATOR.'img'.DIR_SEPARATOR.'PDF'.DIR_SEPARATOR;
        unlink($vRootDirectory.$vNameImage);
        $this->vAPIIbnorcaData->deleteLandingPDF($vCodLandingPDF);
        echo 'success';
    }
    
    public function deleteMenu($vCodMenu)
    {
        $vCodMenu = (int) $vCodMenu;
        $this->vMenuData->deleteMenu($vCodMenu);
        echo 'success';
        //$this->redirect('system/menuList');
    }
    
    public function deleteHeaderIndex($vCode)
    {
        $vCode = (int) $vCode;
        $this->vFrontEndData->deleteHeaderIndex($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    }    
    
    public function deleteUser($vCode)
    {
        $vCode = (int) $vCode;
        $this->vUsersData->deleteUser($vCode);
        $this->vProfileData->deleteProfileFromUserCod($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    }      
    public function deleteDetailIndex($vCode)
    {
        $vCode = (int) $vCode;
        $this->vFrontEndData->deleteDetailIndex($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    }
    public function deleteBenefitsIndex($vCode)
    {
        $vCode = (int) $vCode;
        $this->vFrontEndData->deleteBenefitsIndex($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    }
    
    public function deleteBenefitsServices($vCode)
    {
        $vCode = (int) $vCode;
        $this->vFrontEndData->deleteBenefitsServices($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    }

    public function deleteServiceAnchoring($vCode)
    {
        $vCode = (int) $vCode;
        $this->vFrontEndData->deleteServiceAnchoring($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    }
    
    public function deleteImage($vCode)
    {
        $vCode = (int) $vCode;
        $vRootDirectory = ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.DEFAULT_VIEW_LAYOUT.DIR_SEPARATOR.'frontend'.DIR_SEPARATOR.'img'.DIR_SEPARATOR.'ibnorca'.DIR_SEPARATOR;
        $vImageLocation = $vRootDirectory.$this->vFrontEndData->getImageName($vCode);
        unlink($vImageLocation); 
        $this->vFrontEndData->deleteImage($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    }
    
    public function deleteTitle($vCode)
    {
        $vCode = (int) $vCode;
        $this->vFrontEndData->deleteTitle($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    }
    
    public function deletePartners($vCode)
    {
        $vCode = (int) $vCode;
        $this->vFrontEndData->deletePartners($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    } 
    
    public function deleteIndexServices($vCode)
    {
        $vCode = (int) $vCode;
        $this->vFrontEndData->deleteIndexServices($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    }     

    public function deleteSectionServices($vCode)
    {
        $vCode = (int) $vCode;
        $this->vFrontEndData->deleteSectionServices($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    }
    
    public function deleteCourseWeb($vCode)
    {
        $vCode = (int) $vCode;
        $this->vFrontEndData->deleteCourseWeb($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    }
    
    public function deleteServiceServicesAnchoring($vCode)
    {
        $vCode = (int) $vCode;
        $this->vFrontEndData->deleteServiceServicesAnchoring($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    }
    
    public function deleteLandingBenefit($vCode, $IdUnico)
    {
        $vCode = (int) $vCode;
        $IdUnico = (int) $IdUnico;
        $this->vAPIIbnorcaData->deleteLandingBenefit($vCode);
        //echo 'success';
        $this->redirect('backendSoluciones/addInfo/'.$IdUnico);
    }
    
    public function deleteLandingFaqs($vCode)
    {
        $vCode = (int) $vCode;
        $IdUnico = (int) $IdUnico;
        $this->vAPIIbnorcaData->deleteLandingFaqs($vCode);
        //echo 'success';
        $this->redirect('backendSoluciones/landingfaqs');
    }
    public function deleteKeywords($vCode)
    {
        $vCode = (int) $vCode;
        $this->vFrontEndData->deleteKeywords($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    } 
    public function deleteDescriptionSEO($vCode)
    {
        $vCode = (int) $vCode;
        $this->vFrontEndData->deleteDescriptionSEO($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    }
    public function deleteRegistrationProcess($vCode)
    {
        $vCode = (int) $vCode;
        $this->vFrontEndData->deleteRegistrationProcess($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    }
    public function deleteTestimonials($vCode)
    {
        $vCode = (int) $vCode;
        $this->vFrontEndData->deleteTestimonials($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    }
    
    public function deleteNews($vCode)
    {
        $vCode = (int) $vCode;
        $this->vFrontEndData->deleteNews($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    }
    
    public function deleteLandingDiscounts($vCode)
    {
        $vCode = (int) $vCode;
        $this->vAPIIbnorcaData->deleteLandingDiscounts($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    }
    
    public function deleteComitePDF($vCodPDF,$vIdComite)
    {
        $vCodPDF = (int) $vCodPDF;
        $vIdComite = (int) $vIdComite;
        $this->vFrontEndData->updateComiteCodPDF(0, $vIdComite);
        $vRootDirectory = ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.DEFAULT_VIEW_LAYOUT.DIR_SEPARATOR.'frontend'.DIR_SEPARATOR.'img'.DIR_SEPARATOR.'PDF'.DIR_SEPARATOR;
        unlink($vRootDirectory.$this->vFrontEndData->getPDFName($vCodPDF));
        $this->vFrontEndData->deleteComitePDF($vCodPDF);
        //echo 'success';
        $this->redirect('backendnormalizacion/addComitePDF');
    }
    
    public function deleteSectorRelationship($vCodSector,$vCodeSectorGroup)
    {
        $vCodSector = (int) $vCodSector;
        $vCodeSectorGroup = (int) $vCodeSectorGroup;
        $this->vFrontEndData->deleteSectorRelationship($vCodeSectorGroup);
        //echo 'success';
        $this->redirect('frontend/sectorRelationship/'.$vCodSector);
    }
    
    public function deleteAdvertisement($vCode)
    {
        $vCode = (int) $vCode;
        $this->vFrontEndData->deleteAdvertisement($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    }

    public function deleteSector($vCode)
    {
        $vCode = (int) $vCode;
        $this->vFrontEndData->deleteSector($vCode);
        echo 'success';
        //$this->redirect('system/menuList');
    }

    public function deletePDFIndexServices($vCodPDF,$vCodIndexServices)
    {
        $vCodPDF = (int) $vCodPDF;
        $vCodIndexServices = (int) $vCodIndexServices;
        $this->vFrontEndData->updateIndexServicesCodPDF(0, $vCodIndexServices);
        $vRootDirectory = ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.DEFAULT_VIEW_LAYOUT.DIR_SEPARATOR.'frontend'.DIR_SEPARATOR.'img'.DIR_SEPARATOR.'PDF'.DIR_SEPARATOR;
        unlink($vRootDirectory.$this->vFrontEndData->getPDFName($vCodPDF));
        $this->vFrontEndData->deletePDFRegister($vCodPDF);
        //echo 'success';
        $this->redirect('backendibnorca/addPDFIndexServices/'.$vCodIndexServices);
    }
    
}