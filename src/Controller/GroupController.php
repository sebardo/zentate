<?php

namespace App\Controller;

use App\Entity\Group;
use App\Repository\GroupRepository;
use App\Service\ValidatorManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * Class GroupController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class GroupController
{
    private $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    /**
     * Add group
     *
     * This call add a new group with "label" mandatory params like.
     *
     * @Route("group", name="add_group", methods={"POST"})
     * @OA\RequestBody(
     *     description="Json request",
     *     required=true,
     *     @OA\JsonContent(
     *         type="string",
     *     )
     * )
     */
    public function add(Request $request, ValidatorManager $validatorManager): JsonResponse
    {
        //validation
        $validEntity = $validatorManager->validate($request, new Group(), ['create']);
        if($validEntity instanceof JsonResponse) return $validEntity;

        //save entity
        $group = $this->groupRepository->saveGroup($validEntity);

        return new JsonResponse(['status' => 'success', 'message' => 'Group created!', 'id' => $group->getId()], Response::HTTP_CREATED);
    }

    /**
     * Get a group detail
     *
     * This call return a group detail.
     *
     * @Route("group/{id}", name="get_one_group", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $group = $this->groupRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $group->getId(),
            'label' => $group->getLabel(),
            'displayedLabel' => $group->getDisplayedLabel(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Update a group
     *
     * This call modify a group data.
     *
     * @Route("group/{id}", name="update_group", methods={"PUT"})
     * @OA\RequestBody(
     *     description="Json request",
     *     required=true,
     *     @OA\JsonContent(
     *         type="string",
     *     )
     * )
     */
    public function update($id, Request $request, ValidatorManager $validatorManager): JsonResponse
    {
        $group = $this->groupRepository->findOneBy(['id' => $id]);

        //validation
        $validEntity = $validatorManager->validate($request, $group);
        if($validEntity instanceof JsonResponse) return $validEntity;

        $updatedGroup = $this->groupRepository->updateGroup($validEntity);

        return new JsonResponse(['status' => 'success', 'message' => 'Group updated!', 'id' => $updatedGroup->getId()], Response::HTTP_OK);
    }

    /**
     * Delete a group
     *
     * @Route("group/{id}", name="delete_group", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $group = $this->groupRepository->findOneBy(['id' => $id]);

        $this->groupRepository->removeGroup($group);

        return new JsonResponse(['status' => 'success', 'message' => 'Group deleted!'], Response::HTTP_OK);
    }

    /**
     * List all groups
     *
     * This call return all groups.
     *
     * @Route("groups", name="get_all_groups", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $groups = $this->groupRepository->findAll();
        $data = [];

        foreach ($groups as $group) {
            $data[] = [
                'id' => $group->getId(),
                'label' => $group->getLabel(),
                'displayedLabel' => $group->getDisplayedLabel(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

}
