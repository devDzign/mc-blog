<?php

namespace App\DataFixtures;

use App\Entity\MicroPost;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private const USERS
        = [
            [
                'username' => 'mou_cha',
                'email'    => 'john_doe@doe.com',
                'password' => 'admin',
                'fullName' => 'John Doe',
                'roles'=> [User::ROLE_ADMIN]
            ],
            [
                'username' => 'yas_ikh',
                'email'    => 'rob_smith@smith.com',
                'password' => 'admin',
                'fullName' => 'Rob Smith',
                'roles'=> [User::ROLE_USER]
            ],
            [
                'username' => 'sam-ta',
                'email'    => 'marry_gold@gold.com',
                'password' => 'admin',
                'fullName' => 'Marry Gold',
                'roles'=> [User::ROLE_USER]
            ],
        ];

    private const POST_TEXT
        = [
            'Hello, how are you?',
            'It\'s nice sunny weather today',
            'I need to buy some ice cream!',
            'I wanna buy a new car',
            'There\'s a problem with my phone',
            'I need to go to the doctor',
            'What are you up to today?',
            'Did you watch the game yesterday?',
            'How was your day?',
        ];

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $this->loadUser($manager);
        $this->loadMicroPost($manager);

    }

    private function loadMicroPost(ObjectManager $manager)
    {
        for ($i = 0; $i <= 30; $i++) {
            $microPost = new MicroPost();
            $microPost->setText(self::POST_TEXT[rand(0,count(self::POST_TEXT)-1)]);
            $date = new \DateTime();
            $date->modify('-'.rand(0,10).' day');
            $microPost->setTime($date);
            $microPost->setUser($this->getReference(
                self::USERS[rand(0,count(self::USERS)-1)]['username']
            ));
            $manager->persist($microPost);
        }
        $manager->flush();
    }


    private function loadUser(ObjectManager $manager)
    {
        foreach (self::USERS as $userData) {
            $user = new User();
            $user->setUsername($userData['username']);
            $user->setFullName($userData['fullName']);
            $user->setEmail($userData['email']);

            $password = $this->encoder->encodePassword($user, $userData['password']);
            $user->setRoles($userData['roles']);
            $user->setPassword($password);
            $this->addReference($userData['username'], $user);

            $manager->persist($user);
            $manager->flush();
        }

    }

}
