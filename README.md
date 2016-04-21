Component automatically compile js and css files (on request)
===================================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist skeeks/cms-assets-auto-compress "*"
```

or add

```
"skeeks/cms-assets-auto-compress": "*"
```

Configuration app
----------

```php

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

```

##Links
* [Web site](http://en.cms.skeeks.com)
* [Web site (rus)](http://cms.skeeks.com)
* [Author](http://skeeks.com)
* [ChangeLog](https://github.com/skeeks-cms/cms-assets-auto-compress/blob/master/CHANGELOG.md)
* [Page on SkeekS CMS Marketplace](http://marketplace.cms.skeeks.com/solutions/instrumentyi/razrabotchiku/75-komponent-optimizatsii-koda-js-i-css-d)



___

> [![skeeks!](https://gravatar.com/userimage/74431132/13d04d83218593564422770b616e5622.jpg)](http://skeeks.com)  
<i>SkeekS CMS (Yii2) — quickly, easily and effectively!</i>  
[skeeks.com](http://skeeks.com) | [en.cms.skeeks.com](http://en.cms.skeeks.com) | [cms.skeeks.com](http://cms.skeeks.com) | [marketplace.cms.skeeks.com](http://marketplace.cms.skeeks.com)


