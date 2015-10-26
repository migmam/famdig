<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UsuariosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'apellido1') ?>

    <?= $form->field($model, 'telefono') ?>

    <?= $form->field($model, 'movil') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'codpostal') ?>

    <?php // echo $form->field($model, 'municipios_id') ?>

    <?php // echo $form->field($model, 'password') ?>

    <?php // echo $form->field($model, 'username') ?>

    <?php // echo $form->field($model, 'token') ?>

    <?php // echo $form->field($model, 'apellido2') ?>

    <?php // echo $form->field($model, 'dni') ?>

    <?php // echo $form->field($model, 'direccion') ?>

    <?php // echo $form->field($model, 'persona_fisica') ?>

    <?php // echo $form->field($model, 'fecha_nacimiento') ?>

    <?php // echo $form->field($model, 'genero') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
