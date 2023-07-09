<?php

declare(strict_types=1);

namespace App\Command;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadFixturesCommand extends Command
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        parent::__construct('fixtures:load');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $loader = new Loader();
        $loader->loadFromDirectory(__DIR__ . '/../Fixture');

        $executor = new ORMExecutor($this->entityManager, new ORMPurger());
        $executor->execute($loader->getFixtures());

        return Command::SUCCESS;
    }
}
