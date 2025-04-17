<?Php

class helpdeskController extends IdEnController
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
            $this->vHelpDeskData = $this->LoadModel('helpdesk');
    
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

        public function ticketList()
        {
            $this->vView->DataTickets = $this->vHelpDeskData->getTickets($this->vCodUserLogged, 'to');
            $this->vView->visualize('ticketList');
        }

        public function ticketView($vNumTicket)
        {
            $vNumTicket = (int) $vNumTicket;
            $this->vView->DataTicket = $this->vHelpDeskData->getTicket($vNumTicket, $this->vCodUserLogged);
            $this->vView->visualize('ticketView');
        }
        
        public function ticketReply()
        {
            $this->vView->visualize('ticketReply');
        }        
        
        public function ticketCompose()
        {
            $this->vView->visualize('ticketCompose');
        }         
    }
?>