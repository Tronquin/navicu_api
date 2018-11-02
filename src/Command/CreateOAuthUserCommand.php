<?php

namespace App\Command;

use App\Entity\OAuthUser;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Registra un nuevo usuario para el consumo de la api
 *
 * @author Emilio Ochoa <emilioaor@gmail.com>
 */
class CreateOAuthUserCommand extends Command
{
    use ContainerAwareTrait;

    protected static $defaultName = 'navicu:oauth:create';

    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Crea un nuevo usuario para consumir la api')
            ->addArgument('code', InputArgument::REQUIRED, 'Codigo unico para este registro')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $code = $input->getArgument('code');

        $manager = $this->container->get('doctrine')->getManager();

        $user = $manager->getRepository(OAuthUser::class)->findOneBy(['code' => $code]);

        if ($user) {

            $io->error(sprintf('User code "%s" already exists', $code));

        } else {

            $user = new OAuthUser();
            $user->setCode($code);
            $user->generateToken();
            $user->setExpiredAt(new \DateTime('+1 year'));

            $manager->persist($user);
            $manager->flush();

            $io->success('User creation success');
            $io->writeln(sprintf('User: %s', $code));
            $io->writeln(sprintf('Expired at: %s', $user->getExpiredAt()->format('d-m-Y H:i:s')));
            $io->writeln(sprintf('Token: %s', $user->getToken()));
        }
    }
}
