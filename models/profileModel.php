<?php
class profileModel extends IdEnModel
	{
		public function __construct(){
				parent::__construct();
			}
            public function getProfileExists($vProfileName){
                $vProfileName = (string) $vProfileName;
                $vResultProfileExists = $this->vDataBase->query("SELECT
                                                                        COUNT(*)
                                                                    FROM tb_ibnc_profiles
                                                                        WHERE tb_ibnc_profiles.c_profilename = '$vProfileName';");
                return $vResultProfileExists->fetchColumn();
                $vResultProfileExists->close();            
            }
            public function getProfileCodFromProfileName($vProfileName){
                $vProfileName = (string) $vProfileName;
                $vResultProfileCodFromProfileName = $this->vDataBase->query("SELECT
                                                                                tb_ibnc_profiles.n_codprofile
                                                                            FROM tb_ibnc_profiles
                                                                                WHERE tb_ibnc_profiles.c_profilename = '".$vProfileName."';");
                return $vResultProfileCodFromProfileName->fetchColumn();
                $vResultProfileCodFromProfileName->close();            
            }                        
            public function getNames($vCodProfile){
                $vCodProfile = (int) $vCodProfile;
                $vResultNames = $this->vDataBase->query("SELECT
                                                                    tb_ibnc_profiles.c_name
                                                                FROM tb_ibnc_profiles
                                                                    WHERE tb_ibnc_profiles.n_codprofile = $vCodProfile;");
                return $vResultNames->fetchColumn();
                $vResultNames->close();            
            }    
            public function getLastNames($vCodProfile){
                $vCodProfile = (int) $vCodProfile;
                $vResultNames = $this->vDataBase->query("SELECT
                                                                    tb_ibnc_profiles.c_lastname
                                                                FROM tb_ibnc_profiles
                                                                    WHERE tb_ibnc_profiles.n_codprofile = $vCodProfile;");
                return $vResultNames->fetchColumn();
                $vResultNames->close();            
            }
            public function getProfile($vCodProfile){
                $vCodProfile = (int) $vCodProfile;
                $vResultProfiles = $this->vDataBase->query("SELECT
                                                                    tb_ibnc_profiles.*
                                                                FROM tb_ibnc_profiles
                                                                    WHERE tb_ibnc_profiles.n_codprofile = $vCodProfile;");
                return $vResultProfiles->fetchAll();
                $vResultProfiles->close();            
            }
            public function getCodUserFromCodProfile($vCodProfile){
                $vCodProfile = (int) $vCodProfile;
                $vResultProfiles = $this->vDataBase->query("SELECT
                                                                    tb_ibnc_profiles.n_coduser
                                                                FROM tb_ibnc_profiles
                                                                    WHERE tb_ibnc_profiles.n_codprofile = $vCodProfile;");
                return $vResultProfiles->fetchColumn();
                $vResultProfiles->close();            
            }
            public function getProfileNameFromCodProfile($vCodProfile){
                $vCodProfile = (int) $vCodProfile;
                $vResultProfiles = $this->vDataBase->query("SELECT
                                                                    tb_ibnc_profiles.c_profilename
                                                                FROM tb_ibnc_profiles
                                                                    WHERE tb_ibnc_profiles.n_codprofile = $vCodProfile;");
                return $vResultProfiles->fetchColumn();
                $vResultProfiles->close();            
            }                        
            public function getProfileCodeFromUserCode($vUserCode){
                $vUserCode = (int) $vUserCode;
                $vResultProfileCodFromProfileName = $this->vDataBase->query("SELECT
                                                                                tb_ibnc_profiles.n_codprofile
                                                                            FROM tb_ibnc_profiles
                                                                                WHERE tb_ibnc_profiles.n_coduser = $vUserCode;");
                return $vResultProfileCodFromProfileName->fetchColumn();
                $vResultProfileCodFromProfileName->close();            
            }
            public function getProfileName($vCodProfile, $vCodUser){
                $vCodProfile = (int) $vCodProfile;
                $vCodUser = (int) $vCodUser;
                $vResultProfileName = $this->vDataBase->query("SELECT
                                                                    tb_ibnc_profiles.c_profilename
                                                                FROM tb_ibnc_profiles
                                                                WHERE tb_ibnc_profiles.n_codprofile = $vCodProfile
                                                                AND tb_ibnc_profiles.n_coduser = $vCodUser;");
                return $vResultProfileName->fetchColumn();
                $vResultProfileName->close();            
            }

            /* INSERT */
            public function profileRegister($vUserCode, $vProfileName, $vName, $vLastName, $vProfileType, $vActive){
                $vUserCode = (int) $vUserCode;
                $vProfileName = (string) $vProfileName;
                $vName = (string) $vName;
                $vLastName = (string) $vLastName;
                $vProfileType = (int) $vProfileType;
                $vActive = (int) $vActive;
                if(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail') == null){
                    $vUserCreate = 'system['.date('d.m.Y h:m:s').']';
                } else {
                    $vUserCreate = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
                }
                $vDateCreate = date("Y-m-d H:i:s", time());
                $vResultProfileRegister = $this->vDataBase->prepare("INSERT INTO tb_ibnc_profiles(n_coduser, c_profilename, c_name, c_lastname, n_profiletype, n_active, c_usercreate, d_datecreate)
                                                                VALUES(:n_coduser, :c_profilename, :c_name, :c_lastname, :n_profiletype, :n_active, :c_usercreate, :d_datecreate)")
                                ->execute(
                                        array(
                                            ':n_coduser' => $vUserCode,
                                            ':c_profilename' => $vProfileName,
                                            ':c_name' => $vName,
                                            ':c_lastname' => $vLastName,
                                            ':n_profiletype' => $vProfileType,
                                            ':n_active' => $vActive,
                                            ':c_usercreate' => $vUserCreate,
                                            ':d_datecreate' => $vDateCreate
                                        ));
                return $vResultProfileRegister = $this->vDataBase->lastInsertId();
                $vResultProfileRegister->close();            
            }            
            /* UPDATE SECCION */
            public function updateProfile($vCodProfile,$vName,$vLastName,$vDesc,$vAddress,$vWhatsApp)
            {            
                $vCodProfile = (int) $vCodProfile;
                //$vCodUser = (int) $vCodUser;
                //$vProfileName = (string) $vProfileName;
                $vName = (string) $vName;
                $vLastName = (string) $vLastName;
                $vDesc = (string) $vDesc;
                $vAddress = (string) $vAddress;
                //$vDateBirth = $vDateBirth;
                $vWhatsApp = (string) $vWhatsApp;
                //$vProfileImg = (string) $vProfileImg;

                $vUserMod = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
                $vDateMod = date("Y-m-d H:i:s", time());

                $vResultUpdateProfileInfo = $this->vDataBase->prepare("UPDATE
                                                                        tb_ibnc_profiles
                                                                    SET tb_ibnc_profiles.c_name = :c_name,
                                                                        tb_ibnc_profiles.c_lastname = :c_lastname,
                                                                        tb_ibnc_profiles.c_description = :c_description,
                                                                        tb_ibnc_profiles.c_address = :c_address,
                                                                        tb_ibnc_profiles.c_whatsapp = :c_whatsapp,
                                                                        tb_ibnc_profiles.c_usermod = :c_usermod,
                                                                        tb_ibnc_profiles.d_datemod = :d_datemod
                                                                    WHERE tb_ibnc_profiles.n_codprofile = :n_codprofile;")
                                ->execute(
                                            array(
                                                ':c_name'=>$vName,
                                                ':c_lastname'=>$vLastName,
                                                ':c_description'=>$vDesc,
                                                ':c_address'=>$vAddress,
                                                ':c_whatsapp'=>$vWhatsApp,
                                                ':c_usermod'=>$vUserMod,
                                                ':d_datemod'=>$vDateMod,
                                                ':n_codprofile'=>$vCodProfile
                                                 )
                                         );
                return $vResultUpdateProfileInfo;
                $vResultUpdateProfileInfo->close();
			}
                        
            /* */

            public function deleteProfileFromUserCod($vCode){
                $vCode = (int) $vCode;				
                $this->vDataBase->query("DELETE FROM tb_ibnc_profiles WHERE n_coduser = $vCode;");
            }            
}
?>