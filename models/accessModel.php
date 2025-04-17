<?php

class accessModel extends IdEnModel
	{
		public function __construct(){
				parent::__construct();
			}
        
        /* BEGIN SELECT STATEMENT QUERY  */
		public function getValidPassword($vEmail,$vPassword)
			{
				$vEmail = (string) $vEmail;
                $vPassword = (string) IdEnHash::getHash('sha1',$vPassword,DEFAULT_HASH_KEY);

				$vResultGetValidPassword = $this->vDataBase->query("SELECT
                                                                                COUNT(*)
                                                                            FROM tb_ibnc_users
                                                                                WHERE tb_ibnc_users.c_email = '".$vEmail."'
                                                                                    AND tb_ibnc_users.c_pass1 = '".$vPassword."';");
				return $vResultGetValidPassword->fetchColumn();
				$vResultGetValidPassword->close();
			}    
		public function askIfFacebookUserExists($vFacebookUserId)
			{
				$vFacebookUserId = (int) $vFacebookUserId;

				$vResultAskIfFacebookUserExists = $this->vDataBase->query("SELECT
                                                                            COUNT(tb_ibnc_facebookusers.c_id)
                                                                        FROM tb_ibnc_facebookusers
                                                                            WHERE tb_ibnc_facebookusers.c_id = '$vFacebookUserId';");
				return $vResultAskIfFacebookUserExists->fetchColumn();
				$vResultAskIfFacebookUserExists->close();
			}
        public function getCodFacebookUserFromFacebookId($vFacebookId){
            $vFacebookId = (string) $vFacebookId;
            $vResultCodFacebookUserFromFacebookId = $this->vDataBase->query("SELECT
                                                                tb_ibnc_facebookusers.n_codfacebookuser
                                                            FROM tb_ibnc_facebookusers
                                                                WHERE tb_ibnc_facebookusers.c_id = '$vFacebookId';");
            return $vResultCodFacebookUserFromFacebookId->fetchColumn();
            $vResultCodFacebookUserFromFacebookId->close();            
            }
            public function getAccessStatus($vEmail,$vPassword){
				$vEmail = (string) $vEmail;
				$vPassword = (string) IdEnHash::getHash('sha1',$vPassword,DEFAULT_HASH_KEY);

				$vResultAccessStatus = $this->vDataBase->query("SELECT
                                                                    tb_ibnc_users.n_coduser,
                                                                    tb_ibnc_users.c_username,
                                                                    tb_ibnc_users.c_pass1,
                                                                    tb_ibnc_users.c_pass2,
                                                                    tb_ibnc_users.c_email,
                                                                    tb_ibnc_users.c_userrole,
                                                                    tb_ibnc_users.c_email,
                                                                    tb_ibnc_users.n_active,
                                                                    tb_ibnc_profiles.c_profilename,
                                                                    tb_ibnc_profiles.c_name,
                                                                    tb_ibnc_profiles.c_lastname
                                                                FROM tb_ibnc_users, tb_ibnc_profiles
                                                                    WHERE tb_ibnc_users.n_coduser = tb_ibnc_profiles.n_coduser
                                                                        AND tb_ibnc_users.c_email = '".$vEmail."'
                                                                        AND tb_ibnc_users.c_pass1 = '".$vPassword."'
                                                                        AND tb_ibnc_users.c_pass2 = '".$vPassword."';");
				return $vResultAccessStatus->fetch();
				$vResultAccessStatus->close();
			}
            public function getAccessStatusIbnorca($vEmail){
				$vEmail = (string) $vEmail;
				$vPassword = (string) IdEnHash::getHash('sha1',$vPassword,DEFAULT_HASH_KEY);

				$vResultAccessStatus = $this->vDataBase->query("SELECT
                                                                    tb_ibnc_users.n_coduser,
                                                                    tb_ibnc_users.c_username,
                                                                    tb_ibnc_users.c_pass1,
                                                                    tb_ibnc_users.c_pass2,
                                                                    tb_ibnc_users.c_email,
                                                                    tb_ibnc_users.c_userrole,
                                                                    tb_ibnc_users.c_email,
                                                                    tb_ibnc_users.n_active,
                                                                    tb_ibnc_profiles.c_profilename,
                                                                    tb_ibnc_profiles.c_name,
                                                                    tb_ibnc_profiles.c_lastname
                                                                FROM tb_ibnc_users, tb_ibnc_profiles
                                                                    WHERE tb_ibnc_users.n_coduser = tb_ibnc_profiles.n_coduser
                                                                        AND tb_ibnc_users.c_email = '".$vEmail."';");
				return $vResultAccessStatus->fetch();
				$vResultAccessStatus->close();
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
        /* END INSERT STATEMENT QUERY  */    
    
    }