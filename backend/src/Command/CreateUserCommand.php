<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use InvalidArgumentException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserCommand extends Command
{
    private const INPUT_EMAIL = 'email';
    private const INPUT_PASSWORD = 'password';
    private const INPUT_FIRSTNAME = 'firstname';
    private const INPUT_LASTNAME = 'lastname';

    private ManagerRegistry $managerRegistry;

    private UserPasswordHasherInterface $encoder;

    public function __construct(ManagerRegistry $managerRegistry, UserPasswordHasherInterface $encoder)
    {
        parent::__construct();

        $this->managerRegistry = $managerRegistry;
        $this->encoder = $encoder;
    }

    protected function configure(): void
    {
        $this
            ->setName('database:user:create')
            ->setDescription('Create a user.')
            ->addArgument(self::INPUT_EMAIL, InputArgument::REQUIRED, 'The email')
            ->addArgument(self::INPUT_PASSWORD, InputArgument::REQUIRED, 'The password')
            ->addArgument(self::INPUT_FIRSTNAME, InputArgument::OPTIONAL, 'The firstname')
            ->addArgument(self::INPUT_LASTNAME, InputArgument::OPTIONAL, 'The lastname');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $newUser = new User();

        $email = strval($input->getArgument(self::INPUT_EMAIL));
        $newUser->setEmail($email);

        $firstname = strval($input->getArgument(self::INPUT_FIRSTNAME));
        $lastname = strval($input->getArgument(self::INPUT_LASTNAME));
        $newUser->setFirstName($firstname);
        $newUser->setLastName($lastname);

        $password = strval($input->getArgument(self::INPUT_PASSWORD));
        $encodedPassword = $this->encoder->hashPassword($newUser, $password);
        $newUser->setPassword($encodedPassword);

        $this->managerRegistry->getManager()->persist($newUser);
        $this->managerRegistry->getManager()->flush();
        $output->writeln(sprintf('Created User <comment>%s</comment>', $email));

        return 0;
    }

    protected function interact(InputInterface $input, OutputInterface $output): void
    {
        $questions = [];
        if (!$input->getArgument(self::INPUT_EMAIL)) {
            $questions[self::INPUT_EMAIL] = $this->createQuestion(
                'Please choose an email:',
                'Email can not be empty'
            );
        }
        if (!$input->getArgument(self::INPUT_PASSWORD)) {
            $questions[self::INPUT_PASSWORD] = $this->createQuestion(
                'Please choose a password:',
                'Password can not be empty',
                true
            );
        }
        foreach ($questions as $name => $question) {
            $answer = $this->getHelper('question')->ask($input, $output, $question);
            $input->setArgument($name, $answer);
        }
    }

    private function createQuestion(string $question, string $errorMessage, bool $isHidden = false): Question
    {
        $question = new Question($question);
        $question->setValidator(static function ($answer) use ($errorMessage) {
            if (null === $answer || '' === $answer) {
                throw new InvalidArgumentException($errorMessage);
            }

            return $answer;
        });
        $question->setHidden($isHidden);

        return $question;
    }
}