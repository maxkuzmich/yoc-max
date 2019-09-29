<?php


namespace App\Command;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use App\Entity\City;
use App\Entity\Country;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;


class CreateEntity extends Command
{
// the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-entity';

    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Creates a new city.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to create a city...')
        ;
        $this
            // configure an argument
            ->addArgument('entityName', InputArgument::REQUIRED, 'The username of the user.')
            // ...
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'Entity Creator',
            '============',
            '',
        ]);

        // retrieve the argument value using getArgument()
        $output->writeln('Entity: '.$input->getArgument('entityName'));


        // the value returned by someMethod() can be an iterator (https://secure.php.net/iterator)
        // that generates and returns the messages with the 'yield' PHP keyword

        $entity=$input->getArgument('entityName');

        if($input->getArgument('entityName')=='city') {
            $output->writeln($this->createCity($output));
        }else{
            $output->writeln($this->createCountry($output));
        }

        // outputs a message followed by a "\n"
        $output->writeln('Whoa!');

        // outputs a message without adding a "\n" at the end of the line
        $output->write('You are about to ');
        $output->write('create a user.');
    }

    private function createCity($output)
    {
        $dataProviderUrl =$this->container->getParameter('data_provider');
        $json = file_get_contents($dataProviderUrl);
        $dataProvider=json_decode($json,true);
        $entityManager = $this->container->get('doctrine')->getManager();
        foreach($dataProvider as $cityItem)
        {
            $city = new City();
            $city->setName($cityItem['city_name']);
            $city->setTimezone($cityItem['timezone']);
            $city->setCountry($cityItem['country_code']);
            $city->setData(json_encode($cityItem['data']));
            // tell Doctrine you want to (eventually) save the Product (no queries yet)
            $entityManager->persist($city);
            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
            $output->writeln('City was add');
        }
    }

    private function createCountry($output)
    {
        $output->writeln('Country was add');
    }
}