<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 */

namespace skeeks\cms\assetsAuto\jobs;

use skeeks\cms\job\contracts\JobReporterInterface;
use skeeks\cms\job\exceptions\JobCancelledException;
use skeeks\cms\job\handlers\AbstractJobHandler;
use skeeks\cms\job\runtime\JobContext;
use skeeks\yii2\assetsAuto\CompiledFilesCleaner;

/**
 * Removes compiled css/js files that pages have not used for `days` days.
 *
 * Payload: `{"days": 7, "dryRun": false}`, both optional. The asset directories
 * come from `cms->tmpFolderScheme['assets']`, the same list `cms/cache/flush-assets` uses.
 */
class CompiledFilesCleanupJobHandler extends AbstractJobHandler
{
    /**
     * @var int default retention in days
     */
    public $days = 7;

    public function run(JobContext $context, JobReporterInterface $reporter): void
    {
        $days = $context->get('days', $this->days);
        if (!is_numeric($days) || (int)$days < 1) {
            throw new \InvalidArgumentException('Срок хранения days должен быть целым числом дней не меньше 1.');
        }
        $dryRun = (bool)$context->get('dryRun', false);

        $checkpoint = static function () use ($reporter): void {
            if ($reporter->isCancelled()) {
                throw new JobCancelledException('Очистка отменена.');
            }
            $reporter->heartbeat();
        };
        $checkpoint();

        $assetsDirs = array_map(function ($path) {
            return \Yii::getAlias($path);
        }, (array)(\Yii::$app->cms->tmpFolderScheme['assets'] ?? []));
        $dirs = CompiledFilesCleaner::compiledDirs($assetsDirs);

        $reporter->setStage('cleanup', 'Очистка склеенных CSS и JS');
        $stats = (new CompiledFilesCleaner([
            'dirs'       => $dirs,
            'days'       => (int)$days,
            'dryRun'     => $dryRun,
            'checkpoint' => $checkpoint,
        ]))->run();

        $reporter->countSuccess($stats['files']);
        if ($stats['errors']) {
            $reporter->warning('Часть файлов не удалось удалить.', ['errors' => $stats['errors']]);
            $reporter->countWarning($stats['errors']);
        }

        $mib = round($stats['bytes'] / 1048576, 1);
        $reporter->setResult($stats + ['days' => (int)$days, 'dryRun' => $dryRun, 'dirs' => $dirs, 'mib' => $mib]);
        $reporter->setStage('complete', ($dryRun ? 'Пробный запуск. Можно удалить файлов: ' : 'Удалено файлов: ').$stats['files'].', освобождено '.$mib.' МБ');
    }
}
