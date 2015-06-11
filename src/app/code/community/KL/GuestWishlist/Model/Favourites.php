<?php 

class KL_GuestWishlist_Model_Favourites extends Mage_Catalog_Model_Resource_Product_Collection
{
    /**
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    public function loadItems()
    {
       return $this->addAttributeToFilter('in', $this->getFavouriteIds())
                   ->addAttributeToSelect('*')
       ;
    }

    /**
     * @return array
     */
    protected function getFavouriteIds()
    {
        return (array)Mage::getSingleton('core/session')->getData(KL_GuestWishlist_Model_Item::KEY_IDENTIFIER);
    }

}
