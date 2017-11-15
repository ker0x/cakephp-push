Installation
============

Using `Composer <http://getcomposer.org/>`__
--------------------------------------------

To install this plugin, run ``composer require ker0x/cakephp-push`` or add this snippet in your project's ``composer.json``.

.. code:: json

    {
        "require": {
            "ker0x/cakephp-push": "~2.0"
        }
    }

Enable plugin
-------------

You can load the plugin by typing the following command in a terminal:

.. code:: bash

    bin/cake plugin load Kerox/Push -b

or by adding the following line inside your ``config/bootstrap.php`` file:

.. code:: php

    Plugin::load('Kerox/Push', ['bootstrap' => true]);