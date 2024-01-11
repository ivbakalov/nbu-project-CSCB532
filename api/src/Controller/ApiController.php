<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Survey;
use App\Entity\TextEntry;
use App\Entity\Variant;
use App\Entity\GroupTextMapping;
use InvalidArgumentException;
use Exception;
use DateTimeImmutable;

#[Route(format: "json")]
class ApiController extends AbstractController
{
    private function initializeSurvey(User $user, EntityManagerInterface $entityManager): Survey
    {
        $variant = new Variant();
        $texts = $entityManager->getRepository(TextEntry::class)->findAll();
        $rand_keys = array_rand($texts, 8);
        shuffle($rand_keys);
        $variant->setText1($texts[$rand_keys[0]]);
        $variant->setText2($texts[$rand_keys[1]]);
        $variant->setText3($texts[$rand_keys[2]]);
        $variant->setText4($texts[$rand_keys[3]]);
        $variant->setText5($texts[$rand_keys[4]]);
        $variant->setText6($texts[$rand_keys[5]]);
        $variant->setText7($texts[$rand_keys[6]]);
        $variant->setText8($texts[$rand_keys[7]]);
        //TODO: maybe set these dynamically

        $survey = new Survey();
        $survey->setUser($user);
        $survey->setVariant($variant);

        for ($i = 0; $i <= 7; $i++) {
            $groupTextMapping = new GroupTextMapping();
            $groupTextMapping->setText($texts[$rand_keys[$i]]);
            $groupTextMapping->setSurvey($survey);
            $entityManager->persist($groupTextMapping);

            $survey->addGroupTextMapping($groupTextMapping);
        }

        $entityManager->persist($variant);
        $entityManager->persist($survey);
        $entityManager->flush();

        return $survey;
    }

    #[Route("/user", "create_user", methods: ["POST"])]
    public function createUser(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        try {
            $requestBody = json_decode($request->getContent(), true);

            $user = new User($requestBody["email"]);
            $user->setNativeLanguage($requestBody["nativeLanguage"]);

            $user->setCountry($requestBody["country"] ?? null);
            $user->setEnglishLevel($requestBody["englishLevel"] ?? null);
            $user->setGender($requestBody["gender"] ?? null);
            $user->setEducation($requestBody["education"] ?? null);
            $user->setInterestedInMoreInfo($requestBody["interestedInMoreInfo"] ?? null);

            $errors = $validator->validate($user);
            if(count($errors) > 0) {
                throw new InvalidArgumentException((string) $errors);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            $user->addSurvey($this->initializeSurvey($user, $entityManager));

            return $this->json($user, status: Response::HTTP_CREATED);
        } catch(Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    #[Route("/user/{email}", "read_user", methods: ["GET"])]
    public function readUser(User $user): JsonResponse
    {
        return $this->json($user, Response::HTTP_OK);
    }

    #[Route("/user/{user}/survey/{survey}", "update_survey", methods: ["PATCH"])]
    public function updateSurvey(Request $request, User $user, Survey $survey, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        try {
            $requestBody = json_decode($request->getContent(), true);

            if($survey->getUser() !== $user)
                throw new InvalidArgumentException('Survey not matching user!');
            if($survey->isCompleted())
                throw new InvalidArgumentException('Survey already completed!');
            if(count($requestBody["groupTextMappings"]) > 8)
                throw new InvalidArgumentException('Too many groupTextMappings!');

            foreach($requestBody["groupTextMappings"] as $mapping){
                $groupTextMapping = $entityManager->getRepository(GroupTextMapping::class)->find($mapping['id']);

                if(!$groupTextMapping)
                    throw new InvalidArgumentException('Invalid groupTextMapping id ' . $mapping['id'] . '!');
                if($groupTextMapping->getSurvey()->getId() !== $survey->getId())
                    throw new InvalidArgumentException('groupTextMapping ' . $mapping['id'] . ' is not for this survey!');
                if(isset($requestBody["completed"]) && $requestBody["completed"] === true && $mapping['textGroup'] === null)
                    throw new InvalidArgumentException('Survey cannot be completed with a null textGroup!');

                $groupTextMapping->setTextGroup($mapping['textGroup']);
                $errors = $validator->validate($groupTextMapping);
                if(count($errors) > 0) {
                    throw new InvalidArgumentException((string) $errors);
                }

                $entityManager->persist($groupTextMapping);
            }

            $survey->setCompleted($requestBody["completed"] ?? false);
            if(isset($requestBody["completed"])) {
                $survey->setFinishedOnDate($requestBody["completed"] ? new DateTimeImmutable() : null);
                $newSurvey = $this->initializeSurvey($user, $entityManager);
            }
            $entityManager->persist($survey);
            $entityManager->flush();

            return $this->json($user, Response::HTTP_OK);
        } catch(Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }
}
