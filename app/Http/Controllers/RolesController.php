<?php

namespace App\Http\Controllers;

use App\Contracts\RolesServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse as Response;

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
        return response()->json($this->rolesService->getRoles());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
