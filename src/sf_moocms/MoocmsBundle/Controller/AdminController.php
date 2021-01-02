<?php
namespace sf_moocms\MoocmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use sf_moocms\MoocmsBundle\Entity\Course;
use sf_moocms\MoocmsBundle\Entity\CourseLesson;
use sf_moocms\MoocmsBundle\Entity\Lesson;
use sf_moocms\MoocmsBundle\Entity\Activity;
use sf_moocms\UserBundle\Entity\User;
use sf_moocms\MoocmsBundle\Entity\Image;
use sf_moocms\MoocmsBundle\Entity\Sequence;
use sf_moocms\MoocmsBundle\Entity\Topic;
use sf_moocms\MoocmsBundle\Entity\Category;
use sf_moocms\MoocmsBundle\Form\CourseType;
use sf_moocms\MoocmsBundle\Form\LessonType;
use sf_moocms\MoocmsBundle\Form\SequenceType;
use sf_moocms\MoocmsBundle\Form\ActivityType;
use sf_moocms\MoocmsBundle\Form\UserType;
use sf_moocms\MoocmsBundle\Form\TopicType;
use sf_moocms\MoocmsBundle\Form\CategoryType;
use sf_moocms\MoocmsBundle\PDFService\PDFService;

/**
* Classe Controleur de la section d'administration
*/
class AdminController extends Controller {

  /**
  * Display students dashboar
  * @return string Render admin homepage
  */
  public function dashboardAction()
  {
    return $this->render('MoocmsBundle:Admin:index.html.twig');
  }

  /**
  * Display topics list by category
  * @return string Render topics list
  */
  public function topicsAction() {
    $em = $this->getDoctrine()->getManager();
    if($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
      $topics = $em->getRepository("MoocmsBundle:Topic")->findAll();
    }
    return $this->render('MoocmsBundle:Admin:topics.html.twig', array(
      'topics' => $topics,
    ));
  }

  /**
  * Add a new topic to database
  * @param Request
  * @return Topic
  */
  public function addTopicAction(Request $request){
    $em = $this->getDoctrine()->getManager();
    $topic = new Topic();
    $form = $this->createForm(TopicType::class, $topic);
    if ($form->handleRequest($request)->isValid()) {
      $em->persist($topic);
      $em->flush();
      return $this->redirect($this->generateUrl("moocms_topics"));
    }
    return $this->render("MoocmsBundle:Admin:topic_add.html.twig", array(
      'form' => $form->createView()
    ));
  }

  /**
  * Edit topic for update
  * @param Topic topic to edit
  * @param Request
  * @return Topic
  */
  public function editTopicAction(Topic $topic, Request $request){
    $em = $this->getDoctrine()->getManager();
    $form = $this->createForm(TopicType::class, $topic);
    if ($form->handleRequest($request)->isValid()) {
      $em->persist($topic);
      $em->flush();
      return $this->redirect($this->generateUrl("moocms_edit_topic", array(
        'id' => $topic->getId()
      )
    ));

    }
    return $this->render("MoocmsBundle:Admin:topic_edit.html.twig", array(
      'topic' => $topic,
      'form' => $form->createView()
    ));
  }

  /**
  * Remove a topic from database
  * @param Topic topic to be removed
  * @param Request
  * @return string Render Topics list
  */
  public function removeTopicAction(Topic $topic, Request $request){
    $em = $this->getDoctrine()->getManager();
    $em->remove($topic);
    $em->flush();
    return $this->redirect($this->generateUrl("moocms_topics"));
  }

  /**
  * Display categories list by category
  * @return string Render categories list
  */
  public function categoriesAction() {

    $em = $this->getDoctrine()->getManager();
    if($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
      $categories = $em->getRepository("MoocmsBundle:Category")->findAll();
    }
    return $this->render('MoocmsBundle:Admin:categories.html.twig', array(
      'categories' => $categories,
    ));
  }

  /**
  * Add a new category to database
  * @param Request
  * @return category
  */
  public function addCategoryAction(Request $request){
    $em = $this->getDoctrine()->getManager();
    $category = new Category();
    $form = $this->createForm(CategoryType::class, $category);
    if ($form->handleRequest($request)->isValid()) {
      $em->persist($category);
      $em->flush();
      return $this->redirect($this->generateUrl("moocms_categories"));
    }
    return $this->render("MoocmsBundle:Admin:category_add.html.twig", array(
      'form' => $form->createView()
    ));
  }

  /**
  * Edit category for update
  * @param Category to edit
  * @param Request
  * @return category
  */
  public function editCategoryAction(Request $request, Category $category){
    $em = $this->getDoctrine()->getManager();
    $form = $this->createForm(CategoryType::class, $category);
    if ($form->handleRequest($request)->isValid()) {
      $em->persist($category);
      $em->flush();
      return $this->redirect($this->generateUrl("moocms_edit_category", array(
        'id' => $category->getId()
      )
    ));
    }
    return $this->render("MoocmsBundle:Admin:category_edit.html.twig", array(
      'category' => $category,
      'form' => $form->createView()
    ));
  }

  /**
  * Remove a category from database
  * @param category to be removed
  * @param Request
  * @return string Render categories list
  */
  public function removeCategoryAction(Category $category, Request $request){
    $em = $this->getDoctrine()->getManager();
    $em->remove($category);
    $em->flush();
    return $this->redirect($this->generateUrl("moocms_categories"));
  }


  /**
  * Display current teacher course list
  * @return string Render admin course liste
  */
  public function coursesAction() {
    $em = $this->getDoctrine()->getManager();
    if($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
      $courses = $em->getRepository("MoocmsBundle:Course")->findAll();
    } else {
      $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $courses = $em->getRepository("MoocmsBundle:Course")->findBy(array('user' => $user->getId()));
    }
    return $this->render('MoocmsBundle:Admin:courses.html.twig', array(
      'courses' => $courses,
    ));
  }

  /**
  * Add a new course to the database
  * @param Request
  * @return string Render course add form
  * @return string Render admin courses list
  */
  public function addCourseAction(Request $request){
    $em = $this->getDoctrine()->getManager();
    $course = new Course();
    $form = $this->createForm(CourseType::class, $course);
    if ($form->handleRequest($request)->isValid()) {
      if ($course->getImage()) {
        $course->getImage()->upload(); /* Enregistre l'image */
      }   
      /* Enregistre le user */
      $user = $this->container->get('security.token_storage')->getToken()->getUser(); 
      $course->setUser($user);
      $em->persist($course);
      $em->flush();
      return $this->redirect($this->generateUrl("moocms_list_courses"));
    }
    return $this->render("MoocmsBundle:Admin:course_add.html.twig", array(
      'form' => $form->createView()
    ));
  }

  /**
  * Edit course for update or removal
  * @param Course course to edit
  * @param Request
  * @return string Display edit course form
  */
  public function editCourseAction(Course $course, Request $request){
    $em = $this->getDoctrine()->getManager();
    $form = $this->createForm(CourseType::class, $course);
    $courseLessons = $em->getRepository("MoocmsBundle:CourseLesson")->findBy(
      array('course' => $course->getId()),
      array('position' => 'asc')
    );
    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $lessons = $em->getRepository("MoocmsBundle:Lesson")->getNotUsedLessonsByUser($course, $user);
    if ($form->handleRequest($request)->isValid()) {
      if ($course->getImage()) {
        /* Enregistre l'image */
        $course->getImage()->upload();
      }
      /* Enregistre le user */
      $course->setUser($user);
      $em->persist($course);
      if($request->get('add_lesson')) {
        $lesson = new Lesson();
        $lesson_id = $request->get('lesson_id');
        $lesson = $em->getRepository("MoocmsBundle:Lesson")->find($lesson_id);
        $courseLesson = new CourseLesson();
        $courseLesson->setLesson($lesson);
        $courseLesson->setCourse($course);
        $position = $em->getRepository("MoocmsBundle:CourseLesson")->getNbForCourse($course);
        $courseLesson->setPosition($position + 1);
        $em->persist($courseLesson);
      }
      $em->flush();
      return $this->redirect($this->generateUrl("moocms_edit_course",
        array('id' => $course->getId())
      ));
    }
    return $this->render("MoocmsBundle:Admin:course_edit.html.twig", array(
      'form' => $form->createView(),
      'course' => $course,
      'courseLessons' => $courseLessons,
      'lessons' => $lessons
    ));
  }

  /**
  * Remove a course
  * @param Course course to be removed
  * @param Request
  * @return string Render admin courses list
  */
  public function removeCourseAction(Course $course, Request $request){
    $em = $this->getDoctrine()->getManager();
    $em->remove($course);
    $em->flush();
    return $this->redirect($this->generateUrl("moocms_list_courses"));
  }

  /**
  * Remove a lesson from course
  * @param integer CourseLesson id
  * @param Request
  * @return string Render edit course form
  */
  public function removeCourseLessonAction($id, Request $request){
    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $em = $this->getDoctrine()->getManager();
    $courseLesson = $em->getRepository("MoocmsBundle:CourseLesson")->find($id);
    if($courseLesson->getCourse()->getUser()<>$user) {
      throw new NotFoundHttpException();
    }
    $course_id = $courseLesson->getCourse()->getId();
    $em->getRepository("MoocmsBundle:CourseLesson")->update_positions($courseLesson);
    $em->remove($courseLesson);
    $em->flush();
    return $this->redirect($this->generateUrl("moocms_edit_course", array(
      'id' => $course_id
    )));
  }

  /**
  * Display current user tutorials (lessons) list
  * @return string Display admin tutorials (lessons) list
  */
  public function lessonsAction() {
    $em = $this->getDoctrine()->getManager();
    if($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
      $lessons = $em->getRepository("MoocmsBundle:Lesson")->findAll();
    } else {
      $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $lessons = $em->getRepository("MoocmsBundle:Lesson")->findBy(array('user' => $user->getId()));
    }
    return $this->render('MoocmsBundle:Admin:lessons.html.twig', array(
      'lessons' => $lessons,
    ));
  }

  /**
  * Add new lesson to database
  * @param Request
  * @return string Display add lesson form
  * @return string Redirect to admin lessons list
  */
  public function addLessonAction(Request $request){
    $em = $this->getDoctrine()->getManager();
    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $lesson = new Lesson();
    $form = $this->createForm(LessonType::class, $lesson, array(
      'user' => $user
    ));
    if ($form->handleRequest($request)->isValid()) {
      /* Enregistre l'image */
      $lesson->getImage()->upload();
      /* Enregistre le user */
      $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $lesson->setUser($user);
      $em->persist($lesson);
      $em->flush();
      return $this->redirect($this->generateUrl("moocms_list_lessons"));
    }
    return $this->render("MoocmsBundle:Admin:lesson_add.html.twig", array(
      'form' => $form->createView()
    ));
  }

  /**
  * Edit the lesson for update or removal
  * @param Lesson to edit
  * @param Request
  * @return string display edit form
  */
  public function editLessonAction(Lesson $lesson, Request $request){
    $em = $this->getDoctrine()->getManager();
    if (true === $this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
      $user = $lesson->getUser();
    } else {
      $user = $this->container->get('security.token_storage')->getToken()->getUser();
    }
    $form = $this->createForm(LessonType::class, $lesson, array(
      'user' => $user
    ));
    if ($form->handleRequest($request)->isValid()) {
      /* Enregistre l'image */
      if ($lesson->getImage()) {
        $lesson->getImage()->upload();
      }
      $em->persist($lesson);
      $em->flush();
      return $this->redirect($this->generateUrl("moocms_edit_lesson", array(
        'id' => $lesson->getId(),
      )));
    }
    // On récupère la liste des séquences de cette leçon
    $listSequences = $em
    ->getRepository('MoocmsBundle:Sequence')
    ->findBy(array('lesson' => $lesson), array('number' => 'ASC'));

    return $this->render("MoocmsBundle:Admin:lesson_edit.html.twig", array(
      'id' => $lesson->getId(),
      'form' => $form->createView(),
      'lesson' => $lesson,
      'listSequences' => $listSequences
    ));
  }

  /**
  * Remove a tutorial (lesson) from database : warning this remove all attached sequences
  * @param Lesson to be removed
  * @param Request
  * @return string redirect to admin tutorials (lessons) list
  */
  public function removeLessonAction(Lesson $lesson, Request $request){
    $em = $this->getDoctrine()->getManager();
    $em->remove($lesson);
    $em->flush();
    return $this->redirect($this->generateUrl("moocms_list_lessons"));
  }

  /**
  * Export a lesson to PDF format for printing
  * @param Lesson to export
  * @param Request
  */
  public function exportLessonAction(Lesson $lesson, Request $request){
    $em = $this->getDoctrine()->getManager();
    $sequences = $em
    ->getRepository('MoocmsBundle:Sequence')
    ->findBy(array('lesson' => $lesson), array('number' => 'ASC'));
    $spdf = new PDFService();
    $spdf->generateLesson($lesson, $sequences);
    return;
  }

  /**
  * Edit a sequence of tutorial (lesson) for update
  * @param Sequence to edit
  * @return string Display edit sequence form
  */
  public function editSequenceAction(Request $request, Sequence $sequence){
    $em = $this->getDoctrine()->getManager();
    if (true === $this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
      $user = $sequence->getLesson()->getUser();	
    } else {
      $user = $this->container->get('security.token_storage')->getToken()->getUser();
    }
    $form = $this->createForm(SequenceType::class, $sequence, array(
      'user' => $user
    ));
    if ($form->handleRequest($request)->isValid()) {
      // $form->bind($request);
      /*if ($form->isValid()) {*/
        // $s = $form->getData();
        $em->persist($sequence);
        $em->flush();
        return $this->redirect($this->generateUrl("moocms_edit_sequence", array(
          'sequence' => $sequence,
          'id' => $sequence->getId()
        )));
        /*}*/
      }
      return $this->render("MoocmsBundle:Admin:sequence_edit.html.twig", array(
        'sequence' => $sequence,
        'id' => $sequence->getId(),
        'form' => $form->createView()
      ));
    }

  /**
  * Add new couse sequence
  * @param integer lesson id
  * @return string Display add sequence form
  * @return string Redirects to edit lesson form
  */
  public function addSequenceAction(Request $request, $id){
    $em = $this->getDoctrine()->getManager();
    $lesson = $em->getRepository('MoocmsBundle:Lesson')->find($id);
    if (true === $this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
      $user = $lesson->getUser();
    } else {
      $user = $this->container->get('security.token_storage')->getToken()->getUser();
    }
    $sequence = new Sequence();
    $form = $this->createForm(SequenceType::class, $sequence, array(
      'user' => $user
    ));
    
    if ($form->handleRequest($request)->isValid()) {
      $sequence->setLesson($lesson);
      $em->persist($sequence);
      $em->flush();
      return $this->redirect($this->generateUrl("moocms_edit_lesson", array(
        'id' => $id
      )));
    }
    return $this->render("MoocmsBundle:Admin:sequence_add.html.twig", array(
      'sequence' => $sequence,
      'form' => $form->createView(),
      'id' => $id
    ));
  }

  /**
  * Remove a tutorial (lesson) sequence
  * @param Sequence to remove
  * @param Request*
  * @return string Rediects to turorial (lesson) edit form
  */
  public function removeSequenceAction(Sequence $sequence, Request $request){
    $less_id = $sequence->getLesson()->getId();
    $em = $this->getDoctrine()->getManager();
    $em->remove($sequence);
    $em->flush();
    return $this->redirect($this->generateUrl("moocms_edit_lesson", array(
      'id' => $less_id
    )));
  }


  /**
  * Display the list of all activities
  * @return string Admin activities list
  */
  public function activitiesAction() {
    $em = $this->getDoctrine()->getManager();

    if($this->container->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
      $activities = $em->getRepository("MoocmsBundle:Activity")->findAll();
    } else {
      $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $activities = $em->getRepository("MoocmsBundle:Activity")->findBy(array('user' => $user->getId()));
    }
    return $this->render('MoocmsBundle:Admin:activities.html.twig', array(
      'activities' => $activities,
    ));
  }

  /**
  * Add  new activity
  * @param integer attached sequence id
  * @return string Render add activity form
  * @return string Redirect to attached sequence edit form (called from edit sequence form)
  * @return string Redirect to admin list of all activities
  */
  public function addActivityAction($sid = null, $lid = null, Request $request){
    $em = $this->getDoctrine()->getManager();
    $activity = new Activity();
    $form = $this->createForm(ActivityType::class, $activity);
    if ($form->handleRequest($request)->isValid()) {
      if ($activity->getDocument()) {
        /* Enregistre le document */
        $activity->getDocument()->upload();
      }
      /* Enregistre le user */
      $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $activity->setUser($user);
      $em->persist($activity);
      $em->flush();
      if($sid && $sid != null) {
        return $this->redirect($this->generateUrl("moocms_edit_sequence",  array('id' => $sid)));
      }
      if ($lid && $lid != null) {
        return $this->redirect($this->generateUrl("moocms_edit_lesson",  array('id' => $lid)));
      }
      return $this->redirect($this->generateUrl("moocms_activities"));
    }
    return $this->render("MoocmsBundle:Admin:activity_add.html.twig", array(
      /*'id' => $lesson->getId(),*/
      'form' => $form->createView()
    ));
  }

  /**
  * Edit an activity
  * @param Activity to edit
  * @param Request
  * @return string activity edit form
  */
  public function editActivityAction(Activity $activity, Request $request){
    $em = $this->getDoctrine()->getManager();
    $form = $this->createForm(ActivityType::class, $activity);
    if ($form->handleRequest($request)->isValid()) {
      if ($activity->getDocument()) {
        /* Enregistre le document */
        $activity->getDocument()->upload();
      }
      /* Enregistre le user */
      $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $activity->setUser($user);
      $em->persist($activity);
      $em->flush();
      return $this->redirect($this->generateUrl("moocms_edit_activity", array(
        'id' => $activity->getId(),
      )));
    }
    return $this->render("MoocmsBundle:Admin:activity_edit.html.twig", array(
      'id' => $activity->getId(),
      'form' => $form->createView(),
      'activity' => $activity
    ));
  }

  /**
  * Remove the lesso
  * @param Activity to remove
  * @param Request
  * @return string Dispay admin activities list
  */
  public function removeActivityAction(Activity $activity, Request $request){
    $em = $this->getDoctrine()->getManager();
    $em->remove($activity);
    $em->flush();
    return $this->redirect($this->generateUrl("moocms_activities"));
  }

  /**
  * Display users list
  * @return string Dispay users list
  */
  public function UsersAction(){
    $userManager = $this->get('fos_user.user_manager');
    $users = $userManager->findUsers();
    return $this->render('MoocmsBundle:Admin:users.html.twig', array(
      'users' => $users,
    ));
    return;
  }

  /**
  * Displays a form to edit an existing Users.
  *
  */
  public function editUserAction(User $user, Request $request) {
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();
      return $this->redirectToRoute('moocms_users');
    }
    return $this->render('MoocmsBundle:Admin:user_edit.html.twig', array(
      'id' => $user->getId(),
      'form' => $form->createView(),
    ));
  }

  /**
  * Add new user
  * @return string Dispay users list
  */
  public function addUserAction(Request $request){
    $user = new User();
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($user);
      $em->flush();
      return $this->redirectToRoute('moocms_users');
    }
    return $this->render('MoocmsBundle:Admin:user_add.html.twig', array(
      'id' => $user->getId(),
      'form' => $form->createView(),
    ));
  }

  /**
  * Try to generate unique filname
  * @return string
  */
  private function generateUniqueFileName()
  {
    /*md5() reduces the similarity of the file names generated by*/
    /*uniqid(), which is based on timestamps*/
    return md5(uniqid());
  }
}
