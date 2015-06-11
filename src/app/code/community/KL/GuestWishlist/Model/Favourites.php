<?php 

class KL_GuestWishlist_Model_Favourites
{
    /**
     * @return Mage_Catalog_Model_Resource_Product_Collection
     */
    public function loadItems()
    {
       return Mage::getModel('catalog/product')->getCollection()
           ->addAttributeToFilter(array(
               array(
                   'attribute' => 'entity_id',
                   'in' => $this->getFavouriteIds()
               )
           ))
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
