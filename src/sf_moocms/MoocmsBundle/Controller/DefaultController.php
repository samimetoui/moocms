<?php
namespace sf_moocms\MoocmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;

use sf_moocms\MoocmsBundle\Entity\Lesson;
use sf_moocms\MoocmsBundle\Entity\LessonSearch;
use sf_moocms\MoocmsBundle\Repository\LessonRepository;
use sf_moocms\MoocmsBundle\Entity\Topic;
use sf_moocms\MoocmsBundle\Form\LessonSearchType;

/**
* Classe Controleur de la section utilisateur
*/
class DefaultController extends Controller
{

  /**
  * Affiche tous les tutoriels (leçons)
  * @return display home page
  */
  public function lessonsAction(Request $request) {


    $search = new LessonSearch();
    $form = $this->createForm(LessonSearchType::class, $search);
    $form->handleRequest($request);

    $em = $this->getDoctrine()->getManager();
    // $lessons = $em->getRepository("MoocmsBundle:Lesson")->findAll(); /*->getLast(8);*/
    $topics = $em->getRepository(Topic::class)->findAll();

    // $query = $em->getRepository(Lesson::class)->findAllQuery();
    $query = $em->getRepository(Lesson::class)->findAllRequestedQuery($search);

    $paginator  = $this->get('knp_paginator');
    $pagination = $paginator->paginate($query,
       $request->query->getInt('page', 1), /*page number*/
        9 /*limit per page*/
    );

    return $this->render('MoocmsBundle:Default:index2.html.twig', array(
      // 'lessons' => $lessons,
      'topics' => $topics,
      'pagination' => $pagination,
      'form' => $form->createView()
    ));
  }

  /**
  * Affiche la liste de tutoriels (leçons) par catégorie
  * @param integer $id topic identifier
  * @return string Render list of tutorials view
  */
  // public function lessonsCategoryAction($id) {
  //   $em = $this->getDoctrine()->getManager();
  //   $lessons = $em->getRepository("MoocmsBundle:Lesson")->findBy(array(
  //     'topic' => $id
  //   ));
  //   $topics = $em->getRepository("MoocmsBundle:topic")->findAll();
  //   return $this->render('MoocmsBundle:Default:index.html.twig', array(
  //     'lessons' => $lessons,
  //     'topics' => $topics
  //   ));
  // }

  /**
  * Affiche un aperçu de la description du tutoriel (leçon)
  * @param $id lesson identifier
  * @return string Render lesson preview view
  */
  public function previewLessonAction($id) {
    $em = $this->getDoctrine()->getManager();
    $lesson = $em->getRepository("MoocmsBundle:Lesson")->find($id);
    return $this->render('MoocmsBundle:Default:lesson_preview.html.twig', array(
      'lesson' => $lesson,
    ));
  }

  /**
  * Affiche la page d'accueil du tutoriel (leçon)
  * @param $id lesson identifier
  * @return
  */
  public function followLessonAction($id) {
    $em = $this->getDoctrine()->getManager();
    $lesson = $em->getRepository("MoocmsBundle:Lesson")->find($id);
    $sequencesList = $em->getRepository("MoocmsBundle:Sequence")->getAllOrdered($lesson);
    return $this->render('MoocmsBundle:Default:lesson_follow.html.twig', array(
      'lesson' => $lesson,
      'sequencesList' => $sequencesList
    ));
  }

  /**
  * Affiche une séquence du tutoriel (leçon)
  * @param integer $id course identifier
  * @param integer $snum sequence number
  * @param string Render the sequence content
  */
  public function showLessonSequenceAction($id, $snum) {
    $em = $this->getDoctrine()->getManager();
    $lesson = $em->getRepository("MoocmsBundle:Lesson")->find($id); /* Charge la leçon */
    $seqRepoitory = $em->getRepository("MoocmsBundle:Sequence");
    $sequencesList = $seqRepoitory->getAllOrdered($lesson); /* charge les séquences dans l'ordre*/
    $nbSeq = $seqRepoitory->getNbForLesson($lesson); /* compte le nombre de séquence */
    $sequence =  $seqRepoitory->findOneBy(array('number' => $snum, 'lesson' => $lesson));
    if($sequence) {
      return $this->render('MoocmsBundle:Default:lesson_sequence_show.html.twig', array(
        'lesson' => $lesson,
        'sequence' => $sequence,
        'nbSeq' => $nbSeq,
        'sequencesList' => $sequencesList
      ));
    }
    throw new NotFoundHttpException();
  }

  /**
  * Affiche la page de fin de la leçon
  * @param integer $id lesson identifier
  * @return string render the finish lesson page
  */
  public function finishLessonAction($id) {
    $em = $this->getDoctrine()->getManager();
    $lesson = $em->getRepository("MoocmsBundle:Lesson")->find($id);
    return $this->render('MoocmsBundle:Default:lesson_finish.html.twig', array(
      'lesson' => $lesson
    ));
  }

  /**
  * Affiche tous les cours
  * @return string Display all courses view
  */
  public function coursesAction() {
    $em = $this->getDoctrine()->getManager();
    $courses = $em->getRepository("MoocmsBundle:Course")->findAll();
    $topics = $em->getRepository("MoocmsBundle:topic")->findAll();
    return $this->render('MoocmsBundle:Default:courses.html.twig', array(
      'courses' => $courses,
      'topics' => $topics
    ));
  }

  /**
  * Affiche les formations par catégories
  * @param integer $id course identifier
  * @return string courses list view for the selected topic
  */
  public function coursesCategoryAction($id){
    $em = $this->getDoctrine()->getManager();
    $courses = $em->getRepository("MoocmsBundle:Course")->findBy(array(
      'topic' => $id
    ));
    $topics = $em->getRepository("MoocmsBundle:topic")->findAll();
    return $this->render('MoocmsBundle:Default:courses.html.twig', array(
      'courses' => $courses,
      'topics' => $topics
    ));
  }

  /**
  * Affiche le resumé du cours
  * @param integer $id lesson identifier
  * @return string Render course preview
  */
  public function previewCourseAction($id) {
    $em = $this->getDoctrine()->getManager();
    $course = $em->getRepository("MoocmsBundle:Course")->find($id);
    $courseLessons = $em->getRepository("MoocmsBundle:CourseLesson")->findBy(
      array('course' => $course),
      array('position' => 'asc')
    );
    return $this->render('MoocmsBundle:Default:course_preview.html.twig', array(
      'course' => $course,
      'courseLessons' => $courseLessons
    ));

  }

  /**
  * Affiche la page d'accuil du cours avec les leçons (Formation + Tutoriels)
  * @param integer $id course id
  * @return Render the follow course views
  */
  public function followCourseAction($id){
    $em = $this->getDoctrine()->getManager();
    $course = $em->getRepository("MoocmsBundle:Course")->find($id);
    $courseLessonsList = $em->getRepository("MoocmsBundle:CourseLesson")->findBy(
      array('course' => $course),
      array('position' => 'asc')
    );
    return $this->render('MoocmsBundle:Default:course_follow.html.twig', array(
      'course' => $course,
      'courseLessonsList' => $courseLessonsList
    ));
  }

  /**
  * Affiche la page d'accueil du tutoriel (leçon) du cours
  * @param integer $cid course identifier
  * @param integer $lid lesson identifier
  * @param string Render the course lesson follow view
  */
  public function followCourseLessonAction($cid, $lid){

    $em = $this->getDoctrine()->getManager();
    $course = $em->getRepository("MoocmsBundle:Course")->find($cid);
    $courseLessonsList = $em->getRepository("MoocmsBundle:CourseLesson")->findBy(
      array('course' => $course),
      array('position' => 'asc')
    );
    $lesson = $em->getRepository("MoocmsBundle:Lesson")->find($lid);
    $sequencesList = $em->getRepository("MoocmsBundle:Sequence")->getAllOrdered($lesson);
    return $this->render('MoocmsBundle:Default:course_lesson_follow.html.twig', array(
      'lesson' => $lesson,
      'course' => $course,
      'courseLessonsList' => $courseLessonsList,
      'sequencesList' => $sequencesList
    ));
  }

  /**
  * Affiche une séquence de la leçon du cours
  * @param integer $cid course identifier
  * @param integer $lid lesson identifier
  * @param integer $snum sequence number
  * @return sring Display the sequence view
  */
  public function showCourseLessonSeqenceAction($cid, $lid, $snum){
    $em = $this->getDoctrine()->getManager();
    $course = $em->getRepository("MoocmsBundle:Course")->find($cid);
    $lesson = $em->getRepository("MoocmsBundle:Lesson")->find($lid); /* Charge la leçon */
    $sequencesList = $em->getRepository("MoocmsBundle:Sequence")->getAllOrdered($lesson); /* charge les séquences dans l'ordre*/
    $seqRepository = $em->getRepository("MoocmsBundle:Sequence");
    $nbSeq = $seqRepository->getNbForLesson($lesson); /* compte le nombre de séquence */
    $sequence =  $seqRepository->findOneBy(array('number' => $snum, 'lesson' => $lesson));
    /*$nbSeq = $sequence->cu;*/
    if($sequence) {
      return $this->render('MoocmsBundle:Default:course_lesson_sequence_show.html.twig', array(
        'lesson' => $lesson,
        'sequence' => $sequence,
        'nbSeq' => $nbSeq,
        'sequencesList' => $sequencesList,
        'course' => $course
      ));
    }
    throw new NotFoundHttpException();
  }

  /**
  * Affiche la page de fin de la leçon dans une formation 
  * @param integer $cid course identifier
  * @param integer $lid lesson identifier
  * @return string render the finish lesson page
  */
  public function finishCourseLessonAction($cid, $lid) {
    $em = $this->getDoctrine()->getManager();
    $course = $em->getRepository("MoocmsBundle:Course")->find($cid);
    $lesson = $em->getRepository("MoocmsBundle:Lesson")->find($lid);
    return $this->render('MoocmsBundle:Default:course_lesson_finish.html.twig', array(
      'course' => $course,
      'lesson' => $lesson
    ));
  }


  /**
  * Affiche l'activité de synthèse du tutoriel (leçon)
  * @param integer $cid course identifier
  * @param integer $lid lesson identifier
  * @param integer $id activity identifier
  * @return string display the activity view
  */
  public function lessonActivityShowAction($cid=null, $lid, $id){
    $em = $this->getDoctrine()->getManager();
    $activity = $em->getRepository("MoocmsBundle:Activity")->find($id);
    return $this->render('MoocmsBundle:Default:activity_show_lesson.html.twig', array(
      'cid' => $cid,
      'lid' => $lid,
      'activity' => $activity
    ));
  }

  /**
  * Affiche une activité au sein d'une séquence de cours
  * @param integer $cid course id
  * @param integer $lid lesson id
  * @param integer $snum sequence number (position)
  * @param integer $id activity id
  * @return string render activity view
  */
  public function sequenceActivityShowAction($cid=null, $lid=null, $snum=null, $id) {
    $em = $this->getDoctrine()->getManager();
    $activity = $em->getRepository("MoocmsBundle:Activity")->find($id);
    if ($cid != null) $course = $em->getRepository("MoocmsBundle:Course")->find($cid);
    if ($lid != null) {
      $lesson = $em->getRepository("MoocmsBundle:Lesson")->find($lid);
      $nbSeq = $em->getRepository("MoocmsBundle:Sequence")->getNbForLesson($lesson);
    } else {
      $nbSeq = null;
    }
    return $this->render('MoocmsBundle:Default:activity_show_sequence.html.twig', array(
      'cid' => $cid,
      'lid' => $lid,
      'snum' => $snum,
      'nbSeq' => $nbSeq,
      'activity' => $activity
    ));
  }

  /**
  * Affiche une activité seule
  * @param integer $id activity identifier
  * @return string Display activity view
  */
  public function activityShowAction($id){
    $em = $this->getDoctrine()->getManager();
    $activity = $em->getRepository("MoocmsBundle:Activity")->find($id);
    return $this->render('MoocmsBundle:Default:activity_show.html.twig', array(
      'activity' => $activity
    ));
  }

  /**
  *
  */
  public function forumAction() {
    return $this->render('MoocmsBundle:Default:forum.html.twig');
  }

  /**
  *
  */
  public function aboutAction() {
    return $this->render('MoocmsBundle:Default:about.html.twig');
  }

  /**
  *
  */
  public function dashboardAction() {
    return $this->render('MoocmsBundle:Default:dashboard.html.twig');
  }
}
