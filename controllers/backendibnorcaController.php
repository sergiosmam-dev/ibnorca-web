<?Php

class backendibnorcaController extends IdEnController
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

    public function indexHeader($vAction = null, $vCode = 0)
    {
        $vPage = 'index';
        $vCodPage = 1;

        $this->vView->DataPages = $this->vFrontEndData->getDataPages();
        //$this->vView->DataIndexList = $this->vFrontEndData->getDataIndexList();
        $this->vView->DataIndexList = $this->vFrontEndData->getDataIndexItemPage($vCodPage);

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataIndexItem = $this->vFrontEndData->getDataIndexItem($vCode);
            $this->vView->visualize('indexHeader');
        } else {
            $this->vView->visualize('indexHeader');
        }
    }

    public function addindexHeaderImage($vCode)
    {
        $vCode = (int) $vCode;
        
        $this->vView->vCode = $vCode;
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();
        $this->vView->visualize('addindexHeaderImage');
    }

    public function indexDetail($vAction = null, $vCode = 0)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataIndexDetailItem = $this->vFrontEndData->getDataIndexDetailItem($vCode);
            $this->vView->visualize('indexDetail');
        } else {
            $this->vView->visualize('indexDetail');
        }
    } 
    
    public function indexBenefits($vAction = null, $vCode = 0)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataIndexBenefitsItem = $this->vFrontEndData->getDataIndexBenefitsItem($vCode);
            $this->vView->DataPages = $this->vFrontEndData->getDataPages();
            $this->vView->visualize('indexBenefits');
        } else {
            $this->vView->visualize('indexBenefits');
        }
    }     
    
    public function addindexBenefitsImage($vCode)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        $vCode = (int) $vCode;
        
        $this->vView->vCode = $vCode;
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();
        $this->vView->visualize('addindexBenefitsImage');
    }

    public function indexServices($vAction = null, $vCode = 0)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();
        $this->vView->DataIndexServicesList = $this->vFrontEndData->getDataIndexServicesList();

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataIndexServicesItem = $this->vFrontEndData->getDataIndexServicesItem($vCode);
            $this->vView->visualize('indexServices');
        } else {
            $this->vView->visualize('indexServices');
        }
    }

    public function addPDFIndexServices($vCode)
    {
        $vCode = (string) $vCode;

        $this->vView->DataIndexServicesItem = $this->vFrontEndData->getDataIndexServicesItem($vCode);
        $this->vView->DataIndexServicesPDF = $this->vFrontEndData->getPDFIndexServices($vCode);
        
        $this->vView->visualize('addPDFIndexServices');
    }
    
    public function addIndexServicesImage($vCode)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        $vCode = (int) $vCode;
        
        $this->vView->vCode = $vCode;
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();
        $this->vView->visualize('addIndexServicesImage');
    }

    public function addIndexServicesImage2($vCode)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        $vCode = (int) $vCode;
        
        $this->vView->vCode = $vCode;
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();
        $this->vView->visualize('addIndexServicesImage2');
    }
    
    public function indexBenefitsServices($vAction = null, $vCode = 0)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();
        $this->vView->DataInfoServices = $this->vFrontEndData->getDataInfoServices();

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataIndexBenefitsServicesItem = $this->vFrontEndData->getDataIndexBenefitsServicesItem($vCode);
            $this->vView->DataPages = $this->vFrontEndData->getDataPages();
            $this->vView->visualize('indexBenefitsServices');
        } else {
            $this->vView->visualize('indexBenefitsServices');
        }
    }

    public function addIndexBenefitsServicesImage($vCode)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        $vCode = (int) $vCode;
        
        $this->vView->vCode = $vCode;
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();
        $this->vView->visualize('addIndexBenefitsServicesImage');
    }

    public function news($vAction = null, $vCode = 0)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataNewsItem = $this->vFrontEndData->getDataNewsItem($vCode);
            $this->vView->visualize('news');
        } else {
            $this->vView->visualize('news');
        }
    }
    
    public function addNewsImage($vCode)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        $vCode = (int) $vCode;
        
        $this->vView->vCode = $vCode;
        $this->vView->DataImages = $this->vFrontEndData->getDataImages();
        $this->vView->visualize('addNewsImage');
    }

    public function keywords($vAction = null, $vCode = 0)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataKeywordsItem = $this->vFrontEndData->getDataKeywordsItem($vCode);
            $this->vView->DataPages = $this->vFrontEndData->getDataPages();
            $this->vView->visualize('keywords');
        } else {
            $this->vView->visualize('keywords');
        }
    }
    
    public function descriptionSEO($vAction = null, $vCode = 0)
    {
        $this->vView->DataPages = $this->vFrontEndData->getDataPages();

        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataDescriptionSEOItem = $this->vFrontEndData->getDataDescriptionSEOItem($vCode);
            $this->vView->DataPages = $this->vFrontEndData->getDataPages();
            $this->vView->visualize('descriptionSEO');
        } else {
            $this->vView->visualize('descriptionSEO');
        }
    }
    
    public function addNewsPDF()
    {
        $this->vView->DataNewsList = $this->vFrontEndData->getDataNewsList();
        $this->vView->DataComitePDFList = $this->vFrontEndData->getDataComitePDFList();
        $this->vView->visualize('addNewsPDF');
    } 
}
?>