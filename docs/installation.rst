Installation
============

Using `Composer <http://getcomposer.org/>`__
--------------------------------------------

To install this plugin, run ``composer require ker0x/cakephp-push`` or add this snippet in your project's ``composer.json``.

.. code:: json

    {
        "require": {
            "ker0x/cakephp-push": "dev-master"
        }
    }

Enable plugin
-------------

You need to enable the plugin in your ``config/bootstrap.php`` file:

.. code:: php

    Plugin::load('ker0x/Push', ['bootstrap' => true]);