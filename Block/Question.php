<?php
/**
 * @author  Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
namespace Kuzman\ProductFaq\Block;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\View\Element\Template;

/**
 * Product Review Tab
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Question extends Template implements IdentityInterface
{
    const SORT_ORDER_ASC = 'ASC';
    
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry;

    /**
     * Review resource model
     *
     * @var \Kuzman\ProductFaq\Model\ResourceModel\Question\CollectionFactory
     */
    protected $questionColFactory;

    /**
     * @var \Kuzman\ProductFaq\Helper\Data
     */
    protected $helper;

    /**
     * @param Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Kuzman\ProductFaq\Model\ResourceModel\Question\CollectionFactory $collectionFactory
     * @param \Kuzman\ProductFaq\Helper\Data $helper
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Kuzman\ProductFaq\Model\ResourceModel\Question\CollectionFactory $collectionFactory,
        \Kuzman\ProductFaq\Helper\Data $helper,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        $this->questionColFactory = $collectionFactory;
        $this->helper = $helper;
        parent::__construct($context, $data);

        $this->setTabTitle();
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
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [\Kuzman\ProductFaq\Model\Question::CACHE_TAG];
    }

    /**
     * Set tab title
     *
     * @return void
     */
    public function setTabTitle()
    {
        $title = $this->getCollectionSize()
            ? __('FAQ %1', '<span class="counter">' . $this->getCollectionSize() . '</span>')
            : __('FAQ');
        $this->setTitle($title);
    }

    /**
     * Joined collection
     * @return array
     */
    public function getQuestionCollection()
    {
        if ($this->isEnabled()) {

            $collection = $this->questionColFactory->create();
            $questionCollection = $collection->joinedCollection($this->getProductId());
            return $questionCollection;
        }
    }
    /**
     * Show on frontend
     *
     * @return mixed
     */
    protected function isEnabled()
    {
        return $this->helper->getEnable();
    }
}