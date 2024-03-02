<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Validator;
use App\Skills;


class SkillsController extends Controller
{
    public function index(){
        $skill = Skills::all();

        if(count($skill) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $skill
            ],200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }

    public function show($id){
        $skill = Skills::find($id);

        if(!is_null($skill)){
            return response([
                'message' => 'Retrieve Skill Success',
                'data' => $skill
            ],200);
        }

        return response([
            'message' => 'Skill Not Found',
            'data' => null
        ],400);
    }

    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'skill_name'          => 'required',
        ]);

        if($validate->fails())
            return response (['message' => $validate->errors()],400);

        $skill = Skills::create($storeData);

        return response([
            'message' => 'Add Skill Success',
            'data' => $skill,
        ],200);
    }

    public function destroy($id){
        $skill = Skills::find($id);

        if(is_null($skill)){
            return response([
                'message' => 'Skill Not Found',
                'data' => null
            ],404);
        }

        if($skill->delete()){
            return response([
                'message' => 'Delete Skill Success',
                'data' => $skill,
            ],200);
        }
        
        return response([
            'message' => 'Delete Skill Failed',
            'data' => null,
        ],400);

    }

    public function update(Request $request, $id){
        $skill = Skills::find($id);
        if(is_null($skill)){
            return response([
                'message' => 'Skill Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'skill_name'          => 'required',
        ]);

        if($validate->fails())
        return response(['message' => $validate->errors()],400);

        $skill->skill_name       = $updateData['skill_name'];
       
        if($skill->save()){
            return response([
                'message' => 'Update Skill Success',
                'data' => $skill,
            ],200);
        }

        return response([
            'message' => 'Update Skill Failed',
            'data' => null
        ],400);
    }

}
