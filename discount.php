<?php
// достаем список скидок, применяемых к товару в корзине
if (!function_exists("getDiscountList")) {
    function getDiscountList($PRODUCT_ID, $QUANTITY = 1, $strProductProviderClass = "CCatalogProductProvider", $strCallbackFunc = "")
    {
        CModule::IncludeModule("sale");
        $arCallbackPrice = false;
        if (!empty($strProductProviderClass)) {
            if ($productProvider = CSaleBasket::GetProductProvider(array(
                'MODULE' => 'catalog',
                'PRODUCT_PROVIDER_CLASS' => $strProductProviderClass))
            ) {
                $providerParams = array(
                    'PRODUCT_ID' => $PRODUCT_ID,
                    'QUANTITY' => $QUANTITY,
                    'RENEWAL' => 'N'
                );
                /* @var $productProvider CCatalogProductProvider */
                $arCallbackPrice = $productProvider::GetProductData($providerParams);
                unset($providerParams);
            }
        } elseif (!empty($strCallbackFunc)) {
            $arCallbackPrice = CSaleBasket::ExecuteCallbackFunction(
                $strCallbackFunc,
                'catalog',
                $PRODUCT_ID,
                $QUANTITY,
                'N'
            );
        }
        return $arCallbackPrice;
    }
}

?>
