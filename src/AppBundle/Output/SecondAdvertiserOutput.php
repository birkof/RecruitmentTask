<?php

namespace AppBundle\Output;

use AppBundle\Entity\Offer;

/**
 * Class SecondAdvertiserOutput
 *
 * @package AppBundle\Output
 */
class SecondAdvertiserOutput implements OutputInterface
{
    /**
     * @param array $data
     *
     * @return Offer
     */
    public function process(array $data = [])
    {
        return (new Offer())
            ->setPlatform($data['app_details']['platform'])
            ->setApplicationId($data['app_details']['bundle_id'])
            ->setCountry($data['campaigns']['countries'][0])
            ->setPayout(round($data['campaigns']['points'] / 1000, 2)) // 1000 points = 1$
            ;
    }
}
