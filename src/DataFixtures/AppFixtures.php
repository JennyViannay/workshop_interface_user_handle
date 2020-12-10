<?php

namespace App\DataFixtures;

use App\Entity\TypeOfUser;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $typeOfUser = ['prestataire','entrepreneur'];
        $typeOfUserEntity = [];
        for ($i = 0; $i < 2; $i++) {
            $type = new TypeOfUser();
            $type->setName($typeOfUser[$i]);
            $manager->persist($type);
            $typeOfUserEntity[] = $type;
        }

        $admin = new User();
        $admin->setEmail('admin@gmail.com');
        $admin->setPassword($this->encoder->encodePassword($admin, 'password'));
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $presta = new User();
        $presta->setEmail('presta@gmail.com');
        $presta->setPassword($this->encoder->encodePassword($presta, 'password'));
        $presta->setRoles(['ROLE_PRESTATAIRE']);
        $presta->setTypeOfUser($typeOfUserEntity[0]);
        $manager->persist($presta);

        $pro = new User();
        $pro->setEmail('entrepreneur@gmail.com');
        $pro->setPassword($this->encoder->encodePassword($pro, 'password'));
        $pro->setRoles(['ROLE_ENTREPRENEUR']);
        $pro->setTypeOfUser($typeOfUserEntity[1]);
        $manager->persist($pro);
        
        $manager->flush();
    }
}
