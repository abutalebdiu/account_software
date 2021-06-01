<?php
use App\Model\Backend\Admin\UserRoleManagement\User_role_menu_action_permition;
use App\Model\Backend\Admin\UserRoleManagement\User_role_menu_title_permition;
use App\Model\Backend\Admin\UserRoleManagement\User_role_module_action_permition;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Model\Backend\Admin\UserRoleManagement\User_role_menu_title;
use App\Model\Backend\Admin\UserRoleManagement\Role;


/*===========================================Route Setting==================================*/
    /*=============Route web.php file=============*/
        /*=========URL========*/
    define('o','role-menu-title-permition');
        /*=========URL========*/


        /*==========Route=========*/
    define('l','role-menu-title-permition');
        /*===========Route===========*/
    /*=============Route web.php file=============*/
/*===========================================Route Setting==================================*/


    /**
     *Permission power
     *permission_power
     *in the users table.. for extra
    */
    /**use this in the User_role_menu_title model and others */
    define('user_permission_power_maximum_HP',1);
    define('user_permission_power_minimum_HP',0);
    /**use this in the User_role_menu_title model and others */
    function maximumAccessPermission_HP()
    {
        if(Auth::user()->email == 'moinulibr@gmail.com' || Auth::user()->permission_power ==  user_permission_power_maximum_HP)
        {
            return true;
        }else{
            return false;
        }
    }


    /*========Controller================= */

    /*========Controller================= */



            define('menuModuleTypeMenu','Menu');//1//menu_module_type
            define('menuModuleTypeModule','Module');//2//menu_module_type
            define('menuModuleTypeMenuAndModule','Menu & Module');//3//menu_module_type

            // whereIn array
            define('menuModuleTypeArray',[2,3]);
            define('menuOnlyTypeArray',[1,3]);

           //UserRoleMenuActionController ,,, UserRoleMenuActionPermitionController
           function createAndEditModuleActionModuleList_HP()
           {
               return  User_role_menu_title::whereIn('menu_module_type',menuModuleTypeArray)
                            ->whereNull('is_deleted')
                            ->get();
           }

           //UserRoleMenuActionController ,,, UserRoleMenuActionPermitionController
           function createAndEditMenuTitlePermissionList_HP()
           {
               return  User_role_menu_title::whereIn('menu_module_type',menuOnlyTypeArray)
                            ->whereNull('is_deleted')
                            ->get();
           }

           //UserRoleMenuActionController ,,, UserRoleMenuActionPermitionController
           function createAndEditRoleList_HP()
           {
               //specail permission
               if(maximumAccessPermission_HP())
               {
                        return  Role::whereNull('is_deleted')
                        ->get();
               }else{
                    return  Role::where('created_by',Auth::user()->id)
                                ->whereNull('is_deleted')
                                ->get();
               }
           }


            //UserRoleMenuActionController ,,, UserRoleMenuActionPermitionController
            function createdAndEditedRoleList_HP()
            {
                //specail permission
                if(maximumAccessPermission_HP())
                {
                     return  Role::whereNull('is_deleted')
                     ->get();
                }else{
                     return  Role::where('created_by',Auth::user()->id)
                            ->whereNull('is_deleted')
                            ->get();
                }
            }



/*
|-----------------------------------------------------------------------------------|
| Label in the blade file                                                           |
| only User Role and Permission and its relavent blade file                         |
|                                                                                   |
|-----------------------------------------------------------------------------------|
*/

    /**Menu Label */
    define('parentMenuNavbarPermissionLabel_HP','Menu Permission');

    define('parentMenuNavbarLabel_HP','Add Parent Menu');
    define('parentMenuNavbarMenuModuleActionLabel_HP','Add Module/Menu Action');


    define('parentMenuLabel_HP','Parent Menu (Title)');
    define('parentMenuCheckerLabel_HP','Parent Menu Checker');
    define('parentMenuSubmitLabel_HP','Menu');

    define('parentMenuViewTableLabel_HP','Parent Menu (Title)');
    //========Parent Menu Title==============
    define('parentMenuAssignedPermissionList_HP','Parent Menu (Title) Assigned Parmission List');
    define('parentMenuPermissionCreate_HP','Parent Menu (Title) Parmission Create');
    define('parentMenuPermissionUpdate_HP','Parent Menu (Title) Parmission Update');

    define('parentMenuList_HP','Parent Menu (Title) List');

    //==== Menu/Module Action======
    define('menuModuleRouteURLActionIndex_HP','Menu/Module Route/URL Action List');
    define('menuModuleRouteURLActionName_HP','Action Name');
    define('menuModuleRouteURLActionChecker_HP','Action Checker');
    define('menuModuleTitleName_HP','Menu/Module Name');
    //route/url
    define('menuModuleCreateAction_HP','Menu/Module Action');

    //create page
    define('menuModuleRouteURLActionCreateTitle_HP','Menu/Module Route/URL Action');
    define('menuModuleRouteURLActionCreateSubmit_HP','Menu/Module Action');
    //back to url index
    define('menuModuleRouteURLActionIndexToList_HP','Menu/Module List');

     //==== Menu/Module Permission======
    define('menuModuleRouteURLActionPermissionList_HP','Module (Menu) Permission List');
    define('menuModuleRouteURLPermissionCreate_HP','Module (Menu) Permission Create');
    define('menuModuleRouteURLActionPermissionAssignedList_HP','Module (Menu) Permission Assigned List');
    define('menuModuleRouteURLAssignedPermissionUpdate_HP','Module (Menu) Permission Update');
/*
|-----------------------------------------------------------------------------------|
| Label in the blade file                                                           |
| only User Role and Permission and its relavent blade file                         |
|                                                                                   |
|-----------------------------------------------------------------------------------|
*/




    // developer or another user login email and user role another healper menu show
    function userRoleShowHealperMenu_HP()
    {
        $userAccessEmail1 = 'moinulibr@gmail.com';
        $userAccessEmail2 = 'abutaleb@gmail.com';
        if(Auth::user()->email == $userAccessEmail1 || Auth::user()->email == $userAccessEmail2)
        {
            return true;
        }else{
            return  false;
        }
    }

//access_permission
/*
|-----------------------------------------------------------------------------------|
| Index Page Action Permition Check Start                                           |
| Always call this ACTION_BUTTON_CHECK_PERMITION  method in the blade file          |
| like === ACTION_BUTTON_CHECK_PERMITION("view")==                                  |
|-----------------------------------------------------------------------------------|
*/


    $loginEmail = "moinulibr@gmail.com";
    define("developerLogin", $loginEmail);
    $actionLinkable = "menu";#"button";"menu";
    define("menuEnableType", $actionLinkable);


/*
|--------------------------------------------------------------------------------------------------------|
| Nav Bar menu checker and route checker with middleware,, its uses like,,                               |
| ==MENU_CHECK_PERMITION(Route::currentRouteName());==                                                   |
|--------------------------------------------------------------------------------------------------------|
*/
    function routeUrlActionPermission()
    {
        return User_role_menu_action_permition::with('menuAction')
                    ->where('role_id',Auth::user()->role_id)
                    ->where('is_active',1)
                    ->whereNull('is_deleted')
                    ->get();
    }

    function routeUrlPermissionCheckFromMiddleware_HP($checker) #with route with middleware
    {
        $value= 0 ;
        if(count(routeUrlActionPermission())>0)
        {
            foreach(routeUrlActionPermission() as $per)
            {
                if($checker == $per->menuAction->action_checker_route_or_url)
                {
                    $value = 1;
                    break;
                }
            }
        }
        if(AUth::user()->email ==  developerLogin || AUth::user()->permission_power == user_permission_power_maximum_HP)
        {
            $value = 1;
        }else{
            $value = $value;
        }
        return $value;
    }
    /*
        use Illuminate\Support\Facades\Route;
        if(MENU_CHECK_PERMITION(Route::currentRouteName()) || MENU_CHECK_PERMITION($request->path()))
        {
            return true;
        }else{
            return redirect()->back()->with('error','You are not permitted to access this');
        }
    */

/*
|----------------------------------------------------------------------------------------------------------------------|
|------------------------Nav Bar menu checker and route checker with middleware End -----------------------------------|
|----------------------------------------------------------------------------------------------------------------------|
*/




#===========================================================================================================================|
# All route_url_list and Route/Url also Check By Middleware Start == Call Like == route_url_list_in_array()['accounts']['view']
#================================================================================================================
    function route_url_list_in_array()
    {
        $route_url_list = [];
        $route_url_list = [

                    'users' =>
                        [
                            "view"      => "users.view",
                            "create"    => "users.add",
                            "store"     => "users.stor",
                            "edit"      => "users.edit",
                            "update"    => "users.update",
                            "show"      => "users.show",
                            "delete"    => "users.delete",

                            "up_view"    => "up.users.view",
                            "up_show"    => "up.users.show",
                            "up_destroy"    => "up.users.destroy",
                            "up_approved"    => "up.users.approved"
                        ],
                    'profiles' =>
                        [
                            "view"      => "profiles.view",
                            "create"    => "profiles.add",
                            "store"     => "profiles.stor",
                            "edit"      => "profiles.edit",
                            "update"    => "profiles.update",
                            "show"      => "profiles.show",
                            "edit_password"      => "profiles.edit.password",
                            "update_password"      => "profiles.update.password",
                            "delete"    => "profiles.delete"
                        ],

                    'divisions' =>
                        [
                            "view"      => "division.index",
                        ],
                    'districts' =>
                        [
                            "view"      => "district.index",
                        ],
                    'thanas' =>
                        [
                            "d_view"      => "district.index",

                            "view"      => "thana.index",
                            "create"    => "thana.create",
                            "store"     => "thana.store",
                            "edit"      => "thana.edit",
                            "update"    => "thana.update",
                            "show"      => "thana.show",
                            "delete"    => "thana.destroy"
                        ],
                    'unions' =>
                        [
                            "view"      => "union.index",
                            "create"    => "union.create",
                            "store"     => "union.store",
                            "edit"      => "union.edit",
                            "update"    => "thana.update",
                            "show"      => "union.show",
                            "delete"    => "union.destroy"
                        ],

                    'user_roles' =>
                        [
                            "view"      => "admin.user-role.index",
                            "create"    => "admin.user-role.create",
                            "store"     => "admin.user-role.store",
                            "edit"      => "admin.user-role.edit",
                            "update"    => "admin.user-role.update",
                            "show"      => "admin.user-role.show",
                            "delete"    => "admin.user-role.delete"
                        ],

                    'menu_title_permissions' =>
                        [
                            "view"      => "admin.role-menu-title-permition.index",
                            "create"    => "admin.role-menu-title-permition.create",
                            "store"     => "admin.role-menu-title-permition.store",
                            "edit"      => "admin.role-menu-title-permition.edit",
                            "update"    => "admin.role-menu-title-permition.update",
                            "show"      => "admin.role-menu-title-permition.show",
                            "delete"    => "admin.role-menu-title-permition.delete"
                        ],
                        //Main Module Permission from Menu Action Permission
                    'route_url_action_permissions' =>
                        [
                            "view"      => "admin.role-menu-action-permition.index",
                            "create"    => "admin.role-menu-action-permition.create",
                            "store"     => "admin.role-menu-action-permition.store",
                            "edit"      => "admin.role-menu-action-permition.edit",
                            "update"    => "admin.role-menu-action-permition.update",
                            "show"      => "admin.role-menu-action-permition.show",
                            "delete"    => "admin.role-menu-action-permition.delete"
                        ],
                    //=========================== skip
                    'module_action_permissions' =>
                        [
                            "view"      => "admin.role-module-action-permition.index",
                            "create"    => "admin.role-module-action-permition.create",
                            "store"     => "admin.role-module-action-permition.store",
                            "edit"      => "admin.role-module-action-permition.edit",
                            "update"    => "admin.role-module-action-permition.update",
                            "show"      => "admin.role-module-action-permition.show",
                            "delete"    => "admin.role-module-action-permition.delete"
                        ],
                    'only_deleloper' =>
                        [
                            "view"      => "only Developer",
                        ],
                ];
        return $route_url_list;
    }
#==============================================================================================================
# All route_url_list and Route/Url also Check By Middleware End == Call Like == route_url_list_in_array()['accounts']['view']
#===========================================================================================================================|


// routeURL_permission('user_roles','view')
// check_menu_button('user_roles','view')
#===========================================================================================================================|
# Apply this in anywhere in the blade fine, here include menu and button also use this like
#================================================================================================================
    function routeURL_permission($val , $val2)
    {

        if(array_key_exists($val,route_url_list_in_array()))
        {
            if(array_key_exists($val2,route_url_list_in_array()[$val]))
            {
                if((routeUrlPermissionCheckFromMiddleware_HP(route_url_list_in_array()[$val][$val2])))
                {
                    return true;
                }
            }
            else{
                Session::flash('error', 'Your route_url_list_in_array (Value) is not match! please check in the helper file in route_url_list_in_array function');
                return false;
            }

        }else{
            Session::flash('error', 'Your route_url_list_in_array (Index) is not match! please check in the helper file in route_url_list_in_array function');
            return false;
        }

    }
#==============================================================================================================
# Apply this in anywhere in the blade fine, here include menu and button also use this like
#===========================================================================================================================|




/*
|-------------------------------------------------------------------------------------------------------------|
|------------------- -------------     Menu Title Check Start          ---------------------------------------|
|-------------------------------------------------------------------------------------------------------------|
*/
    function menuTitlePermission()
    {
        return User_role_menu_title_permition::with('menuTitle')
        ->where('role_id',Auth::user()->role_id)
        ->where('is_active',1)
        ->whereNull('is_deleted')
        ->get();
    }


    function MENU_TITLE_PERMISSION($checker)
    {
        $value= 0 ;
        if(count(menuTitlePermission())>0)
        {
            foreach(menuTitlePermission() as $permission)
            {
                if($checker == $permission->menuTitle->menu_title_checker_route_or_url)
                {
                    $value = 1;
                    break;
                }
            }
        }
        if(AUth::user()->email ==  developerLogin || AUth::user()->permission_power == user_permission_power_maximum_HP)
        {
            $value = 1;
        }else{
            $value = $value;
        }
        return $value;
    }

/*
|----------------   The End : User Role Module , Role Menu Title , Menue Action Check and others ----------------------
|---------------------------------------------------------------------------------------------------------------------------
|--------------------------------------------------------------------------------------------------------------------------------|
*/


#===========================================================================================================================|
# All Menus and Route/Url also Check By Middleware Start == Call Like == menu_titles()['account']['show']
#================================================================================================================
    function menu_titles()
    {
        $menu_title = [];
        $menu_title = [
                    'user_management' =>
                        [
                            "show"      => "user_management",
                        ],
                    'user_admin' =>
                        [
                            "show"      => "user_admin",
                        ],
                    'union_porisodh' =>
                        [
                            "show"      => "union_porisodh",
                        ],
                    'user_role' =>
                        [
                            "show"      => "user_role",
                        ],

                    'profile_management' =>
                        [
                            "show"      => "profile_management",
                        ],
                    'area_management' =>
                        [
                            "show"      => "area_management",
                        ],
                    //==============================
                    'permission_management' =>
                        [
                            "show"      => "permission_management",
                        ],
                    'menu_permission' =>
                        [
                            "show"      => "menu_permission",
                        ],
                    'module_menu_permission' =>
                        [
                            "show"      => "module_menu_permission",
                        ],
                    'profile_management' =>
                        [
                            "show"      => "profile_management",
                        ],
                    'area_management' =>
                        [
                            "show"      => "area_management",
                        ],
                ];
        return $menu_title;
    }
#==============================================================================================================
# All Menus and Route/Url also Check By Middleware End == Call Like == menu_titles()['account']['show']
#if(MENU_TITLE_PERMISSION(menu_titles()['account']['show']))
#===========================================================================================================================|
























/*=====================================================================================================================================*/
/*=====================================================================================================================================*/
/*=====================================================================================================================================*/












































function moduleActionPermission()
{
    return User_role_module_action_permition::with('moduleAction')
                ->where('role_id',Auth::user()->role_id)
                ->where('is_active',1)
                ->whereNull('is_deleted')
                ->get();
}

function BUTTON_PERMISSION($checker)
{
    $value= 0 ;
    if(count(moduleActionPermission())>0)
    {
        foreach(moduleActionPermission() as $per)
        {
            if($checker == $per->moduleAction->action_checker_route_or_url)
            {
                $value = 1;
                break;
            }
        }
    }
    if(AUth::user()->email ==  developerLogin)
    {
        $value = 1;
    }else{
        $value = $value;
    }

    return $value;
}

/*
|-----------------------------------------------------------------------------------|
| Index Page Action Permition Check End                                             |
|-----------------------------------------------------------------------------------|
*/






/*
|-------------------------------------------------------------------------------------------------------------------------------
|   The Start : User Role Module Action Checker Use In the Balde FIle.... IN THE EVERY Module /TABLE
|---------------------------------------------------------------------------------------------
|-----------------------------------------------------------------------------------
*/
    #===========================================================================================================================
    # All Modules Action Button Check Start Call like === if(ACTION_BUTTON_CHECK_PERMISSION((modules()['=============================']['view'])))
    #===================================================================================================================
    function buttons()
    {
        $module = [];
        $module = [
                    'user_roles' =>
                        [
                            "view"      => "admin.user-role.index",
                            "create"    => "admin.user-role.create",
                            "store"     => "admin.user-role.store",
                            "edit"      => "admin.user-role.edit",
                            "update"    => "admin.user-role.update",
                            "show"      => "admin.user-role.show",
                            "delete"    => "admin.user-role.delete"
                        ],
                    'menu_title_permissions' =>
                        [
                            "view"      => "admin.role-menu-title-permition.index",
                            "create"    => "admin.role-menu-title-permition.create",
                            "store"     => "admin.role-menu-title-permition.store",
                            "edit"      => "admin.role-menu-title-permition.edit",
                            "update"    => "admin.role-menu-title-permition.update",
                            "show"      => "admin.role-menu-title-permition.show",
                            "delete"    => "admin.role-menu-title-permition.delete"
                        ],
                    'menu_action_permissions' =>
                        [
                            "view"      => "admin.role-menu-action-permition.index",
                            "create"    => "admin.role-menu-action-permition.create",
                            "store"     => "admin.role-menu-action-permition.store",
                            "edit"      => "admin.role-menu-action-permition.edit",
                            "update"    => "admin.role-menu-action-permition.update",
                            "show"      => "admin.role-menu-action-permition.show",
                            "delete"    => "admin.role-menu-action-permition.delete"
                        ],
                    'module_action_permissions' =>
                        [
                            "view"      => "admin.role-module-action-permition.index",
                            "create"    => "admin.role-module-action-permition.create",
                            "store"     => "admin.role-module-action-permition.store",
                            "edit"      => "admin.role-module-action-permition.edit",
                            "update"    => "admin.role-module-action-permition.update",
                            "show"      => "admin.role-module-action-permition.show",
                            "delete"    => "admin.role-module-action-permition.delete"
                        ],
                    'only_deleloper' =>
                        [
                            "view"      => "only Developer",
                        ],
                ];
        return $module;
    }
#==================================================================================================================
# All Modules Action Button Check End Call Like == modules()['accounts']['view']
#=========================================================================================================================|



    /*
        function routeURL_permission($val , $val2)
        {
            if(menuEnableType == "button")
            {
                if(array_key_exists($val,buttons()))
                {
                    if(array_key_exists($val2,buttons()[$val]))
                    {
                        if((BUTTON_PERMISSION(buttons()[$val][$val2])))
                        {
                            return true;
                        }
                    }
                    else{
                        Session::flash('error', 'Your buttons (Value) is not match! please check in the helper file in button function');
                        return false;
                    }

                }else{
                    Session::flash('error', 'Your buttons (Index) is not match! please check in the helper file in button function');
                    return false;
                }
            }
            else
            {
                if(array_key_exists($val,route_url_list_in_array()))
                {
                    if(array_key_exists($val2,route_url_list_in_array()[$val]))
                    {
                        if((routeUrlPermissionCheckFromMiddleware_HP(route_url_list_in_array()[$val][$val2])))
                        {
                            return true;
                        }
                    }
                    else{
                        Session::flash('error', 'Your route_url_list_in_array (Value) is not match! please check in the helper file in route_url_list_in_array function');
                        return false;
                    }

                }else{
                    Session::flash('error', 'Your route_url_list_in_array (Index) is not match! please check in the helper file in route_url_list_in_array function');
                    return false;
                }
            }
        }
    */
