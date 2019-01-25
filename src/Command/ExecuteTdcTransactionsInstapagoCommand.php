<?php

namespace App\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use App\Navicu\Handler\Main\ExecuteTdcTransactionInstapagoHandler;

class ExecuteTdcTransactionsInstapagoCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('navicu:web:executetdctransactionspre')
            ->addArgument('id',
                InputArgument::OPTIONAL,
                '0'
            )
            ->addArgument('amount',
                InputArgument::OPTIONAL,
                '0'
            )
            ->setDescription('Ejecucion en lote de transacciones incompletas pre-autorizadas')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        global $kernel;
        $container = $kernel->getContainer();

        $handler = new ExecuteTdcTransactionInstapagoHandler();
        $handler->processHandler();

        $response = $handler->getJsonResponseData();
    }
}
