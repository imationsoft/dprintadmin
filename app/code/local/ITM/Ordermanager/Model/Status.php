<?php

class ITM_Ordermanager_Model_Status extends Varien_Object
{
    const STATUS_ENABLED	= 'approved'; //changed by Wang 2015-6-26
    const STATUS_DISABLED	= 'pending';
    const STATUS_REJECTED   =  'rejected'; // added by Wang 2015-7-7
    const STATUS_CLOSED   =  'rejected';
    const STATUS_PROCESSING   =  'processing';
    const STATUS_CANCELED   =  'canceled';


    static public function getOptionArray()
    {
        return array(
            self::STATUS_ENABLED    => Mage::helper('ordermanager')->__('Approved'), //changed by Wang 2015-6-26
            self::STATUS_DISABLED   => Mage::helper('ordermanager')->__('Pending'),
            self::STATUS_REJECTED   => Mage::helper('ordermanager')->__('Rejected'),   // added by Wang 2015-7-7
            self::STATUS_CLOSED    => Mage::helper('ordermanager')->__('Closed'),
            self::STATUS_PROCESSING   => Mage::helper('ordermanager')->__('Processing'),
            self::STATUS_CANCELED   => Mage::helper('ordermanager')->__('Canceled')
        );
    }
}