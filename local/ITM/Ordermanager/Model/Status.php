<?php

class ITM_Ordermanager_Model_Status extends Varien_Object
{
    const STATUS_ENABLED	= 'approved'; //changed by Wang 2015-6-26
    const STATUS_DISABLED	= 'pending';
    const STATUS_REJECTED   =  'rejected'; // added by Wang 2015-7-7

    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('ordermanager')->__('Approved'), //changed by Wang 2015-6-26
            self::STATUS_DISABLED   => Mage::helper('ordermanager')->__('Pending'),
            self::STATUS_REJECTED   => Mage::helper('ordermanager')->__('Rejected')   // added by Wang 2015-7-7
        );
    }
}