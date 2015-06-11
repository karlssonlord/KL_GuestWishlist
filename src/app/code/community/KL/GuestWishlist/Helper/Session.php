<?php 

class KL_GuestWishlist_Helper_Session
{
    /**
     * @param $productId
     * @return Varien_Object
     */
    public function saveFavourite($productId)
    {
        $items = Mage::getSingleton('core/session')->getData(KL_GuestWishlist_Model_Item::KEY_IDENTIFIER);
        if (is_array($items)) {
            array_push($items, $productId);
            return Mage::getSingleton('core/session')->setData(KL_GuestWishlist_Model_Item::KEY_IDENTIFIER, $items);
        }
        Mage::getSingleton('core/session')->setData(KL_GuestWishlist_Model_Item::KEY_IDENTIFIER, array($productId));
    }

    public function removeFavourite($productId)
    {
        $items = Mage::getSingleton('core/session')->getData(KL_GuestWishlist_Model_Item::KEY_IDENTIFIER);
        if ($this->sessionHasFavourites($items) && $this->itemExists($productId, $items)) {
            $key = array_search($productId, $items);
            unset($items[$key]);
            return Mage::getSingleton('core/session')->setData(KL_GuestWishlist_Model_Item::KEY_IDENTIFIER, $items);
        }
    }

    /**
     * @param $productId
     * @param $items
     * @return bool
     */
    private function itemExists($productId, $items)
    {
        return in_array($productId, $items);
    }

    /**
     * @param $items
     * @return bool
     */
    private function sessionHasFavourites($items)
    {
        return is_array($items);
    }

}