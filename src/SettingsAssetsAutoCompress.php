<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 31.07.2015
 */
namespace skeeks\cms\assetsAuto;

use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/**
 * @property array htmlCompressOptions
 *
 * Class SettingsAssetsAutoCompress
 * @package skeeks\cms\assetsAuto
 */
class SettingsAssetsAutoCompress extends \skeeks\cms\base\Component
{
    /**
     * @var bool Включение выключение механизма компиляции
     */
    public $enabled = false;



    /**
     * @var bool
     */
    public $jsCompress = true;
    /**
     * @var bool Выризать комментарии при обработке js
     */
    public $jsCompressFlaggedComments = true;


    /**
     * @var bool
     */
    public $cssCompress = true;




    /**
     * @var bool Включение объединения css файлов
     */
    public $cssFileCompile = true;

    /**
     * @var bool Пытаться получить файлы css к которым указан путь как к удаленному файлу, скчать его к себе.
     */
    public $cssFileRemouteCompile = false;

    /**
     * @var bool Включить сжатие и обработку css перед сохранением в файл
     */
    public $cssFileCompress = false;


    /**
     * @var bool Перенос css файлов вниз страницы
     */
    public $cssFileBottom = false;

    /**
     * @var bool Перенос css файлов вниз страницы и их подгрузка при помощи js
     */
    public $cssFileBottomLoadOnJs = false;




    /**
     * @var bool Включение объединения js файлов
     */
    public $jsFileCompile = true;

    /**
     * @var bool Пытаться получить файлы js к которым указан путь как к удаленному файлу, скчать его к себе.
     */
    public $jsFileRemouteCompile = false;

    /**
     * @var bool Включить сжатие и обработку js перед сохранением в файл
     */
    public $jsFileCompress = true;

    /**
     * @var bool Выризать комментарии при обработке js
     */
    public $jsFileCompressFlaggedComments = true;



    /**
     * Enable compression html
     * @var bool
     */
    public $htmlCompress = true;

    /**
     * Use more compact HTML compression algorithm
     * @var bool
     */
    public $htmlCompressExtra = false;

    /**
     * During HTML compression, cut out all html comments
     * @var bool
     */
    public $htmlCompressNoComments = true;







    /**
     * Можно задать название и описание компонента
     * @return array
     */
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name'          => \Yii::t('skeeks/assets-auto', 'Compilation settings js and css'),
        ]);
    }

    public function renderConfigForm(ActiveForm $form)
    {
        echo \Yii::$app->view->renderFile(__DIR__ . '/forms/_settings.php', [
            'form'  => $form,
            'model' => $this
        ], $this);
    }


    public function rules()
    {
        return ArrayHelper::merge(parent::rules(), [
            [['enabled'], 'boolean'],
            [['jsCompress'], 'boolean'],
            [['jsCompressFlaggedComments'], 'boolean'],
            [['cssFileCompile'], 'boolean'],
            [['cssFileRemouteCompile'], 'boolean'],
            [['cssFileCompress'], 'boolean'],
            [['jsFileCompile'], 'boolean'],
            [['jsFileRemouteCompile'], 'boolean'],
            [['jsFileCompress'], 'boolean'],
            [['jsFileCompressFlaggedComments'], 'boolean'],
            [['cssCompress'], 'boolean'],
            [['cssFileBottom'], 'boolean'],
            [['cssFileBottomLoadOnJs'], 'boolean'],
            [['htmlCompress'], 'boolean'],
            [['htmlCompressExtra'], 'boolean'],
            [['htmlCompressNoComments'], 'boolean'],
        ]);
    }

    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'enabled'                                   => 'Включена',
            'jsCompress'                                => 'Компиляция js в коде html',
            'jsCompressFlaggedComments'                 => 'Обрезание комментариев в (компиляция js в коде html)',
            'cssFileCompile'                            => 'Включить объединение css файлов в один',
            'cssFileRemouteCompile'                     => 'Попытаться скачать файл с удаленного сервера',
            'cssFileCompress'                           => 'Сжимать полученный css файл (удалять комментарии и т.д.)',
            'jsFileCompile'                             => 'Включить объединение js файлов в один',
            'jsFileRemouteCompile'                      => 'Попытаться скачать файл с удаленного сервера',
            'jsFileCompress'                            => 'Сжимать полученный js файл (удалять комментарии и т.д.)',
            'jsFileCompressFlaggedComments'             => 'Обрезать комментарии',
            'cssCompress'                               => 'Включить сжатие css встречающегося в коде html',
            'cssFileBottom'                             => 'Переносить файлы CSS вниз страницы',
            'cssFileBottomLoadOnJs'                     => 'Переносить файлы CSS вниз страницы и загружать асинхронно при помощи js',

            'htmlCompress'                              => \Yii::t('skeeks/assets-auto', 'Enable compression HTML'),
            'htmlCompressExtra'                         => \Yii::t('skeeks/assets-auto', 'Use more compact HTML compression algorithm'),
            'htmlCompressNoComments'                    => \Yii::t('skeeks/assets-auto', 'During HTML compression, cut out all html comments'),
        ]);
    }


    /**
     * @return array
     */
    public function getHtmlCompressOptions()
    {
        return [
            'extra'         => (bool) $this->htmlCompressExtra,
            'no-comments'   => (bool) $this->htmlCompressNoComments,
        ];
    }

}