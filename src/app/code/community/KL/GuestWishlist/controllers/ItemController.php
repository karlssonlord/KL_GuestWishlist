<?php 

class KL_GuestWishlist_ItemController extends Mage_Core_Controller_Front_Action
{
    public function addAction()
    {
        Mage::helper('guestwishlist')->saveFavourite($this->getRequest()->getPost('product_id'));
    }

    public function removeAction()
    {
        try
        {
            Mage::helper('guestwishlist')->removeFavourite($this->getRequest()->getPost('product_id'));
        }
        catch (Exception $e)
        {
            $this->getResponse()->setBody($this->__('Unable to save your favourite.'));
            return $this->getResponse()->setHttpResponseCode(400);
        }

        $this->getResponse()->setHttpResponseCode(200);
    }
}