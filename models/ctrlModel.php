<?php

class ctrlModel extends IdEnModel
	{
		public function __construct(){
				parent::__construct();
			}
        
        /* BEGIN SELECT STATEMENT QUERY  */
		public function getLastSession($vCodProfile,$vCodUser)
			{
                $vCodProfile = (int) $vCodProfile;
                $vCodUser = (int) $vCodUser;
            
				$vResultGetLastSession = $this->vDataBase->query("SELECT
                                                                        tb_ctrl_session.n_codctrlsession
                                                                    FROM tb_ctrl_session
                                                                        ORDER BY tb_ctrl_session.n_codctrlsession
                                                                            DESC LIMIT 1;");
				return $vResultGetLastSession->fetchColumn();
				$vResultGetLastSession->close();
			}
            public function getDataFromExcel()
			{            
				$vResultGetLastSession = $this->vDataBase->query("SELECT
                tb_mut_excel.*
                FROM tb_mut_excel
                WHERE tb_mut_excel.d NOT IN(SELECT tb_mut_purchases.n_numbillingpurchase FROM tb_mut_purchases);");
				return $vResultGetLastSession->fetchAll();
				$vResultGetLastSession->close();
			}
            public function getLineFromExcel($vCodPurchase, $vLetter)
			{
                $vCodPurchase = (int) $vCodPurchase;
                $vLetter = (string) $vLetter;
				$vResultLineFromExcel = $this->vDataBase->query("SELECT tb_mut_excel.* FROM tb_mut_excel WHERE tb_mut_excel.$vLetter = ".$vCodPurchase.";");
				return $vResultLineFromExcel->fetchAll();
				$vResultLineFromExcel->close();
			}             
        /* END SELECT STATEMENT QUERY  */
        
        /* BEGIN INSERT STATEMENT QUERY  */
		public function insertCtrlSession($vCodProfile, $vCodUser, $vStatus, $vSession, $vIPv4, $vMACAddress, $vOS, $vBrowser, $vHostName){
            
                $vCodProfile = (int) $vCodProfile;
                $vCodUser = (int) $vCodUser;
                $vStatus = (string) $vStatus;
                $vSession = (string) $vSession;
                $vIPv4 = (string) $vIPv4;
                $vMACAddress = (string) $vMACAddress;
                $vOS = (string) $vOS;
                $vBrowser = (string) $vBrowser;
                $vHostName = (string) $vHostName;
                $vDate = date("Y-m-d", time());
                $vTime = date("H:i:s", time());
				$vResultCtrlSession = $this->vDataBase->prepare("INSERT INTO tb_ctrl_session(n_codprofile, n_coduser, c_status, c_session, c_ipv4, c_mac, c_os, c_browser, c_hostname, d_date, t_time)
																VALUES(:n_codprofile, :n_coduser, :c_status, :c_session, :c_ipv4, :c_mac, :c_os, :c_browser, :c_hostname, :d_date, :t_time);")
								->execute(
										array(
                                            ':n_codprofile' => $vCodProfile,
                                            ':n_coduser' => $vCodUser,
                                            ':c_status' => $vStatus,
                                            ':c_session' => $vSession,
                                            ':c_ipv4' => $vIPv4,
                                            ':c_mac' => $vMACAddress,
                                            ':c_os' => $vOS,
                                            ':c_browser' => $vBrowser,
                                            ':c_hostname' => $vHostName,
                                            ':d_date' => $vDate,
                                            ':t_time' => $vTime
										));
                return $vResultCtrlSession = $this->vDataBase->lastInsertId();
                $vResultCtrlSession->close();
			}
            public function insertCtrlAction($vCodCtrlSession, $vCodProfile, $vCodUser, $vAction, $vController, $vMethod, $vDBAction, $vDataQuery){
            
                $vCodCtrlSession = (int) $vCodCtrlSession;
                $vCodProfile = (int) $vCodProfile;
                $vCodUser = (int) $vCodUser;
                $vAction = (string) $vAction;
                $vController = (string) $vController;
                $vMethod = (string) $vMethod;
                $vDBAction = (string) $vDBAction;
                $vDataQuery = (string) $vDataQuery;
                $vDate = date("Y-m-d", time());
                $vTime = date("H:i:s", time());
           
				$vResultCtrlAction = $this->vDataBase->prepare("INSERT INTO tb_ctrl_action(n_codctrlsession, n_codprofile, n_coduser, c_action, c_controller, c_method, c_dbaction, c_dataquery, d_date, t_time)
																VALUES(:n_codctrlsession, :n_codprofile, :n_coduser, :c_action, :c_controller, :c_method, :c_dbaction, :c_dataquery, :d_date, :t_time);")
								->execute(
										array(
                                            ':n_codctrlsession' => $vCodCtrlSession,
                                            ':n_codprofile' => $vCodProfile,
                                            ':n_coduser' => $vCodUser,
                                            ':c_action' => $vAction,
                                            ':c_controller' => $vController,
                                            ':c_method' => $vMethod,
                                            ':c_dbaction' => $vDBAction,
                                            ':c_dataquery' => $vDataQuery,
                                            ':d_date' => $vDate,
                                            ':t_time' => $vTime
										));
                return $vResultCtrlAction = $this->vDataBase->lastInsertId();
                $vResultCtrlAction->close();
			}
            public function insertLogAction($vAction, $vMethod){
            
                $vAction = (string) $vAction;
                $vMethod = (string) $vMethod;
                $vDate = date("Y-m-d", time());
                $vTime = date("H:i:s", time());
           
				$vResultCtrlAction = $this->vDataBase->prepare("INSERT INTO tb_log_actions(c_action, c_method, d_date, t_time)
																VALUES(:c_action, :c_method, :d_date, :t_time);")
								->execute(
										array(
                                            ':c_action' => $vAction,
                                            ':c_method' => $vMethod,
                                            ':d_date' => $vDate,
                                            ':t_time' => $vTime
										));
                return $vResultCtrlAction = $this->vDataBase->lastInsertId();
                $vResultCtrlAction->close();
			}                
        /* END INSERT STATEMENT QUERY  */    
    }
?>