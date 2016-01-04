<?php
/**
 * @author  Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
namespace Kuzman\ProductFaq\Block;
/**
 * Quiestion form block
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class Form extends \Magento\Framework\View\Element\Template
{
    /**
     * Catalog product model
     *
     * @var \Magento\Catalog\Api\ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param array $data
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        array $data = []
    ) {
        $this->logger = $logger;
        $this->productRepository = $productRepository;
        parent::__construct($context, $data);
    }

    /**
     * Get product info
     *
     * @return Product
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductInfo()
    {
        return $this->productRepository->getById(
            $this->getProductId(),
            false,
            $this->_storeManager->getStore()->getId()
        );
    }

    /**
     * Get question product post action
     *
     * @return string
     */
    public function getPostUrl()
    {
        return $this->getUrl(
            'productfaq/question/post'
        );
    }

    /**
     * Get product id
     *
     * @return int
     */
    protected function getProductId()
    {
        return $this->getRequest()->getParam('id', false);
    }
}