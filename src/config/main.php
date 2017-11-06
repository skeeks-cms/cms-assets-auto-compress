<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (�����)
 * @date 15.06.2015
 */
return [
    'bootstrap'    => ['assetsAutoCompress'],

    'components' =>
    [
        'assetsAutoCompress' =>
        [
            'class'         => '\skeeks\cms\assetsAuto\AssetsAutoCompressComponent',
        ],

        'assetsAutoCompressSettings' =>
        [
            'class'         => '\skeeks\cms\assetsAuto\SettingsAssetsAutoCompress',
        ],

        'i18n' => [
            'translations' =>
            [
                'skeeks/assets-auto' => [
                    'class'             => 'yii\i18n\PhpMessageSource',
                    'basePath'          => '@skeeks/cms/assetsAuto/messages',
                    'fileMap' => [
                        'skeeks/assets-auto' => 'main.php',
                    ],
                ]
            ]
        ],
    ],
];