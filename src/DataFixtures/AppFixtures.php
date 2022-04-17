<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Teams;
use App\Entity\Tag;
use App\Entity\TagChild;
use App\Entity\OffRequest;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder){
        $this->userPasswordEncoder = $userPasswordEncoder;

    }
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        // create teams
        $team1 = new Teams();
        $team1->setName('Direction');
        $team1->setSlug('direction');
        $manager->persist($team1);

        $team2 = new Teams();
        $team2->setName('IT');
        $team2->setSlug('it');
        // $manager->persist($team2);

        // create admin user
        $adminUser = new User();
        $adminUser->setEmail('admin@yopmail.fr');
        $adminUser->setPlainPassword('azerty');
        $adminUser->setPassword(
            $this->userPasswordEncoder->encodePassword($adminUser, 'azerty')
        );
        $adminUser->setRoles(["ROLE_ADMIN"]);
        $manager->persist($adminUser);

        // créer 4 users et les intégrer à la teams 2
        for ($i = 0; $i < 4; $i++) {
            $product = new User();
            $product->setEmail('user '.$i.'@yopmail.fr');
            $product->setPlainPassword('azerty');
            $product->setRoles(["ROLE_USER"]);
            $product->setPassword(
                $this->userPasswordEncoder->encodePassword($product, 'azerty')
            );
            

            $team2->addUser($product);
            $manager->persist($team2);
            $manager->persist($product);
        }

        // créer 1 team leader IT
        $teamLeader = new User();
        $teamLeader->setEmail('leaderIt@yopmail.fr');
        $teamLeader->setPlainPassword('azerty');
        $teamLeader->setRoles(["ROLE_MANAGER"]);
        $teamLeader->setPassword(
            $this->userPasswordEncoder->encodePassword($teamLeader, 'azerty')
        );
        $team1->addUser($teamLeader);
        $team1->addUser($adminUser);


        // créer des off requests pour un autre user
        $userTookRequest = new User();
        $userTookRequest->setEmail('leaderIt@yopmail.fr');
        $userTookRequest->setPlainPassword('azerty');
        $userTookRequest->setRoles(["ROLE_MANAGER"]);
        $userTookRequest->setPassword(
            $this->userPasswordEncoder->encodePassword($userTookRequest, 'azerty')
        );
        $team2->addUser($userTookRequest);

        $offRequest1 = new OffRequest();
        $offRequest1->setDateStart(new \Datetime('first day of next month'));
        $offRequest1->setDateEnd(new \Datetime('third day of next month'));
        $offRequest1->setComments('Evenement familial');
        $offRequest1->setComments('Evenement familial');
        $offRequest1->setUser($userTookRequest);

        $manager->persist($teamLeader);
        $manager->persist($team1);
        $manager->persist($team2);

        // créer tags et tags child
        $tag1 = new Tag();
        $tag1->setName('Types de contrats');
        $tag1->setSlug('types-de-contrats');

        $tag2 = new Tag();
        $tag2->setName('Types de congés');
        $tag2->setSlug('types-de-congés');

        $tagChild1 = new TagChild();
        $tagChild1->setName('Congés payés');
        $tagChild1->setSlug('conges-payes');
        $tagChild1->setDescription('lorem ipsum congés payés');
        $tagChild1->setMaxBalance(2.5);
        $tagChild1->setMeasureUnit('mois');

        $tagChild2 = new TagChild();
        $tagChild2->setName('Congés RTT');
        $tagChild2->setSlug('conges-rtt');
        $tagChild2->setDescription('lorem ipsum congés rtt');
        $tagChild2->setMaxBalance(10);
        $tagChild2->setMeasureUnit('an');

        $tag2->addTagChild($tagChild1);
        $tag2->addTagChild($tagChild2);

        $tagChild3 = new TagChild();
        $tagChild3->setName('Contrat à Durée Indeterminée (CDI)');
        $tagChild3->setSlug('contrat-a-duree-indeterminee');
        $tagChild3->setDescription('CDI');

        $tagChild3 = new TagChild();
        $tagChild3->setName('Contrat à Durée Determinée (CDD)');
        $tagChild3->setSlug('contrat-a-duree-determinee');
        $tagChild3->setDescription('CDD');

        $tagChild4 = new TagChild();
        $tagChild4->setName('Contrat en alternance');
        $tagChild4->setSlug('contrat-en-alternance');
        $tagChild4->setDescription('En alternance');

        $tag1->addTagChild($tagChild3);
        $tag1->addTagChild($tagChild4);

        $manager->persist($tagChild1);
        $manager->persist($tagChild2);
        $manager->persist($tagChild3);
        $manager->persist($tagChild4);

        $manager->persist($tag1);
        $manager->persist($tag2);


        $manager->flush();
    }
}