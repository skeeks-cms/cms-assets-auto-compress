<?php
/**
 * Loaded by web and console: the job type must be known to both.
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 */
$config = [];

// cms-job and cms-agent are optional: without them the console command remains.
if (class_exists(\skeeks\cms\job\JobRegistry::class)) {
    $type = 'assets-auto-compress.cleanup';
    $config['components']['jobRegistry']['types'][$type] = [
        'type'          => $type,
        'title'         => 'Очистка склеенных CSS и JS',
        'handler'       => \skeeks\cms\assetsAuto\jobs\CompiledFilesCleanupJobHandler::class,
        'queue'         => 'maintenance',
        'timeout'       => 600,
        'leaseSeconds'  => 120,
        'maxAttempts'   => 1,
        'idempotent'    => true,
        'overlapPolicy' => 'skip',
        'permission'    => \skeeks\cms\rbac\CmsManager::PERMISSION_ROLE_ADMIN_ACCESS,
        // One asset directory per installation, whatever the site.
        'resourceKey'   => static function () { return 'assets-auto-compress:cleanup'; },
        'dedupKey'      => static function () use ($type) { return $type; },
    ];

    if (class_exists(\skeeks\cms\agent\CmsAgentComponent::class)) {
        $config['components']['cmsAgent']['jobs'][$type] = [
            'jobType'  => $type,
            'name'     => 'Очистка склеенных CSS и JS',
            'interval' => 86400,
        ];
    }
}

return $config;
