<?php

declare(strict_types=1);

namespace App\Controller;

use App\Course\Fetcher\CourseFetcherInterface;
use App\Course\Persister\CoursePersisterInterface;
use App\Entity\Course;
use App\File\Uploader\FileUploaderInterface;
use App\File\Uploader\Handler\FileHandler;
use App\Form\Type\CourseType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CourseController extends AbstractController
{
    public function __construct(
        private FileHandler $fileHandler,
        private FileUploaderInterface $fileUploader,
        private CoursePersisterInterface $coursePersister,
        private CourseFetcherInterface $courseFetcher,
    ) {
    }

    #[Route('/course', name: 'app_course')]
    public function index(Request $request): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('file')->getData();
            if (null !== $file) {
                $uploadedFilePath = $this->fileHandler->handle($file, $this->fileUploader);
                $course->setFilePath($uploadedFilePath);
            }

            $this->coursePersister->save($course, true);
            $this->addFlash('success', 'Course created successfully!');

            return $this->redirectToRoute('app_course_all');
        }

        return $this->render('course/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/courses/all', name: 'app_course_all')]
    public function all(): Response
    {
        $courses = $this->courseFetcher->fetchAllCourses();

        return $this->render('course/all.html.twig', [
            'courses' => $courses,
        ]);
    }

    #[Route('/courses/{id}', name: 'app_course_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $course = $this->courseFetcher->fetchCourse($id);

        if (null === $course) {
            throw $this->createNotFoundException('Course not found');
        }

        return $this->render('course/show.html.twig', [
            'course' => $course,
        ]);
    }

    #[Route('/courses/{id}/download', name: 'app_course_download', methods: ['GET'])]
    public function download(int $id): Response
    {
        $course = $this->courseFetcher->fetchCourse($id);

        if (null === $course || null === $course->getFilePath()) {
            throw $this->createNotFoundException('No file attached to this course.');
        }

        $filePath = $this->getParameter('kernel.project_dir') . '/public/uploads/' . $course->getFilePath();

        if (!file_exists($filePath)) {
            throw $this->createNotFoundException('File not found.');
        }

        return $this->file($filePath);
    }
}
