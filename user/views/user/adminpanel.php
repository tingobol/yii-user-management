<?php
$this->title = Yii::t('UserModule.user', 'User administration Panel');

$this->breadcrumbs = array(
	Yii::t("UserModule.user", 'Users') => array('index'),
	Yii::t("UserModule.user", 'Administration panel'));

$path = Yii::app()->getBasePath(). '/modules/user/views/user/adminpanel.css';
$cssfile = Yii::app()->assetManager->publish($path);
Yii::app()->clientScript->registerCssFile($cssfile);
?>

<?php if(Yii::app()->getModule('user')->debug===true){
	echo CHtml::openTag('div', array('style'=>'background-color: red;color:white;'));
	echo Yii::t('UserModule.user',
			'You are running the Yii User Management Module {version} in Debug Mode!',
			array( '{version}'=>Yii::app()->controller->module->version));
	echo CHtml::closeTag('div');
}?>
<?php $this->renderPartial('/yumSettings/choose_active_profile', array(
'returnTo' => '//user/user/adminpanel',
'model' => new YumSettings())); ?>

<div id="users">
<p> 
<?php echo Yii::t('UserModule.user', 'There are {active_users} active and {inactive_users} inactive users in your System, from which {admin_users} are Administrators.', array(
			'{active_users}' => $active_users,
			'{inactive_users}' => $inactive_users,
			'{admin_users}' => $admin_users,
			)
		); ?>
</p>
<ul>
<?php printf('<li>%s</li>', CHtml::link(Yii::t('UserModule.user', 'Manage Users'), array('/user/user/admin'))); ?>
<?php printf('<li>%s</li>', CHtml::link(Yii::t('UserModule.user', 'Manage Settings'), array('/user/yumSettings/index'))); ?>
<?php printf('<li>%s</li>', CHtml::link(Yii::t('UserModule.user', 'Manage Text Settings'), array('/user/yumTextSettings/index'))); ?>
</ul>
</div>
<div id="roles">
<p> 
<?php echo Yii::t('UserModule.user', 'There are {roles} roles in your System.', array(
			'{roles}' => $roles)); ?>
</p>

<ul>
<?php printf('<li>%s</li>', CHtml::link(Yii::t('UserModule.user', 'Manage Roles'), array('/user/role/admin'))); ?>
</ul>
</div>
<div style="clear: both;">
<div id="profiles">
<?php echo Yii::t('UserModule.user', 'There are {profiles} profiles in your System. These consist of {profile_fields} profile fields in {profile_field_groups} profile field groups', array(
			'{profiles}' => $profiles,
			'{profile_fields}' => $profile_fields,
			'{profile_field_groups}' => $profile_field_groups,
			)
		); ?>
</p>

	<ul>
	<?php printf('<li>%s</li>', CHtml::link(Yii::t('UserModule.user', 'Manage profile fields'), array('/user/fields/admin'))); ?>
	<?php printf('<li>%s</li>', CHtml::link(Yii::t('UserModule.user', 'Manage profile field groups'), array('/user/fieldsgroup/admin'))); ?>
	</ul>
</div>
<div id="messages">
<p> 
<?php echo Yii::t('UserModule.user', 'There are a total of {messages} messages in your System.', array(
			'{messages}' => $messages)); ?>
</p>
	<ul>
	<?php printf('<li>%s</li>', CHtml::link(Yii::t('UserModule.user', 'View my messages'), array('/user/messages/index'))); ?>
	</ul>
</div>

<div style="clear:both;"></div>

<?php echo CHtml::link(Yii::t('UserModule.user', 'Logout'), array('/user/user/logout')); ?>
</div>
