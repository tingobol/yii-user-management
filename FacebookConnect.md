Configuration options for having Facebook Connect up and running.

# Introduction #

By now this article is a stub. It has the schema, skeleton of the final page. You either can wait for us to complete it or try to follow the schema. In any case we're sure it will work. Well, we hope.

Below you will find the instructions to enable your Yum site to have **Facebook Connect** authentication using the Graph API.

**WARNING:** This code is experimental. Although it works for us, it has not been heavily tested. However is fairly stable.

# Steps to enable Facebook Connect Auth #

## Get a fresh copy of Yum sources ##

Please use a code revision major or equals to [r210](https://code.google.com/p/yii-user-management/source/detail?r=210).

## Install and configure Yum ##

See InstallationInstructions on how to create a new Yii application and install and enable Yum on it.



## Yum enabled site configuration ##

### facebook\_id ###

Create a new 'facebook\_id' INTEGER profile field.

### `config/main.php` configuration ###

Has to be configured under the `user` key in Yii's modules section.

Here is an example:

```
'user' => array(
	'debug'=>true,
	'facebookConfig'=>array(
		'appId'=>'YOUR APPID',
		'secret'=>'YOUR SECRET',
		'domain'=>'YOUR DOMAIN',
		'status'=>true,
		'xfbml'=>true,
		'cookie'=>true,
		'lang'=>'en_US', //es_LA, de_DE, cz_CZ, etc.
	),
	'modules'=>array(...),
),
```

### Enable Facebook Auth ###

You need to set loginType to 8 into the `user` key in Yii's modules section:

```
'user' => array(
	...
	'loginType' => 8, //By username and Facebook should be 9.
	...
),
```

Check in UserModule.php:113 on how to activate one or more login ways.

## Modify the main view layout ##

You need to do some modifications to the layouts in your app:

### PHP control code ###

Put this at the very beginning of your _main layout_:

```
<?php

$fbconfig = Yum::module()->facebookConfig;
if(isset($fbconfig)) {
    Yii::import('application.modules.user.vendors.facebook.*');
        require_once('Facebook.php');
    $facebook = new Facebook($fbconfig);
    $fb_session = $facebook->getSession();
    if($fb_session && Yii::app()->user->isGuest)
                if($this->action->id != 'login')
                        $this->redirect($this->createUrl('/user/auth/login'));
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
```

### Facebook Javascript code ###

Put this just after the `<body>` tag of your _main layout_:

```
<?php if(isset($fbconfig)): ?>
<div id="fb-root"></div>
<script>
window.fbAsyncInit = function() {
    FB.init({
        appId   : '<?php echo $facebook->getAppId(); ?>',
        session : <?php echo json_encode($fb_session); ?>, // don't refetch the session when PHP already has it
        status  : <?php echo $fbconfig['status']; ?>, // check login status
        cookie  : <?php echo $fbconfig['cookie']; ?>, // enable cookies to allow the server to access the session
        xfbml   : <?php echo $fbconfig['xfbml']; ?> // parse XFBML
    });

    // whenever the user logs in, we refresh the page
    FB.Event.subscribe('auth.login', function() {
        window.location.reload();
    });
};

(function() {
    var e = document.createElement('script');
    e.src = document.location.protocol + '//connect.facebook.net/<?php echo $fbconfig['lang']; ?>/all.js';
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
}());
</script>
<?php endif; ?>
```
### The (infamous) Facebook Login button ###

In your views, where you want the button to be displayed. Check for the Facebook Connect permissions in http://developers.facebook.com/

```
<?php if (!Yii::app()->user->isGuest): ?>
<a href="<?php echo $this->createUrl('/user/auth/logout'); ?>" class="exit"><div></div>
   <span>Logout</span>
</a>
<?php else: ?>
<fb:login-button perms="email,user_birthday,read_stream,publish_stream">
<span>Login to Facebook</span>
</fb:login-button>
<?php endif; ?>
```
#### Alternative login method ####

As alternative to the above login fbmltag, you can use straigh PHP/HTML markup:
```
<a href="<?php echo $facebook->getLoginUrl(); ?>">
<img style="margin-left: 10px; margin-top: 4px;"
     src="<?php echo Yii::app()->baseUrl;?>>/images/signin/facebook.png" /> <!-- Google the image! -->
</a>
```

# Conclusion #

That's all. As said some paragraphs above, this is experimental code. We will be glad to have feedback from you, to help us to improve this documentation and the feature itself.

Thank you for trying Yii User Management module.