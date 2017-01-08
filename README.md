# justcoded-test-app

INSTALLATION
------------
1. Clone repo to your computer
2. Install vendor packages via Composer (make sure that you have already installed php composer.phar global require "fxp/composer-asset-plugin:~1.1.1")
3. Create MySql database
4. Change directory to "config". Copy "appExample.php" as "app.php" in the same folder.
5. Change database settings in this file
6. Run php yii migrate from console.

USAGE
------------
1. Links to CRUD actions for products and categories can be found in the top menu.
2. API action endpoint is %yourHostName%/?r=api/get-product-details&product_id=%productId%