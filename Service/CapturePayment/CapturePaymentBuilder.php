<?php

declare(strict_types=1);

namespace Worldline\CreditCard\Service\CapturePayment;

use OnlinePayments\Sdk\Domain\CapturePaymentRequest;
use OnlinePayments\Sdk\Domain\CapturePaymentRequestFactory;

class CapturePaymentBuilder
{
    /**
     * @var CapturePaymentRequestFactory
     */
    private $capturePaymentRequestFactory;

    public function __construct(
        CapturePaymentRequestFactory $capturePaymentRequestFactory
    ) {
        $this->capturePaymentRequestFactory = $capturePaymentRequestFactory;
    }

    public function build(int $amount): CapturePaymentRequest
    {
        $capturePaymentRequest = $this->capturePaymentRequestFactory->create();
        $capturePaymentRequest->setAmount($amount);

        return $capturePaymentRequest;
    }
}
