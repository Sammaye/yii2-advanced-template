Sammaye's Application Template
===================================

This is a template for the Yii 2 advanced application which I have decided to release.

**But why?**

This template was born out of a number of a projects, including an e-commerce site. Covering a common set of functionality I kept implementing between them.

I also seemed to always do this very repetitively as such I sought to remedy that. It incorporates what I feel is a good structure, this does, of course, make it opinionated but might give you pointers as well; might even be exactly what your looking for.

Maybe it will help someone.

First I will talk abut the structure and then I will delve into the things I have done. I will attempt to explain it concisely however, it is likely I may miss things out.

# DIRECTORY STRUCTURE

```
common
	components/			contains all of the extended components of the framework
	config/				contains shared configurations
	mail/				contains view/template files for e-mails
	rbac/				contains the role based permissions configuration
	models/				contains model classes used in both backend and frontend
	tests/				contains various tests for objects that are common among applications
	widgets/			contains widgets common to both back and front end
console
	config/				contains console configurations
	controllers/		contains console controllers (commands)
	migrations/			contains database migrations
	models/				contains console-specific model classes
	runtime/			contains files generated during runtime
	tests/				contains various tests for the console application
backend
	assets/				contains application assets such as JavaScript and CSS
	config/				contains backend configurations
	controllers/		contains Web controller classes
	models/				contains backend-specific model classes (Does not actually exist)
	runtime/			contains files generated during runtime
	tests/				contains various tests for the backend application
	views/				contains view files for the Web application
	web/				contains the entry script and Web resources
frontend
	assets/				contains application assets such as JavaScript and CSS
	config/				contains frontend configurations
	controllers/		contains Web controller classes
	models/				contains frontend-specific model classes (Does not actually exist)
	runtime/			contains files generated during runtime
	tests/				contains various tests for the frontend application
	views/				contains view files for the Web application
	web/				contains the entry script and Web resources
vendor/					contains dependent 3rd-party packages
environments/			contains environment-based overrides
```

## Structure Changes

The directory structure has changed a little to a version that I have tested as being quite good. The main changes revolve around moving stuff to the `common/` folder. `common/` holds all of the stuff that is common to the application globally. 

### common/components/

`components/` holds all of the extended Yii 2 components such as custom `Controller`, `User` and `Request` objects.

You can put extensions in here but you may find it better to put them in an `extensions/` folder, it is entirely up to your better judgement.

### common/mail/

This folder contains all the stuff for mail, from templates to view files.

The mail templates and views are strictly common globally to the entire application.

### common/rbac/

This folder contains the RBAC configuration including rule classes. 

Again this is globally common across the entire application.

### common/models/

I have made all models reside in `common/models` including the `SignupForm.php`, `PasswordResetRequestForm.php` and the `ResetPasswordForm.php`.

The reason for adding even these, normally frontend, models is because I found more and more that they are also useful on the backend. You want employees of a company 
using the backend to be able to register and reset their passwords without having to jump between two systems; especially if they are a new employee on their first 
day of work registering a new account in your system.

This means that the `models/` folder in both backend and frontend do not actually exist, but they can if you really need them to.

### common/widgets/

This folder contains global widgets.

There are a number of widgets you may find are actually global to your entire application, for example: I have already added the `Alert` widget as a global widget and added it to both the frontend and the backend layout.

### frontend/models/

Now moved to `common/models`.

### backend/models/

Now moved to `common/models`.


# COMPOSER

Composer has been changed. What it installs by default has been expanded and/or changed.

This project, by defauult, will download the MongoDB extension. I will explain later how to rid it of that, it is literally 2 lines of changes.

Here is a brief but comphrensive list of changes in composer:

- `yii2-mongodb` has been added and is the default database of the application
- jQuery installs a IE 8 and 9 compliant edition
- jQuery UI install a IE 8 and 9 compliant edition
- `yii2-jui` extension has been added
- `yii2-imagine` has been added for image manipulation capabilities

# CONFIGURATION

It is important to get to grips with the configuration and how it is laid out before you start fiddling.

Most of the configuration is placed within `common/config/main.php` however a sizeable amount of customisation exists within `backend/config/main.php` and `frontend/config/main.php`.

The `common/config/main.php` contains:

- Url Manager
- user
- session
- cache
- request
- mailer
- Asset Manager
- RBAC

These parts are essential to the site in general, both frontend and backend.

The asset manager configuration provides the ability to have a custom Bootstrap with your own theme and CSS for it.

The RBAC configuration allows for the default RBAC that is set-up in this template, refer to the RBAC section below.

The other parts are not so important and do pretty much what they say on the tin. Ensure to take a good long look at the configuration files and also the `params.php` files within those directories.

The `params.php` files tends to hold varibles which are helpful, these should be explained later in their own "feature" section, for which their functionality refers to. These files are quite bare currently so do not be surprised if you hear nothing of them again.

Some of the configuration is defined within the environments folder too, essentially the database, for example: SQL and MongoDB are both defined in the environments folder's own configuration files.

# CONTROLLERS

All controllers now inherit from `common\components\Controller` which provides tier 2 functionality, which will be discussed later.

The `common\components\Controller` class runs a `beforeAction` event which can be expanded with your own functionality.

# FEATURES

## common\models\Request

### CSRF Routes

I found more and more that in a real production environment CSRFs on every action were causing problems, especially on e-commerce sites. Mainly the problems revolved around the fact that not everyone posted to the website with CSRF tokens, especially if they came in from marketing campaigns such as Google Ads words or emails.

As time went on I found I actually wanted to disable CSRF by default but then enable it on pages that could be potentially insecure. 

This is more fine grain than disabling CSRF on entire controllers which is currently the only other option.

An example taken from `frontend/config/main.php`:

    'request' => [
      	'class' => 'common\components\Request',
       	'enableCsrfValidation' => true,
       	'csrfRoutes' => [
	        'site/login',
	        'site/signup',
	        'site/request-password-reset',
	        'site/reset-password',
	        'site/confirm-login'
       	]
    ],

This will make the CSRF work on those routes. It is important to also define `enableCsrfValidation` to ensure it works within Yii 2 itself.

### SSL Routes

When you site cannot entirely run over SSL you wish to define certain rrouts as SSL only, for example: with this template you may wish to define that `site/login`, `site/signup` and `user/index` are SSL routes.

Just like above you can define these by filling a property of `sslRoutes` in your request configuration with route paths.

The SSL route will be redirected to within the `common\components\Controller`.

### Tier 2 Logins

Tier 2 logins can be very helpful for e-commerce sites that wish to keep the user logged in but do not wish to leave them with he ability to order items without being securely logged in.

You will see an example of this on your local Amazon site, in my case Amazon.co.uk. It will keep you logged in but when you try and buy something it will ask you for your password.

These logins are disabled on the backend by default but enabled on the frontend,. via the configuration in `frontend/config/main.php`:

    'user' => [
        'enableTier2' => true,
        'tier2Timeout' => 3600 /* 10 mins */
    ]

As you can see the configuration is applied to the user object. By default the user component in this application template is `common\components\User`.

When you login it will set a session variable with the time out (here 10 minutes by default) and that time out will continue to grow provided you keep browsing the site within the specified time frame (in this case 10 minutes).

When a user is inactive for longer than 10 minutes it will continue to keep them logged in and allow them to do certain actions but if they hit an action which you have defined ass being tier 2 they will be asked to login.

For example within the `frontend/controllers/UserController.php` file you might have:

	public function behaviors()
	{
		return [
			'access' => [
				'class' => \yii\filters\AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['subscribe'],
						'roles' => ['?']
					],
					[
						'allow' => true,
						'actions' => ['index', 'recent-orders', 'change-password'],
						'roles' => ['tier2User']
					],
					[
						'allow' => true,
						'roles' => ['user']
					],
				],
			],
		];
	}

The `tier2User` role relates to RBAC and runs the rule at `common/rbac/Tier2Rule.php`.

If the user is found to not be tier 2 logged they are redirected to `site/confirm-login`.

## RBAC

The RBAC that is in place is done via the `common\components\PhpManager` and essentially works by adding a role field to a user which contains a role.

This role is then linked to within the `common/rbac/items.php` file and can include inheritance from other roles.

I found this style of RBAC to apply to many sites easily, without much effort, even e-commerce sites.

This is implemented by rule files within the `common/rbac/` folder.

The RBAC that comes with this application template has six roles:

- guest: most of your users
- user: someone who is logged in
- tier2user: used for tier 2 logins
- staff: someone who is a employee but not privileged to use many admin functions
- admin: an administrator of the site
- god: normally you

The default role applied to all new users will be `user` and it will be saved as full text within the record, like so (taken from MongoDBB):

    { "_id" : ObjectId("543e94856803fab5038b4570"), "username" : "sammaye", "status" : NumberLong(10), "role" : "user", "created_at" : NumberLong(1413387397), "updated_at" : NumberLong(1413394841) }

The default role applied to any non-logged in user of your site will be `guest`.

## Customised Bootstrap Assets

Both frontend and backend have their own Bootstrap contained within their respective `web` folder.

I find this the best option since I always want to apply my own variables and themes to Bootstrap as such it makes perfect sense that you should have control over it.

This is facilitated by the configuration within the `common/config/main.php` file:

    'assetManager' => [
	    'bundles' => [
	        'yii\bootstrap\BootstrapAsset' => [
		        'basePath' => '@webroot',
		        'baseUrl' => '@web',
		        'sourcePath' => null,
	        ],
	        'yii\bootstrap\BootstrapPluginAsset' => [
		        'basePath' => '@webroot',
		        'baseUrl' => '@web',
		        'sourcePath' => null,
	        ]
	    ],
    ]

and also exists within the asset compressor configuration file.

## Compressing Assets

Within the `frontend/config/assets.php` is placed an example file which will work with the assets compressor command to allow you to compress your assets.

This will in turn compress to the specification define within the `common/wigets/AllAssets.php` file.

# Sign up, Login and Reset Password

All of the user normal user functions of:

- sign up
- login
- and, reset password

exist in both frontend and backend. As states above in "common/models` section I have found time and time again I want these in both backend and frontend, not just frontend.

# Removing MongoDB 

You can easily remove MongoDB from this template by removing the etension line from composer and then running:

    php ./composer.phar update

and then "grep"-ing for `yii/mongodb/ActiveRecord` and replacing it with `yii/db/ActiveRecord`.