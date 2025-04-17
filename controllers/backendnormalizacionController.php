<?Php

class backendnormalizacionController extends IdEnController
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

    public function normalizationHeader($vAction = null, $vCode = 0)
    {
        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataNormalizationItem = $this->vFrontEndData->getDataNormalizationItem($vCode);
            $this->vView->visualize('normalizationHeader');
        } else {
            $this->vView->visualize('normalizationHeader');
        }
    }
    
    public function developerNormalizationHeader($vAction = null, $vCode = 0)
    {
        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataDeveloperNormalizationItem = $this->vFrontEndData->getDataDeveloperNormalizationItem($vCode);
            $this->vView->visualize('developerNormalizationHeader');
        } else {
            $this->vView->visualize('developerNormalizationHeader');
        }
    }
    
    public function standardizationCommitteesHeader($vAction = null, $vCode = 0)
    {
        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataStandardizationCommitteesHeaderItem = $this->vFrontEndData->getDataStandardizationCommitteesItem($vCode);
            $this->vView->visualize('standardizationCommitteesHeader');
        } else {
            $this->vView->visualize('standardizationCommitteesHeader');
        }
    }
    
    public function systemicReviewHeader($vAction = null, $vCode = 0)
    {
        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataSystemicReviewHeaderItem = $this->vFrontEndData->getDataSystemicReviewItem($vCode);
            $this->vView->visualize('systemicReviewHeader');
        } else {
            $this->vView->visualize('systemicReviewHeader');
        }
    }

    public function publicConsultationHeader($vAction = null, $vCode = 0)
    {
        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataPublicConsultationItem = $this->vFrontEndData->getDataPublicConsultationItem($vCode);
            $this->vView->visualize('publicConsultationHeader');
        } else {
            $this->vView->visualize('publicConsultationHeader');
        }
    }
    
    public function strengtheningHeader($vAction = null, $vCode = 0)
    {
        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataStrengtheningItem = $this->vFrontEndData->getDataStrengtheningItem($vCode);
            $this->vView->visualize('strengtheningHeader');
        } else {
            $this->vView->visualize('strengtheningHeader');
        }
    } 
    
    public function specificationsHeader($vAction = null, $vCode = 0)
    {
        if($vAction == 'edit' && $vCode > 0){
            $vCode = (int) $vCode;
            $this->vView->DataSpecificationsItem = $this->vFrontEndData->getDataSpecificationsItem($vCode);
            $this->vView->visualize('specificationsHeader');
        } else {
            $this->vView->visualize('specificationsHeader');
        }
    }
    
    public function addComitePDF()
    {
        $this->vView->DataActiveCommiteesList = $this->vAPIIbnorcaData->getIbnorcaActiveCommitees();
        $this->vView->DataComitePDFList = $this->vFrontEndData->getDataComitePDFList();
        $this->vView->visualize('addComitePDF');
    }    

    
}
?>