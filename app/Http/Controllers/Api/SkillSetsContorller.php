<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Validator;
use App\SkillSets;


class SkillSetsContorller extends Controller
{
    public function index(){
        $skillsets = DB::table('skill_sets')
                ->join('candidates','candidates.id','=','skill_sets.candidate_id')
                ->join('skills','skills.id','=','skill_sets.skill_id')
                ->select('candidates.name','skills.name')
                ->get();

        if(count($skillsets) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $skillsets
            ],200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }

    public function show($id){
        $skillsets = SkillSets::find($id);

        if(!is_null($skillsets)){
            return response([
                'message' => 'Retrieve Skill Sets Success',
                'data' => $skillsets
            ],200);
        }

        return response([
            'message' => 'Skill Sets Not Found',
            'data' => null
        ],400);
    }

    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'candidate_id'     => 'required',
            'skill_id'         => 'required',
        ]);

        if($validate->fails())
            return response (['message' => $validate->errors()],400);

        $skillsets = SkillSets::create($storeData);

        $skillsets->unread = 1;

        return response([
            'message' => 'Add Skill Sets Success',
            'data' => $skillsets,
        ],200);
    }

    public function destroy($id){
        $skillsets = SkillSets::find($id);

        if(is_null($skillsets)){
            return response([
                'message' => 'Skill Sets Not Found',
                'data' => null
            ],404);
        }

        if($skillsets->delete()){
            return response([
                'message' => 'Delete Skill Sets Success',
                'data' => $skillsets,
            ],200);
        }
        
        return response([
            'message' => 'Delete Skill Sets Failed',
            'data' => null,
        ],400);

    }

    public function update(Request $request, $id){
        $skillsets = SkillSets::find($id);
        if(is_null($skillsets)){
            return response([
                'message' => 'Skill Sets Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'candidate_id'     => 'required',
            'skill_id'         => 'required',
        ]);

        if($validate->fails())
        return response(['message' => $validate->errors()],400);

        $skillsets->candidate_id     = $updateData['candidate_id'];
        $skillsets->skill_id         = $updateData['skill_id'];
       
        if($skillsets->save()){
            return response([
                'message' => 'Update Skill Sets Success',
                'data' => $skillsets,
            ],200);
        }

        return response([
            'message' => 'Update Skill Sets Failed',
            'data' => null
        ],400);
    }

}
