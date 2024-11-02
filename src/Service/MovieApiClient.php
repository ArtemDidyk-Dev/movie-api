<?php
declare(strict_types=1);

namespace App\Service;

use App\Builder\MovieBuilder;
use App\Request\MovieRequest;
use App\Serializer\AccessGroup;
use App\Serializer\Mapper;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class MovieApiClient
{
    private const int TTL = 604800;

    private FilesystemAdapter $cache;
    private string $host;
    private string $key;

    public function __construct(
        private HttpClientInterface $client,
        private ParameterBagInterface $parameterBag,
        private MovieBuilder $builder,
        private Mapper $mapper,
        private LoggerInterface $logger,
    ) {
        $this->cache = new FilesystemAdapter();
        $this->host = $this->parameterBag->get('movie_host');
        $this->key = $this->parameterBag->get('movie_key');
    }

    public function getMovies(MovieRequest $request): array
    {
        $cacheKey = $this->generateCacheKey($request);

        return $this->cache->get($cacheKey, function (ItemInterface $item) use ($request, $cacheKey) {
            $item->expiresAfter(self::TTL);
            $this->logger->info('API connection removed');

            return $this->fetchMovies($request);
        });

    }

    private function fetchMovies(MovieRequest $request): array
    {
        $response = $this->client->request('GET', 'https://'.$this->host.'/Filter', [
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->key,
            ],
            'query' => [
                'MinRating' => $request->minRating,
                'MaxRating' => $request->maxRating,
                'MinYear' => $request->minYear,
                'MaxYear' => $request->maxYear,
                'MinRevenue' => $request->minRevenue,
                'MaxRevenue' => $request->maxRevenue,
                'Genre' => $request->genre->value,
                'MinRuntime' => $request->minRuntime,
                'MaxRuntime' => $request->maxRuntime,
                'Limit' => $request->limit,
            ],
        ]);

        $content = $response->getContent();
        $result = json_decode($content, true);

        return $this->builder->buildFromApi($result);

    }

    private function generateCacheKey(MovieRequest $request): string
    {

        $string = json_encode($request, JSON_THROW_ON_ERROR);

        return md5($string);
    }


}
