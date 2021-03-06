<?php
/**
 * 2017-2019 DM Productions B.V.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file LICENSE.md
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@dmp.nl so we can send you a copy immediately.
 *
 * @author     Michael Dekker <info@mijnpresta.nl>
 * @copyright  2010-2019 DM Productions B.V.
 * @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
 */

if (!defined('_PS_VERSION_')) {
    return;
}

/**
 * @param MyParcel $module
 *
 * @return bool
 * @throws PrestaShopDatabaseException
 * @throws PrestaShopException
 */
function upgrade_module_2_3_0($module)
{
    /** @var MyParcel $module */
    $newHooks = array(
        'actionLogsGridDefinitionModifier',
        'actionLogsGridPresenterModifier',
        'displayAdminProductsExtra',
        'actionProductSave',
    );
    foreach ($newHooks as $newHook) {
        $module->registerHook($newHook);
    }
    Configuration::updateValue('MYPARCEL_DIGSTAMP_SHIPPED', true);
    Configuration::updateValue('MYPARCEL_DEFCON_CS', 'enable');
    try {
        MyParcelProductSetting::createDatabase();
    } catch (Exception $e) {
        Context::getContext()->controller->errors[] = "Unable to update the MyParcel module: {$e->getMessage()}";
    }
    try {
        MyParcelCarrierDeliverySetting::createMissingColumns();
    } catch (Exception $e) {
        Context::getContext()->controller->errors[] = "Unable to update the MyParcel module: {$e->getMessage()}";
    }
    try {
        MyParcelGoodsNomenclature::createDatabase();
    } catch (Exception $e) {
        Context::getContext()->controller->errors[] = "Unable to update the MyParcel module: {$e->getMessage()}";
    }

    return true;
}
