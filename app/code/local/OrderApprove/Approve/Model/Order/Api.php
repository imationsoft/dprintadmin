<?php
/**
 * Magento
 *
 */
class OrderApprove_Approve_Model_Order_Api extends Mage_Sales_Model_Order_Api
{    
	/**
     * Approve order
     *
     * @param string $orderIncrementId
     * @return boolean
     */
    public function approve($orderIncrementId)   //added by Wang
    {
        $order = $this->_initOrder($orderIncrementId);

        try {
            $order->approve();
            $order->save();
        } catch (Mage_Core_Exception $e) {
            $this->_fault('status_not_changed', $e->getMessage());
        }

        return true;
    }

    /**
     * Reject order
     *
     * @param string $orderIncrementId
     * @return boolean
     */
    public function reject($orderIncrementId)   //added by Wang 2015-7-7
    {

        $order = $this->_initOrder($orderIncrementId);

        try {
            $order->reject();
            $order->save();
        } catch (Mage_Core_Exception $e) {
            $this->_fault('status_not_changed', $e->getMessage());
        }

        return true;
    }
} // Class Mage_Sales_Model_Order_Api End
