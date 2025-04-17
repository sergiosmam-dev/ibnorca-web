<?php

class usersModel extends IdEnModel
	{
		public function __construct(){
				parent::__construct();
			}

        /* BEGIN SELECT STATEMENT QUERY  */
        public function getUsers(){
            $vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode');

            if($vUserCode == 1){
                $vResultUsers = $this->vDataBase->query("SELECT
                                                    tb_ibnc_users.n_coduser,
                                                    tb_ibnc_users.c_rrss_id,
                                                    tb_ibnc_users.c_username,
                                                    tb_ibnc_users.c_pass1,
                                                    tb_ibnc_users.c_pass2,
                                                    tb_ibnc_users.c_email,
                                                    tb_ibnc_users.c_userrole,
                                                    tb_ibnc_users.n_tnc,
                                                    tb_ibnc_users.n_activationcode,
                                                    tb_ibnc_users.n_status,
                                                    tb_ibnc_users.n_active,
                                                    (SELECT
                                                            tb_ibnc_profiles.n_codprofile
                                                        FROM tb_ibnc_profiles
                                                            WHERE tb_ibnc_profiles.n_coduser = tb_ibnc_users.n_coduser) as n_codprofile,                                                        
                                                    IFNULL((SELECT
                                                            tb_ibnc_profiles.c_profile_img
                                                        FROM tb_ibnc_profiles
                                                            WHERE tb_ibnc_profiles.n_coduser = tb_ibnc_users.n_coduser), 'blank.png') as c_profile_img
                                                FROM tb_ibnc_users;");
                return $vResultUsers->fetchAll();
                $vResultUsers->close();
            } else {
                $vResultUsers = $this->vDataBase->query("SELECT
                                                    tb_ibnc_users.n_coduser,
                                                    tb_ibnc_users.c_rrss_id,
                                                    tb_ibnc_users.c_username,
                                                    tb_ibnc_users.c_pass1,
                                                    tb_ibnc_users.c_pass2,
                                                    tb_ibnc_users.c_email,
                                                    tb_ibnc_users.c_userrole,
                                                    tb_ibnc_users.n_tnc,
                                                    tb_ibnc_users.n_activationcode,
                                                    tb_ibnc_users.n_status,
                                                    tb_ibnc_users.n_active,
                                                    (SELECT
                                                            tb_ibnc_profiles.n_codprofile
                                                        FROM tb_ibnc_profiles
                                                            WHERE tb_ibnc_profiles.n_coduser = tb_ibnc_users.n_coduser) as n_codprofile,                                                        
                                                    IFNULL((SELECT
                                                            tb_ibnc_profiles.c_profile_img
                                                        FROM tb_ibnc_profiles
                                                            WHERE tb_ibnc_profiles.n_coduser = tb_ibnc_users.n_coduser), 'blank.png') as c_profile_img
                                                FROM tb_ibnc_users
                                                    WHERE tb_ibnc_users.n_coduser <> 1;");
                return $vResultUsers->fetchAll();
                $vResultUsers->close();
            }            
        }
        public function getUser($vCodeUser){
            $vCodeUser = (int) $vCodeUser;
            $vResultUser = $this->vDataBase->query("SELECT
                                                            tb_ibnc_users.n_coduser,
                                                            tb_ibnc_users.c_rrss_id,
                                                            tb_ibnc_users.c_username,
                                                            tb_ibnc_users.c_email,
                                                            tb_ibnc_users.c_userrole,
                                                            tb_ibnc_users.n_status,
                                                            tb_ibnc_users.n_active,
                                                            tb_ibnc_profiles.c_name,
                                                            tb_ibnc_profiles.c_lastname
                                                        FROM tb_ibnc_users, tb_ibnc_profiles
                                                            WHERE tb_ibnc_users.n_coduser = tb_ibnc_profiles.n_coduser
                                                                AND tb_ibnc_users.n_coduser = $vCodeUser;");
            return $vResultUser->fetchAll();
            $vResultUser->close();            
        }        
        public function getUserEmailExists($vEmail){
            $vEmail = (string) $vEmail;
            $vResultUserEmailExists = $this->vDataBase->query("SELECT
                                                                    COUNT(*)
                                                                FROM tb_ibnc_users
                                                                    WHERE tb_ibnc_users.c_email = '".$vEmail."';");
            return $vResultUserEmailExists->fetchColumn();
            $vResultUserEmailExists->close();            
        }               
        public function getUserNameExists($vEmail){
            $vEmail = (string) $vEmail;
            $vResultUserEmailExists = $this->vDataBase->query("SELECT
                                                                    COUNT(*)
                                                                FROM tb_ibnc_users
                                                                    WHERE tb_ibnc_users.c_username = '".$vEmail."';");
            return $vResultUserEmailExists->fetchColumn();
            $vResultUserEmailExists->close();            
        }
		public function getUserAccountStatus($vEmail)
			{
				$vEmail = (string) $vEmail;

				$vResultGetUserAccountStatus = $this->vDataBase->query("SELECT
                                                                                tb_ibnc_users.n_active
                                                                            FROM tb_ibnc_users
                                                                                WHERE tb_ibnc_users.c_email = '".$vEmail."';");
				return $vResultGetUserAccountStatus->fetchColumn();
				$vResultGetUserAccountStatus->close();
			}
		public function getAccountStatusUserCode($vCodUser)
			{
				$vCodUser = (int) $vCodUser;

				$vResultGetUserAccountStatus = $this->vDataBase->query("SELECT
                                                                                tb_ibnc_users.n_active
                                                                            FROM tb_ibnc_users
                                                                                WHERE tb_ibnc_users.n_coduser = $vCodUser;");
				return $vResultGetUserAccountStatus->fetchColumn();
				$vResultGetUserAccountStatus->close();
			}    
        public function getCodUserFromCodFacebookUser($vCodFacebookUser){
            $vCodFacebookUser = (string) $vCodFacebookUser;
            $vResultCodUser = $this->vDataBase->query("SELECT
                                                                tb_ibnc_users.n_coduser
                                                            FROM tb_ibnc_users
                                                                WHERE tb_ibnc_users.c_rrss_id = '".$vCodFacebookUser."';");
            return $vResultCodUser->fetchColumn();
            $vResultCodUser->close();            
        }
        public function getCodUserFromCodGoogleUser($vCodGoogleUser){
            $vCodGoogleUser = (string) $vCodGoogleUser;
            $vResultCodUser = $this->vDataBase->query("SELECT
                                                                tb_ibnc_users.n_coduser
                                                            FROM tb_ibnc_users
                                                                WHERE tb_ibnc_users.c_rrss_id = '".$vCodGoogleUser."';");
            return $vResultCodUser->fetchColumn();
            $vResultCodUser->close();            
        }
        public function getCodFacebookUserFromCodUser($vCodUser){
            $vCodUser = (string) $vCodUser;
            $vResultCodUser = $this->vDataBase->query("SELECT
                                                                tb_ibnc_users.c_rrss_id
                                                            FROM tb_ibnc_users
                                                                WHERE tb_ibnc_users.n_coduser = $vCodUser;");
            return $vResultCodUser->fetchColumn();
            $vResultCodUser->close();            
        } 
        public function getCodGoogleUserFromCodUser($vCodUser){
            $vCodUser = (string) $vCodUser;
            $vResultCodUser = $this->vDataBase->query("SELECT
                                                                tb_ibnc_users.n_codgoogleuser
                                                            FROM tb_ibnc_users
                                                                WHERE tb_ibnc_users.n_coduser = $vCodUser;");
            return $vResultCodUser->fetchColumn();
            $vResultCodUser->close();            
        } 
        public function getUserEmail($vCodUser){
            $vCodUser = (int) $vCodUser;
            $vResultUserEmail = $this->vDataBase->query("SELECT
                                                                tb_ibnc_users.c_email
                                                            FROM tb_ibnc_users
                                                                WHERE tb_ibnc_users.n_coduser = $vCodUser;");
            return $vResultUserEmail->fetchColumn();
            $vResultUserEmail->close();            
        }
        public function getUserActivationCode($vCodUser){
            $vCodUser = (int) $vCodUser;
            $vResultUserActivationCode = $this->vDataBase->query("SELECT
                                                                tb_ibnc_users.n_activationcode
                                                            FROM tb_ibnc_users
                                                                WHERE tb_ibnc_users.n_coduser = $vCodUser;");
            return $vResultUserActivationCode->fetchColumn();
            $vResultUserActivationCode->close();            
        }    
        public function getUserRole($vCodUser){
            $vCodUser = (int) $vCodUser;
            $vResultUserRole = $this->vDataBase->query("SELECT
                                                                tb_ibnc_users.c_userrole
                                                            FROM tb_ibnc_users
                                                                WHERE tb_ibnc_users.n_coduser = $vCodUser;");
            return $vResultUserRole->fetchColumn();
            $vResultUserRole->close();            
        }
		public function getUserCode($vEmail)
			{
				$vEmail = (string) $vEmail;

				$vResultGetUserCode = $this->vDataBase->query("SELECT
                                                                                tb_ibnc_users.n_coduser
                                                                            FROM tb_ibnc_users
                                                                                WHERE tb_ibnc_users.c_email = '".$vEmail."';");
				return $vResultGetUserCode->fetchColumn();
				$vResultGetUserCode->close();
			}
        public function getPrivileges($vCodUser, $vUserRole){
            $vCodUser = (int) $vCodUser;
            $vUserRole = (string) $vUserRole;
            $vResultPrivileges = $this->vDataBase->query("SELECT
                                                                count(*)
                                                            FROM tb_ibnc_users
                                                                WHERE tb_ibnc_users.n_coduser = $vCodUser
                                                                    AND tb_ibnc_users.c_userrole = $vUserRole;");
            return $vResultPrivileges->fetchColumn();
            $vResultPrivileges->close();            
        }        
        public function getFacebookProfileImage($vCodUser){
            $vCodUser = (int) $vCodUser;
            $vResultFacebookProfileImage = $this->vDataBase->query("SELECT
                                                                        tb_ibnc_facebookusers.c_picture
                                                                    FROM tb_ibnc_users, tb_ibnc_facebookusers
                                                                        WHERE tb_ibnc_users.n_coduser = tb_ibnc_facebookusers.c_rrss_id
                                                                            AND tb_ibnc_users.n_coduser = $vCodUser;");
            return $vResultFacebookProfileImage->fetchColumn();
            $vResultFacebookProfileImage->close();            
        }
        public function getGoogleProfileImage($vCodUser){
            $vCodUser = (int) $vCodUser;
            $vResultGoogleProfileImage = $this->vDataBase->query("SELECT
                                                                        tb_ibnc_googleusers.c_picture
                                                                    FROM tb_ibnc_users, tb_ibnc_googleusers
                                                                        WHERE tb_ibnc_users.n_coduser = tb_ibnc_googleusers.n_codgoogleuser
                                                                            AND tb_ibnc_users.n_coduser = $vCodUser;");
            return $vResultGoogleProfileImage->fetchColumn();
            $vResultGoogleProfileImage->close();            
        }
        public function getPassword($vCodUser){
            $vCodUser = (int) $vCodUser;
            $vResultPassword = $this->vDataBase->query("SELECT
                                                                tb_ibnc_users.c_pass1
                                                            FROM tb_ibnc_users
                                                                WHERE tb_ibnc_users.n_coduser = $vCodUser;");
            return $vResultPassword->fetchColumn();
            $vResultPassword->close();            
        }
        public function getRePassword($vCodUser){
            $vCodUser = (int) $vCodUser;
            $vResultRePassword = $this->vDataBase->query("SELECT
                                                                tb_ibnc_users.c_pass2
                                                            FROM tb_ibnc_users
                                                                WHERE tb_ibnc_users.n_coduser = $vCodUser;");
            return $vResultRePassword->fetchColumn();
            $vResultRePassword->close();            
        }
        public function getUserDateCreate($vCodUser){
            $vCodUser = (int) $vCodUser;
            $vResultUserDateCreate = $this->vDataBase->query("SELECT
                                                                tb_ibnc_users.d_datecreate
                                                            FROM tb_ibnc_users
                                                                WHERE tb_ibnc_users.n_coduser = $vCodUser;");
            return $vResultUserDateCreate->fetchColumn();
            $vResultUserDateCreate->close();            
        }    
        /* END SELECT STATEMENT QUERY  */
    
        /* BEGIN INSERT STATEMENT QUERY  */
		public function userRegister($vUserFacebookId, $vUsername, $vPassword1, $vPassword2, $vEmail, $vRole, $vActivationcode, $vStatus, $vActive){
            
                $vUserFacebookId = $vUserFacebookId;
                $vUsername = (string) $vUsername;
                $vPassword1 = (string) IdEnHash::getHash('sha1',$vPassword1,DEFAULT_HASH_KEY);
                $vPassword2 = (string) IdEnHash::getHash('sha1',$vPassword2,DEFAULT_HASH_KEY);            
                $vEmail = (string) $vEmail;
                $vRole = (string) "'".$vRole."'";
                $vActivationcode = (int) $vActivationcode;
                $vStatus = (int) $vStatus;
                $vActive = (int) $vActive;
            
                if(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'Email') == null){
                    $vUserCreate = 'system['.date('d.m.Y h:m:s').']';
                } else {
                    $vUserCreate = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'Email');
                }

				$vResultUserRegister = $this->vDataBase->prepare("INSERT INTO tb_ibnc_users(c_rrss_id, c_username, c_pass1, c_pass2, c_email, c_userrole, n_activationcode, n_status, n_active, c_usercreate, d_datecreate)
																VALUES(:c_rrss_id, :c_username, :c_pass1, :c_pass2, :c_email, :c_userrole, :n_activationcode, :n_status, :n_active, :c_usercreate, NOW())")
								->execute(
										array(
                                            ':c_rrss_id' => $vUserFacebookId,
                                            ':c_username' => $vUsername,
                                            ':c_pass1' => $vPassword1,
                                            ':c_pass2' => $vPassword2,
                                            ':c_email' => $vEmail,
                                            ':c_userrole' => $vRole,
                                            ':n_activationcode' => $vActivationcode,
                                            ':n_status' => $vStatus,
                                            ':n_active' => $vActive,
                                            ':c_usercreate' => $vUserCreate,
										));
                return $vResultUserRegister = $this->vDataBase->lastInsertId();
                $vResultUserRegister->close();
			}

        /* END INSERT STATEMENT QUERY  */
        
        /* BEGIN UPDATE STATEMENT QUERY  */
		public function updateUser($vCodUser, $vEmail, $vRole, $vStatus, $vActive)
            {            
                $vCodUser = (int) $vCodUser;
                $vEmail = (string) $vEmail;
                $vRole = (string) "'".$vRole."'";
                $vStatus = (int) $vStatus;
                $vActive = (int) $vActive;

                $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
                $vDateMod = date("Y-m-d H:i:s", time());
                $vResultUpdateUser = $this->vDataBase->prepare("UPDATE
                                                                        tb_ibnc_users
                                                                    SET tb_ibnc_users.c_username = :c_username,
                                                                        tb_ibnc_users.c_email = :c_email,
                                                                        tb_ibnc_users.c_userrole = :c_userrole,
                                                                        tb_ibnc_users.n_status = :n_status,
                                                                        tb_ibnc_users.n_active = :n_active,
                                                                        tb_ibnc_users.c_usermod = :c_usermod,
                                                                        tb_ibnc_users.d_datemod = :d_datemod
                                                                    WHERE tb_ibnc_users.n_coduser = :n_coduser;")
                                ->execute(
                                            array(
                                                ':c_username'=>$vEmail,
                                                ':c_email'=>$vEmail,
                                                ':c_userrole'=>$vRole,
                                                ':n_status'=>$vStatus,
                                                ':n_active'=>$vActive,
                                                ':c_usermod'=>$vUserMod,
                                                ':d_datemod'=>$vDateMod,
                                                ':n_coduser'=>$vCodUser
                                                 )
                                         );
                return $vResultUpdateUser;
                $vResultUpdateUser->close();
			}
            public function updateEmailProfile($vCodUser, $vEmail)
            {            
                $vCodUser = (int) $vCodUser;
                $vEmail = (string) $vEmail;
                $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'Email');
                $vDateMod = date("Y-m-d H:i:s", time());
                $vResultUpdateAccount = $this->vDataBase->prepare("UPDATE
                                                                            tb_ibnc_users
                                                                        SET tb_ibnc_users.c_email = :c_email,
                                                                            tb_ibnc_users.c_usermod = :c_usermod,
                                                                            tb_ibnc_users.d_datemod = :d_datemod
                                                                        WHERE tb_ibnc_users.n_coduser = :n_coduser;")
                                ->execute(
                                            array(
                                                ':c_email'=>$vEmail,
                                                ':c_usermod'=>$vUserMod,
                                                ':d_datemod'=>$vDateMod,
                                                ':n_coduser'=>$vCodUser
                                                 )
                                         );
                return $vResultUpdateAccount;
                $vResultUpdateAccount->close();
			}            
		public function updateUserPassword($vCodUser, $vNewPassword, $vNewRePassword)
            {            
                $vCodUser = (int) $vCodUser;
                $vPassword = (string) IdEnHash::getHash('sha1',$vNewPassword,DEFAULT_HASH_KEY);
                $vRePassword = (string) IdEnHash::getHash('sha1',$vNewRePassword,DEFAULT_HASH_KEY);
                $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'Email');
                $vDateMod = date("Y-m-d H:i:s", time());
                $vResultUpdatePassword = $this->vDataBase->prepare("UPDATE
                                                                            tb_ibnc_users
                                                                        SET tb_ibnc_users.c_pass1 = :c_pass1,
                                                                            tb_ibnc_users.c_pass2 = :c_pass2,
                                                                            tb_ibnc_users.c_usermod = :c_usermod,
                                                                            tb_ibnc_users.d_datemod = :d_datemod
                                                                        WHERE tb_ibnc_users.n_coduser = :n_coduser;")
                                ->execute(
                                            array(
                                                ':c_pass1'=>$vPassword,
                                                ':c_pass2'=>$vRePassword,
                                                ':c_usermod'=>$vUserMod,
                                                ':d_datemod'=>$vDateMod,
                                                ':n_coduser'=>$vCodUser
                                                 )
                                         );
                return $vResultUpdatePassword;
                $vResultUpdatePassword->close();
			}
        public function updateUserActive($vCodUser, $vActive)
            {            
                $vCodUser = (int) $vCodUser;
                $vActive = (int) $vActive;
            
                $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'Email');
                $vDateMod = date("Y-m-d H:i:s", time());
                $vResultUpdatePassword = $this->vDataBase->prepare("UPDATE
                                                                            tb_ibnc_users
                                                                        SET tb_ibnc_users.n_active = :n_active,
                                                                            tb_ibnc_users.c_usermod = :c_usermod,
                                                                            tb_ibnc_users.d_datemod = :d_datemod
                                                                        WHERE tb_ibnc_users.n_coduser = :n_coduser;")
                                ->execute(
                                            array(
                                                ':n_active'=>$vActive,
                                                ':c_usermod'=>$vUserMod,
                                                ':d_datemod'=>$vDateMod,
                                                ':n_coduser'=>$vCodUser
                                                 )
                                         );
                return $vResultUpdatePassword;
                $vResultUpdatePassword->close();
			}
        public function updateModuleUser($vCodUserToAssign, $vModuleAssigned)
            {            
                $vCodUser = (int) $vCodUserToAssign;
                $vModuleAssigned = (string) $vModuleAssigned;
            
                $vUserMod = (string) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
                $vDateMod = date("Y-m-d H:i:s", time());
                $vResultUpdateModuleUser = $this->vDataBase->prepare("UPDATE
                                                                            tb_ibnc_users
                                                                        SET tb_ibnc_users.c_userrole = :c_userrole,
                                                                            tb_ibnc_users.c_usermod = :c_usermod,
                                                                            tb_ibnc_users.d_datemod = :d_datemod
                                                                        WHERE tb_ibnc_users.n_coduser = :n_coduser;")
                                ->execute(
                                            array(
                                                ':c_userrole'=>$vModuleAssigned,
                                                ':c_usermod'=>$vUserMod,
                                                ':d_datemod'=>$vDateMod,
                                                ':n_coduser'=>$vCodUser
                                                 )
                                         );
                return $vResultUpdateModuleUser;
                $vResultUpdateModuleUser->close();
			}                
        /* END UPDATE STATEMENT QUERY  */

        public function deleteUser($vCode){
            $vCode = (int) $vCode;				
            $this->vDataBase->query("DELETE FROM tb_ibnc_users WHERE n_coduser = $vCode;");
        }        
    }