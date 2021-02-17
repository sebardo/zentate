<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * Class EventController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class EventController
{
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * Add event
     *
     * This call add a new event with mandatory params like: name and schema.
     *
     * @Route("event", name="add_event", methods={"POST"})
     * @OA\RequestBody(
     *     description="Json request",
     *     required=true,
     *     @OA\JsonContent(
     *         type="string",
     *     )
     * )
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = (isset($data['name'])) ? $data['name'] : null;
        $schema = (isset($data['schema'])) ? $data['schema'] : null;

        if (empty($name) || empty($schema)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $event = $this->eventRepository->saveEvent($name, $schema);

        return new JsonResponse(['status' => 'success', 'message' => 'Event created!', 'id' => $event->getId()], Response::HTTP_CREATED);
    }

    /**
     * Get a event detail
     *
     * This call return a event detail.
     *
     * @Route("event/{id}", name="get_one_event", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $event = $this->eventRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $event->getId(),
            'name' => $event->getName(),
            'schema' => $event->getSchema()->getId(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Update a event
     *
     * This call modify a event data.
     *
     * @Route("event/{id}", name="update_event", methods={"PUT"})
     * @OA\RequestBody(
     *     description="Json request",
     *     required=true,
     *     @OA\JsonContent(
     *         type="string",
     *     )
     * )
     */
    public function update($id, Request $request): JsonResponse
    {
        $event = $this->eventRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $event->setName($data['name']);
        empty($data['schema']) ? true : $event->setSchema($data['schema']);

        $updatedEvent = $this->eventRepository->updateEvent($event);

        return new JsonResponse(['status' => 'success', 'message' => 'Event updated!', 'id' => $updatedEvent->getId()], Response::HTTP_OK);
    }

    /**
     * Delete a event
     *
     * @Route("event/{id}", name="delete_event", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $event = $this->eventRepository->findOneBy(['id' => $id]);

        $this->eventRepository->removeEvent($event);

        return new JsonResponse(['status' => 'success', 'message' => 'Event deleted!'], Response::HTTP_OK);
    }

    /**
     * List all events
     *
     * This call return all events.
     *
     * @Route("events", name="get_all_events", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $events = $this->eventRepository->findAll();
        $data = [];

        foreach ($events as $event) {
            $data[] = [
                'id' => $event->getId(),
                'name' => $event->getName(),
                'schema' => $event->getSchema()->getId(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

}
