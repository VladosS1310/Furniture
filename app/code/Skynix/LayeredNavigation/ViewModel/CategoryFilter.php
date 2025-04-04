<?php

namespace Skynix\LayeredNavigation\ViewModel;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Api\Data\CategoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\View\Asset\Repository as AssetRepository;
use Psr\Log\LoggerInterface;

class CategoryFilter implements ArgumentInterface
{
    /**
     * @var CategoryRepositoryInterface
     */
    protected CategoryRepositoryInterface $categoryRepository;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @var StoreManagerInterface
     */
    protected StoreManagerInterface $storeManager;
    private AssetRepository $assetRepository;

    /**
     * CategoryFilter constructor
     *
     * @param CategoryRepositoryInterface $categoryRepository
     * @param StoreManagerInterface $storeManager
     * @param AssetRepository $assetRepository
     * @param LoggerInterface $logger
     */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        StoreManagerInterface $storeManager,
        AssetRepository $assetRepository,
        LoggerInterface $logger
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->logger = $logger;
        $this->storeManager = $storeManager;
        $this->assetRepository = $assetRepository;
    }

    /**
     * Retrieve category from repository
     *
     * @param $categoryId
     * @return CategoryInterface|null
     */
    public function getCategory($categoryId): ?CategoryInterface
    {
        try {
            return $this->categoryRepository->get($categoryId);
        } catch (NoSuchEntityException $e) {
            $this->logger->error(
                $e->getMessage(),
                [
                    'category_id' => $categoryId,
                ]
            );

            return null;
        }
    }

    public function getPlaceholderImageUrl()
    {
        return $this->assetRepository->getUrl('images/NoCategoryImagePlaceholder.png');
    }
}
