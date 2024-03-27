<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 06.08.2015
 */

namespace skeeks\cms\assetsAuto;

use skeeks\cms\backend\BackendComponent;
use skeeks\yii2\assetsAuto\formatters\html\TylerHtmlCompressor;
use yii\base\Event;
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
        if ($app instanceof Application) {
            $this->enabled = $this->settings->enabled;

            foreach ($this->settings->attributeLabels() as $attribute => $label) {
                if ($this->canSetProperty($attribute)) {
                    $this->{$attribute} = $this->settings->{$attribute};
                }
            }

            if ($this->settings->htmlCompress) {
                $this->htmlFormatter = [
                    'class'      => TylerHtmlCompressor::class,
                    'extra'      => (bool)$this->settings->htmlCompressExtra,
                    'noComments' => (bool)$this->settings->htmlCompressNoComments,
                ];
            }


            if ($app instanceof \yii\web\Application) {
                $app->view->on(View::EVENT_END_PAGE, function (Event $e) use ($app) {

                    if (BackendComponent::getCurrent()) {
                        //При включении компиляции CKEDitor не работает
                        return false;
                        //TODO: доработать
                        if (YII_ENV_DEV) {
                            return false;
                        }

                        $this->enabled = true;
                        $this->jsFileCompileByGroups = false;
                        $this->jsFileCompile = true;
                        $this->cssFileCompile = false;
                    }

                    /**
                     * @var $view View
                     */
                    $view = $e->sender;

                    if ($this->enabled && $view instanceof View && $app->response->format == Response::FORMAT_HTML && !$app->request->isAjax && !$app->request->isPjax) {
                        \Yii::beginProfile('Compress assets');
                        $this->_processing($view);
                        \Yii::endProfile('Compress assets');
                    }

                    //TODO:: Think about it
                    if ($this->enabled && $app->request->isPjax) {

                        if ($this->noIncludeJsFilesOnPjax && $this->jsFileCompile) {
                            \Yii::$app->view->jsFiles = null;
                        }

                        if ($this->noIncludeCssFilesOnPjax && $this->cssFileCompile) {
                            \Yii::$app->view->cssFiles = null;
                        }
                    }
                });

                //Html compressing
                $app->response->on(\yii\web\Response::EVENT_BEFORE_SEND, function (\yii\base\Event $event) use ($app) {
                    if (\Yii::$app->admin->requestIsAdmin) {
                        return false;
                    }

                    $response = $event->sender;

                    if ($this->enabled && $this->htmlCompress && $response->format == \yii\web\Response::FORMAT_HTML && !$app->request->isAjax && !$app->request->isPjax) {
                        if (!empty($response->data) && is_string($response->data)) {
                            $response->data = $this->_processingHtml($response->data);
                        }
                    }
                });
            }
        }
    }
}