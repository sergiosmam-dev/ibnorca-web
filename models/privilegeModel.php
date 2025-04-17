<?php

class privilegeModel extends IdEnModel
	{
		public function __construct(){
				parent::__construct();
			}
        
        /* BEGIN SELECT STATEMENT QUERY  */
		public function getPrivilege()
			{
				$vResultGetPrivilege = $this->vDataBase->query("SELECT * FROM tb_ibnc_privileges;");
				return $vResultGetPrivilege->fetchAll();
				$vResultGetPrivilege->close();
			}
        public function getPrivilegeExists($vCodPrivilege)
			{
                $vCodPrivilege = (int) $vCodPrivilege;
				$vResultGetPrivilege = $this->vDataBase->query("SELECT COUNT(*) FROM tb_ibnc_privileges WHERE n_codprivilege = $vCodPrivilege;");
				return $vResultGetPrivilege->fetchColumn();
				$vResultGetPrivilege->close();
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
		public function insertPrivilege($vNamePrivilege, $vRolePrivilege, $vStatus, $vActive){
            
            $vNamePrivilege = (string)$vNamePrivilege;
            $vRolePrivilege = (string) $vRolePrivilege;            
            $vStatus = (int) $vStatus;
            $vActive = (int) $vActive;
            
            $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
            $vDateCreate = date("Y-m-d H:i:s", time());

            $vResultInsertPrivilege = $this->vDataBase->prepare("INSERT INTO tb_ibnc_privileges(c_name_privilege,c_role_privilege,n_status,n_active,c_usercreate,d_datecreate)
                                                                                                VALUES(:c_name_privilege,:c_role_privilege,:n_status,:n_active,:c_usercreate,:d_datecreate)")
                            ->execute(
                                    array(
                                        ':c_name_privilege' => $vNamePrivilege,
                                        ':c_role_privilege' => $vRolePrivilege,
                                        ':n_status' => $vStatus,
                                        ':n_active' => $vActive,
                                        ':c_usercreate' => $vUserCreate,
                                        ':d_datecreate' => $vDateCreate,
                                    ));
        
            return $vResultInsertPrivilege = $this->vDataBase->lastInsertId();
            $vResultInsertPrivilege->close();            
        }            
        /* END INSERT STATEMENT QUERY  */    
    
    }