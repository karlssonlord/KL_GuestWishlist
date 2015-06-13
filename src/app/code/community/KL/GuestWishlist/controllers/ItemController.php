<?php 

class KL_GuestWishlist_ItemController extends Mage_Core_Controller_Front_Action
{
    public function addAction()
    {
        try
        {
            Mage::helper('guestwishlist')->saveFavourite($this->getRequest()->getPost('product_id'));
        }
        catch (Exception $e)
        {
            $this->getResponse()->setBody($this->__('Unable to add your favourite.'));
            return $this->getResponse()->setHttpResponseCode(400);
        }
        $this->getResponse()->setHttpResponseCode(200);
    }

    public function removeAction()
    {
        try
        {
            Mage::helper('guestwishlist')->removeFavourite($this->getRequest()->getPost('product_id'));
        }
        catch (Exception $e)
        {
            $this->getResponse()->setBody($this->__('Unable to remove your favourite.'));
            return $this->getResponse()->setHttpResponseCode(400);
        }

        $this->getResponse()->setHttpResponseCode(200);
    }

    public function allAction()
    {
        $items = Mage::helper('guestwishlist')->getAll();
        if (count($items)) {
            $this->getResponse()->setHttpResponseCode(200);
            $this->getResponse()->setBody(
                Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK, $secure = true) . '/guest-wishlist/?items=' . $items->toJson()
            );
        } else {
            $this->getResponse()->setHttpResponseCode(400);
        }
    }
}