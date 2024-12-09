<?php

namespace App\Http\Controllers;

use App\Commands\Product\Handlers\ProductPurchaseCommandHandler;
use App\Commands\Product\Handlers\ProductRentCommandHandler;
use App\Commands\Product\ProductPurchaseCommand;
use App\Commands\Product\ProductRentCommand;
use App\Queries\Product\Handlers\ProductStatusQueryHandler;
use App\Queries\Product\ProductStatusQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function purchase(Request $request, $id): JsonResponse
    {
        $command = new ProductPurchaseCommand($id, $request->user()->id);
        $handler = new ProductPurchaseCommandHandler();

        $handler->handle($command);


        return response()->json([
            'message' => 'Product successfully purchased!',
            'status' => 200,
        ]);
    }

    public function rent(Request $request, $id): JsonResponse
    {
        $request->validate([
            'duration' => ['required', 'integer', Rule::in([4, 8, 12, 24])]
        ]);

        $command = new ProductRentCommand($id, $request->user()->id, $request->get('duration'));
        $handler = new ProductRentCommandHandler();

        $handler->handle($command);

        return response()->json([
            'message' => 'Product successfully rented!',
            'status' => 200,
        ]);
    }

    public function status(Request $request, $id): JsonResponse
    {
        $query = new ProductStatusQuery($request->user()->id, $id);
        $handler = new ProductStatusQueryHandler();

        return response()->json($handler->handle($query));
    }
}
