<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Validator;
use App\Candidate;


class CandidateController extends Controller
{
    public function index(){
        $candidate = DB::table('candidates')
                    ->join('jobs','jobs.id','=','candidates.job_id')
                    ->join('skills','skills.id','=','candidates.skill_id')
                    ->select('candidates.*','jobs.job_name','skills.skill_name')
                    ->get();

        if(count($candidate) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $candidate
            ],200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }

    public function show($id){
        $candidate = Candidate::find($id);

        if(!is_null($candidate)){
            return response([
                'message' => 'Retrieve Candidate Success',
                'data' => $candidate
            ],200);
        }

        return response([
            'message' => 'Candidate Not Found',
            'data' => null
        ],400);
    }

    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'job_id'        => 'required',
            'name'          => 'required',
            'email'         => ['required', Rule::unique('candidates') , 'email:rfc,dns'],
            'phone'         => ['required', Rule::unique('candidates')],
            'year'          => 'required',
            'skill_id'      => 'required',
        ]);

        if($validate->fails())
            return response (['message' => $validate->errors()],400);

        $candidate = Candidate::create($storeData);

        return response([
            'message' => 'Add Candidate Success',
            'data' => $candidate,
        ],200);
    }

    public function destroy($id){
        $candidate = Candidate::find($id);

        if(is_null($candidate)){
            return response([
                'message' => 'Candidate Not Found',
                'data' => null
            ],404);
        }

        if($candidate->delete()){
            return response([
                'message' => 'Delete Candidate Success',
                'data' => $candidate,
            ],200);
        }
        
        return response([
            'message' => 'Delete Candidate Failed',
            'data' => null,
        ],400);

    }

    public function update(Request $request, $id){
        $candidate = Candidate::find($id);
        if(is_null($candidate)){
            return response([
                'message' => 'Candidate Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'job_id'        => 'required',
            'name'          => 'required',
            'email'         => ['required', Rule::unique('candidates')->ignore($candidate) , 'email:rfc,dns'],
            'phone'         => ['required', Rule::unique('candidates')->ignore($candidate)],
            'year'          => 'required',
            'skill_id'      => 'required',
        ]);

        if($validate->fails())
        return response(['message' => $validate->errors()],400);

        $candidate->job_id     = $updateData['job_id'];
        $candidate->name       = $updateData['name'];
        $candidate->email      = $updateData['email'];
        $candidate->phone      = $updateData['phone'];
        $candidate->year       = $updateData['year'];
        $candidate->skill_id       = $updateData['skill_id'];
       
        if($candidate->save()){
            return response([
                'message' => 'Update Candidate Success',
                'data' => $candidate,
            ],200);
        }

        return response([
            'message' => 'Update Candidate Failed',
            'data' => null
        ],400);
    }

}
