<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookAPIRequest;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BooksAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();

        $response = response()->json(
            [
                'status' => false,
                'message' => "No Books Found",
                'books' => null
            ],
            404  # Not Found
        );

        if ($books->count() > 0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => "Retrieved successfully.",
                    'data' => [
                        'books' => $books,
                    ],
                ],
                200
            );
        }
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAuthorAPIRequest $request
     * @return JsonResponse
     */
    public function store(StoreBookAPIRequest $request): JsonResponse
    {
        $validated = $request->validated(); // Get validated data
        $book = Book::create($validated); // Create the book

        return response()->json(
            [
                'success' => true,
                'message' => "Created successfully.",
                'data' => [
                    'books' => $book,
                ],
            ],
            200
        );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $book = Book::query()->where('id', $id)->get();

        $response = response()->json(
            [
                'status' => false,
                'message' => "Book Not Found",
                'books' => null
            ],
            404  # Not Found
        );

        if ($book->count() > 0) {
            $response = response()->json(
                [
                    'status' => true,
                    'message' => "Retrieved successfully.",
                    'books' => $book
                ],
                200  # Ok
            );
        }
        return $response;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
