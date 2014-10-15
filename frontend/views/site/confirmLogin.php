<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\widgets\Alert;

/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var common\models\LoginForm $model
 */
$this->title = 'Please confirm your login';
echo Alert::widget();
?>
<div class="site-login">
	<div class="row">
		<div class="col-sm-6">
			<h2><?= Html::encode('Please login') ?></h2>

			<?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
				<?= $form->field($model, 'email') ?>
				<?= $form->field($model, 'password')->passwordInput() ?>
				<?= $form->field($model, 'rememberMe')->checkbox() ?>
				<div style="color:#999;margin:1em 0">
					If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
				</div>
				<div class="form-group">
					<?= Html::submitButton('Login', ['class' => 'btn btn-success btn-lg']) ?>
				</div>
			<?php ActiveForm::end(); ?>
		</div>
		<div class="col-sm-6">
		<h2>New User</h2>
		<?= Html::a('Continue', ['site/signup'], ['class' => 'btn btn-lg btn-success']) ?>
		</div>
	</div>
</div>