<?php

declare(strict_types=1);

namespace Ahc\StrapiClientBundle\Client;

use Ahc\StrapiClientBundle\Entity\ResourceContentType;
use Ahc\StrapiClientBundle\Factory\ResourceContentTypeFactory;
use Ahc\StrapiClientBundle\Resource\Mapper;
use Ahc\StrapiClientBundle\Synchronization\Query;
use Psr\SimpleCache\CacheInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class BaseClient implements ClientInterface
{
    public const CACHE_KEY_CONTENT_TYPES = 'content_types';
    public const CACHE_KEY_CONTENT_MAP = 'content_map';

    protected HttpClientInterface $httpClient;
    protected CacheInterface $cache;

    public function __construct(
        HttpClientInterface $httpClient,
        CacheInterface $cache
    ) {
        $this->httpClient = $httpClient;
        $this->cache = $cache;
        $this->generateContentTypes();
    }

    /** @return mixed[] */
    public function getWithQuery(Query $query): array
    {
        return $this->callApi($query);
    }

    /** @return mixed[] */
    protected function getContentTypes(bool $onlyApplication = true, int $limit = 150): array
    {
        $query = new Query();

        $query
            ->contentType('content-manager')
            ->addSubType('content-types')
            ->setLimit($limit)
        ;

        $componentTypes = $this->callApi($query)['data'];

        if (true === $onlyApplication) {
            $componentTypes = $this->removePlugins($componentTypes);
        }

        return $componentTypes;
    }

    /**
     * @return mixed[]|null
     */
    protected function getContentType(string $uid): ?array
    {
        $query = new Query();

        $query
            ->contentType('content-manager')
            ->addSubType('content-types')
            ->addSubType($uid)
            ->setLimit(1)
        ;

        return $this->callApi($query)['data'];
    }

    /** @return mixed[] */
    protected function getComponents(string $uid): array
    {
        $query = new Query();

        $query
            ->contentType('content-manager')
            ->addSubType('explorer')
            ->addSubType($uid)
        ;

        return $this->callApi($query);
    }

    protected function isCached(string $key): bool
    {
        return $this->cache->has($key);
    }

    /** @return mixed */
    protected function getFromCache(string $key)
    {
        return $this->cache->get($key);
    }

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    protected function registerToCache(string $key, $value)
    {
        $this->cache->set($key, $value);

        return $value;
    }

    protected function getCacheKey(string $identifier, string $key = self::CACHE_KEY_CONTENT_TYPES): string
    {
        return str_replace(':', '?', sprintf('%s_%s', $key, $identifier));
    }

    protected function generateContentTypes(): void
    {
        if ($this->isCached(self::CACHE_KEY_CONTENT_TYPES)) {
            return;
        }

        $contentTypes = $this->getContentTypes();

        $rawContents = null;
        $generatedContents = null;

        // Get all raw contents inside content types
        foreach ($contentTypes as $contentType) {
            $rawContents = Mapper::mapResourceContent($contentType, $this->getComponents($contentType['uid']));

            foreach ($rawContents as $key => $rawContent) {
                $generatedContent = ResourceContentTypeFactory::create($rawContent);

                $generatedContents[$contentType['uid']][$key] = $generatedContent;
                $this->cacheMapSetContent($generatedContent);
            }
        }
        $this->registerToCache(self::CACHE_KEY_CONTENT_TYPES, $generatedContents);
    }

    protected function cacheMapSetContent(ResourceContentType $resourceContentType): void
    {
        $cacheKey = sprintf(
            '%s?%s?%s',
            self::CACHE_KEY_CONTENT_MAP,
            $resourceContentType->getContentProperties()->getSchema()->getCollectionName(),
            $resourceContentType->getSystemFields()->getId()
        );

        if (!$this->isCached($cacheKey)) {
            $this->registerToCache($cacheKey, $resourceContentType);
        }
    }

    protected function cacheMapGetContent(string $name, int $id): ?ResourceContentType
    {
        $cacheKey = sprintf('%s?%s?%s', self::CACHE_KEY_CONTENT_MAP, $name, $id);

        if ($this->isCached($cacheKey)) {
            return $this->getFromCache($cacheKey);
        }

        return null;
    }

    /** @return mixed[] */
    private function callApi(Query $query): array
    {
        return $this->httpClient->request('GET', $query->getQueryString())->toArray();
    }

    /**
     * @param mixed[] $contentTypes
     *
     * @return mixed[]
     */
    private function removePlugins(array $contentTypes): array
    {
        foreach ($contentTypes as $key => $contentType) {
            if ('plugins' === $this->uidType($contentType['uid'])) {
                unset($contentTypes[$key]);
            }
        }

        return $contentTypes;
    }

    private function uidType(string $uid): string
    {
        return current(explode('::', $uid));
    }
}
