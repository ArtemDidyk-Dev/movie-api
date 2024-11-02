<?php
declare(strict_types=1);
namespace App\Service;

use App\Logger\TranslateLogger;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final readonly class TranslateApiClient implements TranslateApiClientInterface
{
    private FilesystemAdapter $cache;

    private const string SOURCE_LANG = 'en';
    private const string TARGET_LANG = 'uk-UK';
    private const int TTL = 604800;
    private string $host;
    private string $key;
    public function __construct(
        private HttpClientInterface $client,
        private ParameterBagInterface $parameterBag,
        private TranslateLogger $logger,
    ) {
        $this->cache = new FilesystemAdapter();
        $this->host = $this->parameterBag->get('translate_host');
        $this->key = $this->parameterBag->get('translate_key');
    }

    public function trans(string $text): string
    {
        $cacheKey = $this->generateCacheKey($text);
        $translatedText = $this->cache->get($cacheKey, function (ItemInterface $item) use ($text) {
            $item->expiresAfter(self::TTL);
            return $this->fetchTranslation($text);
        });

        $this->logTranslation($text, $translatedText, $cacheKey);

        return $translatedText;
    }

    private function generateCacheKey(string $text): string
    {
        return md5($text . self::SOURCE_LANG . self::TARGET_LANG);
    }

    private function fetchTranslation(string $text): string
    {
        $response = $this->client->request('POST', 'https://' . $this->host . '/v2', [
            'json' => [
                'q' => $text,
                'source' => self::SOURCE_LANG,
                'target' => self::TARGET_LANG,
                'format' => 'text',
            ],
            'headers' => [
                'Content-Type' => 'application/json',
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key' => $this->key,
            ],
        ]);

        $this->logger->log('API connection removed translated text', [
            'status_code' => $response->getStatusCode(),
            'response_body' => $response->getContent(false),
        ]);

        $data = json_decode($response->getContent(false), true, 512, JSON_THROW_ON_ERROR);
        return $data['data']['translations'][0]['translatedText'];
    }

    private function logTranslation(string $originalText, string $translatedText, string $cacheKey): void
    {
        $this->logger->log('Wash down the translation', [
            'text' => $originalText,
            'translation' => $translatedText,
            'source_lang' => self::SOURCE_LANG,
            'target_lang' => self::TARGET_LANG,
            'cache_key' => $cacheKey,
        ]);
    }
}
