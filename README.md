Summary
------------------------

Magento 2 Extension that will allow customers to view common FAQ’s based on the product they are viewing.
If they don’t see what they are looking for, they can submit a question via a form which can be approved and answered by the admin.

Configuration
------------------------
 
 PRODUCTS > Product FAQ > Configuration  
 STORES > Configuration > CATALOG > Product FAQ  
 
        Enable - Yes/No
      

Administration
------------------------

 PRODUCTS > Product FAQ > Manage Questions  
 PRODUCTS > Catalog > Product > ADVANCED SETTINGS > FAQ (tab)  


Installation
------------------------

Enter following commands to install module:

```bash
cd MAGE2_ROOT_DIR
# install
composer config repositories.kuzman_productfaq git https://github.com/vladankuzmanovic/ProductFaq.git
composer require kuzman/productfaq:dev-master
# enable
php bin/magento module:enable Kuzman_ProductFaq --clear-static-content
php bin/magento setup:upgrade
php bin/magento setup:static-content:deploy
```

Uninstall
------------------------

Enter following commands to disable and uninstall module:

```bash
cd MAGE2_ROOT_DIR
# disable
php bin/magento module:disable Kuzman_ProductFaq --clear-static-content    
# uninstall
php bin/magento module:uninstall Kuzman_ProductFaq --clear-static-content
php bin/magento setup:static-content:deploy
```
