# Introduction #

Installing the User Management Module is very easy due to the great module System of the Yii Framework and the Installer provided by the Module. In this Tutorial we will learn how to use the User Management Module on a fresh created Yii Web Application.

# Details #

1.) Generate your Webapp:

$ php yii-1.1-dev/framework/yiic webapp testdrive
Create a Web application under '/var/www/testdrive'? [Yes|No] Yes

[...]

Your application has been created successfully under /var/www/testdrive.


2.) Extract the Yii User Management Module under the modules/ directory of your new Web Application. Replace the _0.2 with the latest Version available._

$ cd testdrive/protected
$ mkdir modules
$ cd modules
$ wget http://www.yiiframework.com/extension/yii-user-management/files/User_Management_Module_0.2.tar.bz2
$ tar xvf User\_Management\_Module\_0.2.tar.bz2

3.) Add the Module to your Application Configuration

$ [youreditor](youreditor.md) protected/config/main.php

Add this lines:

'modules' => array(
> 'user' => array(
> > 'debug' => true

> ),

in your Application Configuration

You can set additionally 'salt'=>'example\_salt' for yours passwords, and 'hashFunc' for valid callback to hashing algorithm of passwords (if not set extension will use md5 algorithm as hash function) if You'll change salt, or hashing function in future, Yours passwords will become useless

4.) The Yii User Management Module needs a Database Connection to work. You now have to setup your SQlite or MySQL Database and insert the connection URI in your Application configuration, like this:

> 'db'=>array(
> > 'connectionString' => 'mysql:host=localhost;dbname=testdrive',
> > 'emulatePrepare' => true,
> > 'username' => 'root',
> > 'password' => '',
> > 'charset' => 'utf8',
> > ),

$ mysql -u root localhost
> CREATE DATABASE `testdrive` ;


5.) To let your Web Application use the Authentification Methods of the User Management Module, we need to overwrite the default Authentification Method in the Application Configuration:


> 'components'=>array(
> 'User'=>array(
> > 'class' => 'User',
> > ),


This tells our Web Application that is should access the Model 'User' when Yii:app()->User is run. Please note the difference of 'User' and 'user' here. 'User' represents our ActiveRecord-Model while 'user' represents the user configuration.

If you want, you can set the loginUrl of the Application to this:


> 'user'=>array(
> > 'allowAutoLogin'=>true,
> > 'loginUrl' => array('/user/user/login'),
> > ),

At the time of this writing you have to copy over the UserIdentity.php of the User Module to your Application components directory manually. This will be automated in later versions. Do it like this:


> $ cp protected/modules/user/components/UserIdentity.php protected/components

6.) Run the User Management Installer in your Web-Browser:

http://localhost/testdrive/index.php/user/install

7.) Now the Installer of the User Management Module should appear. To the right you can set up alternating Table Names used by the Module. In most cases this is not needed and you can ignore this Settings. If you do change this, be sure to set up the correct table Names in your Application Configuration, so the User Module can access them.

Click 'Install Module':

Congratulations, your User management Module Installation Succeded !

8.) Click on "Administrate your Users (use admin/admin)". Now you are taken to the default Front-End Login-Screen of the User Management Module. Log in with the Username admin and Password admin.

9.) Click on the 'update Icon' (the pencil) of your administrator User. Change the Password to something more safe than 'admin'. Click Save.

10.) Remove the 'debug' => 'true' line from your Application Configuration so your new data doesn't get overwritten accidentally by the installation process.

11.) Update the 'login' link of your Yii Webapp to point to array('user') in the views/layouts/main.php

Configuration of your freshly installed User Management Module:

Language:

The Yii-User Management Module uses the language that is set in the Application Configuration. If you want, you can add a

'language' => 'de',

in your config/main.php to get German Language strings. French and Spain are available, but not every string is translated at the time of this writing.

Role Management:

You can add up new roles in the Role Manager. To check for access to this roles, you can use this code Snippet everywhere in your Yii Application. Most likely it will be used in the ACL Filter of your Controllers:

if(Yii::app()->User->hasRole('role'))
{
> // user is allowed
}
else
{
> // user is not allowed to do this
}

Note, that you can assign several Roles to a user holding your CTRL key in the Listbox. This will be changed to a two-pane view (like in srbac) in a later Version.

available Application Configuration Parameters:

Version number of the Module:

$version = '0.2';

Whether the Module is in Debug mode.

$debug = false;

Table Names:

$usersTable = "users";
$messagesTable = "messages";
$profileFieldsTable = "profile\_fields";
$profileTable = "profiles";
$rolesTable = "roles";
$userRoleTable = "user\_has\_role";

Should there be installed the demo Data? :

$installDemoData = true;

The Layout used. This is the default Layout of the skeleton App. Replace it with the used layout of your Web Application:

$layout = 'column2';