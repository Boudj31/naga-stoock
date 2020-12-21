<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @UniqueEntity(fields={"email"}, message="Adresse mail déjà utilisé")
 */
class UserCreateCommand extends Command
{
    protected static $defaultName = 'app:user:create';

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManagerInterface, UserRepository $userRepository)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->entityManagerInterface = $entityManagerInterface;
        $this->userRepository = $userRepository;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Créer un utilisateur')
            ->addArgument('email', InputArgument::REQUIRED, 'Le mail')
            ->addArgument('password', InputArgument::REQUIRED, 'Le mot de passe')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // On instancie les variables
        $io = new SymfonyStyle($input, $output);
        $email = $input->getArgument('email');
        $user = new User();

        // Ont récupère la saisie
        $user->setEmail($email);
        $user->setPassword(
            $this->passwordEncoder->encodePassword($user, $input->getArgument('password'))
        );

        // Ont persist les données
        $this->entityManagerInterface->persist($user);
        $this->entityManagerInterface->flush();

        $io->success(sprintf('Le compte a été créé avec succès : '. $email));

        return Command::SUCCESS;
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        // On instancie les questions
        $helper = $this->getHelper('question');
        $questions = [];

        // Question email
        if (!$input->getArgument('email')) {
            $question = new Question('Saisissez l\'adresse email : ');
            $question->setValidator(function ($email) {
                if (empty($email)) {
                    throw new \Exception("Entrer une adresse email valide");
                }

                return $email;
            });
            $questions['email'] = $question;
        }

        // Question password
        if (!$input->getArgument('password')) {
            $question = new Question('Saisissez un mot de passe : ');
            $question->setValidator(function ($password) {
                if (empty($password)) {
                    throw new \Exception("Le mot de passe ne peut pas être vide");
                }

                return $password;
            });
            $question->setHidden(true);
            $questions['password'] = $question;
        }

        // Parcours le tableaux questions
        foreach ($questions as $key => $question) {
            $answer = $helper->ask($input, $output, $question);
            $input->setArgument($key, $answer);
        }
    }
}
