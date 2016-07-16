<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 27.03.2015
 */
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\WidgetConfig */

?>

<?= $form->fieldSet('Основное'); ?>
    <?= $form->field($model, 'enabled')->radioList(\Yii::$app->formatter->booleanFormat)->hint('Эта опция, отключает и включает работу всего компонента. Отключив ее все другие настройки не будут учитываться.'); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet('Js обработка в html'); ?>
    <?= $form->field($model, 'jsCompress')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'jsCompressFlaggedComments')->radioList(\Yii::$app->formatter->booleanFormat); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet('Css обработка в html'); ?>
    <?= $form->field($model, 'cssCompress')->radioList(\Yii::$app->formatter->booleanFormat); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet('Обработка css файлов'); ?>
    <?= $form->field($model, 'cssFileCompile')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'cssFileRemouteCompile')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'cssFileCompress')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'cssFileBottom')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'cssFileBottomLoadOnJs')->radioList(\Yii::$app->formatter->booleanFormat); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet('Обработка js файлов'); ?>
    <?= $form->field($model, 'jsFileCompile')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'jsFileRemouteCompile')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'jsFileCompress')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'jsFileCompressFlaggedComments')->radioList(\Yii::$app->formatter->booleanFormat); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet('Обработка HTML'); ?>
    <?= $form->field($model, 'htmlCompress')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'htmlCompressExtra')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'htmlCompressNoComments')->radioList(\Yii::$app->formatter->booleanFormat); ?>
<?= $form->fieldSetEnd(); ?>


