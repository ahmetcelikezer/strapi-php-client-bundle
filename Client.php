<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle;

use Ahc\StrapiClientBundle\Client\BaseClient;
use Ahc\StrapiClientBundle\Entity\ResourceContentType;
use Ahc\StrapiClientBundle\Synchronization\Query;

class Client extends BaseClient
{
    public function getContentByQuery(Query $query): ?ResourceContentType
    {
        $content = current($this->getWithQuery($query));

        if (null === $query->getContentType()) {
            return null;
        }

        return $this->cacheMapGetContent($query->getContentType(), $content['id']);
    }

    /**
     * @return mixed[]|null
     */
    public function getContentByUid(string $uid): ?array
    {
        $cachedContentTypes = $this->getFromCache(self::CACHE_KEY_CONTENT_TYPES);

        if (null !== $cachedContentTypes && true === \array_key_exists($uid, $cachedContentTypes)) {
            return $cachedContentTypes[$uid];
        }

        $this->generateContentTypes();

        $cachedContentTypes = $this->getFromCache(self::CACHE_KEY_CONTENT_TYPES);
        if (true === \array_key_exists($uid, $cachedContentTypes)) {
            return $cachedContentTypes[$uid];
        }

        return null;
    }
}
