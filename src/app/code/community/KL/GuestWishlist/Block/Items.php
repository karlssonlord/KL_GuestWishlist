<?php 

class KL_GuestWishlist_Block_Items extends KL_Boilerplate_Block_Catalog_Product_List_General
{
    public $isWishlist = true;

    /**
     * Product Collection
     *
     * @var Mage_Eav_Model_Entity_Collection_Abstract
     */
    protected $_productCollection;

    /**
     * Retrieve loaded category collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getLoadedProductCollection()
    {
        return $this->_getProductCollection();
    }

    public function _getProductCollection()
    {
        if (is_null($this->_productCollection)) {
            $this->_productCollection = Mage::getModel('guestwishlist/favourites')->loadItems();
        }

        return $this->_productCollection;
    }

    public function getCollection()
    {
        return $this->_productCollection;
    }

    public function getItems()
    {
        return $this->_getProductCollection();
    }

    protected function _beforeToHtml()
    {
        $this->_getProductCollection()->load();

        return Mage_Core_Block_Template::_beforeToHtml();
    }
}