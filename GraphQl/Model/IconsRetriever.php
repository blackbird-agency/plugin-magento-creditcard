<?php
declare(strict_types=1);

namespace Worldline\CreditCard\GraphQl\Model;

use Worldline\CreditCard\Model\Ui\PaymentIconsProvider;
use Worldline\PaymentCore\GraphQl\Model\PaymentIcons\IconsRetrieverInterface;

class IconsRetriever implements IconsRetrieverInterface
{
    /**
     * @var PaymentIconsProvider
     */
    private $iconProvider;

    public function __construct(PaymentIconsProvider $iconProvider)
    {
        $this->iconProvider = $iconProvider;
    }

    /**
     * @param string $code
     * @param string $originalCode
     * @param int $storeId
     * @return array
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getIcons(string $code, string $originalCode, int $storeId): array
    {
        $icons = $this->iconProvider->getIcons($storeId);

        return $this->getIconsDetails($icons);
    }

    /**
     * @param array $icons
     * @return array
     */
    private function getIconsDetails(array $icons): array
    {
        $iconsDetails = [];
        foreach ($icons as $icon) {
            $iconsDetails[] = [
                IconsRetrieverInterface::ICON_TITLE => $icon['title'],
                IconsRetrieverInterface::ICON_URL => $icon['url']
            ];
        }

        return $iconsDetails;
    }
}