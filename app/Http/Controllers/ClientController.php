<?php

namespace App\Http\Controllers;

use App\Http\Resources\ClientResource;
use App\Support\ApiResponse;
use Illuminate\Http\Request;
use App\Services\ClientService;

class ClientController extends Controller
{
    public function __construct(
        private readonly ClientService $clientService
    )
    {
        
    }

    public function index(Request $request)
    {
        $paginate = $request->boolean('paginate');
        $pageNumber = $request->integer('page_number');
        $perPage = $request->integer('per_page');
        $name = $request->query('name');
        $status = $request->integer('status');
        $select = $request->boolean('select');

        $select = $select ? ['id', 'uuid', 'first_name', 'last_name', 'middle_name'] : [];

        $clients = $this->clientService->get([
            'name' => $name,
            'status' => $status
        ], $select, $paginate, $pageNumber, $perPage);

        if($paginate){
            return (new ApiResponse())->paginate('Success fetching clients', $clients);
        }

        $data = $select ? $clients : ClientResource::collection($clients);

        return (new ApiResponse())->success('Success fetching clients', ClientResource::collection($data));
    }
}
