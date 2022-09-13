<?php
declare(strict_types=1);

namespace Worldline\CreditCard\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Worldline\CreditCard\Gateway\Config\Config;
use Worldline\CreditCard\UI\ConfigProvider;
use Worldline\PaymentCore\Model\AvailableMethodChecker;

class PaymentMethodIsActive implements ObserverInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var AvailableMethodChecker
     */
    private $availableMethodChecker;

    public function __construct(
        Config $config,
        AvailableMethodChecker $availableMethodChecker
    ) {
        $this->config = $config;
        $this->availableMethodChecker = $availableMethodChecker;
    }

    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        /** @var \Magento\Payment\Model\Method\Adapter $methodInstance */
        $methodInstance = $observer->getMethodInstance();
        $quote = $observer->getQuote();
        if ($methodInstance === null
            || $quote === null
            || $methodInstance->getCode() !== ConfigProvider::CODE
            || !$this->config->isActive()
        ) {
            return;
        }

        $observer->getResult()->setIsAvailable(
            $this->availableMethodChecker->checkIsAvailable($this->config, $quote)
        );
    }
}
