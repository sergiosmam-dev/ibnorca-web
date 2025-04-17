<?php

abstract class IdEnController
	{
		protected $vView;
		
		public function __construct()
			{
				$this->vView = new IdEnView(new IdEnRequest);
			}
		
		abstract public function index();/* OBLIGA A TODAS LAS CLASES HEREDADAS DE LA MISMA IMPLEMENTEN UN METODO INDEX CON O SIN CODIGO */
		
		protected function LoadModel($vModel)
			{
				$vModel = $vModel.'Model';
				$vRouteModel = ROOT_APPLICATION.'models'.DIR_SEPARATOR.$vModel.'.php';
				
				if(is_readable($vRouteModel))
					{
						require_once $vRouteModel;
						$vModel = new $vModel;
						return $vModel;
					}
				else
					{
						throw new Exception($vModel.' - No Existe el Modelo!');
						exit;						
					}
			}
        
		protected function getLibrary($vLibrary)
			{
				$vRouteLibrary = ROOT_APPLICATION.'libs'.DIR_SEPARATOR.$vLibrary.'.php';
				
				if(is_readable($vRouteLibrary))
					{
						require_once $vRouteLibrary;
					}
				else
					{
						throw new Exception($vLibrary.' - No Existe la Libreria!');
					}
			}        
		
		protected function redirect($vRoute = FALSE)
			{
				if($vRoute)
					{
						header('Location:'.BASE_VIEW_URL.$vRoute);
						exit;								
					}
				else
					{
						header('Location:'.BASE_VIEW_URL);					
						exit;						
					}
			}
    
        /* BEGIN VALIDADORES EN FUNCIONES GLOBALES - PÚBLICAS */    
        public function isValidEmail($str){
          $matches = null;
          return (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $str, $matches));
        }
    
        public function isPasswordStrenght($password){   
            if(preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).*$/", $password)){
                echo true;  
            } else {
                echo false;                
            }
        }     
        /* END VALIDADORES EN FUNCIONES GLOBALES - PÚBLICAS */    
    
        /* BEGIN VALIDADORES EN FUNCIONES GLOBALES - PÚBLICAS */
        public function stringLength($vString){
            
                $vNumCharacters = 0;
                $vNumCharacters = strlen($vString);

                return $vNumCharacters;
            
            }
    
        public function userNameValid($vString){
                
                if(ereg('^[a-zA-Z0-9]{3,20}$', $vString)){
                    //echo "El nombre de usuario $nombre_usuario es correcto<br>";
                    return true;
                } else {
                    //echo "El nombre de usuario $nombre_usuario no es válido<br>";
                    return false;
                } 
            
            }    
    
        /* END VALIDADORES EN FUNCIONES GLOBALES - PÚBLICAS */    
    
        /* BEGIN GLOBAL FUNCTIONS */
        public function stringInverted($vStringNormal){
            $vStringNormal = (string) $vStringNormal;
            $vStringInverted = '';
            
            for ($i=strlen($vStringNormal); $i >= 0; $i--){
              $vStringInverted .= $vStringNormal[$i];
            }
            
            return $vStringInverted;
        }
    
        public function separateDigitsAndAddNumber($vNumberToSeparate, $vNumberToAdd){
            $vNumberToSeparate = (string) $vNumberToSeparate;
            $vNumberToAdd = (float) $vNumberToAdd;
            
            $x = (string) $vNumberToSeparate;
            
            $vNewVal[] = '';

            for($i = 0;$i < strlen($x); $i++){ 
                $vNewVal[$i] = $x[$i] + $vNumberToAdd;
                
            }
            
            return $vNewVal;

        }
    
        public function roundNumber($vNumber){
            
            $vNumber = str_replace(',','.',$vNumber);
            $vNumber = explode('.',$vNumber);
            //print_r($vNumber);
             //round($vNumber);
            
            if(count($vNumber) == 1){
                $vNumber = $vNumber[0];
            } elseif(count($vNumber) == 2){
                    $vDecimales = (int) $vNumber[1];
                    if(strlen($vDecimales) == 1){
                        if($vDecimales >= 5){
                            //echo $vDecimales.' es mayor que 5';
                            $vNumber = $vNumber[0]+1;
                        } else {
                            //echo $vDecimales.' es menor que 5';
                            $vNumber = $vNumber[0];
                        }                
                    } else if(strlen($vDecimales) == 2){
                        if($vDecimales >= 50){
                            //echo $vDecimales.' es mayor que 50';
                            $vNumber = $vNumber[0]+1;
                        } else {
                            //echo $vDecimales.' es menor que 50';
                            $vNumber = $vNumber[0];
                        }                
                    }
                //exit;
            } else if(count($vNumber) == 3){
                    $vDecimales = (int) $vNumber[2];
                    if(strlen($vDecimales) == 1){
                        if($vDecimales >= 5){
                            //echo $vDecimales.' es mayor que 5';
                            $vNumber = ($vNumber[0].$vNumber[1])+1;
                        } else {
                            //echo $vDecimales.' es menor que 5';
                            $vNumber = $vNumber[0].$vNumber[1];
                        }                
                    } else if(strlen($vDecimales) == 2){
                        if($vDecimales >= 50){
                            //echo $vDecimales.' es mayor que 50';
                            $vNumber = ($vNumber[0].$vNumber[1])+1;
                        } else {
                            //echo $vDecimales.' es menor que 50';
                            $vNumber = $vNumber[0].$vNumber[1];
                        }                
                    }                
                }

            return $vNumber;
            
        }

        public function validateNumber($value){
            if(!preg_match('/^[0-9,.]+$/', $value)){
                throw new InvalidArgumentException(sprintf("Error! Valor restringido a número, %s no es un número.",$value));
            }
        }

        public function validateDosageKey($value){
            if(!preg_match('/^[A-Za-z0-9=#()*+-_\@\[\]{}%$]+$/', $value)){
                throw new InvalidArgumentException(sprintf("Error! llave de dosificación,<b> %s </b>contiene caracteres NO permitidos.",$value));
            }
        }
    
        public function compararCadenas($vString1, $vString2){        
            $vString1 = (string) $vString1;
            $vString2 = (string) $vString2;

            if(strcmp($vString1, $vString2) == 0){
                return 'son iguales';
            } else {
                return 'no son iguales';
            }            
        }
    
        public function formatControlCodeInvoice($vString){
            
            $vStringLength = strlen($vString);
            $vTimesSeparate = $vStringLength/2;
            $vCount = 0;
            $vLoop = 2;
            $vControlCodeInvoice = '';
            
            while($vCount < $vStringLength){
                    $vControlCodeInvoice .= substr($vString, $vCount, $vLoop).'-';
                    $vCount = $vCount + $vLoop;
                }
            return substr($vControlCodeInvoice, 0, strlen($vControlCodeInvoice)-1);
        }

        public function numtowords($num){
            $f = new NumberFormatter('es', NumberFormatter::SPELLOUT);
            return $f->format($num);            
        }
    
        public function num2letras($num, $fem = false, $dec = true) { 
           $matuni[2]  = "dos"; 
           $matuni[3]  = "tres"; 
           $matuni[4]  = "cuatro"; 
           $matuni[5]  = "cinco"; 
           $matuni[6]  = "seis"; 
           $matuni[7]  = "siete"; 
           $matuni[8]  = "ocho"; 
           $matuni[9]  = "nueve"; 
           $matuni[10] = "diez"; 
           $matuni[11] = "once"; 
           $matuni[12] = "doce"; 
           $matuni[13] = "trece"; 
           $matuni[14] = "catorce"; 
           $matuni[15] = "quince"; 
           $matuni[16] = "dieciseis"; 
           $matuni[17] = "diecisiete"; 
           $matuni[18] = "dieciocho"; 
           $matuni[19] = "diecinueve"; 
           $matuni[20] = "veinte"; 
           $matunisub[2] = "dos"; 
           $matunisub[3] = "tres"; 
           $matunisub[4] = "cuatro"; 
           $matunisub[5] = "quin"; 
           $matunisub[6] = "seis"; 
           $matunisub[7] = "sete"; 
           $matunisub[8] = "ocho"; 
           $matunisub[9] = "nove"; 

           $matdec[2] = "veint"; 
           $matdec[3] = "treinta"; 
           $matdec[4] = "cuarenta"; 
           $matdec[5] = "cincuenta"; 
           $matdec[6] = "sesenta"; 
           $matdec[7] = "setenta"; 
           $matdec[8] = "ochenta"; 
           $matdec[9] = "noventa"; 
           $matsub[3]  = 'mill'; 
           $matsub[5]  = 'bill'; 
           $matsub[7]  = 'mill'; 
           $matsub[9]  = 'trill'; 
           $matsub[11] = 'mill'; 
           $matsub[13] = 'bill'; 
           $matsub[15] = 'mill'; 
           $matmil[4]  = 'millones'; 
           $matmil[6]  = 'billones'; 
           $matmil[7]  = 'de billones'; 
           $matmil[8]  = 'millones de billones'; 
           $matmil[10] = 'trillones'; 
           $matmil[11] = 'de trillones'; 
           $matmil[12] = 'millones de trillones'; 
           $matmil[13] = 'de trillones'; 
           $matmil[14] = 'billones de trillones'; 
           $matmil[15] = 'de billones de trillones'; 
           $matmil[16] = 'millones de billones de trillones'; 

           //Zi hack
           $float=explode('.',$num);
           $num=$float[0];

           $num = trim((string)@$num); 
           if ($num[0] == '-') { 
              $neg = 'menos '; 
              $num = substr($num, 1); 
           }else 
              $neg = ''; 
           while ($num[0] == '0') $num = substr($num, 1); 
           if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
           $zeros = true; 
           $punt = false; 
           $ent = ''; 
           $fra = ''; 
           for ($c = 0; $c < strlen($num); $c++) { 
              $n = $num[$c]; 
              if (! (strpos(".,'''", $n) === false)) { 
                 if ($punt) break; 
                 else{ 
                    $punt = true; 
                    continue; 
                 } 

              }elseif (! (strpos('0123456789', $n) === false)) { 
                 if ($punt) { 
                    if ($n != '0') $zeros = false; 
                    $fra .= $n; 
                 }else 

                    $ent .= $n; 
              }else 

                 break; 

           } 
           $ent = '     ' . $ent; 
           if ($dec and $fra and ! $zeros) { 
              $fin = ' coma'; 
              for ($n = 0; $n < strlen($fra); $n++) { 
                 if (($s = $fra[$n]) == '0') 
                    $fin .= ' cero'; 
                 elseif ($s == '1') 
                    $fin .= $fem ? ' una' : ' un'; 
                 else 
                    $fin .= ' ' . $matuni[$s]; 
              } 
           }else 
              $fin = ''; 
           if ((int)$ent === 0) return 'Cero ' . $fin; 
           $tex = ''; 
           $sub = 0; 
           $mils = 0; 
           $neutro = false; 
           while ( ($num = substr($ent, -3)) != '   ') { 
              $ent = substr($ent, 0, -3); 
              if (++$sub < 3 and $fem) { 
                 $matuni[1] = 'una'; 
                 $subcent = 'os'; 
              }else{ 
                 $matuni[1] = $neutro ? 'un' : 'uno'; 
                 $subcent = 'os'; 
              } 
              $t = ''; 
              $n2 = substr($num, 1); 
              if ($n2 == '00') { 
              }elseif ($n2 < 21) 
                 $t = ' ' . $matuni[(int)$n2]; 
              elseif ($n2 < 30) { 
                 $n3 = $num[2]; 
                 if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
                 $n2 = $num[1]; 
                 $t = ' ' . $matdec[$n2] . $t; 
              }else{ 
                 $n3 = $num[2]; 
                 if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
                 $n2 = $num[1]; 
                 $t = ' ' . $matdec[$n2] . $t; 
              } 
              $n = $num[0]; 
              if ($n == 1) { 
                 $t = ' ciento' . $t; 
              }elseif ($n == 5){ 
                 $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
              }elseif ($n != 0){ 
                 $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
              } 
              if ($sub == 1) { 
              }elseif (! isset($matsub[$sub])) { 
                 if ($num == 1) { 
                    $t = ' mil'; 
                 }elseif ($num > 1){ 
                    $t .= ' mil'; 
                 } 
              }elseif ($num == 1) { 
                 $t .= ' ' . $matsub[$sub] . '?n'; 
              }elseif ($num > 1){ 
                 $t .= ' ' . $matsub[$sub] . 'ones'; 
              }   
              if ($num == '000') $mils ++; 
              elseif ($mils != 0) { 
                 if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
                 $mils = 0; 
              } 
              $neutro = true; 
              $tex = $t . $tex; 
              
              
           } 
           $tex = $neg . substr($tex, 1) . $fin;
           
           //Zi hack --> return ucfirst($tex);
           $end_num=ucfirst($tex).' bolivianos '.$float[1].'/100 BOLIVIANOS';
           return $end_num; 
        }     
    

        public function spanishLiteralDate($fecha) {
            $fecha = substr($fecha, 0, 10);
            
            $numeroDia = date('d', strtotime($fecha));
            
            $dia = date('l', strtotime($fecha));
            $mes = date('F', strtotime($fecha));
            $anio = date('Y', strtotime($fecha));
            
            $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
            $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
            $nombredia = str_replace($dias_EN, $dias_ES, $dia);
            
            $meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
            $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
            
            $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
            
            return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
        }

        public function dateDiff($vDateIni, $vDateEnd) {

            $dias = (strtotime($vDateIni)-strtotime($vDateEnd))/86400;
            $dias = abs($dias); $dias = floor($dias);
            
            return $dias;
        }        
    
		public function cutLongText($texto, $limite=100)
			{   				
				$texto = trim($texto);
				$texto = strip_tags($texto);
				$tamano = strlen($texto);
				$resultado = '';
				if($tamano <= $limite){
					return $texto;
				}else{
					$texto = substr($texto, 0, $limite);
					$palabras = explode(' ', $texto);
					$resultado = implode(' ', $palabras);
					$resultado .= '...';
				}   
				return $resultado;
			}
    
		public function NotificationDays($vNotificationDate)
			{   				
                $vDayNotification = date('d', strtotime($vNotificationDate));
                $vDayNow = date('d');

                if($vDayNow == $vDayNotification):
                    $vNotificationTime = 'Hoy';
                elseif($vDayNow > $vDayNotification):
                    $vDays = $vDayNow - $vDayNotification;
                    if($vDays == 1):
                        $vNotificationTime = $vDays.' día';
                    elseif($vDays > 1):
                        $vNotificationTime = $vDays.' días';
                    endif;
                endif;
            
				return $vNotificationTime;
			}
    
        function cleanCharacterString($string){

            $string = trim($string);

            $string = str_replace(
                array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
                array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
                $string
            );

            $string = str_replace(
                array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
                array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
                $string
            );

            $string = str_replace(
                array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
                array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
                $string
            );

            $string = str_replace(
                array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
                array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
                $string
            );

            $string = str_replace(
                array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
                array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
                $string
            );

            $string = str_replace(
                array('ñ', 'Ñ', 'ç', 'Ç'),
                array('n', 'N', 'c', 'C',),
                $string
            );

            return $string;
        }
        function replace_spaces($string){

            $string = trim($string);

            $string = str_replace(' ','-',$string);

            return $string;
        }    
        /* END GLOBAL FUNCTIONS */
    
        function getUserIP(){
            // Get real visitor IP behind CloudFlare network
            if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
                      $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
                      $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            }
            $client  = @$_SERVER['HTTP_CLIENT_IP'];
            $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
            $remote  = $_SERVER['REMOTE_ADDR'];

            if(filter_var($client, FILTER_VALIDATE_IP))
            {
                $ip = $client;
            }
            elseif(filter_var($forward, FILTER_VALIDATE_IP))
            {
                $ip = $forward;
            }
            else
            {
                $ip = $remote;
            }

            return $ip;
        }    

    function getBrowser(){
            $arr_browsers = ["Opera", "Edg", "Chrome", "Safari", "Firefox", "MSIE", "Trident"];
            $user_browser = '';
            foreach ($arr_browsers as $browser) {
                    if (strpos($_SERVER['HTTP_USER_AGENT'], $browser) !== false) {
                        $user_browser = $browser;
                        break;
                    }   
                }
            /*switch ($user_browser) {
                case 'MSIE':
                    $user_browser = 'Internet Explorer';
                    break;

                case 'Trident':
                    $user_browser = 'Internet Explorer';
                    break;

                case 'Edg':
                    $user_browser = 'Microsoft Edge';
                    break;
            } */
            return $user_browser;
        }
    
    function getMAC(){
            //$var = explode(' ',exec('getmac'));
            //return $var[0];
            //$mac='UNKNOWN';
            //foreach(explode("\n",str_replace(' ','',trim(`getmac`,"\n"))) as $i)
            //if(strpos($i,'Tcpip')>-1){$mac=substr($i,0,17);break;}
            //return $mac;            
            return 'php8_not_working_exec()';
        }
    
    function getComputerName(){
            return gethostname();
        }
    
    function getOS($user_agent = null){
            if(!isset($user_agent) && isset($_SERVER['HTTP_USER_AGENT'])) {
                $user_agent = $_SERVER['HTTP_USER_AGENT'];
            }

            // https://stackoverflow.com/questions/18070154/get-operating-system-info-with-php
            $os_array = [
                'windows nt 10'                              =>  'Windows 10',
                'windows nt 6.3'                             =>  'Windows 8.1',
                'windows nt 6.2'                             =>  'Windows 8',
                'windows nt 6.1|windows nt 7.0'              =>  'Windows 7',
                'windows nt 6.0'                             =>  'Windows Vista',
                'windows nt 5.2'                             =>  'Windows Server 2003/XP x64',
                'windows nt 5.1'                             =>  'Windows XP',
                'windows xp'                                 =>  'Windows XP',
                'windows nt 5.0|windows nt5.1|windows 2000'  =>  'Windows 2000',
                'windows me'                                 =>  'Windows ME',
                'windows nt 4.0|winnt4.0'                    =>  'Windows NT',
                'windows ce'                                 =>  'Windows CE',
                'windows 98|win98'                           =>  'Windows 98',
                'windows 95|win95'                           =>  'Windows 95',
                'win16'                                      =>  'Windows 3.11',
                'mac os x 10.1[^0-9]'                        =>  'Mac OS X Puma',
                'macintosh|mac os x'                         =>  'Mac OS X',
                'mac_powerpc'                                =>  'Mac OS 9',
                'linux'                                      =>  'Linux',
                'ubuntu'                                     =>  'Linux - Ubuntu',
                'iphone'                                     =>  'iPhone',
                'ipod'                                       =>  'iPod',
                'ipad'                                       =>  'iPad',
                'android'                                    =>  'Android',
                'blackberry'                                 =>  'BlackBerry',
                'webos'                                      =>  'Mobile',

                '(media center pc).([0-9]{1,2}\.[0-9]{1,2})'=>'Windows Media Center',
                '(win)([0-9]{1,2}\.[0-9x]{1,2})'=>'Windows',
                '(win)([0-9]{2})'=>'Windows',
                '(windows)([0-9x]{2})'=>'Windows',

                // Doesn't seem like these are necessary...not totally sure though..
                //'(winnt)([0-9]{1,2}\.[0-9]{1,2}){0,1}'=>'Windows NT',
                //'(windows nt)(([0-9]{1,2}\.[0-9]{1,2}){0,1})'=>'Windows NT', // fix by bg

                'Win 9x 4.90'=>'Windows ME',
                '(windows)([0-9]{1,2}\.[0-9]{1,2})'=>'Windows',
                'win32'=>'Windows',
                '(java)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})'=>'Java',
                '(Solaris)([0-9]{1,2}\.[0-9x]{1,2}){0,1}'=>'Solaris',
                'dos x86'=>'DOS',
                'Mac OS X'=>'Mac OS X',
                'Mac_PowerPC'=>'Macintosh PowerPC',
                '(mac|Macintosh)'=>'Mac OS',
                '(sunos)([0-9]{1,2}\.[0-9]{1,2}){0,1}'=>'SunOS',
                '(beos)([0-9]{1,2}\.[0-9]{1,2}){0,1}'=>'BeOS',
                '(risc os)([0-9]{1,2}\.[0-9]{1,2})'=>'RISC OS',
                'unix'=>'Unix',
                'os/2'=>'OS/2',
                'freebsd'=>'FreeBSD',
                'openbsd'=>'OpenBSD',
                'netbsd'=>'NetBSD',
                'irix'=>'IRIX',
                'plan9'=>'Plan9',
                'osf'=>'OSF',
                'aix'=>'AIX',
                'GNU Hurd'=>'GNU Hurd',
                '(fedora)'=>'Linux - Fedora',
                '(kubuntu)'=>'Linux - Kubuntu',
                '(ubuntu)'=>'Linux - Ubuntu',
                '(debian)'=>'Linux - Debian',
                '(CentOS)'=>'Linux - CentOS',
                '(Mandriva).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)'=>'Linux - Mandriva',
                '(SUSE).([0-9]{1,3}(\.[0-9]{1,3})?(\.[0-9]{1,3})?)'=>'Linux - SUSE',
                '(Dropline)'=>'Linux - Slackware (Dropline GNOME)',
                '(ASPLinux)'=>'Linux - ASPLinux',
                '(Red Hat)'=>'Linux - Red Hat',
                // Loads of Linux machines will be detected as unix.
                // Actually, all of the linux machines I've checked have the 'X11' in the User Agent.
                //'X11'=>'Unix',
                '(linux)'=>'Linux',
                '(amigaos)([0-9]{1,2}\.[0-9]{1,2})'=>'AmigaOS',
                'amiga-aweb'=>'AmigaOS',
                'amiga'=>'Amiga',
                'AvantGo'=>'PalmOS',
                //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1}-([0-9]{1,2}) i([0-9]{1})86){1}'=>'Linux',
                //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1} i([0-9]{1}86)){1}'=>'Linux',
                //'(Linux)([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}(rel\.[0-9]{1,2}){0,1})'=>'Linux',
                '[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,3}'=>'Linux',
                '(webtv)/([0-9]{1,2}\.[0-9]{1,2})'=>'WebTV',
                'Dreamcast'=>'Dreamcast OS',
                'GetRight'=>'Windows',
                'go!zilla'=>'Windows',
                'gozilla'=>'Windows',
                'gulliver'=>'Windows',
                'ia archiver'=>'Windows',
                'NetPositive'=>'Windows',
                'mass downloader'=>'Windows',
                'microsoft'=>'Windows',
                'offline explorer'=>'Windows',
                'teleport'=>'Windows',
                'web downloader'=>'Windows',
                'webcapture'=>'Windows',
                'webcollage'=>'Windows',
                'webcopier'=>'Windows',
                'webstripper'=>'Windows',
                'webzip'=>'Windows',
                'wget'=>'Windows',
                'Java'=>'Unknown',
                'flashget'=>'Windows',

                // delete next line if the script show not the right OS
                //'(PHP)/([0-9]{1,2}.[0-9]{1,2})'=>'PHP',
                'MS FrontPage'=>'Windows',
                '(msproxy)/([0-9]{1,2}.[0-9]{1,2})'=>'Windows',
                '(msie)([0-9]{1,2}.[0-9]{1,2})'=>'Windows',
                'libwww-perl'=>'Unix',
                'UP.Browser'=>'Windows CE',
                'NetAnts'=>'Windows',
            ];

            // https://github.com/ahmad-sa3d/php-useragent/blob/master/core/user_agent.php
            $arch_regex = '/\b(x86_64|x86-64|Win64|WOW64|x64|ia64|amd64|ppc64|sparc64|IRIX64)\b/ix';
            $arch = preg_match($arch_regex, $user_agent) ? '64' : '32';

            foreach ($os_array as $regex => $value) {
                if (preg_match('{\b('.$regex.')\b}i', $user_agent)) {
                    return $value.' x'.$arch;
                }
            }

            return 'Unknown';
        }
    
    
    /***/
    
    
    
        public function menuIdEnFramework(){
                /* LOAD MODEL MENU*/
                $this->vMenuData = $this->LoadModel('menu');
                $this->vUsersData = $this->LoadModel('users');
                $this->vUserRole = $this->vUsersData->getUserRole(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'));
                /* BEGIN GENERATE MENU */            
                $this->vMenuLevel1 = $this->vMenuData->getPrivilegeMenuIdEn(1, 0, $this->vUserRole); 

                $vMenuOpen = '';
                $vMenuHere = '';
                
                if(isset($this->vMenuLevel1) && count($this->vMenuLevel1)):
                    $vDataQuery = '';
                    for($i=0;$i<count($this->vMenuLevel1);$i++):
                        
                        $this->vMenuLevel2 = $this->vMenuData->getPrivilegeMenuIdEn(2, $this->vMenuLevel1[$i]['n_codmenu'], $this->vUserRole);

                        if($this->vControllerActive == $this->vMenuLevel1[$i]['c_controlleractive']):
                            $vMenuOpen = ' menu-item-open ';
                            $vMenuHere = ' menu-item-here ';
                        else:
                            $vMenuOpen = '';
                            $vMenuHere = '';
                        endif;
                
                
                        if(count($this->vMenuLevel2) >= 1):
                        $vDataQuery = $vDataQuery.'<li class="menu-item menu-item-submenu '.$vMenuOpen.' '.$vMenuHere.' " aria-haspopup="true" data-menu-toggle="hover">
                                        <a href="javascript:;" class="menu-link menu-toggle">
                                        '.$this->vMenuLevel1[$i]['c_iconmenu'].'
                                            <span class="menu-text">'.ucwords($this->vMenuLevel1[$i]['c_title']).'</span>
                                            <i class="menu-arrow"></i>
                                        </a>
                                        <div class="menu-submenu">
                                            <i class="menu-arrow"></i>
                                            <ul class="menu-subnav">
                                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                                    <span class="menu-link">
                                                        <span class="menu-text">'.ucwords($this->vMenuLevel1[$i]['c_title']).'</span>
                                                    </span>
                                                </li>';
                                                for($j=0;$j<count($this->vMenuLevel2);$j++):
                                                    $this->vMenuLevel3 = $this->vMenuData->getPrivilegeMenuIdEn(3, $this->vMenuLevel2[$j]['n_codmenu'], $this->vUserRole);
                
                                                    if(count($this->vMenuLevel3) >= 1):
                                                    $vDataQuery = $vDataQuery.'<li class="menu-item menu-item-submenu '.$vMenuOpen.' '.$vMenuHere.' " aria-haspopup="true" data-menu-toggle="hover">
                                                                <a href="javascript:;" class="menu-link menu-toggle">
                                                                    '.$this->vMenuLevel2[$j]['c_iconmenu'].'
                                                                    <span class="menu-text">'.ucwords($this->vMenuLevel2[$j]['c_title']).'</span>
                                                                    <i class="menu-arrow"></i>
                                                                </a>
                                                                <div class="menu-submenu">
                                                                    <i class="menu-arrow"></i>
                                                                    <ul class="menu-subnav">';
                                                                        for($k=0;$k<count($this->vMenuLevel3);$k++):
                                                                            $this->vMenuLevel4 = $this->vMenuData->getPrivilegeMenuIdEn(4, $this->vMenuLevel3[$k]['n_codmenu'], $this->vUserRole);
                
                                                                            if($this->vMethodActive == $this->vMenuLevel3[$k]['c_methodactive']):
                                                                                $vMenu3Open = ' menu-item-open ';
                                                                                $vMenu3Here = ' menu-item-here ';
                                                                            else:
                                                                                $vMenu3Open = '';
                                                                                $vMenu3Here = '';
                                                                            endif;
                
                                                                            if(count($this->vMenuLevel4) >= 1):
                                                                                $vDataQuery = $vDataQuery.'<li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                                                                                    <a href="javascript:;" class="menu-link menu-toggle">
                                                                                        '.$this->vMenuLevel3[$k]['c_iconmenu'].'
                                                                                        <!--<i class="menu-bullet menu-bullet-dot">
                                                                                            <span></span>
                                                                                        </i>-->
                                                                                        <span class="menu-text">'.ucwords($this->vMenuLevel3[$k]['c_title']).'</span>
                                                                                        <!--<span class="menu-label">
                                                                                            <span class="label label-inline label-info">ok</span>
                                                                                        </span>-->
                                                                                        <i class="menu-arrow"></i>
                                                                                    </a>
                                                                                    <div class="menu-submenu">
                                                                                        <i class="menu-arrow"></i>
                                                                                        <ul class="menu-subnav">';
                                                                                        for($m=0;$m<count($this->vMenuLevel4);$m++):
                                                                                            $vDataQuery = $vDataQuery.'<li class="menu-item" aria-haspopup="true">
                                                                                                <a href="'.BASE_VIEW_URL.$this->vMenuLevel4[$m]['c_url'].'" class="menu-link">
                                                                                                    '.$this->vMenuLevel4[$m]['c_iconmenu'].'
                                                                                                    <!--<i class="menu-bullet menu-bullet-dot">
                                                                                                        <span></span>
                                                                                                    </i>-->
                                                                                                    <span class="menu-text">'.ucwords($this->vMenuLevel4[$m]['c_title']).'</span>
                                                                                                </a>
                                                                                            </li>';
                                                                                        endfor;            
                                                                                $vDataQuery = $vDataQuery.'
                                                                                        </ul>
                                                                                    </div>                                                                                
                                                                                </li>';            
                                                                            else:
                                                                                $vDataQuery = $vDataQuery.'<li class="menu-item menu-item-submenu '.$vMenu3Open.' '.$vMenu3Here.'" aria-haspopup="true" data-menu-toggle="hover">
                                                                                    <a href="'.BASE_VIEW_URL.$this->vMenuLevel3[$k]['c_url'].'" class="menu-link menu-toggle">
                                                                                        '.$this->vMenuLevel3[$k]['c_iconmenu'].'
                                                                                        <!--<i class="menu-bullet menu-bullet-dot">
                                                                                            <span></span>
                                                                                        </i>-->
                                                                                        <span class="menu-text">'.ucwords($this->vMenuLevel3[$k]['c_title']).'</span>
                                                                                        <!--<span class="menu-label">
                                                                                            <span class="label label-inline label-info">ok</span>
                                                                                        </span>-->
                                                                                    </a>
                                                                                </li>';            
                                                                            endif;
                                                                        endfor;
                                                                    $vDataQuery = $vDataQuery.'       
                                                                    </ul>
                                                                </div>                                                            
                                                            </li>';
                                                    else:
                                                    $vDataQuery = $vDataQuery.'<li class="menu-item" aria-haspopup="true">
                                                            <a href="'.BASE_VIEW_URL.$this->vMenuLevel2[$j]['c_url'].'" class="menu-link">
                                                                '.$this->vMenuLevel2[$j]['c_iconmenu'].'
                                                                <span class="menu-text">'.ucwords($this->vMenuLevel2[$j]['c_title']).'</span>
                                                            </a>
                                                        </li>';            
                                                    endif;
                                                endfor;          
                                            $vDataQuery = $vDataQuery.'                                        
                                            </ul>
                                        </div>                                    
                                    </li>';                                    
                        else:
                        $vDataQuery = $vDataQuery.'<li class="menu-item '.$vMenuOpen.' '.$vMenuHere.' " aria-haspopup="true">
                            <a href="'.BASE_VIEW_URL.$this->vMenuLevel1[$i]['c_url'].'" class="menu-link">
                                '.$this->vMenuLevel1[$i]['c_iconmenu'].'
                                <span class="menu-text">'.ucwords($this->vMenuLevel1[$i]['c_title']).'</span>
                            </a>
                        </li>';            
                        endif;
                        $vMenuOpen = '';
                        $vMenuHere = '';

                    endfor;
                    
                    return $vDataQuery;
                else:
                    echo '<div class="alert alert-custom alert-notice alert-light-danger fade show" role="alert">
                            <div class="alert-icon"><i class="flaticon-warning"></i></div>
                            <div class="alert-text">El usuario <b>NO</b> tiene privilegios de menú</div>
                            <div class="alert-close">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="ki ki-close"></i></span>
                                </button>
                            </div>
                        </div>';                    
                endif;
        }

    public function menuSubNavContent(){
        return $vSubNavContent = '';
    }

    public function menuPlatForm2023(){
            /* LOAD MODEL MENU*/
            $this->vMenuData = $this->LoadModel('menu');
            $this->vUsersData = $this->LoadModel('users');
            $this->vUserCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode');
            $this->vUserRole = $this->vUsersData->getUserRole(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'));
            /* BEGIN GENERATE MENU */            
            $this->vMenuLevel1 = $this->vMenuData->getPrivilegeMenuIdEn(1, 0, $this->vUserRole);

            if(isset($this->vMenuLevel1) && count($this->vMenuLevel1)){
                $vDataQuery = '';
                for($i=0;$i<count($this->vMenuLevel1);$i++):
                    $this->vMenuLevel2 = $this->vMenuData->getPrivilegeMenuIdEn(2, $this->vMenuLevel1[$i]['n_codmenu'], $this->vUserRole);
                    if(($this->vMenuData->getUserMenuAccess($this->vUserCode, $this->vMenuLevel1[$i]['n_codmenu'], 1) == 1) || ($this->vUserCode == 1)){
                        if(count($this->vMenuLevel2) >= 1){
                            $vDataQuery = $vDataQuery.'<!--begin:Menu item-->
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">'.$this->vMenuLevel1[$i]['c_iconmenu'].'</span>                            
                                    <span class="menu-title">'.ucwords($this->vMenuLevel1[$i]['c_title']).'</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">';
                                for($j=0;$j<count($this->vMenuLevel2);$j++):
                                    $this->vMenuLevel3 = $this->vMenuData->getPrivilegeMenuIdEn(3, $this->vMenuLevel2[$j]['n_codmenu'], $this->vUserRole);
                                    if(($this->vMenuData->getUserMenuAccess($this->vUserCode, $this->vMenuLevel2[$j]['n_codmenu'], 1) == 1) || ($this->vUserCode == 1)){
                                        if(count($this->vMenuLevel3) >= 1):
                                            $vDataQuery = $vDataQuery.'
                                            <!--begin:Menu item-->
                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                                <!--begin:Menu link-->
                                                <span class="menu-link">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">'.ucwords($this->vMenuLevel2[$j]['c_title']).'</span>
                                                    <span class="menu-arrow"></span>
                                                </span>
                                                <!--end:Menu link-->
                                                <!--begin:Menu sub-->
                                                <div class="menu-sub menu-sub-accordion menu-active-bg">';
                                                for($k=0;$k<count($this->vMenuLevel3);$k++):
                                                    $this->vMenuLevel4 = $this->vMenuData->getPrivilegeMenuIdEn(4, $this->vMenuLevel3[$k]['n_codmenu'], $this->vUserRole);
                                                    if(($this->vMenuData->getUserMenuAccess($this->vUserCode, $this->vMenuLevel3[$k]['n_codmenu'], 1) == 1) || ($this->vUserCode == 1)){
                                                        if(count($this->vMenuLevel4) >= 1):
                                                            $vDataQuery = $vDataQuery.'
                                                            <!--begin:Menu item-->
                                                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                                                <!--begin:Menu link-->
                                                                <span class="menu-link">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">'.ucwords($this->vMenuLevel2[$j]['c_title']).'</span>
                                                                    <span class="menu-arrow"></span>
                                                                </span>
                                                                <!--end:Menu link-->
                                                                <!--begin:Menu sub-->
                                                                <div class="menu-sub menu-sub-accordion menu-active-bg">';
                                                                for($m=0;$m<count($this->vMenuLevel4);$m++):
                                                                    $vDataQuery = $vDataQuery.'<!--begin:Menu item-->
                                                                    <div class="menu-item">
                                                                        <!--begin:Menu link-->
                                                                        <a class="menu-link" href="'.BASE_VIEW_URL.$this->vMenuLevel4[$m]['c_url'].'">
                                                                            <span class="menu-bullet">
                                                                                <span class="bullet bullet-dot"></span>
                                                                            </span>
                                                                            <span class="menu-title">'.ucwords($this->vMenuLevel4[$m]['c_title']).'</span>
                                                                        </a>
                                                                        <!--end:Menu link-->
                                                                    </div>
                                                                    <!--end:Menu item-->';
                                                                endfor;
                                                            $vDataQuery = $vDataQuery.'
                                                                </div>
                                                            </div>';                                                
                                                        else:
                                                            $vDataQuery = $vDataQuery.'
                                                            <!--begin:Menu item-->
                                                            <div class="menu-item">
                                                                <!--begin:Menu link-->
                                                                <a class="menu-link" href="'.BASE_VIEW_URL.$this->vMenuLevel3[$k]['c_url'].'">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">'.ucwords($this->vMenuLevel3[$k]['c_title']).'</span>
                                                                </a>
                                                                <!--end:Menu link-->
                                                            </div>
                                                            <!--end:Menu item-->';                                                
                                                        endif;                                                        
                                                    }
                                                endfor;
                                                $vDataQuery = $vDataQuery.'
                                                </div>
                                                <!--end:Menu sub-->
                                            </div>
                                            <!--end:Menu item-->';
                                        else:
                                            $vDataQuery = $vDataQuery.'<!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link" href="'.BASE_VIEW_URL.$this->vMenuLevel2[$j]['c_url'].'">
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">'.ucwords($this->vMenuLevel2[$j]['c_title']).'</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->';
                                        endif;
                                    }
                                endfor;
                            $vDataQuery = $vDataQuery.'
                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <!--end:Menu item-->';
                        } else {
                            $vDataQuery = $vDataQuery.'
                            <div class="menu-item">
                                <a class="menu-link" href="'.BASE_VIEW_URL.$this->vMenuLevel1[$i]['c_url'].'">
                                    <span class="menu-icon">'.$this->vMenuLevel1[$i]['c_iconmenu'].'</span>
                                    <span class="menu-title">'.ucwords($this->vMenuLevel1[$i]['c_title']).'</span>
                                </a>
                            </div>';
                        }
                    }
                endfor;
                return $vDataQuery;
            }
            /*if(isset($this->vMenuLevel1) && count($this->vMenuLevel1)):
                $vDataQuery = '';
                for($i=0;$i<count($this->vMenuLevel1);$i++):
                    $this->vMenuLevel2 = $this->vMenuData->getPrivilegeMenuIdEn(2, $this->vMenuLevel1[$i]['n_codmenu'], $this->vUserRole);
                        if(count($this->vMenuLevel2) >= 1):
                            $vDataQuery = $vDataQuery.'<!--begin:Menu item-->
                            <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                <!--begin:Menu link-->
                                <span class="menu-link">
                                    <span class="menu-icon">'.$this->vMenuLevel1[$i]['c_iconmenu'].'</span>                            
                                    <span class="menu-title">'.ucwords($this->vMenuLevel1[$i]['c_title']).'</span>
                                    <span class="menu-arrow"></span>
                                </span>
                                <!--end:Menu link-->
                                <!--begin:Menu sub-->
                                <div class="menu-sub menu-sub-accordion">';
                                for($j=0;$j<count($this->vMenuLevel2);$j++):
                                    $this->vMenuLevel3 = $this->vMenuData->getPrivilegeMenuIdEn(3, $this->vMenuLevel2[$j]['n_codmenu'], $this->vUserRole);
                                    if(count($this->vMenuLevel3) >= 1):
                                        $vDataQuery = $vDataQuery.'
                                        <!--begin:Menu item-->
                                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                            <!--begin:Menu link-->
                                            <span class="menu-link">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">'.ucwords($this->vMenuLevel2[$j]['c_title']).'</span>
                                                <span class="menu-arrow"></span>
                                            </span>
                                            <!--end:Menu link-->
                                            <!--begin:Menu sub-->
                                            <div class="menu-sub menu-sub-accordion menu-active-bg">';
                                            for($k=0;$k<count($this->vMenuLevel3);$k++):
                                                $this->vMenuLevel4 = $this->vMenuData->getPrivilegeMenuIdEn(4, $this->vMenuLevel3[$k]['n_codmenu'], $this->vUserRole);
                                                if(count($this->vMenuLevel4) >= 1):
                                                    $vDataQuery = $vDataQuery.'
                                                    <!--begin:Menu item-->
                                                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                                        <!--begin:Menu link-->
                                                        <span class="menu-link">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">'.ucwords($this->vMenuLevel2[$j]['c_title']).'</span>
                                                            <span class="menu-arrow"></span>
                                                        </span>
                                                        <!--end:Menu link-->
                                                        <!--begin:Menu sub-->
                                                        <div class="menu-sub menu-sub-accordion menu-active-bg">';
                                                        for($m=0;$m<count($this->vMenuLevel4);$m++):
                                                            $vDataQuery = $vDataQuery.'<!--begin:Menu item-->
                                                            <div class="menu-item">
                                                                <!--begin:Menu link-->
                                                                <a class="menu-link" href="'.BASE_VIEW_URL.$this->vMenuLevel4[$m]['c_url'].'">
                                                                    <span class="menu-bullet">
                                                                        <span class="bullet bullet-dot"></span>
                                                                    </span>
                                                                    <span class="menu-title">'.ucwords($this->vMenuLevel4[$m]['c_title']).'</span>
                                                                </a>
                                                                <!--end:Menu link-->
                                                            </div>
                                                            <!--end:Menu item-->';
                                                        endfor;
                                                    $vDataQuery = $vDataQuery.'
                                                        </div>
                                                    </div>';                                                
                                                else:
                                                    $vDataQuery = $vDataQuery.'
                                                    <!--begin:Menu item-->
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <a class="menu-link" href="'.BASE_VIEW_URL.$this->vMenuLevel3[$k]['c_url'].'">
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">'.ucwords($this->vMenuLevel3[$k]['c_title']).'</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <!--end:Menu item-->';                                                
                                                endif;
                                            endfor;
                                            $vDataQuery = $vDataQuery.'
                                            </div>
                                            <!--end:Menu sub-->
                                        </div>
                                        <!--end:Menu item-->';
                                    else:
                                        $vDataQuery = $vDataQuery.'<!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link" href="'.BASE_VIEW_URL.$this->vMenuLevel2[$j]['c_url'].'">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">'.ucwords($this->vMenuLevel2[$j]['c_title']).'</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->';
                                    endif;
                                endfor;
                            $vDataQuery = $vDataQuery.'
                                </div>
                                <!--end:Menu sub-->
                            </div>
                            <!--end:Menu item-->';
                        else:
                            $vDataQuery = $vDataQuery.'<!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link" href="'.BASE_VIEW_URL.$this->vMenuLevel1[$i]['c_url'].'">
                                    <span class="menu-icon">'.$this->vMenuLevel1[$i]['c_iconmenu'].'</span>
                                    <span class="menu-title">'.ucwords($this->vMenuLevel1[$i]['c_title']).'</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->';
                        endif;                            
                endfor;
                return $vDataQuery;
            endif;*/

    }        
    
    function getRandomBillingCode($vCodActivity){
            $this->vCtrl = $this->LoadModel('ctrl');
            /* RANDOM CODE */
            $vCodActivity = (int) $vCodActivity;
            //$uniqid = uniqid();
            //$rand_start = rand(1,10);
            //$rand_8_char = substr($uniqid,$rand_start,8);
            $vRandomCode = $this->vCtrl->getLastSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'),IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'));

            return $vRandomBillingCode = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode').IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode').$vCodActivity.$vRandomCode.date('Ymd').date('ga');
            //date('gia') hora, minutos, am/pm
        }
        
        public function todayDate(){
            $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");

            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            
            return $dias[date('w')]." ".date('d').", ".$meses[date('n')-1]." ".date('Y');
                    
        }

        public function monthDate($vMonth){

            $vMonth = (int) $vMonth;

            $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
            
            return $meses[$vMonth-1];   
        }
        
        public function chartofaccountList(){
            $this->vFinancesData = $this->LoadModel('finances');
            $this->vChartOfAccountLevel1 = $this->vFinancesData->getChartOfAccount(1, 1, 0);
            if(isset($this->vChartOfAccountLevel1) && count($this->vChartOfAccountLevel1)):
                for($i=0;$i<count($this->vChartOfAccountLevel1);$i++):
                    $vDataChartOfAccountList = $vDataChartOfAccountList.'<li>'.ucwords($this->vChartOfAccountLevel1[$i]['c_chartofaccount_name']);
                        $this->vChartOfAccountLevel2 = $this->vFinancesData->getChartOfAccount(2, 1, $this->vChartOfAccountLevel1[$i]['n_codchartofaccountlevel1']);
                        if(isset($this->vChartOfAccountLevel2) && count($this->vChartOfAccountLevel2)):
                            $vDataChartOfAccountList = $vDataChartOfAccountList.'<ul>';
                                for($j=0;$j<count($this->vChartOfAccountLevel2);$j++):
                                    $vDataChartOfAccountList = $vDataChartOfAccountList.'<li>'.ucwords($this->vChartOfAccountLevel2[$j]['c_chartofaccount_name']);
                                    $this->vChartOfAccountLevel3 = $this->vFinancesData->getChartOfAccount(3, 2, $this->vChartOfAccountLevel2[$j]['n_codchartofaccountlevel2']);
                                    if(isset($this->vChartOfAccountLevel3) && count($this->vChartOfAccountLevel3)):
                                        $vDataChartOfAccountList = $vDataChartOfAccountList.'<ul>';
                                        for($k=0;$k<count($this->vChartOfAccountLevel3);$k++):
                                            $vDataChartOfAccountList = $vDataChartOfAccountList.'<li>'.ucwords($this->vChartOfAccountLevel3[$k]['c_chartofaccount_name']);
                                            $this->vChartOfAccountLevel4 = $this->vFinancesData->getChartOfAccount(4, 3, $this->vChartOfAccountLevel3[$k]['n_codchartofaccountlevel3']);
                                            if(isset($this->vChartOfAccountLevel4) && count($this->vChartOfAccountLevel4)):
                                                $vDataChartOfAccountList = $vDataChartOfAccountList.'<ul>';
                                                for($l=0;$l<count($this->vChartOfAccountLevel4);$l++):
                                                    $vDataChartOfAccountList = $vDataChartOfAccountList.'<li>'.ucwords($this->vChartOfAccountLevel4[$l]['c_chartofaccount_name']);
                                                    $this->vChartOfAccountLevel5 = $this->vFinancesData->getChartOfAccount(5, 4, $this->vChartOfAccountLevel4[$l]['n_codchartofaccountlevel4']);
                                                    if(isset($this->vChartOfAccountLevel5) && count($this->vChartOfAccountLevel5)):
                                                        $vDataChartOfAccountList = $vDataChartOfAccountList.'<ul>';
                                                        for($s=0;$s<count($this->vChartOfAccountLevel5);$s++):
                                                            $vDataChartOfAccountList = $vDataChartOfAccountList.'<li>'.ucwords($this->vChartOfAccountLevel5[$s]['c_chartofaccount_name']);
                                                            $vDataChartOfAccountList = $vDataChartOfAccountList.'</li>';
                                                        endfor;
                                                        $vDataChartOfAccountList = $vDataChartOfAccountList.'</ul>';
                                                    else:
                                                        $vDataChartOfAccountList = $vDataChartOfAccountList.'</li>';
                                                    endif;
                                                endfor;
                                                $vDataChartOfAccountList = $vDataChartOfAccountList.'</ul>';
                                            else:
                                                $vDataChartOfAccountList = $vDataChartOfAccountList.'</li>';
                                            endif;
                                        endfor;
                                        $vDataChartOfAccountList = $vDataChartOfAccountList.'</ul>';
                                    else:
                                        $vDataChartOfAccountList = $vDataChartOfAccountList.'</li>';
                                    endif;
                                    /*echo '<li data-jstree="{"selected" : true }"><a href="javascript:;">Initially selected</a></li>
                                            <li data-jstree="{"icon" : "flaticon2-gear text-success"}">custom icon URL</li>
                                            <li data-jstree="{"opened" : true }">initially open
                                                <ul>
                                                    <li data-jstree="{ "disabled" : true }">Disabled Node</li>
                                                    <li data-jstree="{ "type" : "file" }">Another node</li>
                                                </ul>
                                            </li>';
                                    echo '<li data-jstree="{ "icon" : "flaticon2-rectangular text-danger" }">Custom icon class (bootstrap)</li>';*/
                                endfor;
                                $vDataChartOfAccountList = $vDataChartOfAccountList.'</ul>';
                        else:
                            $vDataChartOfAccountList = $vDataChartOfAccountList.'</li>'; 
                        endif;
                endfor;
            endif;
            
            return $vDataChartOfAccountList;
        }
        
        function eliminar_acentos($cadena){
		
            //Reemplazamos la A y a
            $cadena = str_replace(
            array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
            array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
            $cadena
            );
    
            //Reemplazamos la E y e
            $cadena = str_replace(
            array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
            array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
            $cadena );
    
            //Reemplazamos la I y i
            $cadena = str_replace(
            array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
            array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
            $cadena );
    
            //Reemplazamos la O y o
            $cadena = str_replace(
            array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
            array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
            $cadena );
    
            //Reemplazamos la U y u
            $cadena = str_replace(
            array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
            array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
            $cadena );
    
            //Reemplazamos la N, n, C y c
            $cadena = str_replace(
            array('Ñ', 'ñ', 'Ç', 'ç'),
            array('N', 'n', 'C', 'c'),
            $cadena
            );
            
            return $cadena;
        }
        
        function getCountSubCommiteees($vNumeroComite){
            
            $this->vAPIIbnorcaData = $this->LoadModel('apiibnorca');
            
            $vNumeroComite = (string) $vNumeroComite;

            $vNumSubCommitee = $this->vAPIIbnorcaData->getIbnorcaSubCommitees($vNumeroComite.'.');

            return $vNumSubCommitee;
        }

        function getDataSubCommiteees($vNumeroComite){
            
            $this->vAPIIbnorcaData = $this->LoadModel('apiibnorca');
            
            $vNumeroComite = (string) $vNumeroComite;

            $vNumSubCommitee = $this->vAPIIbnorcaData->getIbnorcaDataSubCommitees($vNumeroComite.'.');

            return $vNumSubCommitee;
        }

        function quitarEspacios($vString)
        {
            $vString = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $vString);
            return $vString;
        }

        function changeSpecialCharacters($vString)
        {
            $vString = preg_replace('/[^a-zA-Z0-9\']/', ' ', $vString);
            return $vString;
        }        
	}

?>
