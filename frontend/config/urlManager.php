<?php

/** @var array $params */

return [
    'class' => 'yii\web\UrlManager',
    'hostInfo' => $params['frontendHostInfo'],
    'baseUrl' => '',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'cache' => false,
    'rules' => [


        '' => 'catalog/index',
        ['class' => 'frontend\urls\CategoryUrlRule'],
        'catalog/<id:\d+>' => 'shop/catalog/product',

        'blog' => 'blog/post/index',
        'blog/tag/<slug:[\w\-]+>' => 'blog/post/tag',
        'blog/<slug:[\w\-]+>' => 'blog/post/category',

        '<_c:[\w\-]+>' => '<_c>/index',
        '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
        '<_c:[\w\-]+>/<_a:[\w-]+>' => '<_c>/<_a>',
        '<_c:[\w\-]+>/<id:\d+>/<_a:[\w\-]+>' => '<_c>/<_a>',
    ],
];