<?Php

class systemController extends IdEnController
{
    public function __construct()
    {
        parent::__construct();

        /* BEGIN VALIDATION TIME SESSION USER */
        if (!IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE)) {
            $this->redirect('auth');
        } else {
            IdEnSession::timeSession();
        }
        /* END VALIDATION TIME SESSION USER */
        $this->vCtrl = $this->LoadModel('ctrl');
        $this->vMenuData = $this->LoadModel('menu');
        $this->vAccessData = $this->LoadModel('access');
        $this->vUsersData = $this->LoadModel('users');
        $this->vProfileData = $this->LoadModel('profile');
        $this->vPrivilegeData = $this->LoadModel('privilege');
        $this->vModuleData = $this->LoadModel('module');

        /**********************************/
        /* BEGIN AUTHENTICATE USER ACTIVE */
        /**********************************/
        $this->vCodProfileLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode');
        $this->vCodUserLogged = IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode');
        //$this->vView->vProfileImageNameLogged = 'directory_' . $this->vCodProfileLogged . '/' . $this->vProfileData->getProfileImage($this->vCodProfileLogged);
        $this->vView->vProfileNameLogged = ucwords($this->vProfileData->getNames($this->vCodProfileLogged) . ' ' . $this->vProfileData->getLastNames($this->vCodProfileLogged));
        $this->vView->vProfileNameLetters = substr($this->vProfileData->getNames($this->vCodProfileLogged), 0, 1) . substr($this->vProfileData->getLastNames($this->vCodProfileLogged), 0, 1);
        $this->vView->vProfileEmailLogged = $this->vUsersData->getUserEmail($this->vCodUserLogged);
        $this->vView->vProfileEmailValidation = $this->vUsersData->getAccountStatusUserCode($this->vCodUserLogged);
        /********************************/
        /* END AUTHENTICATE USER ACTIVE */
        /********************************/

        $this->vView->vControllerActive = 'system';
        $this->vView->vSubNavContent = '';

    }

    public function index()
    {
        $this->vView->vMethodActive = 'index';
        $this->vView->visualize('index');

    }

    /* BEGIN ACTUALIZACIÓN DE DATOS AUTOMATICO */
    /* END ACTUALIZACIÓN DE DATOS AUTOMATICO */

    public function menuReg()
    {

        $this->vView->vMenuLevelAndParent = $this->vMenuData->getMenuLevelAndParent();
        $this->vView->vListMenu = $this->vMenuData->getListMenu();
        $this->vView->vModuleData = $this->vModuleData->getModule();

        $this->vView->vMethodActive = 'menuReg';
        $this->vView->visualize('menuReg');

    }
    public function registerMenu()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vUserCode = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode');
            $vLevel1 = (int) $_POST['vLevel1'];
            $vLevel2 = (int) $_POST['vLevel2'];
            $vLevel3 = (int) $_POST['vLevel3'];
            $vLevel4 = (int) $_POST['vLevel4'];
            $vParentMenu = (int) $_POST['vParentMenu'];
            $vPositionMenu = (int) $_POST['vPositionMenu'];
            if ($_POST['vRoleMenu'] == 0)
            {
                $vRoleMenu = (string) $_POST['vControllerActive'];
            } else {
                $vRoleMenu = (string) $_POST['vRoleMenu'];
            }            
            $vIconMenu = (string) $_POST['vIconMenu'];
            $vNameMenu = (string) $_POST['vNameMenu'];
            $vDescMenu = (string) $_POST['vDescMenu'];
            $vControllerActive = (string) $_POST['vControllerActive'];
            $vMethodActive = (string) $_POST['vMethodActive'];
            $vURLMenu = (string) $_POST['vURLMenu'];
            $vSessionMenu = (int) $_POST['vSessionMenu'];
            $vActiveMenu = (int) $_POST['vActiveMenu'];

            $vInsertMenu = $this->vMenuData->insertMenu($vUserCode, $vLevel1, $vLevel2, $vLevel3, $vLevel4, $vParentMenu, $vPositionMenu, $vRoleMenu, $vIconMenu, $vNameMenu, $vDescMenu, $vControllerActive, $vMethodActive, $vURLMenu, $vSessionMenu, $vActiveMenu);

            if ($this->vMenuData->getMenuExists($vInsertMenu) == 1) {
                echo 'success';

                /* CONTROL USER ACTION */
                $this->vCtrl->insertCtrlAction($this->vCtrl->getLastSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode')), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode'), 'register', 'system', 'registerMenu', 'insertMenu', $vUserCode . ';' . $vLevel1 . ';' . $vLevel2 . ';' . $vLevel3 . ';' . $vLevel4 . ';' . $vParentMenu . ';' . $vPositionMenu . ';' . $vRoleMenu . ';' . $vIconMenu . ';' . $vNameMenu . ';' . $vDescMenu . ';' . $vControllerActive . ';' . $vMethodActive . ';' . $vURLMenu . ';' . $vSessionMenu . ';' . $vActiveMenu);
            } else {
                echo 'error';
            }

        }
    }
    public function menuList()
    {

        $this->vView->vMenuLevelAndParent = $this->vMenuData->getMenuLevelAndParent();
        $this->vView->vListMenu = $this->vMenuData->getListMenu();
        $this->vView->vMethodActive = 'menuList';
        $this->vView->visualize('menuList');

    }
    public function menuEdit($vCodMenu)
    {

        $vCodMenu = (int) $vCodMenu;

        $this->vView->vMenuLevelAndParent = $this->vMenuData->getMenuLevelAndParent();
        $this->vView->vDataItemMenu = $this->vMenuData->getDataItemMenu($vCodMenu);
        $this->vView->vModuleData = $this->vModuleData->getModule();

        $this->vView->vMethodActive = 'menuEdit';
        $this->vView->visualize('menuEdit');

    }
    public function menuDelete()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $vCodeMenu = (int) $_POST['vCodMenu'];
            if ($this->vMenuData->getMenuExists($vCodeMenu) == 1) {
                if ($this->vMenuData->getIfMenuIsParent($vCodeMenu) == 0) {

                    /* SELECT INFO FOR CONTROL USER ACTION */
                    $this->vDataItemMenu = $this->vMenuData->getDataItemMenu($vCodeMenu);
                    for ($i = 0; $i < count($this->vDataItemMenu); $i++):
                        $vDataQuery = $this->vDataItemMenu[$i]['n_codmenu'] . ';' .
                        $this->vDataItemMenu[$i]['n_level1'] . ';' .
                        $this->vDataItemMenu[$i]['n_level2'] . ';' .
                        $this->vDataItemMenu[$i]['n_level3'] . ';' .
                        $this->vDataItemMenu[$i]['n_level4'] . ';' .
                        $this->vDataItemMenu[$i]['n_parent'] . ';' .
                        $this->vDataItemMenu[$i]['c_menutype'] . ';' .
                        $this->vDataItemMenu[$i]['n_positionmenu'] . ';' .
                        $this->vDataItemMenu[$i]['c_iconmenu'] . ';' .
                        $this->vDataItemMenu[$i]['c_title'] . ';' .
                        $this->vDataItemMenu[$i]['c_descmenu'] . ';' .
                        $this->vDataItemMenu[$i]['c_controlleractive'] . ';' .
                        $this->vDataItemMenu[$i]['c_methodactive'] . ';' .
                        $this->vDataItemMenu[$i]['c_url'] . ';' .
                        $this->vDataItemMenu[$i]['n_codprofiletype'] . ';' .
                        $this->vDataItemMenu[$i]['n_active'] . ';' .
                        $this->vDataItemMenu[$i]['c_usercreate'] . ';' .
                        $this->vDataItemMenu[$i]['d_datecreate'] . ';' .
                        $this->vDataItemMenu[$i]['c_usermod'] . ';' .
                        $this->vDataItemMenu[$i]['d_datemod'];
                    endfor;
                    $this->vMenuData->deleteItemMenu($vCodeMenu);

                    /* CONTROL USER ACTION */
                    $this->vCtrl->insertCtrlAction($this->vCtrl->getLastSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode')), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode'), 'delete', 'system', 'menuDelete', 'deleteItemMenu', $vDataQuery);

                    echo 'success';
                } else {
                    echo 'parent';
                }
            } else {
                echo 'error';
            }
        }

    }

    public function privilegeReg()
    {

        $this->vView->vPrivilegeData = $this->vPrivilegeData->getPrivilege();

        $this->vView->vMethodActive = 'privilegeReg';
        $this->vView->visualize('privilegeReg');

    }
    public function privilegeRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vPrivilegeName = (string) $_POST['vPrivilegeName'];
            $vPrivilegeRole = (string) $_POST['vPrivilegeRole'];
            $vStatus = (int) 1;
            $vActive = (int) 1;

            $vCodPrivilege = $this->vPrivilegeData->insertPrivilege($vPrivilegeName, $vPrivilegeRole, $vStatus, $vActive);
            if ($this->vPrivilegeData->getPrivilegeExists($vCodPrivilege) == 1) {
                echo 'success-privilege';
                // CONTROL USER ACTION
                //$this->vCtrl->insertCtrlAction($this->vCtrl->getLastSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'),IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode')), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'), 'register', 'system', 'registerMenu', 'insertMenu', $vUserCode.';'.$vLevel1.';'.$vLevel2.';'.$vLevel3.';'.$vLevel4.';'.$vParentMenu.';'.$vPositionMenu.';'.$vRoleMenu.';'.$vIconMenu.';'.$vNameMenu.';'.$vDescMenu.';'.$vControllerActive.';'.$vMethodActive.';'.$vURLMenu.';'.$vSessionMenu.';'.$vActiveMenu);
            } else {
                echo 'error-privilege';
            }

        }
    }
    public function usersAssignModuleReg()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vCodUserToAssign = (int) $_POST['vCodUser'];
            $vModuleAssigned = (string) $_POST['vModuleAssigned'];
            $vModuleAssignedReplace = str_replace ("'", '', $vModuleAssigned);
            $vArrayModuleAssigned = explode(",", $vModuleAssignedReplace);
            //echo count($vArrayModuleAssigned);
            for($i=0;$i<count($vArrayModuleAssigned);$i++){
                $vCodMenuAssign = $this->vMenuData->getCodMenuFromName($vArrayModuleAssigned[$i]);
                if($this->vMenuData->getUserMenuAccess($vCodUserToAssign, $vCodMenuAssign, 1) == 0){
                    $this->vMenuData->insertMenuAccess($vCodMenuAssign, $vCodUserToAssign, 1, 1);
                }                
            }

            $vAssignModule = $this->vUsersData->updateModuleUser($vCodUserToAssign, $vModuleAssigned);
            if ($vAssignModule == 1) {
                echo 'success-assignmodule';
                // CONTROL USER ACTION
                //$this->vCtrl->insertCtrlAction($this->vCtrl->getLastSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'),IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode')), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'), 'register', 'system', 'registerMenu', 'insertMenu', $vUserCode.';'.$vLevel1.';'.$vLevel2.';'.$vLevel3.';'.$vLevel4.';'.$vParentMenu.';'.$vPositionMenu.';'.$vRoleMenu.';'.$vIconMenu.';'.$vNameMenu.';'.$vDescMenu.';'.$vControllerActive.';'.$vMethodActive.';'.$vURLMenu.';'.$vSessionMenu.';'.$vActiveMenu);
            } else {
                echo 'error-module';
            }

        }
    }
    public function updateMenu()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vUserCode = (int) IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'Code');
            $vCodMenu = (int) $_POST['vCodMenu'];
            $vLevel1 = (int) $_POST['vLevel1'];
            $vLevel2 = (int) $_POST['vLevel2'];
            $vLevel3 = (int) $_POST['vLevel3'];
            $vLevel4 = (int) $_POST['vLevel4'];
            $vParentMenu = (int) $_POST['vParentMenu'];
            $vPositionMenu = (int) $_POST['vPositionMenu'];
            $vRoleMenu = (string) $_POST['vRoleMenu'];
            $vIconMenu = (string) $_POST['vIconMenu'];
            $vNameMenu = (string) $_POST['vNameMenu'];
            $vDescMenu = (string) $_POST['vDescMenu'];
            $vControllerActive = (string) $_POST['vControllerActive'];
            $vMethodActive = (string) $_POST['vMethodActive'];
            $vURLMenu = (string) $_POST['vURLMenu'];
            $vSessionMenu = (int) $_POST['vSessionMenu'];
            $vActiveMenu = (int) $_POST['vActiveMenu'];

            $vUpdateMenu = $this->vMenuData->updateMenu($vCodMenu, $vUserCode, $vLevel1, $vLevel2, $vLevel3, $vLevel4, $vParentMenu, $vPositionMenu, $vRoleMenu, $vIconMenu, $vNameMenu, $vDescMenu, $vControllerActive, $vMethodActive, $vURLMenu, $vSessionMenu, $vActiveMenu);

            //echo $vRoleMenu.' '.$vCodMenu.' '.$vNameMenu.' '.$vControllerActive;
            $vUpdateModule = $this->vMenuData->updateModule($vCodMenu, $vNameMenu, $vRoleMenu);

            /* CONTROL USER ACTION */
            $this->vCtrl->insertCtrlAction($this->vCtrl->getLastSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode')), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode'), 'update', 'system', 'updateMenu', 'updateMenu', $vUserCode . ';' . $vCodMenu . ';' . $vLevel1 . ';' . $vLevel2 . ';' . $vLevel3 . ';' . $vLevel4 . ';' . $vParentMenu . ';' . $vPositionMenu . ';' . $vRoleMenu . ';' . $vIconMenu . ';' . $vNameMenu . ';' . $vDescMenu . ';' . $vControllerActive . ';' . $vMethodActive . ';' . $vURLMenu . ';' . $vSessionMenu . ';' . $vActiveMenu);

            echo 'success';
        }
    }
    public function users()
    {
        $this->vView->vMethodActive = 'users';
        $this->vView->visualize('users');

    }
    public function usersReg()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vNames = (string) strtolower($_POST['vNames']);
            $vLastNames = (string) strtolower($_POST['vLastNames']);
            $vEmail = (string) strtolower($_POST['vEmail']);
            $vRole = (string) strtolower($_POST['vRole']);
            $vStatus = (int) $_POST['vStatus'];
            $vActive = (int) $_POST['vActive'];

            if ($this->vUsersData->getUserEmailExists($vEmail) == 0) {
                $vPassword = $vRePassword = $vActivationcode = rand(1000000, 9999999);
                $vUserCode = $this->vUsersData->userRegister(0, $vEmail, $vPassword, $vRePassword, $vEmail, $vRole, $vActivationcode, $vStatus, $vActive);
                if ($vUserCode != 0) {
                    $vOthername = (string) $vEmail;
                    $vProfileName = (string) strtolower(str_replace(' ', '', $vNames) . str_replace(' ', '', $vLastNames));

                    if ($this->vProfileData->getProfileExists($vProfileName) == 1) {
                        $vProfileName = $vProfileName . rand(100, 999);
                    }

                    $vProfileType = 1;
                    $vProfileCode = $this->vProfileData->profileRegister($vUserCode, $vProfileName, $vNames, $vLastNames, $vProfileType, $vStatus, $vActive);
                    if ($vProfileCode != 0) {

                        /* BEGIN PRIVACY SETTINGS */
                        $this->vPrivacyData->inserPrivacyPersonal($vProfileCode, 1, 1, 1, 1, 1);
                        //$this->vPrivacyData->inserPrivacyLocation($vProfileCode, 1, 1, 1, 1, 1);
                        //$this->vPrivacyData->inserPrivacyProfession($vProfileCode, 1, 1, 1, 1);
                        //$this->vPrivacyData->inserPrivacyNotifications($vProfileCode, 1, 1, 1, 1, 1, 1);
                        /* END PRIVACY SETTINGS */

                        /*$vUserCode = $this->vProfileData->getCodUserFromCodProfile($vProfileCode);
                        $vProfileName = $this->vProfileData->getProfileNameFromCodProfile($vProfileCode);
                        $vUserEmail = $this->vUsersData->getUserEmail($vUserCode);
                        $vUserRole = $this->vUsersData->getUserRole($vUserCode);

                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE, true);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'UserCode', $vUserCode);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode', $vProfileCode);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'ProfileName', $vProfileName);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'Email', $vUserEmail);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'Role', $vUserRole);
                        IdEnSession::setSession(DEFAULT_USER_AUTHENTICATE.'TimeSession', time());*/

                        /* CONTROL USER SESSION */
                        $this->vCtrl->insertCtrlSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode'), 'Signin', session_id(), $this->getUserIP(), $this->getMAC(), $this->getOS(), $this->getBrowser(), $this->getComputerName());

                        /* CONTROL USER ACTION */
                        $this->vCtrl->insertCtrlAction($this->vCtrl->getLastSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode')), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode'), 'register', 'auth', 'RegisterMethod', 'userRegister', $vNames . ';' . $vLastNames . ';' . $vActivationcode . ';' . $vActivationcode . ';' . $vActive);

                        echo 'success-userreg';
                    } else {
                        echo 'error-profile';
                    }
                } else {
                    echo 'error-user';
                }
            } else {
                echo 'error-emailexists';
            }

            $vInsertMenu = $this->vMenuData->insertMenu($vUserCode, $vLevel1, $vLevel2, $vLevel3, $vLevel4, $vParentMenu, $vPositionMenu, $vRoleMenu, $vIconMenu, $vNameMenu, $vDescMenu, $vControllerActive, $vMethodActive, $vURLMenu, $vSessionMenu, $vActiveMenu);

            if ($this->vMenuData->getMenuExists($vInsertMenu) == 1) {
                echo 'success';
                /* CONTROL USER ACTION */
                $this->vCtrl->insertCtrlAction($this->vCtrl->getLastSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode')), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode'), 'register', 'system', 'registerMenu', 'insertMenu', $vUserCode . ';' . $vLevel1 . ';' . $vLevel2 . ';' . $vLevel3 . ';' . $vLevel4 . ';' . $vParentMenu . ';' . $vPositionMenu . ';' . $vRoleMenu . ';' . $vIconMenu . ';' . $vNameMenu . ';' . $vDescMenu . ';' . $vControllerActive . ';' . $vMethodActive . ';' . $vURLMenu . ';' . $vSessionMenu . ';' . $vActiveMenu);
            } else {
                echo 'error';
            }
        }
    }
    public function usersList()
    {
        $this->vView->vDataUsers = $this->vUsersData->getUsers();
        $this->vView->vMethodActive = 'userList';
        $this->vView->visualize('usersList');
    }
    public function usersEdit($vCodeUser)
    {
        $vCodeUser = (int) $vCodeUser;
        $this->vView->vDataUser = $this->vUsersData->getUser($vCodeUser);
        $this->vView->visualize('usersEdit');
    }
    public function usersModule($vCodeUser)
    {
        $vCodeUser = (int) $vCodeUser;
        $this->vView->vDataUser = $this->vUsersData->getUser($vCodeUser);
        $this->vView->vModuleData = $this->vModuleData->getModule();
        $this->vView->vMethodActive = 'usersEdit';
        $this->vView->visualize('usersModule');
    }
    public function updateUsers()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $vCodUser = (int) $_POST['vCodUser'];
            $vEmail = (string) strtolower($_POST['vEmail']);
            $vRole = (string) $_POST['vRole'];
            $vStatus = (int) $_POST['vStatus'];
            $vActive = (int) $_POST['vActive'];

            if ($this->vUsersData->getUserEmail($vCodUser) == $vEmail) {
                $this->vUsersData->updateUser($vCodUser, $vEmail, $vRole, $vStatus, $vActive);
                /* CONTROL USER ACTION */
                $this->vCtrl->insertCtrlAction($this->vCtrl->getLastSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode')), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode'), 'update', 'system', 'updateUsers', 'updateUser', $vCodUser . ';' . $vEmail . ';' . $vRole . ';' . $vStatus . ';' . $vActive);
                /* NOTIFICATION REGISTER */
                $this->vNotificationsData->notificationRegister(1, $this->vCodProfileLogged, $this->vProfileData->getProfileCodeFromUserCode($vCodUser), 1, 1);
                echo 'success-userupdate';
            } else {
                if ($this->vUsersData->getUserEmailExists($vEmail) == 0) {
                    $this->vUsersData->updateUser($vCodUser, $vEmail, $vRole, $vStatus, $vActive);
                    /* CONTROL USER ACTION */
                    $this->vCtrl->insertCtrlAction($this->vCtrl->getLastSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode')), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE . 'UserCode'), 'update', 'system', 'updateUsers', 'updateUser', $vCodUser . ';' . $vEmail . ';' . $vRole . ';' . $vStatus . ';' . $vActive);

                    echo 'success-userupdate';
                } else {
                    echo 'error-emailexists';
                }
            }
        }
    }
    public function moduleReg()
    {
        $this->vView->vMenuNotModuleData = $this->vMenuData->getMenuNotModule(1);
        $this->vView->vModuleData = $this->vModuleData->getModule();
        $this->vView->vMethodActive = 'moduleReg';
        $this->vView->visualize('moduleReg');
    }
    public function moduleRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $vCodeMenu = (int) $_POST['vCodeMenu'];
            $vModuleName = (string) $this->vMenuData->getMenuTitle($vCodeMenu);
            $vModuleRole = (string) $this->vMenuData->getMenuRole($vCodeMenu);
            $vStatus = (int) 1;
            $vActive = (int) 1;

            $vCodModule = $this->vModuleData->insertModule($vCodeMenu, $vModuleName, $vModuleRole, $vStatus, $vActive);
            if ($this->vModuleData->getModuleExists($vCodModule) == 1) {
                echo 'success-module';
                // CONTROL USER ACTION
                //$this->vCtrl->insertCtrlAction($this->vCtrl->getLastSession(IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'),IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode')), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'ProfileCode'), IdEnSession::getSession(DEFAULT_USER_AUTHENTICATE.'UserCode'), 'register', 'system', 'registerMenu', 'insertMenu', $vUserCode.';'.$vLevel1.';'.$vLevel2.';'.$vLevel3.';'.$vLevel4.';'.$vParentMenu.';'.$vPositionMenu.';'.$vRoleMenu.';'.$vIconMenu.';'.$vNameMenu.';'.$vDescMenu.';'.$vControllerActive.';'.$vMethodActive.';'.$vURLMenu.';'.$vSessionMenu.';'.$vActiveMenu);
            } else {
                echo 'error-module';
            }
        }
    }
    public function methods()
    {
        $this->vView->vModuleData = $this->vModuleData->getModule();
        $this->vView->vMethodActive = 'methods';
        $this->vView->visualize('methods');
    }
    public function methodManagement($vCodeMenu)
    {
        $vCodeMenu = (int) $vCodeMenu;
        $this->vView->vMethodsFromCodModuleData = $this->vModuleData->getMethodsFromCodModule($vCodeMenu);
        $this->vView->vMethodActive = 'methodManagement';
        $this->vView->visualize('methodManagement');
    }
    public function addMethodToModule($vCodeModule)
    {
        $vCodeModule = (int) $vCodeModule;
        $this->vView->vDataMethods = $this->vModuleData->getMethodsFromCodModule($vCodeModule);
        $this->vView->vMethodActive = 'methodReg';
        $this->vView->visualize('addMethod');
    }
    public function usersMethod($vCodMenu, $vCodeUser){
        $vCodMenu = (int) $vCodMenu;
        $vCodeUser = (int) $vCodeUser;
        $this->vView->vPrevCodMenu = $vCodMenu;
        $this->vView->vDataUser = $this->vUsersData->getUser($vCodeUser);
        $this->vView->vDataItemMenu = $this->vMenuData->getDataItemMenu($vCodMenu);
        $this->vView->vMenuLevelData = $this->vMenuData->getMenuAssigned($vCodMenu, $vCodeUser);
        $this->vView->vMethodActive = 'usersMethod';
        $this->vView->visualize('usersMethod');    
    }
    public function assignPrivilegeMethod($vCodMenu, $vCodeUser, $vCodMenuAssign){
        $vCodMenu = (int) $vCodMenu;
        $vCodeUser = (int) $vCodeUser;
        $vCodMenuAssign = (int) $vCodMenuAssign;
        if($this->vMenuData->getUserMenuAccess($vCodeUser, $vCodMenuAssign, 1) == 0){
            $this->vMenuData->insertMenuAccess($vCodMenuAssign, $vCodeUser, 1, 1);
        }
        $this->redirect('system/usersMethod/'.$vCodMenu.'/'.$vCodeUser);
    }
    public function unAssignPrivilegeMethod($vCodMenu, $vCodeUser, $vCodMenuAssign){
        $vCodMenu = (int) $vCodMenu;
        $vCodeUser = (int) $vCodeUser;
        $vCodMenuAssign = (int) $vCodMenuAssign;
        $this->vMenuData->getUserMenuAccess($vCodeUser, $vCodMenuAssign, 1);
        if($this->vMenuData->getUserMenuAccess($vCodeUser, $vCodMenuAssign, 1) == 1){
            $vCodeMenuAccess = $this->vMenuData->getCodeMenuAccess($vCodeUser, $vCodMenuAssign, 1);
            $this->vMenuData->deleteMenuAccess($vCodeMenuAccess);
        }        
        $this->redirect('system/usersMethod/'.$vCodMenu.'/'.$vCodeUser);
    }    
}
