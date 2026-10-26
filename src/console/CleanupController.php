<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 */

namespace skeeks\cms\assetsAuto\console;

/**
 * `php yii assets-auto-compress/cleanup --dry-run` over the CMS asset directories
 * (`cms->tmpFolderScheme['assets']`).
 */
class CleanupController extends \skeeks\yii2\assetsAuto\console\CleanupController
{
    public function init()
    {
        parent::init();
        if (\Yii::$app->has('cms')) {
            $this->assetsDirs = (array)(\Yii::$app->cms->tmpFolderScheme['assets'] ?? $this->assetsDirs);
        }
    }
}
