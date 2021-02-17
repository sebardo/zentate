<?php

namespace App\Controller;

use App\Entity\Schema;
use App\Repository\SchemaRepository;
use App\Service\ValidatorManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use OpenApi\Annotations as OA;

/**
 * Class SchemaController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class SchemaController
{
    private $schemaRepository;

    public function __construct(SchemaRepository $schemaRepository)
    {
        $this->schemaRepository = $schemaRepository;
    }

    /**
     * Add schema
     *
     * This call add a new schema with "label" mandatory params like.
     *
     * @Route("schema", name="add_schema", methods={"POST"})
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
        $validEntity = $validatorManager->validate($request, new Schema(), ['create']);
        if($validEntity instanceof JsonResponse) return $validEntity;

        //save entity
        $schema = $this->schemaRepository->saveSchema($validEntity);

        return new JsonResponse(['status' => 'success', 'message' => 'Schema created!', 'id' => $schema->getId()], Response::HTTP_CREATED);
    }

    /**
     * Get a schema detail
     *
     * This call return a schema detail.
     *
     * @Route("schema/{id}", name="get_one_schema", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $schema = $this->schemaRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $schema->getId(),
            'name' => $schema->getName(),
            'description' => $schema->getDescription(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * Update a schema
     *
     * This call modify a schema data.
     *
     * @Route("schema/{id}", name="update_schema", methods={"PUT"})
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
        $schema = $this->schemaRepository->findOneBy(['id' => $id]);

        //validation
        $validEntity = $validatorManager->validate($request, $schema);
        if($validEntity instanceof JsonResponse) return $validEntity;

        $updatedSchema = $this->schemaRepository->updateSchema($validEntity);

        return new JsonResponse(['status' => 'success', 'message' => 'Schema updated!', 'id' => $updatedSchema->getId()], Response::HTTP_OK);
    }

    /**
     * Delete a schema
     *
     * @Route("schema/{id}", name="delete_schema", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $schema = $this->schemaRepository->findOneBy(['id' => $id]);

        $this->schemaRepository->removeSchema($schema);

        return new JsonResponse(['status' => 'success', 'message' => 'Schema deleted!'], Response::HTTP_OK);
    }

    /**
     * List all schemas
     *
     * This call return all schemas.
     *
     * @Route("schemas", name="get_all_schemas", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $schemas = $this->schemaRepository->findAll();
        $data = [];

        foreach ($schemas as $schema) {
            $data[] = [
                'id' => $schema->getId(),
                'name' => $schema->getName(),
                'description' => $schema->getDescription(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

}
