<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEndUserRequest;
use App\Http\Requests\UpdateEndUserRequest;
use App\Http\Resources\Admin\EndUserResource;
use App\Models\EndUser;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EndUsersApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('end_user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EndUserResource(EndUser::all());
    }

    public function store(StoreEndUserRequest $request)
    {
        $endUser = EndUser::create($request->all());

        return (new EndUserResource($endUser))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EndUser $endUser)
    {
        abort_if(Gate::denies('end_user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EndUserResource($endUser);
    }

    public function update(UpdateEndUserRequest $request, EndUser $endUser)
    {
        $endUser->update($request->all());

        return (new EndUserResource($endUser))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EndUser $endUser)
    {
        abort_if(Gate::denies('end_user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $endUser->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
