<?php 

class KL_GuestWishlist_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $items;

    public function __construct()
    {
        $this->items = Mage::getSingleton('core/session')->getData(KL_GuestWishlist_Model_Item::KEY_IDENTIFIER);
    }

    protected function _getSingletonModel($className, $arguments = array())
    {
        return Mage::getSingleton($className, $arguments);
    }

    protected function _getUrlStore($item)
    {
        $storeId = null;
        $product = null;
        if ($item instanceof Mage_Wishlist_Model_Item) {
            $product = $item->getProduct();
        } elseif ($item instanceof Mage_Catalog_Model_Product) {
            $product = $item;
        }
        if ($product) {
            if ($product->isVisibleInSiteVisibility()) {
                $storeId = $product->getStoreId();
            } else if ($product->hasUrlDataObject()) {
                $storeId = $product->getUrlDataObject()->getStoreId();
            }
        }
        return Mage::app()->getStore($storeId);
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

    public function getAddUrl($item)
    {
        return $this->getAddUrlWithParams($item);
    }

    public function getAddUrlWithParams($item, array $params = array())
    {
        $productId = null;
        if ($item instanceof Mage_Catalog_Model_Product) {
            $productId = $item->getEntityId();
        }
        if ($item instanceof Mage_Wishlist_Model_Item) {
            $productId = $item->getProductId();
        }

        if ($productId) {
            $params['product_id'] = $productId;
            $params[Mage_Core_Model_Url::FORM_KEY] = $this->_getSingletonModel('core/session')->getFormKey();
            return $this->_getUrlStore($item)->getUrl('guest-wishlist/item/add', $params);
        }

        return false;
    }

    public function getRemoveUrlWithParams($item, array $params = array())
    {
        $productId = null;
        if ($item instanceof Mage_Catalog_Model_Product) {
            $productId = $item->getEntityId();
        }
        if ($item instanceof Mage_Wishlist_Model_Item) {
            $productId = $item->getProductId();
        }

        if ($productId) {
            $params['product_id'] = $productId;
            $params[Mage_Core_Model_Url::FORM_KEY] = $this->_getSingletonModel('core/session')->getFormKey();
            return $this->_getUrlStore($item)->getUrl('guest-wishlist/item/remove', $params);
        }

        return false;
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
        if (!is_array($items)) {
            return false;
        }
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
        } else {
            $this->items = array($productId);
        }
        return Mage::getSingleton('core/session')->setData(KL_GuestWishlist_Model_Item::KEY_IDENTIFIER, $this->items);
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
