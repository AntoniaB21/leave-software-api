<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Teams;
use App\Entity\Tag;
use App\Entity\TagChild;
use App\Entity\OffRequest;
use App\Entity\ValidationTemplate;
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

 
        $manager->persist($team1);
        $manager->persist($team2);

        // // create admin user
        $adminUser = new User();
        $adminUser->setEmail('admin@yopmail.fr');
        $adminUser->setPlainPassword('azerty');
        $adminUser->setPassword(
            $this->userPasswordEncoder->encodePassword($adminUser, 'azerty')
        );
        $adminUser->setDateEntrance(new \DateTime('11 months ago'));
        $adminUser->setRoles(["ROLE_ADMIN"]);
        $adminUser->setTeams($team1);
        $adminUser->setDaysTaken(9);
        $adminUser->setDaysEarned(27.5);
        $adminUser->setDaysLeft(20.5);
        $manager->persist($adminUser);

        // créer tags et tags child
        $tag1 = new Tag();
        $tag1->setName('Types de contrats');
        $tag1->setSlug('types-de-contrats');

        $tag2 = new Tag();
        $tag2->setName('Types de congés');
        $tag2->setSlug('types-de-congés');

        $manager->persist($tag1);
        $manager->persist($tag2);

        $tagChild1 = new TagChild();
        $tagChild1->setName('Congés payés');
        $tagChild1->setSlug('conges-payes');
        $tagChild1->setDescription('lorem ipsum congés payés');
        $tagChild1->setMaxBalance(2.5);
        $tagChild1->setMeasureUnit('mois');
        $tagChild1->setTag($tag2);

        $tagChild2 = new TagChild();
        $tagChild2->setName('Congés RTT');
        $tagChild2->setSlug('conges-rtt');
        $tagChild2->setDescription('lorem ipsum congés rtt');
        $tagChild2->setMaxBalance(10);
        $tagChild2->setMeasureUnit('an');
        $tagChild2->setTag($tag2);

        $tagChild3 = new TagChild();
        $tagChild3->setName('Contrat à Durée Determinée (CDD)');
        $tagChild3->setSlug('contrat-a-duree-determinee');
        $tagChild3->setDescription('CDD');
        $tagChild3->setTag($tag1);

        $tagChild4 = new TagChild();
        $tagChild4->setName('Contrat à Durée Indeterminée (CDI)');
        $tagChild4->setSlug('contrat-a-duree-indeterminee');
        $tagChild4->setDescription('CDI');
        $tagChild4->setTag($tag1);

        $tagChild5 = new TagChild();
        $tagChild5->setName('Contrat en alternance');
        $tagChild5->setSlug('contrat-en-alternance');
        $tagChild5->setDescription('En alternance');
        $tagChild5->setTag($tag1);

        $manager->persist($tagChild3);
        $manager->persist($tagChild4);
        $manager->persist($tagChild5);
        $manager->persist($tagChild1);
        $manager->persist($tagChild2);

        // créer 4 users et les intégrer à la teams 2
        for ($i = 0; $i < 4; $i++) {
            $product = new User();
            $product->setEmail('user'.$i.'@yopmail.fr');
            $product->setPlainPassword('azerty');
            $product->setRoles(["ROLE_USER"]);
            $product->setPassword(
                $this->userPasswordEncoder->encodePassword($product, 'azerty')
            );
            $product->setDateEntrance(new \DateTime('9 months ago'));
            $product->setTeams($team2);
            $product->addTagItem($tagChild3);
            $product->setDaysTaken(10);
            $product->setDaysEarned(22.5);
            $product->setDaysLeft(12.5);
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
        $teamLeader->setTeams($team1);
        $manager->persist($teamLeader);

        // créer des off requests pour un autre user
        $userTookRequest = new User();
        $userTookRequest->setEmail('userAsked@yopmail.fr');
        $userTookRequest->setPlainPassword('azerty');
        $userTookRequest->setRoles(["ROLE_USER"]);
        $userTookRequest->setPassword(
            $this->userPasswordEncoder->encodePassword($userTookRequest, 'azerty')
        );
        $userTookRequest->setTeams($team2);
        $manager->persist($userTookRequest);

        $offRequest1 = new OffRequest();
        $offRequest1->setDateStart(new \Datetime('Monday next week'));
        $offRequest1->setDateEnd(new \Datetime('Thursday next week'));
        $offRequest1->setComments('Autre evenement familial');
        $offRequest1->setStatus('pending');
        $offRequest1->setUser($userTookRequest);

        $manager->persist($offRequest1);

        $offRequest2 = new OffRequest();
        $offRequest2->setDateStart(new \Datetime('Monday last week'));
        $offRequest2->setDateEnd(new \Datetime('Thursday last week'));
        $offRequest2->setComments('Evenement familial');
        $offRequest2->setStatus('accepted');
        $offRequest2->setUser($userTookRequest);

        $manager->persist($offRequest2);

        // NEXT : create validation template
        $validationTemplateIt = new ValidationTemplate();
        $validationTemplateIt->setTeam($team2);
        $validationTemplateIt->setMainValidator($teamLeader);
        $validationTemplateIt->setSecondValidator($adminUser);

        $manager->persist($validationTemplateIt);

        $manager->flush();
    }
}