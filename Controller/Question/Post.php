<?php
/**
 * @author  Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
namespace Kuzman\ProductFaq\Controller\Question;
use Magento\Framework\Controller\ResultFactory;

class Post extends \Magento\Framework\App\Action\Action
{
    /**
     * Question Factory
     *
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $questionFactory;

    /**
     * Generic session
     *
     * @var \Magento\Framework\Session\Generic
     */
    protected $questionSession;

    /**
     * @param \Kuzman\ProductFaq\Model\QuestionFactory $questionFactory
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Kuzman\ProductFaq\Model\QuestionFactory $questionFactory,
        \Magento\Framework\App\Action\Context $context
    ) {
        $this->questionFactory = $questionFactory;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $data = $this->getRequest()->getPostValue();
        try{
            $this->questionFactory->create()->setData($data)->save();
            $this->messageManager->addSuccess(__('You submitted your question for moderation.'));
        }catch (Exception $e){
            $this->messageManager->addSuccess(__('Error in submitting question.'));
        }
        $resultRedirect->setUrl($this->_redirect->getRedirectUrl());


        return $resultRedirect;
    }
}
