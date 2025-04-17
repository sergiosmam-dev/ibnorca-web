<?php

class frontendModel extends IdEnModel
	{
		public function __construct(){
				parent::__construct();
			}
        
        /* BEGIN SELECT STATEMENT QUERY  */

        public function getImageName($vCode)
        {
            $vCode = (int) $vCode;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = $vCode;");
            return $vResultGetDataIndex->fetchColumn();
            $vResultGetDataIndex->close();
        }
        
        public function getDataPages()
        {
            $vResultGetDataIndex = $this->vDataBase->query("SELECT * FROM tb_ibnc_pages WHERE n_status = 1;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }        

        public function getSector($vCodSector)
        {
            $vCodSector = (int) $vCodSector;
            $vResultWebSectors = $this->vDataBase->query("SELECT tb_ibnc_sectors.*,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_sectors.n_codimg) AS c_image_name,
(SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_sectors.n_codimg) AS c_image_desc,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_sectors.n_codimg2) AS c_image_name2,
(SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_sectors.n_codimg2) AS c_image_desc2,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_sectors.n_codbanner) AS c_image_banner,
(SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_sectors.n_codbanner) AS c_image_bannerdesc
                FROM tb_ibnc_sectors WHERE tb_ibnc_sectors.n_codsector = $vCodSector;");
            return $vResultWebSectors->fetchAll();
            $vResultWebSectors->close();
        }

        public function getIdSector($vCodSector)
        {
            $vCodSector = (int) $vCodSector;
            $vResultWebSectors = $this->vDataBase->query("SELECT tb_ibnc_sectors.n_idsector FROM tb_ibnc_sectors WHERE tb_ibnc_sectors.n_codsector = $vCodSector;");
            return $vResultWebSectors->fetchColumn();
            $vResultWebSectors->close();
        }

        public function getGroupActiveComiteSectors()
        {
            $vResultWebSectors = $this->vDataBase->query("SELECT
                                                                tb_ibnc_web_activecommitees.NumeroComite,
                                                                tb_ibnc_web_activecommitees.Sector
                                                            FROM tb_ibnc_web_activecommitees
                                                                GROUP BY tb_ibnc_web_activecommitees.Sector
                                                                    ORDER BY tb_ibnc_web_activecommitees.Sector ASC;");
            return $vResultWebSectors->fetchAll();
            $vResultWebSectors->close();
        }

        public function getSectors()
        {
            $vResultWebSectors = $this->vDataBase->query("SELECT
                                                                tb_ibnc_sectors.*,
                                                                    (SELECT tb_ibnc_images.c_image_name
                                                                        FROM tb_ibnc_images
                                                                            WHERE tb_ibnc_images.n_codimages = tb_ibnc_sectors.n_codimg) AS c_image_name
                                                            FROM tb_ibnc_sectors;");
            return $vResultWebSectors->fetchAll();
            $vResultWebSectors->close();
        }

        public function getSectorItem($vCodSector)
        {
            $vCodSector = (int) $vCodSector;
            $vResultWebSectors = $this->vDataBase->query("SELECT
                                                                tb_ibnc_sectors.*,
                                                                    (SELECT tb_ibnc_images.c_image_name
                                                                        FROM tb_ibnc_images
                                                                            WHERE tb_ibnc_images.n_codimages = tb_ibnc_sectors.n_codimg) AS c_image_name
                                                            FROM tb_ibnc_sectors
                                                                WHERE tb_ibnc_sectors.n_codsector = $vCodSector;");
            return $vResultWebSectors->fetchAll();
            $vResultWebSectors->close();
        }
        
        public function getDataImages()
        {
            $vResultWebSectors = $this->vDataBase->query("SELECT
                                                                tb_ibnc_images.*
                                                            FROM tb_ibnc_images;");
            return $vResultWebSectors->fetchAll();
            $vResultWebSectors->close();
        }
        public function getDataImageItem($vCode)
        {
            $vCode = (int) $vCode;
            $vResultWebSectors = $this->vDataBase->query("SELECT
                                                                tb_ibnc_images.*
                                                            FROM tb_ibnc_images
                                                                WHERE tb_ibnc_images.n_codimages = $vCode;");
            return $vResultWebSectors->fetchAll();
            $vResultWebSectors->close();
        }

        public function getDataCabecera($vCodPage)
        {
            $vCodPage = (int) $vCodPage;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                                            tb_ibnc_header_index.*,
                                                            (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_header_index.n_codimages) AS c_image_name,
                                                            (SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_header_index.n_codimages) AS c_image_desc
                                                            FROM tb_ibnc_header_index WHERE n_status = 1 AND n_codpage = $vCodPage;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }

        public function getDataIndexItem($vCode)
        {
            $vCode = (int) $vCode;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT * FROM tb_ibnc_header_index WHERE n_codheader_index = $vCode;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }

        public function getDataIndexItemPage($vCodPage)
        {
            $vCodPage = (int) $vCodPage;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                                                tb_ibnc_header_index.*,
                                                                (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_header_index.n_codimages) AS c_image_name,
                                                                (SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_header_index.n_codimages) AS c_image_desc
                                                            FROM tb_ibnc_header_index
                                                                WHERE n_codpage = $vCodPage;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        
        public function getDataIndexList()
        {
            $vResultGetDataIndexList = $this->vDataBase->query("SELECT * FROM tb_ibnc_header_index;");
            return $vResultGetDataIndexList->fetchAll();
            $vResultGetDataIndexList->close();
        }
        
        public function getDataIndexSectionServicesList()
        {
            $vResultGetDataIndexList = $this->vDataBase->query("SELECT
tb_ibnc_section_services.*,
(SELECT tb_ibnc_pages.c_title FROM tb_ibnc_pages WHERE tb_ibnc_pages.n_codpage = tb_ibnc_section_services.n_codpage) AS name_page,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_section_services.n_codimages) AS c_image_name,
(SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_section_services.n_codimages) AS c_image_desc
FROM tb_ibnc_section_services WHERE n_status = 1;");
            return $vResultGetDataIndexList->fetchAll();
            $vResultGetDataIndexList->close();
        }

        public function getDataIndexSectionServices($vCodPage)
        {
            $vCodPage = (int) $vCodPage;
            $vResultGetDataIndexList = $this->vDataBase->query("SELECT
tb_ibnc_section_services.*,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_section_services.n_codimages) AS c_image_name,
(SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_section_services.n_codimages) AS c_image_desc
FROM tb_ibnc_section_services WHERE n_status = 1 AND n_codpage = $vCodPage;");
            return $vResultGetDataIndexList->fetchAll();
            $vResultGetDataIndexList->close();
        }        
        
        public function getDataIndexSectionServicesItem($vCode)
        {
            $vCode = (int) $vCode;
            $vResultGetDataIndexList = $this->vDataBase->query("SELECT
tb_ibnc_section_services.*,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_section_services.n_codimages) AS c_image_name,
(SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_section_services.n_codimages) AS c_image_desc
FROM tb_ibnc_section_services WHERE n_status = 1 AND tb_ibnc_section_services.n_codsection_services = $vCode;");
            return $vResultGetDataIndexList->fetchAll();
            $vResultGetDataIndexList->close();
        }      
        

        public function getDataIndexDetailList()
        {
            $vResultGetDataIndexList = $this->vDataBase->query("SELECT * FROM tb_ibnc_detail_index;");
            return $vResultGetDataIndexList->fetchAll();
            $vResultGetDataIndexList->close();
        }
        
        public function getDataIndexDetailItem($vCode)
        {
            $vCode = (int) $vCode;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT * FROM tb_ibnc_detail_index WHERE n_coddetail_index = $vCode;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }        

        public function getDataDetalle($vCodPage)
        {
            $vCodPage = (int) $vCodPage;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                                            tb_ibnc_detail_index.*,
                                                            (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_detail_index.n_codimages) AS c_image_name,
                                                            (SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_detail_index.n_codimages) AS c_image_desc
                                                            FROM tb_ibnc_detail_index WHERE n_status = 1 AND n_codpage = $vCodPage;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        } 
        
        public function getDataIndexBenefitsList()
        {
            $vResultGetDataIndexList = $this->vDataBase->query("SELECT tb_ibnc_benefits_index.*,
            (SELECT tb_ibnc_pages.c_title FROM tb_ibnc_pages WHERE tb_ibnc_pages.n_codpage = tb_ibnc_benefits_index.n_codpage) AS name_page
            FROM tb_ibnc_benefits_index;");
            return $vResultGetDataIndexList->fetchAll();
            $vResultGetDataIndexList->close();
        }
        
        public function getDataIndexBenefitsItem($vCode)
        {
            $vCode = (int) $vCode;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT * FROM tb_ibnc_benefits_index WHERE n_codbenefits_index = $vCode;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }

        public function getDataBeneficios($vCodPage)
        {
            $vCodPage = (int) $vCodPage;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                                            tb_ibnc_benefits_index.*,
                                                            (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_benefits_index.n_codimages) AS c_image_name,
                                                            (SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_benefits_index.n_codimages) AS c_image_desc
                                                            FROM tb_ibnc_benefits_index WHERE n_status = 1 AND n_codpage = $vCodPage;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        } 

        public function getDataIndexServicesList()
        {
            $vResultGetDataIndexList = $this->vDataBase->query("SELECT tb_ibnc_services_index.*,
            (SELECT tb_ibnc_pages.c_title FROM tb_ibnc_pages WHERE tb_ibnc_pages.n_codpage = tb_ibnc_services_index.n_codpage) AS name_page,
            (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_services_index.n_codimages) AS c_image_name1,
            (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_services_index.n_codimages2) AS c_image_name2
             FROM tb_ibnc_services_index;");
            return $vResultGetDataIndexList->fetchAll();
            $vResultGetDataIndexList->close();
        }
        
        public function getDataIndexServicesItem($vCode)
        {
            $vCode = (int) $vCode;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT *,
                (SELECT tb_ibnc_pages.c_title FROM tb_ibnc_pages WHERE tb_ibnc_pages.n_codpage = tb_ibnc_services_index.n_codpage) AS name_page
            FROM tb_ibnc_services_index WHERE n_codservices_index = $vCode;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        
        public function getDataServicios($vCodPage)
        {
            $vCodPage = (int) $vCodPage;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                                            tb_ibnc_services_index.*,
                                                            (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_services_index.n_codimages) AS c_image_name,
                                                            (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_services_index.n_codimages2) AS c_image_name2,
                                                            (SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_services_index.n_codimages) AS c_image_desc,
                                                            (SELECT tb_ibnc_web_pdf.c_pdf_name FROM tb_ibnc_web_pdf WHERE tb_ibnc_web_pdf.n_codpdf = tb_ibnc_services_index.n_codpdf) AS c_pdf_name
                                                            FROM tb_ibnc_services_index WHERE n_codpage = $vCodPage;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        } 
        
        public function getDataServicio($vCode)
        {
            $vCode = (int) $vCode;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                                            tb_ibnc_services_index.*,
                                                            (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_services_index.n_codimages) AS c_image_name,
                                                            (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_services_index.n_codimages2) AS c_image_name2,
                                                            (SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_services_index.n_codimages) AS c_image_desc,
                                                            (SELECT tb_ibnc_web_pdf.c_pdf_name FROM tb_ibnc_web_pdf WHERE tb_ibnc_web_pdf.n_codpdf = tb_ibnc_services_index.n_codpdf) AS c_pdf_name
                                                            FROM tb_ibnc_services_index WHERE n_codservices_index = $vCode AND n_status = 1;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        
        public function getDataInfoServices()
        {
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                                                tb_ibnc_services_index.n_codservices_index,
                                                                tb_ibnc_services_index.c_title
                                                            FROM tb_ibnc_services_index
                                                                WHERE tb_ibnc_services_index.n_status = 1;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        
        public function getDataIndexBenefitsServicesList()
        {
            $vResultGetDataIndexList = $this->vDataBase->query("SELECT
tb_ibnc_benefits_services.*,
(SELECT tb_ibnc_pages.c_title FROM tb_ibnc_pages WHERE tb_ibnc_pages.n_codpage = (SELECT tb_ibnc_services_index.n_codpage FROM tb_ibnc_services_index WHERE tb_ibnc_services_index.n_codservices_index = tb_ibnc_benefits_services.n_codservices_index)) AS name_page,
(SELECT tb_ibnc_services_index.c_title FROM tb_ibnc_services_index WHERE tb_ibnc_services_index.n_codservices_index = tb_ibnc_benefits_services.n_codservices_index) AS name_service,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_benefits_services.n_codimages) AS c_image_name,
(SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_benefits_services.n_codimages) AS c_image_desc
FROM tb_ibnc_benefits_services;");
            return $vResultGetDataIndexList->fetchAll();
            $vResultGetDataIndexList->close();
        }
        
        public function getDataIndexBenefitsServicesItem($vCode)
        {
            $vCode = (int) $vCode;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
tb_ibnc_benefits_services.*,
(SELECT tb_ibnc_services_index.c_title FROM tb_ibnc_services_index WHERE tb_ibnc_services_index.n_codservices_index = tb_ibnc_benefits_services.n_codservices_index) AS name_service
FROM tb_ibnc_benefits_services WHERE n_codbenefits_services = $vCode;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        
        public function getDataBeneficiosDeServicios($vCode)
        {
            $vCode = (int) $vCode;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                                            tb_ibnc_benefits_services.*,
                                                            (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_benefits_services.n_codimages) AS c_image_name,
                                                            (SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_benefits_services.n_codimages) AS c_image_desc
                                                            FROM tb_ibnc_benefits_services WHERE n_codservices_index = $vCode AND n_status = 1;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        public function getDataIbnorcaServices()
        {
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                                                tb_ibnc_services_index.n_codservices_index AS n_codservices_index,
                                                                tb_ibnc_pages.c_url AS c_url,
                                                                tb_ibnc_pages.c_title AS c_title,
                                                                tb_ibnc_services_index.c_title AS c_service,
                                                                tb_ibnc_services_index.c_header AS c_service_desc
                                                            FROM tb_ibnc_pages, tb_ibnc_services_index
                                                                WHERE tb_ibnc_pages.n_codpage = tb_ibnc_services_index.n_codpage
                                                                    AND tb_ibnc_services_index.n_status = 1;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        public function getDataIbnorcaNormas()
        {
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                                                tb_ibnc_web_standardscatalog.IdNorma,
                                                                tb_ibnc_web_standardscatalog.CodigoNorma,
                                                                tb_ibnc_web_standardscatalog.NombreNorma
                                                            FROM tb_ibnc_web_standardscatalog;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }

        public function getDataSectorItem($vCode)
        {
            $vCode = (int) $vCode;
            $vResultGetDataSector = $this->vDataBase->query("SELECT tb_ibnc_sectors.* FROM tb_ibnc_sectors WHERE n_status = 1 AND tb_ibnc_sectors.n_codsector = $vCode;");
            return $vResultGetDataSector->fetchAll();
            $vResultGetDataSector->close();
        }

        public function getDataSectorRelationship()
        {
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
tb_ibnc_sectorgroup.n_codsectorgroup,
tb_ibnc_sectorgroup.n_codsector,
tb_ibnc_sectorgroup.n_typereg,
(SELECT tb_ibnc_sectors.t_name_sector FROM tb_ibnc_sectors WHERE tb_ibnc_sectors.n_codsector = tb_ibnc_sectorgroup.n_codsector) AS t_name_sector,
tb_ibnc_sectorgroup.CodigoNorma,
(SELECT tb_ibnc_web_standardization.nombreNorma FROM tb_ibnc_web_standardization WHERE tb_ibnc_web_standardization.codigo = tb_ibnc_sectorgroup.CodigoNorma) AS nombreNorma,
tb_ibnc_sectorgroup.IdUnico,
(SELECT tb_ibnc_web_courses.Programa FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdUnico = tb_ibnc_sectorgroup.IdUnico) AS Programa,
tb_ibnc_sectorgroup.n_codservices_index,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = (SELECT tb_ibnc_services_index.n_codimages FROM tb_ibnc_services_index WHERE n_codservices_index = tb_ibnc_sectorgroup.n_codservices_index)) AS c_service_image,
(SELECT tb_ibnc_services_index.c_title FROM tb_ibnc_services_index WHERE tb_ibnc_services_index.n_codservices_index = tb_ibnc_sectorgroup.n_codservices_index) AS c_title_service,
tb_ibnc_sectorgroup.n_status,
tb_ibnc_sectorgroup.n_active,
tb_ibnc_sectorgroup.c_usercreate,
tb_ibnc_sectorgroup.d_datecreate
FROM tb_ibnc_sectorgroup;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }

        public function getDataSectorRelationshipGroup($vTypeReg, $vCodSector)
        {
            $vTypeReg = (int) $vTypeReg;
            $vCodSector = (int) $vCodSector;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
tb_ibnc_sectorgroup.n_codsectorgroup,
tb_ibnc_sectorgroup.n_codsector,
tb_ibnc_sectorgroup.n_typereg,
(SELECT tb_ibnc_sectors.t_name_sector FROM tb_ibnc_sectors WHERE tb_ibnc_sectors.n_codsector = tb_ibnc_sectorgroup.n_codsector) AS t_name_sector,
tb_ibnc_sectorgroup.CodigoNorma,
(SELECT tb_ibnc_web_standardization.nombreNorma FROM tb_ibnc_web_standardization WHERE tb_ibnc_web_standardization.codigo = tb_ibnc_sectorgroup.CodigoNorma) AS nombreNorma,
(SELECT tb_ibnc_web_standardscatalog.IdNorma as n_cod FROM tb_ibnc_web_standardscatalog WHERE tb_ibnc_web_standardscatalog.CodigoNorma = tb_ibnc_sectorgroup.CodigoNorma) AS IdNorma,
tb_ibnc_sectorgroup.IdUnico,
(SELECT tb_ibnc_web_courses.Programa FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdUnico = tb_ibnc_sectorgroup.IdUnico) AS Programa,
(SELECT tb_ibnc_web_courses.FechaInicio FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdUnico = tb_ibnc_sectorgroup.IdUnico) AS FechaInicio,
(SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_sectorgroup.IdUnico AND tb_ibnc_landing_img.c_image_assign = 1) AS image_principal,
(SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_sectorgroup.IdUnico AND tb_ibnc_landing_img.c_image_assign = 2) AS image_secundaria,
(SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_sectorgroup.IdUnico AND tb_ibnc_landing_img.c_image_assign = 3) AS image_banner,
tb_ibnc_sectorgroup.n_codservices_index,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = (SELECT tb_ibnc_services_index.n_codimages FROM tb_ibnc_services_index WHERE n_codservices_index = tb_ibnc_sectorgroup.n_codservices_index)) AS c_service_image,
(SELECT tb_ibnc_services_index.c_title FROM tb_ibnc_services_index WHERE tb_ibnc_services_index.n_codservices_index = tb_ibnc_sectorgroup.n_codservices_index) AS c_title_service,
tb_ibnc_sectorgroup.n_status,
tb_ibnc_sectorgroup.n_active,
tb_ibnc_sectorgroup.c_usercreate,
tb_ibnc_sectorgroup.d_datecreate
FROM tb_ibnc_sectorgroup
    WHERE tb_ibnc_sectorgroup.n_codsector = $vCodSector
    AND tb_ibnc_sectorgroup.n_typereg = $vTypeReg;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }        

        public function getDataNormasFromNumeroComite($vNumeroComite)
        {
            $vNumeroComite = (string) $vNumeroComite;            
            $vResultGetDataIndex = $this->vDataBase->query("SELECT tb_ibnc_web_standardscatalog.CodigoNorma
                                                                FROM tb_ibnc_web_standardscatalog 
                                                                    WHERE tb_ibnc_web_standardscatalog.NumeroComite Like '".$vNumeroComite."%';");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        
        public function getIdNormaFromNombreNorma($vNombreNorma)
        {
            $vNombreNorma = (string) $vNombreNorma;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT tb_ibnc_web_standardscatalog.IdNorma FROM tb_ibnc_web_standardscatalog WHERE tb_ibnc_web_standardscatalog.CodigoNorma = '".$vNombreNorma."';");
            return $vResultGetDataIndex->fetchColumn();
            $vResultGetDataIndex->close();
        }
        
        public function getNormaExistente($vNombreNorma)
        {
            $vNombreNorma = (string) $vNombreNorma;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT COUNT(*) FROM tb_ibnc_web_standardscatalog WHERE tb_ibnc_web_standardscatalog.CodigoNorma = '".$vNombreNorma."';");
            return $vResultGetDataIndex->fetchColumn();
            $vResultGetDataIndex->close();
        }

        public function getIdCursoExistente($IdUnico)
        {
            $IdUnico = (string) $IdUnico;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT COUNT(*) FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdUnico = '".$IdUnico."';");
            return $vResultGetDataIndex->fetchColumn();
            $vResultGetDataIndex->close();
        }
        
        public function getIdServicioExistente($vCode)
        {
            $vCode = (int) $vCode;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT COUNT(*) FROM tb_ibnc_services_index WHERE tb_ibnc_services_index.n_codservices_index = $vCode;");
            return $vResultGetDataIndex->fetchColumn();
            $vResultGetDataIndex->close();
        }

        public function getIdComiteExistente($NumeroComite)
        {
            $NumeroComite = (string) $NumeroComite;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT COUNT(*) FROM tb_ibnc_web_activecommitees WHERE tb_ibnc_web_activecommitees.NumeroComite Like '".$NumeroComite."%';");
            return $vResultGetDataIndex->fetchColumn();
            $vResultGetDataIndex->close();
        }

        public function getDataIndexServiceAnchoringList()
        {
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                                                tb_ibnc_serviceanchoring.*,
                                                                    (SELECT tb_ibnc_pages.c_title FROM tb_ibnc_pages WHERE tb_ibnc_pages.n_codpage = tb_ibnc_serviceanchoring.n_codpage) AS name_page,
                                                                    (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_serviceanchoring.n_codimages) AS c_image_name,
                                                                    (SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_serviceanchoring.n_codimages) AS c_image_desc,
                                                                    (SELECT tb_ibnc_services_index.c_title FROM tb_ibnc_services_index WHERE tb_ibnc_services_index.n_codservices_index = tb_ibnc_serviceanchoring.n_codservices_index) AS c_titulo,
                                                                    (SELECT tb_ibnc_web_standardscatalog.CodigoNorma FROM tb_ibnc_web_standardscatalog WHERE tb_ibnc_web_standardscatalog.IdNorma = tb_ibnc_serviceanchoring.IdNorma) AS c_norma                                                                
                                                                FROM tb_ibnc_serviceanchoring;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        
        public function getDataAnclajeServicio($vCodPage)
        {
            $vCodPage = (int) $vCodPage;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                                                tb_ibnc_serviceanchoring.n_codserviceanchoring,
                                                                tb_ibnc_serviceanchoring.n_codservices_index,
                                                                tb_ibnc_serviceanchoring.IdNorma,                
                                                                (SELECT tb_ibnc_pages.c_url FROM tb_ibnc_pages WHERE tb_ibnc_pages.n_codpage = (SELECT tb_ibnc_services_index.n_codpage FROM tb_ibnc_services_index WHERE tb_ibnc_services_index.n_codservices_index = tb_ibnc_serviceanchoring.n_codservices_index)) AS c_url_page,
                                                                (SELECT tb_ibnc_services_index.c_title FROM tb_ibnc_services_index WHERE tb_ibnc_services_index.n_codservices_index = tb_ibnc_serviceanchoring.n_codservices_index) AS c_title,
                                                                (SELECT tb_ibnc_web_standardscatalog.CodigoNorma FROM tb_ibnc_web_standardscatalog WHERE tb_ibnc_web_standardscatalog.IdNorma = tb_ibnc_serviceanchoring.IdNorma) AS CodigoNorma,
                                                                (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_serviceanchoring.n_codimages) AS c_image_name,
                                                                (SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_serviceanchoring.n_codimages) AS c_image_desc,
                                                                tb_ibnc_serviceanchoring.IdUnico,
                                                                (SELECT tb_ibnc_web_courses.Programa FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdUnico = tb_ibnc_serviceanchoring.IdUnico) AS Programa,
                                                                (SELECT tb_ibnc_web_courses.FechaInicio FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdUnico = tb_ibnc_serviceanchoring.IdUnico) AS FechaInicio,
                                                                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_serviceanchoring.IdUnico AND tb_ibnc_landing_img.c_image_assign = 1) AS image_principal,
                                                                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_serviceanchoring.IdUnico AND tb_ibnc_landing_img.c_image_assign = 2) AS image_secundaria,
                                                                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_serviceanchoring.IdUnico AND tb_ibnc_landing_img.c_image_assign = 3) AS image_banner
                                                            FROM tb_ibnc_serviceanchoring
                                                                WHERE tb_ibnc_serviceanchoring.n_status = 1
                                                                    AND tb_ibnc_serviceanchoring.n_codpage = $vCodPage;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        
        public function getDatatableTitlesList()
        {
            $vResultGetDataIndexList = $this->vDataBase->query("SELECT
tb_ibnc_titles.*,
(SELECT tb_ibnc_pages.c_title FROM tb_ibnc_pages WHERE tb_ibnc_pages.n_codpage = tb_ibnc_titles.n_codpage) AS c_title_page
FROM tb_ibnc_titles;");
            return $vResultGetDataIndexList->fetchAll();
            $vResultGetDataIndexList->close();
        }
        
        public function getDataTitlesItem($vCode)
        {
            $vCode = (int) $vCode;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT tb_ibnc_titles.*,
                                                                    (SELECT tb_ibnc_pages.c_title FROM tb_ibnc_pages WHERE tb_ibnc_pages.n_codpage = tb_ibnc_titles.n_codpage) AS c_title_page
                                                                FROM tb_ibnc_titles WHERE tb_ibnc_titles.n_codtitle = $vCode;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        
        public function getDataTitlesPage($vCode)
        {
            $vCode = (int) $vCode;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT * FROM tb_ibnc_titles WHERE tb_ibnc_titles.n_codpage = $vCode;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        public function getDataTitleSectionPage($vSection, $vCode)
        {
            $vSection = (int) $vSection;
            $vCode = (int) $vCode;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                                                tb_ibnc_titles.*,
                                                                (SELECT tb_ibnc_pages.c_title FROM tb_ibnc_pages WHERE tb_ibnc_pages.n_codpage = tb_ibnc_titles.n_codpage) AS c_title_page
                                                                FROM tb_ibnc_titles WHERE tb_ibnc_titles.n_codpage = $vCode AND tb_ibnc_titles.n_type = $vSection;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }        
        public function getDataPartnersList()
        {
            $vResultGetDataIndex = $this->vDataBase->query("SELECT * FROM tb_ibnc_partners WHERE tb_ibnc_partners.n_status = 1;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        public function getDataPartnersItem($vCode)
        {
            $vCode = (int) $vCode;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT * FROM tb_ibnc_partners WHERE tb_ibnc_partners.n_codpartners = $vCode;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        public function getDataSorterGroup($vType)
        {
            $vType = (int) $vType;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT tb_ibnc_sorter.n_sortergroup FROM tb_ibnc_sorter WHERE tb_ibnc_sorter.n_idclasificador = $vType;");
            return $vResultGetDataIndex->fetchColumn();
            $vResultGetDataIndex->close();
        }
        public function getDataSorterList()
        {
            $vResultGetDataIndex = $this->vDataBase->query("SELECT * FROM tb_ibnc_sorter WHERE tb_ibnc_sorter.n_status = 1;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }        
        public function getDataSorterItem($vCode)
        {
            $vCode = (int) $vCode;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT * FROM tb_ibnc_sorter WHERE n_codsorter = $vCode;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        public function getDataCoursesWebList()
        {
            $vResultGetDataIndex = $this->vDataBase->query("SELECT * FROM tb_ibnc_courses WHERE tb_ibnc_courses.n_status = 1
            AND tb_ibnc_courses.d_datecourse >= CURDATE();");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }        
        public function getDataWebCourses($vIdClasificador)
        {
            $vIdClasificador = (int) $vIdClasificador;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
tb_ibnc_courses.*,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_courses.n_codimages_pri) AS c_image_name_pri,
(SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_courses.n_codimages_pri) AS c_image_desc_pri,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_courses.n_codimages_sec) AS c_image_name_sec,
(SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_courses.n_codimages_sec) AS c_image_desc_sec            
            FROM tb_ibnc_courses
                WHERE n_idclasificador in($vIdClasificador)
                    AND tb_ibnc_courses.n_status = 1
                    AND tb_ibnc_courses.d_datecourse >= CURDATE();");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        public function getDataWebCourseItem($vIdUnico)
        {
            $vIdUnico = (int) $vIdUnico;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
tb_ibnc_courses.*,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_courses.n_codimages_pri) AS c_image_name_pri,
(SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_courses.n_codimages_pri) AS c_image_desc_pri,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_courses.n_codimages_sec) AS c_image_name_sec,
(SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_courses.n_codimages_sec) AS c_image_desc_sec              
            FROM tb_ibnc_courses WHERE IdUnico = $vIdUnico
            AND tb_ibnc_courses.d_datecourse >= CURDATE();;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        public function getDataIbnorcaCourses()
        {
            $vResultGetDataIndex = $this->vDataBase->query("SELECT * FROM tb_ibnc_web_courses WHERE n_status = 1;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }

        public function getDataServiceServicesAnchoringList()
        {
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                                                tb_ibnc_services_anchoring.n_codservices_anchoring,
                                                                tb_ibnc_services_anchoring.n_codservices_index,
                                                                (SELECT tb_ibnc_services_index.c_title FROM tb_ibnc_services_index WHERE tb_ibnc_services_index.n_codservices_index = tb_ibnc_services_anchoring.n_codservices_index) AS n_nameservice,
                                                                tb_ibnc_services_anchoring.n_coduser,
                                                                tb_ibnc_services_anchoring.n_codimages,
                                                                (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_services_anchoring.n_codimages) AS c_image_name,
                                                                (SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_services_anchoring.n_codimages) AS c_image_desc,
                                                                tb_ibnc_services_anchoring.IdNorma,
                                                                (SELECT tb_ibnc_web_standardscatalog.CodigoNorma FROM tb_ibnc_web_standardscatalog WHERE tb_ibnc_web_standardscatalog.IdNorma = tb_ibnc_services_anchoring.IdNorma) AS CodigoNorma,
                                                                tb_ibnc_services_anchoring.IdUnico,
                                                                tb_ibnc_services_anchoring.n_codservices_index2,
                                                                (SELECT tb_ibnc_services_index.c_title FROM tb_ibnc_services_index WHERE tb_ibnc_services_index.n_codservices_index = tb_ibnc_services_anchoring.n_codservices_index2) AS n_nameservice2,
                                                                (SELECT tb_ibnc_web_courses.Programa FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdUnico = tb_ibnc_services_anchoring.IdUnico) AS Programa,
                                                                (SELECT tb_ibnc_web_courses.FechaInicio FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdUnico = tb_ibnc_services_anchoring.IdUnico) AS FechaInicio,
                                                                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_services_anchoring.IdUnico AND tb_ibnc_landing_img.c_image_assign = 1) AS image_principal,
                                                                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_services_anchoring.IdUnico AND tb_ibnc_landing_img.c_image_assign = 2) AS image_secundaria,
                                                                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_services_anchoring.IdUnico AND tb_ibnc_landing_img.c_image_assign = 3) AS image_banner,
                                                                tb_ibnc_services_anchoring.n_status,
                                                                tb_ibnc_services_anchoring.c_usercreate,
                                                                tb_ibnc_services_anchoring.d_datecreate
                                                            FROM tb_ibnc_services_anchoring
                                                                WHERE tb_ibnc_services_anchoring.n_status = 1;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        
        public function getDataAnclajeServiciosPorServicio($vCodService)
        {
            $vCodService = (int) $vCodService;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                                                tb_ibnc_services_anchoring.n_codservices_anchoring,
                                                                tb_ibnc_services_anchoring.n_codservices_index,
                                                                tb_ibnc_services_anchoring.IdNorma,                
                                                                (SELECT tb_ibnc_web_standardscatalog.CodigoNorma FROM tb_ibnc_web_standardscatalog WHERE tb_ibnc_web_standardscatalog.IdNorma = tb_ibnc_services_anchoring.IdNorma) AS CodigoNorma,
                                                                (SELECT tb_ibnc_web_standardscatalog.NombreNorma FROM tb_ibnc_web_standardscatalog WHERE tb_ibnc_web_standardscatalog.IdNorma = tb_ibnc_services_anchoring.IdNorma) AS NombreNorma,
                                                                (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_services_anchoring.n_codimages) AS c_image_name,
                                                                (SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_services_anchoring.n_codimages) AS c_image_desc,
                                                                tb_ibnc_services_anchoring.IdUnico,
                                                                tb_ibnc_services_anchoring.n_codservices_index2,
                                                                (SELECT tb_ibnc_services_index.c_title FROM tb_ibnc_services_index WHERE tb_ibnc_services_index.n_codservices_index = tb_ibnc_services_anchoring.n_codservices_index2) AS n_nameservice2,
                                                                (SELECT tb_ibnc_web_courses.Programa FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdUnico = tb_ibnc_services_anchoring.IdUnico) AS Programa,
                                                                (SELECT tb_ibnc_web_courses.FechaInicio FROM tb_ibnc_web_courses WHERE tb_ibnc_web_courses.IdUnico = tb_ibnc_services_anchoring.IdUnico) AS FechaInicio,
                                                                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_services_anchoring.IdUnico AND tb_ibnc_landing_img.c_image_assign = 1) AS image_principal,
                                                                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_services_anchoring.IdUnico AND tb_ibnc_landing_img.c_image_assign = 2) AS image_secundaria,
                                                                (SELECT tb_ibnc_landing_img.c_image_name FROM tb_ibnc_landing_img WHERE tb_ibnc_landing_img.IdUnico = tb_ibnc_services_anchoring.IdUnico AND tb_ibnc_landing_img.c_image_assign = 3) AS image_banner
                                                            FROM tb_ibnc_services_anchoring
                                                                WHERE tb_ibnc_services_anchoring.n_status = 1
                                                                    AND tb_ibnc_services_anchoring.n_codservices_index = $vCodService;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        
        public function getDataCoursesTypeNameSorter($vIdTipo)
        {
            $vIdTipo = (int) $vIdTipo;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT tb_ibnc_sorter.c_nameweb FROM tb_ibnc_sorter WHERE tb_ibnc_sorter.n_idclasificador in($vIdTipo);");
            return $vResultGetDataIndex->fetchColumn();
            $vResultGetDataIndex->close();
        }
        
        public function getDataNewsList()
        {
            $vResultGetDataIndex = $this->vDataBase->query("SELECT * FROM tb_ibnc_news WHERE tb_ibnc_news.n_status = 1;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        
        public function getDataNews($vType)
        {
            $vType = (int) $vType;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT tb_ibnc_news.*,
                                                                    (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_news.n_codimages) AS c_image_name,
                                                                    (SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_news.n_codimages) AS c_image_desc
                                                                FROM tb_ibnc_news
                                                                    WHERE tb_ibnc_news.n_status = 1
                                                                        and tb_ibnc_news.n_type = $vType
                                                                        ORDER BY tb_ibnc_news.d_datenews DESC;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        public function getDataNewsItem($vCode)
        {
            $vCode = (int) $vCode;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT tb_ibnc_news.*,
                                                                    (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_news.n_codimages) AS c_image_name,
                                                                    (SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_news.n_codimages) AS c_image_desc
                                                                FROM tb_ibnc_news
                                                                WHERE tb_ibnc_news.n_codnews = $vCode
                                                                AND tb_ibnc_news.n_status = 1;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        public function getDataYoutube()
        {
            $vResultGetDataIndex = $this->vDataBase->query("SELECT * FROM tb_ibnc_youtube;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        
        public function getDataHeader($vCodPage)
        {
            $vCodPage = (int) $vCodPage;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
tb_ibnc_header_index.*,
(SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_header_index.n_codimages) AS c_image_name
FROM tb_ibnc_header_index
WHERE tb_ibnc_header_index.n_codpage = $vCodPage;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        
        public function getDataKeywordsList()
        {
            $vResultGetDataKeywords = $this->vDataBase->query("SELECT tb_ibnc_keywords.* FROM tb_ibnc_keywords;");
            return $vResultGetDataKeywords->fetchAll();
            $vResultGetDataKeywords->close();
        }

        public function getDataPageKeywords($vCodPage)
        {
            $vCodPage = (int) $vCodPage;
            $vResultGetDataPageKeywords = $this->vDataBase->query("SELECT tb_ibnc_keywords.c_text FROM tb_ibnc_keywords WHERE tb_ibnc_keywords.n_codpage = $vCodPage;");
            return $vResultGetDataPageKeywords->fetchColumn();
            $vResultGetDataPageKeywords->close();
        }        
        
        public function getDataKeywordsItem($vCodKeywords)
        {
            $vCodKeywords = (int) $vCodKeywords;
            $vResultGetDataPageKeywordsItem = $this->vDataBase->query("SELECT tb_ibnc_keywords.*,
                                                                                (SELECT tb_ibnc_pages.c_title FROM tb_ibnc_pages WHERE tb_ibnc_pages.n_codpage = tb_ibnc_keywords.n_codpage) AS c_title_page
                                                                            FROM tb_ibnc_keywords WHERE tb_ibnc_keywords.n_codkeywords = $vCodKeywords;");
            return $vResultGetDataPageKeywordsItem->fetchAll();
            $vResultGetDataPageKeywordsItem->close();
        }
        
        public function getDataDescriptionSEOList()
        {
            $vResultGetDataDescriptionSEO = $this->vDataBase->query("SELECT tb_ibnc_descriptionseo.* FROM tb_ibnc_descriptionseo;");
            return $vResultGetDataDescriptionSEO->fetchAll();
            $vResultGetDataDescriptionSEO->close();
        }

        public function getDataPageDescriptionSEO($vCodPage)
        {
            $vCodPage = (int) $vCodPage;
            $vResultGetDataPageDescriptionSEO = $this->vDataBase->query("SELECT tb_ibnc_descriptionseo.c_text FROM tb_ibnc_descriptionseo WHERE tb_ibnc_descriptionseo.n_codpage = $vCodPage;");
            return $vResultGetDataPageDescriptionSEO->fetchColumn();
            $vResultGetDataPageDescriptionSEO->close();
        }        
        
        public function getDataDescriptionSEOItem($vCodDescriptionSEO)
        {
            $vCodDescriptionSEO = (int) $vCodDescriptionSEO;
            $vResultGetDataDescriptionSEOItem = $this->vDataBase->query("SELECT tb_ibnc_descriptionseo.*,
                                                                                (SELECT tb_ibnc_pages.c_title FROM tb_ibnc_pages WHERE tb_ibnc_pages.n_codpage = tb_ibnc_descriptionseo.n_codpage) AS c_title_page
                                                                            FROM tb_ibnc_descriptionseo WHERE tb_ibnc_descriptionseo.n_coddescriptionseo = $vCodDescriptionSEO;");
            return $vResultGetDataDescriptionSEOItem->fetchAll();
            $vResultGetDataDescriptionSEOItem->close();
        }
        
        public function getDataRegistrationProcessList()
        {
            $vResultGetDataIndexList = $this->vDataBase->query("SELECT * FROM tb_ibnc_registrationprocess;");
            return $vResultGetDataIndexList->fetchAll();
            $vResultGetDataIndexList->close();
        }
        
        public function getDataRegistrationProcessItem($vCode)
        {
            $vCode = (int) $vCode;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT tb_ibnc_registrationprocess.*,
                                                                    (SELECT tb_ibnc_pages.c_title FROM tb_ibnc_pages WHERE tb_ibnc_pages.n_codpage = tb_ibnc_registrationprocess.n_codpage) AS c_title_page
                                                                FROM tb_ibnc_registrationprocess WHERE n_codregistrationprocess = $vCode;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }

        public function getDataRegistrationProcess($vCodPage)
        {
            $vCodPage = (int) $vCodPage;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                                            tb_ibnc_registrationprocess.*,
                                                            (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_registrationprocess.n_codimages) AS c_image_name,
                                                            (SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_registrationprocess.n_codimages) AS c_image_desc
                                                            FROM tb_ibnc_registrationprocess WHERE n_status = 1 AND n_codpage = $vCodPage;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }

        public function getDataTestimonialsList()
        {
            $vResultGetDataIndexList = $this->vDataBase->query("SELECT * FROM tb_ibnc_testimonials;");
            return $vResultGetDataIndexList->fetchAll();
            $vResultGetDataIndexList->close();
        }
        
        public function getDataTestimonialsItem($vCode)
        {
            $vCode = (int) $vCode;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT tb_ibnc_testimonials.*,
                                                                    (SELECT tb_ibnc_pages.c_title FROM tb_ibnc_pages WHERE tb_ibnc_pages.n_codpage = tb_ibnc_testimonials.n_codpage) AS c_title_page
                                                                FROM tb_ibnc_testimonials WHERE n_codtestimonials = $vCode;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }

        public function getDataTestimonials($vCodPage)
        {
            $vCodPage = (int) $vCodPage;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                                            tb_ibnc_testimonials.*,
                                                            (SELECT tb_ibnc_images.c_image_name FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_testimonials.n_codimages) AS c_image_name,
                                                            (SELECT tb_ibnc_images.c_image_desc FROM tb_ibnc_images WHERE tb_ibnc_images.n_codimages = tb_ibnc_testimonials.n_codimages) AS c_image_desc
                                                            FROM tb_ibnc_testimonials WHERE n_status = 1 AND n_codpage = $vCodPage;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        public function getDataComitePDFList()
        {
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                tb_ibnc_web_activecommitees.id_comite,
                                tb_ibnc_web_activecommitees.NumeroComite,
                                tb_ibnc_web_activecommitees.NombreComite,
                                tb_ibnc_web_activecommitees.n_codpdf,
                                (SELECT tb_ibnc_web_pdf.c_pdf_name FROM tb_ibnc_web_pdf WHERE tb_ibnc_web_pdf.n_codpdf = tb_ibnc_web_activecommitees.n_codpdf) AS c_pdf_name,
                                (SELECT tb_ibnc_web_pdf.c_pdf_type FROM tb_ibnc_web_pdf WHERE tb_ibnc_web_pdf.n_codpdf = tb_ibnc_web_activecommitees.n_codpdf) AS c_pdf_type,
                                (SELECT tb_ibnc_web_pdf.n_pdf_size FROM tb_ibnc_web_pdf WHERE tb_ibnc_web_pdf.n_codpdf = tb_ibnc_web_activecommitees.n_codpdf) AS n_pdf_size
                                FROM tb_ibnc_web_activecommitees
                                WHERE tb_ibnc_web_activecommitees.n_codpdf > 0;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        public function getPDFName($vCodPDF)
        {
            $vCodPDF = (int) $vCodPDF;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT tb_ibnc_web_pdf.c_pdf_name FROM tb_ibnc_web_pdf WHERE tb_ibnc_web_pdf.n_codpdf = $vCodPDF");
            return $vResultGetDataIndex->fetchColumn();
            $vResultGetDataIndex->close();
        }
        public function getPDFIndexServices($vCod)
        {
            $vCod = (int) $vCod;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                tb_ibnc_services_index.*,
                                (SELECT tb_ibnc_web_pdf.c_pdf_name FROM tb_ibnc_web_pdf WHERE tb_ibnc_web_pdf.n_codpdf = tb_ibnc_services_index.n_codpdf) AS c_pdf_name,
                                (SELECT tb_ibnc_web_pdf.c_pdf_type FROM tb_ibnc_web_pdf WHERE tb_ibnc_web_pdf.n_codpdf = tb_ibnc_services_index.n_codpdf) AS c_pdf_type,
                                (SELECT tb_ibnc_web_pdf.n_pdf_size FROM tb_ibnc_web_pdf WHERE tb_ibnc_web_pdf.n_codpdf = tb_ibnc_services_index.n_codpdf) AS n_pdf_size
                                FROM tb_ibnc_services_index
                                WHERE tb_ibnc_services_index.n_codservices_index = $vCod;");
            return $vResultGetDataIndex->fetchAll();
            $vResultGetDataIndex->close();
        }
        public function getDataComitePDFItem($vIdComite)
        {
            $vIdComite = (int) $vIdComite;
            $vResultGetDataIndex = $this->vDataBase->query("SELECT
                                    (SELECT tb_ibnc_web_pdf.c_pdf_name FROM tb_ibnc_web_pdf WHERE tb_ibnc_web_pdf.n_codpdf = tb_ibnc_web_activecommitees.n_codpdf) AS c_pdf_name
                                    FROM tb_ibnc_web_activecommitees
                                    WHERE tb_ibnc_web_activecommitees.id_comite = $vIdComite;");
            return $vResultGetDataIndex->fetchColumn();
            $vResultGetDataIndex->close();
        }
        public function getModalActive()
        {
            $vResultGetModalActive = $this->vDataBase->query("SELECT
                                                                    COUNT(*)
                                                                FROM tb_ibnc_advertisement
                                                                    WHERE tb_ibnc_advertisement.n_status = 1
                                                                        AND (CURDATE() BETWEEN tb_ibnc_advertisement.d_dateini AND tb_ibnc_advertisement.d_dateend);");
            return $vResultGetModalActive->fetchColumn();
            $vResultGetModalActive->close();
        }
        public function getModalContent()
        {
            $vResultGetModalContent = $this->vDataBase->query("SELECT
                                                                    tb_ibnc_advertisement.c_title,
                                                                    tb_ibnc_advertisement.c_text
                                                                FROM tb_ibnc_advertisement
                                                                    WHERE tb_ibnc_advertisement.n_status = 1
                                                                        AND (CURDATE() BETWEEN tb_ibnc_advertisement.d_dateini AND tb_ibnc_advertisement.d_dateend);");
            return $vResultGetModalContent->fetchAll();
            $vResultGetModalContent->close();
        }
        public function getDataAdvertisementList()
        {
            $vResultGetAdvertisement = $this->vDataBase->query("SELECT * FROM tb_ibnc_advertisement;");
            return $vResultGetAdvertisement->fetchAll();
            $vResultGetAdvertisement->close();
        }
        public function getAdvertisementStatus($vCode)
        {
            $vCode = (int) $vCode;
            $vResultGetAdvertisement = $this->vDataBase->query("SELECT n_status FROM tb_ibnc_advertisement WHERE n_codadvertisement = $vCode;");
            return $vResultGetAdvertisement->fetchColumn();
            $vResultGetAdvertisement->close();
        }
        
        public function getDataDocumentsPDF($vCodService, $vCodPage)
        {
            $vCodService = (int) $vCodService;
            $vCodPage = (int) $vCodPage;
            $vResultGetAdvertisement = $this->vDataBase->query("SELECT tb_ibnc_services_pdf.*,
(SELECT tb_ibnc_web_pdf.c_pdf_name FROM tb_ibnc_web_pdf WHERE tb_ibnc_web_pdf.n_codpdf = tb_ibnc_services_pdf.n_codpdf) AS c_pdf_name
FROM tb_ibnc_services_pdf
WHERE tb_ibnc_services_pdf.n_codservices_index = $vCodService
and tb_ibnc_services_pdf.n_codpdf != 0;");
            return $vResultGetAdvertisement->fetchAll();
            $vResultGetAdvertisement->close();
        }
        /**************************** */

        /* END SELECT STATEMENT QUERY  */
        
        /* BEGIN INSERT STATEMENT QUERY  */
		public function insertLandingContent($vCodUser, $vIdCurso, $vAttractive, $vMessage1, $vMessage2, $vDescLanding, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vIdCurso = (int) $vIdCurso;
            $vAttractive = (string) $vAttractive;
            $vMessage1 = (string) $vMessage1;
            $vMessage2 = (string) $vMessage2;
            $vDescLanding = (string) $vDescLanding;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;              
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());                 

            $vResultLandingContent = $this->vDataBase->prepare("INSERT INTO tb_ibnc_landing_info(n_coduser, IdUnico, c_attractive, c_message1, c_message2, t_landingcontent, n_status, n_active, c_usercreate, d_datecreate)
                                                            VALUES(:n_coduser, :IdUnico, :c_attractive, :c_message1, :c_message2, :t_landingcontent, :n_status, :n_active, :c_usercreate, :d_datecreate);")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':IdUnico' => $vIdCurso,
                                        ':c_attractive' => $vAttractive,
                                        ':c_message1' => $vMessage1,
                                        ':c_message2' => $vMessage2,
                                        ':t_landingcontent' => $vDescLanding,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate,
                                    ));
            return $vResultLandingContent = $this->vDataBase->lastInsertId();
            $vResultLandingContent->close();
        }        
		public function insertLandingImage($vCodUser, $vIdUnico, $vAssignLandingImg, $vImageName, $vImageDesc, $vImageContent, $vImageType, $vImageSize){
            
            $vCodUser = (int) $vCodUser;
            $vIdUnico = (int) $vIdUnico;
            $vAssignLandingImg = (int) $vAssignLandingImg;
            $vImageName = (string) $vImageName;
            $vImageDesc = (string) $vImageDesc;
            $vImageContent = $vImageContent;
            $vImageType = $vImageType;
            $vImageSize = $vImageSize;

            $vStatus = 1;
            $vActive = 1;                
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());                 

            $vResultCtrlSession = $this->vDataBase->prepare("INSERT INTO tb_ibnc_landing_img(n_coduser, IdUnico, c_image_assign, c_image_name, c_image_desc, c_image_content, c_image_type, n_image_size, n_status, n_active, c_usercreate, d_datecreate)
                                                            VALUES(:n_coduser, :IdUnico, :c_image_assign, :c_image_name, :c_image_desc, :c_image_content, :c_image_type, :n_image_size, :n_status, :n_active, :c_usercreate, :d_datecreate);")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':IdUnico' => $vIdUnico,
                                        ':c_image_assign' => $vAssignLandingImg,
                                        ':c_image_name' => $vImageName,
                                        ':c_image_desc' => $vImageDesc,
                                        ':c_image_content' => $vImageContent,
                                        ':c_image_type' => $vImageType,
                                        ':n_image_size' => $vImageSize,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate,
                                    ));
            return $vResultCtrlSession = $this->vDataBase->lastInsertId();
            $vResultCtrlSession->close();
        }
		public function insertLandingPDF($vCodUser, $vIdUnico, $vImageName, $vImageContent, $vImageType, $vImageSize){
            
            $vCodUser = (int) $vCodUser;
            $vIdUnico = (int) $vIdUnico;
            $vImageName = (string) $vImageName;
            $vImageContent = $vImageContent;
            $vImageType = $vImageType;
            $vImageSize = $vImageSize;

            $vStatus = 1;
            $vActive = 1;                
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());                 

            $vResultCtrlSession = $this->vDataBase->prepare("INSERT INTO tb_ibnc_landing_pdf(n_coduser, IdUnico, c_pdf_name, c_pdf_content, c_pdf_type, n_pdf_size, n_status, n_active, c_usercreate, d_datecreate)
                                                            VALUES(:n_coduser, :IdUnico, :c_pdf_name, :c_pdf_content, :c_pdf_type, :n_pdf_size, :n_status, :n_active, :c_usercreate, :d_datecreate);")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':IdUnico' => $vIdUnico,
                                        ':c_pdf_name' => $vImageName,
                                        ':c_pdf_content' => $vImageContent,
                                        ':c_pdf_type' => $vImageType,
                                        ':n_pdf_size' => $vImageSize,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate,
                                    ));
            return $vResultCtrlSession = $this->vDataBase->lastInsertId();
            $vResultCtrlSession->close();
        }

		public function insertIndexHeader($vCodUser, $vTitle, $vText, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vTitle = (string) $vTitle;
            $vText = (string) $vText;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_header_index(n_coduser, c_title, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :c_title, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
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
        

		public function insertImage($vCodUser, $vImageName, $vImageDesc, $vImageContent, $vImageType, $vImageSize){
            
            $vCodUser = (int) $vCodUser;
            $vImageName = (string) $vImageName;
            $vImageDesc = (string) $vImageDesc;
            $vImageContent = $vImageContent;
            $vImageType = $vImageType;
            $vImageSize = $vImageSize;

            $vStatus = 1;
            $vActive = 1;                
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());                 

            $vResultCtrlSession = $this->vDataBase->prepare("INSERT INTO tb_ibnc_images(n_coduser, c_image_name, c_image_desc, c_image_content, c_image_type, n_image_size, n_status, n_active, c_usercreate, d_datecreate)
                                                            VALUES(:n_coduser, :c_image_name, :c_image_desc, :c_image_content, :c_image_type, :n_image_size, :n_status, :n_active, :c_usercreate, :d_datecreate);")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':c_image_name' => $vImageName,
                                        ':c_image_desc' => $vImageDesc,
                                        ':c_image_content' => $vImageContent,
                                        ':c_image_type' => $vImageType,
                                        ':n_image_size' => $vImageSize,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate,
                                    ));
            return $vResultCtrlSession = $this->vDataBase->lastInsertId();
            $vResultCtrlSession->close();
        }

		public function insertIndexSectionServices($vCodUser, $vCodPage, $vURL, $vTitle, $vText, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCodPage = (int) $vCodPage;
            $vURL = (string) $vURL;
            $vTitle = (string) $vTitle;
            $vText = (string) $vText;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_section_services(n_coduser, n_codpage, c_url, c_title, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codpage, :c_url, :c_title, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codpage' => $vCodPage,
                                        ':c_url' => $vURL,
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

		public function insertIndexDetail($vCodUser, $vCodPage, $vTitle, $vDesc, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCodPage =(int) $vCodPage;
            $vTitle = (string) $vTitle;
            $vDesc = (string) $vDesc;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_detail_index(n_coduser, n_codpage, c_title, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codpage, :c_title, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codpage' => $vCodPage,
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
        
		public function insertIndexBenefits($vCodUser, $vCodPage,$vTitle, $vDesc, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCodPage = (int) $vCodPage;
            $vTitle = (string) $vTitle;
            $vDesc = (string) $vDesc;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_benefits_index(n_coduser, n_codpage, c_title, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codpage,  :c_title, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codpage' => $vCodPage,
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
        
		public function insertIndexServices($vCodUser, $vCodPage, $vTitle, $vHeader, $vDesc, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCodPage = (int) $vCodPage;
            $vTitle = (string) $vTitle;
            $vHeader = (string) $vHeader;
            $vDesc = (string) $vDesc;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_services_index(n_coduser, n_codpage, c_title, c_header, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codpage,  :c_title, :c_header, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codpage' => $vCodPage,
                                        ':c_title' => $vTitle,
                                        ':c_header' => $vHeader,
                                        ':c_text' => $vDesc,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }
        
		public function insertIndexBenefitsServices($vCodUser, $vCodServicesIndex, $vTitle, $vDesc, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCodServicesIndex = (int) $vCodServicesIndex;
            $vTitle = (string) $vTitle;
            $vDesc = (string) $vDesc;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_benefits_services(n_coduser, n_codservices_index, c_title, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codservices_index, :c_title, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codservices_index' => $vCodServicesIndex,
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
		public function insertServiceAnchoringNorma($vCodUser, $vCodPage, $vIdNorma, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCodPage = (int) $vCodPage;
            $vIdNorma = (string) $vIdNorma;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_serviceanchoring(n_coduser, n_codpage, IdNorma, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codpage, :IdNorma, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codpage' => $vCodPage,
                                        ':IdNorma' => $vIdNorma,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }
        
		public function insertServiceAnchoringService($vCodUser, $vCodPage, $vCodService, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCodPage = (int) $vCodPage;
            $vCodService = (int) $vCodService;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_serviceanchoring(n_coduser, n_codpage, n_codservices_index, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codpage, :n_codservices_index, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codpage' => $vCodPage,
                                        ':n_codservices_index' => $vCodService,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }

		public function insertServiceAnchoringCourse($vCodUser, $vCodPage, $IdUnico, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCodPage = (int) $vCodPage;
            $IdUnico = (string) $IdUnico;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_serviceanchoring(n_coduser, n_codpage, IdUnico, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codpage, :IdUnico, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codpage' => $vCodPage,
                                        ':IdUnico' => $IdUnico,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }        
        
		public function insertTitles($vCodUser, $vCodPage, $vCodSection, $vTitleA, $vTitleB, $vText, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCodPage = (int) $vCodPage;
            $vCodSection = (int) $vCodSection;
            $vTitleA = (string) $vTitleA;
            $vTitleB = (string) $vTitleB;
            $vText = (string) $vText;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_titles(n_coduser, n_codpage, n_type, c_title_a, c_title_b, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codpage, :n_type, :c_title_a, :c_title_b, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codpage' => $vCodPage,
                                        ':n_type' => $vCodSection,
                                        ':c_title_a' => $vTitleA,
                                        ':c_title_b' => $vTitleB,
                                        ':c_text' => $vText,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }
		public function insertPartners($vCodUser, $vCodPage, $vType, $vTitle, $vURL, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCodPage = (int) $vCodPage;
            $vType = (int) $vType;
            $vTitle = (string) $vTitle;
            $vURL = (string) $vURL;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_partners(n_coduser, n_codpage, n_type, c_url, c_title, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codpage, :n_type, :c_url, :c_title, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codpage' => $vCodPage,
                                        ':n_type' => $vType,
                                        ':c_url' => $vURL,
                                        ':c_title' => $vTitle,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }
		public function insertCourseWeb($vCodUser, $vIdUnico, $vIdClasificador, $vTitle, $vTextCoursesWeb, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vIdUnico = (int) $vIdUnico;
            $vIdClasificador = (int) $vIdClasificador;
            $vTitle = (string) $vTitle;
            $vTextCoursesWeb = (string) $vTextCoursesWeb;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_courses(n_coduser, n_idclasificador, IdUnico, c_title, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_idclasificador, :IdUnico, :c_title, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_idclasificador' => $vIdClasificador,
                                        ':IdUnico' => $vIdUnico,
                                        ':c_title' => $vTitle,
                                        ':c_text' => $vTextCoursesWeb,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }
        
		public function insertServiceServicesAnchoringNorma($vCodUser, $vCodServicesIndex, $vIdNorma, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCodServicesIndex = (int) $vCodServicesIndex;
            $vIdNorma = (string) $vIdNorma;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_services_anchoring(n_coduser, n_codservices_index, IdNorma, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codservices_index, :IdNorma, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codservices_index' => $vCodServicesIndex,
                                        ':IdNorma' => $vIdNorma,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }
        
		public function insertServiceServicesAnchoringCourse($vCodUser, $vCodServicesIndex, $IdUnico, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCodServicesIndex = (int) $vCodServicesIndex;
            $IdUnico = (string) $IdUnico;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_services_anchoring(n_coduser, n_codservices_index, IdUnico, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codservices_index, :IdUnico, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codservices_index' => $vCodServicesIndex,
                                        ':IdUnico' => $IdUnico,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }

		public function insertServiceServicesAnchoringServices($vCodUser, $vCodServicesIndex, $vCodServiceAnchoring, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCodServicesIndex = (int) $vCodServicesIndex;
            $vCodServiceAnchoring = (int) $vCodServiceAnchoring;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_services_anchoring(n_coduser, n_codservices_index, n_codservices_index2, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codservices_index, :n_codservices_index2, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codservices_index' => $vCodServicesIndex,
                                        ':n_codservices_index2' => $vCodServiceAnchoring,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }        
        
		public function insertNews($vCodUser, $vType, $vDateNews, $vTitle, $vText, $vStatus, $vActive)
        {
            
            $vCodUser = (int) $vCodUser;
            $vType = (int) $vType;
            $vDateNews = $vDateNews;
            $vTitle = (string) $vTitle;
            $vText = (string) $vText;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_news(n_coduser, n_type, d_datenews, c_title, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_type, :d_datenews, :c_title, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_type' => $vType,
                                        ':d_datenews' => $vDateNews,
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
        
		public function insertKeywords($vCodUser, $vCodPage, $vText, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCodPage = (int) $vCodPage;
            $vText = (string) $vText;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_keywords(n_coduser, n_codpage, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codpage, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codpage' => $vCodPage,
                                        ':c_text' => $vText,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }
        
		public function insertDescriptionSEO($vCodUser, $vCodPage, $vText, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCodPage = (int) $vCodPage;
            $vText = (string) $vText;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_descriptionseo(n_coduser, n_codpage, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codpage, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codpage' => $vCodPage,
                                        ':c_text' => $vText,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }
		public function insertRegistrationProcess($vCodUser, $vCodPage,$vTitle, $vDesc, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCodPage = (int) $vCodPage;
            $vTitle = (string) $vTitle;
            $vDesc = (string) $vDesc;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_registrationprocess(n_coduser, n_codpage, c_title, c_text, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codpage,  :c_title, :c_text, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codpage' => $vCodPage,
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
		public function insertTestimonials($vCodUser, $vCodPage, $vName, $vBusiness, $vText, $vURL, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCodPage = (int) $vCodPage;
            $vName = (string) $vName;
            $vBusiness = (string) $vBusiness;
            $vText = (string) $vText;
            $vURL = (string) $vURL;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_testimonials(n_coduser, n_codpage, c_name, c_business, c_text, c_url, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codpage,  :c_name, :c_business, :c_text, :c_url, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codpage' => $vCodPage,
                                        ':c_name' => $vName,
                                        ':c_business' => $vBusiness,
                                        ':c_text' => $vText,
                                        ':c_url' => $vURL,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }

		public function insertPDFDocument($vCodPage, $vCodUser, $vImageName, $vImageContent, $vImageType, $vImageSize){
            
            $vCodPage = (int) $vCodPage;
            $vCodUser = (int) $vCodUser;
            $vImageName = (string) $vImageName;
            $vImageContent = $vImageContent;
            $vImageType = $vImageType;
            $vImageSize = $vImageSize;

            $vStatus = 1;
            $vActive = 1;                
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());                 

            $vResultCtrlSession = $this->vDataBase->prepare("INSERT INTO `tb_ibnc_web_pdf`(n_coduser, n_codpage, c_pdf_name, c_pdf_content, c_pdf_type, n_pdf_size, n_status, n_active, c_usercreate, d_datecreate)
                                                            VALUES(:n_coduser, :n_codpage, :c_pdf_name, :c_pdf_content, :c_pdf_type, :n_pdf_size, :n_status, :n_active, :c_usercreate, :d_datecreate);")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codpage' => $vCodPage,
                                        ':c_pdf_name' => $vImageName,
                                        ':c_pdf_content' => $vImageContent,
                                        ':c_pdf_type' => $vImageType,
                                        ':n_pdf_size' => $vImageSize,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate,
                                    ));
            return $vResultCtrlSession = $this->vDataBase->lastInsertId();
            $vResultCtrlSession->close();
        }

		public function insertComitePDF($vCodUser, $vImageName, $vImageContent, $vImageType, $vImageSize){
            
            $vCodUser = (int) $vCodUser;
            $vImageName = (string) $vImageName;
            $vImageContent = $vImageContent;
            $vImageType = $vImageType;
            $vImageSize = $vImageSize;

            $vStatus = 1;
            $vActive = 1;                
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());                 

            $vResultCtrlSession = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_pdf(n_coduser, c_pdf_name, c_pdf_content, c_pdf_type, n_pdf_size, n_status, n_active, c_usercreate, d_datecreate)
                                                            VALUES(:n_coduser, :c_pdf_name, :c_pdf_content, :c_pdf_type, :n_pdf_size, :n_status, :n_active, :c_usercreate, :d_datecreate);")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':c_pdf_name' => $vImageName,
                                        ':c_pdf_content' => $vImageContent,
                                        ':c_pdf_type' => $vImageType,
                                        ':n_pdf_size' => $vImageSize,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate,
                                    ));
            return $vResultCtrlSession = $this->vDataBase->lastInsertId();
            $vResultCtrlSession->close();
        }

        public function insertDocumentPDF($vCodUser, $vImageName, $vImageContent, $vImageType, $vImageSize){
            
            $vCodUser = (int) $vCodUser;
            $vImageName = (string) $vImageName;
            $vImageContent = $vImageContent;
            $vImageType = $vImageType;
            $vImageSize = $vImageSize;

            $vStatus = 1;
            $vActive = 1;                
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());                 

            $vResultCtrlSession = $this->vDataBase->prepare("INSERT INTO tb_ibnc_web_pdf(n_coduser, c_pdf_name, c_pdf_content, c_pdf_type, n_pdf_size, n_status, n_active, c_usercreate, d_datecreate)
                                                            VALUES(:n_coduser, :c_pdf_name, :c_pdf_content, :c_pdf_type, :n_pdf_size, :n_status, :n_active, :c_usercreate, :d_datecreate);")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':c_pdf_name' => $vImageName,
                                        ':c_pdf_content' => $vImageContent,
                                        ':c_pdf_type' => $vImageType,
                                        ':n_pdf_size' => $vImageSize,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate,
                                    ));
            return $vResultCtrlSession = $this->vDataBase->lastInsertId();
            $vResultCtrlSession->close();
        }
        
		public function insertSectorRelationshipService($vCodUser, $vCode, $vTypeReg, $vCodServicesIndex, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCode = (int) $vCode;
            $vTypeReg = (int) $vTypeReg;
            $vCodServicesIndex = (int) $vCodServicesIndex;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_sectorgroup(n_coduser, n_codsector, n_typereg, n_codservices_index, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codsector, :n_typereg, :n_codservices_index, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codsector' => $vCode,
                                        ':n_typereg' => $vTypeReg,
                                        ':n_codservices_index' => $vCodServicesIndex,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }

		public function insertSectorRelationshipNorma($vCodUser, $vCode, $vTypeReg, $vIdNorma, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCode = (int) $vCode;
            $vTypeReg = (int) $vTypeReg;
            $vIdNorma = (string) $vIdNorma;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_sectorgroup(n_coduser, n_codsector, n_typereg, CodigoNorma, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codsector, :n_typereg, :CodigoNorma, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codsector' => $vCode,
                                        ':n_typereg' => $vTypeReg,
                                        ':CodigoNorma' => $vIdNorma,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }        
		public function insertSector($vCodUser, $vCodImg, $vCodIcon, $vNameSector, $vDescSector, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCodImg = (int) $vCodImg;
            $vCodIcon = (int) $vCodIcon;
            $vNameSector = (string) $vNameSector;
            $vDescSector = (string) $vDescSector;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_sectors(n_coduser, n_codimg, n_codimg2, t_name_sector, t_desc_sector, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codimg, :n_codimg2, :t_name_sector, :t_desc_sector, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codimg' => $vCodImg,
                                        ':n_codimg2' => $vCodIcon,
                                        ':t_name_sector' => $vNameSector,
                                        ':t_desc_sector' => $vDescSector,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }
		public function insertSectorRelationshipCurso($vCodUser, $vCode, $vTypeReg, $IdUnico, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vCode = (int) $vCode;
            $vTypeReg = (int) $vTypeReg;
            $IdUnico = (int) $IdUnico;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_sectorgroup(n_coduser, n_codsector, n_typereg, IdUnico, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :n_codsector, :n_typereg, :IdUnico, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':n_codsector' => $vCode,
                                        ':n_typereg' => $vTypeReg,
                                        ':IdUnico' => $IdUnico,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }
		public function insertAdvertisement($vCodUser, $vTitle, $vTextAdvertisement, $vDateIni, $vDateEnd, $vStatus, $vActive){
            
            $vCodUser = (int) $vCodUser;
            $vTitle = (string) $vTitle;
            $vTextAdvertisement = (string) $vTextAdvertisement;
            $vDateIni = $vDateIni;
            $vDateEnd = $vDateEnd;
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsert = $this->vDataBase->prepare("INSERT INTO tb_ibnc_advertisement(n_coduser, c_title, c_text, d_dateini, d_dateend, n_status, n_active, c_usercreate, d_datecreate)
                                                                    VALUES(:n_coduser, :c_title, :c_text, :d_dateini, :d_dateend, :n_status, :n_active, :c_usercreate, :d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_coduser' => $vCodUser,
                                        ':c_title' => $vTitle,
                                        ':c_text' => $vTextAdvertisement,
                                        ':d_dateini' => $vDateIni,
                                        ':d_dateend' => $vDateEnd,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate
                                    ));
        
            return $vResultInsert = $this->vDataBase->lastInsertId();
            $vResultInsert->close();            
        }
        /* END INSERT STATEMENT QUERY  */

        /* BEGIN UPDATE STATEMENT QUERY */
		public function updateIndexHeader($vCode,$vTitle,$vDesc){
            
            $vCode = (int) $vCode;
            $vTitle = (string) $vTitle;
            $vDesc = (string) $vDesc;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_header_index
                                                            SET c_title = :c_title,
                                                                c_text = :c_text,
                                                                c_usermod = :c_usermod,
                                                                d_datemod = :d_datemod
                                                            WHERE n_codheader_index = :n_codheader_index;")
                            ->execute(
                                        array(
                                        ':c_title' => $vTitle,
                                        ':c_text' => $vDesc,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codheader_index'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }

		public function updateIndexHeaderImage($vCode,$vCodeImage){
            
            $vCode = (int) $vCode;
            $vCodeImage = (int) $vCodeImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_header_index
                                                            SET tb_ibnc_header_index.n_codimages = :n_codimages,
                                                                tb_ibnc_header_index.c_usermod = :c_usermod,
                                                                tb_ibnc_header_index.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_header_index.n_codheader_index = :n_codheader_index;")
                            ->execute(
                                        array(
                                        ':n_codimages' => $vCodeImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codheader_index'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateSectorImage($vCode,$vCodeImage){
            
            $vCode = (int) $vCode;
            $vCodeImage = (int) $vCodeImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_sectors
                                                            SET tb_ibnc_sectors.n_codimg = :n_codimg,
                                                                tb_ibnc_sectors.c_usermod = :c_usermod,
                                                                tb_ibnc_sectors.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_sectors.n_codsector = :n_codsector;")
                            ->execute(
                                        array(
                                        ':n_codimg' => $vCodeImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codsector'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }

        public function updateSectorImage2($vCode,$vCodeImage){
            
            $vCode = (int) $vCode;
            $vCodeImage = (int) $vCodeImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_sectors
                                                            SET tb_ibnc_sectors.n_codimg2 = :n_codimg2,
                                                                tb_ibnc_sectors.c_usermod = :c_usermod,
                                                                tb_ibnc_sectors.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_sectors.n_codsector = :n_codsector;")
                            ->execute(
                                        array(
                                        ':n_codimg2' => $vCodeImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codsector'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }

        public function updateSectorBanner($vCode,$vCodeImage){
            
            $vCode = (int) $vCode;
            $vCodeImage = (int) $vCodeImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_sectors
                                                            SET tb_ibnc_sectors.n_codbanner = :n_codbanner,
                                                                tb_ibnc_sectors.c_usermod = :c_usermod,
                                                                tb_ibnc_sectors.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_sectors.n_codsector = :n_codsector;")
                            ->execute(
                                        array(
                                        ':n_codbanner' => $vCodeImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codsector'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }        

		public function updateSector($vCode, $vNameSector, $vDescSector){
            
            $vCode = (int) $vCode;
            $vNameSector = (string) $vNameSector;
            $vDescSector = (string) $vDescSector;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_sectors
                                                            SET tb_ibnc_sectors.t_name_sector = :t_name_sector,
                                                            tb_ibnc_sectors.t_desc_sector = :t_desc_sector,
                                                                tb_ibnc_sectors.c_usermod = :c_usermod,
                                                                tb_ibnc_sectors.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_sectors.n_codsector = :n_codsector;")
                            ->execute(
                                        array(
                                        ':t_name_sector' => $vNameSector,
                                        ':t_desc_sector' => $vDescSector,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codsector'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateImageIndexSectionService($vCode,$vCodeImage){
            
            $vCode = (int) $vCode;
            $vCodeImage = (int) $vCodeImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_section_services
                                                            SET tb_ibnc_section_services.n_codimages = :n_codimages,
                                                                tb_ibnc_section_services.c_usermod = :c_usermod,
                                                                tb_ibnc_section_services.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_section_services.n_codsection_services = :n_codsection_services;")
                            ->execute(
                                        array(
                                        ':n_codimages' => $vCodeImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codsection_services'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateIndexDetail($vCode, $vCodPage, $vTitle,$vDesc){
            
            $vCode = (int) $vCode;
            $vCodPage = (int) $vCodPage;
            $vTitle = (string) $vTitle;
            $vDesc = (string) $vDesc;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_detail_index
                                                            SET n_codpage = :n_codpage,
                                                                c_title = :c_title,
                                                                c_text = :c_text,
                                                                c_usermod = :c_usermod,
                                                                d_datemod = :d_datemod
                                                            WHERE n_coddetail_index = :n_coddetail_index;")
                            ->execute(
                                        array(
                                        ':n_codpage' => $vCodPage,
                                        ':c_title' => $vTitle,
                                        ':c_text' => $vDesc,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_coddetail_index'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateIndexBenefits($vCode,$vTitle,$vDesc){
            
            $vCode = (int) $vCode;
            $vTitle = (string) $vTitle;
            $vDesc = (string) $vDesc;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_benefits_index
                                                            SET c_title = :c_title,
                                                                c_text = :c_text,
                                                                c_usermod = :c_usermod,
                                                                d_datemod = :d_datemod
                                                            WHERE n_codbenefits_index = :n_codbenefits_index;")
                            ->execute(
                                        array(
                                        ':c_title' => $vTitle,
                                        ':c_text' => $vDesc,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codbenefits_index'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateIndexBenefitsImage($vCode,$vCodeImage){
            
            $vCode = (int) $vCode;
            $vCodeImage = (int) $vCodeImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_benefits_index
                                                            SET tb_ibnc_benefits_index.n_codimages = :n_codimages,
                                                                tb_ibnc_benefits_index.c_usermod = :c_usermod,
                                                                tb_ibnc_benefits_index.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_benefits_index.n_codbenefits_index = :n_codbenefits_index;")
                            ->execute(
                                        array(
                                        ':n_codimages' => $vCodeImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codbenefits_index'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateIndexServices($vCode,$vCodPage, $vTitle,$vHeader, $vDesc){
            
            $vCode = (int) $vCode;
            $vCodPage = (int) $vCodPage;
            $vTitle = (string) $vTitle;
            $vHeader = (string) $vHeader;
            $vDesc = (string) $vDesc;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_services_index
                                                            SET n_codpage = :n_codpage,
                                                                c_title = :c_title,
                                                                c_header = :c_header,
                                                                c_text = :c_text,
                                                                c_usermod = :c_usermod,
                                                                d_datemod = :d_datemod
                                                            WHERE n_codservices_index = :n_codservices_index;")
                            ->execute(
                                        array(
                                        ':n_codpage' => $vCodPage,
                                        ':c_title' => $vTitle,
                                        ':c_header' => $vHeader,
                                        ':c_text' => $vDesc,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codservices_index'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateIndexServicesImage($vCode,$vCodeImage){
            
            $vCode = (int) $vCode;
            $vCodeImage = (int) $vCodeImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_services_index
                                                            SET tb_ibnc_services_index.n_codimages = :n_codimages,
                                                                tb_ibnc_services_index.c_usermod = :c_usermod,
                                                                tb_ibnc_services_index.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_services_index.n_codservices_index = :n_codservices_index;")
                            ->execute(
                                        array(
                                        ':n_codimages' => $vCodeImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codservices_index'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }

		public function updateIndexServicesImage2($vCode,$vCodeImage){
            
            $vCode = (int) $vCode;
            $vCodeImage = (int) $vCodeImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_services_index
                                                            SET tb_ibnc_services_index.n_codimages2 = :n_codimages2,
                                                                tb_ibnc_services_index.c_usermod = :c_usermod,
                                                                tb_ibnc_services_index.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_services_index.n_codservices_index = :n_codservices_index;")
                            ->execute(
                                        array(
                                        ':n_codimages2' => $vCodeImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codservices_index'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateIndexBenefitsServices($vCode, $vCodServicesIndex,$vTitle,$vDesc){
            
            $vCode = (int) $vCode;
            $vCodServicesIndex = (int) $vCodServicesIndex;
            $vTitle = (string) $vTitle;
            $vDesc = (string) $vDesc;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_benefits_services
                                                            SET tb_ibnc_benefits_services.n_codservices_index = :n_codservices_index,
                                                                tb_ibnc_benefits_services.c_title = :c_title,
                                                                tb_ibnc_benefits_services.c_text = :c_text,
                                                                tb_ibnc_benefits_services.c_usermod = :c_usermod,
                                                                tb_ibnc_benefits_services.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_benefits_services.n_codbenefits_services = :n_codbenefits_services;")
                            ->execute(
                                        array(
                                        ':n_codservices_index' => $vCodServicesIndex,
                                        ':c_title' => $vTitle,
                                        ':c_text' => $vDesc,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codbenefits_services'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateIndexBenefitsServicesImage($vCode,$vCodeImage){
            
            $vCode = (int) $vCode;
            $vCodeImage = (int) $vCodeImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_benefits_services
                                                            SET tb_ibnc_benefits_services.n_codimages = :n_codimages,
                                                                tb_ibnc_benefits_services.c_usermod = :c_usermod,
                                                                tb_ibnc_benefits_services.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_benefits_services.n_codbenefits_services = :n_codbenefits_services;")
                            ->execute(
                                        array(
                                        ':n_codimages' => $vCodeImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codbenefits_services'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateImageIndexServiceAnchoring($vCode,$vCodeImage){
            
            $vCode = (int) $vCode;
            $vCodeImage = (int) $vCodeImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_serviceanchoring
                                                            SET tb_ibnc_serviceanchoring.n_codimages = :n_codimages,
                                                                tb_ibnc_serviceanchoring.c_usermod = :c_usermod,
                                                                tb_ibnc_serviceanchoring.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_serviceanchoring.n_codserviceanchoring = :n_codserviceanchoring;")
                            ->execute(
                                        array(
                                        ':n_codimages' => $vCodeImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codserviceanchoring'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateIndexSectionServices($vCode, $vCodPage, $vURL, $vTitle, $vText){
            
            $vCode = (int) $vCode;
            $vCodPage = (int) $vCodPage;
            $vURL = (string) $vURL;
            $vTitle = (string) $vTitle;
            $vText = (string) $vText;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_section_services
                                                            SET tb_ibnc_section_services.n_codpage = :n_codpage,
                                                                tb_ibnc_section_services.c_url = :c_url,
                                                                tb_ibnc_section_services.c_title = :c_title,
                                                                tb_ibnc_section_services.c_text = :c_text,
                                                                tb_ibnc_section_services.c_usermod = :c_usermod,
                                                                tb_ibnc_section_services.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_section_services.n_codsection_services = :n_codsection_services;")
                            ->execute(
                                        array(
                                        ':n_codpage' => $vCodPage,
                                        ':c_url' => $vURL,
                                        ':c_title' => $vTitle,
                                        ':c_text' => $vText,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codsection_services'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateTitles($vCode, $vCodPage, $vCodSection, $vTitleA, $vTitleB, $vText){
            
            $vCode = (int) $vCode;
            $vCodPage = (int) $vCodPage;
            $vCodSection = (int) $vCodSection;
            $vTitleA = (string) $vTitleA;
            $vTitleB = (string) $vTitleB;
            $vText = (string) $vText;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_titles
                                                            SET tb_ibnc_titles.n_codpage = :n_codpage,
                                                                tb_ibnc_titles.n_type = :n_type,
                                                                tb_ibnc_titles.c_title_a = :c_title_a,
                                                                tb_ibnc_titles.c_title_b = :c_title_b,
                                                                tb_ibnc_titles.c_text = :c_text,
                                                                tb_ibnc_titles.c_usermod = :c_usermod,
                                                                tb_ibnc_titles.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_titles.n_codtitle = :n_codtitle;")
                            ->execute(
                                        array(
                                        ':n_codpage' => $vCodPage,
                                        ':n_type' => $vCodSection,
                                        ':c_title_a' => $vTitleA,
                                        ':c_title_b' => $vTitleB,
                                        ':c_text' => $vText,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codtitle'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updatePartners($vCode, $vCodPage, $vType, $vTitle, $vURL){
            
            $vCode = (int) $vCode;
            $vCodPage = (int) $vCodPage;
            $vType = (int) $vType;
            $vTitle = (string) $vTitle;
            $vURL = (string) $vURL;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_partners
                                                            SET tb_ibnc_partners.n_codpage = :n_codpage,
                                                                tb_ibnc_partners.n_type = :n_type,
                                                                tb_ibnc_partners.c_url = :c_url,
                                                                tb_ibnc_partners.c_title = :c_title,
                                                                tb_ibnc_partners.c_usermod = :c_usermod,
                                                                tb_ibnc_partners.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_partners.n_codpartners = :n_codpartners;")
                            ->execute(
                                        array(
                                        ':n_codpage' => $vCodPage,
                                        ':n_type' => $vType,
                                        ':c_url' => $vURL,
                                        ':c_title' => $vTitle,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codpartners'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateImagePartners($vCode,$vCodeImage){
            
            $vCode = (int) $vCode;
            $vCodeImage = (int) $vCodeImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_partners
                                                            SET tb_ibnc_partners.n_codimages = :n_codimages,
                                                                tb_ibnc_partners.c_usermod = :c_usermod,
                                                                tb_ibnc_partners.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_partners.n_codpartners = :n_codpartners;")
                            ->execute(
                                        array(
                                        ':n_codimages' => $vCodeImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codpartners'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }

		public function updateSorter($vCode, $vOrder, $vNameWeb, $vTextWeb){
            
            $vCode = (int) $vCode;
            $vOrder = (int) $vOrder;
            $vNameWeb = (string) $vNameWeb;
            $vTextWeb = (string) $vTextWeb;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_sorter
                                                            SET tb_ibnc_sorter.n_order = :n_order,
                                                                tb_ibnc_sorter.c_nameweb = :c_nameweb,
                                                                tb_ibnc_sorter.c_textweb = :c_textweb,
                                                                tb_ibnc_sorter.c_usermod = :c_usermod,
                                                                tb_ibnc_sorter.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_sorter.n_codsorter = :n_codsorter;")
                            ->execute(
                                        array(
                                        ':n_order' => $vOrder,
                                        ':c_nameweb' => $vNameWeb,
                                        ':c_textweb' => $vTextWeb,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codsorter'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateImageServiceServicesAnchoring($vCode,$vCodeImage){
            
            $vCode = (int) $vCode;
            $vCodeImage = (int) $vCodeImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_services_anchoring
                                                            SET tb_ibnc_services_anchoring.n_codimages = :n_codimages,
                                                                tb_ibnc_services_anchoring.c_usermod = :c_usermod,
                                                                tb_ibnc_services_anchoring.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_services_anchoring.n_codservices_anchoring = :n_codservices_anchoring;")
                            ->execute(
                                        array(
                                        ':n_codimages' => $vCodeImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codservices_anchoring'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateNewsImage($vCode,$vCodeImage){
            
            $vCode = (int) $vCode;
            $vCodeImage = (int) $vCodeImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_news
                                                            SET tb_ibnc_news.n_codimages = :n_codimages,
                                                                tb_ibnc_news.c_usermod = :c_usermod,
                                                                tb_ibnc_news.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_news.n_codnews = :n_codnews;")
                            ->execute(
                                        array(
                                        ':n_codimages' => $vCodeImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codnews'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateNews($vCode, $vType, $vDateNews, $vTitle, $vText){
            
            $vCode = (int) $vCode;
            $vType = (int) $vType;
            $vDateNews = $vDateNews;
            $vTitle = (string) $vTitle;
            $vText = (string) $vText;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_news
                                                            SET tb_ibnc_news.n_type = :n_type,
                                                                tb_ibnc_news.d_datenews = :d_datenews,
                                                                tb_ibnc_news.c_title = :c_title,
                                                                tb_ibnc_news.c_text = :c_text,
                                                                tb_ibnc_news.c_usermod = :c_usermod,
                                                                tb_ibnc_news.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_news.n_codnews = :n_codnews;")
                            ->execute(
                                        array(
                                        ':n_type' => $vType,
                                        ':d_datenews' => $vDateNews,
                                        ':c_title' => $vTitle,
                                        ':c_text' => $vText,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codnews'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateLandingContent($vIdCurso, $vAttractive, $vMessage1, $vMessage2, $vDescLanding){
            
            $vIdCurso = (int) $vIdCurso;
            $vAttractive = (string) $vAttractive;
            $vMessage1 = (string) $vMessage1;
            $vMessage2 = (string) $vMessage2;
            $vDescLanding = (string) $vDescLanding;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_landing_info
                                                            SET tb_ibnc_landing_info.c_attractive  = :c_attractive,
                                                                tb_ibnc_landing_info.c_message1  = :c_message1,
                                                                tb_ibnc_landing_info.c_message2 = :c_message2,
                                                                tb_ibnc_landing_info.c_usermod = :c_usermod,
                                                                tb_ibnc_landing_info.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_landing_info.IdUnico = :IdUnico;")
                            ->execute(
                                        array(
                                        ':c_attractive' => $vAttractive,
                                        ':c_message1' => $vMessage1,
                                        ':c_message2' => $vMessage2,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':IdUnico' => $vIdCurso
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
		public function updateSorterIco($vCode,$vCodeImage){
            
            $vCode = (int) $vCode;
            $vCodeImage = (int) $vCodeImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'username');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_sorter
                                                            SET tb_ibnc_sorter.n_codimages_ico = :n_codimages_ico,
                                                                tb_ibnc_sorter.c_usermod = :c_usermod,
                                                                tb_ibnc_sorter.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_sorter.n_codsorter = :n_codsorter;")
                            ->execute(
                                        array(
                                        ':n_codimages_ico' => $vCodeImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codsorter'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        } 
        
		public function updateSorterImage($vCode,$vCodeImage){
            
            $vCode = (int) $vCode;
            $vCodeImage = (int) $vCodeImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'username');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_sorter
                                                            SET tb_ibnc_sorter.n_codimages = :n_codimages,
                                                                tb_ibnc_sorter.c_usermod = :c_usermod,
                                                                tb_ibnc_sorter.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_sorter.n_codsorter = :n_codsorter;")
                            ->execute(
                                        array(
                                        ':n_codimages' => $vCodeImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codsorter'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateWebCourseImagePri($vCode,$vCodeImage){
            
            $vCode = (int) $vCode;
            $vCodeImage = (int) $vCodeImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'username');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_courses
                                                            SET tb_ibnc_courses.n_codimages_pri = :n_codimages_pri,
                                                                tb_ibnc_courses.c_usermod = :c_usermod,
                                                                tb_ibnc_courses.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_courses.n_codcourses = :n_codcourses;")
                            ->execute(
                                        array(
                                        ':n_codimages_pri' => $vCodeImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codcourses'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
		public function updateWebCourseImageSec($vCode,$vCodeImage){
            
            $vCode = (int) $vCode;
            $vCodeImage = (int) $vCodeImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'username');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_courses
                                                            SET tb_ibnc_courses.n_codimages_sec = :n_codimages_sec,
                                                                tb_ibnc_courses.c_usermod = :c_usermod,
                                                                tb_ibnc_courses.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_courses.n_codcourses = :n_codcourses;")
                            ->execute(
                                        array(
                                        ':n_codimages_sec' => $vCodeImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codcourses'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateKeywords($vCode,$vCodPage,$vText){
            
            $vCode = (int) $vCode;
            $vCodPage = (int) $vCodPage;
            $vText = (string) $vText;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_keywords
                                                            SET n_codpage = :n_codpage,
                                                                c_text = :c_text,
                                                                c_usermod = :c_usermod,
                                                                d_datemod = :d_datemod
                                                            WHERE n_codkeywords = :n_codkeywords;")
                            ->execute(
                                        array(
                                        ':n_codpage' => $vCodPage,
                                        ':c_text' => $vText,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codkeywords'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
		public function updateDescriptionSEO($vCode,$vCodPage,$vText){
            
            $vCode = (int) $vCode;
            $vCodPage = (int) $vCodPage;
            $vText = (string) $vText;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_descriptionseo
                                                            SET n_codpage = :n_codpage,
                                                                c_text = :c_text,
                                                                c_usermod = :c_usermod,
                                                                d_datemod = :d_datemod
                                                            WHERE n_coddescriptionseo = :n_coddescriptionseo;")
                            ->execute(
                                        array(
                                        ':n_codpage' => $vCodPage,
                                        ':c_text' => $vText,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_coddescriptionseo'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateRegistrationProcess($vCode,$vTitle,$vDesc){
            
            $vCode = (int) $vCode;
            $vTitle = (string) $vTitle;
            $vDesc = (string) $vDesc;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_registrationprocess
                                                            SET c_title = :c_title,
                                                                c_text = :c_text,
                                                                c_usermod = :c_usermod,
                                                                d_datemod = :d_datemod
                                                            WHERE n_codregistrationprocess = :n_codregistrationprocess;")
                            ->execute(
                                        array(
                                        ':c_title' => $vTitle,
                                        ':c_text' => $vDesc,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codregistrationprocess'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateRegistrationProcessImage($vCode,$vCodeImage){
            
            $vCode = (int) $vCode;
            $vCodeImage = (int) $vCodeImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'username');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_registrationprocess
                                                            SET tb_ibnc_registrationprocess.n_codimages = :n_codimages,
                                                                tb_ibnc_registrationprocess.c_usermod = :c_usermod,
                                                                tb_ibnc_registrationprocess.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_registrationprocess.n_codregistrationprocess = :n_codregistrationprocess;")
                            ->execute(
                                        array(
                                        ':n_codimages' => $vCodeImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codregistrationprocess'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateTestimonials($vCode, $vCodPage, $vName, $vBusiness, $vText, $vURL){
            
            $vCode = (int) $vCode;
            $vCodPage = (int) $vCodPage;
            $vName = (string) $vName;
            $vBusiness = (string) $vBusiness;
            $vText = (string) $vText;
            $vURL = (string) $vURL;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_testimonials
                                                            SET c_name = :c_name,
                                                                c_business = :c_business,
                                                                c_text = :c_text,
                                                                c_url = :c_url,
                                                                c_usermod = :c_usermod,
                                                                d_datemod = :d_datemod
                                                            WHERE n_codtestimonials = :n_codtestimonials;")
                            ->execute(
                                        array(
                                        ':c_name' => $vName,
                                        ':c_business' => $vBusiness,
                                        ':c_text' => $vText,
                                        ':c_url' => $vText,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codtestimonials'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateTestimonialImage($vCode,$vCodeImage){
            
            $vCode = (int) $vCode;
            $vCodeImage = (int) $vCodeImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'username');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_testimonials
                                                            SET tb_ibnc_testimonials.n_codimages = :n_codimages,
                                                                tb_ibnc_testimonials.c_usermod = :c_usermod,
                                                                tb_ibnc_testimonials.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_testimonials.n_codtestimonials = :n_codtestimonials;")
                            ->execute(
                                        array(
                                        ':n_codimages' => $vCodeImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codtestimonials'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
		public function updateComiteCodPDF($vCodPDF, $vIdComite){
            
            $vCodPDF = (int) $vCodPDF;
            $vIdComite = (int) $vIdComite;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'username');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_web_activecommitees
                                                            SET tb_ibnc_web_activecommitees.n_codpdf  = :n_codpdf,
                                                                tb_ibnc_web_activecommitees.c_usermod = :c_usermod,
                                                                tb_ibnc_web_activecommitees.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_web_activecommitees.id_comite = :id_comite;")
                            ->execute(
                                        array(
                                        ':n_codpdf' => $vCodPDF,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':id_comite'=>$vIdComite
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }

		public function updateIndexServicesCodPDF($vCodPDF, $vCodServicesIndex){
            
            $vCodPDF = (int) $vCodPDF;
            $vCodServicesIndex = (int) $vCodServicesIndex;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'username');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_services_index
                                                            SET tb_ibnc_services_index.n_codpdf  = :n_codpdf,
                                                                tb_ibnc_services_index.c_usermod = :c_usermod,
                                                                tb_ibnc_services_index.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_services_index.n_codservices_index = :n_codservices_index;")
                            ->execute(
                                        array(
                                        ':n_codpdf' => $vCodPDF,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codservices_index'=>$vCodServicesIndex
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        
		public function updateStatusAdvertisement($vCode, $vStatus){
            
            $vCode = (int) $vCode;
            $vStatus = (int) $vStatus;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'username');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_advertisement
                                                            SET tb_ibnc_advertisement.n_status  = :n_status,
                                                                tb_ibnc_advertisement.c_usermod = :c_usermod,
                                                                tb_ibnc_advertisement.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_advertisement.n_codadvertisement = :n_codadvertisement;")
                            ->execute(
                                        array(
                                        ':n_status' => $vStatus,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codadvertisement'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }

		public function updateImage($vCode, $vNameImage, $vDescImage){
            
            $vCode = (int) $vCode;
            $vNameImage = (string) $vNameImage;
            $vDescImage = (string) $vDescImage;
        
            $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'username');
            $vDateMod = date("Y-m-d H:i:s", time());

            $vResultUpdateItem = $this->vDataBase->prepare("UPDATE
                                                                tb_ibnc_images
                                                            SET tb_ibnc_images.c_image_name  = :c_image_name,
                                                                tb_ibnc_images.c_image_desc  = :c_image_desc,
                                                                tb_ibnc_images.c_usermod = :c_usermod,
                                                                tb_ibnc_images.d_datemod = :d_datemod
                                                            WHERE tb_ibnc_images.n_codimages = :n_codimages;")
                            ->execute(
                                        array(
                                        ':c_image_name' => $vNameImage,
                                        ':c_image_desc' => $vDescImage,
                                        ':c_usermod' => $vUserMod,
                                        ':d_datemod' => $vDateMod,
                                        ':n_codimages'=>$vCode
                                         )
                                     );            

            return $vResultUpdateItem = $this->vDataBase->lastInsertId();
            $vResultUpdateItem->close();
        }
        /* END UPDATE STATEMENT QUERY */

        /* BEGIN DELETE STATEMENT QUERY  */
        public function deleteHeaderIndex($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_header_index WHERE n_codheader_index = $vCode;");
        }
        public function deleteDetailIndex($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_detail_index WHERE n_coddetail_index = $vCode;");
        } 
        public function deleteBenefitsIndex($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_benefits_index WHERE n_codbenefits_index = $vCode;");
        } 
        public function deleteBenefitsServices($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_benefits_services WHERE n_codbenefits_services = $vCode;");
        }
        public function deleteServiceAnchoring($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_serviceanchoring WHERE n_codserviceanchoring = $vCode;");
        }
        public function deleteImage($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_images WHERE n_codimages = $vCode;");
        }
        public function deleteTitle($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_titles WHERE n_codtitle = $vCode;");
        }
        public function deletePartners($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_partners WHERE n_codpartners = $vCode;");
        }
        public function deleteIndexServices($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_services_index WHERE n_codservices_index = $vCode;");
        }
        public function deleteSectionServices($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_section_services WHERE n_codsection_services = $vCode;");
        }
        public function deleteCourseWeb($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_courses WHERE n_codcourses = $vCode;");
        }
        public function deleteServiceServicesAnchoring($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_services_anchoring WHERE n_codservices_anchoring = $vCode;");
        }
        public function deleteKeywords($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_keywords WHERE n_codkeywords = $vCode;");
        }
        public function deleteDescriptionSEO($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_descriptionseo WHERE n_coddescriptionseo = $vCode;");
        }
        public function deleteRegistrationProcess($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_registrationprocess WHERE n_codregistrationprocess = $vCode;");
        }
        public function deleteTestimonials($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_testimonials WHERE n_codtestimonials = $vCode;");
        }
        public function deleteNews($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_news WHERE n_codnews = $vCode;");
        }
        public function deleteComitePDF($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_web_pdf WHERE n_codpdf = $vCode;");
        }
        public function deletePDFRegister($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_web_pdf WHERE n_codpdf = $vCode;");
        }
        public function deleteSectorRelationship($vCodeSectorGroup){
            $vCodeSectorGroup = (int) $vCodeSectorGroup;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_sectorgroup WHERE n_codsectorgroup = $vCodeSectorGroup;");
        }
        public function deleteAdvertisement($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_advertisement WHERE n_codadvertisement = $vCode;");
        } 
        public function deleteSector($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_sectors WHERE n_codsector = $vCode;");
        }                 
    /* END DELETE STATEMENT QUERY  */        
    }
?>