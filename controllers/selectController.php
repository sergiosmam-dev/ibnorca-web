<?Php

class selectController extends IdEnController
{
    public function __construct()
    {

        parent::__construct();

        $this->vCtrl = $this->LoadModel('ctrl');
        $this->vMenuData = $this->LoadModel('menu');
        $this->vAccessData = $this->LoadModel('access');
        $this->vProfileData = $this->LoadModel('profile');        
        $this->vUsersData = $this->LoadModel('users');
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
    
    public function webServicesLoginIbnorca()
    {
        //if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //$nombreUser = (string) strtolower($_POST['email']);
            //$claveUser = (string) md5($_POST['password']);

            $sIde = "portal";
            $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988";
            $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, 
                        "accion"=>"Login", 
                        "nombreUser"=>"jose.veizaga@ibnorca.org", 
                        "claveUser"=>"e10adc3949ba59abbe56e057f20f883e"
                        ); 
            $datos=json_encode($parametros);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibnob/operacion/ws-ope-usuario.php");
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $remote_server_output = curl_exec ($ch);
            curl_close ($ch);
            header('Content-type: application/json'); 	
            print_r($remote_server_output);            

        //}
    }    

    public function ibnorcaLoginService()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $nombreUser = (string) strtolower($_POST['email']);
            $claveUser = (string) md5($_POST['password']);

            $sIde = "portal";
            $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988";
            $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, 
                        "accion"=>"Login", 
                        "nombreUser"=>$nombreUser, 
                        "claveUser"=>$claveUser
                        );

            $datos=json_encode($parametros);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/operacion/ws-ope-usuario.php");
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $remote_server_output = curl_exec ($ch);
            curl_close ($ch);

            $this->DataIbnorcaLoginService = json_decode($remote_server_output, true);

            $vEstadoLogin = $this->DataIbnorcaLoginService['estadologin'];
            $vEmail = $this->DataIbnorcaLoginService['datosUsuario']['UsuarioCorreo'];
            $vActivationcode = $this->DataIbnorcaLoginService['datosUsuario']['IdUsuario'];


            $vNames = $this->DataIbnorcaLoginService['datosCliente']['NombreRazon'];
            $vLastNames = $this->DataIbnorcaLoginService['datosCliente']['Paterno'].' '.$this->DataIbnorcaLoginService['datosCliente']['Materno'];
            
            if($vEstadoLogin == true){
                $vEmail = $nombreUser;
                $vPassword = $vRePassword = 'MD5_'.$claveUser;
                if($this->vUsersData->getUserEmailExists($vEmail) == 0){
                    $vActivationcode = rand(1000000,9999999);
                    $vUserCode = $this->vUsersData->userRegister(0,$vEmail,$vPassword,$vRePassword,$vEmail,'web',$vActivationcode,1,1);
                    $vProfileName = (string) strtolower(str_replace(' ', '', $vNames).str_replace(' ', '', $vLastNames));

                    if($this->vProfileData->getProfileExists($vProfileName) == 1){
                        $vProfileName = $vProfileName.rand(100,99999);
                    }
                    
                    $vProfileType = 1;
                    $vProfileCode = $this->vProfileData->profileRegister($vUserCode, $vProfileName, $vNames, $vLastNames, $vProfileType, $vStatus, $vActive);                                
                    if($vProfileCode != 0){                             
                        
                        $vUserCode = $this->vProfileData->getCodUserFromCodProfile($vProfileCode);
                        $vProfileName = $this->vProfileData->getProfileNameFromCodProfile($vProfileCode);
                        $vUserEmail = $this->vUsersData->getUserEmail($vUserCode);
                        $vUserRole = $this->vUsersData->getUserRole($vUserCode);


                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE, true);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'RandCodeUser', rand(10000, 99999).'-'.$vUserCode);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'UserCode', $vUserCode);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode', $vProfileCode);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'ProfileName', $vProfileName);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'Email', $vUserEmail);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'Role', $vUserRole);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'TimeSession', time());
                        
                        // CONTROL USER SESSION
                        $this->vCtrl->insertCtrlSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'), 'Signin', session_id(), $this->getUserIP(), $this->getMAC(), $this->getOS(), $this->getBrowser(), $this->getComputerName());
                        
                        // CONTROL USER ACTION
                        $this->vCtrl->insertCtrlAction($this->vCtrl->getLastSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'),IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode')), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'), 'register', 'auth', 'RegisterMethod', 'userRegister', $vNames.';'.$vLastNames.';'.$vActivationcode.';'.$vActivationcode.';'.$vActive);

                        echo 'success';                    
                    }    
                } else {
                    $vPassword = $vRePassword = 'MD5_'.$claveUser;
                    $vValidPassword = $this->vAccessData->getValidPassword($vEmail,$vPassword);

                    if($vValidPassword == 1){
                        $vAccessStatus = $this->vAccessData->getAccessStatusIbnorca($vEmail);
                        $vProfileType = 1;
                        $vProfileCode = $this->vProfileData->getProfileCodeFromUserCode($vAccessStatus['n_coduser'], $vProfileType);
    
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE, true);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'RandCodeUser', rand(10000, 99999).'-'.$vAccessStatus['n_coduser']);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'UserCode', $vAccessStatus['n_coduser']);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'UserEmail', $vAccessStatus['c_email']);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'UserRole', $vAccessStatus['c_userrole']);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'ProfileName', $vAccessStatus['c_profilename']);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode', $vProfileCode);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'TimeSession', time());
                        
                        // CONTROL USER SESSION
                        $this->vCtrl->insertCtrlSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'), 'login', session_id(), $this->getUserIP(), $this->getMAC(), $this->getOS(), $this->getBrowser(), $this->getComputerName());
    
                        echo 'success';
                    } else {
                        $vNewPassword = $vNewRePassword = 'MD5_'.$claveUser;
                        $vCodUser = $this->vUsersData->getUserCode($vEmail);
                        $this->vUsersData->updateUserPassword($vCodUser, $vNewPassword, $vNewRePassword);

                        $vAccessStatus = $this->vAccessData->getAccessStatusIbnorca($vEmail);
                        $vProfileType = 1;
                        $vProfileCode = $this->vProfileData->getProfileCodeFromUserCode($vAccessStatus['n_coduser'], $vProfileType);
    
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE, true);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'RandCodeUser', rand(10000, 99999).'-'.$vAccessStatus['n_coduser']);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'UserCode', $vAccessStatus['n_coduser']);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'UserEmail', $vAccessStatus['c_email']);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'UserRole', $vAccessStatus['c_userrole']);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'ProfileName', $vAccessStatus['c_profilename']);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode', $vProfileCode);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'TimeSession', time());
                        
                        // CONTROL USER SESSION
                        $this->vCtrl->insertCtrlSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'), 'login', session_id(), $this->getUserIP(), $this->getMAC(), $this->getOS(), $this->getBrowser(), $this->getComputerName());
    
                        echo 'success';
                    }


                }
            } else {
                echo $vEstadoLogin;
            }
        }      
    }    

    public function dataFromExcel()
    {
        $this->DataDataFromExcel = $this->vCtrl->getDataFromExcel();
        foreach ($this->DataDataFromExcel as $row) {
            $data[] = array(
                "a" => $row['a'],
                "b" => $row['b'],
                "c" => $row['c'],
                "d" => $row['d'],
                "e" => $row['e'],
                "f" => $row['f'],
                "g" => $row['g'],
                "h" => $row['h'],
                /*"i"=>$row['i'],
            "j"=>$row['j'],
            "k"=>$row['k'],
            "l"=>$row['l'],
            "m"=>$row['m'],
            "n"=>$row['n'],
            "o"=>$row['o'],
            "p"=>$row['p'],
            "q"=>$row['q'],
            "r"=>$row['r'],
            "s"=>$row['s'],
            "t"=>$row['t'],
            "u"=>$row['u'],
            "v"=>$row['v'],
            "w"=>$row['w'],
            "x"=>$row['x'],
            "y"=>$row['y'],
            "z"=>$row['z']*/
            );
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }

    public function dataMenuSide()
    {
        $this->DataListMenu = $this->vMenuData->getListMenu();
        foreach ($this->DataListMenu as $row) {
            $data[] = array(
                "n_codmenu" => $row['n_codmenu'],
                "n_level1" => $row['n_level1'],
                "n_level2" => $row['n_level2'],
                "n_level3" => $row['n_level3'],
                "n_level4" => $row['n_level4'],
                "c_controlleractive" => $row['c_controlleractive'],
                "c_title" => $row['c_title'],
                "n_parent" => $row['n_parent'],
                "c_menutype" => $row['c_menutype'],
                "n_positionmenu" => $row['n_positionmenu'],
                "c_url" => $row['c_url'],
                "n_session" => $row['n_session'],
                "n_active" => $row['n_active'],
            );
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }

    public function dataUsers()
    {
        $this->DataListUsers = $this->vUsersData->getUsers();
        foreach ($this->DataListUsers as $row) {
            $data[] = array(
                "n_coduser" => $row['n_coduser'],
                "c_rrss_id" => $row['c_rrss_id'],
                "c_username" => $row['c_username'],
                "c_pass1" => $row['c_pass1'],
                "c_pass2" => $row['c_pass2'],
                "c_email" => $row['c_email'],
                "c_userrole" => $row['c_userrole'],
                "n_tnc" => $row['n_tnc'],
                "n_activationcode" => $row['n_activationcode'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "n_codprofile" => $row['n_codprofile'],
                "c_profile_img" => '<span class="symbol symbol-lg-35 symbol-25 symbol-light-success"><div class="symbol-label" style="background-image:url(' . $vParamsViewBackEndLayout['root_backend_media_users'] . 'directory_' . $this->vDataUsers[$i]['n_codprofile'] . '/' . $row['c_profile_img'] . ')"></div></span></strong>',
            );
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    public function dataCourses()
    {
        /*ACCESO A WEB SERVICE CAPACITACION Mod:2020-03-28*/
        //LLAVES DE ACCESO AL WS
        $sIde = "portal";
        $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988";
        /*PARAMETROS PARA LA OBTENCION DE CURSOS*/
        // cambiar esta linea por las opciones
        $parametros = array("sIdentificador" => $sIde, "sKey" => $sKey, "accion" => "ListaCursos", "cursosvigentes" => 1, "registrarlog" => 1); // lista cursos 0=Todos; 1 = Solo vigentes
        $parametros = json_encode($parametros);
        // abrimos la sesión cURL
        $ch = curl_init();
        // definimos la URL a la que hacemos la petición
        curl_setopt($ch, CURLOPT_URL, "http://ibnored.ibnorca.org/wsibno/capacitacion/ws-capacitacion.php");
        // indicamos el tipo de petición: POST
        curl_setopt($ch, CURLOPT_POST, true);
        // definimos cada uno de los parámetros
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
        // recibimos la respuesta y la guardamos en una variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec($ch);
        // cerramos la sesión cURL
        curl_close($ch);
        // imprimir en formato JSON
        header('Content-type: application/json');
        print_r($remote_server_output);
        exit;

        $this->DataCoursesList = json_decode($remote_server_output, true);
        $vCount = 1;
        foreach ($this->DataCoursesList['cursos'] as $row) {
            $data[] = array(
                "Num" => $vCount,
                "IdUnico" => $row['IdUnico'],
                "IdCurso" => $row['IdCurso'],
                "IdPrograma" => $row['IdPrograma'],
                "CodigoCurso" => $row['CodigoCurso'],
                "Programa" => $row['Programa'],
                "CantidadModulos" => $row['CantidadModulos'],
                "FechaInicio" => $row['FechaInicio'],
                "Costo" => $row['Costo'],
                "CostoModular" => $row['CostoModular'],
                "IdTipo" => $row['IdTipo'],
                "tipo" => $row['tipo'],
                "IdOficina" => $row['IdOficina'],
                "Oficina" => $row['Oficina'],
                "IdGestion" => $row['IdGestion'],
                "Gestion" => $row['Gestion'],
                "CargaHoraria" => $row['CargaHoraria'],
                "horas_modulo" => $row['horas_modulo'],
                "IdArea" => $row['IdArea'],
                "Area" => $row['Area'],
                "IdImagenCurso" => $row['IdImagenCurso'],
                "UrlImagenCurso" => $row['UrlImagenCurso'],
                "contenido" => $row['contenido'],
                "Objetivo" => $row['Objetivo'],
                "IdSectorInteres" => $row['IdSectorInteres'],
                "SectorInteres" => $row['SectorInteres'],
                "UrlImagenSector" => $row['UrlImagenSector'],
                "norma" => $row['norma'],
                "Orientado" => $row['Orientado'],
                "Horario" => $row['Horario'],
                "Dias" => $row['Dias'],
                "IdModalidad" => $row['IdModalidad'],
                "Modalidad" => $row['Modalidad'],
                "DescripcionModalidad" => $row['DescripcionModalidad'],
                "Responsable" => $row['Responsable'],
                "Descuento" => $row['Descuento'],
                "PorcenDescuento" => $row['PorcenDescuento'],
                "DescuentoGrupo" => $row['DescuentoGrupo'],
                "PorcenDescuentoGrupo" => $row['PorcenDescuentoGrupo'],
                "Link" => $row['Link'],
                "AlumnosInscritos" => $row['AlumnosInscritos'],
                "CostoSUS" => $row['CostoSUS'],
                "CostoModularSUS" => $row['CostoModularSUS'],
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    public function dataModulesXCourse()
    {
        /*ACCESO A WEB SERVICE CAPACITACION Mod:2020-03-28*/
        //LLAVES DE ACCESO AL WS
        $sIde = "portal";
        $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988";
        /*PARAMETROS PARA LA OBTENCION DE CURSOS*/
        // cambiar esta linea por las opciones
        $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ListaModulosxCurso", "IdCurso"=>4615);
        $parametros = json_encode($parametros);
        // abrimos la sesión cURL
        $ch = curl_init();
        // definimos la URL a la que hacemos la petición
        curl_setopt($ch, CURLOPT_URL, "http://ibnored.ibnorca.org/wsibno/capacitacion/ws-capacitacion.php");
        // indicamos el tipo de petición: POST
        curl_setopt($ch, CURLOPT_POST, true);
        // definimos cada uno de los parámetros
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
        // recibimos la respuesta y la guardamos en una variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec($ch);
        // cerramos la sesión cURL
        curl_close($ch);
        // imprimir en formato JSON
        header('Content-type: application/json');
        print_r($remote_server_output);
        exit;

        $this->DataCoursesList = json_decode($remote_server_output, true);
        $vCount = 1;
        foreach ($this->DataCoursesList['cursos'] as $row) {
            $data[] = array(
                "Num" => $vCount,
                "IdUnico" => $row['IdUnico'],
                "IdCurso" => $row['IdCurso'],
                "IdPrograma" => $row['IdPrograma'],
                "CodigoCurso" => $row['CodigoCurso'],
                "Programa" => $row['Programa'],
                "CantidadModulos" => $row['CantidadModulos'],
                "FechaInicio" => $row['FechaInicio'],
                "Costo" => $row['Costo'],
                "CostoModular" => $row['CostoModular'],
                "IdTipo" => $row['IdTipo'],
                "tipo" => $row['tipo'],
                "IdOficina" => $row['IdOficina'],
                "Oficina" => $row['Oficina'],
                "IdGestion" => $row['IdGestion'],
                "Gestion" => $row['Gestion'],
                "CargaHoraria" => $row['CargaHoraria'],
                "IdArea" => $row['IdArea'],
                "Area" => $row['Area'],
                "IdImagenCurso" => $row['IdImagenCurso'],
                "UrlImagenCurso" => $row['UrlImagenCurso'],
                "contenido" => $row['contenido'],
                "Objetivo" => $row['Objetivo'],
                "IdSectorInteres" => $row['IdSectorInteres'],
                "SectorInteres" => $row['SectorInteres'],
                "UrlImagenSector" => $row['UrlImagenSector'],
                "norma" => $row['norma'],
                "Orientado" => $row['Orientado'],
                "Horario" => $row['Horario'],
                "Dias" => $row['Dias'],
                "IdModalidad" => $row['IdModalidad'],
                "Modalidad" => $row['Modalidad'],
                "DescripcionModalidad" => $row['DescripcionModalidad'],
                "Responsable" => $row['Responsable'],
                "Descuento" => $row['Descuento'],
                "PorcenDescuento" => $row['PorcenDescuento'],
                "DescuentoGrupo" => $row['DescuentoGrupo'],
                "PorcenDescuentoGrupo" => $row['PorcenDescuentoGrupo'],
                "Link" => $row['Link'],
                "AlumnosInscritos" => $row['AlumnosInscritos'],
                "CostoSUS" => $row['CostoSUS'],
                "CostoModularSUS" => $row['CostoModularSUS'],
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    public function dataStandardsPublic()
    {
/*NORMAS PARA CONSULTA PUBLICA WS: ws-catalogo-v1.php 2020-03-31*/
        $sIde = "portal";
        $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988";
        $parametros = array("sIdentificador" => $sIde, "sKey" => $sKey, "operacion" => "ListarNormasConsultaPublica");
        $datos = json_encode($parametros);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://ibnored.ibnorca.org/wsibno/catalogo/ws-catalogo-v1.php");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec($ch);
        curl_close($ch);
        header('Content-type: application/json');
        print_r($remote_server_output);        
        exit;

        $this->DataStandardsPublicList = json_decode($remote_server_output, true);
        $vCount = 1;
        foreach ($this->DataStandardsPublicList as $row) {
            $data[] = array(
                "Num" => $vCount,
                "codigo" => $row['codigo'],
                "TituloNorma" => $row['TituloNorma'],
                "NumeroComite" => $row['NumeroComite'],
                "NombreComite" => $row['NombreComite'],
                "estado" => $row['estado'],
                "FechaInicioConsulta" => $row['FechaInicioConsulta'],
                "FechaFinConsulta" => $row['FechaFinConsulta'],
                "fecha_estado" => $row['fecha_estado'],
                "NombreSector" => $row['NombreSector'],
                "persona" => $row['persona'],
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    public function dataStandardsInDevelopment()
    {
        $sIde = "portal"; // De acuerdo al sistema
        $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988"; // llave de acuerdo al sistema
        $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ListaElaboracionNormasxTodosComites");

        $datos=json_encode($parametros);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion-web.php");
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec ($ch);
        curl_close ($ch);
        header('Content-type: application/json'); 	
        print_r($remote_server_output);
        exit; 
        
        $this->DataStandardsInDevelopmentList = json_decode($remote_server_output, true);
        $vCount = 1;
        foreach ($this->DataStandardsInDevelopmentList['lstNormas'] as $row) {
            $data[] = array(
                "Num" => $vCount,
                "idSector" => $row['idSector'],
                "id_comite" => $row['id_comite'],
                "nroComite" => $row['nroComite'],
                "nombreComite" => $row['nombreComite'],
                "Alcance" => $row['alcance'],
                "id_etapa" => $row['id_etapa'],
                "CodigoNomra" => $row['CodigoNorma'],
                "TituloNorma" => $row['TituloNorma'],
                "estado" => $row['estado'],
                "estado_fecha" => $row['estado_fecha'],
                "fecha_ibn_presentacion_eqnb" => $row['fecha_ibn_presentacion_eqnb'],
                "fecha_ibn_documento_apnb" => $row['fecha_ibn_documento_apnb'],
                "fecha_ibn_consulta_inicio" => $row['fecha_ibn_consulta_inicio'],
                "fecha_ibn_consulta_fin" => $row['fecha_ibn_consulta_fin'],
                "fecha_ibn_aprobacion_nb" => $row['fecha_ibn_aprobacion_nb'],
                "fecha_ibn_aprobacion_cnno" => $row['fecha_ibn_aprobacion_cnno'],
                "fecha_ibn_ratificacion" => $row['fecha_ibn_ratificacion'],
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    public function dataActiveCommittees()
    {
/*ACCESO A WEB SERVICE LISTA SECTORES, COMITES NORMAS EN ELABORACION WS: ws-normalizacion.php creado:20/04/2020 */
//LLAVES DE ACCESO AL WS

$sIde = "portal"; // De acuerdo al sistema
$sKey = "02b9eb3fdf8c7ef88209e5f14f00e988"; // llave de acuerdo al sistema

//METODOS
//Lista los sectores y comites activos con normas en elaboración
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ListaSectoresyComitesActivos"); 
	

		$datos=json_encode($parametros);
		// abrimos la sesión cURL
		$ch = curl_init();
		// definimos la URL a la que hacemos la petición
		curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion.php");
		// indicamos el tipo de petición: POST
		curl_setopt($ch, CURLOPT_POST, TRUE);
		// definimos cada uno de los parámetros
		curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
		// recibimos la respuesta y la guardamos en una variable
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$remote_server_output = curl_exec ($ch);
		// cerramos la sesión cURL
		curl_close ($ch);
		
		// imprimir en formato JSON
		header('Content-type: application/json'); 	
		print_r($remote_server_output);
        exit; 

        $this->DataActiveCommitteesList = json_decode($remote_server_output, true);
        $vCount = 1;
        foreach ($this->DataActiveCommitteesList['listaSectoresComites'] as $row) {
            $data[] = array(
                "Num" => $vCount,
                "Sector" => $row['Sector'],
                "id_comite" => $row['id_comite'],
                "NumeroComite" => $row['NumeroComite'],
                "NombreComite" => $row['NombreComite'],
                "Alcance" => $row['Alcance'],
                "FechaActivacion" => $row['FechaActivacion'],
                "FechaFinalizacion" => $row['FechaFinalizacion'],
                "NormasEQNB" => $row['NormasEQNB'],
                "NormasAPNB" => $row['NormasAPNB'],
                "NormasPNB" => $row['NormasPNB'],
                "NormasNB" => $row['NormasNB'],
                "CorreoSecretario" => $row['CorreoSecretario'],
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );
        //header('Content-type: application/json');
        echo json_encode($dataset);
    }
    public function dataActiveCommitteesV2()
    {
        $sIde = "portal"; // De acuerdo al sistema
        $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988"; // llave de acuerdo al sistema
        
        //METODOS
        //Lista los sectores y comites activos con normas en elaboración
        $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ListaSectoresyComitesActivos"); 
            
        $datos=json_encode($parametros);
        // abrimos la sesión cURL
        $ch = curl_init();
        // definimos la URL a la que hacemos la petición
        curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion-web.php");
        // indicamos el tipo de petición: POST
        curl_setopt($ch, CURLOPT_POST, TRUE);
        // definimos cada uno de los parámetros
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
        // recibimos la respuesta y la guardamos en una variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec ($ch);
        // cerramos la sesión cURL
        curl_close ($ch);

		// imprimir en formato JSON
		header('Content-type: application/json'); 	
		print_r($remote_server_output);  
        exit;

        $this->DataActiveCommitteesList = json_decode($remote_server_output, true);
        $vCount = 1;
        foreach ($this->DataActiveCommitteesList['listaSectoresComites'] as $row) {
            $data[] = array(
                "Num" => $vCount,
                "Sector" => $row['Sector'],
                "id_comite" => $row['id_comite'],
                "NumeroComite" => $row['NumeroComite'],
                "NombreComite" => $row['NombreComite'],
                "FechaActivacion" => $row['FechaActivacion'],
                "FechaFinalizacion" => $row['FechaFinalizacion'],
                "Estado" => $row['Estado'],
                "NormasEQNB" => $row['NormasEQNB'],
                "NormasAPNB" => $row['NormasAPNB'],
                "NormasPNB" => $row['NormasPNB'],
                "NormasNB" => $row['NormasNB'],
                "alcance" => $row['alcance'],
                "Rel_internacional" => $row['Rel_internacional'],
                "CorreoSecretario" => $row['CorreoSecretario'],
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );
        //header('Content-type: application/json');
        echo json_encode($dataset);
    }    
    public function dataStandardization()
    {
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://normalizacion.ibnorca.org:4721/ibnored-normas/_search/?size=3300&q=web%3A1%20AND%20vigente%3A1%20AND%20activa%3A1&_source=codigo%2CidSector%2CnombreSector%2Cnumerocomite%2CnombreComite%2CnombreNorma%2Calcance%2Cprecio%2CprecioDigital%2CprecioFisico%2Cvigente%2Cactiva%2Cweb%20',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        
        $remote_server_output = curl_exec($curl);
        //$this->DataStandardizationListNodeA = json_decode($remote_server_output, true);
        //$this->DataStandardizationListNodeB = json_decode(json_encode($this->DataStandardizationListNodeA['hits']), true);
        //$this->DataStandardizationListNodeC = json_decode($this->DataStandardizationListNodeB['hits'], true);
        curl_close($curl);
		
        header('Content-type: application/json'); 	
		print_r($remote_server_output); 
        exit;
        
        $vCount = 0;
        foreach ($this->DataStandardizationListNodeC as $row) {
            $data[] = array(
                "Num" => $vCount,
                "_index" => $row['_index'],
                "_type" => $row['_type'],
                "_id" => $row['_id'],
                "_score" => $row['_score'],
                "_precio" => $row['_source']['precio'],
                "_codigo" => $row['_source']['codigo'],
                "_precioDigital" => $row['_source']['precioDigital'],
                "_nombreComite" => $row['_source']['nombreComite'],
                "_vigente" => $row['_source']['vigente'],
                "_precioFisico" => $row['_source']['precioFisico'],
                "_idSector" => $row['_source']['idSector'],
                "_numerocomite" => $row['_source']['numerocomite'],
                "_activa" => $row['_source']['activa'],
                "_nombreNorma" => $row['_source']['nombreNorma'],
                "_nombreSector" => $row['_source']['nombreSector'],
                "_alcance" => $row['_source']['alcance'],                
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );
    }


    
    public function dataMeetingsCommittees ()
    {
        $sIde = "portal"; // De acuerdo al sistema
        $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988"; // llave de acuerdo al sistema
        
        //METODOS
        //Lista las normas en elaboracion de un Comite
        $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ListaElaboracionNormasxComite", "IdComite"=>"Todos");         
        $datos=json_encode($parametros);
        // abrimos la sesión cURL
        $ch = curl_init();
        // definimos la URL a la que hacemos la petición
        curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion.php");
        // indicamos el tipo de petición: POST
        curl_setopt($ch, CURLOPT_POST, TRUE);
        // definimos cada uno de los parámetros
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
        // recibimos la respuesta y la guardamos en una variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec ($ch);
        // cerramos la sesión cURL
        curl_close ($ch);
        
        // imprimir en formato JSON
        header('Content-type: application/json'); 	
        print_r($remote_server_output);
        exit;
        
        $this->DataDataMeetingsCommitteesList = json_decode($remote_server_output, true);
        $vCount = 1;
        foreach ($this->DataDataMeetingsCommitteesList['lstReuniones'] as $row) {
            $data[] = array(
                "Num" => $vCount,
                "NumeroComite" => $row['NumeroComite'],
                "NombreComite" => $row['NombreComite'],
                "FechaReunion" => $row['FechaReunion'],
                "Contacto" => $row['Contacto'],
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );
        //header('Content-type: application/json');
        echo json_encode($dataset);
    }

    public function dataMeetingsCommitteesV2()
    {
        $sIde = "portal"; // De acuerdo al sistema
        $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988"; // llave de acuerdo al sistema
        
        //METODOS
                
        //Lista Reuniones de Comites 
        $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ListaReunionesComites"); 
            
        
                $datos=json_encode($parametros);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion-web.php");
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $remote_server_output = curl_exec ($ch);
                curl_close ($ch);
                
                header('Content-type: application/json'); 	
                //print_r($remote_server_output); 
                //exit;

        $this->DataDataMeetingsCommitteesList = json_decode($remote_server_output, true);
        $vCount = 1;
        foreach ($this->DataDataMeetingsCommitteesList['lstReuniones'] as $row) {

            $vStateActivityClassColor = 'fc-event-success';

            if(date_format(date_create($row['FechaReunion']), 'd-m-Y') < date('d-m-Y')){
                //$vPastDate = 'pasada';
                $vStateActivityClassColorBg = 'fc-event-solid-light';//Fecha Pasada
            }            

            $data[] = array( 'id'=> $vCount,
                                    'title'=> 'CTN '.$row['NumeroComite'].' '.$row['NombreComite'],
                                    'start'=> $row['FechaReunion'],
                                    'description'=> '<strong>Contacto</strong>');
                                    $vCount++;            
            $vCount++;
        }
        echo json_encode($data);
    }
    
    public function dataCapacitacion()
    {
/*ACCESO A WEB SERVICE CAPACITACION 
Mod:2024-02-05*/
//LLAVES DE ACCESO AL WS
$sIde = "portal";
$sKey = "02b9eb3fdf8c7ef88209e5f14f00e988";

/*PARAMETROS PARA LA OBTENCION DE MALLA*/

// cambiar esta linea por las opciones
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ListarMalla"); 

		$parametros=json_encode($parametros);
		// abrimos la sesión cURL
		$ch = curl_init();
		// definimos la URL a la que hacemos la petición
		curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/capacitacion/ws-capacitacion.php"); 
		// indicamos el tipo de petición: POST
		curl_setopt($ch, CURLOPT_POST, TRUE);
		// definimos cada uno de los parámetros
		curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
		// recibimos la respuesta y la guardamos en una variable
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$remote_server_output = curl_exec ($ch);
		// cerramos la sesión cURL
		curl_close ($ch);
		
		// imprimir en formato JSON
		header('Content-type: application/json'); 	
		print_r($remote_server_output); 
        exit;
        
        $this->DataCapacitacionList = json_decode($remote_server_output, true);
        $vCount = 1;
        foreach ($this->DataCapacitacionList['lstMalla'] as $row) {
            $data[] = array(
                "idmalla" => $row['idmalla'],
                "idtipo" => $row['idtipo'],
                "IdCurso" => $row['IdCurso'],
                "idmodulo" => $row['idmodulo'],
                "FechaMalla" => $row['FechaMalla'],
                "d_tipo" => $row['d_tipo'],
                "Programa" => $row['Programa'],
                "Codigo" => $row['Codigo'],
                "d_modulo" => $row['d_modulo'],
                "nivel" => $row['nivel'],                
                "Objetivo" => $row['Objetivo'],
                "Contenido" => $row['Contenido'],
                "CodigoNorma" => $row['CodigoNorma'],
                "NombreNorma" => $row['NombreNorma'],
                "TipoNorma" => $row['TipoNorma'],
                "d_Area" => $row['d_Area'],
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );
        header('Content-type: application/json');
        echo json_encode($dataset);
    }
    
    public function dataIntegrantes()
    {
        $sIde = "portal"; // De acuerdo al sistema
        $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988"; // llave de acuerdo al sistema
        
        //METODOS
                
        //Lista Reuniones de Comites 
        $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ListaIntegrantesComites"); 
            
        
                $datos=json_encode($parametros);
                // abrimos la sesión cURL
                $ch = curl_init();
                // definimos la URL a la que hacemos la petición
                curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion-web.php");
                // indicamos el tipo de petición: POST
                curl_setopt($ch, CURLOPT_POST, TRUE);
                // definimos cada uno de los parámetros
                curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
                // recibimos la respuesta y la guardamos en una variable
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $remote_server_output = curl_exec ($ch);
                // cerramos la sesión cURL
                curl_close ($ch);
                
                // imprimir en formato JSON
                //header('Content-type: application/json'); 	
                //print_r($remote_server_output); 
        
        // imprimir en formato JSON
        header('Content-type: application/json'); 	
        print_r($remote_server_output);
        
        /*$this->DataIntegrantesList = json_decode($remote_server_output, true);
        $vCount = 1;
        foreach ($this->DataIntegrantesList['lstIntegrantes'] as $row) {
            $data[] = array(
                "Num" => $vCount,
                "NumeroComite" => $row['numero_comite'],
                "NombreComite" => $row['nombre_comite'],
                "apellido" => $row['apellido'],
                "nombre" => $row['nombre'],
                "id_persona" => $row['id_persona'],
                "movil" => $row['movil'],
                "rol" => $row['rol'],
                "empresa" => $row['empresa'],
                "Tipo_empresa" => $row['Tipo_empresa']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );
        header('Content-type: application/json');
        echo json_encode($dataset);*/
    }

    public function sectorsIbnorca()
    {
        $this->DataSectorsIbnorca = $this->vAPIIbnorcaData->getIbnorcaSectors();
        $vCount = 1;
        foreach ($this->DataSectorsIbnorca as $row) {
            $data[] = array(
                "Num" => $vCount,
                "n_codsector" => $row['n_codsector'],
                "n_coduser" => $row['n_coduser'],
                "n_codimg" => $row['n_codimg'],
                "n_codicon" => $row['n_codicon'],
                "t_name_sector" => $row['t_name_sector'],
                "t_desc_sector" => $row['t_desc_sector'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate'],
                "c_usermod" => $row['c_usermod'],
                "d_datemod" => $row['d_datemod']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }

    public function searchCurrentCourses()
    {

        $this->DataCoursesList = $this->vAPIIbnorcaData->getIbnorcaCourses();
        $vHtml = '';
        if($this->DataCoursesList > 0){
            foreach ($this->DataCoursesList as $row) {
                $vHtml .= '<div class="col-xl-4 col-lg-4 col-md-6 filter-item '.$row['IdTipo'].' '.$row['IdSectorInteres'].'">
                                <div class="case-studies-one__single">
                                    <div class="case-studies-one__single-img">
                                        <img src="'.$vParamsViewFrontEndLayout['root_frontend_img'].'resources/'.$vCount.'.jpg" alt="" />
                                        <div class="overly-text">
                                            <h3 style="font-size: 20px"><a href="'.BASE_VIEW_URL.'formacion/curso/'.$row['IdUnico'].'/'.strtolower(strtr(strtr(strtr($this->eliminar_acentos($row['Programa']), "/", "-"), ":", "-"), " ", "-")).'">'.$row['Programa'].'</a></h3>
                                            <p>
                                                <strong>Fecha Inicio:</strong> '.$row['FechaInicio'].'<br>
                                                <strong>Costo Total:</strong> '.$row['Costo'].'
                                            </p>
                                        </div>
                                        <div class="overly-btn">
                                            <a href="'.BASE_VIEW_URL.'formacion/curso/'.$row['IdUnico'].'/'.strtolower(strtr(strtr(strtr($this->eliminar_acentos($row['Programa']), "/", "-"), ":", "-"), " ", "-")).'"><i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>';               
                /*$vHtml .= '<tr>';
                $vHtml .= '<td>'.$row['n_codwebcourses'].'</td>';
                $vHtml .= '<td>'.$row['IdUnico'].'</td>';
                $vHtml .= '<td>'.$row['IdPrograma'].'</td>';
                $vHtml .= '<td>'.$row['Programa'].'</td>';
                $vHtml .= '<td>'.$row['tipo'].'</td>';
                $vHtml .= '<td>'.$row['CargaHoraria'].'</td>';
                $vHtml .= '<td>'.$row['Area'].'</td>';
                $vHtml .= '<td>'.$row['contenido'].'</td>';
                $vHtml .= '<td>'.$row['objetivo'].'</td>';
                $vHtml .= '<td>'.$row['SectorInteres'].'</td>';
                $vHtml .= '<td>'.$row['norma'].'</td>';
                $vHtml .= '</tr>';*/
                
            }
        } else {
            $vHtml .= '<div> Sin Resultados</div>';
        }

        echo json_encode($vHtml, JSON_UNESCAPED_UNICODE);
        //echo json_encode($vHtml);
    }
    public function dataCurrentCourses()
    {
        /*ACCESO A WEB SERVICE CAPACITACION Mod:2020-03-28*/
        //LLAVES DE ACCESO AL WS
        $sIde = "portal";
        $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988";
        /*PARAMETROS PARA LA OBTENCION DE CURSOS*/
        // cambiar esta linea por las opciones
        $parametros = array("sIdentificador" => $sIde, "sKey" => $sKey, "accion" => "ListaCursos", "cursosvigentes" => 1, "registrarlog" => 1); // lista cursos 0=Todos; 1 = Solo vigentes
        $parametros = json_encode($parametros);
        // abrimos la sesión cURL
        $ch = curl_init();
        // definimos la URL a la que hacemos la petición
        curl_setopt($ch, CURLOPT_URL, "http://ibnored.ibnorca.org/wsibno/capacitacion/ws-capacitacion.php");
        // indicamos el tipo de petición: POST
        curl_setopt($ch, CURLOPT_POST, true);
        // definimos cada uno de los parámetros
        curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
        // recibimos la respuesta y la guardamos en una variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec($ch);
        // cerramos la sesión cURL
        curl_close($ch);
        // imprimir en formato JSON
        header('Content-type: application/json');
        //print_r($remote_server_output);

        $this->DataCoursesList = json_decode($remote_server_output, true);
        $vCount = 1;
        foreach ($this->DataCoursesList['cursos'] as $row) {
            $data[] = array(
                "Num" => $vCount,
                "IdUnico" => $row['IdUnico'],
                "IdPrograma" => $row['IdPrograma'],
                "CodigoCurso" => $row['CodigoCurso'],
                "Programa" => $row['Programa'],
                "CantidadModulos" => $row['CantidadModulos'],
                "FechaInicio" => $row['FechaInicio'],
                "Costo" => $row['Costo'],
                "CostoModular" => $row['CostoModular'],
                "tipo" => $row['tipo'],
                "Gestion" => $row['Gestion'],
                "CargaHoraria" => $row['CargaHoraria'],
                "Area" => $row['Area'],
                "contenido" => $row['contenido'],
                "Objetivo" => $row['Objetivo'],
                "SectorInteres" => $row['SectorInteres'],
                "norma" => $row['norma'],
                "Orientado" => $row['Orientado'],
                "Horario" => $row['Horario'],
                "Dias" => $row['Dias'],
                "Modalidad" => $row['Modalidad'],
                "DescripcionModalidad" => $row['DescripcionModalidad'],
                "Responsable" => $row['Responsable'],
                "Descuento" => $row['Descuento'],
                "AlumnosInscritos" => $row['AlumnosInscritos'],
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }

    public function inspectionServicesIbnorca()
    {
        $this->DataIbnorcaInspectionServices = $this->vAPIIbnorcaData->getIbnorcaInspectionServices();
        $vCount = 1;
        foreach ($this->DataIbnorcaInspectionServices as $row) {
            $data[] = array(
                "n_codinspection" => $row['n_codinspection'],
                "n_coduser" => $row['n_coduser'],
                "c_title" => $row['c_title'],
                "c_slogan" => $row['c_slogan'],
                "c_text" => $row['c_text'],
                "n_codwebimage" => $row['n_codwebimage'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate'],
                "c_usermod" => $row['c_usermod'],
                "d_datemod" => $row['d_datemod']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    
    public function inspectionServicesContentIbnorca()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $vCodInspection = (int) $_POST['vCodInspection'];
            $this->DataIbnorcaInspectionContentServices = $this->vAPIIbnorcaData->getIbnorcaInspectionServiceContent($vCodInspection);
            $vCount = 1;
            foreach ($this->DataIbnorcaInspectionContentServices as $row) {
                $data[] = array(
                    "n_codinspectiondesc" => $row['n_codinspectiondesc'],
                    "n_coduser" => $row['n_coduser'],
                    "n_codinspection" => $row['n_codinspection'],
                    "c_title" => $row['c_title'],
                    "c_text" => $row['c_text'],
                    "n_codwebimage" => $row['n_codwebimage'],
                    "n_status" => $row['n_status'],
                    "n_active" => $row['n_active'],
                    "c_usercreate" => $row['c_usercreate'],
                    "d_datecreate" => $row['d_datecreate'],
                    "c_usermod" => $row['c_usermod'],
                    "d_datemod" => $row['d_datemod']
                );
                $vCount++;
            }
    
            $dataset = array(
                "draw" => 1,
                "totalrecords" => count($data),
                "totaldisplayrecords" => count($data),
                "data" => $data,
            );
    
            echo json_encode($dataset);            
        }
    }
    
    public function dataLeadCRMRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $code = (string) $_POST['code'];
            $fullname = (string) $_POST['fullname'];
            $email = (string) $_POST['email'];
            $phone = (string) $_POST['phone'];
            $city = (string) $_POST['city'];
            $country = (string) $_POST['country'];
            $org = (string) $_POST['org'];
            $job = (string) $_POST['job'];
            $media = 'facebook';//(string) $_POST['media'];

            //echo $code.' '.$fullname.' '.$email.' '.$phone.' '.$city.' '.$country.' '.$org.' '.$job.' '.$media;
            //exit;

            if($email == ''){
                echo $email;
            } else {
                $param_postfields = array("code" => $code,"fullname" => $fullname,"email" => $email,"phone" => $phone,"city" => $city,"job" => $job,"media" => $media);
                $param_postfields = json_encode($param_postfields);
                
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'http://intranet.ibnorca.org:8008/api/v1/crm/lead',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>$param_postfields,
                    CURLOPT_HTTPHEADER => array(
                      'api_key: cd77c5d7ef268ea79a4573222258effbd782b358',
                      'Content-Type: application/json'
                    ),
                  ));
                
                //$response = curl_exec($curl);
                curl_exec($curl);
                if (!curl_errno($curl)) {
                    switch ($http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE)) {
                      case 200:
                        echo "success";
                        break;
                      default:
                        echo 'Unexpected HTTP code: ', $http_code, "\n";
                    }
                  }
    
                curl_close($curl);
            }
        }
    }

    public function dataLandingLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $email = (string) $_POST['email'];

            echo $email;
        }
    }    
    
    public function dataListOfStandards()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $vCodeStandard = (string) $_POST['vCodeStandard'];
            $vNroComite = (string) $_POST['vNroComite'];

            if($vCodeStandard == 'All'){
                $this->DataIbnorcaStandardsInDevelopmentByFilter = $this->vAPIIbnorcaData->getIbnorcaStandardizationByNumComite($vNroComite);
                $this->DataIbnorcaPublishedStandardsByFilter = $this->vAPIIbnorcaData->DataIbnorcaStandardizationPublic($vNroComite);
            } else {
                $this->DataIbnorcaStandardsInDevelopmentByFilter = $this->vAPIIbnorcaData->getStandardsInDevelopmentByFilter($vNroComite, $vCodeStandard);
                $this->DataIbnorcaPublishedStandardsByFilter = $this->vAPIIbnorcaData->getPublishedStandardsByFilter($vNroComite, $vCodeStandard);
            }

            $vCount = 1;
            foreach ($this->DataIbnorcaStandardsInDevelopmentByFilter as $row) {
                $vDataIbnorcaStandards .= '<tr>
                                                <th>'.$vCount.'</th>
                                                <td>'.$row['CodigoNomra'].'</td>
                                                <td><a href="'.BASE_VIEW_URL.'normalizacion/norma/'.$row['n_codwebstandardsindevelopment'].'">'.$row['TituloNorma'].'</a></td>
                                                <td>'.$row['estado'].'</td>
                                            </tr>';
                $vCount++;
            }
            foreach ($this->DataIbnorcaPublishedStandardsByFilter as $row) {
                $vDataIbnorcaStandards .= '<tr>
                                                <th>'.$vCount.'</th>
                                                <td>'.$row['codigo'].'</td>
                                                <td><a href="'.BASE_VIEW_URL.'normalizacion/norma/'.$row['n_codwebstandardsindevelopment'].'">'.$row['nombreNorma'].'</a></td>';
                                                
                                                if($row['activa'] == 1){
                                                    $vDataIbnorcaStandards .= '<td>Publicado</td>';
                                                } else {
                                                    $vDataIbnorcaStandards .= '<td>Error</td>';
                                                }

                    $vDataIbnorcaStandards .= '</tr>';
                $vCount++;
            }
            
            echo $vDataIbnorcaStandards;
        }
    }

    public function dataRevisionSistemica()
    {
        $sIde = "portal"; // De acuerdo al sistema
        $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988"; // llave de acuerdo al sistema
        //Lista las normas en elaboracion de un Comite
        $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ListaNormasRevisionSistematica"); 
		$datos=json_encode($parametros);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion-web.php");
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$remote_server_output = curl_exec ($ch);
		curl_close ($ch);
		header('Content-type: application/json'); 	
		print_r($remote_server_output); 	
        exit;

        $this->DataRevisionSistemicaList = json_decode($remote_server_output, true);
        $vCount = 1;
        foreach ($this->DataRevisionSistemicaList['lstNormas'] as $row) {
            $data[] = array(
                "Num" => $vCount,
                "id_revision_normas" => $row['id_revision_normas'],
                "id_revision_sistematica" => $row['id_revision_sistematica'],
                "id_norma" => $row['id_norma'],
                "nombre_norma" => $row['nombre_norma'],
                "estado" => $row['estado'],
                "id_tipo" => $row['id_tipo'],
                "numero" => $row['numero'],
                "id_comite_norma" => $row['id_comite_norma'],
                "tipo" => $row['tipo'],
                "anio" => $row['anio'],
                "FechaFin" => $row['FechaFin'],
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }

    public function dataCatalogoNormas()
    {
        $sIde = "portal"; // De acuerdo al sistema
        $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988"; // llave de acuerdo al sistema
        $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ListaCatalogoNormas"); 

		$datos=json_encode($parametros);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion-web.php");
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$remote_server_output = curl_exec ($ch);
		curl_close ($ch);
		
		header('Content-type: application/json'); 	
		print_r($remote_server_output);
        exit;

        $this->DataCatalogoDeNormasList = json_decode($remote_server_output, true);
        $vCount = 1;
        foreach ($this->DataCatalogoDeNormasList['lstNormas'] as $row) {
            $data[] = array(
                "Num" => $vCount,
                "IdNorma" => $row['IdNorma'],
                "IdComite" => $row['IdComite'],
                "CodigoNorma" => $row['CodigoNorma'],
                "NombreNorma" => $row['NombreNorma'],
                "PalabrasClave" => $row['PalabrasClave'],
                "Alcance" => $row['Alcance'],
                "FechaVigencia" => $row['FechaVigencia'],
                "CantidadHojas" => $row['CantidadHojas'],
                "Observaciones" => $row['Observaciones'],
                "RemplazadaPor" => $row['RemplazadaPor'],
                "NombreSector" => $row['NombreSector'],
                "NombreComite" => $row['NombreComite'],
                "NumeroComite" => $row['NumeroComite'],
                "Adoptada" => $row['Adoptada'],
                "PrecioFisico" => $row['precio_fisico'],
                "PrecioDigital" => $row['precio_digital'],
                "EnWeb" => $row['EnWEB'],
                "CODIGO_ICS" => $row['CODIGO_ICS'],
                "Texto_desstaque" => $row['Texto_desstaque'],
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }

    public function fechaLimiteCurso($vIdUnico)
    {
        echo $this->DataFechaLimiteCurso = $this->vAPIIbnorcaData->getIbnorcaFechaLimiteCurso($vIdUnico);
    }

    public function dataLandingInfo($vIdUnico)
    {
        $vIdUnico = (int) $vIdUnico;
        $this->DataLandingInfo = $this->vAPIIbnorcaData->getDataLandingInfo($vIdUnico);
        $vCount = 1;
        foreach ($this->DataLandingInfo as $row) {
            $data[] = array(
                "Num" => $vCount,
                "n_codlandinginfo" => $row['n_codlandinginfo'],
                "IdUnico" => $row['IdUnico'],
                "t_landingcontent" => $row['t_landingcontent'],
                "n_status" => $row['n_status'],
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }


    public function dataCatalogoICS()
    {
        /*ACCESO A WEB SERVICE LISTA SECTORES, COMITES NORMAS EN ELABORACION
        WS: ws-normalizacion-web.php
        creado:11/01/2024 - 2024-05-28
        */
        //LLAVES DE ACCESO AL WS
        $sIde = "portal"; // De acuerdo al sistema
        $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988"; // llave de acuerdo al sistema
        //METODOS
        //Lista las normas en elaboracion de un Comite
        $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ListaCatalogoICS"); 

		$datos=json_encode($parametros);
		// abrimos la sesión cURL
		$ch = curl_init();
		// definimos la URL a la que hacemos la petición
		curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion-web.php");
		// indicamos el tipo de petición: POST
		curl_setopt($ch, CURLOPT_POST, TRUE);
		// definimos cada uno de los parámetros
		curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
		// recibimos la respuesta y la guardamos en una variable
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$remote_server_output = curl_exec ($ch);
		// cerramos la sesión cURL
		curl_close ($ch);	
		
		header('Content-type: application/json'); 	
		print_r($remote_server_output);
        exit;

        $this->DataCatalogoDeNormasList = json_decode($remote_server_output, true);
        $vCount = 1;
        foreach ($this->DataCatalogoDeNormasList['lstNormas'] as $row) {
            $data[] = array(
                "Num" => $vCount,
                "IdNorma" => $row['IdNorma'],
                "IdComite" => $row['IdComite'],
                "CodigoNorma" => $row['CodigoNorma'],
                "NombreNorma" => $row['NombreNorma'],
                "PalabrasClave" => $row['PalabrasClave'],
                "Alcance" => $row['Alcance'],
                "FechaVigencia" => $row['FechaVigencia'],
                "CantidadHojas" => $row['CantidadHojas'],
                "Observaciones" => $row['Observaciones'],
                "RemplazadaPor" => $row['RemplazadaPor'],
                "NombreSector" => $row['NombreSector'],
                "NombreComite" => $row['NombreComite'],
                "NumeroComite" => $row['NumeroComite'],
                "Adoptada" => $row['Adoptada'],
                "PrecioFisico" => $row['precio_fisico'],
                "PrecioDigital" => $row['precio_digital'],
                "EnWeb" => $row['EnWEB'],
                "CODIGO_ICS" => $row['CODIGO_ICS'],
                "Texto_desstaque" => $row['Texto_desstaque'],
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    
    
    public function dataCatalogoBuscar()
    {
/*ACCESO A WEB SERVICE LISTA SECTORES, COMITES NORMAS EN ELABORACION
WS: ws-normalizacion-web.php
creado:11/01/2024 - 2024-05-28
*/
//LLAVES DE ACCESO AL WS

$sIde = "portal"; // De acuerdo al sistema
$sKey = "02b9eb3fdf8c7ef88209e5f14f00e988"; // llave de acuerdo al sistema

//METODOS

//Lista las normas en elaboracion de un Comite
$parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"BuscarNormaNacional",
					//"CodigoNorma"=>'NB 9001', //busca en el campo codigo
					//"Palabra"=>'NB 9001' // busca en nombre norma, palabra clave, alcance
				); 
	

		$datos=json_encode($parametros);
		// abrimos la sesión cURL
		$ch = curl_init();
		// definimos la URL a la que hacemos la petición
		curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion-web.php");
		//curl_setopt($ch, CURLOPT_URL,"http://localhost/wsibno/normalizacion/ws-normalizacion-web.php");
		// indicamos el tipo de petición: POST
		curl_setopt($ch, CURLOPT_POST, TRUE);
		// definimos cada uno de los parámetros
		curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
		// recibimos la respuesta y la guardamos en una variable
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$remote_server_output = curl_exec ($ch);
		// cerramos la sesión cURL
		curl_close ($ch);	
		
		header('Content-type: application/json'); 	
		print_r($remote_server_output);
        exit;

        /*$this->DataCatalogoDeNormasList = json_decode($remote_server_output, true);
        $vCount = 1;
        foreach ($this->DataCatalogoDeNormasList['lstNormas'] as $row) {
            $data[] = array(
                "Num" => $vCount,
                "IdNorma" => $row['IdNorma'],
                "IdComite" => $row['IdComite'],
                "CodigoNorma" => $row['CodigoNorma'],
                "NombreNorma" => $row['NombreNorma'],
                "PalabrasClave" => $row['PalabrasClave'],
                "Alcance" => $row['Alcance'],
                "FechaVigencia" => $row['FechaVigencia'],
                "CantidadHojas" => $row['CantidadHojas'],
                "Observaciones" => $row['Observaciones'],
                "RemplazadaPor" => $row['RemplazadaPor'],
                "NombreSector" => $row['NombreSector'],
                "NombreComite" => $row['NombreComite'],
                "NumeroComite" => $row['NumeroComite'],
                "Adoptada" => $row['Adoptada'],
                "PrecioFisico" => $row['precio_fisico'],
                "PrecioDigital" => $row['precio_digital'],
                "EnWeb" => $row['EnWEB'],
            );
            $vCount++;
        }*/

        /*$dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);*/
    }    

    /**************************************************/

    public function dataIndexList()
    {
        $this->DataIndexList = $this->vFrontEndData->getDataIndexList();
        $vCount = 1;
        foreach ($this->DataIndexList as $row) {
            $data[] = array(               
                "Num" => $vCount,
                "n_codheader_index" => $row['n_codheader_index'],
                "n_coduser" => $row['n_coduser'],
                "c_title" => $row['c_title'],
                "c_text" => $row['c_text'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    
    
    public function dataIndexSectionServicesList()
    {
        $this->DataIndexSectionServices = $this->vFrontEndData->getDataIndexSectionServicesList();
        $vCount = 1;
        foreach ($this->DataIndexSectionServices as $row) {
            $data[] = array(
                "Num" => $vCount,
                "n_codsection_services" => $row['n_codsection_services'],
                "name_page" => $row['name_page'],
                "c_image_name" => '<img src="https://www.ibnorca.org/views/layout/assets/frontend/img/ibnorca/'.$row['c_image_name'].'" alt="" width="80px">',
                "c_url" => $row['c_url'],
                "c_title" => $row['c_title'],
                "c_text" => $row['c_text'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    
    public function dataIndexDetailList()
    {
        $this->DataIndexDetailList = $this->vFrontEndData->getDataIndexDetailList();
        $vCount = 1;
        foreach ($this->DataIndexDetailList as $row) {
            $data[] = array(
                "Num" => $vCount,
                "n_coddetail_index" => $row['n_coddetail_index'],
                "n_codpage" => $row['n_codpage'],
                "n_coduser" => $row['n_coduser'],
                "c_title" => $row['c_title'],
                "c_text" => $row['c_text'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    
    public function dataIndexBenefitsList()
    {
        $this->DataIndexBenefitsList = $this->vFrontEndData->getDataIndexBenefitsList();
        $vCount = 1;
        foreach ($this->DataIndexBenefitsList as $row) {
            $data[] = array(               
                "Num" => $vCount,
                "n_codbenefits_index" => $row['n_codbenefits_index'],
                "name_page" => $row['name_page'],
                "c_title" => $row['c_title'],
                "c_text" => $row['c_text'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    } 
    
    public function dataIndexServicesList()
    {
        $this->DataIndexServicesList = $this->vFrontEndData->getDataIndexServicesList();
        $vCount = 1;
        foreach ($this->DataIndexServicesList as $row) {
            $data[] = array(   
                "Num" => $vCount,
                "n_codservices_index" => $row['n_codservices_index'],
                "n_codpage" => $row['n_codpage'],
                "name_page" => $row['name_page'],
                "n_codimages" => $row['n_codimages'],
                "c_image_name1" => '<img src="https://www.ibnorca.org/views/layout/assets/frontend/img/ibnorca/'.$row['c_image_name1'].'" alt="" width="80px">',
                "n_codimages2" => $row['n_codimages2'],
                "c_image_name2" => '<img src="https://www.ibnorca.org/views/layout/assets/frontend/img/ibnorca/'.$row['c_image_name2'].'" alt="" width="80px">',
                "c_title" => $row['c_title'],
                "c_header" => $row['c_header'],
                "c_text" => $row['c_text'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    
    public function dataIndexBenefitsServicesList()
    {
        $this->DataIndexBenefitsServicesList = $this->vFrontEndData->getDataIndexBenefitsServicesList();
        $vCount = 1;
        foreach ($this->DataIndexBenefitsServicesList as $row) {
            $data[] = array(   
                "Num" => $vCount,
                "n_codbenefits_services" => $row['n_codbenefits_services'],
                "name_page" => $row['name_page'],
                "n_codservices_index" => $row['n_codservices_index'],
                "c_image_name" => '<img style="background-color: #000 !important;" src="https://www.ibnorca.org/views/layout/assets/frontend/img/ibnorca/'.$row['c_image_name'].'" alt="" width="80px">',
                "c_title" => $row['c_title'],
                "c_text" => $row['c_text'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate'],
                "name_service" => $row['name_service']                
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    
    public function dataIndexServiceAnchoringList()
    {
        $this->DataIndexServiceAnchoringList = $this->vFrontEndData->getDataIndexServiceAnchoringList();
        $vCount = 1;
        foreach ($this->DataIndexServiceAnchoringList as $row) {
            $data[] = array(   
                "Num" => $vCount,
                "n_codserviceanchoring" => $row['n_codserviceanchoring'],
                "name_page" => $row['name_page'],
                "n_codservices_index" => $row['n_codservices_index'],
                "c_image_name" => '<img src="https://www.ibnorca.org/views/layout/assets/frontend/img/ibnorca/'.$row['c_image_name'].'" alt="" width="80px">',
                "c_titulo" => $row['c_titulo'],
                "c_norma" => $row['c_norma'],
                "IdNorma" => $row['IdNorma'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate']           
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }

    public function datatableTitlesList()
    {
        $this->DatatableTitlesList = $this->vFrontEndData->getDatatableTitlesList();
        $vCount = 1;
        foreach ($this->DatatableTitlesList as $row) {
            $data[] = array(   
                "Num" => $vCount,
                "n_codtitle" => $row['n_codtitle'],
                "n_codpage" => $row['n_codpage'],
                "c_title_page" => $row['c_title_page'],
                "n_coduser" => $row['n_coduser'],
                "n_type" => "Sección ".$row['n_type'],
                "c_title_a" => $row['c_title_a'],
                "c_title_b" => $row['c_title_b'],
                "c_text" => $row['c_text'],
                "c_url" => $row['c_url'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    
    public function dataPartnersList()
    {
        $this->DataPartnersList = $this->vFrontEndData->getDataPartnersList();
        $vCount = 1;
        foreach ($this->DataPartnersList as $row) {
            $data[] = array(                  
                "Num" => $vCount,
                "n_codpartners" => $row['n_codpartners'],
                "n_codpage" => $row['n_codpage'],
                "n_coduser" => $row['n_coduser'],
                "n_type" => $row['n_type'],
                "c_url" => $row['c_url'],
                "c_title" => $row['c_title'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    
    public function dataNormasCompletasPorComite($vNumComite)
    {
        $vNumComite = (string) $vNumComite;
        
        $this->NormasCompletasPorComite = $this->vAPIIbnorcaData->getNormasCompletasPorComite($vNumComite);

        $vCount = 1;
        foreach ($this->NormasCompletasPorComite as $row) {
            
            if($row['IdNorma'] == 'N/A'){
                $vURLTienda = BASE_VIEW_URL.'normalizacion/norma/'.$row['c_type'].'/'.$row['n_cod'].'/'.strtolower(strtr(strtr($row['CodigoNomra']," ","-"),"/","-"));
            } else {
                $vURLTienda = BASE_VIEW_URL.'tienda/catalogo/detalle-norma/nb/'.strtolower(strtr($row['CodigoNomra']," ","-")).'-nid='.$row['IdNorma'];
            }

            if($row['estado'] == 'Aprobada'){
                $vEstado = 'Por Publicar';
            } else {
                $vEstado = $row['estado'];
            }

            $data[] = array(                  
                "Num" => $vCount,
                "CodigoSearch" => 'norma-'.$row['c_type'],
                "CodigoNomra" => '<strong>'.$row['CodigoNomra'].'</strong><br>'.$row['TituloNorma'],
                "estado" => $vEstado,
                "url" => '<a href="'.$vURLTienda.'" class="thm-btn-ibnorca" target="_blank">Ver</a>',
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }

    public function dataSorterList()
    {
        $this->DataSorterList = $this->vFrontEndData->getDataSorterList();
        $vCount = 1;
        foreach ($this->DataSorterList as $row) {
            $data[] = array(                  
                "Num" => $vCount,
                "n_codsorter" => $row['n_codsorter'],
                "n_coduser" => $row['n_coduser'],
                "n_idclasificador" => $row['n_idclasificador'],
                "c_descripcion" => $row['c_descripcion'],
                "n_idpadre" => $row['n_idpadre'],
                "c_abrev" => $row['c_abrev'],
                "n_order" => $row['n_order'],
                "n_codimages_ico" => $row['n_codimages_ico'],
                "n_codimages" => $row['n_codimages'],
                "c_nameweb" => $row['c_nameweb'],
                "c_textweb" => $row['c_textweb'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    
    public function dataCoursesWebList()
    {
        $this->DataCoursesWebList = $this->vFrontEndData->getDataCoursesWebList();
        $vCount = 1;
        foreach ($this->DataCoursesWebList as $row) {
            $data[] = array(                  
                "Num" => $vCount,
                "n_codcourses" => $row['n_codcourses'],
                "n_idclasificador" => $row['n_idclasificador'],
                "n_coduser" => $row['n_coduser'],                
                "IdUnico" => $row['IdUnico'],
                "d_datecourse" => $row['d_datecourse'],
                "n_codimages" => $row['n_codimages'],
                "c_title" => $row['c_title'],
                "c_text" => $row['c_text'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    
    public function dataServiceServicesAnchoringList()
    {
        $this->DataServiceServicesAnchoringList = $this->vFrontEndData->getDataServiceServicesAnchoringList();
        $vCount = 1;
        foreach ($this->DataServiceServicesAnchoringList as $row) {
            $data[] = array(   
                "Num" => $vCount,
                "n_codservices_anchoring" => $row['n_codservices_anchoring'],
                "n_codservices_index" => $row['n_codservices_index'],
                "n_nameservice" => $row['n_nameservice'],
                "c_image_name" => '<img src="https://www.ibnorca.org/views/layout/assets/frontend/img/ibnorca/'.$row['c_image_name'].'" alt="" width="80px">',
                "IdNorma" => $row['IdNorma'],
                "CodigoNorma" => $row['CodigoNorma'],
                "IdUnico" => $row['IdUnico'],
                "Programa" => $row['Programa'],
                "n_codservices_index2" => $row['n_codservices_index2'],
                "n_nameservice2" => $row['n_nameservice2'],
                "FechaInicio" => $row['FechaInicio'],
                "n_status" => $row['n_status'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    
    public function dataNewsList()
    {
        $this->DataNewsList = $this->vFrontEndData->getDataNewsList();
        $vCount = 1;
        foreach ($this->DataNewsList as $row) {
            $data[] = array(   
                "Num" => $vCount,
                "n_codnews" => $row['n_codnews'],
                "n_coduser" => $row['n_coduser'],
                "n_codimages" => $row['n_codimages'],
                "c_title" => $row['c_title'],
                "c_text" => $row['c_text'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    
    public function dataFormSendEmail()
    {
        session_start();

        $sIde = "portal";
        $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988";

        /*$names = (string) $_POST['names'];
        $lastnames = (string) $_POST['lastnames'];
        $email = (string) $_POST['email'];
        $country = (string) $_POST['country'];
        $city = (string) $_POST['city'];
        $whatsapp = (string) $_POST['whatsapp'];
        $business = (string) $_POST['business'];
        $subject = (string) $_POST['subject'];
        $sendfor = (string) $_POST['sendfor'];
        $message = (string) $_POST['message'];*/

        $names = isset($_POST['names']) ? $_POST['names'] : '';
        $lastnames = isset($_POST['lastnames']) ? $_POST['lastnames'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $country = isset($_POST['country']) ? $_POST['country'] : '';
        $city = isset($_POST['city']) ? $_POST['city'] : '';
        $whatsapp = isset($_POST['whatsapp']) ? $_POST['whatsapp'] : '';
        $business = isset($_POST['business']) ? $_POST['business'] : '';
        $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
        $sendfor = isset($_POST['sendfor']) ? $_POST['sendfor'] : '';
        $message = isset($_POST['message']) ? $_POST['message'] : '';

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $vCaptcha = (string) $_POST['codigo'];
            $codigoVerificacion = isset($_SESSION['codigo_verificacion']) ? $_SESSION['codigo_verificacion'] : '';
            
            if(empty($email) || empty($lastnames) || empty($country) || empty($city) || empty($whatsapp) || empty($business) || empty($subject) || empty($sendfor) || empty($message)){
                echo 'required-fields-error';
            } else {
                if ($codigoVerificacion !== sha1($vCaptcha)) {
                    $_SESSION['codigo_verificacion'] = '';
                    echo 'captcha-error';
                } else {
                    $asunto = $subject.', '.$sendfor;
                    //$message = $email.' - '.$country.' - '.$city.' - '.$whatsapp.' - '.$business.' - '.$subject.' - '.$sendfor.' - '.$message;
                    $message = '<p><strong>Mensaje recibido del <strong>Formulario de Contacto ibnorca.org</strong></p>
                                <p>Los siguientes datos han sido proporcionados por el usuario:</p>
                                <ul>
                                    <li><strong>Nombre Completo: </strong>'.$names.' '.$lastnames.'</li>
                                    <li><strong>Correo Electrónico: </strong>'.$email.'</li>
                                    <li><strong>País: </strong>'.$country.'</li>
                                    <li><strong>Ciudad: </strong>'.$city.'</li>
                                    <li><strong>Whatsapp: </strong>'.$whatsapp.'</li>
                                    <li><strong>Organización/Empresa: </strong>'.$business.'</li>
                                    <li><strong>Motivo: </strong>'.$subject.'</li>
                                    <li><strong>Área de Consulta: </strong>'.$sendfor.'</li>
                                    <li><strong>Mensaje: </strong>'.$message.'</li>
                                </ul>
                                <p>Por favor no te olvides deribar la información a quién corresponda</p>
                                <p>Saludos!</p>';
        
                    $datos          = array("sIdentificador"=> $sIde,
                                            "sKey"          => $sKey,
                                            "accion"        => "EnviarCorreoCtaIbnoredWEB",
                                            "NombreEnvia"   => $names.' '.$lastnames, // cambiar
                                            "CorreoDestino" => "info@ibnorca.org",
                                            "NombreDestino" => 'Formulario Contacto Portal IBNORCA',
                                            "Asunto"        => $asunto,
                                            "Body"          => $message);
        
                    $datos = json_encode($datos);       
                    $ch    = curl_init();
                    curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/correo/ws-correotoken.php");
                    curl_setopt($ch, CURLOPT_POST, TRUE);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $remote_server_output = curl_exec ($ch);
                    curl_close ($ch);	  
                    
                    echo 'success';
                }            
            }
          } else {
            echo 'required-email-error';
          }
    }

    public function dataFormReplyEmail()
    {
        $sIde = "portal";
        $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988";

        $names = (string) $_POST['names'];
        $lastnames = (string) $_POST['lastnames'];
        $email = (string) $_POST['email'];
        //$country = (string) $_POST['country'];
        //$city = (string) $_POST['city'];
        //$whatsapp = (string) $_POST['whatsapp'];
        //$business = (string) $_POST['business'];
        //$subject = (string) $_POST['subject'];
        //$sendfor = (string) $_POST['sendfor'];
        //$message = (string) $_POST['message'];

        //echo $names.' - '.$lastnames.' - '.$email.' - '.$country.' - '.$city.' - '.$whatsapp.' - '.$business.' - '.$subject.' - '.$sendfor.' - '.$message;
        //exit;

        $asunto = $names.' '.$lastnames.', hemos recibido tu mensaje';
        //$message = $names.' '.$lastnames.', gracias por comunicarte con nosotros, uno de nuestros asesores se comunicará contigo lo más rápido posible para responder a tu mensaje.';
        $message = '<p><strong>'.$names.' '.$lastnames.'</strong></p>
                    <p>Gracias por comunicarte con <strong>IBNORCA</strong>, muy pronto uno de nuestros asesores se comunicará contigo para responder a tu mensaje y brindarte toda la ayuda que solicitas.</p>
                    <p>Te invitamos a que sigas consultando información en nuestro sitio web, ingresando a los siguientes enlaces:</p>
                    <ul>
                        <li>Si quieres conocer más sobre nosotros visita <a href="https://www.ibnorca.org/nosotros" target="_blank">Nuestra Trayectoria</a></li>
                        <li>Encuentra información sobre <a href="http://normalizacion.ibnorca.org:1010/?/misc/login/" target="_blank">Normas</a> y <a href="https://www.ibnorca.org/normalizacion/comitesDeNormalizacion" target="_blank">Comités Técnicos de Normalización</a></li>
                        <li>¿Buscas capacitación? Te invitamos a conocer <a href="https://www.ibnorca.org/soluciones/formacion" target="_blank">Nuestra Oferta Académica</a></li>
                    </ul>
                    <p>Sigue en contacto con <strong>IBNORCA</strong> visita <a href="https://www.ibnorca.org/novedades/noticias" target="_blank">Noticias y Eventos</a>, tambien puedes <a href="https://www.ibnorca.org/novedades/podcast" target="_blank">Podcast</a></p>';

        //$asunto = "Prueba de Web Service Web 2.0";
        //$message = "Este es un mensaje para la web 2.0";        

        $datos          = array("sIdentificador"=> $sIde,
                                "sKey"          => $sKey,
                                "accion"        => "EnviarCorreoCtaIbnoredWEB",
                                "NombreEnvia"   => "Portal WEB IBNORCA", // cambiar
                                "CorreoDestino" => $email,
                                "NombreDestino" => $names.' '.$lastnames,
                                "Asunto"        => $asunto,
                                "Body"          => $message);

        $datos = json_encode($datos);       
        $ch    = curl_init();
        curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/correo/ws-correotoken.php");
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$remote_server_output = curl_exec ($ch);
		curl_close ($ch);	
		
		//header('Content-type: application/json'); 	
		//print_r($remote_server_output);
        //exit;      
        
        echo 'success';
    }

    public function dataKeywordsList()
    {
        $this->DataKeywordsList = $this->vFrontEndData->getDataKeywordsList();
        $vCount = 1;
        foreach ($this->DataKeywordsList as $row) {
            $data[] = array(               
                "Num" => $vCount,
                "n_codkeywords" => $row['n_codkeywords'],
                "n_coduser" => $row['n_coduser'],
                "n_codpage" => $row['n_codpage'],
                "c_text" => $row['c_text'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }

    public function dataDescriptionSEOList()
    {
        $this->DataDescriptionSEOList = $this->vFrontEndData->getDataDescriptionSEOList();
        $vCount = 1;
        foreach ($this->DataDescriptionSEOList as $row) {
            $data[] = array(               
                "Num" => $vCount,
                "n_coddescriptionseo" => $row['n_coddescriptionseo'],
                "n_coduser" => $row['n_coduser'],
                "n_codpage" => $row['n_codpage'],
                "c_text" => $row['c_text'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    
    public function dataRegistrationProcessList()
    {
        $this->DataRegistrationProcessList = $this->vFrontEndData->getDataRegistrationProcessList();
        $vCount = 1;
        foreach ($this->DataRegistrationProcessList as $row) {
            $data[] = array(               
                "Num" => $vCount,
                "n_codregistrationprocess" => $row['n_codregistrationprocess'],
                "n_coduser" => $row['n_coduser'],
                "c_title" => $row['c_title'],
                "c_text" => $row['c_text'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    
    public function dataTestimonialsList()
    {
        $this->DataTestimonialsList = $this->vFrontEndData->getDataTestimonialsList();
        $vCount = 1;
        foreach ($this->DataTestimonialsList as $row) {
            $data[] = array(               
                "Num" => $vCount,
                "n_codtestimonials" => $row['n_codtestimonials'],
                "n_coduser" => $row['n_coduser'],
                "c_name" => $row['c_name'],
                "c_business" => $row['c_business'],
                "c_text" => $row['c_text'],
                "c_url" => $row['c_url'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }
    
    public function dataLandingDiscountsList()
    {
        $this->DataLandingDiscountsList = $this->vAPIIbnorcaData->getDataLandingDiscountsList();
        $vCount = 1;
        foreach ($this->DataLandingDiscountsList as $row) {
            $data[] = array(               
                "Num" => $vCount,
                "n_codlandingdiscounts" => $row['n_codlandingdiscounts'],
                "n_coduser" => $row['n_coduser'],
                "IdUnico" => $row['IdUnico'],
                "n_type" => $row['n_type'],
                "c_text" => $row['c_text'],
                "n_status" => $row['n_status'],
                "n_active" => $row['n_active'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    } 
    
    public function dataSectorRelationshipList()
    {
        $this->DataSectorRelationship = $this->vFrontEndData->getDataSectorRelationship();
        $vCount = 1;
        foreach ($this->DataSectorRelationship as $row) {
            $data[] = array(               
                "Num" => $vCount,
                "n_codsectorgroup" => $row['n_codsectorgroup'],
                "n_codsector" => $row['n_codsector'],
                "CodigoNorma" => $row['CodigoNorma'],
                "nombreNorma" => $row['nombreNorma'],
                "IdUnico" => $row['IdUnico'],
                "Programa" => $row['Programa'],
                "n_codservices_index" => $row['n_codservices_index'],
                "c_title_service" => $row['c_title_service'],
                "n_status" => $row['n_status'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }

    public function dataModalActive()
    {
        echo $this->DataModalActive = $this->vFrontEndData->getModalActive();
    }

    public function dataModalContent()
    {
        $this->DataModalContent = $this->vFrontEndData->getModalContent();
        for($i=0;$i<count($this->DataModalContent);$i++):
            $vTitle = $this->DataModalContent[$i]['c_title'];
            $vText = $this->DataModalContent[$i]['c_text'];
        endfor;
        echo '<h2 class="mt-3 mb-5" style="text-align: center !important;">'.$vTitle.'</h2><span>'.$vText.'</span>';
    }

    public function dataAdvertisementList()
    {
        $this->DataAdvertisementList = $this->vFrontEndData->getDataAdvertisementList();
        $vCount = 1;
        foreach ($this->DataAdvertisementList as $row) {
            $data[] = array(               
                "Num" => $vCount,
                "n_codadvertisement" => $row['n_codadvertisement'],
                "n_coduser" => $row['n_coduser'],
                "c_title" => $row['c_title'],
                "c_text" => $row['c_text'],
                "d_dateini" => $row['d_dateini'],
                "d_dateend" => $row['d_dateend'],
                "n_status" => $row['n_status'],
                "c_usercreate" => $row['c_usercreate'],
                "d_datecreate" => $row['d_datecreate']
            );
            $vCount++;
        }

        $dataset = array(
            "draw" => 1,
            "totalrecords" => count($data),
            "totaldisplayrecords" => count($data),
            "data" => $data,
        );

        echo json_encode($dataset);
    }


    public function dataFormServiceSendEmail()
    {
        session_start();

        $sIde = "portal";
        $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988";

        /*$names = (string) $_POST['names'];
        $lastnames = (string) $_POST['lastnames'];
        $email = (string) $_POST['email'];
        $country = (string) $_POST['country'];
        $city = (string) $_POST['city'];
        $whatsapp = (string) $_POST['whatsapp'];
        $business = (string) $_POST['business'];
        $subject = (string) $_POST['subject'];
        $sendfor = (string) $_POST['sendfor'];
        $message = (string) $_POST['message'];*/

        $names = isset($_POST['names']) ? $_POST['names'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $business = isset($_POST['business']) ? $_POST['business'] : '';
        $whatsapp = isset($_POST['phone']) ? $_POST['phone'] : '';
        $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
        $message = isset($_POST['message']) ? $_POST['message'] : '';

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

            $vCaptcha = (string) $_POST['codigo'];
            $codigoVerificacion = isset($_SESSION['codigo_verificacion']) ? $_SESSION['codigo_verificacion'] : '';
            
            if(empty($email) || empty($names) || empty($whatsapp) || empty($business) || empty($subject) || empty($message)){
                echo 'required-fields-error';
            } else {
                if ($codigoVerificacion !== sha1($vCaptcha)) {
                    $_SESSION['codigo_verificacion'] = '';
                    echo 'captcha-error';
                } else {
                    $asunto = $subject;
                    //$message = $email.' - '.$country.' - '.$city.' - '.$whatsapp.' - '.$business.' - '.$subject.' - '.$sendfor.' - '.$message;
                    $message = '<p><strong>Mensaje recibido del <strong>Formulario de Contacto ibnorca.org</strong></p>
                                <p>Los siguientes datos han sido proporcionados por el usuario:</p>
                                <ul>
                                    <li><strong>Nombre Completo: </strong>'.$names.'</li>
                                    <li><strong>Correo Electrónico: </strong>'.$email.'</li>
                                    <li><strong>Whatsapp: </strong>'.$whatsapp.'</li>
                                    <li><strong>Organización/Empresa: </strong>'.$business.'</li>
                                    <li><strong>Motivo: </strong>'.$subject.'</li>
                                    <li><strong>Mensaje: </strong>'.$message.'</li>
                                </ul>
                                <p>Por favor no te olvides deribar la información a quién corresponda</p>
                                <p>Saludos!</p>';
        
                    $datos          = array("sIdentificador"=> $sIde,
                                            "sKey"          => $sKey,
                                            "accion"        => "EnviarCorreoCtaIbnoredWEB",
                                            "NombreEnvia"   => $names, // cambiar
                                            "CorreoDestino" => "info@ibnorca.org",
                                            "NombreDestino" => 'Formulario Contacto Portal IBNORCA',
                                            "Asunto"        => $asunto,
                                            "Body"          => $message);
        
                    $datos = json_encode($datos);       
                    $ch    = curl_init();
                    curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/correo/ws-correotoken.php");
                    curl_setopt($ch, CURLOPT_POST, TRUE);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $remote_server_output = curl_exec ($ch);
                    curl_close ($ch);	  
                    
                    echo 'success';
                }            
            }
          } else {
            echo 'required-email-error';
          }
    }

    public function dataFormServiceReplyEmail()
    {
        $sIde = "portal";
        $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988";

        $names = (string) $_POST['names'];
        $email = (string) $_POST['email'];
        //$country = (string) $_POST['country'];
        //$city = (string) $_POST['city'];
        //$whatsapp = (string) $_POST['whatsapp'];
        //$business = (string) $_POST['business'];
        //$subject = (string) $_POST['subject'];
        //$sendfor = (string) $_POST['sendfor'];
        //$message = (string) $_POST['message'];

        //echo $names.' - '.$lastnames.' - '.$email.' - '.$country.' - '.$city.' - '.$whatsapp.' - '.$business.' - '.$subject.' - '.$sendfor.' - '.$message;
        //exit;

        $asunto = $names.', hemos recibido tu mensaje';
        //$message = $names.' '.$lastnames.', gracias por comunicarte con nosotros, uno de nuestros asesores se comunicará contigo lo más rápido posible para responder a tu mensaje.';
        $message = '<p><strong>'.$names.'</strong></p>
                    <p>Gracias por comunicarte con <strong>IBNORCA</strong>, muy pronto uno de nuestros asesores se comunicará contigo para responder a tu mensaje y brindarte toda la ayuda que solicitas.</p>
                    <p>Te invitamos a que sigas consultando información en nuestro sitio web, ingresando a los siguientes enlaces:</p>
                    <ul>
                        <li>Si quieres conocer más sobre nosotros visita <a href="https://www.ibnorca.org/nosotros" target="_blank">Nuestra Trayectoria</a></li>
                        <li>Encuentra información sobre <a href="http://normalizacion.ibnorca.org:1010/?/misc/login/" target="_blank">Normas</a> y <a href="https://www.ibnorca.org/normalizacion/comitesDeNormalizacion" target="_blank">Comités Técnicos de Normalización</a></li>
                        <li>¿Buscas capacitación? Te invitamos a conocer <a href="https://www.ibnorca.org/soluciones/formacion" target="_blank">Nuestra Oferta Académica</a></li>
                    </ul>
                    <p>Sigue en contacto con <strong>IBNORCA</strong> visita <a href="https://www.ibnorca.org/novedades/noticias" target="_blank">Noticias y Eventos</a>, tambien puedes <a href="https://www.ibnorca.org/novedades/podcast" target="_blank">Podcast</a></p>';

        //$asunto = "Prueba de Web Service Web 2.0";
        //$message = "Este es un mensaje para la web 2.0";        

        $datos          = array("sIdentificador"=> $sIde,
                                "sKey"          => $sKey,
                                "accion"        => "EnviarCorreoCtaIbnoredWEB",
                                "NombreEnvia"   => "Portal WEB IBNORCA", // cambiar
                                "CorreoDestino" => $email,
                                "NombreDestino" => $names,
                                "Asunto"        => $asunto,
                                "Body"          => $message);

        $datos = json_encode($datos);       
        $ch    = curl_init();
        curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/correo/ws-correotoken.php");
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$remote_server_output = curl_exec ($ch);
		curl_close ($ch);	
		
		//header('Content-type: application/json'); 	
		//print_r($remote_server_output);
        //exit;      
        
        echo 'success';
    }

    public function dataGeolocalizacion(){

        $this->getLibrary('geoplugin.class');
        $this->vGeoPluginVar = new geoPlugin;
         
        $this->vGeoPluginVar->locate();
         
        echo "Geolocation results for {$this->vGeoPluginVar->ip}: <br />\n".
            "City: {$this->vGeoPluginVar->city} <br />\n".
            "Region: {$this->vGeoPluginVar->region} <br />\n".
            "Region Code: {$this->vGeoPluginVar->regionCode} <br />\n".
            "Region Name: {$this->vGeoPluginVar->regionName} <br />\n".
            "DMA Code: {$this->vGeoPluginVar->dmaCode} <br />\n".
            "Country Name: {$this->vGeoPluginVar->countryName} <br />\n".
            "Country Code: {$this->vGeoPluginVar->countryCode} <br />\n".
            "In the EU?: {$this->vGeoPluginVar->inEU} <br />\n".
            "EU VAT Rate: {$this->vGeoPluginVar->euVATrate} <br />\n".
            "Latitude: {$this->vGeoPluginVar->latitude} <br />\n".
            "Longitude: {$this->vGeoPluginVar->longitude} <br />\n".
            "Radius of Accuracy (Miles): {$this->vGeoPluginVar->locationAccuracyRadius} <br />\n".
            "Timezone: {$this->vGeoPluginVar->timezone} <br />\n".
            "Currency Code: {$this->vGeoPluginVar->currencyCode} <br />\n".
            "Currency Symbol: {$this->vGeoPluginVar->currencySymbol} <br />\n".
            "Exchange Rate: {$this->vGeoPluginVar->currencyConverter} <br />\n";
         
        if ( $this->vGeoPluginVar->currency != $this->vGeoPluginVar->currencyCode ) {
            //our visitor is not using the same currency as the base currency
            echo "<p>At todays rate, US$100 will cost you " . $this->vGeoPluginVar->convert(100) ." </p>\n";
        }
         
        /* find places nearby */
        $nearby = $this->vGeoPluginVar->nearby();
        if ( isset($nearby[0]['geoplugin_place']) ) {
            echo "<pre><p>Some places you may wish to visit near " . $this->vGeoPluginVar->city . ": </p>\n";
            foreach ( $nearby as $key => $array ) {
         
                echo ($key + 1) .":<br />";
                echo "\t Place: " . $array['geoplugin_place'] . "<br />";
                echo "\t Country Code: " . $array['geoplugin_countryCode'] . "<br />";
                echo "\t Region: " . $array['geoplugin_region'] . "<br />";
                echo "\t County: " . $array['geoplugin_county'] . "<br />";
                echo "\t Latitude: " . $array['geoplugin_latitude'] . "<br />";
                echo "\t Longitude: " . $array['geoplugin_longitude'] . "<br />";
                echo "\t Distance (miles): " . $array['geoplugin_distanceMiles'] . "<br />";
                echo "\t Distance (km): " . $array['geoplugin_distanceKilometers'] . "<br />";
         
            }
            echo "</pre>\n";
        }
    }

    public function dataWebServicesUpdate(){

        $vCurrentDate = date('Y-m-d');
        
        /************* insertIbnorcaCourses ********************/
        $this->DataWebServicesUpdateLogCourses = $this->vAPIIbnorcaData->getDataWebServicesUpdateLog('insertIbnorcaCourses', $vCurrentDate);
        if($this->DataWebServicesUpdateLogCourses == 0){
            //echo "No se encontró ningún registro con la fecha $vCurrentDate.";
            $vTable = 'tb_ibnc_web_courses';
            if($this->vAPIIbnorcaData->truncateTable($vTable) === TRUE){
    
                $sIde = "portal";
                $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988";
                $parametros = array("sIdentificador" => $sIde, "sKey" => $sKey, "accion" => "ListaCursos", "cursosvigentes" => 1, "registrarlog" => 1); // lista cursos 0=Todos; 1 = Solo vigentes
                $parametros = json_encode($parametros);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, "http://ibnored.ibnorca.org/wsibno/capacitacion/ws-capacitacion.php");
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $remote_server_output = curl_exec($ch);
                curl_close($ch);
    
                $this->DataCoursesList = json_decode($remote_server_output, true);
                $vCount = 1;
                foreach ($this->DataCoursesList['cursos'] as $row) {
                        $vIdUnico = $row['IdUnico'];
                        $vIdCurso = $row['IdCurso'];
                        $vIdPrograma = $row['IdPrograma'];
                        $vCodigoCurso = $row['CodigoCurso'];
                        $vPrograma = $row['Programa'];
                        $vCantidadModulos = $row['CantidadModulos'];
                        $vFechaInicio = $row['FechaInicio'];
                        $vCosto = $row['Costo'];
                        $vCostoModular = $row['CostoModular'];
                        $vIdTipo = $row['IdTipo'];
                        $vtipo = $row['tipo'];
                        $vIdOficina = $row['IdOficina'];
                        $vOficina = $row['Oficina'];
                        $vIdGestion = $row['IdGestion'];
                        $vGestion = $row['Gestion'];
                        $vCargaHoraria = $row['CargaHoraria'];
                        $vHorasModulo = $row['horas_modulo'];
                        $vIdArea = $row['IdArea'];
                        $vArea = $row['Area'];
                        $vIdImagenCurso = $row['IdImagenCurso'];
                        $vUrlImagenCurso = $row['UrlImagenCurso'];
                        $vcontenido = $row['contenido'];
                        $vobjetivo = $row['Objetivo'];
                        $vIdSectorInteres = $row['IdSectorInteres'];
                        $vSectorInteres = $row['SectorInteres'];
                        $vUrlImagenSector = $row['UrlImagenSector'];
                        $vnorma = $row['norma'];
                        $vOrientado = $row['Orientado'];
                        $vHorario = $row['Horario'];
                        $vDias = $row['Dias'];
                        $vIdModalidad = $row['IdModalidad'];
                        $vModalidad = $row['Modalidad'];
                        $vDescripcionModalidad = $row['DescripcionModalidad'];
                        $vResponsable = $row['Responsable'];
                        $vDescuento = $row['Descuento'];
                        $vPorcenDescuento = $row['PorcenDescuento'];
                        $vDescuentoGrupo = $row['DescuentoGrupo'];
                        $vPorcenDescuentoGrupo = $row['PorcenDescuentoGrupo'];
                        $vLink = $row['Link'];
                        $vAlumnosInscritos = $row['AlumnosInscritos'];
                        $vCostoSUS = $row['CostoSUS'];
                        $vCostoModularSUS = $row['CostoModularSUS'];
    
                        $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
    
                        if ($vCodigoCurso == 'OV-PFISGC-PFA-G1-2024') {
                            $vStatus = 0;
                        } else {
                            $vStatus = 1;
                        }                   
    
                        
                        $vActive = 1;
            
                        $vCodWebCourses = $this->vAPIIbnorcaData->insertIbnorcaCourses($vUserCode,$vIdUnico,$vIdCurso,$vIdPrograma,$vCodigoCurso,$vPrograma,$vCantidadModulos,$vFechaInicio,$vCosto,$vCostoModular,$vIdTipo,$vtipo,$vIdOficina,$vOficina,$vIdGestion,$vGestion,$vCargaHoraria,$vHorasModulo,$vIdArea,$vArea,$vIdImagenCurso,$vUrlImagenCurso,$vcontenido,$vobjetivo,$vIdSectorInteres,$vSectorInteres,$vUrlImagenSector,$vnorma,$vOrientado,$vHorario,$vDias,$vIdModalidad,$vModalidad,$vDescripcionModalidad,$vResponsable,$vDescuento,$vPorcenDescuento,$vDescuentoGrupo,$vPorcenDescuentoGrupo,$vLink,$vAlumnosInscritos,$vCostoSUS,$vCostoModularSUS,$vStatus,$vActive);                
                    }            
    
                    /* CONTROL LOG ACTION */
                    $vAction = 'execute';
                    $vMethod = 'insertIbnorcaCourses';
                    $this->vCtrl->insertLogAction($vAction, $vMethod);
            }
        }
        /************* insertIbnorcaCourses ********************/

        /************* insertMalla ********************/
        $this->DataWebServicesUpdateLogMalla = $this->vAPIIbnorcaData->getDataWebServicesUpdateLog('insertMalla', $vCurrentDate);
        if($this->DataWebServicesUpdateLogMalla == 0){
            //echo "No se encontró ningún registro con la fecha $vCurrentDate.";            
            $vTable = 'tb_ibnc_web_malla';
            if($this->vAPIIbnorcaData->truncateTable($vTable) === TRUE){              
            
                $sIde = "portal";
                $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988";
                $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ListarMalla"); 

                $parametros=json_encode($parametros);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/capacitacion/ws-capacitacion.php"); 
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $remote_server_output = curl_exec ($ch);
                curl_close ($ch);
            
                $this->DataCapacitacionList = json_decode($remote_server_output, true);

                foreach ($this->DataCapacitacionList['lstMalla'] as $row) {
                        $idmalla = $row['idmalla'];
                        $idtipo = $row['idtipo'];
                        $IdCurso = $row['IdCurso'];
                        $idmodulo = $row['idmodulo'];
                        $FechaMalla = $row['FechaMalla'];
                        $d_tipo = $row['d_tipo'];
                        $Programa = $row['Programa'];
                        $Codigo = $row['Codigo'];
                        $d_modulo = $row['d_modulo'];
                        $nivel = $row['nivel'];
                        $Objetivo = $row['Objetivo'];
                        $Contenido = $row['Contenido'];
                        $CodigoNorma = $row['CodigoNorma'];
                        $NombreNorma = $row['NombreNorma'];
                        $TipoNorma = $row['TipoNorma'];
                        $d_Area = $row['d_Area'];
        
                        $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
                        $vStatus = 1;
                        $vActive = 1;
            
                        $vCodMembers = $this->vAPIIbnorcaData->insertMalla($vUserCode,$idmalla,$idtipo,$IdCurso,$idmodulo,$FechaMalla,$d_tipo,$Programa,$Codigo,$d_modulo,$nivel,$Objetivo,$Contenido,$CodigoNorma,$NombreNorma,$TipoNorma,$d_Area,$vStatus,$vActive);
                    }            

                /* CONTROL LOG ACTION */
                $vAction = 'execute';
                $vMethod = 'insertMalla';
                $this->vCtrl->insertLogAction($vAction, $vMethod);
            }
        }
        /************* insertMalla ********************/        
    }    
}
