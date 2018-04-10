<?php

namespace AppBundle\Output;

use AppBundle\Entity\Offer;

/**
 * Class FirstAdvertiserOutput
 *
 * @package AppBundle\Output
 */
class FirstAdvertiserOutput implements OutputInterface
{
    /**
     * @param array $data
     *
     * @return Offer
     */
    public function process(array $data = [])
    {
        return (new Offer())
            ->setPlatform($data['mobile_platform'])
            ->setName($data['name'])
            ->setApplicationId($data['mobile_app_id'])
            ->setCountry($data['countries'][0])
            ->setPayout($data['payout_amount'])
        ;
    }
}
