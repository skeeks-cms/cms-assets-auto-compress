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
                    $this->_processing($view);
                    \Yii::endProfile('Compress assets');
                }
            });
        }
    }
}