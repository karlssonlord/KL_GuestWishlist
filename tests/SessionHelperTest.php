<?php


class SessionHelperTest extends PHPUnit_Framework_TestCase 
{
    public function setUp()
    {
        Mage::init();
        Mage::helper('guestwishlist/session')->saveFavourite(1);
        Mage::helper('guestwishlist/session')->saveFavourite(2);
        Mage::helper('guestwishlist/session')->saveFavourite(3);
    }
    
    public function tearDown()
    {
        Mage::getSingleton('core/session')->setData(KL_GuestWishlist_Model_Item::KEY_IDENTIFIER, null);
    }
    
    /**
     * @test
     */
    public function it_can_add_a_favourite_item_to_the_session_key()
    {
        $this->assertEquals(Mage::getSingleton('core/session')->getData(KL_GuestWishlist_Model_Item::KEY_IDENTIFIER), array(1,2,3));
    }

    /**
     * @test
     */
    public function it_can_remove_a_favourite_item_from_a_session_key()
    {
        Mage::helper('guestwishlist/session')->removeFavourite(3);
        $this->assertEquals(Mage::getSingleton('core/session')->getData(KL_GuestWishlist_Model_Item::KEY_IDENTIFIER), array(1,2));
    }
}
