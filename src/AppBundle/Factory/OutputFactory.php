<?php

namespace AppBundle\Factory;

use AppBundle\Output\FirstAdvertiserOutput;
use AppBundle\Output\SecondAdvertiserOutput;

/**
 * Class OutputFactory
 *
 * @package AppBundle\Factory
 */
class OutputFactory
{
    public static function build(array $data = [])
    {
        switch ($data['advertiser_id']) {
            case 1:
                return (new FirstAdvertiserOutput())->process($data);
                break;
            case 2:
                return (new SecondAdvertiserOutput())->process($data);
                break;
            default:
                return (new FirstAdvertiserOutput())->process($data);
                break;
        }
    }
}
