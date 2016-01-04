<?php
/**
 * @author  Vladan Kuzmanovic (vladankuzmanovic@gmail.com)
 */
namespace Kuzman\ProductFaq\Observer;

use Magento\Framework\Event\ObserverInterface;

class SaveQuestions implements ObserverInterface
{
    /**
     * @var \Magento\Framework\App\RequestInterface
     */
    protected $request;

    /**
     * @var \Magento\Backend\Helper\Js
     */
    protected $jsHelper;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * QuestionId collection
     *
     * @var \Kuzman\ProductFaq\Model\ResourceModel\QuestionId\CollectionFactory
     */
    protected $questionIdsCol;

    protected $questionId;
    protected $question;
    /**
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Backend\Helper\Js $jsHelper
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Backend\Helper\Js $jsHelper,
        \Kuzman\ProductFaq\Model\ResourceModel\QuestionId\CollectionFactory $collectionIdFactory,
        \Kuzman\ProductFaq\Model\QuestionIdFactory $questionIdFactory,
        \Kuzman\ProductFaq\Model\QuestionFactory $questionFactory

    ) {
        $this->request = $request;
        $this->jsHelper = $jsHelper;
        $this->logger = $logger;
        $this->questionIdsCol = $collectionIdFactory;
        $this->questionId = $questionIdFactory;
        $this->question = $questionFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $productId = $this->request->getParam('id');
        $links = $this->request->getPost('links');
        $links = is_array($links) ? $links : [];

        if (isset($links['question'])) {

            $links['question'] = $this->jsHelper->decodeGridSerializedInput($links['question']);
            $idsCollection = $this->getIdsCollection();
            $idsCollection->addFieldToFilter('product_id', $productId);

            $questionIds=array();
            foreach ($idsCollection as $question) {
                $questionIds[] = $question->getQuestionId();
            }

            //update question position
            foreach($questionIds as $questionId){
                if(isset($links['question'][$questionId])) {
                    $idsCollection = $this->getIdsCollection();
                    $idsCollection->addFieldToFilter('question_id', $questionId);
                    $idsCollection->addFieldToFilter('product_id', $productId);
                    $item = $idsCollection->getFirstItem();
                    if ($item->getPosition() != $links['question'][$questionId]['position'] && !empty($links['question'][$questionId]['position'])) {
                        $item->setPosition($links['question'][$questionId]['position']);
                        $item->save();
                    }
                }
            }

            // save new checked questions and position
            $insert = array_diff(array_keys($links['question']),$questionIds);
            if(!empty($insert)) {
                foreach ($insert as $i) {
                    $questionIdModel = $this->questionId->create();
                    $questionIdModel->setProductId((int)$productId);
                    $questionIdModel->setQuestionId($i);
                    $questionIdModel->setPosition($links['question'][$i]['position']);
                    $questionIdModel->save();
                }
            }

            //delete unchecked Questions
            $delete = array_diff($questionIds,array_keys($links['question']));
            if(!empty($delete)) {
                $idsCollection = $this->getIdsCollection();
                $idsCollection->addFieldToFilter('product_id', $productId);
                $idsCollection->addFieldToFilter('question_id', ['in' => $delete]);
                foreach ($idsCollection as $item) {
                    $item->delete();
                }
            }
        }
    }

    /**
     * Get Collection Ids instance
     * @return collection
     */
    protected function getIdsCollection()
    {
        return $this->questionIdsCol->create();
    }
}