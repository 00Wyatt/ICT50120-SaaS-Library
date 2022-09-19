<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAuthorAPIRequest;
use App\Http\Requests\UpdateAuthorAPIRequest;
use App\Models\Author;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthorAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $authors = Author::all();
        return response()->json(
            [
                'status' => true,
                'message' => "Retrieved successfully.",
                'authors' => $authors
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAuthorAPIRequest $request
     * @return JsonResponse
     */
    public function store(StoreAuthorAPIRequest $request): JsonResponse
    {

        $validated = $request->validated();
        $validated['is_company'] = $validated['is_company'] ?? 0;

        /*  Option 1:  Move given name into blank family name.
         *
         *  If using this option, remove the Option 2 block
         *  and uncomment the code below
         */
        // if (!isset($validated['family_name']) ) {
        //     $validated['family_name'] = $validated['given_name'];
        //     $validated['given_name'] = null;
        // }


        /*  Option 2:  Move family name into blank given name.
         *
         *  If using this option, remove the Option 1 block
         *  and uncomment the code below
         */
        if (!isset($validated['given_name'])) {
            $validated['given_name'] = $validated['family_name'];
            $validated['family_name'] = null;
        }

        $author = Author::create($validated);

        return response()->json(
            [
                'success' => true,
                'message' => "Created successfully.",
                'data' => [
                    'authors' => $author,
                ],
            ],
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $author = Author::query()->where('id', $id)->get();

        $response = response()->json(
            [
                'status' => false,
                'message' => "Author Not Found",
                'authors' => null
            ],
            404  # Not Found
        );

        if ($author->count() > 0) {
            $response = response()->json(
                [
                    'status' => true,
                    'message' => "Retrieved successfully.",
                    'authors' => $author
                ],
                200  # Ok
            );
        }
        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(UpdateAuthorAPIRequest $request, int $id): \Illuminate\Http\Response
    {
        $validated = $request->validated();
        $author = Author::query()->where('id', $id)->get();
        $response = response()->json(
            [
                'status' => false,
                'message' => "Author Not Found",
                'authors' => null
            ],
            404  # Not Found
        );

        if ($author->count() > 0) {
            $validated['is_company'] = $validated['is_company'] ?? 0;
            if (!isset($validated['given_name'])) {
                $validated['given_name'] = $validated['family_name'];
                $validated['family_name'] = null;
            }

            $author->update($validated);
            $author->save();

            $response = response()->json(
                [
                    'status' => true,
                    'message' => "Retrieved successfully.",
                    'authors' => $author
                ],
                200  # Ok
            );
        }
        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
        return response()->error(404);

    }
}
