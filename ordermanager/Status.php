<?php

class ITM_Ordermanager_Model_Status extends Varien_Object
{
    const STATUS_ENABLED	= 'approved';
    const STATUS_DISABLED	= 'pending';

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('ordermanager')->__('Approved'),
            self::STATUS_DISABLED   => Mage::helper('ordermanager')->__('Pending')
        );
    }
}