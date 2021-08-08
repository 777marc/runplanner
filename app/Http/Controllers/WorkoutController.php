<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Http\Resources\WorkoutResource;
use App\Services\CalcService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class WorkoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workouts = Workout::where('user_id', auth()->user()->id)
            ->with('workoutType')
            ->get();
        return $this->resOk(WorkoutResource::collection($workouts), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'duration' => 'required',
            'distance' => 'required',
            'pace' => 'required',
            'workout_type_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->resOk($validator->errors()->toJson(), 400);
        }

        $workout = Workout::create(array_merge(
            $validator->validated(),
            [
                'name' => $request->name,
                'duration' => $request->duration,
                'distance' => $request->distance,
                'workout_type_id' => $request->workout_type_id,
                'user_id' => auth()->user()->id,
                'pace' => CalcService::calculatePace(
                    $request->distance,
                    $request->duration
                )
            ]
        ));

        return $this->resOk($workout, 201);
    }

    public function view(Request $request, $id)
    {
        $workout = Workout::where('user_id', auth()->user()->id)
            ->where('id', $id)
            ->with('workoutType')
            ->first();
        if($workout) {
            return $this->resOk(new WorkoutResource($workout), 200);
        } 
        return $this->resOk([], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Workout  $workout
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'duration' => 'required',
            'distance' => 'required',
            'workout_type_id' => 'required',
            'pace' => 'required'
        ]);

        $workout = Workout::where('id', $id)->first();

        $workout->name = $request->name;
        $workout->duration = $request->duration;
        $workout->distance = $request->distance;
        $workout->pace = CalcService::calculatePace(
            $request->distance,
            $request->duration
        );
        $workout->workout_type_id = $request->workout_type_id;
        $workout->save();

        return $this->resOk($workout, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Workout  $workout
     * @return \Illuminate\Http\Response
     */
    public function destroy(Workout $workout, $id)
    {
        $workout = Workout::find($id);
        $workout->delete();
        return $this->resOk(['message' => $id . ' deleted'], 200);
    }
}
