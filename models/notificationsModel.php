<?php

class notificationsModel extends IdEnModel
	{
		public function __construct(){
				parent::__construct();
			}

        /* BEGIN SELECT STATEMENT QUERY  */
        public function getNotifications($vCodeNotifications){
            if($vCodeNotifications == 'all'){
                $vResultNotifications = $this->vDataBase->query("SELECT * FROM tb_mut_notifications;");
                return $vResultNotifications->fetchAll();
                $vResultNotifications->close();
            } else {
                $vCodeNotifications = (int) $vCodeNotifications;
                $vResultNotifications = $this->vDataBase->query("SELECT
                                                                      tb_mut_notifications.*
                                                                    FROM tb_mut_notifications
                                                                      WHERE tb_mut_notifications.n_codnotifications = $vCodeNotifications;");
                return $vResultNotifications->fetchAll();
                $vResultNotifications->close();                
            }
        }
        public function getProfileToNotification($vCodeProfileNotification){
            $vCodeProfileNotification = (int) $vCodeProfileNotification;
            $vResultProfileToNotification = $this->vDataBase->query("SELECT
                                                                  tb_mut_profilenotifications.n_codprofileto
                                                                FROM tb_mut_profilenotifications
                                                                  WHERE tb_mut_profilenotifications.n_codprofilenotification = $vCodeProfileNotification;");
            return $vResultProfileToNotification->fetchColumn();
            $vResultProfileToNotification->close();
        }    
        public function getCodeNotificationsFromNameNotification($vNotificationName){
            $vNotificationName = (string) $vNotificationName;
            $vResultNotifications = $this->vDataBase->query("SELECT
                                                                  tb_mut_notifications.n_codnotifications
                                                                FROM tb_mut_notifications
                                                                  WHERE tb_mut_notifications.c_notifications_name = '".$vNotificationName."';");
            return $vResultNotifications->fetchColumn();
            $vResultNotifications->close();
        }
        public function getProfileNotifications($vCodProfile, $vState){

            if($vState == 'all'){
                $vCodProfile = (int) $vCodProfile;
                $vResultNotifications = $this->vDataBase->query("SELECT
                                                                        tb_mut_profilenotifications.*,
                                                                        (SELECT
                                                                              CONCAT(tb_mut_profiles.c_name,' ',tb_mut_profiles.c_lastname)
                                                                            FROM tb_mut_profiles
                                                                              WHERE tb_mut_profiles.n_codprofile = tb_mut_profilenotifications.n_codprofilefrom) AS c_profilenames,
                                                                        (SELECT
                                                                              tb_mut_notifications.c_notifications_name
                                                                            FROM tb_mut_notifications
                                                                              WHERE tb_mut_notifications.n_codnotifications = tb_mut_profilenotifications.n_codnotification_in) AS c_notifications_name,
                                                                        (SELECT
                                                                              tb_mut_notifications.c_notifications_desc
                                                                            FROM tb_mut_notifications
                                                                              WHERE tb_mut_notifications.n_codnotifications = tb_mut_profilenotifications.n_codnotification_in) AS c_notifications_desc,
                                                                        (SELECT
                                                                              tb_mut_notifications.c_notifications_controller
                                                                            FROM tb_mut_notifications
                                                                              WHERE tb_mut_notifications.n_codnotifications = tb_mut_profilenotifications.n_codnotification_in) AS c_notifications_controller
                                                                    FROM tb_mut_profilenotifications
                                                                      WHERE tb_mut_profilenotifications.n_codprofileto = $vCodProfile;");
                return $vResultNotifications->fetchAll();
                $vResultNotifications->close();
            } else {
                $vCodProfile = (int) $vCodProfile;
                $vState = (int) $vState;
                $vResultNotifications = $this->vDataBase->query("SELECT
                                                                        tb_mut_profilenotifications.*,
                                                                        (SELECT
                                                                              CONCAT(tb_mut_profiles.c_name,' ',tb_mut_profiles.c_lastname)
                                                                            FROM tb_mut_profiles
                                                                              WHERE tb_mut_profiles.n_codprofile = tb_mut_profilenotifications.n_codprofilefrom) AS c_profilenames,
                                                                        (SELECT
                                                                              tb_mut_notifications.c_notifications_desc
                                                                            FROM tb_mut_notifications
                                                                              WHERE tb_mut_notifications.n_codnotifications = tb_mut_profilenotifications.n_codnotification_in) AS c_notifications_desc,
                                                                        (SELECT
                                                                              tb_mut_notifications.c_notifications_controller
                                                                            FROM tb_mut_notifications
                                                                              WHERE tb_mut_notifications.n_codnotifications = tb_mut_profilenotifications.n_codnotification_in) AS c_notifications_controller                                                                              
                                                                    FROM tb_mut_profilenotifications
                                                                      WHERE tb_mut_profilenotifications.n_codprofileto = $vCodProfile
                                                                        AND tb_mut_profilenotifications.n_state = $vState;");
                return $vResultNotifications->fetchAll();
                $vResultNotifications->close();
            }
        }    
        /* END SELECT STATEMENT QUERY  */
    
        /* BEGIN INSERT STATEMENT QUERY  */
		public function notificationRegister($vCodeNotificationIN, $vCodeNotificationOUT, $vCodProfileFrom, $vCodProfileTo, $vCodWorkNotification, $vState, $vActive){
            
                $vCodeNotificationIN = (int) $vCodeNotificationIN;
                $vCodeNotificationOUT = (int) $vCodeNotificationOUT;
                $vCodProfileFrom = (int) $vCodProfileFrom;
                $vCodProfileTo = (int) $vCodProfileTo;
                $vCodWorkNotification = (int) $vCodWorkNotification;
                $vState = (int) $vState;
                $vActive = (int) $vActive;
            
                $vUserCreate = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
                $vDateCreate = date("Y-m-d H:i:s", time());

				$vResultNotificationRegister = $this->vDataBase->prepare("INSERT INTO tb_mut_profilenotifications(n_codnotification_in, n_codnotification_out, n_codprofilefrom, n_codprofileto, n_codworknotification, n_state, n_active, c_usercreate, d_datecreate)
																VALUES(:n_codnotification_in, :n_codnotification_out, :n_codprofilefrom, :n_codprofileto, :n_codworknotification, :n_state, :n_active, :c_usercreate, :d_datecreate)")
								->execute(
										array(
                                            ':n_codnotification_in' => $vCodeNotificationIN,
                                            ':n_codnotification_out' => $vCodeNotificationOUT,
                                            ':n_codprofilefrom' => $vCodProfileFrom,
                                            ':n_codprofileto' => $vCodProfileTo,
                                            ':n_codworknotification' => $vCodWorkNotification,
                                            ':n_state' => $vState,
                                            ':n_active' => $vActive,
                                            ':c_usercreate' => $vUserCreate,
                                            ':d_datecreate' => $vDateCreate,
										));
                return $vResultNotificationRegister = $this->vDataBase->lastInsertId();
                $vResultNotificationRegister->close();
			}
        /* END INSERT STATEMENT QUERY  */
        /* BEGIN UPDATE STATEMENT QUERY  */    
		public function updateNotificationState($vCodProfileNotification, $vState)
            {
                $vCodProfileNotification = (int) $vCodProfileNotification;
                $vState = (int) $vState;
            
                $vUserMod = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserEmail');
                $vDateMod = date("Y-m-d H:i:s", time());
            
                $vResultUpdateProfileName = $this->vDataBase->prepare("UPDATE
                                                                            tb_mut_profilenotifications
                                                                        SET tb_mut_profilenotifications.n_state = :n_state,
                                                                            tb_mut_profilenotifications.c_usermod = :c_usermod,
                                                                            tb_mut_profilenotifications.d_datemod = :d_datemod
                                                                        WHERE tb_mut_profilenotifications.n_codprofilenotification = :n_codprofilenotification;")
                                ->execute(
                                            array(
                                                ':n_state'=>$vState,
                                                ':c_usermod'=>$vUserMod,
                                                ':d_datemod'=>$vDateMod,
                                                ':n_codprofilenotification'=>$vCodProfileNotification
                                                 )
                                         );
                return $vResultUpdateProfileName;
                $vResultUpdateProfileName->close();
			}    
        /* END UPDATE STATEMENT QUERY  */    
    }
?>