<?Php


class cronController extends IdEnController
{
    public function __construct()
    {
        parent::__construct();
        $this->vAPIIbnorcaData = $this->LoadModel('apiibnorca');
    }

    public function index()
    {
        $this->vView->visualize('index');
    }

    public function executeInserts()
    {
/* insertIbnorcaCourses */
$vTable = 'tb_ibnc_web_courses';
if ($this->vAPIIbnorcaData->truncateTable($vTable) === true) {
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

        $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode');

        if ($vCodigoCurso == 'OV-PFISGC-PFA-G1-2024') {
            $vStatus = 0;
        } else {
            $vStatus = 1;
        }

        $vActive = 1;

        $vCodWebCourses = $this->vAPIIbnorcaData->insertIbnorcaCourses($vUserCode, $vIdUnico, $vIdCurso, $vIdPrograma, $vCodigoCurso, $vPrograma, $vCantidadModulos, $vFechaInicio, $vCosto, $vCostoModular, $vIdTipo, $vtipo, $vIdOficina, $vOficina, $vIdGestion, $vGestion, $vCargaHoraria, $vIdArea, $vArea, $vIdImagenCurso, $vUrlImagenCurso, $vcontenido, $vobjetivo, $vIdSectorInteres, $vSectorInteres, $vUrlImagenSector, $vnorma, $vOrientado, $vHorario, $vDias, $vIdModalidad, $vModalidad, $vDescripcionModalidad, $vResponsable, $vDescuento, $vPorcenDescuento, $vDescuentoGrupo, $vPorcenDescuentoGrupo, $vLink, $vAlumnosInscritos, $vCostoSUS, $vCostoModularSUS, $vStatus, $vActive);
    }
    echo 'Ok insertIbnorcaCourses';
}

/* insertIbnorcaStandardizationV2 */
$vTable = 'tb_ibnc_web_standardization';
if ($this->vAPIIbnorcaData->truncateTable($vTable) === true) {
    $sIde = "portal"; // De acuerdo al sistema
    $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988"; // llave de acuerdo al sistema
    $parametros = array("sIdentificador" => $sIde, "sKey" => $sKey, "accion" => "ListaNormasElastic");
    $datos = json_encode($parametros);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion-web.php");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec($ch);
    curl_close($ch);
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
        $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode');
        $vStatus = 1;
        $vActive = 1;

        $vCodStandardization = $this->vAPIIbnorcaData->insertIbnorcaStandardization($vUserCode, $vIndex, $vType, $vId, $vScore, $vPrecio, $vCodigo, $vPrecioDigital, $vNombreComite, $vVigente, $vPrecioFisico, $vIdSector, $vNumeroComite, $vActiva, $vNombreNorma, $vNombreSector, $vAlcance, $vStatus, $vActive);
    }
    echo 'Ok insertIbnorcaStandardizationV2';
}

/* insertIbnorcaStandardizationV2 */
$vTable = 'tb_ibnc_web_activecommitees';
if ($this->vAPIIbnorcaData->truncateTable($vTable) === true) {
    $sIde = "portal"; // De acuerdo al sistema
    $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988"; // llave de acuerdo al sistema
    $parametros = array("sIdentificador" => $sIde, "sKey" => $sKey, "accion" => "ListaSectoresyComitesActivos");
    $datos = json_encode($parametros);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion-web.php");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec($ch);
    curl_close($ch);

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

        $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode');
        $vStatus = 1;
        $vActive = 1;

        $vCodActiveCommittees = $this->vAPIIbnorcaData->insertIbnorcaActiveCommitteesV2($vUserCode, $vIdUnico, $vSector, $vIdComite, $vNumeroComite, $vNombreComite, $vFechaActivacion, $vFechaFinalizacion, $vEstado, $vNormasEQNB, $vNormasAPNB, $vNormasPNB, $vNormasNB, $vAlcance, $vRelInternacional, $vCorreoSecretario, $vStatus, $vActive);
    }
    echo 'Ok insertIbnorcaStandardizationV2';
}
/* insertStandardsInDevelopment */
$vTable = 'tb_ibnc_web_standardsindevelopment';
if ($this->vAPIIbnorcaData->truncateTable($vTable) === true) {

    $sIde = "portal"; // De acuerdo al sistema
    $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988"; // llave de acuerdo al sistema
    $parametros = array("sIdentificador" => $sIde, "sKey" => $sKey, "accion" => "ListaElaboracionNormasxTodosComites");

    $datos = json_encode($parametros);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion-web.php");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec($ch);
    curl_close($ch);
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

        $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode');
        $vStatus = 1;
        $vActive = 1;
        $vCodActiveCommittees = $this->vAPIIbnorcaData->insertStandardsInDevelopmentList($vUserCode, $idSector, $id_comite, $nroComite, $nombreComite, $Alcance, $id_etapa, $CodigoNomra, $TituloNorma, $estado, $estado_fecha, $fecha_ibn_presentacion_eqnb, $fecha_ibn_documento_apnb, $fecha_ibn_consulta_inicio, $fecha_ibn_consulta_fin, $fecha_ibn_aprobacion_nb, $fecha_ibn_aprobacion_cnno, $fecha_ibn_ratificacion, $vStatus, $vActive);
        $vCount++;
    }
    echo 'Ok insertStandardsInDevelopment';
}
/* insertMembers */
$vTable = 'tb_ibnc_web_members';
if ($this->vAPIIbnorcaData->truncateTable($vTable) === true) {
    $sIde = "portal"; // De acuerdo al sistema
    $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988"; // llave de acuerdo al sistema
    $parametros = array("sIdentificador" => $sIde, "sKey" => $sKey, "accion" => "ListaIntegrantesComites");
    $datos = json_encode($parametros);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion-web.php");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec($ch);
    curl_close($ch);

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

        $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode');
        $vStatus = 1;
        $vActive = 1;

        $vCodMembers = $this->vAPIIbnorcaData->insertMembers($vUserCode, $NumeroComite, $NombreComite, $apellido, $nombre, $id_persona, $movil, $rol, $empresa, $Tipo_empresa, $vStatus, $vActive);
    }
    echo 'Ok insertMembers';
}

/* insertMalla */
$vTable = 'tb_ibnc_web_malla';
if ($this->vAPIIbnorcaData->truncateTable($vTable) === true) {

    $sIde = "portal";
    $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988";
    $parametros = array("sIdentificador" => $sIde, "sKey" => $sKey, "accion" => "ListarMalla");
    $parametros = json_encode($parametros);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://ibnored.ibnorca.org/wsibno/capacitacion/ws-capacitacion.php");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $parametros);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec($ch);
    curl_close($ch);

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

        $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode');
        $vStatus = 1;
        $vActive = 1;

        $vCodMembers = $this->vAPIIbnorcaData->insertMalla($vUserCode, $idmalla, $idtipo, $IdCurso, $idmodulo, $FechaMalla, $d_tipo, $Programa, $Codigo, $d_modulo, $nivel, $Objetivo, $Contenido, $CodigoNorma, $NombreNorma, $TipoNorma, $d_Area, $vStatus, $vActive);
    }
    echo 'Ok insertMalla';
}
/* insertStandardsCatalog */
$vTable = 'tb_ibnc_web_standardscatalog';
if ($this->vAPIIbnorcaData->truncateTable($vTable) === true) {

    $sIde = "portal"; // De acuerdo al sistema
    $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988"; // llave de acuerdo al sistema
    $parametros = array("sIdentificador" => $sIde, "sKey" => $sKey, "accion" => "ListaCatalogoNormas");

    $datos = json_encode($parametros);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion-web.php");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec($ch);
    curl_close($ch);

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

        $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode');
        $vStatus = 1;
        $vActive = 1;
        $vCodStandardsCatalog = $this->vAPIIbnorcaData->insertStandardsCatalog($vUserCode, $IdNorma, $IdComite, $CodigoNorma, $NombreNorma, $PalabrasClave, $Alcance, $FechaVigencia, $CantidadHojas, $Observaciones, $RemplazadaPor, $NombreSector, $NombreComite, $NumeroComite, $Adoptada, $PrecioFisico, $PrecioDigital, $EnWeb, $CODIGO_ICS, $Texto_desstaque, $vStatus, $vActive);
    }
    echo 'Ok insertStandardsCatalog';
}
/* insertICSCatalog */
$vTable = 'tb_ibnc_web_icscatalog';
if ($this->vAPIIbnorcaData->truncateTable($vTable) === true) {

    $sIde = "portal"; // De acuerdo al sistema
    $sKey = "02b9eb3fdf8c7ef88209e5f14f00e988"; // llave de acuerdo al sistema
    $parametros = array("sIdentificador" => $sIde, "sKey" => $sKey, "accion" => "ListaCatalogoICS");

    $datos = json_encode($parametros);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://ibnored.ibnorca.org/wsibno/normalizacion/ws-normalizacion-web.php");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $datos);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $remote_server_output = curl_exec($ch);
    curl_close($ch);

    $this->DataCatalogICSList = json_decode($remote_server_output, true);

    foreach ($this->DataCatalogICSList['lstNormas'] as $row) {
        $ICS = $row['ICS'];
        $Descripcion = $row['Descripcion'];
        $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode');
        $vStatus = 1;
        $vActive = 1;

        $vCodICSCatalog = $this->vAPIIbnorcaData->insertICSCatalog($vUserCode, $ICS, $Descripcion, $vStatus, $vActive);
    }
echo 'Ok insertICSCatalog';
}
    }
}
?>