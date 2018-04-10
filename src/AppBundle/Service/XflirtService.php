<?php

namespace AppBundle\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LogLevel;

/**
 * Class XflirtService
 *
 * @package AppBundle\Service
 */
class XflirtService
{
    use LoggerAwareTrait;

    const API_OFFER_ENDPOINT = '/advertiser/%d/offers';

    /** @var Client */
    private $apiClient;

    /**
     * XflirtService constructor.
     *
     * @param $apiClient
     */
    public function __construct(Client $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @param int $advertiserId
     *
     * @return mixed
     */
    public function getOffersForAdvertiser(int $advertiserId)
    {
        try {
            /** @var ResponseInterface $response */
            $response = $this->apiClient->get(sprintf(self::API_OFFER_ENDPOINT, $advertiserId));

            return $this->decodeJsonResponse($response);
        } catch (ClientException $e) {
            $data = json_decode($e->getResponse()->getBody(), true);
            $this->log(LogLevel::ERROR, 'Error response from Xflirt API', $data);
            throw new \RuntimeException('Error response from Xflirt API', null, $e);
        } catch (\Exception $e) {
            $this->log(LogLevel::ERROR, 'Error when making request to Xflirt API: '.$e->getMessage());
            throw new \RuntimeException('Error when making request to Xflirt API', null, $e);
        }
    }

    /**
     * @param ResponseInterface $response
     *
     * @return mixed
     */
    private function decodeJsonResponse(ResponseInterface $response)
    {
        $decodedResponse = json_decode($response->getBody(), true);

        // Check for decoding errors.
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \RuntimeException(
                sprintf(
                    'Error decoding JSON "%s" from string: %s',
                    json_last_error_msg(),
                    $response->getBody()
                )
            );
        }

        return $decodedResponse;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     *
     * @return void
     */
    protected function log($level, $message, array $context = [])
    {
        $this->logger->log($level, '[Xflirt API] '.$message, $context);
    }
}
