<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 31.07.2015
 */
namespace skeeks\cms\assetsAuto;

use yii\helpers\ArrayHelper;

/**
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
     * Можно задать название и описание компонента
     * @return array
     */
    static public function descriptorConfig()
    {
        return array_merge(parent::descriptorConfig(), [
            'name'          => 'Настройки компиляции js и css',
        ]);
    }

    /**
     * Файл с формой настроек, по умолчанию
     *
     * @return string
     */
    public function getConfigFormFile()
    {
        $class = new \ReflectionClass($this->className());
        return dirname($class->getFileName()) . DIRECTORY_SEPARATOR . 'forms/_settings.php';
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
        ]);
    }
}