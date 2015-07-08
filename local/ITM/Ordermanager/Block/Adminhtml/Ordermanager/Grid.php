<?php

class ITM_Ordermanager_Block_Adminhtml_Ordermanager_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
    {
        parent::__construct();
        $this->setId('sales_order_grid');
        $this->setUseAjax(false);
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true); // added by Wang 2015-7-8
//        $this->setSaveParametersInSession(false); //removed by Wang 2015-7-8
		$this->setFilterVisibility(false);
//		$this->setPagerVisibility(false);       //removed by Wang 2015-7-8
    }
 
 
 	protected function _prepareLayout()
    {
        $this->unsetChild('reset_filter_button');
        $this->unsetChild('search_button');
    }
    /**
     * Retrieve collection class
     *
     * @return string
     */
    protected function _getCollectionClass()
    {
        return 'sales/order_grid_collection';
    }
 
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel($this->_getCollectionClass());

        //we changed mysql query, we added inner join to order item table
        //$collection->join('sales/order_item', 'order_id=entity_id', array('name'=>'name', 'sku' =>'sku', 'qty_ordered'=>'qty_ordered' ), null,'left');
        $this->setCollection($collection);
      //  return $collection;//parent::_prepareCollection(); // removed by Wang 2015-7-7
        return parent::_prepareCollection();        //added by Wang 20154-7-7
    }

    protected function _prepareColumns()
    {
 
        $this->addColumn('real_order_id', array(
            'header'=> Mage::helper('sales')->__('Order #'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'increment_id',
        ));
 
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'    => Mage::helper('sales')->__('Purchased from (store)'),
                'index'     => 'store_id',
                'type'      => 'store',
                'store_view'=> true,
                'display_deleted' => true,
                'filter_index' => 'main_table.store_id'
            ));
        }
 
        $this->addColumn('created_at', array(
            'header' => Mage::helper('sales')->__('Purchased On'),
            'index' => 'created_at',
            'type' => 'datetime',
            'width' => '100px',
            'filter_index' => 'main_table.created_at'
        ));
 
        $this->addColumn('billing_name', array(
            'header' => Mage::helper('sales')->__('Bill to Name'),
            'index' => 'billing_name',
        ));
 
/*        $this->addColumn('qty_ordered', array(
            'header'    => Mage::helper('sales')->__('Items Ordered'),
            'index'     => 'qty_ordered',
            'type'      => 'number',
            'total'     => 'sum'
        ));
 
        $this->addColumn('sku', array(
            'header'    => Mage::helper('catalog')->__('SKU'),
            'index'     => 'sku',
			'type' => 'text'
        ));
 */
        $this->addColumn('base_grand_total', array(
            'header' => Mage::helper('sales')->__('G.T. (Base)'),
            'index' => 'base_grand_total',
            'type'  => 'currency',
            'currency' => 'base_currency_code',
        ));
 
        $this->addColumn('grand_total', array(
            'header' => Mage::helper('sales')->__('G.T. (Purchased)'),
            'index' => 'grand_total',
            'type'  => 'currency',
            'currency' => 'order_currency_code',
        ));
 
        $this->addColumn('status', array(
            'header' => Mage::helper('sales')->__('Status'),
            'index' => 'status',
            'type'  => 'options',
            'width' => '70px',
            'options' => array('approved'=>'Approved','pending'=>'pending','rejected'=>'Rejected'),//Mage::getSingleton('sales/order_config')->getStatuses(), //added by Wang 2015-7-7
        ));
 
 
        return $this;
    }
 
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('order_ids');
        $this->getMassactionBlock()->setUseSelectAll(false);
 
       $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('ordermanager')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('ordermanager')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('ordermanager/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('ordermanager')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('ordermanager')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
 
        return $this;
    }
 
    public function getRowUrl($row)
    {
        //print_r($this->getUrl('./admin/sales_order/actions/view', array('order_id' => $row->getId())));
        if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
            return $this->getUrl('./admin/sales_order/view', array('order_id' => $row->getId()));
        }
        return false;
    }
    public function getGridUrl()
    {
        return $this->getUrl('*/*/index', array('_current'=>true));
    }
}