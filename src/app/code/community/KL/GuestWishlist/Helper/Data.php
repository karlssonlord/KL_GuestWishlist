<?php 

class KL_GuestWishlist_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $items;

    public function __construct()
    {
        $this->items = Mage::getSingleton('core/session')->getData(KL_GuestWishlist_Model_Item::KEY_IDENTIFIER);
    }
    /**
     * @param $productId
     * @return Varien_Object
     */
    public function saveFavourite($productId)
    {
        return $this->addToSessionArray($productId);
    }

    public function merge($productId)
    {
        if (!$this->itemAlreadySaved($productId)) {
            $this->addToSessionArray($productId);
        }
    }

    /**
     * @param $productId
     * @return Varien_Object
     */
    public function removeFavourite($productId)
    {
        if ($this->sessionHasFavourites($this->items) && $this->itemExists($productId, $this->items)) {
            $key = array_search($productId, $this->items);
            unset($this->items[$key]);
            return Mage::getSingleton('core/session')->setData(KL_GuestWishlist_Model_Item::KEY_IDENTIFIER, $this->items);
        }
    }

    /**
     * @return int
     */
    public function getItemsCount()
    {
        $sessionKey = Mage::getSingleton('core/session')->getData(KL_GuestWishlist_Model_Item::KEY_IDENTIFIER);
        if (!is_array($sessionKey)) return 0;
        return count($sessionKey);
    }

    public function isFavourite(Mage_Catalog_Model_Product $product)
    {
        return $this->itemExists(
            $product->getId(),
            Mage::getSingleton('core/session')->getData(KL_GuestWishlist_Model_Item::KEY_IDENTIFIER)
        );
    }

    public function getAll()
    {
        if (!$this->items) {
            $this->items = Mage::getSingleton('core/session')->getData(KL_GuestWishlist_Model_Item::KEY_IDENTIFIER);
        }
        return $this;
    }

    public function toJson()
    {
        return json_encode($this->items);
    }

    public function toArray()
    {
        return (array)$this->items;
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

    /**
     * @param $productId
     * @return mixed
     */
    private function addToSessionArray($productId)
    {
        if (is_array($this->items)) {
            array_push($this->items, $productId);
            return Mage::getSingleton('core/session')->setData(KL_GuestWishlist_Model_Item::KEY_IDENTIFIER, $this->items);
        }
        return Mage::getSingleton('core/session')->setData(KL_GuestWishlist_Model_Item::KEY_IDENTIFIER, array($productId));
    }

    /**
     * @param $productId
     * @return bool
     */
    private function itemAlreadySaved($productId)
    {
        if (!is_array($this->items)) {
            return false;
        }
        return in_array($productId, $this->items);
    }

}
