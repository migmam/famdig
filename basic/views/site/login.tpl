
{use class="yii\helpers\Html"}
{use class="yii\bootstrap\ActiveForm"}

{use class='yii\widgets\ActiveForm' type='block'}
{ActiveForm assign='form' id='login-form' action='/form-handler' options=['class' => 'form-horizontal']}
    {$form->field($model, 'username')}
    {$form->field($model, 'password')}
    <div class="form-group">
 
            <input type="submit" value="Login" class="btn btn-primary" />

    </div>
{/ActiveForm}
