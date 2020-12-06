<?php
// api/src/DataProvider/BlogPostCollectionDataProvider.php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Entity\Promo;
use App\Repository\PromoRepository;

final class PromoDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface
{
    private $promoRepository;

    public function __construct(PromoRepository $promoRepository)
    {
        $this->promoRepository = $promoRepository;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Promo::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null)
    {
        // Retrieve the blog post collection from somewhere
        $resourceClass = $this->promoRepository->findByArchive(false);
        return $resourceClass;
    }
}
