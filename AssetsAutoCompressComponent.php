<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 06.08.2015
 */
namespace skeeks\cms\assetsAuto;

use yii\helpers\FileHelper;
use yii\base\BootstrapInterface;
use yii\base\Component;
use yii\base\Event;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Application;
use yii\web\Response;
use yii\web\View;
/**
 * @property SettingsAssetsAutoCompress $settings
 *
 * Class AssetsAutoCompressComponent
 * @package skeeks\cms\assetsAuto
 */
class AssetsAutoCompressComponent extends \skeeks\yii2\assetsAuto\AssetsAutoCompressComponent
{

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
     * @return SettingsAssetsAutoCompress
     */
    public function getSettings()
    {
        return \Yii::$app->assetsAutoCompressSettings;
    }

    /**
     * @param Application $app
     */
    public function bootstrap($app)
    {
        if ($app instanceof Application)
        {
            $this->enabled = $this->settings->enabled;

            foreach ($this->settings->attributeLabels() as $attribute => $label)
            {
                if ($this->canSetProperty($attribute))
                {
                    $this->{$attribute} = $this->settings->{$attribute};
                }
            }


            $app->view->on(View::EVENT_END_PAGE, function(Event $e)
            {
                /**
                 * @var $view View
                 */
                $view = $e->sender;

                if ($this->enabled && $view instanceof View && \Yii::$app->response->format == Response::FORMAT_HTML && !\Yii::$app->request->isAjax && !\Yii::$app->request->isPjax
                        && !\Yii::$app->cms->moduleAdmin->requestIsAdmin()
                )
                {

                    \Yii::beginProfile('Compress assets');


                    //Стандартный прелоадер
                    if ($this->enabledPreloader)
                    {
                        if ($this->preloaderBodyCss)
                        {
                            $view->registerCss($this->preloaderBodyCss);
                        }

                        if ($this->preloaderBodyJs)
                        {
                            $view->registerJs($this->preloaderBodyJs);
                        }
                    }


                    $this->_processing($view);


                    //Стандартный прелоадер
                    if ($this->enabledPreloader && $this->preloaderBodyHtml)
                    {
                        \Yii::beginProfile('Adding preloader html');

                        if (ArrayHelper::getValue($view->jsFiles, View::POS_BEGIN))
                        {
                            $view->jsFiles[View::POS_BEGIN] = ArrayHelper::merge($view->jsFiles[View::POS_BEGIN], $this->preloaderBodyHtml);

                        } else
                        {
                            $view->jsFiles[View::POS_BEGIN][] = $this->preloaderBodyHtml;
                        }

                        \Yii::endProfile('Adding preloader html');
                    }

                    \Yii::endProfile('Compress assets');
                }
            });
        }
    }
}