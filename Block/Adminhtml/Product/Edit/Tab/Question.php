<?php
/**
 * @author  Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
namespace Kuzman\ProductFaq\Block\Adminhtml\Product\Edit\Tab;

class Question extends \Magento\Backend\Block\Widget\Grid\Extended
{

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * Review resource model
     *
     * @var \Kuzman\ProductFaq\Model\ResourceModel\Question\CollectionFactory
     */
    protected $questionColFactory;

    /**
     * Review resource model
     *
     * @var \Kuzman\ProductFaq\Model\ResourceModel\QuestionId\CollectionFactory
     */
    protected $questionIdsColFactory;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Backend\Helper\Data $backendHelper
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Kuzman\ProductFaq\Model\ResourceModel\Question\CollectionFactory $collectionFactory
     * @param \Kuzman\ProductFaq\Model\ResourceModel\QuestionId\CollectionFactory $collectionIdFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Backend\Helper\Data $backendHelper,
        \Magento\Framework\Registry $coreRegistry,
        \Kuzman\ProductFaq\Model\ResourceModel\Question\CollectionFactory $collectionFactory,
        \Kuzman\ProductFaq\Model\ResourceModel\QuestionId\CollectionFactory $collectionIdFactory,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->questionColFactory = $collectionFactory;
        $this->questionIdsColFactory = $collectionIdFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * Set grid params
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('product_question_grid');
        $this->setDefaultSort('question_id');
        $this->setUseAjax(true);

    }

    /**
     * Retirve currently edited product model
     *
     * @return \Magento\Catalog\Model\Product
     */
    public function getProduct()
    {
        return $this->_coreRegistry->registry('current_product');
    }

    /**
     * Retrieve product questions
     *
     * @return array
     */
    public function getSelectedProductQuestion()
    {
        $questions = [];
        $idsCollection = $this->questionIdsColFactory->create();
        $idsCollection->addFieldToFilter('product_id', $this->getProduct()->getId());
        foreach ($idsCollection as $question) {
            $questions[$question->getQuestionId()] = ['position' => $question->getPosition()];
        }
        return $questions;
    }

    /**
     * Add filter
     *
     * @param object $column
     * @return $this
     */
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in product flag
        if ($column->getId() == 'in_questions') {
            $questionIds = $this->_getSelectedQuestions();
            if (empty($questionIds)) {
                $questionIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('question_id', ['in' => $questionIds]);
            } else {
                if ($questionIds) {
                    $this->getCollection()->addFieldToFilter('question_id', ['nin' => $questionIds]);
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * Prepare collection
     *
     * @return \Magento\Backend\Block\Widget\Grid\Extended
     */
    protected function _prepareCollection()
    {
        $collection = $this->questionColFactory->create();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Get current product id
     *
     * @return null|int
     */
    public function getProductId()
    {
        $product = $this->_coreRegistry->registry('product');
        return $product ? $product->getId() : null;
    }

    /**
     * Retrieve selected upsell products
     *
     * @return array
     */
    protected function _getSelectedQuestions()
    {
        $questions = $this->getProductQuestion();
        if (!is_array($questions)) {
            $questions = array_keys($this->getSelectedProductQuestion());
        }
        return $questions;
    }

    /**
     * Rerieve grid URL
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->_getData(
            'grid_url'
        ) ? $this->_getData(
            'grid_url'
        ) : $this->getUrl(
            'productfaq/product/questionGrid',
            ['_current' => true]
        );
    }
    
    /**
     * Add columns to grid
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_questions',
            [
                'type' => 'checkbox',
                'name' => 'in_questions',
                'values' => $this->_getSelectedQuestions(),
                'align' => 'center',
                'index' => 'question_id',
                'header_css_class' => 'col-select',
                'column_css_class' => 'col-select'
            ]
        );
        $this->addColumn(
            'question_id',
            [
                'header' => __('ID'),
                'sortable' => true,
                'index' => 'question_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );
        $this->addColumn(
            'nickname',
            [
                'header' => __('Nickname'),
                'index' => 'nickname',
                'header_css_class' => 'col-name',
                'column_css_class' => 'col-name'
            ]
        );
        $this->addColumn(
            'question',
            [
                'header' => __('Question'),
                'index' => 'question',
                'header_css_class' => 'col-name',
                'column_css_class' => 'col-name'
            ]
        );
        $this->addColumn(
            'answer',
            [
                'header' => __('Answer'),
                'index' => 'answer',
                'header_css_class' => 'col-name',
                'column_css_class' => 'col-name'
            ]
        );
        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'header_css_class' => 'col-name',
                'column_css_class' => 'col-name'
            ]
        );
        $this->addColumn(
            'position',
            [
                'header' => __('Sort Order'),
                'name' => 'position',
                'type' => 'number',
                'validate_class' => 'validate-number',
                'index' => 'position',
                'editable' => true,
                'edit_only' => true,
                'header_css_class' => 'col-position',
                'column_css_class' => 'col-position',
            ]
        );

        return parent::_prepareColumns();
    }
}