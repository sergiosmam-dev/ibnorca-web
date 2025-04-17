<?php

class moduleModel extends IdEnModel
	{
		public function __construct(){
				parent::__construct();
			}
        
        /* BEGIN SELECT STATEMENT QUERY  */
		public function getModule()
			{
				$vResultGetModule = $this->vDataBase->query("SELECT
                                                                    tb_ibnc_modules.*,
                                                                    (SELECT
                                                                            tb_ibnc_menu.c_iconmenu
                                                                        FROM tb_ibnc_menu
                                                                            WHERE tb_ibnc_menu.n_codmenu = tb_ibnc_modules.n_codmenu) AS c_iconmenu
                                                                FROM tb_ibnc_modules;");
				return $vResultGetModule->fetchAll();
				$vResultGetModule->close();
			}
        public function getModuleExists($vCodModule)
			{
                $vCodModule = (int) $vCodModule;
				$vResultGetModule = $this->vDataBase->query("SELECT COUNT(*) FROM tb_ibnc_modules WHERE n_codmodule = $vCodModule;");
				return $vResultGetModule->fetchColumn();
				$vResultGetModule->close();
			}
        public function getMethodsFromCodModule($vCodeMenu)
			{
                $vCodeMenu = (int) $vCodeMenu;
				$vResultGetMethodsFromCodModule = $this->vDataBase->query("SELECT * FROM tb_ibnc_menu WHERE n_parent = $vCodeMenu;");
				return $vResultGetMethodsFromCodModule->fetchAll();
				$vResultGetMethodsFromCodModule->close();
			}            
        /* END SELECT STATEMENT QUERY  */

        /* BEGIN INSERT STATEMENT QUERY  */
		public function insertUserFacebook($vUserOauthProvider, $vUserFacebookId, $vUserFacebookFirstName, $vUserFacebookLastName, $vUserFacebookEmail, $vUserFacebookGender, $vUserFacebookLocale, $vUserFacebookImage, $vUserFacebookLink){
            
            /*$vUserOauthProvider = $vUserOauthProvider;
            $vUserFacebookId = $vUserFacebookId;            
            $vUserFacebookFirstName = $vUserFacebookFirstName;
            $vUserFacebookLastName = $vUserFacebookLastName;
            $vUserFacebookEmail = $vUserFacebookEmail;
            $vUserFacebookGender = $vUserFacebookGender;
            $vUserFacebookLocale = $vUserFacebookLocale;
            $vUserFacebookImage = $vUserFacebookImage;
            $vUserFacebookLink = $vUserFacebookLink;*/
            
            $vCreate = date("Y-m-d H:i:s");

            $vResultInsertUserFacebook = $this->vDataBase->prepare("INSERT INTO tb_ibnc_facebookusers(c_id,c_oauth_provider,c_first_name,c_last_name,c_email,c_gender,c_locale,c_picture,c_link,d_datecreate)
                                                                                                VALUES(:c_id,:c_oauth_provider,:c_first_name,:c_last_name,:c_email,:c_gender,:c_locale,:c_picture,:c_link,:d_datecreate)")
                            ->execute(
                                    array(
                                        ':c_id' => $vUserFacebookId,
                                        ':c_oauth_provider' => $vUserOauthProvider,
                                        ':c_first_name' => $vUserFacebookFirstName,
                                        ':c_last_name' => $vUserFacebookLastName,
                                        ':c_email' => $vUserFacebookEmail,
                                        ':c_gender' => $vUserFacebookGender,                                            
                                        ':c_locale' => $vUserFacebookLocale,
                                        ':c_picture' => $vUserFacebookImage,
                                        ':c_link' => $vUserFacebookLink,
                                        ':d_datecreate' => $vCreate
                                    ));
        
            return $vResultInsertUserFacebook = $this->vDataBase->lastInsertId();
            $vResultInsertUserFacebook->close();            
        }
		public function insertModule($vCodeMenu, $vModuleName, $vModuleRole, $vStatus, $vActive){
            
            $vCodeMenu = (int) $vCodeMenu;
            $vModuleName = (string) $vModuleName;
            $vModuleRole = (string) $vModuleRole;            
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsertModule = $this->vDataBase->prepare("INSERT INTO tb_ibnc_modules(n_codmenu, c_name_module,c_role_module,n_status,n_active,c_usercreate,d_datecreate)
                                                                                                VALUES(:n_codmenu,:c_name_module,:c_role_module,:n_status,:n_active,:c_usercreate,:d_datecreate)")
                            ->execute(
                                    array(
                                        ':n_codmenu' => $vCodeMenu,
                                        ':c_name_module' => $vModuleName,
                                        ':c_role_module' => $vModuleRole,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate,
                                    ));
        
            return $vResultInsertModule = $this->vDataBase->lastInsertId();
            $vResultInsertModule->close();            
        }            
        /* END INSERT STATEMENT QUERY  */    
    
    }