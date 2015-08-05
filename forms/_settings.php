<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 27.03.2015
 */
use yii\helpers\Html;
use skeeks\cms\modules\admin\widgets\form\ActiveFormUseTab as ActiveForm;

/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\WidgetConfig */

?>
<?php $form = ActiveForm::begin(); ?>


<?= $form->fieldSet('Основное'); ?>
    <?= $form->field($model, 'enabled')->radioList(\Yii::$app->formatter->booleanFormat)->hint('Эта опция, отключает и включает работу всего компонента. Отключив ее все другие настройки не будут учитываться.'); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet('JS обработка в html'); ?>
    <?= $form->field($model, 'jsCompress')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'jsCompressFlaggedComments')->radioList(\Yii::$app->formatter->booleanFormat); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet('Обработка css файлов'); ?>
    <?= $form->field($model, 'cssFileCompile')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'cssFileRemouteCompile')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'cssFileCompress')->radioList(\Yii::$app->formatter->booleanFormat); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->fieldSet('Обработка js файлов'); ?>
    <?= $form->field($model, 'jsFileCompile')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'jsFileRemouteCompile')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'jsFileCompress')->radioList(\Yii::$app->formatter->booleanFormat); ?>
    <?= $form->field($model, 'jsFileCompressFlaggedComments')->radioList(\Yii::$app->formatter->booleanFormat); ?>
<?= $form->fieldSetEnd(); ?>

<?= $form->buttonsCreateOrUpdate($model); ?>
<?php ActiveForm::end(); ?>


