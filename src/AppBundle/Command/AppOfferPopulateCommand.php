<?php

namespace AppBundle\Command;

use AppBundle\Entity\Offer;
use AppBundle\Factory\OutputFactory;
use AppBundle\Service\XflirtService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AppOfferPopulateCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:offer:populate')
            ->setDescription('...')
            ->addArgument('advertiser_id', InputArgument::REQUIRED, 'Advertiser ID');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $advertiserId = (int)$input->getArgument('advertiser_id');

        try {
            // Extract offers from API endpoint.
            $offersFromXflirt = $this->getContainer()->get(XflirtService::class)->getOffersForAdvertiser($advertiserId);

            // No offers received.
            if (empty($offersFromXflirt)) {
                throw new \RuntimeException('No offers available to process.');
            }

            /** @var int $total */
            $totalProcessed = 0;

            /** @var EntityManagerInterface $entityManager */
            $entityManager = $this->getContainer()->get('doctrine')->getManager();

            // Process & Save each offer receive from API.
            foreach ($offersFromXflirt as $offerFromXflirt) {
                $currentOffer = OutputFactory::build($offerFromXflirt);

                // Skip it, if already exists.
                if (
                    $entityManager->getRepository(Offer::class)->findOneByApplicationId($currentOffer->getApplicationId()) instanceof Offer
                ) {
                    continue;
                }

                // Increase total processed offers.
                $totalProcessed++;

                $this->getContainer()->get('doctrine')->getManager()->persist($currentOffer);
            }

            // Save new offers into database.
            $this->getContainer()->get('doctrine')->getManager()->flush();

            // Show some colors to the world.
            $output->writeln(
                sprintf('<comment>Process ended successfully importing %d from %d offers.</comment>', $totalProcessed, count($offersFromXflirt))
            );
        } catch (\Exception $e) {
            // Show errors on screen.
            $output->writeln(sprintf('<error>Something went wrong: %s</error>', $e->getMessage()));
        }


    }

}
