<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
namespace Kuzman\ProductFaq\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Question extends AbstractDb
{
    /**
     * Construct
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param string|null $resourcePrefix
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);
    }

    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('kuzman_product_faq', 'question_id');
    }

    /**
     * Assign page to store views
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
    {
        $oldProductIds = $this->lookupProductIds($object->getId());
        $newProductIds =  array_filter(array_unique($this->getProductIds($object->getData('product_id'))));
        $table = $this->getTable('kuzman_product_faq_id');
        $insert = array_diff($newProductIds, $oldProductIds);
        $delete = array_diff($oldProductIds, $newProductIds);

        if ($delete) {
            $where = ['question_id = ?' => (int)$object->getId(), 'product_id IN (?)' => $delete];

            $this->getConnection()->delete($table, $where);
        }

        if ($insert) {
            $data = [];

            foreach ($insert as $storeId) {
                $data[] = ['question_id' => (int)$object->getId(), 'product_id' => (int)$storeId];
            }

            $this->getConnection()->insertMultiple($table, $data);
        }

        return parent::_afterSave($object);
    }

    /**
     * Get store ids to which specified item is assigned
     *
     * @param int $questionId
     * @return array
     */
    public function lookupProductIds($questionId)
    {
        $connection = $this->getConnection();

        $select = $connection->select()->from(
            $this->getTable('kuzman_product_faq_id'),
            'product_id'
        )->where(
            'question_id = ?',
            (int)$questionId
        );

        return $connection->fetchCol($select);
    }

    protected function getProductIds($productId)
    {
        return explode(',', $productId);
    }

    /**
     * Perform operations after object load
     *
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return $this
     */
    protected function _afterLoad(\Magento\Framework\Model\AbstractModel $object)
    {
        if ($object->getId()) {
            $productIds = $this->lookupProductIds($object->getId());
            $productId = implode(',', $productIds);
            $object->setData('product_id', $productId);
        }

        return parent::_afterLoad($object);
    }
}