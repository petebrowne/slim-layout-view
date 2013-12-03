slim-layout-view
================

A Custom View supporting Layouts for the Slim Framework. slim-layout-view requires Slim 2.0+, which now follows the PSR-2 standard.

Installation
------------

Add `"petebrowne/slim-layout-view"` to your `composer.json` file:

``` json
{
  "require": {
    "slim/slim": "2.*",
    "petebrowne/slim-layout-view": "0.2.*"
  }
}
```

And install using composer:

``` bash
$ php composer.phar install
```

Configuration
-------------

Configure Slim to use slim-layout-view, and optionally set the layout file to use (defaults to `'layout.php'`):

``` php
$app = new \Slim\Slim(array(
  'view' => '\Slim\LayoutView',
  'layout' => 'layouts/main.php'
));
```

Usage
-----

Now create your layout file. The content from the rendered view will be in a variable called `$yield`:

``` html+php
<html>
  <head></head>
  <body>
    <?php echo $yield ?>
  </body>
</html>
```

Now you can render the view in the usual way:

``` php
$app->get('/', function() use ($app) {
  $app->render('index.php');
});
```

Rendering with custom layouts or without any layout at all is also supported:

``` php
// Use a different layout for this route:
$app->get('/', function() use ($app) {
  $app->render('index.php', array('layout' => 'custom_layout.php'));
});

// Skip the layout for this route:
$app->get('/index.xml', function() use ($app) {
  $app->render('xml.php', array('layout' => false));
});
```

Copyright
---------

Copyright (c) 2013 [Peter Browne](http://petebrowne.com). See LICENSE for details.
