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
        'car/<slug:[\w\-]+>' => 'catalog/car',
    ],
];