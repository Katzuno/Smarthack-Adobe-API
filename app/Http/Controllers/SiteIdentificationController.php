<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteIdentificationController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
    de adaugat pe langa token si path
     */
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
                ['json_edit' => json_encode($request->json_edit), 'token' => $request->token, 'path' => $request->path]
            ]);

            return response("", 201);
        }
        catch (\Illuminate\Database\QueryException $ex) {
            return response()->json($ex->getMessage());
        }
    }
    public function getSiteInfo(Request $request, $token)
    {
        try {
            $siteInfo = DB::table('version_history')
                ->where([
                    ['token', '=', $token],
                    ['path','=',$request->path]
                ])
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

    public function getAllVersions(Request $request, $token)
    {
        try {
            $siteInfo = DB::table('version_history')
                ->where([
                    ['token', '=', $token],
                    ['path', '=', $request->path]
                ])
                ->orderBy('updated_at', 'DESC')
                ->get();

            if (count($siteInfo)) {
                return response()->json($siteInfo);
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

    public function getVersionById($versionId)
    {
        try {
            $siteInfo = DB::table('version_history')
                ->where('id', '=', $versionId)
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
