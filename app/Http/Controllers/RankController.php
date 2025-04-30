<?php

namespace App\Http\Controllers;

use App\Http\Requests\RankRequest;
use App\Models\Rank;
use Illuminate\Http\Request;

class RankController extends Controller
{
    public function index()
    {
        return response()->json(Rank::all(), 200);
    }

    public function store(RankRequest $request)
    {
        $rank = Rank::create($request->validated());

        return response()->json([
            'message' => 'Rank created successfully',
            'data' => $rank
        ], 201);
    }

    public function show($id)
    {
        $rank = Rank::find($id);

        if (!$rank) {
            return response()->json(['message' => 'Rank not found'], 404);
        }

        return response()->json($rank, 200);
    }

    public function update(RankRequest $request, $id)
    {
        $rank = Rank::find($id);

        if (!$rank) {
            return response()->json(['message' => 'Rank not found'], 404);
        }

        $rank->update($request->validated());

        return response()->json([
            'message' => 'Rank updated successfully',
            'data' => $rank
        ], 200);
    }

    public function destroy($id)
    {
        $rank = Rank::find($id);

        if (!$rank) {
            return response()->json(['message' => 'Rank not found'], 404);
        }

        $rank->delete();

        return response()->json(['message' => 'Rank deleted successfully'], 200);
    }
}
