<?php

namespace App\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

use Faker\Factory;

use sf_moocms\MoocmsBundle\Entity\Lesson;
use sf_moocms\MoocmsBundle\Entity\Course;
use sf_moocms\MoocmsBundle\Entity\Topic;
use sf_moocms\UserBundle\Entity\User;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
      $faker = Factory::create('fr_FR');

      for ($i = 0; $i < 5; $i++) {
        $user = new User();
        $user->setPassword(password_hash ( 'test123.' , PASSWORD_DEFAULT ));
        $user->setEnabled(true);
        $user->setEmailCanonical($faker->safeEmail());
        $user->setEmail($faker->safeEmail());
        $user->setUsernameCanonical($faker->firstName());
        $user->setUsername($faker->firstName());
        $user->setFirstname($faker->firstName());
        $user->setLastname($faker->lastName());
        if($i == 0) {
          $user->setRoles(array('ROLE_SUPER_ADMIN'));
          $user->setUsername('admin');
        }

        $arr_users[] = $user;
        $manager->persist($user);
      }

      for ($i = 0; $i < 5; $i++) {
        $topic = new Topic();
        $topic->setName($faker->words(1,true));
        $topic->setDescription($faker->sentences(3,true));

        $arr_topics[] = $topic;
        $manager->persist($topic);
      }


      for ($i = 0; $i < 40; $i++) {
          $lesson = new Lesson();
          $lesson->setName($faker->words(3,true));
          $lesson->setSummary($faker->sentences(3,true));
          $lesson->setPublished(true);
          $lesson->setPromote(true);
          $lesson->setPrerequisite($faker->sentences(2,true));
          $lesson->setLevel($faker->numberBetween(0,3));
          $lesson->setTopic($arr_topics[($i % 5)]);
          $lesson->setUser($arr_users[random_int(0,4)]);

          $arr_lessons[] = $lesson;
          $manager->persist($lesson);
      }

      for ($i = 0; $i < 5; $i++) {
          $course = new Course();
          $course->setTitle($faker->words(3,true));
          $course->setSummary($faker->sentences(3,true));
          $course->setGoals($faker->sentences(3,true));
          $course->setPrerequiste($faker->sentences(3,true));
          $course->setTopic($arr_topics[($i % 5)]);
          $course->setUser($arr_users[random_int(0,4)]);
      //     for($j = 0; $j < 5; $j++){
      //       $course->addCourseLesson($arr_lessons[$j+5*$i]);
      //       }                  

          $manager->persist($course);
      }

      $manager->flush();
    }
}