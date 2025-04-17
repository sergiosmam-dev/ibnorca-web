<?Php

class insertController extends IdEnController
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
        $this->vPrivilegeData = $this->LoadModel('privilege');
        $this->vModuleData = $this->LoadModel('module');
        $this->vAPIIbnorcaData = $this->LoadModel('apiibnorca');
        $this->vFrontEndData = $this->LoadModel('frontend');

        $this->vView->vSubNavContent = '';


        /**********************************/
        /* BEGIN AUTHENTICATE USER ACTIVE */
        /**********************************/
    }

    public function index()
    {
        $this->vView->visualize('index');
    }

    public function insertIbnorcaStandardizationV2()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $vTable = 'tb_ibnc_web_standardization';
            if($this->vAPIIbnorcaData->truncateTable($vTable) === TRUE){
                $sIde = "portal"; // De acuerdo al sistema
                $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988"; // llave de acuerdo al sistema
                $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ListaNormasElastic");
                $datos=json_encode($parametros);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion-web.php");
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $remote_server_output = curl_exec ($ch);
                curl_close ($ch);
                $this->DataStandardizationListNodeA = json_decode($remote_server_output, true);
                $this->DataStandardizationListNodeB = json_decode(json_encode($this->DataStandardizationListNodeA['hits']), true);
                $this->DataStandardizationListNodeC = $this->DataStandardizationListNodeB['hits'];
                
                foreach ($this->DataStandardizationListNodeC as $row) {
        
                        $vIndex = $row['_index'];
                        $vType = $row['_type'];
                        $vId = $row['_id'];
                        $vScore = $row['_score'];
                        $vPrecio = $row['_source']['precio'];
                        $vCodigo = $row['_source']['codigo'];
                        $vPrecioDigital = $row['_source']['precioDigital'];
                        $vNombreComite = $row['_source']['nombreComite'];
                        $vVigente = $row['_source']['vigente'];
                        $vPrecioFisico = $row['_source']['precioFisico'];
                        $vIdSector = $row['_source']['idSector'];
                        $vNumeroComite = $row['_source']['numerocomite'];
                        $vActiva = $row['_source']['activa'];
                        $vNombreNorma = $row['_source']['nombreNorma'];
                        $vNombreSector = $row['_source']['nombreSector'];
                        $vAlcance = $row['_source']['alcance'];
                        $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
                        $vStatus = 1;
                        $vActive = 1;
            
                        $vCodStandardization = $this->vAPIIbnorcaData->insertIbnorcaStandardization($vUserCode,$vIndex,$vType,$vId,$vScore,$vPrecio,$vCodigo,$vPrecioDigital,$vNombreComite,$vVigente,$vPrecioFisico,$vIdSector,$vNumeroComite,$vActiva,$vNombreNorma,$vNombreSector,$vAlcance,$vStatus,$vActive);
                    }
                    echo 'success';
            }            
        }
    }
     public function insertIbnorcaStandardization()
        {        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            echo $curl = curl_init();
        
            echo curl_setopt_array($curl, array(
              CURLOPT_URL => 'http://normalizacion.ibnorca.org:4721/ibnored-normas/_search/?size=3300&q=web%3A1%20AND%20vigente%3A1%20AND%20activa%3A1&_source=codigo%2CidSector%2CnombreSector%2Cnumerocomite%2CnombreComite%2CnombreNorma%2Calcance%2Cprecio%2CprecioDigital%2CprecioFisico%2Cvigente%2Cactiva%2Cweb%20',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_SSL_VERIFYHOST => 0,// don't verify ssl
              CURLOPT_SSL_VERIFYPEER => false,//
            ));
            
            $remote_server_output = curl_exec($curl);
            $this->DataStandardizationListNodeA = json_decode($remote_server_output, true);
            $this->DataStandardizationListNodeB = json_decode(json_encode($this->DataStandardizationListNodeA['hits']), true);
            $this->DataStandardizationListNodeC = $this->DataStandardizationListNodeB['hits'];
            curl_close($curl);

            /*header('Content-type: application/json');
            print_r($remote_server_output);
            exit;*/
        
        foreach ($this->DataStandardizationListNodeC as $row) {

                $vIndex = $row['_index'];
                $vType = $row['_type'];
                $vId = $row['_id'];
                $vScore = $row['_score'];
                $vPrecio = $row['_source']['precio'];
                $vCodigo = $row['_source']['codigo'];
                $vPrecioDigital = $row['_source']['precioDigital'];
                $vNombreComite = $row['_source']['nombreComite'];
                $vVigente = $row['_source']['vigente'];
                $vPrecioFisico = $row['_source']['precioFisico'];
                $vIdSector = $row['_source']['idSector'];
                $vNumeroComite = $row['_source']['numerocomite'];
                $vActiva = $row['_source']['activa'];
                $vNombreNorma = $row['_source']['nombreNorma'];
                $vNombreSector = $row['_source']['nombreSector'];
                $vAlcance = $row['_source']['alcance'];
                $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
                $vStatus = 1;
                $vActive = 1;
    
                $vCodStandardization = $this->vAPIIbnorcaData->insertIbnorcaStandardization($vUserCode,$vIndex,$vType,$vId,$vScore,$vPrecio,$vCodigo,$vPrecioDigital,$vNombreComite,$vVigente,$vPrecioFisico,$vIdSector,$vNumeroComite,$vActiva,$vNombreNorma,$vNombreSector,$vAlcance,$vStatus,$vActive);
            }
            echo 'success';
        }
    }    

    public function insertIbnorcaCourses()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $vTable = 'tb_ibnc_web_courses';
        if($this->vAPIIbnorcaData->truncateTable($vTable) === TRUE){

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
            /*header('Content-type: application/json');
            print_r($remote_server_output);
            exit;*/

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


                echo 'success';
            }
        }

    }

    public function insertIbnorcaActiveCommitteesV2()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vTable = 'tb_ibnc_web_activecommitees';
            if($this->vAPIIbnorcaData->truncateTable($vTable) === TRUE){
                $sIde = "portal"; // De acuerdo al sistema
                $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988"; // llave de acuerdo al sistema
                $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ListaSectoresyComitesActivos"); 
                $datos=json_encode($parametros);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion-web.php");
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $remote_server_output = curl_exec ($ch);
                curl_close ($ch);
        
                $this->DataActiveCommitteesV2List = json_decode($remote_server_output, true);
        
                $vCount = 1;
                foreach ($this->DataActiveCommitteesV2List['listaSectoresComites'] as $row) {
                        $vIdUnico = $row['IdUnico'];
                        $vSector = $row['Sector'];
                        $vIdComite = $row['id_comite'];
                        $vNumeroComite = $row['NumeroComite'];
                        $vNombreComite = $row['NombreComite'];
                        $vFechaActivacion = $row['FechaActivacion'];
                        $vFechaFinalizacion = $row['FechaFinalizacion'];
                        $vEstado = $row['Estado'];
                        $vNormasEQNB = $row['NormasEQNB'];
                        $vNormasAPNB = $row['NormasAPNB'];
                        $vNormasPNB = $row['NormasPNB'];
                        $vNormasNB = $row['NormasNB'];
                        $vAlcance = $row['alcance'];
                        $vRelInternacional = $row['Rel_internacional'];
                        $vCorreoSecretario = $row['CorreoSecretario'];
        
                        $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
                        $vStatus = 1;
                        $vActive = 1;
            
                        $vCodActiveCommittees = $this->vAPIIbnorcaData->insertIbnorcaActiveCommitteesV2($vUserCode,$vIdUnico,$vSector,$vIdComite,$vNumeroComite,$vNombreComite,$vFechaActivacion,$vFechaFinalizacion,$vEstado,$vNormasEQNB,$vNormasAPNB,$vNormasPNB,$vNormasNB,$vAlcance,$vRelInternacional,$vCorreoSecretario,$vStatus,$vActive);
                    }                
            }            
            echo 'success';
        }
    }    
    
    public function systemMenu(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vUserCode = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'Code');
            $vLevel1 = (int) $_POST['vLevel1'];
            $vLevel2 = (int) $_POST['vLevel2'];
            $vLevel3 = (int) $_POST['vLevel3'];
            $vLevel4 = (int) $_POST['vLevel4'];
            $vParentMenu = (int) $_POST['vParentMenu'];
            $vPositionMenu = (int) $_POST['vPositionMenu'];
            $vRoleMenu = (string) $_POST['vRoleMenu'];
            $vIconMenu = (string) $_POST['vIconMenu'];
            $vNameMenu = (string) $_POST['vNameMenu'];
            $vDescMenu = (string) $_POST['vDescMenu'];
            $vControllerActive = (string) $_POST['vControllerActive'];
            $vMethodActive = (string) $_POST['vMethodActive'];
            $vURLMenu = (string) $_POST['vURLMenu'];
            $vSessionMenu = (int) $_POST['vSessionMenu'];
            $vActiveMenu = (int) $_POST['vActiveMenu'];
            
            $vInsertMenu = $this->vMenuData->insertMenu($vUserCode, $vLevel1, $vLevel2, $vLevel3, $vLevel4, $vParentMenu, $vPositionMenu, $vRoleMenu, $vIconMenu, $vNameMenu, $vDescMenu, $vControllerActive, $vMethodActive, $vURLMenu, $vSessionMenu, $vActiveMenu);

            if($this->vMenuData->getMenuExists($vInsertMenu) == 1){
                   echo 'success';
                
                    /* CONTROL USER ACTION */
                    $this->vCtrl->insertCtrlAction($this->vCtrl->getLastSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'),IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode')), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'), 'register', 'system', 'registerMenu', 'insertMenu', $vUserCode.';'.$vLevel1.';'.$vLevel2.';'.$vLevel3.';'.$vLevel4.';'.$vParentMenu.';'.$vPositionMenu.';'.$vRoleMenu.';'.$vIconMenu.';'.$vNameMenu.';'.$vDescMenu.';'.$vControllerActive.';'.$vMethodActive.';'.$vURLMenu.';'.$vSessionMenu.';'.$vActiveMenu);                        
            } else {
                echo 'error';
            }
            
        }             
    }

    public function insertMeetingsCommittees(){            
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $vTable = 'tb_ibnc_web_meetingscommitees';
            if($this->vAPIIbnorcaData->truncateTable($vTable) === TRUE){
                $sIde = "portal"; // De acuerdo al sistema
                $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988"; // llave de acuerdo al sistema
                $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ListaReunionesComites");  
                $datos=json_encode($parametros);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion.php");
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $remote_server_output = curl_exec ($ch);
                curl_close ($ch);
                
                $this->DataMeetingsCommitteesList = json_decode($remote_server_output, true);
        
                $vCount = 1;
                foreach ($this->DataMeetingsCommitteesList['lstReuniones'] as $row) {
        
                        $NumeroComite = $row['NumeroComite'];
                        $NombreComite = $row['NombreComite'];
                        $FechaReunion = $row['FechaReunion'];
                        $Contacto = $row['Contacto'];
        
                        $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
                        $vStatus = 1;
                        $vActive = 1;
            
                        $vCodActiveCommittees = $this->vAPIIbnorcaData->insertIbnorcaMeetingsCommittees($vUserCode,$NumeroComite,$NombreComite,$FechaReunion,$Contacto,$vStatus,$vActive);
                    }
            }
            echo 'success';
        }
    }

    public function insertStandardsInDevelopment(){            
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $vTable = 'tb_ibnc_web_standardsindevelopment';
            if($this->vAPIIbnorcaData->truncateTable($vTable) === TRUE){

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
                /*header('Content-type: application/json'); 	
                print_r($remote_server_output);
                exit;*/ 	              
                
                $this->DataStandardsInDevelopmentList = json_decode($remote_server_output, true);

                $vCount = 1;
                foreach ($this->DataStandardsInDevelopmentList['lstNormas'] as $row) {
                    $idSector = $row['idSector'];
                    $id_comite = $row['id_comite'];
                    $nroComite = $row['nroComite'];
                    $nombreComite = $row['nombreComite'];
                    $Alcance = $row['alcance'];
                    $id_etapa = $row['id_etapa'];
                    $CodigoNomra = $row['CodigoNorma'];
                    $TituloNorma = $row['TituloNorma'];
                    $estado = $row['estado'];
                    $estado_fecha = $row['estado_fecha'];
                    $fecha_ibn_presentacion_eqnb = $row['fecha_ibn_presentacion_eqnb'];
                    $fecha_ibn_documento_apnb = $row['fecha_ibn_documento_apnb'];
                    $fecha_ibn_consulta_inicio = $row['fecha_ibn_consulta_inicio'];
                    $fecha_ibn_consulta_fin = $row['fecha_ibn_consulta_fin'];
                    $fecha_ibn_aprobacion_nb = $row['fecha_ibn_aprobacion_nb'];
                    $fecha_ibn_aprobacion_cnno = $row['fecha_ibn_aprobacion_cnno'];
                    $fecha_ibn_ratificacion = $row['fecha_ibn_ratificacion'];

                    $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
                    $vStatus = 1;
                    $vActive = 1;            
                    $vCodActiveCommittees = $this->vAPIIbnorcaData->insertStandardsInDevelopmentList($vUserCode,$idSector,$id_comite,$nroComite,$nombreComite,$Alcance,$id_etapa,$CodigoNomra,$TituloNorma,$estado,$estado_fecha,$fecha_ibn_presentacion_eqnb,$fecha_ibn_documento_apnb,$fecha_ibn_consulta_inicio,$fecha_ibn_consulta_fin,$fecha_ibn_aprobacion_nb,$fecha_ibn_aprobacion_cnno,$fecha_ibn_ratificacion,$vStatus,$vActive);
                    $vCount++;
                }
            }
            echo 'success';
        }
    }
    
    public function insertStandardsPublic(){            
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $vTable = 'tb_ibnc_web_standardspublic';
            if($this->vAPIIbnorcaData->truncateTable($vTable) === TRUE){

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
                
                $this->DataStandardsPublicList = json_decode($remote_server_output, true);
                foreach ($this->DataStandardsPublicList['lista'] as $row) {
                    $codigo = $row['codigo'];
                    $TituloNorma = $row['TituloNorma'];
                    $NumeroComite = $row['NumeroComite'];
                    $NombreComite = $row['NombreComite'];
                    $estado = $row['estado'];
                    $FechaInicioConsulta = $row['FechaInicioConsulta'];
                    $FechaFinConsulta = $row['FechaFinConsulta'];
                    $fecha_estado = $row['fecha_estado'];
                    $NombreSector = $row['NombreSector'];
                    $persona = $row['persona'];

                    $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
                    $vStatus = 1;
                    $vActive = 1;            
                    $vCodStandardsPublic = $this->vAPIIbnorcaData->insertStandardsPublic($vUserCode,$codigo,$TituloNorma,$NumeroComite,$NombreComite,$estado,$FechaInicioConsulta,$FechaFinConsulta,$fecha_estado,$NombreSector,$persona,$vStatus,$vActive);
                }
            }
            echo 'success';
        }
    }

    public function insertSystemicReview(){            
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $vTable = 'tb_ibnc_apiibnorca_systemicreview';
            if($this->vAPIIbnorcaData->truncateTable($vTable) === TRUE){

                $sIde = "portal";
                $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988";
                $parametros=array("sIdentificador"=>$sIde, "sKey"=>$sKey, "accion"=>"ListaNormasRevisionSistematica"); 
                $datos=json_encode($parametros);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,"http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion-web.php");
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $remote_server_output = curl_exec ($ch);
                curl_close ($ch);

                $this->DataRevisionSistemicaList = json_decode($remote_server_output, true);
                foreach ($this->DataRevisionSistemicaList['lstNormas'] as $row) {
                    $id_revision_normas = $row['id_revision_normas'];
                    $id_revision_sistematica = $row['id_revision_sistematica'];
                    $id_norma = $row['id_norma'];
                    $nombre_norma = $row['nombre_norma'];
                    $estado = $row['estado'];
                    $id_tipo = $row['id_tipo'];
                    $numero = $row['numero'];
                    $id_comite_norma = $row['id_comite_norma'];
                    $tipo = $row['tipo'];
                    $anio = $row['anio'];
                    $FechaFin = $row['FechaFin'];

                    $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
                    $vStatus = 1;
                    $vActive = 1;            
                    $vCodStandardsPublic = $this->vAPIIbnorcaData->insertRevisionSistemica($vUserCode,$id_revision_normas,$id_revision_sistematica,$id_norma,$nombre_norma,$estado,$id_tipo,$numero,$id_comite_norma,$tipo,$anio,$FechaFin,$vStatus,$vActive);
                }
            }
            echo 'success';
        }
    }    

    public function insertMembers(){            
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $vTable = 'tb_ibnc_web_members';
            if($this->vAPIIbnorcaData->truncateTable($vTable) === TRUE){            
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
            //exit;
            
            $this->DataIntegrantesList = json_decode($remote_server_output, true);
          
            foreach ($this->DataIntegrantesList['lstIntegrantes'] as $row) {
                    $NumeroComite = $row['numero_comite'];
                    $NombreComite = $row['nombre_comite'];
                    $apellido = $row['apellido'];
                    $nombre = $row['nombre'];
                    $id_persona = $row['id_persona'];
                    $movil = $row['movil'];
                    $rol = $row['rol'];
                    $empresa = $row['empresa'];
                    $Tipo_empresa = $row['Tipo_empresa'];
    
                    $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
                    $vStatus = 1;
                    $vActive = 1;
        
                    $vCodMembers = $this->vAPIIbnorcaData->insertMembers($vUserCode,$NumeroComite,$NombreComite,$apellido,$nombre,$id_persona,$movil,$rol,$empresa,$Tipo_empresa,$vStatus,$vActive);
                }
            }            
    
    
                echo 'success';            
        }
    }

    public function insertMalla(){            
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $vTable = 'tb_ibnc_web_malla';
            if($this->vAPIIbnorcaData->truncateTable($vTable) === TRUE){              
            
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
    
            }
                echo 'success';            
        }
    }    
    
    // upload scripts
    
    public function insertSector(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            $vCodImg = null;//(int) $_POST['vCodImg'];
            $vCodIcon = null;//(int) $_POST['vCodIcon'];
            $vNameSector = (string) $_POST['vNameSector'];
            $vHeaderSector = (string) $_POST['vHeaderSector'];
            $vDescSector = (string) $_POST['vDescSector'];
            $vStatus = 1;//(int) $_POST['vStatus'];
            $vActive = 1;//(int) $_POST['vActive'];
            
            $vInsertSector = $this->vFrontEndData->insertSector($vCodUser, $vCodImg, $vCodIcon, $vNameSector, $vHeaderSector, $vDescSector, $vStatus, $vActive);
            echo 'success';    
            /* CONTROL USER ACTION */
            //$this->vCtrl->insertCtrlAction($this->vCtrl->getLastSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'),IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode')), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'), 'register', 'system', 'registerMenu', 'insertMenu', $vUserCode.';'.$vLevel1.';'.$vLevel2.';'.$vLevel3.';'.$vLevel4.';'.$vParentMenu.';'.$vPositionMenu.';'.$vRoleMenu.';'.$vIconMenu.';'.$vNameMenu.';'.$vDescMenu.';'.$vControllerActive.';'.$vMethodActive.';'.$vURLMenu.';'.$vSessionMenu.';'.$vActiveMenu);
            
        }             
    }
    
    public function insertFrontEndMenu()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vUserCode = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode');
            $vLevel1 = (int) $_POST['vLevel1'];
            $vLevel2 = (int) $_POST['vLevel2'];
            $vLevel3 = null;
            $vLevel4 = null;
            $vParentMenu = (int) $_POST['vParentMenu'];
            $vPositionMenu = (int) $_POST['vPositionMenu'];
            $vRoleMenu = null;
            $vIconMenu = null;
            $vNameMenu = (string) $_POST['vNameMenu'];
            $vDescMenu = null;
            $vControllerActive = (string) $_POST['vControllerActive'];
            $vMethodActive = (string) $_POST['vMethodActive'];
            $vURLMenu = (string) $_POST['vURLMenu'];
            $vSessionMenu = 0;
            $vActiveMenu = 1;

            $vInsertMenu = $this->vFrontEndData->insertFrontEndMenu($vUserCode, $vLevel1, $vLevel2, $vLevel3, $vLevel4, $vParentMenu, $vPositionMenu, $vRoleMenu, $vIconMenu, $vNameMenu, $vDescMenu, $vControllerActive, $vMethodActive, $vURLMenu, $vSessionMenu, $vActiveMenu);

            if ($this->vMenuData->getMenuExists($vInsertMenu) == 1) {
                echo 'success';

                /* CONTROL USER ACTION */
                $this->vCtrl->insertCtrlAction($this->vCtrl->getLastSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode')), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode'), 'register', 'system', 'registerMenu', 'insertMenu', $vUserCode . ';' . $vLevel1 . ';' . $vLevel2 . ';' . $vLevel3 . ';' . $vLevel4 . ';' . $vParentMenu . ';' . $vPositionMenu . ';' . $vRoleMenu . ';' . $vIconMenu . ';' . $vNameMenu . ';' . $vDescMenu . ';' . $vControllerActive . ';' . $vMethodActive . ';' . $vURLMenu . ';' . $vSessionMenu . ';' . $vActiveMenu);
            } else {
                echo 'error';
            }

        }
    }
    
    public function insertInspectionService(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            $vTitle = (string) $_POST['vTitle'];
            $vText = (string) $_POST['vText'];
            $vStatus = 1;
            $vActive = 1;
            
            $vInsert = $this->vFrontEndData->insertInspectionService($vCodUser, $vTitle, $vText, $vStatus, $vActive);
            echo 'success';
        }             
    }
    
    public function insertInspectionContent(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            $vCodInspection = (string) $_POST['vCodInspection'];
            $vTitle = (string) $_POST['vTitle'];
            $vDesc = (string) $_POST['vDesc'];
            $vStatus = 1;
            $vActive = 1;
            
            $vInsert = $this->vFrontEndData->insertInspectionContent($vCodUser, $vCodInspection, $vTitle, $vDesc, $vStatus, $vActive);
            echo 'success';
        }             
    }
    
    public function insertLandingContent(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');

            $vAttractive = (string) $_POST['vAttractive'];
            $vMessage1 = (string) $_POST['vMessage1'];
            $vMessage2 = (string) $_POST['vMessage2'];            
            $vIdCurso = (int) $_POST['vIdCurso'];
            //$vDescLanding = (string) $_POST['vDescLanding'];
            $vDescLanding = 'none';
            $vStatus = 1;
            $vActive = 1;

            if($this->vAPIIbnorcaData->getDataLandingContentExists($vIdCurso) == 0){
                $vInsert = $this->vFrontEndData->insertLandingContent($vCodUser, $vIdCurso, $vAttractive, $vMessage1, $vMessage2, $vDescLanding, $vStatus, $vActive);
                echo 'success';                
            } else if($this->vAPIIbnorcaData->getDataLandingContentExists($vIdCurso) == 1){
                $vInsert = $this->vFrontEndData->updateLandingContent($vIdCurso, $vAttractive, $vMessage1, $vMessage2, $vDescLanding);
                echo 'success';
            }
        }             
    }

    public function uploadImage(){                  
            if($_SERVER['REQUEST_METHOD'] == 'POST'){
    
                $vNameImage = (string) $_POST['vNameImage'];
                $vImageDesc = (string) $_POST['vDescImage'];
                
                $vCodProfile = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode');
                $vCodUser = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
                /****************************/
                /** BEGIN CREATE DIRECTORY **/
                /****************************/
                $vRootDirectory = ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.DEFAULT_VIEW_LAYOUT.DIR_SEPARATOR.'frontend'.DIR_SEPARATOR.'img'.DIR_SEPARATOR.'ibnorca'.DIR_SEPARATOR;
                /****************************/
                /** END CREATE DIRECTORY **/
                /****************************/                    
                
                /**************************/
                /*** BEGIN UPLOAD IMAGE ***/
                /**************************/
                $vSliderImage = $_FILES['vFImage']['name'];
    
                $this->getLibrary('upload');
                $this->vUploadVar = new libraryUploadFiles;                    
    
                if($vSliderImage != null){
    
                    $vImageType = $_FILES['vFImage']['type'];
                    $vImageSize = ($_FILES['vFImage']['size']/1024);
    
                    $vChangeNameExtension = pathinfo($_FILES['vFImage']['name']);
                    
                    $vChangeNameExtension = '.'.$vChangeNameExtension['extension'];
    
                    $vRandomImgCode1 = rand(1000000000,9999999999);
                    //$vFinalNameImage = 'slider_'.$vRandomImgCode1.$vChangeNameExtension;
                    $vFinalNameImage = $vNameImage.$vChangeNameExtension;
    
                    $vImageName = basename($vFinalNameImage);
    
                    if($vImageName){                                
                            $this->vUploadVar->SetFileName($vImageName);
                            $this->vUploadVar->SetTempName($_FILES['vFImage']['tmp_name']);
                            $this->vUploadVar->SetMaximumFileSize("");
                            $this->vUploadVar->SetUploadDirectory($vRootDirectory.DIR_SEPARATOR);
                            $this->vUploadVar->SetValidExtensions(array('gif', 'jpg', 'png', 'jpeg'));
    
                            if($this->vUploadVar->UploadFile() == 1){
                                $vImageContent = null;
                                $vInsertCodImg = $this->vFrontEndData->insertImage($vCodUser, $vImageName, $vImageDesc, $vImageContent, $vImageType, $vImageSize);
                                echo 'success';
                            } else {
                                echo 'error-upload';
                            }
                    } else {
                        echo 'error-name-root';
                    }                         
                } else {
                    echo 'no-entra';
                }                  
                
                /************************/
                /*** END UPLOAD IMAGE ***/
                /************************/                    
            }
        }
    
    public function uploadLandingImage(){            
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $vIdUnico = (int) $_POST['vIdUnico'];
            $vNameLandingImg = (string) $_POST['vNameLandingImg'];
            $vImageDesc = (string) $_POST['vDescLandingImg'];
            $vAssignLandingImg = (int) $_POST['vAssignLandingImg'];
            
            $vCodProfile = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode');
            $vCodUser = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            /****************************/
            /** BEGIN CREATE DIRECTORY **/
            /****************************/
            $vRootDirectory = ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.DEFAULT_VIEW_LAYOUT.DIR_SEPARATOR.'frontend'.DIR_SEPARATOR.'img'.DIR_SEPARATOR.'courses'.DIR_SEPARATOR;
            /****************************/
            /** END CREATE DIRECTORY **/
            /****************************/                    
            
            /**************************/
            /*** BEGIN UPLOAD IMAGE ***/
            /**************************/
            $vSliderImage = $_FILES['vLandingImage']['name'];

            $this->getLibrary('upload');
            $this->vUploadVar = new libraryUploadFiles;                    

            if($vSliderImage != null){

                $vImageType = $_FILES['vLandingImage']['type'];
                $vImageSize = ($_FILES['vLandingImage']['size']/1024);

                $vChangeNameExtension = pathinfo($_FILES['vLandingImage']['name']);
                
                $vChangeNameExtension = '.'.$vChangeNameExtension['extension'];

                $vRandomImgCode1 = rand(1000000000,9999999999);
                //$vFinalNameImage = 'slider_'.$vRandomImgCode1.$vChangeNameExtension;
                $vFinalNameImage = $vNameLandingImg.'_'.$vAssignLandingImg.$vChangeNameExtension;

                $vImageName = basename($vFinalNameImage);

                if($vImageName){                                
                        $this->vUploadVar->SetFileName($vImageName);
                        $this->vUploadVar->SetTempName($_FILES['vLandingImage']['tmp_name']);
                        $this->vUploadVar->SetMaximumFileSize('');
                        $this->vUploadVar->SetUploadDirectory($vRootDirectory.DIR_SEPARATOR);
                        $this->vUploadVar->SetValidExtensions(array('gif', 'jpg', 'png', 'jpeg'));

                        if($this->vUploadVar->UploadFile() == 1){
                            $vImageContent = null;
                            $vInsertCodSliderImg = $this->vFrontEndData->insertLandingImage($vCodUser, $vIdUnico, $vAssignLandingImg, $vImageName, $vImageDesc, $vImageContent, $vImageType, $vImageSize);
                            echo 'success';
                        } else {
                            echo 'error-upload';
                        }
                } else {
                    echo 'error-name-root';
                }                         
            } else {
                echo 'no-entra';
            }                  
            
            /************************/
            /*** END UPLOAD IMAGE ***/
            /************************/                    
        }
    }

    public function uploadLandingPDF(){            
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $vIdUnico = (int) $_POST['vIdUnico'];
            $vNameLandingImg = (string) $_POST['vNameLandingImg'];
            
            $vCodProfile = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode');
            $vCodUser = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            /****************************/
            /** BEGIN CREATE DIRECTORY **/
            /****************************/
            $vRootDirectory = ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.DEFAULT_VIEW_LAYOUT.DIR_SEPARATOR.'frontend'.DIR_SEPARATOR.'img'.DIR_SEPARATOR.'PDF'.DIR_SEPARATOR;
            /****************************/
            /** END CREATE DIRECTORY **/
            /****************************/                    
            
            /**************************/
            /*** BEGIN UPLOAD IMAGE ***/
            /**************************/
            $vSliderImage = $_FILES['vLandingImage']['name'];

            $this->getLibrary('upload');
            $this->vUploadVar = new libraryUploadFiles;                    

            if($vSliderImage != null){

                $vImageType = $_FILES['vLandingImage']['type'];
                $vImageSize = ($_FILES['vLandingImage']['size']/1024);

                $vChangeNameExtension = pathinfo($_FILES['vLandingImage']['name']);
                
                $vChangeNameExtension = '.'.$vChangeNameExtension['extension'];

                $vRandomImgCode1 = rand(1000000000,9999999999);
                //$vFinalNameImage = 'slider_'.$vRandomImgCode1.$vChangeNameExtension;
                $vFinalNameImage = $vNameLandingImg.'_'.$vIdUnico.$vChangeNameExtension;

                $vImageName = basename($vFinalNameImage);

                if($vImageName){                                
                        $this->vUploadVar->SetFileName($vImageName);
                        $this->vUploadVar->SetTempName($_FILES['vLandingImage']['tmp_name']);
                        $this->vUploadVar->SetMaximumFileSize('');
                        $this->vUploadVar->SetUploadDirectory($vRootDirectory.DIR_SEPARATOR);
                        $this->vUploadVar->SetValidExtensions(array('pdf'));

                        if($this->vUploadVar->UploadFile() == 1){
                            $vImageContent = null;
                            $vInsertCodSliderImg = $this->vFrontEndData->insertLandingPDF($vCodUser, $vIdUnico, $vImageName, $vImageContent, $vImageType, $vImageSize);
                            echo 'success';
                        } else {
                            echo 'error-upload';
                        }
                } else {
                    echo 'error-name-root';
                }                         
            } else {
                echo 'no-entra';
            }                  
            
            /************************/
            /*** END UPLOAD IMAGE ***/
            /************************/                  
        }
    }    
    
    public function insertStandardsCatalog(){            
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $vTable = 'tb_ibnc_web_standardscatalog';
            if($this->vAPIIbnorcaData->truncateTable($vTable) === TRUE){

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
                
                $this->DataCatalogoDeNormasList = json_decode($remote_server_output, true);
                $vCount = 1;
                foreach ($this->DataCatalogoDeNormasList['lstNormas'] as $row) {
                    $IdNorma = $row['IdNorma'];
                    $IdComite = $row['IdComite'];
                    $CodigoNorma = $row['CodigoNorma'];
                    $NombreNorma = $row['NombreNorma'];
                    $PalabrasClave = $row['PalabrasClave'];
                    $Alcance = $row['Alcance'];
                    $FechaVigencia = $row['FechaVigencia'];
                    $CantidadHojas = $row['CantidadHojas'];
                    $Observaciones = $row['Observaciones'];
                    $RemplazadaPor = $row['RemplazadaPor'];
                    $NombreSector = $row['NombreSector'];
                    $NombreComite = $row['NombreComite'];
                    $NumeroComite = $row['Numerocomite'];
                    $Adoptada = $row['Adoptada'];
                    $PrecioFisico = $row['precio_fisico'];
                    $PrecioDigital = $row['precio_digital'];
                    $EnWeb = $row['EnWEB'];
                    $CODIGO_ICS = $row['CODIGO_ICS'];
                    $Texto_desstaque = $row['Texto_desstaque'];

                    $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
                    $vStatus = 1;
                    $vActive = 1;            
                    $vCodStandardsCatalog = $this->vAPIIbnorcaData->insertStandardsCatalog($vUserCode, $IdNorma, $IdComite, $CodigoNorma, $NombreNorma, $PalabrasClave, $Alcance, $FechaVigencia, $CantidadHojas, $Observaciones, $RemplazadaPor, $NombreSector, $NombreComite, $NumeroComite, $Adoptada, $PrecioFisico, $PrecioDigital, $EnWeb, $CODIGO_ICS, $Texto_desstaque, $vStatus,$vActive);
                }
            }
            echo 'success';
        }
    }

    public function insertICSCatalog(){            
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $vTable = 'tb_ibnc_web_icscatalog';
            if($this->vAPIIbnorcaData->truncateTable($vTable) === TRUE){              
            
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

            
        $this->DataCatalogICSList = json_decode($remote_server_output, true);

            foreach ($this->DataCatalogICSList['lstNormas'] as $row) {
                    $ICS = $row['ICS'];
                    $Descripcion = $row['Descripcion'];
                    $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
                    $vStatus = 1;
                    $vActive = 1;
        
                    $vCodICSCatalog = $this->vAPIIbnorcaData->insertICSCatalog($vUserCode,$ICS,$Descripcion,$vStatus,$vActive);
                }            
    
            }
                echo 'success';            
        }
    }

    public function insertIndexHeader(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            $vTitle = (string) $_POST['vTitle'];
            $vDesc = (string) $_POST['vDesc'];
            $vStatus = 1;
            $vActive = 1;

            $vInsert = $this->vFrontEndData->insertIndexHeader($vCodUser, $vTitle, $vDesc, $vStatus, $vActive);
            echo 'success';
        }             
    }
    
    public function insertIndexSectionServices(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            $vCodPage = (int) $_POST['vCodPage'];
            $vURL = (string) $_POST['vURL'];
            $vTitle = (string) $_POST['vTitle'];
            $vText = (string) $_POST['vText'];
            $vStatus = 1;
            $vActive = 1;

            $vInsert = $this->vFrontEndData->insertIndexSectionServices($vCodUser, $vCodPage, $vURL, $vTitle, $vText, $vStatus, $vActive);
            echo 'success';
        }             
    }
    
    public function insertIndexDetail(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            $vCodPage = (int) $_POST['vCodPage'];
            $vTitle = (string) $_POST['vTitle'];
            $vDesc = (string) $_POST['vDesc'];
            $vStatus = 1;
            $vActive = 1;

            $vInsert = $this->vFrontEndData->insertIndexDetail($vCodUser, $vCodPage, $vTitle, $vDesc, $vStatus, $vActive);
            echo 'success';
        }             
    }
    
    public function insertIndexBenefits(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            $vCodPage = (string) $_POST['vCodPage'];
            $vTitle = (string) $_POST['vTitle'];
            $vDesc = (string) $_POST['vDesc'];
            $vStatus = 1;
            $vActive = 1;

            $vInsert = $this->vFrontEndData->insertIndexBenefits($vCodUser, $vCodPage, $vTitle, $vDesc, $vStatus, $vActive);
            echo 'success';
        }             
    }
    
    public function insertIndexServices(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            $vCodPage = (string) $_POST['vCodPage'];
            $vTitle = (string) $_POST['vTitle'];
            $vHeader = (string) $_POST['vHeader'];
            $vDesc = (string) $_POST['vDesc'];
            $vStatus = 1;
            $vActive = 1;

            $vInsert = $this->vFrontEndData->insertIndexServices($vCodUser, $vCodPage, $vTitle, $vHeader, $vDesc, $vStatus, $vActive);
            echo 'success';
        }             
    }

    public function insertIndexBenefitsServices(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            $vCodServicesIndex = (string) $_POST['vCodServicesIndex'];
            $vTitle = (string) $_POST['vTitle'];
            $vDesc = (string) $_POST['vDesc'];
            $vStatus = 1;
            $vActive = 1;

            $vInsert = $this->vFrontEndData->insertIndexBenefitsServices($vCodUser, $vCodServicesIndex, $vTitle, $vDesc, $vStatus, $vActive);
            echo 'success';
        }             
    }
    
    public function insertServiceAnchoring(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            $vCodPage = (int) $_POST['vCodPage'];
            
            $vCodService = (string) $_POST['vCodService'];
            $vStatus = 1;
            $vActive = 1;

            $vIdNorma = $this->vFrontEndData->getIdNormaFromNombreNorma($vCodService);
            $IdUnico = $vCodService;

            if($this->vFrontEndData->getNormaExistente($vCodService) == 1){
                $vInsert = $this->vFrontEndData->insertServiceAnchoringNorma($vCodUser, $vCodPage, $vIdNorma, $vStatus, $vActive);
            } else if($this->vFrontEndData->getIdCursoExistente($vCodService) == 1){
                $vInsert = $this->vFrontEndData->insertServiceAnchoringCourse($vCodUser, $vCodPage, $IdUnico, $vStatus, $vActive);
            } else {
                $vInsert = $this->vFrontEndData->insertServiceAnchoringService($vCodUser, $vCodPage, $vCodService, $vStatus, $vActive);
            }
            
            echo 'success';
        }             
    }
    
    public function insertTitles(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            
            $vCodPage = (int) $_POST['vCodPage'];
            $vCodSection = (int) $_POST['vCodSection'];
            $vTitleA = (string) $_POST['vTitleA'];
            $vTitleB = (string) $_POST['vTitleB'];
            $vText = (string) $_POST['vText'];

            $vStatus = 1;
            $vActive = 1;

            $vInsert = $this->vFrontEndData->insertTitles($vCodUser, $vCodPage, $vCodSection, $vTitleA, $vTitleB, $vText, $vStatus, $vActive);
            echo 'success';
        }             
    }
    
    public function insertPartners(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            
            $vCodPage = (int) $_POST['vCodPage'];
            $vType = (int) $_POST['vType'];
            $vTitle = (string) $_POST['vTitle'];
            $vURL = (string) $_POST['vURL'];

            $vStatus = 1;
            $vActive = 1;

            $vInsert = $this->vFrontEndData->insertPartners($vCodUser, $vCodPage, $vType, $vTitle, $vURL, $vStatus, $vActive);
            echo 'success';
        }             
    } 
    
    public function insertCourseWeb(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');

            $vIdUnico = (int) $_POST['vIdUnico'];
            $vIdClasificador = (int) $_POST['vIdClasificador'];
            $vTitle = (string) $_POST['vTitle'];
            $vTextCoursesWeb = (string) $_POST['vTextCoursesWeb'];

            $vStatus = 1;
            $vActive = 1;

            $vInsert = $this->vFrontEndData->insertCourseWeb($vCodUser, $vIdUnico, $vIdClasificador, $vTitle, $vTextCoursesWeb, $vStatus, $vActive);
            echo 'success';
        }             
    }
    
    public function insertServiceServicesAnchoring(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            $vCodServicesIndex = (int) $_POST['vCodServicesIndex'];
            $vCodServiceAnchoring = (string) $_POST['vCodServiceAnchoring'];            
            $vStatus = 1;
            $vActive = 1;

            $vIdNorma = $this->vFrontEndData->getIdNormaFromNombreNorma($vCodServiceAnchoring);
            $IdUnico = $vCodServiceAnchoring;

            if($this->vFrontEndData->getNormaExistente($vCodServiceAnchoring) == 1){
                $vInsert = $this->vFrontEndData->insertServiceServicesAnchoringNorma($vCodUser, $vCodServicesIndex, $vIdNorma, $vStatus, $vActive);
            } else if($this->vFrontEndData->getIdCursoExistente($vCodServiceAnchoring) == 1){
                $vInsert = $this->vFrontEndData->insertServiceServicesAnchoringCourse($vCodUser, $vCodServicesIndex, $IdUnico, $vStatus, $vActive);
            } else {
                $vInsert = $this->vFrontEndData->insertServiceServicesAnchoringServices($vCodUser, $vCodServicesIndex, $vCodServiceAnchoring, $vStatus, $vActive);
            }
            
            echo 'success';
        }             
    }
    
    public function insertNews(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            
            $vType = (int) $_POST['vType'];
            $vDateNews = $_POST['vDateNews'];
            $vTitle = (string) $_POST['vTitle'];
            $vText = (string) $_POST['vTextNews'];

            $vStatus = 1;
            $vActive = 1;

            $vInsert = $this->vFrontEndData->insertNews($vCodUser, $vType, $vDateNews, $vTitle, $vText, $vStatus, $vActive);
            echo 'success';
        }             
    }
    
    public function insertLandingBenefit(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            
            $vIdCurso = (int) $_POST['vIdCurso'];
            $vTitle = (string) $_POST['vTitle'];
            $vText = (string) $_POST['vText'];

            $vStatus = 1;
            $vActive = 1;

            $vInsert = $this->vAPIIbnorcaData->insertLandingBenefit($vCodUser, $vIdCurso, $vTitle, $vText, $vStatus, $vActive);
            echo 'success';
        }             
    }
    
    public function insertLandingFaqs(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            
            $vIdCurso = '';
            $vIdCurso = (int) $_POST['vIdCurso'];
            $vTitle = (string) $_POST['vTitle'];
            $vText = (string) $_POST['vText'];

            $vStatus = 1;
            $vActive = 1;

            $vInsert = $this->vAPIIbnorcaData->insertLandingFaqs($vCodUser, $vIdCurso, $vTitle, $vText, $vStatus, $vActive);
            echo 'success';
        }             
    }
    
    public function insertKeywords(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            $vCodPage = (int) $_POST['vCodPage'];
            $vText = (string) $_POST['vText'];
            $vStatus = 1;
            $vActive = 1;

            $vInsert = $this->vFrontEndData->insertKeywords($vCodUser, $vCodPage, $vText, $vStatus, $vActive);
            echo 'success';
        }             
    }
    
    public function insertDescriptionSEO(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            $vCodPage = (int) $_POST['vCodPage'];
            $vText = (string) $_POST['vText'];
            $vStatus = 1;
            $vActive = 1;

            $vInsert = $this->vFrontEndData->insertDescriptionSEO($vCodUser, $vCodPage, $vText, $vStatus, $vActive);
            echo 'success';
        }             
    }
    
    public function insertRegistrationProcess(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            $vCodPage = (int) $_POST['vCodPage'];
            $vTitle = (string) $_POST['vTitle'];
            $vDesc = '-';//(string) $_POST['vDesc'];
            $vStatus = 1;
            $vActive = 1;

            $vInsert = $this->vFrontEndData->insertRegistrationProcess($vCodUser, $vCodPage, $vTitle, $vDesc, $vStatus, $vActive);
            echo 'success';
        }             
    }
    
    public function insertTestimonials(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            $vCodPage = (int) $_POST['vCodPage'];
            $vName = (string) $_POST['vName'];
            $vBusiness = (string) $_POST['vBusiness'];
            $vText = (string) $_POST['vText'];
            $vURL = (string) $_POST['vURL'];
            $vStatus = 1;
            $vActive = 1;

            $vInsert = $this->vFrontEndData->insertTestimonials($vCodUser, $vCodPage, $vName, $vBusiness, $vText, $vURL, $vStatus, $vActive);
            echo 'success';
        }             
    }

    public function insertLandingDiscounts(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            
            $vType = (int) $_POST['vType'];
            $vIdUnico = (int) $_POST['vIdUnico'];
            $vText = (string) $_POST['vText'];

            $vStatus = 1;
            $vActive = 1;

            $vInsert = $this->vAPIIbnorcaData->insertLandingDiscounts($vCodUser, $vIdUnico, $vType, $vText, $vStatus, $vActive);
            echo 'success';
        }             
    }
    
    public function uploadComitePDF(){            
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $vIdComite = (int) $_POST['vIdComite'];
            $vNameLandingImg = (string) $_POST['vNameLandingImg'];
            
            $vCodProfile = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode');
            $vCodUser = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            /****************************/
            /** BEGIN CREATE DIRECTORY **/
            /****************************/
            $vRootDirectory = ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.DEFAULT_VIEW_LAYOUT.DIR_SEPARATOR.'frontend'.DIR_SEPARATOR.'img'.DIR_SEPARATOR.'PDF'.DIR_SEPARATOR;
            /****************************/
            /** END CREATE DIRECTORY **/
            /****************************/                    
            
            /**************************/
            /*** BEGIN UPLOAD IMAGE ***/
            /**************************/
            $vSliderImage = $_FILES['vLandingImage']['name'];

            $this->getLibrary('upload');
            $this->vUploadVar = new libraryUploadFiles;                    

            if($vSliderImage != null){

                $vImageType = $_FILES['vLandingImage']['type'];
                $vImageSize = ($_FILES['vLandingImage']['size']/1024);

                $vChangeNameExtension = pathinfo($_FILES['vLandingImage']['name']);
                
                $vChangeNameExtension = '.'.$vChangeNameExtension['extension'];

                $vRandomImgCode1 = rand(1000000000,9999999999);
                //$vFinalNameImage = 'slider_'.$vRandomImgCode1.$vChangeNameExtension;
                $vFinalNameImage = $vNameLandingImg.'_'.$vIdComite.$vChangeNameExtension;

                $vImageName = basename($vFinalNameImage);

                if($vImageName){                                
                        $this->vUploadVar->SetFileName($vImageName);
                        $this->vUploadVar->SetTempName($_FILES['vLandingImage']['tmp_name']);
                        $this->vUploadVar->SetMaximumFileSize('');
                        $this->vUploadVar->SetUploadDirectory($vRootDirectory.DIR_SEPARATOR);
                        $this->vUploadVar->SetValidExtensions(array('pdf'));

                        if($this->vUploadVar->UploadFile() == 1){
                            $vImageContent = null;
                            $vCodPDF = $this->vFrontEndData->insertComitePDF($vCodUser, $vImageName, $vImageContent, $vImageType, $vImageSize);
                            $this->vFrontEndData->updateComiteCodPDF($vCodPDF, $vIdComite);
                            echo 'success';
                        } else {
                            echo 'error-upload';
                        }
                } else {
                    echo 'error-name-root';
                }                         
            } else {
                echo 'no-entra';
            }                  
            
            /************************/
            /*** END UPLOAD IMAGE ***/
            /************************/                  
        }
    }

    public function uploadIndexServicesPDF(){            
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $vCodServicesIndex = (int) $_POST['vCodServicesIndex'];
            $vNamePDF = (string) $_POST['vNamePDF'];
            
            $vCodProfile = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode');
            $vCodUser = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            /****************************/
            /** BEGIN CREATE DIRECTORY **/
            /****************************/
            $vRootDirectory = ROOT_APPLICATION.'views'.DIR_SEPARATOR.'layout'.DIR_SEPARATOR.DEFAULT_VIEW_LAYOUT.DIR_SEPARATOR.'frontend'.DIR_SEPARATOR.'img'.DIR_SEPARATOR.'PDF'.DIR_SEPARATOR;
            /****************************/
            /** END CREATE DIRECTORY **/
            /****************************/                    
            
            /**************************/
            /*** BEGIN UPLOAD IMAGE ***/
            /**************************/
            $vDocumentPDF = $_FILES['vDocumentPDF']['name'];

            $this->getLibrary('upload');
            $this->vUploadVar = new libraryUploadFiles;                    

            if($vDocumentPDF != null){

                $vImageType = $_FILES['vDocumentPDF']['type'];
                $vImageSize = ($_FILES['vDocumentPDF']['size']/1024);

                $vChangeNameExtension = pathinfo($_FILES['vDocumentPDF']['name']);
                
                $vChangeNameExtension = '.'.$vChangeNameExtension['extension'];

                $vRandomImgCode1 = rand(1000000000,9999999999);
                //$vFinalNameImage = 'slider_'.$vRandomImgCode1.$vChangeNameExtension;
                $vFinalNameImage = $vNamePDF.'_'.$vCodServicesIndex.$vChangeNameExtension;

                $vImageName = basename($vFinalNameImage);

                if($vImageName){                                
                        $this->vUploadVar->SetFileName($vImageName);
                        $this->vUploadVar->SetTempName($_FILES['vDocumentPDF']['tmp_name']);
                        $this->vUploadVar->SetMaximumFileSize('');
                        $this->vUploadVar->SetUploadDirectory($vRootDirectory.DIR_SEPARATOR);
                        $this->vUploadVar->SetValidExtensions(array('pdf'));

                        if($this->vUploadVar->UploadFile() == 1){
                            $vImageContent = null;
                            $vCodPDF = $this->vFrontEndData->insertDocumentPDF($vCodUser, $vImageName, $vImageContent, $vImageType, $vImageSize);
                            $this->vFrontEndData->updateIndexServicesCodPDF($vCodPDF, $vCodServicesIndex);
                            echo 'success';
                        } else {
                            echo 'error-upload';
                        }
                } else {
                    echo 'error-name-root';
                }                         
            } else {
                echo 'no-entra';
            }                  
            
            /************************/
            /*** END UPLOAD IMAGE ***/
            /************************/                  
        }
    }

    public function insertSectorRelationship(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            $vCode = (int) $_POST['vCode'];
            $vCodRelationship = (string) $_POST['vCodRelationship'];

            $IdUnico = 0;
            $vStatus = 1;
            $vActive = 1;

            $vArrayNumeroComite = explode( '.', $vCodRelationship);
            $vRelationshipType = $vArrayNumeroComite[0];
            $vCodServicesIndex = $vArrayNumeroComite[1];
            $vNumeroComite = $vArrayNumeroComite[1];
            $vIdUnico = $vArrayNumeroComite[1];

            if($vRelationshipType == 'SER'){
                if($this->vFrontEndData->getIdServicioExistente($vCodServicesIndex) == 1){
                    $vInsert = $this->vFrontEndData->insertSectorRelationshipService($vCodUser, $vCode, 1, $vCodServicesIndex, $vStatus, $vActive);
                    echo 'success-service';
                }
            } else if($vRelationshipType == 'SEC'){
                if($this->vFrontEndData->getIdComiteExistente($vNumeroComite) >= 1){
                    $this->DataIbnorcaNormas = $this->vFrontEndData->getDataNormasFromNumeroComite($vNumeroComite);
                    foreach ($this->DataIbnorcaNormas as $row) {
                        $vInsert = $this->vFrontEndData->insertSectorRelationshipNorma($vCodUser, $vCode, 2, $row['CodigoNorma'], $vStatus, $vActive);                 
                    }
                    echo 'success-comite';
                }            
            } else if($vRelationshipType == 'CUR'){
                if($this->vFrontEndData->getIdCursoExistente($vIdUnico) >= 1){
                    $vInsert = $this->vFrontEndData->insertSectorRelationshipCurso($vCodUser, $vCode, 3, $vIdUnico, $vStatus, $vActive);
                    echo 'success-course';
                }            
            }

            /*if($this->vFrontEndData->getNormaExistente($vCodRelationship) == 1){
                //echo 'norma';
                $vInsert = $this->vFrontEndData->insertSectorRelationshipNorma($vCodUser, $vCode, 2, $vIdNorma, $vStatus, $vActive);
            } else if($this->vFrontEndData->getIdCursoExistente($vCodRelationship) == 1){
                //echo 'curso';
                $vInsert = $this->vFrontEndData->insertSectorRelationshipCurso($vCodUser, $vCode, 1, $IdUnico, $vStatus, $vActive);
            /*} else if($this->vFrontEndData->getIdServicioExistente($vCodRelationship) == 1){
                echo 'servicio';
                //$vInsert = $this->vFrontEndData->insertServiceServicesAnchoringCourse($vCodUser, $vCodServicesIndex, $IdUnico, $vStatus, $vActive);*/
            /*} else if($this->vFrontEndData->getIdComiteExistente($vCodRelationship) == 1){
                $this->DataIbnorcaNormas = $this->vFrontEndData->getDataNormasFromNumeroComite($vNumeroComite);
                //echo 'comite '.$vCodRelationship;
                foreach ($this->DataIbnorcaNormas as $row) {
                    $vInsert = $this->vFrontEndData->insertSectorRelationshipNorma($vCodUser, $vCode, 2, $row['CodigoNorma'], $vStatus, $vActive);                 
                }
            }*/
            
            
        }             
    }

    public function insertAdvertisement(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $vCodUser = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            
            $vTitle = (string) $_POST['vTitle'];
            $vTextAdvertisement = (string) $_POST['vTextAdvertisement'];
            /*$vTextAdvertisement = trim($vTextAdvertisement);
            $vTextAdvertisement = stripslashes($vTextAdvertisement);
            $vTextAdvertisement = htmlspecialchars($vTextAdvertisement);*/

            $vDateIni = $_POST['vDateIni'];
            $vDateEnd = $_POST['vDateEnd'];

            $vStatus = 0;
            $vActive = 1;

            $vInsert = $this->vFrontEndData->insertAdvertisement($vCodUser, $vTitle, $vTextAdvertisement, $vDateIni, $vDateEnd, $vStatus, $vActive);
            echo 'success';
        }             
    }
}