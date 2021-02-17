<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Group;
use App\Entity\Schema;
use App\Entity\Seat;
use App\Repository\SeatRepository;
use App\Service\ValidatorManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * Class SeatController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class SeatController
{
    private $seatRepository;

    public function __construct(SeatRepository $seatRepository)
    {
        $this->seatRepository = $seatRepository;
    }

    /**
     * Add seat
     *
     * This call add a new seat with "label" mandatory params like.
     *
     * @Route("seat", name="add_seat", methods={"POST"})
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
        $validEntity = $validatorManager->validate($request, new Seat(), ['create']);
        if($validEntity instanceof JsonResponse) return $validEntity;

        //save entity
        $seat = $this->seatRepository->saveSeat($validEntity);

        return new JsonResponse(['status' => 'success', 'message' => 'Seat created!', 'id' => $seat->getId()], Response::HTTP_CREATED);
    }

    /**
     * Get a seat detail
     *
     * This call return a seat detail.
     *
     * @Route("seat/{id}", name="get_one_seat", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $seat = $this->seatRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $seat->getId(),
            'label' => $seat->getLabel(),
            'displayedLabel' => $seat->getDisplayedLabel(),
            'schema' => ($seat->getSchema() instanceof Schema) ? $seat->getSchema()->getId() : null,
            'group' => ($seat->getGroup() instanceof Group) ? $seat->getGroup()->getLabel() : null,
            'category' => ($seat->getCategory() instanceof Category) ? $seat->getCategory()->getId() : null,
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Update a seat
     *
     * This call modify a seat data.
     *
     * @Route("seat/{id}", name="update_seat", methods={"PUT"})
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
        $seat = $this->seatRepository->findOneBy(['id' => $id]);

        //validation
        $validEntity = $validatorManager->validate($request, $seat);
        if($validEntity instanceof JsonResponse) return $validEntity;

        $updatedSeat = $this->seatRepository->updateSeat($validEntity);

        return new JsonResponse(['status' => 'success', 'message' => 'Seat updated!', 'id' => $updatedSeat->getId()], Response::HTTP_OK);
    }

    /**
     * Delete a seat
     *
     * @Route("seat/{id}", name="delete_seat", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $seat = $this->seatRepository->findOneBy(['id' => $id]);

        $this->seatRepository->removeSeat($seat);

        return new JsonResponse(['status' => 'success', 'message' => 'Seat deleted!'], Response::HTTP_OK);
    }

    /**
     * List all seats
     *
     * This call return all seats.
     *
     * @Route("seats", name="get_all_seats", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $seats = $this->seatRepository->findAll();
        $data = [];

        foreach ($seats as $seat) {
            $data[] = [
                'id' => $seat->getId(),
                'label' => $seat->getLabel(),
                'displayedLabel' => $seat->getDisplayedLabel(),
                'schema' => $seat->getSchema()->getId(),
                'group' => $seat->getGroup()->getLabel(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

}
