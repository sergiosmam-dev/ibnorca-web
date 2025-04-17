<?php

class helpdeskModel extends IdEnModel
	{
		public function __construct(){
				parent::__construct();
			}
        
        /* BEGIN SELECT STATEMENT QUERY  */
		public function getTickets($vCodUser, $vWho)
			{
                $vCodUser = (int) $vCodUser;
                $vWho = (string) $vWho;
                if($vWho == 'from'){
                    $vResult = $this->vDataBase->query("SELECT
                                                                tb_ibnc_tickets.*,
                                                                (SELECT CONCAT(tb_ibnc_profiles.c_name,' ', tb_ibnc_profiles.c_lastname) FROM tb_ibnc_profiles WHERE tb_ibnc_profiles.n_coduser = tb_ibnc_tickets.n_coduserfrom) as name_userfrom,
                                                                (SELECT CONCAT(tb_ibnc_profiles.c_name,' ', tb_ibnc_profiles.c_lastname) FROM tb_ibnc_profiles WHERE tb_ibnc_profiles.n_coduser = tb_ibnc_tickets.n_coduserto) as name_userto
                                                            FROM tb_ibnc_tickets
                                                                WHERE n_coduserfrom = $vCodUser;");
                } else if('to'){
                    $vResult = $this->vDataBase->query("SELECT
                                                                tb_ibnc_tickets.*,
                                                                (SELECT CONCAT(tb_ibnc_profiles.c_name,' ', tb_ibnc_profiles.c_lastname) FROM tb_ibnc_profiles WHERE tb_ibnc_profiles.n_coduser = tb_ibnc_tickets.n_coduserfrom) as name_userfrom,
                                                                (SELECT CONCAT(tb_ibnc_profiles.c_name,' ', tb_ibnc_profiles.c_lastname) FROM tb_ibnc_profiles WHERE tb_ibnc_profiles.n_coduser = tb_ibnc_tickets.n_coduserto) as name_userto
                                                            FROM tb_ibnc_tickets
                                                                WHERE n_coduserto = $vCodUser;");
                } else if('all'){
                    $vResult = $this->vDataBase->query("SELECT
                                                                tb_ibnc_tickets.*,
                                                                (SELECT CONCAT(tb_ibnc_profiles.c_name,' ', tb_ibnc_profiles.c_lastname) FROM tb_ibnc_profiles WHERE tb_ibnc_profiles.n_coduser = tb_ibnc_tickets.n_coduserfrom) as name_userfrom,
                                                                (SELECT CONCAT(tb_ibnc_profiles.c_name,' ', tb_ibnc_profiles.c_lastname) FROM tb_ibnc_profiles WHERE tb_ibnc_profiles.n_coduser = tb_ibnc_tickets.n_coduserto) as name_userto
                                                            FROM tb_ibnc_tickets;");
                }
				return $vResult->fetchAll();
				$vResult->close();
			}
        public function getTicket($vNumTicket, $vCodUser)
			{
                $vNumTicket = (int) $vNumTicket;
                $vCodUser = (int) $vCodUser;

                $vResult = $this->vDataBase->query("SELECT
                                                        tb_ibnc_tickets.*,
                                                        (SELECT CONCAT(tb_ibnc_profiles.c_name,' ', tb_ibnc_profiles.c_lastname) FROM tb_ibnc_profiles WHERE tb_ibnc_profiles.n_coduser = tb_ibnc_tickets.n_coduserfrom) as name_userfrom,
                                                        (SELECT CONCAT(tb_ibnc_profiles.c_name,' ', tb_ibnc_profiles.c_lastname) FROM tb_ibnc_profiles WHERE tb_ibnc_profiles.n_coduser = tb_ibnc_tickets.n_coduserto) as name_userto
                                                    FROM tb_ibnc_tickets
                                                        WHERE n_numticket = $vNumTicket
                                                            AND n_coduserto = $vCodUser;");
				return $vResult->fetchAll();
				$vResult->close();
			}            
        /* END SELECT STATEMENT QUERY  */
    }
?>