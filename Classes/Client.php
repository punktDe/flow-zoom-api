<?php
declare(strict_types=1);

namespace PunktDe\Zoom\Api;

/*
 * (c) 2020 punkt.de GmbH - Karlsruhe, Germany - http://punkt.de
 * All rights reserved.
 */

use Neos\Flow\Annotations as Flow;
use Firebase\JWT\JWT;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Promise\PromiseInterface;
use PunktDe\Zoom\Api\Exception\ZoomApiConfigurationException;

class Client
{
    /**
     * @var string
     * @Flow\InjectConfiguration(path="clientId")
     */
    protected $clientId = '';

    /**
     * @var string
     * @Flow\InjectConfiguration(path="clientSecret")
     */
    protected $clientSecret = '';

    /**
     * @var string
     * @Flow\InjectConfiguration(path="baseUri")
     */
    protected $baseUri = '';

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @throws ZoomApiConfigurationException
     */
    public function initializeObject(): void
    {
        $this->validateConfiguration();

        $options = [
            'base_uri' => $this->baseUri . '/v2/',
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->generateJwtToken(),
                'User-Agent' => 'PunktDe SyliusApi/1.0',
                'Accept' => 'application/json',
            ]
        ];

        $this->httpClient = new HttpClient($options);
    }

    /**
     * @param string $url
     * @param mixed[] $body
     * @param string[] $files
     * @return PromiseInterface
     */
    public function postAsync(string $url, array $body, array $files = []): PromiseInterface
    {
        $options = ['json' => $body];
        foreach ($files as $key => $filePath) {
            $options['multipart'][] = [
                'name' => $key,
                'contents' => $filePath,
            ];
        }

        return $this->httpClient->requestAsync('POST', $url, $options);
    }

    /**
     * @param string $url
     * @param mixed[] $body
     * @return PromiseInterface
     */
    public function patchAsync(string $url, array $body): PromiseInterface
    {
        return $this->httpClient->patchAsync($url, ['json' => $body]);
    }

    /**
     * @param string $url
     * @param mixed[] $body
     * @return PromiseInterface
     */
    public function putAsync(string $url, array $body): PromiseInterface
    {
        return $this->httpClient->requestAsync('PUT', $url, ['body' => json_encode($body), 'headers' => [
            'Content-Type' => 'application/json'
        ]
        ]);
    }

    /**
     * @param string $url
     * @param mixed[] $queryParameters
     * @return PromiseInterface
     */
    public function getAsync(string $url, array $queryParameters = []): PromiseInterface
    {
        return $this->httpClient->requestAsync('GET', $url, ['query' => $queryParameters]);
    }

    /**
     * @param string $url
     * @return PromiseInterface
     */
    public function deleteAsync(string $url): PromiseInterface
    {
        return $this->httpClient->requestAsync('DELETE', $url);
    }

    /**
     * Get a client configuration option.
     *
     * These options include default request options of the client, a "handler"
     * (if utilized by the concrete client), and a "base_uri" if utilized by
     * the concrete client.
     *
     * @param string|null $option The config option to retrieve.
     *
     * @return mixed
     *
     * phpcs:disable
     */
    public function getConfig($option = null)
    {
        return $this->httpClient->getConfig($option);
    }

    /**
     * @throws ZoomApiConfigurationException
     */
    private function validateConfiguration(): void
    {
        $requiredSettingKeys = ['baseUri', 'clientSecret', 'clientId'];
        foreach ($requiredSettingKeys as $requiredSettingKey) {
            if (empty($this->$requiredSettingKey) || trim($this->$requiredSettingKey) === '') {
                throw new ZoomApiConfigurationException(sprintf('The required configuration setting %s for the Zoom API was not set or empty', $requiredSettingKey), 1572349688);
            }
        }
    }

    /**
     * @return string
     */
    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    protected function generateJwtToken(): string
    {
        $key = $this->clientSecret;
        $payload = [
            'iss' => $this->clientId,
            'exp' => time() + 60,
            'iat' => time()
        ];
        return JWT::encode($payload, $key);
    }
}
