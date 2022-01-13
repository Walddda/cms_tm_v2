<?php

namespace App\Controller;

use App\Entity\Origin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\TimeMachineEntry;
use App\Form\TimeMachineEntryType;
use App\Repository\OriginRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Form\FormTypeInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\TimeMachineEntryRepository;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class TimeMachineController extends AbstractController
{
    /**
     * @Route("/", name="time_machine")
     */
    public function index(TimeMachineEntryRepository $TimeMachineEntryRepository): Response
    {
        return $this->render('show.html.twig', [
            'data' => $TimeMachineEntryRepository->findAll(),
            'rand' => false,
        ]);
    }


    /**
     * @Route("/random", name="random", methods={"GET"})
     */
    public function random(TimeMachineEntryRepository $tmEntryRepository, EntityManagerInterface $entityManager): Response
    {
        $rows = $tmEntryRepository->findAll();
        $count = count($rows);
        $rand = rand(0, $count - 1);


        return $this->render('show.html.twig', [
            'data' => $tmEntryRepository->findBy(['id' => $rows[$rand]]),
            'rand' => true,
        ]);
    }

    /**
     * @Route("/addform", name="addform", methods={"GET"})
     */
    public function add(Request $request, EntityManagerInterface $entityManager, OriginRepository $originRepository)
    {
        // dd($originRepository->findAll());
        return $this->render('add.html.twig', [
            'origins' => $originRepository->findAll(),
            'originsJson' =>  $originRepository->findAll()
        ]);
    }

    /**
     * @Route("/add", name="add", methods={"POST"})
     */
    public function post(Request $request, EntityManagerInterface $entityManager)
    {
        // dd($request);
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $data = $request->getContent();

        $time_machine = $serializer->deserialize($data, timeMachineEntry::class, 'json');
        // dd($time_machine);

        $entityManager->persist($time_machine);
        $entityManager->flush();

        exit(\Doctrine\Common\Util\Debug::dump($data));

        return new JsonResponse(
            [
                'status' => 'ok',
            ],
            JsonResponse::HTTP_CREATED
        );
    }
    /**
     * @Route("/addOrigin", name="addOrigin", methods={"POST"})
     */
    public function postOrigin(Request $request, EntityManagerInterface $entityManager)
    {
        // dd($request);
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $data = $request->getContent();

        $origin = $serializer->deserialize($data, Origin::class, 'json');
        // dd($time_machine);

        $entityManager->persist($origin);
        $entityManager->flush();

        exit(\Doctrine\Common\Util\Debug::dump($data));

        return new JsonResponse(
            [
                'status' => 'ok',
            ],
            JsonResponse::HTTP_CREATED
        );
    }
    /**
     * @Route("/edit/{id}", name="edit", methods={"POST"})
     */
    public function editTm($id, TimeMachineEntryRepository $tmEntryRepository, Request $request, EntityManagerInterface $entityManager)
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);

        $data = $request->getContent();
        $current = $tmEntryRepository->find($id);

        $tm = $serializer->deserialize($data, TimeMachineEntry::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $current]);

        // dd($tm->getName());
        $current->setName($tm->getName());
        $current->setUrl($tm->getUrl());
        if ($tm->getOrigin() >= 0) {
            $current->setOrigin($tm->getOrigin());
        }
        // dd($request->getContent());
        // $encoders = [new XmlEncoder(), new JsonEncoder()];
        // $normalizers = [new ObjectNormalizer()];

        // $serializer = new Serializer($normalizers, $encoders);

        // $data = $request->getContent();

        // $time_machine = $serializer->deserialize($data, timeMachineEntry::class, 'json');
        // // dd($time_machine);

        // $entityManager->persist($time_machine);
        $entityManager->flush();

        exit(\Doctrine\Common\Util\Debug::dump($data));

        return new JsonResponse(
            [
                'status' => 'ok',
            ],
            JsonResponse::HTTP_CREATED
        );
    }

    /**
     * @Route("/edit/{id}", name="editPost", methods={"GET"})
     */
    public function edit($id, TimeMachineEntryRepository $tmEntryRepository, Request $request, EntityManagerInterface $entityManager, OriginRepository $originRepository)
    {
        // dd($originRepository->findAll());
        // dd($tmEntryRepository->findBy(['id' => $id]));
        return $this->render('edit.html.twig', [
            'entry' => $tmEntryRepository->findBy(['id' => $id])[0],
            'origins' => $originRepository->findAll(),
        ]);
    }

    /**
     * @Route("/delete", name="delete", methods={"POST"})
     */
    public function delete(Request $request, TimeMachineEntryRepository $tmEntryRepository, EntityManagerInterface $entityManager)
    {

        // dd($request->getContent());

        $ent = $tmEntryRepository->findBy(['id' => $request->getContent()])[0];

        if (!$ent) {
            throw $this->createNotFoundException('No guest found');
        }

        $entityManager->remove($ent);
        $entityManager->flush();

        // return $this->redirect($this->generateUrl('time_machine'));

        // dd($request);
        // $encoders = [new XmlEncoder(), new JsonEncoder()];
        // $normalizers = [new ObjectNormalizer()];

        // $serializer = new Serializer($normalizers, $encoders);

        // $data = $request->getContent();

        // $time_machine = $serializer->deserialize($data, timeMachineEntry::class, 'json');
        // // dd($time_machine);

        // $entityManager->persist($time_machine);
        // $entityManager->flush();

        // exit(\Doctrine\Common\Util\Debug::dump($data));

        return new JsonResponse(
            [
                'status' => 'ok',
            ],
            JsonResponse::HTTP_CREATED
        );
    }
}
