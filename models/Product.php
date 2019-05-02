<?php
/**
 * Created by PhpStorm.
 * User: David
 * Date: 02/05/2019
 * Time: 20:44
 */

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
            if ($cache) {
                $blockedStockQuantityInOrders = OrderLine::getDb()->cache(function ($db) use ($productId) {
                    return (new self)->getBlockedStockQuantityInOrders($productId);
                }, $cacheDuration);
                $blockedStockQuantity = BlockedStock::getDb()->cache(function ($db) use ($productId) {
                    return (new self)->getBlockedStockQuantity($productId);
                }, $cacheDuration);
            } else {
                $blockedStockQuantityInOrders = (new self)->getBlockedStockQuantityInOrders($productId);
                $blockedStockQuantity = (new self)->getBlockedStockQuantity($productId);
            }

            // Units available
            if (isset($blockedStockQuantityInOrders) || isset($blockedStockQuantity)) {
                if ($quantityAvailable >= 0) {
                    $quantityAvailableTemp = $quantityAvailable - $blockedStockQuantityInOrders - $blockedStockQuantity;
                    return (new self)->getQuantityAvailableTemp($quantityAvailableTemp, $securityStockConfig);
                } elseif ($quantityAvailable < 0) {
                    return $quantityAvailable;
                }
            } else {
                if ($quantityAvailable >= 0) {
                    return(new self)->getQuantityAvailableTemp($quantityAvailable, $securityStockConfig);
                }
                return $quantityAvailable;
            }
            return 0;
        } catch (\Exception $e) {
            return $e;
        }

    }

    /**
     * Return blocked stock quantity in orders in process
     *
     * @param string $productId
     * @return integer $blockedStockQuantityInOrders
     */
    public function getBlockedStockQuantityInOrders($productId)
    {
        $blockedStockQuantityInOrders = OrderLine::find()->select('SUM(quantity) as quantity')
            ->joinWith('order')
            ->where("(order.status = '" . Order::STATUS_PENDING . "' OR order.status = '" . Order::STATUS_PROCESSING . "' OR order.status = '" . Order::STATUS_WAITING_ACCEPTANCE . "') AND order_line.product_id = $productId")
            ->scalar();

        return $blockedStockQuantityInOrders;
    }

    /**
     * Return blocked stock quantity
     *
     * @param string $productId
     * @return integer $blockedStockQuantity
     */
    public function getBlockedStockQuantity($productId)
    {
        $blockedStockQuantity = BlockedStock::find()->select('SUM(quantity) as quantity')
            ->joinWith('shoppingCart')
            ->where("blocked_stock.product_id = $productId AND blocked_stock_to_date > '" . date('Y-m-d H:i:s') . "' AND (shopping_cart_id IS NULL OR shopping_cart.status = '" . ShoppingCart::STATUS_PENDING . "')")
            ->scalar();

        return $blockedStockQuantity;
    }

    /**
     * Return blocked stock quantity
     *
     * @param string $productId
     * @return integer $blockedStockQuantity
     */
    public function getQuantityAvailableTemp($quantityAvailableTemp, $securityStockConfig)
    {
        $quantityAvailableTemp = $this->setApplySecurityStockConfig($quantityAvailableTemp, $securityStockConfig);
        return $quantityAvailableTemp > 0 ? $quantityAvailableTemp : 0;
    }

    /**
     * Apply Securiry Stock Config
     *
     * @param string $productId
     * @return integer $blockedStockQuantity
     */
    public function setApplySecurityStockConfig($quantity, $securityStockConfig)
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