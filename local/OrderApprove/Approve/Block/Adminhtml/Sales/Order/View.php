<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @copyright  Copyright (c) 2006-2015 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml sales order view
 *
 * @category    Mage
 * @package     Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class OrderApprove_Approve_Block_Adminhtml_Sales_Order_View extends Mage_Adminhtml_Block_Sales_Order_View
{

    public function __construct()
    {
        $this->_objectId    = 'order_id';
        $this->_controller  = 'sales_order';
        $this->_mode        = 'view';

        parent::__construct();
        $this->_removeButton('delete');
        $this->_removeButton('reset');
        $this->_removeButton('save');
        $this->setId('sales_order_view');
        $order = $this->getOrder();

        if ($this->_isAllowedAction('approve') && $order->canApprove()) {               //added by Wang 2015-6-25

            $this->_addButton('order_approve', array(
                'label'     => Mage::helper('sales')->__('Approve'),
                'onclick'   => 'setLocation(\'' . $this->getApproveUrl() . '\')',
            ));
         }        
    }
	/**
     * Retrieve order model object
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        return Mage::registry('sales_order');
    }

    public function getApproveUrl()  //added by Wang 2015-6-25
    {
        return $this->getUrl('*/*/approve');
    }

	public function getUrl($params='', $params2=array())
    {
        $params2['order_id'] = $this->getOrderId();
		return parent::getUrl($params, $params2);
    }
	 /**
     * Retrieve Order Identifier
     *
     * @return int
     */
    public function getOrderId()
    {
        return $this->getOrder()->getId();
    }

	protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/' . $action);
    }

}
