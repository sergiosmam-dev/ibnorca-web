<?Php

class busquedasController extends IdEnController
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

    public function global($vSearchWords = 'NB', $vPage = 1)
    {        
        $vSearchWords = $vSearchWords;
        $vPage = (int) $vPage;
    
        $this->vView->vSearchString = str_replace('-',' ',$vSearchWords);

        $this->vView->DataCountCoursesSearchResult = $this->vAPIIbnorcaData->getCountIbnorcaCoursesSearch(str_replace('-',' ',$vSearchWords));
        $this->vView->DataCountStandardsSearchResult = $this->vAPIIbnorcaData->getCountIbnorcaStandardsSearch(str_replace('-',' ',$vSearchWords));
        $this->vView->DataCountServiceSearchResult = $this->vAPIIbnorcaData->getCountIbnorcaServiceSearch(str_replace('-',' ',$vSearchWords));
        $this->vView->DataCountNewsSearchResult = $this->vAPIIbnorcaData->getCountIbnorcaNewsSearch(str_replace('-',' ',$vSearchWords));

        $this->vView->DataCoursesSearchResult = $this->vAPIIbnorcaData->getIbnorcaCoursesSearch(str_replace('-',' ',$vSearchWords),$vPage);

        $this->vView->DataStandardsFirstSearchResult = $this->vAPIIbnorcaData->getDataStandardsSearches(str_replace('-',' ',$vSearchWords),$vPage);
        $this->vView->DataStandardsSearchResult = $this->vAPIIbnorcaData->getDataStandardsExactSearches(str_replace('-',' ',$vSearchWords),$vPage);
        $this->vView->DataServiceSearchResult = $this->vAPIIbnorcaData->getDataServiceExactSearches(str_replace('-',' ',$vSearchWords),$vPage);
        $this->vView->DataNewsSearchResult = $this->vAPIIbnorcaData->getIbnorcaNewsSearch(str_replace('-',' ',$vSearchWords),$vPage);
        
        //$this->vView->DataStandardsSearchResult = $this->vAPIIbnorcaData->getIbnorcaStandardsSearch(str_replace('-',' ',$vSearchWords),$vPage);

        $this->vView->DataCountActiveCommiteesSearchResult = $this->vAPIIbnorcaData->getCountActiveCommiteesSearch(str_replace('-',' ',$vSearchWords),$vPage);
        $this->vView->DataIbnorcaActiveCommiteesSearchResult = $this->vAPIIbnorcaData->getIbnorcaActiveCommiteesSearch(str_replace('-',' ',$vSearchWords),$vPage);

        $this->vView->visualize('global');
    }

}
?>