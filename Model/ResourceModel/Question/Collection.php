<?php
/**
 * @author	    Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
namespace Kuzman\ProductFaq\Model\ResourceModel\Question;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */

    protected $_idFieldName = 'question_id';
    
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'Kuzman\ProductFaq\Model\Question',
            'Kuzman\ProductFaq\Model\ResourceModel\Question'
        );
    }

    /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {
        $this->performAfterLoad('kuzman_product_faq_id', 'question_id', 'product_id');
        return parent::_afterLoad();
    }

    /**
     * Perform operations after collection load
     *
     * @param string $tableName
     * @param string $columnName
     * @return void
     */
    protected function performAfterLoad($tableName, $columnName, $product)
    {
        $items = $this->getColumnValues($columnName);
        if (count($items)) {
            $connection = $this->getConnection();
            $select = $connection->select()->from(['question_entity_product' => $this->getTable($tableName)])
                    ->where('question_entity_product.' . $columnName . ' IN (?)', $items);
            $result = $connection->fetchAll($select);

            if ($result) {
                foreach ($this as $item) {
                    $entityId = $item->getData($columnName);
                    $productId = array();
                    foreach($result as $r){
                        if ($r[$columnName] == $entityId){
                            $productId[] = $r[$product];
                        }
                    }
                    $item->setData($product, implode(',',$productId));
                }
            }
        }
    }

    /**
     * Returns Joined collection of 'kuzman_product_faq' and 'kuzman_product_faq_id'
     * @param $productId
     * @return array
     */
    public function joinedCollection($productId){

        $connection = $this->getConnection();
        $select = $connection->select()->from(['v' => $this->getTable('kuzman_product_faq')])
            ->joinInner(['r' => $this->getTable('kuzman_product_faq_id')], 'v.question_id=r.question_id',
                '*'
            )
            ->where('product_id = ?', $productId)
            ->order('position','asc');
        $result = $connection->fetchAll($select);

        return $result;
    }
}