<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuestionRepository;
use App\Service\MarkdownHelper;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    private $logger;
    private $isDebug;

    public function __construct(LoggerInterface $logger, bool $isDebug)
    {
        $this->logger = $logger;
        $this->isDebug = $isDebug;
    }


    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(QuestionRepository $questionRepository)
    {
//        $questions = $questionRepository->findBy(
//            [], # get all
//            ['askedAt' => 'DESC'] # order by column
//        );

        # Custom query
        $questions = $questionRepository->findAllAskedOrderedByNewest();

        return $this->render('question/homepage.html.twig', [
            'questions' => $questions
        ]);
    }


    /**
     * @Route("/questions/new")
     */
    public function new(EntityManagerInterface $entityManager)
    {
        $question = new Question();
        $question->setName('Missing pants')
            ->setSlug('missing-pants-' . rand(0, 1000))
            ->setQuestion('Description question');
        if (rand(1,10) > 5) {
            $question->setAskedAt(new \DateTime(sprintf('-%d days', rand(1, 100))));
        }
        $entityManager->persist($question);
        $entityManager->flush();
        return new Response(sprintf(
            'Hello id #%d with %s slug',
            $question->getId(),
            $question->getSlug(),
        ));
    }

    /**
     * @Route("/questions/{slug}", name="app_question_show")
     */
    public function show(Question $question)
    {
        if ($this->isDebug) {
            $this->logger->info('We are in debug mode!');
        }

//        $repository = $entityManager->getRepository(Question::class);
//        /** @var Question $question */
//        $question = $repository->findOneBy(['slug' => $slug]);
//        if (!$question) {
//            // Cette erreur ne sera visible que dans l'environnement de DEV
//            throw $this->createNotFoundException(sprintf("La question after le slug %s n'existe pas", $slug));
//        }

        $answers = [
            'Make sure your cat is sitting `purrrfectly` still 🤣',
            'Honestly, I like furry shoes better than MY cat',
            'Maybe... try saying the spell backwards?',
        ];

        return $this->render('question/show.html.twig', [
            'question' => $question,
            'answers' => $answers,
        ]);
    }
}
