<?php 

class KL_GuestWishlist_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $items = $this->getRequest()->getParam('items');
        if ($this->requestContainsAllFavouritesAsGetParam($items)) {
            $this->setFavouritesToSession($items);
        }
        $this->loadLayout();
        $this->renderLayout();
    }

    /**
     * @throws Zend_Json_Exception
     */
    protected function setFavouritesToSession($items)
    {
        foreach (Zend_Json::decode($items) as $item) {
            Mage::helper('guestwishlist')->merge((int)$item);
        }
    }

    /**
     * @return bool
     */
    protected function requestContainsAllFavouritesAsGetParam($param)
    {
        return !empty($param);
    }
}