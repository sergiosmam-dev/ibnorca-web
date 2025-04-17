<?php

class apiibnorcaModel extends IdEnModel
	{
		public function __construct(){
				parent::__construct();
			}
        
        /* BEGIN SELECT STATEMENT QUERY  */
        public function getModule()
        {
            $vResultGetModule = $this->vDataBase->query("SELECT * FROM tb_ibnc_modules;");
            return $vResultGetModule->fetchAll();
            $vResultGetModule->close();
        }        
        public function getIbnorcaCoursesGroup()
        {
            $vResultGetIbnorcaCoursesGroup = $this->vDataBase->query("SELECT COUNT(*) AS nCount, tb_ibnc_web_courses.IdTipo, tb_ibnc_web_courses.tipo FROM tb_ibnc_web_courses GROUP BY tb_ibnc_web_courses.IdTipo;");
            return $vResultGetIbnorcaCoursesGroup->fetchAll();
            $vResultGetIbnorcaCoursesGroup->close();
        }            
            public function getIbnorcaMallaGroup($vArea)
			{
                $vArea = (string) $vArea;
				$vResultGetIbnorcaCoursesGroup = $this->vDataBase->query("SELECT COUNT(*) AS nCount, tb_ibnc_web_malla.nivel FROM tb_ibnc_web_malla WHERE tb_ibnc_web_malla.d_Area = '$vArea' GROUP BY tb_ibnc_web_malla.nivel;");
				return $vResultGetIbnorcaCoursesGroup->fetchAll();
				$vResultGetIbnorcaCoursesGroup->close();
			}            
            public function getIbnorcaCoursesArea()
			{
				$vResultGetIbnorcaCoursesArea = $this->vDataBase->query("SELECT COUNT(*) AS nCount, tb_ibnc_web_courses.IdArea, tb_ibnc_web_courses.Area FROM tb_ibnc_web_courses GROUP BY tb_ibnc_web_courses.IdArea;");
				return $vResultGetIbnorcaCoursesArea->fetchAll();
				$vResultGetIbnorcaCoursesArea->close();
			}
            public function getIbnorcaCoursesTipo()
			{
				$vResultGetIbnorcaCoursesArea = $this->vDataBase->query("SELECT tb_ibnc_web_courses.IdTipo, tb_ibnc_web_courses.tipo, COUNT(tb_ibnc_web_courses.n_codwebcourses) AS nCount FROM tb_ibnc_web_courses GROUP BY tb_ibnc_web_courses.IdTipo;");
				return $vResultGetIbnorcaCoursesArea->fetchAll();
				$vResultGetIbnorcaCoursesArea->close();
			}

            public function getIbnorcaIdTipoFromSorterGroup($vSorterGroup)
			{
                $vSorterGroup = (int) $vSorterGroup;
				$vResultGetIbnorcaIdTipoFromSorterGroup = $this->vDataBase->query("SELECT GROUP_CONCAT(tb_ibnc_sorter.n_idclasificador) AS vIdTipo FROM tb_ibnc_sorter WHERE tb_ibnc_sorter.n_sortergroup = $vSorterGroup;");
				return $vResultGetIbnorcaIdTipoFromSorterGroup->fetchColumn();
				$vResultGetIbnorcaIdTipoFromSorterGroup->close();
			}

            public function getIbnorcaNameWebFromIdTipo($vIdTipo)
			{
                $vIdTipo = (int) $vIdTipo;
                $vSorterGroup = (int) $vSorterGroup;
				$vResultGetIbnorcaIdTipoFromSorterGroup = $this->vDataBase->query("SELECT tb_ibnc_sorter.c_nameweb FROM tb_ibnc_sorter WHERE tb_ibnc_sorter.n_idclasificador = $vIdTipo;");
				return $vResultGetIbnorcaIdTipoFromSorterGroup->fetchColumn();
				$vResultGetIbnorcaIdTipoFromSorterGroup->close();
			}
            
            public function getIbnorcaSorterGroupFromIdTipo($vIdTipo)
			{
                $vIdTipo = (int) $vIdTipo;
                $vSorterGroup = (int) $vSorterGroup;
				$vResultGetIbnorcaIdTipoFromSorterGroup = $this->vDataBase->query("SELECT tb_ibnc_sorter.n_sortergroup FROM tb_ibnc_sorter WHERE tb_ibnc_sorter.n_idclasificador = $vIdTipo;");
				return $vResultGetIbnorcaIdTipoFromSorterGroup->fetchColumn();
				$vResultGetIbnorcaIdTipoFromSorterGroup->close();
			}            

            public function getIbnorcaSorterGroupName($vSorterGroup)
			{
                $vSorterGroup = (int) $vSorterGroup;
				$vResultGetIbnorcaIdTipoFromSorterGroup = $this->vDataBase->query("SELECT tb_ibnc_sorter.c_nameweb FROM tb_ibnc_sorter WHERE tb_ibnc_sorter.n_sortergroup = $vSorterGroup;");
				return $vResultGetIbnorcaIdTipoFromSorterGroup->fetchColumn();
				$vResultGetIbnorcaIdTipoFromSorterGroup->close();
			}            

            public function getIbnorcaSorterCourses()
			{
                $vResultGetIbnorcaCoursesArea = $this->vDataBase->query("SELECT
                                                                                tb_ibnc_sorter.n_sortergroup,
                                                                                tb_ibnc_sorter.c_nameweb,
                                                                                (SELECT
                                                                                        COUNT(tb_ibnc_web_courses.n_codwebcourses)
                                                                                    FROM tb_ibnc_web_courses
                                                                                        WHERE tb_ibnc_web_courses.IdTipo = tb_ibnc_sorter.n_idclasificador
                                                                                            AND tb_ibnc_web_courses.n_status = 1) AS nCount,
                                                                                (SELECT
                                                                                        COUNT(tb_ibnc_courses.n_codcourses)
                                                                                    FROM tb_ibnc_courses
                                                                                        WHERE tb_ibnc_courses.n_idclasificador = tb_ibnc_sorter.n_idclasificador
                                                                                            AND tb_ibnc_courses.n_status = 1) AS nCountWeb,
                                                                                (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_sorter.n_codimages_ico) AS c_image_name_ico,
                                                                                (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_sorter.n_codimages) AS c_image_name
                                                                            FROM tb_ibnc_sorter
                                                                                WHERE tb_ibnc_sorter.n_status = 1
                                                                                    GROUP BY tb_ibnc_sorter.n_sortergroup
                                                                                        ORDER BY tb_ibnc_sorter.n_sortergroup ASC");
				return $vResultGetIbnorcaCoursesArea->fetchAll();
				$vResultGetIbnorcaCoursesArea->close();
			}
            public function getIbnorcaSorterCoursesItem($vIdTipo)
			{
                $vIdTipo = (int) $vIdTipo;
				$vResultGetIbnorcaCoursesArea = $this->vDataBase->query("SELECT
tb_ibnc_sorter.c_nameweb,
tb_ibnc_sorter.c_textweb,
tb_ibnc_sorter.n_idclasificador AS IdTipo,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_sorter.n_codimages_ico) AS c_image_name_ico,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_sorter.n_codimages) AS c_image_name,
(SELECT COUNT(tb_ibnc_web_courses.n_codwebcourses) FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdTipo = tb_ibnc_sorter.n_idclasificador) AS nCount,
(SELECT COUNT(tb_ibnc_courses.n_codcourses) FROM tb_ibnc_courses WHERE tb_ibnc_courses.n_idclasificador = tb_ibnc_sorter.n_idclasificador) AS nCountWeb
FROM tb_ibnc_sorter
WHERE tb_ibnc_sorter.n_order > 0
AND tb_ibnc_sorter.n_idclasificador in($vIdTipo)
GROUP BY tb_ibnc_sorter.c_nameweb
ORDER BY tb_ibnc_sorter.n_order ASC");
				return $vResultGetIbnorcaCoursesArea->fetchAll();
				$vResultGetIbnorcaCoursesArea->close();
			}
            
            public function getModulesXCourses($vIdUnico)
			{
                $vIdUnico = (int) $vIdUnico;
				$vResultGetIbnorcaCoursesArea = $this->vDataBase->query("SELECT tb_ibnc_web_courses.horas_modulo FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdUnico = $vIdUnico;");
				return $vResultGetIbnorcaCoursesArea->fetchColumn();
				$vResultGetIbnorcaCoursesArea->close();
			}
            
            public function getIbnorcaCoursesModulos($vIdUnico)
			{
                $vIdUnico = (string) $vIdUnico;
				$vResultGetCoursesModulos = $this->vDataBase->query("SELECT
                tb_ibnc_web_malla.n_codmalla,
                tb_ibnc_web_malla.idmalla,
                tb_ibnc_web_malla.idtipo,
                tb_ibnc_web_malla.IdCurso,
                tb_ibnc_web_malla.idmodulo,
                tb_ibnc_web_malla.FechaMalla,
                tb_ibnc_web_malla.id_persona,
                tb_ibnc_web_malla.d_tipo,
                tb_ibnc_web_malla.Programa,
                tb_ibnc_web_malla.Codigo,
                tb_ibnc_web_malla.NombreNorma,
                tb_ibnc_web_malla.d_modulo,
                tb_ibnc_web_malla.nivel,
                tb_ibnc_web_malla.Objetivo,
                tb_ibnc_web_malla.Contenido,
                GROUP_CONCAT(tb_ibnc_web_malla.CodigoNorma) AS CodigoNorma,
                GROUP_CONCAT(tb_ibnc_web_malla.NombreNorma) AS NombreNorma,
                tb_ibnc_web_malla.d_Area
              FROM tb_ibnc_web_malla
                WHERE tb_ibnc_web_malla.IdCurso = (SELECT tb_ibnc_web_courses.IdPrograma FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdUnico = '$vIdUnico')
                  AND tb_ibnc_web_malla.idTipo = (SELECT tb_ibnc_web_courses.IdTipo FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdUnico = '$vIdUnico')
                    GROUP BY tb_ibnc_web_malla.idmalla;");
				return $vResultGetCoursesModulos->fetchAll();
				$vResultGetCoursesModulos->close();
			}
            public function getIbnorcaCoursesLevelGroup($vIdUnico)
			{
                $vIdUnico = (string) $vIdUnico;
				$vResultGetCoursesModulos = $this->vDataBase->query("SELECT
  tb_ibnc_web_malla.nivel
FROM tb_ibnc_web_malla
  WHERE tb_ibnc_web_malla.IdCurso = (SELECT tb_ibnc_web_courses.IdPrograma FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdUnico = '$vIdUnico')
    AND tb_ibnc_web_malla.idTipo = (SELECT tb_ibnc_web_courses.IdTipo FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdUnico = '$vIdUnico')
      GROUP BY tb_ibnc_web_malla.nivel
      ORDER BY tb_ibnc_web_malla.n_codmalla ASC;");
				return $vResultGetCoursesModulos->fetchAll();
				$vResultGetCoursesModulos->close();
			}                        
            public function getIbnorcaMallaArea()
			{
				$vResultGetIbnorcaMallaArea = $this->vDataBase->query("SELECT COUNT(*) AS nCount, tb_ibnc_web_malla.d_Area FROM tb_ibnc_web_malla GROUP BY tb_ibnc_web_malla.d_Area;");
				return $vResultGetIbnorcaMallaArea->fetchAll();
				$vResultGetIbnorcaMallaArea->close();
			}
            public function getIbnorcaMallaPorArea($vArea)
			{
                $vArea = (string) $vArea;
				$vResultGetIbnorcaMallaPorArea = $this->vDataBase->query("SELECT
                                                                                tb_ibnc_web_malla.nivel,
                                                                                tb_ibnc_web_malla.d_tipo,
                                                                                tb_ibnc_web_malla.Programa
                                                                            FROM tb_ibnc_web_malla
                                                                                WHERE tb_ibnc_web_malla.d_Area = '$vArea'
                                                                                    GROUP BY tb_ibnc_web_malla.nivel;");
				return $vResultGetIbnorcaMallaPorArea->fetchAll();
				$vResultGetIbnorcaMallaPorArea->close();
			}
            public function getIbnorcaCourseArea($vArea)
			{
                $vArea = (string) $vArea;
				$vResultGetIbnorcaMallaPorArea = $this->vDataBase->query("SELECT
                tb_ibnc_web_courses.FechaInicio,
                tb_ibnc_web_courses.Programa,
                tb_ibnc_web_courses.Area,
                tb_ibnc_web_courses.IdUnico,
                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 1 LIMIT 1) AS image_principal,
                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 2 LIMIT 1) AS image_secundaria,
                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 3 LIMIT 1) AS image_banner
                FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdArea = '$vArea';");
				return $vResultGetIbnorcaMallaPorArea->fetchAll();
				$vResultGetIbnorcaMallaPorArea->close();
			}
            public function getIbnorcaCourseTipo($vTipo)
			{
                $vTipo = (string) $vTipo;
				$vResultGetIbnorcaMallaPorArea = $this->vDataBase->query("SELECT
tb_ibnc_web_courses.FechaInicio,
tb_ibnc_web_courses.Programa,
tb_ibnc_web_courses.Area,
tb_ibnc_web_courses.IdUnico,
(SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 1 LIMIT 1) AS image_principal,
(SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 2 LIMIT 1) AS image_secundaria,
(SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 3 LIMIT 1) AS image_banner
FROM tb_ibnc_web_courses, tb_ibnc_sorter
WHERE tb_ibnc_web_courses.IdTipo = tb_ibnc_sorter.n_idclasificador
AND tb_ibnc_sorter.n_sortergroup in($vTipo)
AND tb_ibnc_web_courses.n_status = 1;");
				return $vResultGetIbnorcaMallaPorArea->fetchAll();
				$vResultGetIbnorcaMallaPorArea->close();
			}                                                
            public function getIbnorcaUpcomingCourses()
			{
				$vResultGetIbnorcaUpcomingCourses = $this->vDataBase->query("SELECT
                tb_ibnc_web_courses.FechaInicio,
                tb_ibnc_web_courses.Programa,
                tb_ibnc_web_courses.Area,
                tb_ibnc_web_courses.IdUnico,
                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 1 LIMIT 1) AS image_principal,
                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 2 LIMIT 1) AS image_secundaria,
                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 3 LIMIT 1) AS image_banner
                FROM tb_ibnc_web_courses
                WHERE tb_ibnc_web_courses.n_status = 1
                AND DATE(tb_ibnc_web_courses.FechaInicio) >= CURDATE()
                ORDER BY tb_ibnc_web_courses.FechaInicio ASC LIMIT 4;");
				return $vResultGetIbnorcaUpcomingCourses->fetchAll();
				$vResultGetIbnorcaUpcomingCourses->close();
			}                        
            public function getIbnorcaCourses()
			{
				$vResultGetIbnorcaCourses = $this->vDataBase->query("SELECT
                tb_ibnc_web_courses.*,
                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 1 LIMIT 1) AS image_principal,
                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 2 LIMIT 1) AS image_secundaria,
                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 3 LIMIT 1) AS image_banner
                FROM tb_ibnc_web_courses
                WHERE tb_ibnc_web_courses.n_status = 1
                AND DATE(tb_ibnc_web_courses.FechaInicio) >= CURDATE()
                LIMIT 4;");
				return $vResultGetIbnorcaCourses->fetchAll();
				$vResultGetIbnorcaCourses->close();
			}
            public function getIbnorcaCoursesList()
			{
				$vResultGetIbnorcaCourses = $this->vDataBase->query("SELECT
                tb_ibnc_web_courses.*,
                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 1 LIMIT 1) AS image_principal,
                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 2 LIMIT 1) AS image_secundaria,
                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 3 LIMIT 1) AS image_banner
                FROM tb_ibnc_web_courses;");
				return $vResultGetIbnorcaCourses->fetchAll();
				$vResultGetIbnorcaCourses->close();
			}
            public function getIbnorcaCoursesByTipo($vTipo)
			{
                $vTipo = (string) $vTipo;
				$vResultGetIbnorcaCourses = $this->vDataBase->query("SELECT
                tb_ibnc_web_courses.*,
                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 1 LIMIT 1) AS image_principal,
                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 2 LIMIT 1) AS image_secundaria,
                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 3 LIMIT 1) AS image_banner
                FROM tb_ibnc_web_courses
                WHERE tb_ibnc_web_courses.IdTipo = '$vTipo'
                AND tb_ibnc_web_courses.n_status = 1;;");
				return $vResultGetIbnorcaCourses->fetchAll();
				$vResultGetIbnorcaCourses->close();
			}            
            public function getIbnorcaCoursesBySector()
			{
				$vResultGetIbnorcaCoursesBySector = $this->vDataBase->query("SELECT tb_ibnc_web_courses.SectorInteres, count(tb_ibnc_web_courses.SectorInteres) AS nCount FROM tb_ibnc_web_courses GROUP BY tb_ibnc_web_courses.SectorInteres;");
				return $vResultGetIbnorcaCoursesBySector->fetchAll();
				$vResultGetIbnorcaCoursesBySector->close();
			}            
            public function getIbnorcaCourseIdTipo($vIdUnico)
			{
                $vIdUnico = (int) $vIdUnico;
				$vResultGetIbnorcaCourses = $this->vDataBase->query("SELECT tb_ibnc_web_courses.IdTipo FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdUnico = $vIdUnico;");
				return $vResultGetIbnorcaCourses->fetchColumn();
				$vResultGetIbnorcaCourses->close();
			}
            public function getIbnorcaCourseIdUnico($vIdUnico)
			{
                $vIdUnico = (int) $vIdUnico;
				$vResultGetIbnorcaCourses = $this->vDataBase->query("SELECT
                                                                            tb_ibnc_web_courses.*,
                                                                            (SELECT tb_ibnc_landing_pdf.c_pdf_name FROM tb_ibnc_landing_pdf WHERE tb_ibnc_landing_pdf.IdUnico = tb_ibnc_web_courses.IdUnico) AS c_pdf_name,
                                                                            (SELECT tb_ibnc_sorter.c_nameweb FROM tb_ibnc_sorter WHERE tb_ibnc_sorter.n_idclasificador = tb_ibnc_web_courses.IdTipo) AS c_nameweb
                                                                        FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdUnico = $vIdUnico;");
				return $vResultGetIbnorcaCourses->fetchAll();
				$vResultGetIbnorcaCourses->close();
			}
            public function getIbnorcaCourseName($vIdUnico)
			{
                $vIdUnico = (int) $vIdUnico;
				$vResultGetIbnorcaCourses = $this->vDataBase->query("SELECT tb_ibnc_web_courses.Programa FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdUnico = $vIdUnico;");
				return $vResultGetIbnorcaCourses->fetchColumn();
				$vResultGetIbnorcaCourses->close();
			}                        
            public function getIbnorcaLandingContent($vIdUnico)
			{
                $vIdUnico = (int) $vIdUnico;
				$vResultGetIbnorcaLandingContent = $this->vDataBase->query("SELECT * FROM tb_ibnc_landing_info WHERE tb_ibnc_landing_info.IdUnico = $vIdUnico;");
				return $vResultGetIbnorcaLandingContent->fetchAll();
				$vResultGetIbnorcaLandingContent->close();
			}
            public function getIbnorcaLandingImage($vIdUnico, $vAssignImage)
			{
                $vIdUnico = (int) $vIdUnico;
                $vAssignImage = (int) $vAssignImage;
				$vResultGetIbnorcaLandingContent = $this->vDataBase->query("SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = $vIdUnico AND tb_ibnc_landing_img.c_image_assign = $vAssignImage;");
				return $vResultGetIbnorcaLandingContent->fetchColumn();
				$vResultGetIbnorcaLandingContent->close();
			}                        
            public function getIbnorcaMallaIdMalla($vIdUnico)
			{
                $vIdUnico = (string) $vIdUnico;
				$vResultGetIbnorcaCourses = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_malla WHERE tb_ibnc_web_malla.idmalla = $vIdUnico;");
				return $vResultGetIbnorcaCourses->fetchAll();
				$vResultGetIbnorcaCourses->close();
			}            
            public function getIbnorcaStandardization()
			{
				$vResultGetIbnorcaStandardization = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_standardization;");
				return $vResultGetIbnorcaStandardization->fetchAll();
				$vResultGetIbnorcaStandardization->close();
			}
            public function getIbnorcaActiveCommiteesBySector()
			{
				$vResultGetIbnorcaActiveCommiteesBySector = $this->vDataBase->query("SELECT
                                                                                            tb_ibnc_web_activecommitees.Sector,
                                                                                            COUNT(tb_ibnc_web_activecommitees.Sector) as n_num_sector,
                                                                                            (
                                                                                                SUM(tb_ibnc_web_activecommitees.NormasEQNB) +
                                                                                                SUM(tb_ibnc_web_activecommitees.NormasAPNB) +
                                                                                                SUM(tb_ibnc_web_activecommitees.NormasPNB) +
                                                                                                SUM(tb_ibnc_web_activecommitees.NormasNB)
                                                                                            ) AS n_sum_activecommitees
                                                                                        FROM tb_ibnc_web_activecommitees
                                                                                            GROUP BY tb_ibnc_web_activecommitees.Sector
                                                                                                ORDER BY tb_ibnc_web_activecommitees.n_codwebactivecommitee ASC;");
				return $vResultGetIbnorcaActiveCommiteesBySector->fetchAll();
				$vResultGetIbnorcaActiveCommiteesBySector->close();
			}
            public function getIbnorcaSubCommitees($vNumeroComite)
			{
                $vNumeroComite = (string) $vNumeroComite;
				$vResultGetIbnorcaSubCommitees = $this->vDataBase->query("SELECT COUNT(*)
                                                                            FROM tb_ibnc_web_activecommitees
                                                                                WHERE NumeroComite LIKE '$vNumeroComite%'
                                                                                    ORDER BY tb_ibnc_web_activecommitees.NumeroComite ASC;");
				return $vResultGetIbnorcaSubCommitees->fetchColumn();
				$vResultGetIbnorcaSubCommitees->close();
			}
            public function getIbnorcaMembersList()
			{
				$vResultGetIbnorcaMembersList = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_members;");
				return $vResultGetIbnorcaMembersList->fetchAll();
				$vResultGetIbnorcaMembersList->close();
			}
            public function getIbnorcaMallaCurricular()
			{
				$vResultGetIbnorcaMallaCurricularList = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_malla;");
				return $vResultGetIbnorcaMallaCurricularList->fetchAll();
				$vResultGetIbnorcaMallaCurricularList->close();
			}
            public function getIbnorcaPublicStandards()
			{
				$vResultGetIbnorcaPublicStandardsList = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_standardspublic;");
				return $vResultGetIbnorcaPublicStandardsList->fetchAll();
				$vResultGetIbnorcaPublicStandardsList->close();
			}
            public function getIbnorcaSystemicReview()
			{
				$vResultGetIbnorcaSystemicReviewList = $this->vDataBase->query("SELECT * FROM tb_ibnc_apiibnorca_systemicreview;");
				return $vResultGetIbnorcaSystemicReviewList->fetchAll();
				$vResultGetIbnorcaSystemicReviewList->close();
			}            
            public function getIbnorcaStandardsInDevelopmentList()
			{
				$vResultGetIbnorcaStandardsInDevelopmentList = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_standardsindevelopment;");
				return $vResultGetIbnorcaStandardsInDevelopmentList->fetchAll();
				$vResultGetIbnorcaStandardsInDevelopmentList->close();
			}            
            public function getIbnorcaCatalogoDeNormas()
			{
				$vResultGetIbnorcaCatalogoDeNormasList = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_standardscatalog;");
				return $vResultGetIbnorcaCatalogoDeNormasList->fetchAll();
				$vResultGetIbnorcaCatalogoDeNormasList->close();
			}                                                
            public function getIbnorcaMembers($vNumeroComite)
			{
                $vNumeroComite = (string) $vNumeroComite;
				$vResultGetIbnorcaSubCommitees = $this->vDataBase->query("SELECT COUNT(*)
                                                                            FROM tb_ibnc_web_activecommitees
                                                                                WHERE NumeroComite LIKE '$vNumeroComite%'
                                                                                    ORDER BY tb_ibnc_web_activecommitees.NumeroComite ASC;");
				return $vResultGetIbnorcaSubCommitees->fetchColumn();
				$vResultGetIbnorcaSubCommitees->close();
			}            
            public function getIbnorcaDataSubCommitees($vNumeroComite)
			{
                $vNumeroComite = (string) $vNumeroComite;
				$vResultGetIbnorcaDataSubCommitees = $this->vDataBase->query("SELECT
                                                                                tb_ibnc_web_activecommitees.n_codwebactivecommitee,
                                                                                tb_ibnc_web_activecommitees.Sector,
                                                                                tb_ibnc_web_activecommitees.id_comite,
                                                                                tb_ibnc_web_activecommitees.NumeroComite,
                                                                                tb_ibnc_web_activecommitees.NombreComite,
                                                                                tb_ibnc_web_activecommitees.FechaActivacion,
                                                                                tb_ibnc_web_activecommitees.FechaFinalizacion,
                                                                                tb_ibnc_web_activecommitees.Estado,
                                                                                tb_ibnc_web_activecommitees.NormasEQNB,
                                                                                tb_ibnc_web_activecommitees.NormasAPNB,
                                                                                tb_ibnc_web_activecommitees.NormasPNB,
                                                                                tb_ibnc_web_activecommitees.NormasNB,
                                                                                tb_ibnc_web_activecommitees.Alcance,
                                                                                tb_ibnc_web_activecommitees.Rel_Internacional,
                                                                                tb_ibnc_web_activecommitees.CorreoSecretario,
                                                                                (tb_ibnc_web_activecommitees.NormasEQNB + tb_ibnc_web_activecommitees.NormasAPNB + tb_ibnc_web_activecommitees.NormasPNB + tb_ibnc_web_activecommitees.NormasNB) AS n_sum_activecommitees,
                                                                                (SELECT count(tb_ibnc_web_members.id_persona) FROM tb_ibnc_web_members WHERE tb_ibnc_web_members.NumeroComite = tb_ibnc_web_activecommitees.NumeroComite GROUP BY tb_ibnc_web_members.NumeroComite) AS n_num_members
                                                                            FROM tb_ibnc_web_activecommitees
                                                                                WHERE NumeroComite LIKE '$vNumeroComite%'
                                                                                    ORDER BY tb_ibnc_web_activecommitees.NumeroComite ASC;");
				return $vResultGetIbnorcaDataSubCommitees->fetchAll();
				$vResultGetIbnorcaDataSubCommitees->close();
			}            
            public function getIbnorcaActiveCommiteeBySector($vSectorComiteActivo)
			{
                $vSectorComiteActivo = (string) $vSectorComiteActivo;
				$vResultGetIbnorcaActiveCommiteesBySector = $this->vDataBase->query("SELECT
                                                                                        tb_ibnc_web_activecommitees.Sector,
                                                                                        tb_ibnc_web_activecommitees.n_codwebactivecommitee,
                                                                                        tb_ibnc_web_activecommitees.id_comite,
                                                                                        tb_ibnc_web_activecommitees.NumeroComite,
                                                                                        tb_ibnc_web_activecommitees.NombreComite,
                                                                                        tb_ibnc_web_activecommitees.FechaActivacion,
                                                                                        tb_ibnc_web_activecommitees.FechaFinalizacion,
                                                                                        tb_ibnc_web_activecommitees.Estado,
                                                                                        tb_ibnc_web_activecommitees.NormasEQNB,
                                                                                        tb_ibnc_web_activecommitees.NormasAPNB,
                                                                                        tb_ibnc_web_activecommitees.NormasPNB,
                                                                                        tb_ibnc_web_activecommitees.NormasNB,
                                                                                        tb_ibnc_web_activecommitees.Alcance,
                                                                                        tb_ibnc_web_activecommitees.Rel_Internacional,
                                                                                        tb_ibnc_web_activecommitees.CorreoSecretario,
                                                                                        (tb_ibnc_web_activecommitees.NormasEQNB + tb_ibnc_web_activecommitees.NormasAPNB + tb_ibnc_web_activecommitees.NormasPNB + tb_ibnc_web_activecommitees.NormasNB) AS n_sum_activecommitees,
                                                                                        (SELECT count(tb_ibnc_web_members.id_persona) FROM tb_ibnc_web_members WHERE tb_ibnc_web_members.NumeroComite = tb_ibnc_web_activecommitees.NumeroComite GROUP BY tb_ibnc_web_members.NumeroComite) AS n_num_members
                                                                                        FROM tb_ibnc_web_activecommitees
                                                                                            WHERE tb_ibnc_web_activecommitees.Sector = '$vSectorComiteActivo'
                                                                                                ORDER BY tb_ibnc_web_activecommitees.NumeroComite ASC;");
				return $vResultGetIbnorcaActiveCommiteesBySector->fetchAll();
				$vResultGetIbnorcaActiveCommiteesBySector->close();
			}
            public function getIbnorcaActiveCommiteeByCod($vCodComiteActivo)
			{
                $vCodComiteActivo = (int) $vCodComiteActivo;
				$vResultGetIbnorcaActiveCommiteesByCod = $this->vDataBase->query("SELECT
                                                                                        tb_ibnc_web_activecommitees.n_codwebactivecommitee,
                                                                                        tb_ibnc_web_activecommitees.Sector,
                                                                                        tb_ibnc_web_activecommitees.id_comite,
                                                                                        tb_ibnc_web_activecommitees.NumeroComite,
                                                                                        tb_ibnc_web_activecommitees.NombreComite,
                                                                                        tb_ibnc_web_activecommitees.FechaActivacion,
                                                                                        tb_ibnc_web_activecommitees.FechaFinalizacion,
                                                                                        tb_ibnc_web_activecommitees.Estado,
                                                                                        tb_ibnc_web_activecommitees.NormasEQNB,
                                                                                        tb_ibnc_web_activecommitees.NormasAPNB,
                                                                                        tb_ibnc_web_activecommitees.NormasPNB,
                                                                                        tb_ibnc_web_activecommitees.NormasNB,
                                                                                        tb_ibnc_web_activecommitees.Alcance,
                                                                                        tb_ibnc_web_activecommitees.Rel_Internacional,
                                                                                        tb_ibnc_web_activecommitees.CorreoSecretario,
                                                                                        (tb_ibnc_web_activecommitees.NormasEQNB + tb_ibnc_web_activecommitees.NormasAPNB + tb_ibnc_web_activecommitees.NormasPNB + tb_ibnc_web_activecommitees.NormasNB) AS n_sum_activecommitees,
                                                                                    (SELECT COUNT(*) FROM tb_ibnc_web_standardization WHERE numerocomite = tb_ibnc_web_activecommitees.NumeroComite) as public_NormasNB,
                                                                                    (SELECT count(tb_ibnc_web_members.id_persona) FROM tb_ibnc_web_members WHERE tb_ibnc_web_members.NumeroComite = tb_ibnc_web_activecommitees.NumeroComite GROUP BY tb_ibnc_web_members.NumeroComite) AS n_num_members
                                                                                        FROM tb_ibnc_web_activecommitees
                                                                                            WHERE tb_ibnc_web_activecommitees.id_comite = $vCodComiteActivo
                                                                                                ORDER BY tb_ibnc_web_activecommitees.NumeroComite ASC;");
				return $vResultGetIbnorcaActiveCommiteesByCod->fetchAll();
				$vResultGetIbnorcaActiveCommiteesByCod->close();
			}                        
            public function getIbnorcaActiveCommiteesBySectorExists($vSectorComiteActivo)
			{
                $vSectorComiteActivo = (string) $vSectorComiteActivo;
				$vResultGetIbnorcaActiveCommiteesBySector = $this->vDataBase->query("SELECT
                                                                                            COUNT(tb_ibnc_web_activecommitees.Sector)
                                                                                        FROM tb_ibnc_web_activecommitees
                                                                                            WHERE tb_ibnc_web_activecommitees.Sector = '$vSectorComiteActivo'
                                                                                                ORDER BY tb_ibnc_web_activecommitees.NumeroComite ASC;");
				return $vResultGetIbnorcaActiveCommiteesBySector->fetchColumn();
				$vResultGetIbnorcaActiveCommiteesBySector->close();
			}            
            public function getIbnorcaActiveCommitees()
			{
				$vResultGetIbnorcaActiveCommitees = $this->vDataBase->query("SELECT
    tb_ibnc_web_activecommitees.n_codwebactivecommitee,
    tb_ibnc_web_activecommitees.Sector,
    tb_ibnc_web_activecommitees.id_comite,
    tb_ibnc_web_activecommitees.NumeroComite,
    tb_ibnc_web_activecommitees.NombreComite,
    tb_ibnc_web_activecommitees.FechaActivacion,
    tb_ibnc_web_activecommitees.FechaFinalizacion,
    tb_ibnc_web_activecommitees.Estado,
    (SELECT
        COUNT(*)
      FROM tb_ibnc_web_standardsindevelopment
        WHERE tb_ibnc_web_standardsindevelopment.nroComite = tb_ibnc_web_activecommitees.NumeroComite
          AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'EQNB%'
          AND tb_ibnc_web_standardsindevelopment.estado <> 'Cancelada') AS NormasEQNB,
    (SELECT
        COUNT(*)              
      FROM tb_ibnc_web_standardsindevelopment
        WHERE tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'APNB%'
          AND tb_ibnc_web_standardsindevelopment.nroComite = tb_ibnc_web_activecommitees.NumeroComite) AS NormasAPNB,
    (SELECT
        COUNT(*)
      FROM tb_ibnc_web_standardsindevelopment
        WHERE tb_ibnc_web_standardsindevelopment.nroComite = tb_ibnc_web_activecommitees.NumeroComite
          AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'PNB%') AS NormasPNB,
    (SELECT
        COUNT(*)
      FROM tb_ibnc_web_standardscatalog
        WHERE tb_ibnc_web_standardscatalog.NumeroComite = tb_ibnc_web_activecommitees.NumeroComite
          AND tb_ibnc_web_standardscatalog.EnWeb = 'Si') AS NormasNB,
    ((SELECT
        COUNT(*)
      FROM tb_ibnc_web_standardsindevelopment
        WHERE tb_ibnc_web_standardsindevelopment.nroComite = tb_ibnc_web_activecommitees.NumeroComite
          AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'EQNB%'
          AND tb_ibnc_web_standardsindevelopment.estado <> 'Cancelada') +
    (SELECT
        COUNT(*)              
      FROM tb_ibnc_web_standardsindevelopment
        WHERE tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'APNB%'
          AND tb_ibnc_web_standardsindevelopment.nroComite = tb_ibnc_web_activecommitees.NumeroComite) +
    (SELECT
        COUNT(*)
      FROM tb_ibnc_web_standardsindevelopment
        WHERE tb_ibnc_web_standardsindevelopment.nroComite = tb_ibnc_web_activecommitees.NumeroComite
          AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'PNB%')
    ) AS NormasEnDesarrollo,
    tb_ibnc_web_activecommitees.Alcance,
    tb_ibnc_web_activecommitees.Rel_Internacional,
    tb_ibnc_web_activecommitees.CorreoSecretario,
    (tb_ibnc_web_activecommitees.NormasEQNB + tb_ibnc_web_activecommitees.NormasAPNB + tb_ibnc_web_activecommitees.NormasPNB + tb_ibnc_web_activecommitees.NormasNB) AS n_sum_activecommitees,
    (SELECT count(tb_ibnc_web_members.id_persona) FROM tb_ibnc_web_members WHERE tb_ibnc_web_members.NumeroComite = tb_ibnc_web_activecommitees.NumeroComite GROUP BY tb_ibnc_web_members.NumeroComite) AS n_num_members
FROM tb_ibnc_web_activecommitees;");
				return $vResultGetIbnorcaActiveCommitees->fetchAll();
				$vResultGetIbnorcaActiveCommitees->close();
			}
            public function getSectorActiveCommitees($vIdSector)
			{
                $vIdSector = (int) $vIdSector;
				$vResultGetIbnorcaActiveCommitees = $this->vDataBase->query("SELECT
    tb_ibnc_web_activecommitees.n_codwebactivecommitee,
    tb_ibnc_web_activecommitees.Sector,
    tb_ibnc_web_activecommitees.id_comite,
    tb_ibnc_web_activecommitees.NumeroComite,
    tb_ibnc_web_activecommitees.NombreComite,
    tb_ibnc_web_activecommitees.FechaActivacion,
    tb_ibnc_web_activecommitees.FechaFinalizacion,
    tb_ibnc_web_activecommitees.Estado,
    (SELECT
        COUNT(*)
      FROM tb_ibnc_web_standardsindevelopment
        WHERE tb_ibnc_web_standardsindevelopment.nroComite = tb_ibnc_web_activecommitees.NumeroComite
          AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'EQNB%'
          AND tb_ibnc_web_standardsindevelopment.estado <> 'Cancelada') AS NormasEQNB,
    (SELECT
        COUNT(*)              
      FROM tb_ibnc_web_standardsindevelopment
        WHERE tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'APNB%'
          AND tb_ibnc_web_standardsindevelopment.nroComite = tb_ibnc_web_activecommitees.NumeroComite) AS NormasAPNB,
    (SELECT
        COUNT(*)
      FROM tb_ibnc_web_standardsindevelopment
        WHERE tb_ibnc_web_standardsindevelopment.nroComite = tb_ibnc_web_activecommitees.NumeroComite
          AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'PNB%') AS NormasPNB,
    (SELECT
        COUNT(*)
      FROM tb_ibnc_web_standardscatalog
        WHERE tb_ibnc_web_standardscatalog.NumeroComite = tb_ibnc_web_activecommitees.NumeroComite
          AND tb_ibnc_web_standardscatalog.EnWeb = 'Si') AS NormasNB,
    ((SELECT
        COUNT(*)
      FROM tb_ibnc_web_standardsindevelopment
        WHERE tb_ibnc_web_standardsindevelopment.nroComite = tb_ibnc_web_activecommitees.NumeroComite
          AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'EQNB%'
          AND tb_ibnc_web_standardsindevelopment.estado <> 'Cancelada') +
    (SELECT
        COUNT(*)              
      FROM tb_ibnc_web_standardsindevelopment
        WHERE tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'APNB%'
          AND tb_ibnc_web_standardsindevelopment.nroComite = tb_ibnc_web_activecommitees.NumeroComite) +
    (SELECT
        COUNT(*)
      FROM tb_ibnc_web_standardsindevelopment
        WHERE tb_ibnc_web_standardsindevelopment.nroComite = tb_ibnc_web_activecommitees.NumeroComite
          AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'PNB%')
    ) AS NormasEnDesarrollo,
    tb_ibnc_web_activecommitees.Alcance,
    tb_ibnc_web_activecommitees.Rel_Internacional,
    tb_ibnc_web_activecommitees.CorreoSecretario,
    (tb_ibnc_web_activecommitees.NormasEQNB + tb_ibnc_web_activecommitees.NormasAPNB + tb_ibnc_web_activecommitees.NormasPNB + tb_ibnc_web_activecommitees.NormasNB) AS n_sum_activecommitees,
    (SELECT count(tb_ibnc_web_members.id_persona) FROM tb_ibnc_web_members WHERE tb_ibnc_web_members.NumeroComite = tb_ibnc_web_activecommitees.NumeroComite GROUP BY tb_ibnc_web_members.NumeroComite) AS n_num_members
FROM tb_ibnc_web_activecommitees
    WHERE tb_ibnc_web_activecommitees.NumeroComite LIKE '".$vIdSector.".%';");
				return $vResultGetIbnorcaActiveCommitees->fetchAll();
				$vResultGetIbnorcaActiveCommitees->close();
			}
            public function getIbnorcaStandardizationByNumComite($vNumComite)
			{
                $vNumComite = (string) $vNumComite;
				$vResultGetIbnorcaActiveCommitees = $this->vDataBase->query("SELECT *
                                                                                    FROM tb_ibnc_web_activecommitees, tb_ibnc_web_standardsindevelopment
                                                                                WHERE tb_ibnc_web_activecommitees.NumeroComite = tb_ibnc_web_standardsindevelopment.nroComite
                                                                                    AND tb_ibnc_web_activecommitees.NumeroComite = '".$vNumComite."'
                                                                                        ORDER BY tb_ibnc_web_standardsindevelopment.CodigoNomra;");
				return $vResultGetIbnorcaActiveCommitees->fetchAll();
				$vResultGetIbnorcaActiveCommitees->close();
			}
            public function DataIbnorcaStandardizationPublic($vNumComite)
			{
                $vNumComite = (string) $vNumComite;
				$vResultGetIbnorcaActiveCommitees = $this->vDataBase->query("SELECT tb_ibnc_web_standardization.*
                                                                                FROM tb_ibnc_web_standardization
                                                                                    WHERE numerocomite = '".$vNumComite."'
                                                                                        ORDER BY tb_ibnc_web_standardization.codigo;");
				return $vResultGetIbnorcaActiveCommitees->fetchAll();
				$vResultGetIbnorcaActiveCommitees->close();
			}
            public function DataIbnorcaStandardsCatalog($vNumComite)
			{
                $vNumComite = (string) $vNumComite;
				$vResultGetIbnorcaActiveCommitees = $this->vDataBase->query("SELECT tb_ibnc_web_standardscatalog.*
                                                                                FROM tb_ibnc_web_standardscatalog
                                                                                    WHERE tb_ibnc_web_standardscatalog.NumeroComite = '".$vNumComite."'
                                                                                        ORDER BY tb_ibnc_web_standardscatalog.CodigoNorma;");
				return $vResultGetIbnorcaActiveCommitees->fetchAll();
				$vResultGetIbnorcaActiveCommitees->close();
			}            
            public function getStandardsInDevelopmentByFilter($vNroComite, $vCodeStandard)
			{
                $vNroComite = (string) $vNroComite;
                $vCodeStandard = (string) $vCodeStandard;
				$vResultGetStandardsInDevelopmentByFilter = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_standardsindevelopment WHERE nroComite = '".$vNroComite."' AND codigoNomra LIKE '".$vCodeStandard."%';");
				return $vResultGetStandardsInDevelopmentByFilter->fetchAll();
				$vResultGetStandardsInDevelopmentByFilter->close();
			}
            public function getPublishedStandardsByFilter($vNroComite, $vCodeStandard)
			{
                $vNroComite = (string) $vNroComite;
                $vCodeStandard = (string) $vCodeStandard;
				$vResultGetPublishedStandardsByFilter = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_standardization WHERE numerocomite = '".$vNroComite."' AND codigo LIKE '".$vCodeStandard."%';");
				return $vResultGetPublishedStandardsByFilter->fetchAll();
				$vResultGetPublishedStandardsByFilter->close();
			}                                    
            public function getNorma($vCode)
			{
                $vCode = (int) $vCode;
				$vResultGetIbnorcaActiveCommitees = $this->vDataBase->query("SELECT
                tb_ibnc_web_standardsindevelopment.n_codwebstandardsindevelopment,
                tb_ibnc_web_standardsindevelopment.CodigoNomra as CodigoNomra,
                tb_ibnc_web_standardsindevelopment.estado as estado,
                tb_ibnc_web_standardsindevelopment.nroComite as NumeroComite,
                tb_ibnc_web_standardsindevelopment.TituloNorma as TituloNorma,
                tb_ibnc_web_standardsindevelopment.Alcance as Alcance,
                tb_ibnc_web_standardsindevelopment.estado_fecha as FechaVigencia,
                'N/A' as CantidadHojas,
                'N/A' as Observaciones
                FROM tb_ibnc_web_standardsindevelopment
                WHERE tb_ibnc_web_standardsindevelopment.n_codwebstandardsindevelopment = $vCode;");
				return $vResultGetIbnorcaActiveCommitees->fetchAll();
				$vResultGetIbnorcaActiveCommitees->close();
			}
            public function getNorma2($vCode)
			{
                $vCode = (int) $vCode;
				$vResultGetIbnorcaActiveCommitees = $this->vDataBase->query("SELECT
                tb_ibnc_web_standardization.n_codwebstandardization,
                tb_ibnc_web_standardization.codigo as CodigoNomra,
                tb_ibnc_web_standardization.vigente as estado,
                tb_ibnc_web_standardization.numerocomite as NumeroComite,
                tb_ibnc_web_standardization.nombreNorma as TituloNorma,
                tb_ibnc_web_standardization.alcance as Alcance,
                'N/A' as FechaVigencia,
                'N/A' as CantidadHojas,
                'N/A' as Observaciones
                FROM tb_ibnc_web_standardization
                WHERE tb_ibnc_web_standardization.n_codwebstandardization = $vCode;");
				return $vResultGetIbnorcaActiveCommitees->fetchAll();
				$vResultGetIbnorcaActiveCommitees->close();
			}
            public function getNorma3($vCode)
			{
                $vCode = (int) $vCode;
				$vResultGetIbnorcaActiveCommitees = $this->vDataBase->query("SELECT
                tb_ibnc_web_standardscatalog.n_codwebstandardscatalog,
                tb_ibnc_web_standardscatalog.CodigoNorma as CodigoNomra,
                'Publicada' as estado,
                tb_ibnc_web_standardscatalog.NumeroComite,
                tb_ibnc_web_standardscatalog.NombreNorma as TituloNorma,
                tb_ibnc_web_standardscatalog.Alcance as Alcance,
                tb_ibnc_web_standardscatalog.FechaVigencia,
                tb_ibnc_web_standardscatalog.CantidadHojas,
                tb_ibnc_web_standardscatalog.Observaciones
                FROM tb_ibnc_web_standardscatalog
                WHERE tb_ibnc_web_standardscatalog.n_codwebstandardscatalog = $vCode;");
				return $vResultGetIbnorcaActiveCommitees->fetchAll();
				$vResultGetIbnorcaActiveCommitees->close();
			}                        
            public function getIbnorcaStandardsInDevelopment($vNumComite)
			{
                $vNumComite = (int) $vNumComite;
				$vResultGetIbnorcaStandardsInDevelopment = $this->vDataBase->query("SELECT
                                                                                        tb_ibnc_web_activecommitees.NormasEQNB,
                                                                                        tb_ibnc_web_activecommitees.NormasAPNB,
                                                                                        tb_ibnc_web_activecommitees.NormasPNB,
                                                                                        tb_ibnc_web_activecommitees.NormasNB
                                                                                    FROM tb_ibnc_web_activecommitees
                                                                                        WHERE tb_ibnc_web_activecommitees.id_comite = $vNumComite;");
				return $vResultGetIbnorcaStandardsInDevelopment->fetchAll();
				$vResultGetIbnorcaStandardsInDevelopment->close();
			}            
            public function getIbnorcaStandardizationNumeroComite($vCodIdComite)
			{
                $vCodIdComite = (string) $vCodIdComite;
				$vResultGetIbnorcaStandardizationNumeroComite = $this->vDataBase->query("SELECT
                                                                                    tb_ibnc_web_activecommitees.NumeroComite
                                                                                FROM tb_ibnc_web_activecommitees
                                                                                    WHERE tb_ibnc_web_activecommitees.id_comite = '$vCodIdComite';");
				return $vResultGetIbnorcaStandardizationNumeroComite->fetchColumn();
				$vResultGetIbnorcaStandardizationNumeroComite->close();
			}
            public function getIbnorcaStandardsPublic()
			{
				$vResultGetIbnorcaStandardsPublic = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_standardsindevelopment WHERE id_etapa = 'APNB';");
				return $vResultGetIbnorcaStandardsPublic->fetchAll();
				$vResultGetIbnorcaStandardsPublic->close();
			}
            public function getGroupSectorStandardsPublic()
			{
				$vResultGetGroupSectorStandardsPublic = $this->vDataBase->query("SELECT
tb_ibnc_web_standardscatalog.NombreSector
FROM tb_ibnc_web_standardsindevelopment, tb_ibnc_web_standardscatalog
WHERE tb_ibnc_web_standardsindevelopment.id_comite = tb_ibnc_web_standardscatalog.IdComite
AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'APNB%'
GROUP BY tb_ibnc_web_standardscatalog.NombreSector;");
				return $vResultGetGroupSectorStandardsPublic->fetchAll();
				$vResultGetGroupSectorStandardsPublic->close();
			}                        
            public function getIbnorcaSectors()
			{
				$vResultGetIbnorcaSectors = $this->vDataBase->query("SELECT tb_ibnc_sectors.*,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_sectors.n_codimg) AS c_image_name,
(SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_sectors.n_codimg) AS c_image_desc,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_sectors.n_codimg2) AS c_image_name2,
(SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_sectors.n_codimg2) AS c_image_desc2,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_sectors.n_codbanner) AS c_image_banner,
(SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_sectors.n_codbanner) AS c_image_descbanner
                FROM tb_ibnc_sectors;");
				return $vResultGetIbnorcaSectors->fetchAll();
				$vResultGetIbnorcaSectors->close();
			}

            

            public function getIbnorcaActiveCommiteesSearch($vSearchString, $vPage)
			{
                $vPage = (int) $vPage;
                $vSearchString = (string) $vSearchString;
				$vResultGetIbnorcaCoursesSearch = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_activecommitees
                WHERE (tb_ibnc_web_activecommitees.Sector LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_activecommitees.NombreComite LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_activecommitees.Alcance LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_activecommitees.Rel_Internacional LIKE '%".$vSearchString."%');");
				return $vResultGetIbnorcaCoursesSearch->fetchAll();
				$vResultGetIbnorcaCoursesSearch->close();
			}
            public function getCountActiveCommiteesSearch($vSearchString)
			{
                $vSearchString = (string) $vSearchString;
				$vResultGetIbnorcaCoursesSearch = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_activecommitees
                WHERE (tb_ibnc_web_activecommitees.NumeroComite LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_activecommitees.Sector LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_activecommitees.NombreComite LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_activecommitees.Alcance LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_activecommitees.Rel_Internacional LIKE '%".$vSearchString."%');");
				return $vResultGetIbnorcaCoursesSearch->fetchAll();
				$vResultGetIbnorcaCoursesSearch->close();
			}






            public function getIbnorcaCoursesSearch($vSearchString, $vPage)
			{
                $vPage = (int) $vPage;
                $vSearchString = (string) $vSearchString;
				$vResultGetIbnorcaCoursesSearch = $this->vDataBase->query("SELECT tb_ibnc_web_courses.*,
(SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 1 LIMIT 1) AS image_principal,
(SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 2 LIMIT 1) AS image_secundaria,
(SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 3 LIMIT 1) AS image_banner                
                FROM tb_ibnc_web_courses
                                                                                    WHERE (tb_ibnc_web_courses.Programa LIKE '%".$vSearchString."%' OR
                                                                                        tb_ibnc_web_courses.Area LIKE '%".$vSearchString."%' OR
                                                                                        tb_ibnc_web_courses.contenido LIKE '%".$vSearchString."%' OR
                                                                                        tb_ibnc_web_courses.objetivo LIKE '%".$vSearchString."%' OR
                                                                                        tb_ibnc_web_courses.SectorInteres LIKE '%".$vSearchString."%' OR
                                                                                        tb_ibnc_web_courses.Orientado LIKE '%".$vSearchString."%' OR
                                                                                        tb_ibnc_web_courses.norma LIKE '%".$vSearchString."%');");
				return $vResultGetIbnorcaCoursesSearch->fetchAll();
				$vResultGetIbnorcaCoursesSearch->close();
			}
            public function getCountIbnorcaCoursesSearch($vSearchString)
			{
                $vSearchString = (string) $vSearchString;
				$vResultGetIbnorcaCoursesSearch = $this->vDataBase->query("SELECT tb_ibnc_web_courses.*,
(SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 1 LIMIT 1) AS image_principal,
(SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 2 LIMIT 1) AS image_secundaria,
(SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_web_courses.IdUnico AND tb_ibnc_landing_img.c_image_assign = 3 LIMIT 1) AS image_banner                
                FROM tb_ibnc_web_courses
                                                                                    WHERE (tb_ibnc_web_courses.Programa LIKE '%".$vSearchString."%' OR
                                                                                        tb_ibnc_web_courses.Area LIKE '%".$vSearchString."%' OR
                                                                                        tb_ibnc_web_courses.contenido LIKE '%".$vSearchString."%' OR
                                                                                        tb_ibnc_web_courses.objetivo LIKE '%".$vSearchString."%' OR
                                                                                        tb_ibnc_web_courses.SectorInteres LIKE '%".$vSearchString."%' OR
                                                                                        tb_ibnc_web_courses.Orientado LIKE '%".$vSearchString."%' OR
                                                                                        tb_ibnc_web_courses.norma LIKE '%".$vSearchString."%');");
				return $vResultGetIbnorcaCoursesSearch->fetchAll();
				$vResultGetIbnorcaCoursesSearch->close();
			}
            public function getIbnorcaStandardsSearch($vSearchString, $vPage)
			{
                $vPage = (int) $vPage;
                $vSearchString = (string) $vSearchString;
                $vResultGetIbnorcaStandardsSearch = $this->vDataBase->query("SELECT
                tb_ibnc_web_standardscatalog.IdNorma as id,
                tb_ibnc_web_standardscatalog.n_codwebstandardscatalog as Codigo,
                tb_ibnc_web_standardscatalog.CodigoNorma as CodigoNorma,
                tb_ibnc_web_standardscatalog.NombreNorma as NombreNorma,
                tb_ibnc_web_standardscatalog.NumeroComite as NumeroComite,
                tb_ibnc_web_standardscatalog.NombreComite as NombreComite,
                tb_ibnc_web_standardscatalog.NombreSector as NombreSector,
                tb_ibnc_web_standardscatalog.Alcance as Alcance,
                'Publicada' as estado
                FROM tb_ibnc_web_standardscatalog
                WHERE (tb_ibnc_web_standardscatalog.CodigoNorma LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_standardscatalog.NombreNorma LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_standardscatalog.Alcance LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_standardscatalog.NombreSector LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_standardscatalog.NombreComite LIKE '%".$vSearchString."%')
                AND tb_ibnc_web_standardscatalog.EnWeb = 'Si'
                UNION ALL
                SELECT
                1 as id,
                tb_ibnc_web_standardsindevelopment.n_codwebstandardsindevelopment as Codigo,
                tb_ibnc_web_standardsindevelopment.CodigoNomra as CodigoNorma,
                tb_ibnc_web_standardsindevelopment.TituloNorma as NombreNorma,
                tb_ibnc_web_standardsindevelopment.nroComite as NumeroComite,
                tb_ibnc_web_standardsindevelopment.nombreComite as NombreComite,
                'N/A' as Alcance,
                'N/A' as NombreSector,
                tb_ibnc_web_standardsindevelopment.estado as estado
                FROM tb_ibnc_web_standardsindevelopment
                WHERE (tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_standardsindevelopment.TituloNorma LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_standardsindevelopment.Alcance LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_standardsindevelopment.nombreComite LIKE '%".$vSearchString."%')
                AND tb_ibnc_web_standardsindevelopment.estado <> 'Cancelada'");                                                                                                
				return $vResultGetIbnorcaStandardsSearch->fetchAll();
				$vResultGetIbnorcaStandardsSearch->close();
			}
            
            public function getIbnorcaNewsSearch($vSearchString,$vPage)
			{
                $vSearchString = (string) $vSearchString;
                $vPage = (int) $vPage;
                $vResultGetIbnorcaStandardsSearch = $this->vDataBase->query("SELECT
                                                                                    tb_ibnc_news.*,
                                                                                    MATCH(c_title, c_text) AGAINST('%".$vSearchString."%' IN BOOLEAN MODE) AS score
                                                                                FROM tb_ibnc_news
                                                                                    WHERE MATCH(c_title, c_text) AGAINST('%".$vSearchString."%' IN BOOLEAN MODE) > 0
                                                                                        ORDER BY score DESC");                                                                                                
				return $vResultGetIbnorcaStandardsSearch->fetchAll();
				$vResultGetIbnorcaStandardsSearch->close();
			}
            public function getCountIbnorcaStandardsSearch($vSearchString)
			{
                $vSearchString = (string) $vSearchString;

				$vResultGetIbnorcaStandardsSearch = $this->vDataBase->query("SELECT
                tb_ibnc_web_standardscatalog.IdNorma as id,
                tb_ibnc_web_standardscatalog.n_codwebstandardscatalog as Codigo,
                tb_ibnc_web_standardscatalog.CodigoNorma as CodigoNorma,
                tb_ibnc_web_standardscatalog.NombreNorma as NombreNorma,
                tb_ibnc_web_standardscatalog.NumeroComite as NumeroComite,
                tb_ibnc_web_standardscatalog.NombreComite as NombreComite,
                tb_ibnc_web_standardscatalog.NombreSector as NombreSector,
                tb_ibnc_web_standardscatalog.Alcance as Alcance,
                'Publicada' as estado
                FROM tb_ibnc_web_standardscatalog
                WHERE tb_ibnc_web_standardscatalog.CodigoNorma LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_standardscatalog.NombreNorma LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_standardscatalog.Alcance LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_standardscatalog.NombreSector LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_standardscatalog.NombreComite LIKE '%".$vSearchString."%'
                AND tb_ibnc_web_standardscatalog.EnWeb = 'Si'
                UNION ALL
                SELECT
                1 as id,
                tb_ibnc_web_standardsindevelopment.n_codwebstandardsindevelopment as Codigo,
                tb_ibnc_web_standardsindevelopment.CodigoNomra as CodigoNorma,
                tb_ibnc_web_standardsindevelopment.TituloNorma as NombreNorma,
                tb_ibnc_web_standardsindevelopment.nroComite as NumeroComite,
                tb_ibnc_web_standardsindevelopment.nombreComite as NombreComite,
                'N/A' as Alcance,
                'N/A' as NombreSector,
                tb_ibnc_web_standardsindevelopment.estado as estado
                FROM tb_ibnc_web_standardsindevelopment
                WHERE tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_standardsindevelopment.TituloNorma LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_standardsindevelopment.Alcance LIKE '%".$vSearchString."%' OR
                tb_ibnc_web_standardsindevelopment.nombreComite LIKE '%".$vSearchString."%'
                AND tb_ibnc_web_standardsindevelopment.estado <> 'Cancelada'");
				return $vResultGetIbnorcaStandardsSearch->fetchAll();
				$vResultGetIbnorcaStandardsSearch->close();
			}
            
            public function getIbnorcaInspectionServices()
			{
				$vResultGetIbnorcaInspectionServices = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_inspection;");
				return $vResultGetIbnorcaInspectionServices->fetchAll();
				$vResultGetIbnorcaInspectionServices->close();
			}

            public function getIbnorcaInspectionService($vCodInspection)
			{
                $vCodInspection = (int) $vCodInspection;
				$vResultGetIbnorcaInspectionService = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_inspection WHERE tb_ibnc_web_inspection.n_codinspection = $vCodInspection;");
				return $vResultGetIbnorcaInspectionService->fetchAll();
				$vResultGetIbnorcaInspectionService->close();
			}            
            
            public function getIbnorcaInspectionServiceContent($vCodInspection)
			{
                $vCodInspection = (int) $vCodInspection;
				$vResultGetIbnorcaInspectionServiceContent = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_inspectiondesc WHERE tb_ibnc_web_inspectiondesc.n_codinspection = $vCodInspection;");
				return $vResultGetIbnorcaInspectionServiceContent->fetchAll();
				$vResultGetIbnorcaInspectionServiceContent->close();
			} 
            
            public function getIbnorcaCourseImages($vIdUnico)
			{
                $vIdUnico = (int) $vIdUnico;
				$vResultGetIbnorcaCourseImages = $this->vDataBase->query("SELECT * FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = $vIdUnico;");
				return $vResultGetIbnorcaCourseImages->fetchAll();
				$vResultGetIbnorcaCourseImages->close();
			}

            public function getIbnorcaCoursePDF($vIdUnico)
			{
                $vIdUnico = (int) $vIdUnico;
				$vResultGetIbnorcaCoursePDF = $this->vDataBase->query("SELECT * FROM tb_ibnc_landing_pdf WHERE tb_ibnc_landing_pdf.IdUnico = $vIdUnico;");
				return $vResultGetIbnorcaCoursePDF->fetchAll();
				$vResultGetIbnorcaCoursePDF->close();
			}            
            
            public function getIbnorcaCourseNameImage($vCodLandingImg)
			{
                $vCodLandingImg = (int) $vCodLandingImg;
				$vResultGetIbnorcaCourseImages = $this->vDataBase->query("SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.n_codlandingimg = $vCodLandingImg;");
				return $vResultGetIbnorcaCourseImages->fetchColumn();
				$vResultGetIbnorcaCourseImages->close();
			}

            public function getIbnorcaCourseNamePDF($vCodLandingPDF)
			{
                $vCodLandingPDF = (int) $vCodLandingPDF;
				$vResultGetIbnorcaCourseImages = $this->vDataBase->query("SELECT tb_ibnc_landing_pdf.c_pdf_name FROM  tb_ibnc_landing_pdf WHERE  tb_ibnc_landing_pdf.n_codlandingpdf = $vCodLandingPDF;");
				return $vResultGetIbnorcaCourseImages->fetchColumn();
				$vResultGetIbnorcaCourseImages->close();
			}

            public function getDataLandingInfo($vIdUnico)
			{
                $vIdUnico = (int) $vIdUnico;
				$vResultGetIbnorcaLandingInfo = $this->vDataBase->query("SELECT * FROM tb_ibnc_landing_info WHERE tb_ibnc_landing_info.IdUnico = $vIdUnico;");
				return $vResultGetIbnorcaLandingInfo->fetchAll();
				$vResultGetIbnorcaLandingInfo->close();
			}

            public function getDataLandingContent($vIdUnico)
			{
                $vIdUnico = (int) $vIdUnico;
				$vResultGetIbnorcaLandingContent = $this->vDataBase->query("SELECT tb_ibnc_landing_info.t_landingcontent FROM tb_ibnc_landing_info WHERE tb_ibnc_landing_info.IdUnico = $vIdUnico;");
				return $vResultGetIbnorcaLandingContent->fetchColumn();
				$vResultGetIbnorcaLandingContent->close();
			}
            
            public function getDataLandingContentExists($vIdUnico)
			{
                $vIdUnico = (int) $vIdUnico;
				$vResultGetIbnorcaLandingContent = $this->vDataBase->query("SELECT COUNT(*) FROM tb_ibnc_landing_info WHERE tb_ibnc_landing_info.IdUnico = $vIdUnico;");
				return $vResultGetIbnorcaLandingContent->fetchColumn();
				$vResultGetIbnorcaLandingContent->close();
			}
            
            public function getIbnorcaFechaLimiteCurso($vIdUnico)
			{
                $vIdUnico = (int) $vIdUnico;
				$vResultGetIbnorcaFechaLimiteCurso = $this->vDataBase->query("SELECT tb_ibnc_web_courses.FechaInicio FROM tb_ibnc_web_courses WHERE IdUnico = $vIdUnico;");
				return $vResultGetIbnorcaFechaLimiteCurso->fetchColumn();
				$vResultGetIbnorcaFechaLimiteCurso->close();
			}
            
            public function getNormasCompletasPorComite($vNumComite){
                $vNumComite = (string) $vNumComite;
                //AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'EQNB%'
                //AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'APNB%'
                //AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'PNB%'
				$vResultGetIbnorcaActiveCommitees = $this->vDataBase->query("SELECT
                tb_ibnc_web_standardsindevelopment.n_codwebstandardsindevelopment AS n_cod,
'eqnb' as c_type,
'N/A' as IdNorma,
tb_ibnc_web_standardsindevelopment.CodigoNomra as CodigoNomra,
tb_ibnc_web_standardsindevelopment.estado as estado,
tb_ibnc_web_standardsindevelopment.nroComite as NumeroComite,
tb_ibnc_web_standardsindevelopment.TituloNorma as TituloNorma,
tb_ibnc_web_standardsindevelopment.Alcance as Alcance,
tb_ibnc_web_standardsindevelopment.estado_fecha as FechaVigencia,
'N/A' as CantidadHojas,
'N/A' as Observaciones
FROM tb_ibnc_web_standardsindevelopment
WHERE tb_ibnc_web_standardsindevelopment.nroComite = '".$vNumComite."'
AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'EQNB%'
AND tb_ibnc_web_standardsindevelopment.estado <> 'Cancelada'
UNION ALL
SELECT
tb_ibnc_web_standardsindevelopment.n_codwebstandardsindevelopment AS n_cod,
'apnb' as c_type,
'N/A' as IdNorma,
tb_ibnc_web_standardsindevelopment.CodigoNomra as CodigoNomra,
tb_ibnc_web_standardsindevelopment.estado as estado,
tb_ibnc_web_standardsindevelopment.nroComite as NumeroComite,
tb_ibnc_web_standardsindevelopment.TituloNorma as TituloNorma,
tb_ibnc_web_standardsindevelopment.Alcance as Alcance,
tb_ibnc_web_standardsindevelopment.estado_fecha as FechaVigencia,
'N/A' as CantidadHojas,
'N/A' as Observaciones                
FROM tb_ibnc_web_standardsindevelopment
WHERE tb_ibnc_web_standardsindevelopment.nroComite = '".$vNumComite."'
AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'APNB%'
UNION ALL
SELECT
tb_ibnc_web_standardsindevelopment.n_codwebstandardsindevelopment AS n_cod,
'pnb' as c_type,
'N/A' as IdNorma,
tb_ibnc_web_standardsindevelopment.CodigoNomra as CodigoNomra,
tb_ibnc_web_standardsindevelopment.estado as estado,
tb_ibnc_web_standardsindevelopment.nroComite as NumeroComite,
tb_ibnc_web_standardsindevelopment.TituloNorma as TituloNorma,
tb_ibnc_web_standardsindevelopment.Alcance as Alcance,
tb_ibnc_web_standardsindevelopment.estado_fecha as FechaVigencia,
'N/A' as CantidadHojas,
'N/A' as Observaciones
FROM tb_ibnc_web_standardsindevelopment
WHERE tb_ibnc_web_standardsindevelopment.nroComite = '".$vNumComite."'
AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'PNB%'
UNION ALL
SELECT
tb_ibnc_web_standardsindevelopment.n_codwebstandardsindevelopment AS n_cod,
'pnb' as c_type,
'N/A' as IdNorma,
tb_ibnc_web_standardsindevelopment.CodigoNomra as CodigoNomra,
tb_ibnc_web_standardsindevelopment.estado as estado,
tb_ibnc_web_standardsindevelopment.nroComite as NumeroComite,
tb_ibnc_web_standardsindevelopment.TituloNorma as TituloNorma,
tb_ibnc_web_standardsindevelopment.Alcance as Alcance,
tb_ibnc_web_standardsindevelopment.estado_fecha as FechaVigencia,
'N/A' as CantidadHojas,
'N/A' as Observaciones
FROM tb_ibnc_web_standardsindevelopment
WHERE tb_ibnc_web_standardsindevelopment.nroComite = '".$vNumComite."'
AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'NB%'
AND tb_ibnc_web_standardsindevelopment.estado = 'Aprobada'
UNION ALL
SELECT
tb_ibnc_web_standardscatalog.n_codwebstandardscatalog as n_cod,
'nb' as c_type,
tb_ibnc_web_standardscatalog.IdNorma as IdNorma,
tb_ibnc_web_standardscatalog.CodigoNorma as CodigoNomra,
'Publicada' as estado,
tb_ibnc_web_standardscatalog.NumeroComite as NumeroComite,
tb_ibnc_web_standardscatalog.NombreNorma as TituloNorma,
tb_ibnc_web_standardscatalog.Alcance as Alcance,
tb_ibnc_web_standardscatalog.FechaVigencia as FechaVigencia,
tb_ibnc_web_standardscatalog.CantidadHojas as CantidadHojas,
tb_ibnc_web_standardscatalog.Observaciones as Observaciones
FROM tb_ibnc_web_standardscatalog
WHERE tb_ibnc_web_standardscatalog.NumeroComite = '".$vNumComite."' AND tb_ibnc_web_standardscatalog.EnWeb = 'Si';");
				return $vResultGetIbnorcaActiveCommitees->fetchAll();
				$vResultGetIbnorcaActiveCommitees->close();
            }
            
            public function getEQNB($vNumComite)
			{
                $vNumComite = (string) $vNumComite;
				$vResultGetIbnorcaActiveCommitees = $this->vDataBase->query("SELECT
tb_ibnc_web_standardsindevelopment.n_codwebstandardsindevelopment AS n_cod,
'eqnb' as c_type,
'N/A' as IdNorma,
tb_ibnc_web_standardsindevelopment.CodigoNomra as CodigoNomra,
tb_ibnc_web_standardsindevelopment.estado as estado,
tb_ibnc_web_standardsindevelopment.nroComite as NumeroComite,
tb_ibnc_web_standardsindevelopment.TituloNorma as TituloNorma,
tb_ibnc_web_standardsindevelopment.Alcance as Alcance,
tb_ibnc_web_standardsindevelopment.estado_fecha as FechaVigencia,
'N/A' as CantidadHojas,
'N/A' as Observaciones
FROM tb_ibnc_web_standardsindevelopment
WHERE tb_ibnc_web_standardsindevelopment.nroComite = '".$vNumComite."'
AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'EQNB%'
AND tb_ibnc_web_standardsindevelopment.estado <> 'Cancelada';");
//AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'EQNB%'
				return $vResultGetIbnorcaActiveCommitees->fetchAll();
				$vResultGetIbnorcaActiveCommitees->close();
			}

            public function getNormaEQNB($vCod)
			{
                $vCod = (int) $vCod;
				$vResultGetIbnorcaActiveCommitees = $this->vDataBase->query("SELECT
                                                                                tb_ibnc_web_standardsindevelopment.*,
                                                                                (SELECT tb_ibnc_web_activecommitees.CorreoSecretario
                                                                                    FROM tb_ibnc_web_activecommitees
                                                                                        WHERE tb_ibnc_web_activecommitees.id_comite = tb_ibnc_web_standardsindevelopment.id_comite) AS CorreoSecretario
                                                                                FROM tb_ibnc_web_standardsindevelopment
                                                                                WHERE tb_ibnc_web_standardsindevelopment.n_codwebstandardsindevelopment = $vCod;");
				return $vResultGetIbnorcaActiveCommitees->fetchAll();
				$vResultGetIbnorcaActiveCommitees->close();
			}            

            public function getAPNB($vNumComite)
			{
                $vNumComite = (string) $vNumComite;
				$vResultGetIbnorcaActiveCommitees = $this->vDataBase->query("SELECT
                tb_ibnc_web_standardsindevelopment.n_codwebstandardsindevelopment AS n_cod,
                tb_ibnc_web_standardsindevelopment.CodigoNomra as CodigoNomra,
                tb_ibnc_web_standardsindevelopment.estado as estado,
                tb_ibnc_web_standardsindevelopment.nroComite as NumeroComite,
                tb_ibnc_web_standardsindevelopment.TituloNorma as TituloNorma,
                tb_ibnc_web_standardsindevelopment.Alcance as Alcance,
                tb_ibnc_web_standardsindevelopment.estado_fecha as FechaVigencia,
                'N/A' as CantidadHojas,
                'N/A' as Observaciones                
                FROM tb_ibnc_web_standardsindevelopment
                WHERE tb_ibnc_web_standardsindevelopment.nroComite = '".$vNumComite."'
                AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'APNB%';");
                //tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'APNB%'
				return $vResultGetIbnorcaActiveCommitees->fetchAll();
				$vResultGetIbnorcaActiveCommitees->close();
			}

            public function getNormaAPNB($vCod)
			{
                $vCod = (int) $vCod;
				$vResultGetIbnorcaActiveCommitees = $this->vDataBase->query("SELECT
                                                                                tb_ibnc_web_standardsindevelopment.*,
                                                                                (SELECT tb_ibnc_web_activecommitees.CorreoSecretario
                                                                                    FROM tb_ibnc_web_activecommitees
                                                                                        WHERE tb_ibnc_web_activecommitees.id_comite = tb_ibnc_web_standardsindevelopment.id_comite) AS CorreoSecretario
                                                                                FROM tb_ibnc_web_standardsindevelopment
                                                                                WHERE tb_ibnc_web_standardsindevelopment.n_codwebstandardsindevelopment = $vCod;");
				return $vResultGetIbnorcaActiveCommitees->fetchAll();
				$vResultGetIbnorcaActiveCommitees->close();
			}            

            public function getPNB($vNumComite)
			{
                $vNumComite = (string) $vNumComite;
				$vResultGetIbnorcaActiveCommitees = $this->vDataBase->query("
                SELECT
                    tb_ibnc_web_standardsindevelopment.n_codwebstandardsindevelopment as n_cod,
                    '' as id,
                    'pnb' as c_type,
                    tb_ibnc_web_standardsindevelopment.CodigoNomra,
                    tb_ibnc_web_standardsindevelopment.TituloNorma,
                    tb_ibnc_web_standardsindevelopment.estado,
                    '' as IdNorma
                    FROM tb_ibnc_web_standardsindevelopment
                        WHERE tb_ibnc_web_standardsindevelopment.nroComite = '".$vNumComite."'
                            AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'NB%'
                            AND tb_ibnc_web_standardsindevelopment.estado = 'Aprobada';
            SELECT
                tb_ibnc_web_standardscatalog.n_codwebstandardscatalog as n_cod,
                tb_ibnc_web_standardscatalog.IdNorma as id,
                'nb' as c_type,
                tb_ibnc_web_standardscatalog.CodigoNorma as CodigoNomra,
                tb_ibnc_web_standardscatalog.NombreNorma as TituloNorma,
                'Publicada' as estado,
                tb_ibnc_web_standardscatalog.IdNorma
                    FROM tb_ibnc_web_standardscatalog
                        WHERE tb_ibnc_web_standardscatalog.NumeroComite = '".$vNumComite."' AND tb_ibnc_web_standardscatalog.EnWeb = 'Si';
                ");
                //AND tb_ibnc_web_standardsindevelopment.CodigoNomra LIKE 'PNB%'
				return $vResultGetIbnorcaActiveCommitees->fetchAll();
				$vResultGetIbnorcaActiveCommitees->close();
			}
            
            public function getNormaPNB($vCod)
			{
                $vCod = (int) $vCod;
				$vResultGetIbnorcaActiveCommitees = $this->vDataBase->query("SELECT
                                                                                tb_ibnc_web_standardsindevelopment.*,
                                                                                (SELECT tb_ibnc_web_activecommitees.CorreoSecretario
                                                                                    FROM tb_ibnc_web_activecommitees
                                                                                        WHERE tb_ibnc_web_activecommitees.id_comite = tb_ibnc_web_standardsindevelopment.id_comite) AS CorreoSecretario
                                                                                FROM tb_ibnc_web_standardsindevelopment
                                                                                WHERE tb_ibnc_web_standardsindevelopment.n_codwebstandardsindevelopment = $vCod;");
				return $vResultGetIbnorcaActiveCommitees->fetchAll();
				$vResultGetIbnorcaActiveCommitees->close();
			}            
            
            public function getNB($vNumComite)
			{
                $vNumComite = (string) $vNumComite;
				$vResultGetIbnorcaActiveCommitees = $this->vDataBase->query("SELECT
                    tb_ibnc_web_standardscatalog.n_codwebstandardscatalog as n_cod,
                    tb_ibnc_web_standardscatalog.IdNorma as id,
                    'nb' as c_type,
                    tb_ibnc_web_standardscatalog.CodigoNorma as CodigoNomra,
                    tb_ibnc_web_standardscatalog.NombreNorma as TituloNorma,
                    'Publicada' as estado,
                    tb_ibnc_web_standardscatalog.IdNorma
                    FROM tb_ibnc_web_standardscatalog
                    WHERE tb_ibnc_web_standardscatalog.NumeroComite = '".$vNumComite."' AND tb_ibnc_web_standardscatalog.EnWeb = 'Si';");
				return $vResultGetIbnorcaActiveCommitees->fetchAll();
				$vResultGetIbnorcaActiveCommitees->close();
			}
            public function getNormaNB($vCod)
			{
                $vCod = (int) $vCod;
				$vResultGetIbnorcaActiveCommitees = $this->vDataBase->query("SELECT
                                    tb_ibnc_web_standardscatalog.n_codwebstandardscatalog,
                                    tb_ibnc_web_standardscatalog.IdNorma,
                                    tb_ibnc_web_standardscatalog.IdComite,
                                    tb_ibnc_web_standardscatalog.CodigoNorma,
                                    tb_ibnc_web_standardscatalog.NombreNorma,
                                    tb_ibnc_web_standardscatalog.PalabrasClave,
                                    tb_ibnc_web_standardscatalog.Alcance,
                                    tb_ibnc_web_standardscatalog.FechaVigencia,
                                    tb_ibnc_web_standardscatalog.CantidadHojas,
                                    tb_ibnc_web_standardscatalog.Observaciones,
                                    tb_ibnc_web_standardscatalog.RemplazadaPor,
                                    tb_ibnc_web_standardscatalog.NombreSector,
                                    tb_ibnc_web_standardscatalog.NombreComite,
                                    tb_ibnc_web_standardscatalog.NumeroComite,
                                    tb_ibnc_web_standardscatalog.Adoptada,
                                    tb_ibnc_web_standardscatalog.PrecioFisico,
                                    tb_ibnc_web_standardscatalog.PrecioDigital,
                                    tb_ibnc_web_standardscatalog.EnWeb,
                                    tb_ibnc_web_standardscatalog.CODIGO_ICS,
                                    (SELECT tb_ibnc_web_icscatalog.Descripcion FROM tb_ibnc_web_icscatalog WHERE tb_ibnc_web_icscatalog.ICS = tb_ibnc_web_standardscatalog.CODIGO_ICS) as Descripcion,
                                    tb_ibnc_web_standardscatalog.Texto_desstaque
                                    FROM tb_ibnc_web_standardscatalog
                WHERE tb_ibnc_web_standardscatalog.n_codwebstandardscatalog = $vCod");
				return $vResultGetIbnorcaActiveCommitees->fetchAll();
				$vResultGetIbnorcaActiveCommitees->close();
			}

            public function getRevisionSistemica()
			{
				$vResultGetRevisionSistemica = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_standardscatalog, tb_ibnc_apiibnorca_systemicreview WHERE tb_ibnc_web_standardscatalog.IdNorma = tb_ibnc_apiibnorca_systemicreview.id_norma;");
				return $vResultGetRevisionSistemica->fetchAll();
				$vResultGetRevisionSistemica->close();
			}

            public function getGroupSectorRevisionSistemica()
			{
				$vResultGroupSectorRevisionSistemica = $this->vDataBase->query("SELECT
                                                                                        tb_ibnc_web_standardscatalog.NombreSector
                                                                                    FROM tb_ibnc_web_standardscatalog, tb_ibnc_apiibnorca_systemicreview
                                                                                        WHERE tb_ibnc_web_standardscatalog.IdNorma = tb_ibnc_apiibnorca_systemicreview.id_norma
                                                                                            GROUP BY tb_ibnc_web_standardscatalog.NombreSector");
				return $vResultGroupSectorRevisionSistemica->fetchAll();
				$vResultGroupSectorRevisionSistemica->close();
			}
            
            public function getIbnorcaManagementSystem()
			{
				$vResultGet = $this->vDataBase->query("SELECT
tb_ibnc_web_managementsystem.*,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_web_managementsystem.n_codimages) AS c_image_name,
(SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_web_managementsystem.n_codimages) AS c_image_desc
FROM tb_ibnc_web_managementsystem WHERE n_status = 1;");
				return $vResultGet->fetchAll();
				$vResultGet->close();
			}

            public function getIbnorcaManagementSystemParagraph()
			{
				$vResultGet = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_managementsystem_paragraph;");
				return $vResultGet->fetchAll();
				$vResultGet->close();
			} 
            
            public function getIbnorcaManagementSystemBenefits()
			{
				$vResultGet = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_managementsystem_benefits;");
				return $vResultGet->fetchAll();
				$vResultGet->close();
			}             
            
            public function DataImages()
			{
				$vResultGet = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_managementservices;");
				return $vResultGet->fetchAll();
				$vResultGet->close();
			}

            public function getIbnorcaManagementServices()
			{
				$vResultGet = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_managementservices;");
				return $vResultGet->fetchAll();
				$vResultGet->close();
			}
            public function getIbnorcaManagementService($vCode)
			{
                $vCode = (int) $vCode;
				$vResultGet = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_managementservices WHERE tb_ibnc_web_managementservices.n_codmanagementservices = $vCode;");
				return $vResultGet->fetchAll();
				$vResultGet->close();
			}                        
            public function getIbnorcaManagementServiceContent($vCode)
			{
                $vCode = (int) $vCode;
				$vResultGet = $this->vDataBase->query("SELECT *
                                                        FROM tb_ibnc_web_managementservices, tb_ibnc_web_managementservices_paragraph
                                                            WHERE tb_ibnc_web_managementservices.n_codmanagementservices = tb_ibnc_web_managementservices_paragraph.n_codmanagementservices
                                                                AND tb_ibnc_web_managementservices.n_codmanagementservices = $vCode;");
				return $vResultGet->fetchAll();
				$vResultGet->close();
			}


            public function getIbnorcaProduct()
			{
				$vResultGet = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_productsandservices;");
				return $vResultGet->fetchAll();
				$vResultGet->close();
			}

            public function getIbnorcaProductParagraph()
			{
				$vResultGet = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_productsandservices_paragraph;");
				return $vResultGet->fetchAll();
				$vResultGet->close();
			} 
            
            public function getIbnorcaProductBenefits()
			{
				$vResultGet = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_productsandservices_benefits;");
				return $vResultGet->fetchAll();
				$vResultGet->close();
			}             
            
            public function getIbnorcaProductServices()
			{
				$vResultGet = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_productsandservicesservices;");
				return $vResultGet->fetchAll();
				$vResultGet->close();
			}

            public function getIbnorcaProductService($vCode)
			{
                $vCode = (int) $vCode;
				$vResultGet = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_productsandservicesservices WHERE tb_ibnc_web_productsandservicesservices.n_codproductsandservicesservices = $vCode;");
				return $vResultGet->fetchAll();
				$vResultGet->close();
			}            
            public function getIbnorcaProductServiceContent($vCode)
			{
                $vCode = (int) $vCode;
				$vResultGet = $this->vDataBase->query("SELECT *
                                                        FROM tb_ibnc_web_productsandservicesservices, tb_ibnc_web_productsandservicesservices_paragraph
                                                            WHERE tb_ibnc_web_productsandservicesservices.n_codproductsandservicesservices = tb_ibnc_web_productsandservicesservices_paragraph.n_codproductsandservicesservices
                                                                AND tb_ibnc_web_productsandservicesservices.n_codproductsandservicesservices = $vCode;");
				return $vResultGet->fetchAll();
				$vResultGet->close();
			}
            
            public function getDataICS($vCodICS)
			{
                $vCodICS = (string) $vCodICS;
				$vResultGet = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_icscatalog WHERE REPLACE (tb_ibnc_web_icscatalog.ICS, '.', '') = '".$vCodICS."';");
				return $vResultGet->fetchAll();
				$vResultGet->close();
			}

            public function getDataICSAsociados($vCodICS)
			{
                $vCodICS = (string) $vCodICS;
				$vResultGet = $this->vDataBase->query("SELECT
                                                            tb_ibnc_web_standardscatalog.*
                                                        FROM tb_ibnc_web_standardscatalog
                                                            WHERE REPLACE (tb_ibnc_web_standardscatalog.CODIGO_ICS, '.', '') = '".$vCodICS."';");
				return $vResultGet->fetchAll();
				$vResultGet->close();
			}            
            
            public function getDataLandingBenefitsItem($vCode)
			{
                $vCode = (int) $vCode;
				$vResultGetIbnorcaLandingContent = $this->vDataBase->query("SELECT * FROM tb_ibnc_landing_why WHERE tb_ibnc_landing_why.n_codlandingwhy = $vCode;");
				return $vResultGetIbnorcaLandingContent->fetchAll();
				$vResultGetIbnorcaLandingContent->close();
			}

            public function getDataLandingBenefitsList($vIdUnico)
			{
                $vIdUnico = (int) $vIdUnico;
				$vResultGetIbnorcaLandingContent = $this->vDataBase->query("SELECT * FROM tb_ibnc_landing_why WHERE tb_ibnc_landing_why.IdUnico = $vIdUnico;");
				return $vResultGetIbnorcaLandingContent->fetchAll();
				$vResultGetIbnorcaLandingContent->close();
			}            

            public function getDataLandingFaqsItem($vCode)
			{
                $vCode = (int) $vCode;
				$vResultGetIbnorcaLandingContent = $this->vDataBase->query("SELECT * FROM tb_ibnc_landing_faqs WHERE tb_ibnc_landing_faqs.n_codlandingfaqs = $vCode;");
				return $vResultGetIbnorcaLandingContent->fetchAll();
				$vResultGetIbnorcaLandingContent->close();
			}

            public function getDataLandingFaqsList($vIdUnico)
			{
                $vIdUnico = (int) $vIdUnico;
				$vResultGetIbnorcaLandingContent = $this->vDataBase->query("SELECT * FROM tb_ibnc_landing_faqs WHERE tb_ibnc_landing_faqs.IdUnico = $vIdUnico;");
				return $vResultGetIbnorcaLandingContent->fetchAll();
				$vResultGetIbnorcaLandingContent->close();
			}
            
            public function getIdComiteFromCodNorma($vCodNorma)
			{
                $vCodNorma = (int) $vCodNorma;
				$vResultGetIbnorcaLandingContent = $this->vDataBase->query("SELECT tb_ibnc_web_standardsindevelopment.id_comite
                                                                                FROM tb_ibnc_web_standardsindevelopment
                                                                            WHERE tb_ibnc_web_standardsindevelopment.n_codwebstandardsindevelopment = $vCodNorma;");
				return $vResultGetIbnorcaLandingContent->fetchAll();
				$vResultGetIbnorcaLandingContent->close();
			}            

            public function getDataLandingDiscountsList()
            {
                $vResultGetDataIndexList = $this->vDataBase->query("SELECT * FROM tb_ibnc_landing_discounts;");
                return $vResultGetDataIndexList->fetchAll();
                $vResultGetDataIndexList->close();
            }
            
            public function getDataLandingDiscountsItem($vCode)
            {
                $vCode = (int) $vCode;
                $vResultGetDataIndex = $this->vDataBase->query("SELECT tb_ibnc_landing_discounts.* FROM tb_ibnc_landing_discounts WHERE n_codlandingdiscounts = $vCode;");
                return $vResultGetDataIndex->fetchAll();
                $vResultGetDataIndex->close();
            }

            public function getDataLandingDiscountsType($vIdUnico, $vType)
            {
                $vIdUnico = (int) $vIdUnico;
                $vType = (int) $vType;
                $vResultGetDataLandingDiscountsType = $this->vDataBase->query("SELECT * FROM tb_ibnc_landing_discounts WHERE IdUnico = $vIdUnico AND n_type = $vType;");
                return $vResultGetDataLandingDiscountsType->fetchAll();
                $vResultGetDataLandingDiscountsType->close();
            }
            
            public function getDataStandardsSearches($vSearchString){
            
                $vSearchString = (string) $vSearchString;
                $vResultGetDataLandingDiscountsType = $this->vDataBase->query("SELECT
                        tb_ibnc_web_standardscatalog.IdNorma as id,
                        tb_ibnc_web_standardscatalog.n_codwebstandardscatalog as Codigo,
                        tb_ibnc_web_standardscatalog.CodigoNorma as CodigoNorma,
                        tb_ibnc_web_standardscatalog.NombreNorma as NombreNorma,
                        tb_ibnc_web_standardscatalog.NumeroComite as NumeroComite,
                        tb_ibnc_web_standardscatalog.NombreComite as NombreComite,
                        tb_ibnc_web_standardscatalog.NombreSector as NombreSector,
                        tb_ibnc_web_standardscatalog.Alcance as Alcance,
                        'Publicada' as estado
                    FROM tb_ibnc_web_standardscatalog
                        WHERE tb_ibnc_web_standardscatalog.CodigoNorma LIKE '%".$vSearchString."%';");
                return $vResultGetDataLandingDiscountsType->fetchAll();
                $vResultGetDataLandingDiscountsType->close();
            }

            public function getDataStandardsExactSearches($vSearchString){
            
                $vSearchString = (string) $vSearchString;
                $vResultGetDataLandingDiscountsType = $this->vDataBase->query("SELECT
                        tb_ibnc_web_standardscatalog.IdNorma as id,
                        tb_ibnc_web_standardscatalog.n_codwebstandardscatalog as Codigo,
                        tb_ibnc_web_standardscatalog.CodigoNorma as CodigoNorma,
                        tb_ibnc_web_standardscatalog.NombreNorma as NombreNorma,
                        tb_ibnc_web_standardscatalog.NumeroComite as NumeroComite,
                        tb_ibnc_web_standardscatalog.NombreComite as NombreComite,
                        tb_ibnc_web_standardscatalog.NombreSector as NombreSector,
                        tb_ibnc_web_standardscatalog.Alcance as Alcance,
                        'Publicada' as estado
                    FROM tb_ibnc_web_standardscatalog
                        WHERE (tb_ibnc_web_standardscatalog.CodigoNorma LIKE '%".$vSearchString."%' OR
                                tb_ibnc_web_standardscatalog.NombreNorma LIKE '%".$vSearchString."%' OR
                                tb_ibnc_web_standardscatalog.Alcance LIKE '%".$vSearchString."%' OR
                                tb_ibnc_web_standardscatalog.NombreSector LIKE '%".$vSearchString."%' OR
                                tb_ibnc_web_standardscatalog.NombreComite LIKE '%".$vSearchString."%');");
                return $vResultGetDataLandingDiscountsType->fetchAll();
                $vResultGetDataLandingDiscountsType->close();
            }
            
            public function getDataServiceExactSearches($vSearchString){
            
                $vSearchString = (string) $vSearchString;
                $vResultGetDataLandingDiscountsType = $this->vDataBase->query("SELECT *
                                                                                FROM    tb_ibnc_services_index
                                                                                WHERE (tb_ibnc_services_index.c_title LIKE '%".$vSearchString."%' OR
                                                                                        tb_ibnc_services_index.c_header LIKE '%".$vSearchString."%' OR
                                                                                        tb_ibnc_services_index.c_text LIKE '%".$vSearchString."%');");
                return $vResultGetDataLandingDiscountsType->fetchAll();
                $vResultGetDataLandingDiscountsType->close();
            }

            public function getCountIbnorcaServiceSearch($vSearchString){
            
                $vSearchString = (string) $vSearchString;
                $vResultGetDataLandingDiscountsType = $this->vDataBase->query("SELECT *
                                                                                FROM    tb_ibnc_services_index
                                                                                WHERE (tb_ibnc_services_index.c_title LIKE '%".$vSearchString."%' OR
                                                                                        tb_ibnc_services_index.c_header LIKE '%".$vSearchString."%' OR
                                                                                        tb_ibnc_services_index.c_text LIKE '%".$vSearchString."%');");
                return $vResultGetDataLandingDiscountsType->fetchAll();
                $vResultGetDataLandingDiscountsType->close();
            }

            public function getCountIbnorcaNewsSearch($vSearchString){
            
                $vSearchString = (string) $vSearchString;
                $vResultGetDataLandingDiscountsType = $this->vDataBase->query("SELECT
                                                                                    tb_ibnc_news.*,
                                                                                    MATCH(c_title, c_text) AGAINST('%".$vSearchString."%' IN BOOLEAN MODE) AS score
                                                                                FROM tb_ibnc_news
                                                                                    WHERE MATCH(c_title, c_text) AGAINST('%".$vSearchString."%' IN BOOLEAN MODE) > 0
                                                                                        ORDER BY score DESC");
                return $vResultGetDataLandingDiscountsType->fetchAll();
                $vResultGetDataLandingDiscountsType->close();
            }


                
        /* END SELECT STATEMENT QUERY  */

        /* BEGIN INSERT STATEMENT QUERY  */
		public function insertIbnorcaCourses($vUserCode,$vIdUnico,$vIdCurso,$vIdPrograma,$vCodigoCurso,$vPrograma,$vCantidadModulos,$vFechaInicio,$vCosto,$vCostoModular,$vIdTipo,$vtipo,$vIdOficina,$vOficina,$vIdGestion,$vGestion,$vCargaHoraria,$vHorasModulo,$vIdArea,$vArea,$vIdImagenCurso,$vUrlImagenCurso,$vcontenido,$vobjetivo,$vIdSectorInteres,$vSectorInteres,$vUrlImagenSector,$vnorma,$vOrientado,$vHorario,$vDias,$vIdModalidad,$vModalidad,$vDescripcionModalidad,$vResponsable,$vDescuento,$vPorcenDescuento,$vDescuentoGrupo,$vPorcenDescuentoGrupo,$vLink,$vAlumnosInscritos,$vCostoSUS,$vCostoModularSUS,$vStatus,$vActive){
            
            $vUserCode = (int) $vUserCode;
            $vIdUnico = (string) $vIdUnico;
            $vIdCurso = (string) $vIdCurso;
            $vIdPrograma = (string) $vIdPrograma;
            $vCodigoCurso = (string) $vCodigoCurso;
            $vPrograma = (string) $vPrograma;
            $vCantidadModulos = (string) $vCantidadModulos;
            $vFechaInicio = (string) $vFechaInicio;
            $vCosto = (string) $vCosto;
            $vCostoModular = (string) $vCostoModular;
            $vIdTipo = (string) $vIdTipo;
            $vtipo = (string) $vtipo;
            $vIdOficina = (string) $vIdOficina;
            $vOficina = (string) $vOficina;
            $vIdGestion = (string) $vIdGestion;
            $vGestion = (string) $vGestion;
            $vCargaHoraria = (string) $vCargaHoraria;
            $vHorasModulo = (string) $vHorasModulo;
            $vIdArea = (string) $vIdArea;
            $vArea = (string) $vArea;
            $vIdImagenCurso = (string) $vIdImagenCurso;
            $vUrlImagenCurso = (string) $vUrlImagenCurso;
            $vcontenido = (string) $vcontenido;
            $vobjetivo = (string) $vobjetivo;
            $vIdSectorInteres = (string) $vIdSectorInteres;
            $vSectorInteres = (string) $vSectorInteres;
            $vUrlImagenSector = (string) $vUrlImagenSector;
            $vnorma = (string) $vnorma;
            $vOrientado = (string) $vOrientado;
            $vHorario = (string) $vHorario;
            $vDias = (string) $vDias;
            $vIdModalidad = (string) $vIdModalidad;
            $vModalidad = (string) $vModalidad;
            $vDescripcionModalidad = (string) $vDescripcionModalidad;
            $vResponsable = (string) $vResponsable;
            $vDescuento = (string) $vDescuento;
            $vPorcenDescuento = (string) $vPorcenDescuento;
            $vDescuentoGrupo = (string) $vDescuentoGrupo;
            $vPorcenDescuentoGrupo = (string) $vPorcenDescuentoGrupo;
            $vLink = (string) $vLink;
            $vAlumnosInscritos = (string) $vAlumnosInscritos;
            $vCostoSUS = (string) $vCostoSUS;
            $vCostoModularSUS = (string) $vCostoModularSUS;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());  

            $vResultInsertUserFacebook = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_courses(n_coduser, IdUnico, IdCurso, IdPrograma, CodigoCurso, Programa, CantidadModulos, FechaInicio, Costo, CostoModular, IdTipo, tipo, IdOficina, Oficina, IdGestion, Gestion, CargaHoraria, horas_modulo, IdArea, Area, IdImagenCurso, UrlImagenCurso, contenido, objetivo, IdSectorInteres, SectorInteres, UrlImagenSector, norma, Orientado, Horario, Dias, IdModalidad, Modalidad, DescripcionModalidad, Responsable, Descuento, PorcenDescuento, DescuentoGrupo, PorcenDescuentoGrupo, Link, AlumnosInscritos, CostoSUS, CostoModularSUS, n_status, n_active, c_usercreate, d_datecreate)
                                                            VALUES(:n_coduser, :IdUnico, :IdCurso, :IdPrograma, :CodigoCurso, :Programa, :CantidadModulos, :FechaInicio, :Costo, :CostoModular, :IdTipo, :tipo, :IdOficina, :Oficina, :IdGestion, :Gestion, :CargaHoraria, :horas_modulo, :IdArea, :Area, :IdImagenCurso, :UrlImagenCurso, :contenido, :objetivo, :IdSectorInteres, :SectorInteres, :UrlImagenSector, :norma, :Orientado, :Horario, :Dias, :IdModalidad, :Modalidad, :DescripcionModalidad, :Responsable, :Descuento, :PorcenDescuento, :DescuentoGrupo, :PorcenDescuentoGrupo, :Link, :AlumnosInscritos, :CostoSUS, :CostoModularSUS, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(                                       
                                        ':n_coduser' => $vUserCode,
                                        ':IdUnico' => $vIdUnico,
                                        ':IdCurso' => $vIdCurso,
                                        ':IdPrograma' => $vIdPrograma,
                                        ':CodigoCurso' => $vCodigoCurso,
                                        ':Programa' => $vPrograma,
                                        ':CantidadModulos' => $vCantidadModulos,
                                        ':FechaInicio' => $vFechaInicio,
                                        ':Costo' => $vCosto,
                                        ':CostoModular' => $vCostoModular,
                                        ':IdTipo' => $vIdTipo,
                                        ':tipo' => $vtipo,
                                        ':IdOficina' => $vIdOficina,
                                        ':Oficina' => $vOficina,
                                        ':IdGestion' => $vIdGestion,
                                        ':Gestion' => $vGestion,
                                        ':CargaHoraria' => $vCargaHoraria,
                                        ':horas_modulo' => $vHorasModulo,
                                        ':IdArea' => $vIdArea,
                                        ':Area' => $vArea,
                                        ':IdImagenCurso' => $vIdImagenCurso,
                                        ':UrlImagenCurso' => $vUrlImagenCurso,
                                        ':contenido' => $vcontenido,
                                        ':objetivo' => $vobjetivo,
                                        ':IdSectorInteres' => $vIdSectorInteres,
                                        ':SectorInteres' => $vSectorInteres,
                                        ':UrlImagenSector' => $vUrlImagenSector,
                                        ':norma' => $vnorma,
                                        ':Orientado' => $vOrientado,
                                        ':Horario' => $vHorario,
                                        ':Dias' => $vDias,
                                        ':IdModalidad' => $vIdModalidad,
                                        ':Modalidad' => $vModalidad,
                                        ':DescripcionModalidad' => $vDescripcionModalidad,
                                        ':Responsable' => $vResponsable,
                                        ':Descuento' => $vDescuento,
                                        ':PorcenDescuento' => $vPorcenDescuento,
                                        ':DescuentoGrupo' => $vDescuentoGrupo,
                                        ':PorcenDescuentoGrupo' => $vPorcenDescuentoGrupo,
                                        ':Link' => $vLink,
                                        ':AlumnosInscritos' => $vAlumnosInscritos,
                                        ':CostoSUS' => $CostoSUS,
                                        ':CostoModularSUS' => $CostoModularSUS,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsertUserFacebook = $this->vDataBase->lastInsertId();
            $vResultInsertUserFacebook->close();            
        }
		public function insertIbnorcaStandardization($vUserCode,$vIndex,$vType,$vId,$vScore,$vPrecio,$vCodigo,$vPrecioDigital,$vNombreComite,$vVigente,$vPrecioFisico,$vIdSector,$vNumeroComite,$vActiva,$vNombreNorma,$vNombreSector,$vAlcance,$vStatus,$vActive){
            
            $vUserCode = (int) $vUserCode;
            $vIndex = (string) $vIndex;
            $vType = (string) $vType;
            $vId = (string) $vId;
            $vScore = (string) $vScore;
            $vPrecio = (string) $vPrecio;
            $vCodigo = (string) $vCodigo;
            $vPrecioDigital = (string) $vPrecioDigital;
            $vNombreComite = (string) $vNombreComite;
            $vVigente = (string) $vVigente;
            $vPrecioFisico = (string) $vPrecioFisico;
            $vIdSector = (string) $vIdSector;
            $vNumeroComite = (string) $vNumeroComite;
            $vActiva = (string) $vActiva;
            $vNombreNorma = (string) $vNombreNorma;
            $vNombreSector = (string) $vNombreSector;
            $vAlcance = (string) $vAlcance;

            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());  

            $vResultInsertUserFacebook = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_standardization(n_coduser, vindex, vtype, id, score, precio, codigo, precioDigital, nombreComite, vigente, precioFisico, idSector, numerocomite, activa, nombreNorma, nombreSector, alcance, n_status, n_active, c_usercreate, d_datecreate)
                                                            VALUES(:n_coduser, :vindex, :vtype, :id, :score, :precio, :codigo, :precioDigital, :nombreComite, :vigente, :precioFisico, :idSector, :numerocomite, :activa, :nombreNorma, :nombreSector, :alcance, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array( 
                                        ':n_coduser' => $vUserCode,
                                        ':vindex' => $vIndex,
                                        ':vtype' => $vType,
                                        ':id' => $vId,
                                        ':score' => $vScore,
                                        ':precio' => $vPrecio,
                                        ':codigo' => $vCodigo,
                                        ':precioDigital' => $vPrecioDigital,
                                        ':nombreComite' => $vNombreComite,
                                        ':vigente' => $vVigente,
                                        ':precioFisico' => $vPrecioFisico,
                                        ':idSector' => $vIdSector,
                                        ':numerocomite' => $vNumeroComite,
                                        ':activa' => $vActiva,
                                        ':nombreNorma' => $vNombreNorma,
                                        ':nombreSector' => $vNombreSector,
                                        ':alcance' => $vAlcance,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsertUserFacebook = $this->vDataBase->lastInsertId();
            $vResultInsertUserFacebook->close();            
        }
		public function insertIbnorcaActiveCommitteesV2($vUserCode,$vIdUnico,$vSector,$vIdComite,$vNumeroComite,$vNombreComite,$vFechaActivacion,$vFechaFinalizacion,$vEstado,$vNormasEQNB,$vNormasAPNB,$vNormasPNB,$vNormasNB,$vAlcance,$vRelInternacional,$vCorreoSecretario,$vStatus,$vActive){
            
            $vUserCode = (int) $vUserCode;
            $vIdUnico = (string) $vIdUnico;
            $vSector = (string) $vSector;
            $vIdComite = (string) $vIdComite;
            $vNumeroComite = (string) $vNumeroComite;
            $vNombreComite = (string) $vNombreComite;
            $vFechaActivacion = (string) $vFechaActivacion;
            $vFechaFinalizacion = (string) $vFechaFinalizacion;
            $vEstado = (string) $vEstado;
            $vNormasEQNB = (string) $vNormasEQNB;
            $vNormasAPNB = (string) $vNormasAPNB;
            $vNormasPNB = (string) $vNormasPNB;
            $vNormasNB = (string) $vNormasNB;
            $vAlcance = (string) $vAlcance;
            $vRelInternacional = (string) $vRelInternacional;
            $vCorreoSecretario = (string) $vCorreoSecretario;
            
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());
                         
            $vResultInsertUserFacebook = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_activecommitees(n_coduser,Sector,id_comite,NumeroComite,NombreComite,FechaActivacion,FechaFinalizacion,Estado,NormasEQNB,NormasAPNB,NormasPNB,NormasNB,Alcance,Rel_Internacional,CorreoSecretario, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser,:Sector,:id_comite,:NumeroComite,:NombreComite,:FechaActivacion,:FechaFinalizacion,:Estado,:NormasEQNB,:NormasAPNB,:NormasPNB,:NormasNB,:Alcance,:Rel_Internacional,:CorreoSecretario,:n_status,:n_active,:c_usercreate,:d_datecreate)")
                            ->execute(
                                    array( 
                                        ':n_coduser' => $vUserCode,
                                        ':Sector' => $vSector,
                                        ':id_comite' => $vIdComite,
                                        ':NumeroComite' => $vNumeroComite,
                                        ':NombreComite' => $vNombreComite,
                                        ':FechaActivacion' => $vFechaActivacion,
                                        ':FechaFinalizacion' => $vFechaFinalizacion,
                                        ':Estado' => $vEstado,
                                        ':NormasEQNB' => $vNormasEQNB,
                                        ':NormasAPNB' => $vNormasAPNB,
                                        ':NormasPNB' => $vNormasPNB,
                                        ':NormasNB' => $vNormasNB,
                                        ':Alcance' => $vAlcance,
                                        ':Rel_Internacional' => $vRelInternacional,
                                        ':CorreoSecretario' => $vCorreoSecretario,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsertUserFacebook = $this->vDataBase->lastInsertId();
            $vResultInsertUserFacebook->close();            
        }

		public function insertStandardsInDevelopmentList($vUserCode,$idSector,$id_comite,$nroComite,$nombreComite,$Alcance,$id_etapa,$CodigoNomra,$TituloNorma,$estado,$estado_fecha,$fecha_ibn_presentacion_eqnb,$fecha_ibn_documento_apnb,$fecha_ibn_consulta_inicio,$fecha_ibn_consulta_fin,$fecha_ibn_aprobacion_nb,$fecha_ibn_aprobacion_cnno,$fecha_ibn_ratificacion,$vStatus,$vActive){
            
            $vUserCode = (int) $vUserCode;
            $idSector = (string) $idSector;
            $id_comite = (string) $id_comite;
            $nroComite = (string) $nroComite;
            $nombreComite = (string) $nombreComite;
            $Alcance = (string) $Alcance;
            $id_etapa = (string) $id_etapa;
            $CodigoNomra = (string) $CodigoNomra;
            $TituloNorma = (string) $TituloNorma;
            $estado = (string) $estado;
            $estado_fecha = (string) $estado_fecha;
            $fecha_ibn_presentacion_eqnb = (string) $fecha_ibn_presentacion_eqnb;
            $fecha_ibn_documento_apnb = (string) $fecha_ibn_documento_apnb;
            $fecha_ibn_consulta_inicio = (string) $fecha_ibn_consulta_inicio;
            $fecha_ibn_consulta_fin = (string) $fecha_ibn_consulta_fin;
            $fecha_ibn_aprobacion_nb = (string) $fecha_ibn_aprobacion_nb;
            $fecha_ibn_aprobacion_cnno = (string) $fecha_ibn_aprobacion_cnno;
            $fecha_ibn_ratificacion = (string) $fecha_ibn_ratificacion;
            
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());
                         
            $vResultInsertUserFacebook = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_standardsindevelopment(n_coduser, idSector, id_comite, nroComite, nombreComite, Alcance, id_etapa, CodigoNomra, TituloNorma, estado, estado_fecha, fecha_ibn_presentacion_eqnb, fecha_ibn_documento_apnb, fecha_ibn_consulta_inicio, fecha_ibn_consulta_fin, fecha_ibn_aprobacion_nb, fecha_ibn_aprobacion_cnno, fecha_ibn_ratificacion, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :idSector, :id_comite, :nroComite, :nombreComite, :Alcance, :id_etapa, :CodigoNomra, :TituloNorma, :estado, :estado_fecha, :fecha_ibn_presentacion_eqnb, :fecha_ibn_documento_apnb, :fecha_ibn_consulta_inicio, :fecha_ibn_consulta_fin, :fecha_ibn_aprobacion_nb, :fecha_ibn_aprobacion_cnno, :fecha_ibn_ratificacion, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vUserCode,
                                        ':idSector' => $idSector,
                                        ':id_comite' => $id_comite,
                                        ':nroComite' => $nroComite,
                                        ':nombreComite' => $nombreComite,
                                        ':Alcance' => $Alcance,
                                        ':id_etapa' => $id_etapa,
                                        ':CodigoNomra' => $CodigoNomra,
                                        ':TituloNorma' => $TituloNorma,
                                        ':estado' => $estado,
                                        ':estado_fecha' => $estado_fecha,
                                        ':fecha_ibn_presentacion_eqnb' => $fecha_ibn_presentacion_eqnb,
                                        ':fecha_ibn_documento_apnb' => $fecha_ibn_documento_apnb,
                                        ':fecha_ibn_consulta_inicio' => $fecha_ibn_consulta_inicio,
                                        ':fecha_ibn_consulta_fin' => $fecha_ibn_consulta_fin,
                                        ':fecha_ibn_aprobacion_nb' => $fecha_ibn_aprobacion_nb,
                                        ':fecha_ibn_aprobacion_cnno' => $fecha_ibn_aprobacion_cnno,
                                        ':fecha_ibn_ratificacion' => $fecha_ibn_ratificacion,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsertUserFacebook = $this->vDataBase->lastInsertId();
            $vResultInsertUserFacebook->close();            
        }

		public function insertMembers($vUserCode,$NumeroComite,$NombreComite,$apellido,$nombre,$id_persona,$movil,$rol,$empresa,$Tipo_empresa,$vStatus,$vActive){
            
            $vUserCode = (int) $vUserCode;
            $NumeroComite = (string) $NumeroComite;
            $NombreComite = (string) $NombreComite;
            $apellido = (string) $apellido;
            $nombre = (string) $nombre;
            $id_persona = (string) $id_persona;
            $movil = (string) $movil;
            $rol = (string) $rol;
            $empresa = (string) $empresa;
            $Tipo_empresa = (string) $Tipo_empresa;
            
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());
                         
            $vResultInsertUserFacebook = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_members(n_coduser, NumeroComite, NombreComite, apellido, nombre, id_persona, movil, rol, empresa, Tipo_empresa, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :NumeroComite, :NombreComite, :apellido, :nombre, :id_persona, :movil, :rol, :empresa, :Tipo_empresa, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vUserCode,
                                        ':NumeroComite' => $NumeroComite,
                                        ':NombreComite' => $NombreComite,
                                        ':apellido' => $apellido,
                                        ':nombre' => $nombre,                                        
                                        ':id_persona' => $id_persona,
                                        ':movil' => $movil,
                                        ':rol' => $rol,
                                        ':empresa' => $empresa,
                                        ':Tipo_empresa' => $Tipo_empresa,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsertUserFacebook = $this->vDataBase->lastInsertId();
            $vResultInsertUserFacebook->close();            
        }

		public function insertMalla($vUserCode,$idmalla,$idtipo,$IdCurso,$idmodulo,$FechaMalla,$d_tipo,$Programa,$Codigo,$d_modulo,$nivel,$Objetivo,$Contenido,$CodigoNorma,$NombreNorma,$TipoNorma,$d_Area,$vStatus,$vActive){
            
            $vUserCode = (int) $vUserCode;
            $idmalla = (string) $idmalla;
            $idtipo = (string) $idtipo;
            $IdCurso = (string) $IdCurso;
            $idmodulo = (string) $idmodulo;
            $FechaMalla = (string) $FechaMalla;
            $d_tipo = (string) $d_tipo;
            $Programa = (string) $Programa;
            $Codigo = (string) $Codigo;
            $d_modulo = (string) $d_modulo;
            $nivel = (string) $nivel;
            $Objetivo = (string) $Objetivo;
            $Contenido = (string) $Contenido;
            $CodigoNorma = (string) $CodigoNorma;
            $NombreNorma = (string) $NombreNorma;
            $TipoNorma = (string) $TipoNorma;
            $d_Area = (string) $d_Area;
            
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());
                         
            $vResultInsertUserFacebook = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_malla(n_coduser, idmalla, idtipo, IdCurso, idmodulo, FechaMalla, d_tipo, Programa, Codigo, d_modulo, nivel, Objetivo, Contenido, CodigoNorma, NombreNorma, TipoNorma, d_Area, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :idmalla, :idtipo, :IdCurso, :idmodulo, :FechaMalla, :d_tipo, :Programa, :Codigo, :d_modulo, :nivel, :Objetivo, :Contenido, :CodigoNorma, :NombreNorma, :TipoNorma, :d_Area, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vUserCode,
                                        ':idmalla' => $idmalla,
                                        ':idtipo' => $idtipo,
                                        ':IdCurso' => $IdCurso,
                                        ':idmodulo' => $idmodulo,                                        
                                        ':FechaMalla' => $FechaMalla,
                                        ':d_tipo' => $d_tipo,
                                        ':Programa' => $Programa,
                                        ':Codigo' => $Codigo,
                                        ':d_modulo' => $d_modulo,
                                        ':nivel' => $nivel,
                                        ':Objetivo' => $Objetivo,
                                        ':Contenido' => $Contenido,
                                        ':CodigoNorma' => $CodigoNorma,
                                        ':NombreNorma' => $NombreNorma,
                                        ':TipoNorma' => $TipoNorma,
                                        ':d_Area' => $d_Area,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsertUserFacebook = $this->vDataBase->lastInsertId();
            $vResultInsertUserFacebook->close();            
        }
        
		public function insertStandardsPublic($vUserCode,$codigo,$TituloNorma,$NumeroComite,$NombreComite,$estado,$FechaInicioConsulta,$FechaFinConsulta,$fecha_estado,$NombreSector,$persona,$vStatus,$vActive){
            
            $vUserCode = (int) $vUserCode;
            $codigo = (string) $codigo;
            $TituloNorma = (string) $TituloNorma;
            $NumeroComite = (string) $NumeroComite;
            $NombreComite = (string) $NombreComite;
            $estado = (string) $estado;
            $FechaInicioConsulta = (string) $FechaInicioConsulta;
            $FechaFinConsulta = (string) $FechaFinConsulta;
            $estado_fecha = (string) $estado_fecha;
            $NombreSector = (string) $NombreSector;
            $persona = (string) $persona;            
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsertUserFacebook = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_standardspublic(n_coduser, codigo, TituloNorma, NumeroComite, NombreComite, estado, FechaInicioConsulta, FechaFinConsulta, fecha_estado, NombreSector, persona, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :codigo, :TituloNorma, :NumeroComite, :NombreComite, :estado, :FechaInicioConsulta, :FechaFinConsulta, :fecha_estado, :NombreSector, :persona, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vUserCode,
                                        ':codigo' => $codigo,
                                        ':TituloNorma' => $TituloNorma,
                                        ':NumeroComite' => $NumeroComite,
                                        ':NombreComite' => $NombreComite,
                                        ':estado' => $estado,
                                        ':FechaInicioConsulta' => $FechaInicioConsulta,
                                        ':FechaFinConsulta' => $FechaFinConsulta,
                                        ':fecha_estado' => $estado_fecha,
                                        ':NombreSector' => $NombreSector,
                                        ':persona' => $persona,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsertUserFacebook = $this->vDataBase->lastInsertId();
            $vResultInsertUserFacebook->close();            
        }
        
		public function insertStandardsCatalog($vUserCode, $IdNorma, $IdComite, $CodigoNorma, $NombreNorma, $PalabrasClave, $Alcance, $FechaVigencia, $CantidadHojas, $Observaciones, $RemplazadaPor, $NombreSector, $NombreComite, $NumeroComite, $Adoptada, $PrecioFisico, $PrecioDigital, $EnWeb, $CODIGO_ICS, $Texto_desstaque, $vStatus,$vActive){
            
            $vUserCode = (int) $vUserCode;
            $IdNorma = (string) $IdNorma;
            $IdComite = (string) $IdComite;
            $CodigoNorma = (string) $CodigoNorma;
            $NombreNorma = (string) $NombreNorma;
            $PalabrasClave = (string) $PalabrasClave;
            $Alcance = (string) $Alcance;
            $FechaVigencia = (string) $FechaVigencia;
            $CantidadHojas = (string) $CantidadHojas;
            $Observaciones = (string) $Observaciones;
            $RemplazadaPor = (string) $RemplazadaPor;
            $NombreSector = (string) $NombreSector;
            $NombreComite = (string) $NombreComite;
            $NumeroComite = (string) $NumeroComite;
            $Adoptada = (string) $Adoptada;
            $PrecioFisico = (string) $PrecioFisico;
            $PrecioDigital = (string) $PrecioDigital;
            $EnWeb = (string) $EnWeb;
            $CODIGO_ICS = (string) $CODIGO_ICS;
            $Texto_desstaque = (string) $Texto_desstaque;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive; 
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsertUserFacebook = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_standardscatalog(n_coduser, IdNorma, IdComite, CodigoNorma, NombreNorma, PalabrasClave, Alcance, FechaVigencia, CantidadHojas, Observaciones, RemplazadaPor, NombreSector, NombreComite, NumeroComite, Adoptada, PrecioFisico, PrecioDigital, EnWeb, CODIGO_ICS, Texto_desstaque, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :IdNorma, :IdComite, :CodigoNorma, :NombreNorma, :PalabrasClave, :Alcance, :FechaVigencia, :CantidadHojas, :Observaciones, :RemplazadaPor, :NombreSector, :NombreComite, :NumeroComite, :Adoptada, :PrecioFisico, :PrecioDigital, :EnWeb, :CODIGO_ICS, :Texto_desstaque, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vUserCode,
                                        ':IdNorma' => $IdNorma,
                                        ':IdComite' => $IdComite,
                                        ':CodigoNorma' => $CodigoNorma,
                                        ':NombreNorma' => $NombreNorma,
                                        ':PalabrasClave' => $PalabrasClave,
                                        ':Alcance' => $Alcance,
                                        ':FechaVigencia' => $FechaVigencia,
                                        ':CantidadHojas' => $CantidadHojas,
                                        ':Observaciones' => $Observaciones,
                                        ':RemplazadaPor' => $RemplazadaPor,
                                        ':NombreSector' => $NombreSector,
                                        ':NombreComite' => $NombreComite,
                                        ':NumeroComite' => $NumeroComite,
                                        ':Adoptada' => $Adoptada,
                                        ':PrecioFisico' => $PrecioFisico,
                                        ':PrecioDigital' => $PrecioDigital,
                                        ':EnWeb' => $EnWeb,
                                        ':CODIGO_ICS' => $CODIGO_ICS,
                                        ':Texto_desstaque' => $Texto_desstaque,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsertUserFacebook = $this->vDataBase->lastInsertId();
            $vResultInsertUserFacebook->close();            
        }
        
		public function insertRevisionSistemica($vUserCode,$id_revision_normas,$id_revision_sistematica,$id_norma,$nombre_norma,$estado,$id_tipo,$numero,$id_comite_norma,$tipo,$anio,$FechaFin,$vStatus,$vActive){
            
            $vUserCode = (int) $vUserCode;
            $id_revision_normas = (string) $id_revision_normas;
            $id_revision_sistematica = (string) $id_revision_sistematica;
            $id_norma = (string) $id_norma;
            $nombre_norma = (string) $nombre_norma;
            $estado = (string) $estado;
            $id_tipo = (string) $id_tipo;
            $numero = (string) $numero;
            $id_comite_norma = (string) $id_comite_norma;
            $tipo = (string) $tipo;
            $anio = (string) $anio;
            $FechaFin = (string) $FechaFin;            
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsertUserFacebook = $this->vDataBase->prepare("INSERT INTO tb_ibnc_apiibnorca_systemicreview(n_coduser,id_revision_normas,id_revision_sistematica,id_norma,nombre_norma,estado,id_tipo,numero,id_comite_norma,tipo,anio,FechaFin, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser,:id_revision_normas,:id_revision_sistematica,:id_norma,:nombre_norma,:estado,:id_tipo,:numero,:id_comite_norma,:tipo,:anio,:FechaFin, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vUserCode,
                                        ':id_revision_normas' => $id_revision_normas,
                                        ':id_revision_sistematica' => $id_revision_sistematica,
                                        ':id_norma' => $id_norma,
                                        ':nombre_norma' => $nombre_norma,
                                        ':estado' => $estado,
                                        ':id_tipo' => $id_tipo,
                                        ':numero' => $numero,
                                        ':id_comite_norma' => $id_comite_norma,
                                        ':tipo' => $tipo,
                                        ':anio' => $anio,
                                        ':FechaFin' => $FechaFin,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsertUserFacebook = $this->vDataBase->lastInsertId();
            $vResultInsertUserFacebook->close();            
        }

		public function insertLandingContent($vCodUser, $vIdCurso, $vDescLanding, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vIdCurso = (int) $vIdCurso;
            $vDescLanding = (string) $vDescLanding;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;              
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());                 

            $vResultLandingContent = $this->vDataBase->prepare("INSERT INTO tb_ibnc_landing_info(n_coduser, IdUnico, t_landingcontent, n_status, n_active, c_usercreate, d_datecreate)
                                                            VALUES(:n_coduser, :IdUnico, :t_landingcontent, :n_status, :n_active, :c_usercreate, :d_datecreate);")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':IdUnico' => $vIdCurso,
                                        ':t_landingcontent' => $vDescLanding,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate,
                                    ));
            return $vResultLandingContent = $this->vDataBase->lastInsertId();
            $vResultLandingContent->close();
        }
        
		public function insertICSCatalog($vUserCode,$ICS,$Descripcion,$vStatus,$vActive){
            
            $vUserCode = (int) $vUserCode;
            $ICS = (string) $ICS;
            $Descripcion = (string) $Descripcion;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsertUserFacebook = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_icscatalog(n_coduser, ICS, Descripcion, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :ICS, :Descripcion, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vUserCode,
                                        ':ICS' => $ICS,
                                        ':Descripcion' => $Descripcion,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsertUserFacebook = $this->vDataBase->lastInsertId();
            $vResultInsertUserFacebook->close();            
        }
        

        
		public function insertManagementSystemContent($vCodUser, $vTitle, $vDesc, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vTitle = (string) $vTitle;
            $vDesc = (string) $vDesc;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_managementsystem_paragraph(n_coduser, c_title, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :c_title, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':c_title' => $vTitle,
                                        ':c_text' => $vDesc,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }
        
		public function insertManagementSystemBenefits($vCodUser, $vTitle, $vDesc, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vTitle = (string) $vTitle;
            $vDesc = (string) $vDesc;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_managementsystem_benefits(n_coduser, c_title, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :c_title, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':c_title' => $vTitle,
                                        ':c_text' => $vDesc,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }

		public function insertManagementSystemServices($vCodUser, $vTitle, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vTitle = (string) $vTitle;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_managementservices(n_coduser, c_title, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :c_title, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':c_title' => $vTitle,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }

		public function insertManagementSystemServicesParagraph($vCodUser, $vCode, $vDesc, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCode = (int) $vCode;
            $vDesc = (string) $vDesc;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_managementservices_paragraph(n_coduser, n_codmanagementservices, c_paragraph, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codmanagementservices, :c_paragraph, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codmanagementservices' => $vCode,
                                        ':c_paragraph' => $vDesc,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }
        /*****************************/        
		public function insertProduct($vCodUser, $vTitle, $vDesc, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vTitle = (string) $vTitle;
            $vDesc = (string) $vDesc;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_productsandservices(n_coduser, c_title, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :c_title, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':c_title' => $vTitle,
                                        ':c_text' => $vDesc,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }
        
		public function insertProductContent($vCodUser, $vTitle, $vDesc, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vTitle = (string) $vTitle;
            $vDesc = (string) $vDesc;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_productsandservices_paragraph(n_coduser, c_title, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :c_title, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':c_title' => $vTitle,
                                        ':c_text' => $vDesc,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }
        
		public function insertProductBenefits($vCodUser, $vTitle, $vDesc, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vTitle = (string) $vTitle;
            $vDesc = (string) $vDesc;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_productsandservices_benefits(n_coduser, c_title, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :c_title, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':c_title' => $vTitle,
                                        ':c_text' => $vDesc,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }

		public function insertProductServices($vCodUser, $vTitle, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vTitle = (string) $vTitle;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_productsandservicesservices(n_coduser, c_title, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :c_title, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':c_title' => $vTitle,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }

		public function insertProductServicesParagraph($vCodUser, $vCode, $vDesc, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCode = (int) $vCode;
            $vDesc = (string) $vDesc;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_productsandservicesservices_paragraph(n_coduser, n_codproductsandservicesservices, c_paragraph, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codproductsandservicesservices, :c_paragraph, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codproductsandservicesservices' => $vCode,
                                        ':c_paragraph' => $vDesc,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }

		public function insertLandingBenefit($vCodUser, $vIdCurso, $vTitle, $vText, $vStatus, $vActive)
        {
            
            $vCodUser = (int) $vCodUser;
            $vIdCurso = (int) $vIdCurso;
            $vTitle = (string) $vTitle;
            $vText = (string) $vText;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_landing_why(n_coduser, IdUnico, c_title, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :IdUnico, :c_title, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':IdUnico' => $vIdCurso,
                                        ':c_title' => $vTitle,
                                        ':c_text' => $vText,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }

		public function insertLandingFaqs($vCodUser, $vIdCurso, $vTitle, $vText, $vStatus, $vActive)
        {
            
            $vCodUser = (int) $vCodUser;
            $vIdCurso = (int) $vIdCurso;
            $vTitle = (string) $vTitle;
            $vText = (string) $vText;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_landing_faqs(n_coduser, IdUnico, c_title, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :IdUnico, :c_title, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':IdUnico' => $vIdCurso,
                                        ':c_title' => $vTitle,
                                        ':c_text' => $vText,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }
		public function insertLandingDiscounts($vCodUser, $vIdUnico, $vType, $vText, $vStatus, $vActive)
        {
            
            $vCodUser = (int) $vCodUser;
            $vIdUnico = (int) $vIdUnico;
            $vType = (int) $vType;
            $vText = (string) $vText;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_landing_discounts(n_coduser, IdUnico, n_type, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :IdUnico, :n_type, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':IdUnico' => $vIdUnico,
                                        ':n_type' => $vType,
                                        ':c_text' => $vText,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }                
        /* END INSERT STATEMENT QUERY  */

        /* UPDATE */
        public function updateLandingContent($IdUnico, $vDescLanding)
        {            
            $IdUnico = (int) $IdUnico;
            $vDescLanding = (string) $vDescLanding;
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'Email');
            $vDateMod = date("Y-m-d H:i:s", time());
            $vResultUpdateLandingContent = $this->vDataBase->prepare("UPDATE
                                                                        tb_ibnc_landing_info
                                                                    SET tb_ibnc_landing_info.t_landingcontent = :t_landingcontent,
                                                                    tb_ibnc_landing_info.c_usermod = :c_usermod,
                                                                    tb_ibnc_landing_info.d_datemod = :d_datemod
                                                                    WHERE tb_ibnc_landing_info.IdUnico = :IdUnico;")
                            ->execute(
                                        array(
                                            ':t_landingcontent'=>$vDescLanding,
                                            ':c_usermod'=>$vUserMod,
                                            ':d_datemod'=>$vDateMod,
                                            ':IdUnico'=>$IdUnico
                                             )
                                     );
            return $vResultUpdateLandingContent;
            $vResultUpdateLandingContent->close();
        }        
        
        /* */
		public function truncateTable($vTable){
            
            $vTable = (string) $vTable;            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());
                         
            $vResultTruncateTable = $this->vDataBase->prepare("TRUNCATE TABLE $vTable;")->execute();   
        
            return $vResultTruncateTable;
            $vResultTruncateTable->close();            
        }        
        /* */

        /* BEGIN DELETE STATEMENT QUERY  */
        public function deleteLandingImage($vCodLandingImg){
            $vCodLandingImg = (int) $vCodLandingImg;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.n_codlandingimg = $vCodLandingImg;");
        }
        public function deleteLandingPDF($vCodLandingPDF){
            $vCodLandingPDF = (int) $vCodLandingPDF;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_landing_pdf WHERE tb_ibnc_landing_pdf.n_codlandingpdf = $vCodLandingPDF;");
        }
        public function deleteLandingInfo($vCodLandingInfo){
            $vCodLandingInfo = (int) $vCodLandingInfo;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_landing_info WHERE tb_ibnc_landing_info.n_codlandinginfo = $vCodLandingInfo;");
        }
        
        public function truncateTableRows(){
            $this->vDataBase->query("DELETE FROM tb_ibnc_landing_info;");
        }

        public function deleteLandingBenefit($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_landing_why WHERE n_codlandingwhy = $vCode;");
        } 
        
        public function deleteLandingFaqs($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_landing_faqs WHERE n_codlandingfaqs = $vCode;");
        } 
        
        public function deleteLandingDiscounts($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_landing_discounts WHERE n_codlandingdiscounts = $vCode;");
        }         
        /* END DELETE STATEMENT QUERY  */        
    
    }