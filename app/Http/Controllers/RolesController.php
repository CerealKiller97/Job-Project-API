<?php

namespace App\Http\Controllers;

use App\Contracts\RolesServiceInterface;
use App\DTO\CreateRole;
use App\Exceptions\EntityNotFoundException;
use App\Http\Requests\RoleRequest;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse as Response;
use Illuminate\Support\Facades\Log;

class RolesController extends Controller
{
    /**
     * @var RolesServiceInterface
     */
    private $rolesService;

    public function __construct(RolesServiceInterface $rolesService)
    {
        $this->rolesService = $rolesService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        $roles = $this->rolesService->getRoles();

        return response()->json($roles, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RoleRequest  $request
     * @return Response
     */
    public function store(RoleRequest $request): Response
    {
        try {
            $role = new CreateRole($request->validated());
            $this->rolesService->createRole($role);
            return response()->json(['message' => 'Successfully added new role.'], 201);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => 'Server error, please try later.'], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $id
     * @return Response
     */
    public function show(string $id): Response
    {
        try {
            $role = $this->rolesService->getRole($id);
            return response()->json($role, 200);
        } catch (ModelNotFoundException $exception) {
            Log::error($exception->getMessage());
            return  response()->json(['message' => $exception->getMessage()], 404);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => 'Server error, please try later.'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RoleRequest  $request
     * @param  string  $id
     * @return void
     */
    public function update(RoleRequest $request, string $id)
    {
        try {
            $this->rolesService->updateRole($id, new CreateRole($request->validated()));
            return response()->json(null, 204);
        } catch (ModelNotFoundException $exception) {
            Log::error($exception->getMessage());
            return  response()->json(['message' => $exception->getMessage()], 404);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => 'Server error, please try later.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return Response
     */
    public function destroy(string $id)
    {
        try {
            $this->rolesService->deleteRole($id);
            return response()->json(null, 204);
        } catch (EntityNotFoundException $exception) {
            Log::error($exception->getMessage());
            return  response()->json(['message' => $exception->getMessage()], 404);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json(['message' => 'Server error, please try later.'], 500);
        }
    }

    public function moderatorEmails(): Response
    {
        $emails = $this->rolesService->getModeratorEmails();

        return response()->json($emails, 200);
    }
}
