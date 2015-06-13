<?php 

class KL_GuestWishlist_Block_Items extends KL_Boilerplate_Block_Catalog_Product_List_General
{
    public $isWishlist = true;

    public function getLoadedProductCollection()
    {
        return Mage::getModel('guestwishlist/favourites')->loadItems();
//        return Mage::getModel('catalog/product')
//            ->getCollection()
//            ->addAttributeToSelect('*')
//            ->setPageSize(16)
//            ->setCurPage(1)
//        ;
    }
}