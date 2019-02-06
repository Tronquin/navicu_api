<?php

namespace App\DataFixtures;

use App\Entity\OauthUser;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      
        // create 20 products! Bam!
        for ($i = 1; $i < 6; $i++) {
            $user = new OauthUser();
            $user->setCode($i);
            $user->setToken('d3f31afd5459a'.$i);
            $user->setExpiredAt(new \DateTime('2019-12-01'));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
