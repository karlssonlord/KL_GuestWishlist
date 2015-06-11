<?php


use MageTest\Manager\Factory;

class CollectionTest extends PHPUnit_Framework_TestCase
{
    protected $products;

    protected $name;

    public function setUp()
    {
        Mage::init();
        $this->name = (string)rand(999,9999);
        $this->products = Factory::times(3)->make('catalog/product', ['name' => $this->name]);
        foreach ($this->products as $product) {
            Mage::helper('guestwishlist')->saveFavourite($product->getId());
        }
    }
    
    public function tearDown()
    {
        Mage::getSingleton('core/session')->setData(KL_GuestWishlist_Model_Item::KEY_IDENTIFIER, null);
        Factory::clear();
    }
    
    /**
     * @test
     */
    public function it_does_something()
    {
        $products = Mage::getModel('guestwishlist/favourites')->loadItems();
        $this->assertInstanceOf('Mage_Catalog_Model_Resource_Product_Collection', $products);
        $this->assertCount(3, $products);
        $this->assertEquals($this->name, $products->getFirstItem()->getName());
    }
}
