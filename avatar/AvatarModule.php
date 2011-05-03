<?php
Yii::setPathOfAlias('AvatarModule' , dirname(__FILE__));

class AvatarModule extends CWebModule {
	public $defaultController = 'avatar';

	public $avatarPath = 'images';

	// Set avatarMaxWidth to a value other than 0 to enable image size check
	public $avatarMaxWidth = 0;

	public $avatarThumbnailWidth = 50; // For display in user browse, friend list
	public $avatarDisplayWidth = 200;

	public $controllerMap=array(
		'avatar'=>array('class'=>'AvatarModule.controllers.YumAvatarController'),
	);


}
