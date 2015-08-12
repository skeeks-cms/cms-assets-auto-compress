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
     * @var bool Включить стандартную быструю предзагрузку.
     */
    public $enabledPreloader    = false;

    /**
     * Особенно актуально в момент переноса css файлов вниз страницы
     * @var bool Если включена предыдущая опция, этот html код будет вставлен в начало страницы
     */
    public $preloaderBodyHtml   = <<<HTML
<div class="sx-preloader">
    <div id="sx-loaderImage"></div>
</div>
HTML
;
    /**
     * Особенно актуально в момент переноса css файлов вниз страницы
     * @var bool Если включена предыдущая опция, этот css код будет вставлен в начало страницы
     */
    public $preloaderBodyCss    = <<<CSS
.sx-preloader{
  display: table;
  background: #1e1e1e;
  z-index: 999999;
  position: fixed;
  height: 100%;
  width: 100%;
  left: 0;
  top: 0;
}

#sx-loaderImage {
  display: table-cell;
  vertical-align: middle;
  overflow: hidden;
  text-align: center;
}


#sx-canvas {
  display: table-cell;
  vertical-align: middle;
  margin: 0 auto;
}
CSS
;

    public $preloaderBodyJs    = <<<JS
	jQuery(window).load(function(){
		jQuery('.sx-preloader').fadeOut('slow',function(){jQuery(this).remove();});
	});
JS
;


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
            [['cssFileBottom'], 'boolean'],
            [['cssFileBottomLoadOnJs'], 'boolean'],
            [['enabledPreloader'], 'boolean'],
            [['preloaderBodyHtml'], 'string'],
            [['preloaderBodyCss'], 'string'],
            [['preloaderBodyJs'], 'string'],
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
            'enabledPreloader'                          => 'Включить показ прелоадера',
            'preloaderBodyHtml'                         => 'Html код прелоадера (будет вставлен после тега body)',
            'preloaderBodyCss'                          => 'CSS код прелоадера (будет вставлен вначало страницы)',
            'preloaderBodyJs'                           => 'JS код прелоадера (будет вставлен вниз страницы)',
        ]);
    }
}