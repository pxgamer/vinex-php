<?php

declare(strict_types=1);

namespace pxgamer\Vinex\Api;

use pxgamer\Vinex\Entity\Market as MarketEntity;
use function GuzzleHttp\json_decode;

/** @link https://docs.vinex.network/api_public_endpoint.html */
class Basic extends AbstractApi
{
    public function getServerTime(): int
    {
        $response = $this->adapter->get(sprintf('%s/v1/time', $this->endpoint));

        return json_decode($response)->time;
    }

    /** @return MarketEntity[] */
    public function getAllMarketInformation(): array
    {
        $response = $this->adapter->get(sprintf('%s/v2/markets', $this->endpoint));

        $market = json_decode($response);

        return array_map(function ($market) {
            return new MarketEntity($market);
        }, $market->data);
    }

    public function getSingleMarketInformation(string $marketSymbol): MarketEntity
    {
        $response = $this->adapter->get(sprintf('%s/v2/markets/%s', $this->endpoint, $marketSymbol));

        $market = json_decode($response);

        return new MarketEntity($market->data);
    }
}