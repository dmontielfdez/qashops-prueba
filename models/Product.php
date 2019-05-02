<?php

namespace app\models;

class Product
{
    public static function stock(
        $productId,
        $quantityAvailable,
        $cache = false,
        $cacheDuration = 60,
        $securityStockConfig = null
    )
    {
        try {

            $blockedStockQuantityInOrders = self::blockedStockQuantityInOrders($productId, $cache, $cacheDuration);
            $blockedStockQuantity = self::blockedStockQuantity($productId, $cache, $cacheDuration);

            // Units available
            if ($quantityAvailable >= 0) {
                if (isset($blockedStockQuantityInOrders) || isset($blockedStockQuantity)) {
                    $quantityAvailable = $quantityAvailable - $blockedStockQuantityInOrders - $blockedStockQuantity;
                }
                return self::quantityAvailableTemp($quantityAvailable, $securityStockConfig);
            }
            return $quantityAvailable;

        } catch (\Exception $e) {
            return $e;
        }

    }

    /**
     * @param string $productId, bool $cache, int $cacheDuracion
     * @return integer $blockedStockQuantityInOrders
     */
    private static function blockedStockQuantityInOrders($productId, $cache, $cacheDuration)
    {
        if ($cache) {
            return OrderLine::getDb()->cache(
                function ($db) use ($productId, $cache, $cacheDuration) {
                    return self::blockedStockQuantityInOrdersQuery($productId, $cache, $cacheDuration);
                },
                $cacheDuration);
        }
        return self::blockedStockQuantityInOrdersQuery($productId, $cache, $cacheDuration);

    }

    /**
     * @param string $productId
     * @return integer $blockedStockQuantityInOrders
     */
    private static function blockedStockQuantityInOrdersQuery($productId)
    {
        return OrderLine::find()->select('SUM(quantity) as quantity')
            ->joinWith('order')
            ->where("(order.status = '" . Order::STATUS_PENDING . "' OR order.status = '" . Order::STATUS_PROCESSING . "' OR order.status = '"
                . Order::STATUS_WAITING_ACCEPTANCE . "') AND order_line.product_id = $productId")
            ->scalar();

    }

    /**
     * @param string $productId, bool $cache, int $cacheDuracion
     * @return integer $blockedStockQuantity
     */
    private static function blockedStockQuantity($productId, $cache, $cacheDuration)
    {
        if ($cache) {
            return OrderLine::getDb()->cache(
                function ($db) use ($productId, $cache, $cacheDuration) {
                    return self::blockedStockQuantityQuery($productId, $cache, $cacheDuration);
                },
                $cacheDuration);
        }
        return self::blockedStockQuantityQuery($productId, $cache, $cacheDuration);
    }

    /**
     * @param string $productId
     * @return integer $blockedStockQuantity
     */
    private static function blockedStockQuantityQuery($productId)
    {
        return BlockedStock::find()->select('SUM(quantity) as quantity')
            ->joinWith('shoppingCart')
            ->where("blocked_stock.product_id = $productId AND blocked_stock_to_date > '" . date('Y-m-d H:i:s') . "' AND (shopping_cart_id IS NULL OR shopping_cart.status = '"
                . ShoppingCart::STATUS_PENDING . "')")
            ->scalar();
    }

    /**
     * @param string $productId
     * @return integer $quantity
     */
    private static function quantityAvailableTemp($quantityAvailableTemp, $securityStockConfig)
    {
        $quantityAvailableTemp = self::applySecurityStockConfig($quantityAvailableTemp, $securityStockConfig);
        return $quantityAvailableTemp > 0 ? $quantityAvailableTemp : 0;
    }

    /**
     * @param string $productId
     * @return integer $quantity
     */
    private static function applySecurityStockConfig($quantity, $securityStockConfig)
    {
        if (!empty($securityStockConfig)) {
            $quantity = ShopChannel::applySecurityStockConfig(
                $quantity,
                $securityStockConfig->mode,
                $securityStockConfig->quantity
            );
        }

        return $quantity;
    }

}
