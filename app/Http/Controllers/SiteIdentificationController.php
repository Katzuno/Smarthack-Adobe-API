<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteIdentificationController extends Controller
{
    public function generateToken(Request $request)
    {
        try {
            $token = uniqid('adobe-');
            DB::table('sites')->insert([
                ['site' => $request->site, 'token' => $token]
            ]);
            return response()->json(['token' => $token]);
        }
        catch (\Illuminate\Database\QueryException $ex) {
            return response([], 400)->json($ex->getMessage());
        }
    }

    public function updateSite(Request $request)
    {
        try
        {
            DB::table('version_history')->insert([
                ['json_edit' => $request->json_edit, 'token' => $request->token]
            ]);

            return response("", 201);
        }
        catch (\Illuminate\Database\QueryException $ex) {
            return response([], 400)->json($ex->getMessage());
        }
    }
    public function getSiteInfo($token)
    {
        try {
            $siteInfo = DB::table('version_history')
                ->where('token', '=', $token)
                ->orderBy('updated_at', 'DESC')
                ->limit(1)
                ->get();

            if (count($siteInfo)) {
                return response()->json($siteInfo[0]);
            }
            else
            {
                return response([], 404);
            }
        }
        catch (\Illuminate\Database\QueryException $ex) {
            return response()->json($ex->getMessage());
        }
    }


}
