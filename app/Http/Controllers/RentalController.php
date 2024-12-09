<?php

namespace App\Http\Controllers;

use App\Commands\Rental\Handlers\RentalExtendCommandHandler;
use App\Commands\Rental\RentalExtendCommand;
use App\Models\Rental;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RentalController extends Controller
{
    public function extend(Request $request, $id): JsonResponse
    {
        $request->validate([
            'duration' => ['required', 'integer', Rule::in([4, 8, 12, 24])]
        ]);

        $command = new RentalExtendCommand($request->user()->id, $id, $request->get('duration'));
        $handler = new RentalExtendCommandHandler();

        $handler->handle($command);

        return response()->json([
            'message' => 'Rental extended successfully!',
            'status' => 200,
        ]);
    }
}
