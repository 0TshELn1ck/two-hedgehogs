<?php

namespace AppBundle\Command;

use AppBundle\Entity\Personal;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddAdminCommand extends ContainerAwareCommand
{

    private $entityManager;

    protected function configure()
    {
        $this
            ->setName('app:add-admin')
            ->setDescription('Create admin')
            ->addArgument('password', InputArgument::OPTIONAL, 'The plain password of the new user');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->entityManager = $this->getContainer()->get('doctrine')->getManager();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->adminExistValidator();
        $plainPassword = $input->getArgument('password');
        $this->passwordValidator($plainPassword);
        $personal = new Personal();
        $personal->setEmail('admin@change.me');
        $personal->setRoles('ROLE_ADMIN');

        $encoder = $this->getContainer()->get('security.password_encoder');
        $encodedPassword = $encoder->encodePassword($personal, $plainPassword);
        $personal->setPassword($encodedPassword);

        $this->entityManager->persist($personal);
        $this->entityManager->flush();
        $output->writeln(' "admin@change.me" created');
    }

    public function passwordValidator($plainPassword)
    {
        if (empty($plainPassword)) {
            throw new \Exception('The password can not be empty');
        }
        if (strlen(trim($plainPassword)) < 6) {
            throw new \Exception('The password must be at least 6 characters long');
        }
        return $plainPassword;
    }

    public function adminExistValidator()
    {
        $admin = $this->entityManager->getRepository('AppBundle:Personal')->findOneBy(array('email' => 'admin@change.me'));
        if ($admin) {
            throw new \Exception('You can not create admin user. The user has already created');
        }
    }
}
