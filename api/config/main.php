<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ],
        'v2' => [
            'basePath' => '@app/modules/v2',
            'class' => 'api\modules\v2\Module'
        ],
    ],
    'components' => [        
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
        ],
        'response' => [
            // 'format' => yii\web\Response::FORMAT_JSON, # This line used for Send Every Response as JSON Data Only
            'charset' => 'UTF-8',
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
        'request' => [
                    'enableCookieValidation' => true,
                    'enableCsrfValidation' => false,
                    'cookieValidationKey' => 'sdfsdf'
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => ['v1/country'],
                    //'pluralize' => false,
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ]                    
                ],
                'POST v1/merchant-login' => 'v1/merchant/login',  
                'POST v1/merchant-details' => 'v1/merchant-mgnt/merchant-mgnt', 
        ]
    ],
    'params' => $params,
];