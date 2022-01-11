<?php

# Author : Jana
# Timestamp : 18-02-2020 11:03 AM

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
use \yii\web\Request;

$baseUrl = str_replace('/backend/web', '', (new Request)->getBaseUrl());

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log','MyGlobalClass'],
    'modules' => [],
    'timeZone' => 'Asia/Kolkata',
    'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'nullDisplay' => '',
        ],
        'session' => [
            'name' => 'BreatheAqua' ,
            'timeout' => 1440,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'authTimeout' => 3600, // auth expire 
        ],
       'MyGlobalClass'=>[
            'class'=>'backend\components\MyGlobalClass'
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest'],
        ],
        'request'=>[

            'class' => 'common\components\Request',

            'web'=> '/backend/web',

            'adminUrl' => '/admin',
            'baseUrl' => '/2022/breatheAqua',

        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true, // Need to chage as false for normal URL
            'showScriptName' => false,
            'enableStrictParsing' => false, 
            // 'suffix' => '.html',
            'rules' => [
                // ...
                'home' => 'site/login',
                'logout' => 'site/logout',
                'index' => 'site/index',

                'app-content' => 'app-content-management/create',

                # Left Menu management

                'menu-order'=>'leftmenu-management/menu-order',
                'menu-order-merchant'=>'leftmenu-management/merchant-menu-order',
                'sub-menu-order-merchant/<id:\d+>'=>'leftmenu-management/submenu-order-merchant',
                'sub-menu-order/<id:\d+>'=>'leftmenu-management/submenu-order',
                	
                    
                'menu-mng' => 'leftmenu-management/index',
                'menu-mng-c' => 'leftmenu-management/create',
                'menu-mng-u/<id:\d+>' => 'leftmenu-management/update',
                'menu-mng-e/<id:\d+>' => 'leftmenu-management/edit',
                'menu-mng-d/<id:\d+>' => 'leftmenu-management/delete',
                


                'profile' => 'userdetails/profile',
                'edit-profile' => 'userdetails/editprofile',
                'role-c' => 'role/create',
                

                # Role Creation and Management
                # These URLs are used for Manages the Menu permission for the Users based on their Roles 
                'role-i' => 'role/index',
                'role-c' => 'role/create',
                'role-u/<id:\d+>' => 'role/update',
                'role-d/<id:\d+>' => 'role/delete',
                'role-m-i' => 'role/manageindex',  

                
                /****Role Management *******/
                'role-manage-i' => 'role-manage/index',
                'role-manage-c/<id:\d+>' => 'role/role-manage',
                'role-manage-u/<id:\d+>' => 'role-manage/update',
                'role-manage-d/<id:\d+>' => 'role-manage/delete',
                'role-manage-fc/<id:\d+>' =>'role-manage/franchise-create', 

                /******* User Management *****/
                'user-mng' => 'user-login/index',
                'user-mng-c/<id:\d+>' => 'user-login/create',
                'user-mng-u/<id:\d+>' => 'user-login/update',
                'user-mng-d/<id:\d+>' => 'user-login/delete',

                /*** FORGET PASSWORD ***/
                'forgotpassword'=>'userchangelog/forgotpassword',
                'changepassword'=>'userchangelog/changepassword',
                'thanks'=>'userchangelog/thanks',

                /******* User Masters *****/
                'user' => 'user-management/index',
                'user-c/<id:\d+>' => 'user-management/create',
                'user-u/<id:\d+>' => 'user-management/update',
                'user-d/<id:\d+>' => 'user-management/delete',
                'user-v/<id:\d+>' => 'user-management/view',

                /******* Company User Management *****/
                'company-user' => 'company-users-list/index',
                'company-user-c/<id:\d+>' => 'company-users-list/create',
                'company-user-u/<id:\d+>' => 'company-users-list/update',
                'company-user-d/<id:\d+>' => 'company-users-list/delete',
                'company-user-v/<id:\d+>' => 'company-users-list/view',

                /******* Brand Management *****/
                'brand' => 'brand-master/index',
                'brand-c/<id:\d+>' => 'brand-master/create',
                'brand-u/<id:\d+>' => 'brand-master/update',
                'brand-d/<id:\d+>' => 'brand-master/delete',
                'brand-v/<id:\d+>' => 'brand-master/view',

                /******* capacity Management *****/
                'capacity' => 'capacity-master/index',
                'capacity-c/<id:\d+>' => 'capacity-master/create',
                'capacity-u/<id:\d+>' => 'capacity-master/update',
                'capacity-d/<id:\d+>' => 'capacity-master/delete',
                'capacity-v/<id:\d+>' => 'capacity-master/view',

                /******* capacity Management *****/
                'product' => 'product-master/index',
                'product-c/<id:\d+>' => 'product-master/create',
                'product-u/<id:\d+>' => 'product-master/update',
                'product-d/<id:\d+>' => 'product-master/delete',
                'product-v/<id:\d+>' => 'product-master/view',

                /******* Depostie Management *****/
                'deposite' => 'deposite-management/index',
                'deposite-c/<id:\d+>' => 'deposite-management/create',
                'deposite-u/<id:\d+>' => 'deposite-management/update',
                'deposite-d/<id:\d+>' => 'deposite-management/delete',
                'deposite-v/<id:\d+>' => 'deposite-management/view',

                /******* Order Management *****/
                'order' => 'order-management/index',
                'order-c/<id:\d+>' => 'order-management/create',
                'order-u/<id:\d+>' => 'order-management/update',
                'order-d/<id:\d+>' => 'order-management/delete',
                'order-v/<id:\d+>' => 'order-management/view',

            ],
        ],
    ],
    'params' => $params,
    /*'on beforeAction' => function ($event) {
        if(Yii::$app->request->pathInfo === 'search') {
            $url = 'site/index?' . Yii::$app->request->queryString;
            Yii::$app->response->redirect($url)->send();
            $event->handled = true;
        }
    }*/
];
