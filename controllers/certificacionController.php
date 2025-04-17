<?Php

class certificacionController extends IdEnController
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

        $this->vView->vSubNavContent = '<div class="nav-secciones">
                                            <a class="desplazar" href="#seccion-ibnorca-1">Sistema de Gestión</a>
                                            <a class="desplazar" href="#seccion-ibnorca-2">Productos/Servicios</a>
                                            <a class="desplazar" href="#seccion-ibnorca-3">Buenas Prácticas de Manufactura</a>
                                            <a class="desplazar" href="#seccion-ibnorca-4">Pasos para una Cetificación</a>
                                        </div>';        

    }

    public function index()
    {
        $this->vView->visualize('certificaciones');
    }
    public function sistemadegestion()
    {
        $this->vView->visualize('sistemadegestion');
    }    
    public function productososervicios()
    {
        $this->vView->visualize('productososervicios');
    }
    public function buenaspracticas()
    {
        $this->vView->visualize('buenaspracticas');
    }
}
?>