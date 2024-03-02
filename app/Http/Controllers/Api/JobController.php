<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Validator;
use App\Jobs;


class JobController extends Controller
{
    public function index(){
        $job = Jobs::all();

        if(count($job) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $job
            ],200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ],400);
    }

    public function show($id){
        $job = Jobs::find($id);

        if(!is_null($job)){
            return response([
                'message' => 'Retrieve Job Success',
                'data' => $job
            ],200);
        }

        return response([
            'message' => 'Job Not Found',
            'data' => null
        ],400);
    }

    public function store(Request $request){
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'job_name'          => 'required',
        ]);

        if($validate->fails())
            return response (['message' => $validate->errors()],400);

        $job = Jobs::create($storeData);

        return response([
            'message' => 'Add Job Success',
            'data' => $job,
        ],200);
    }

    public function destroy($id){
        $job = Jobs::find($id);

        if(is_null($job)){
            return response([
                'message' => 'Job Not Found',
                'data' => null
            ],404);
        }

        if($job->delete()){
            return response([
                'message' => 'Delete Job Success',
                'data' => $job,
            ],200);
        }
        
        return response([
            'message' => 'Delete Job Failed',
            'data' => null,
        ],400);

    }

    public function update(Request $request, $id){
        $job = Jobs::find($id);
        if(is_null($job)){
            return response([
                'message' => 'Job Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'job_name'          => 'required',
        ]);

        if($validate->fails())
        return response(['message' => $validate->errors()],400);

        $job->job_name       = $updateData['job_name'];
       
        if($job->save()){
            return response([
                'message' => 'Update Job Success',
                'data' => $job,
            ],200);
        }

        return response([
            'message' => 'Update Job Failed',
            'data' => null
        ],400);
    }

}
