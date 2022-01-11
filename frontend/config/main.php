<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
 return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers', 
   // 'defaultRoute' => 'site/index',
    'components' => [ 

        'user' => [
            'identityClass' => 'common\models\UserManagementLogin',
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_frontendUser', // unique for frontend
            ]
        ],

         'authClientCollection' => [
        'class' => 'yii\authclient\Collection',
                    'httpClient' => [
                'transport' => 'yii\httpclient\CurlTransport',
            ],
        'clients' => [ 
            

            'google' => [
               'class' => 'yii\authclient\clients\Google',  
             'clientId' => '344948834684-42pqo45102p01mumnj5t0d451iu65qd2.apps.googleusercontent.com',
                'clientSecret' => '7WeNGix22YXjeGfN3p3GN-iD',  
                'version'=> '2.0',
                'returnUrl' => 'http://dev.afynder.com/afynder/site/auth?authclient=google',

                
            ], 
            'facebook' => [
                'class' => 'yii\authclient\clients\Facebook',
                //'authUrl' => 'https://dev.afynder.com/afynder/site/auth?authclient=facebook',
                'authUrl' => 'https://www.facebook.com/dialog/oauth?display=popup',
                //'authUrl' => 'https://dev.afynder.com/afynder/accounts/facebook/login/callback/',
                
                'clientId' => '4316023448472872',
                'clientSecret' => 'f837e7fe22eb1c50d193320f07e11b5b',
                            
                /*
                //Prathap
                'clientId' => '267481069968224',
                'clientSecret' => '02b01790c0f4cb8c2151be352741a898',
                'returnUrl' => 'http://dev.afynder.com/afynder/site/auth?authclient=facebook', */
            ],
            /*'twitter' =>[ 
                'class' => 'ext.yiitwitteroauth.YiiTwitter',
                'consumer_key' => 'YOUR TWITEER KEY',
                'consumer_secret' => 'YOUR TWITTER SECRET',
                'callback' => 'YOUR CALLBACK URL',
            ],*/
        ],
    ],


        'session' => [
            'name' => 'Swim987963frontend',
            'savePath' => sys_get_temp_dir(),
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'sdfafsdsd',
            'csrfParam' => '_frontendCSRF',
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
     
      'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'index'=>'site/index',
                'index1'=>'site/index1',
                'callback'=>'site/callback',
                'aboutus'=>'site/aboutus',
                'products'=>'site/products',
                'listings'=>'site/listings',
                'wishlistings'=>'site/wishlistings',
                'wishlist'=>'site/wishlist',
                'search-listings'=>'site/search-listings',
                'categories'=>'site/categories',
                'offers'=>'site/offers',
                'login'=>'site/login',
                'logout'=>'site/logout',
                'wallethistory'=>'site/wallethistory',
                'contactus'=>'site/contactus',
                'registrationsuccess'=>'site/registrationsuccess',
                'merchant-register'=>'site/merchant-register',
                'shopee-register'=>'site/shopee-register',
                'shopee-login'=>'site/shopee-login',
                'after-login'=>'site/after-login',
                'termsandconditions'=>'site/termsandconditions',
                'forgotpassword'=>'site/forgotpassword',
                'forgotpasswordmerchant'=>'site/forgotpasswordmerchant',
                'changepassword'=>'site/changepassword',
                'after-register'=>'site/after-register',
                'interesting'=>'site/interesting',
                'userprofile'=>'site/userprofile',
                'twitter'=>'site/twitter',
                'shop-profile'=>'site/shopprofile',
                'reference-check'=>'site/reference-check',
                'unique-validation'=>'site/unique-validation',
                'message'=>'site/message',

                'merchant-app'=>'site/merchant-app',
                'shopee-app'=>'site/shopee-app',




                /*
                'shopee-mailid-check'=>'site/shopee-mailid-check',
                'shopee-contact-check'=>'site/shopee-contact-check',
                'merchant-mailid-check'=>'site/merchant-mailid-check',
                'merchant-contact-check'=>'site/merchant-contact-check',*/
            ],  
        ],
        
    ],
    'params' => $params,
];
