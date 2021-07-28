<?php

namespace App\Http\Controllers;

use App\Models\TrainingSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class TrainingScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trainingSchedules = TrainingSchedule::where('user_id', auth()->user()->id)->get();
        return $this->resOk($trainingSchedules, 200);
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
            'duration_weeks' => 'required',
            'goal_distance' => 'required',
            'start_date' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->resOk($validator->errors()->toJson(), 400);
        }

        $trainingSchedule = TrainingSchedule::create(array_merge(
            $validator->validated(),
            [
                'name' => $request->name,
                'duration_weeks' => $request->duration_weeks,
                'goal_distance' => $request->goal_distance,
                'start_date' => $request->start_date,
                'user_id' => auth()->user()->id
            ]
        ));

        return response()->json(
            $this->resOk($trainingSchedule, 201),
            201
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrainingSchedule  $trainingSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrainingSchedule $trainingSchedule, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'duration_weeks' => 'required',
            'goal_distance' => 'required',
            'start_date' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->resOk($validator->errors()->toJson(), 400);
        }

        $trainingSchedule = TrainingSchedule::find($id);

        $trainingSchedule->fill($request->all())->save();

        return $this->resOk($trainingSchedule, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainingSchedule  $trainingSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingSchedule $trainingSchedule, $id)
    {
        $trainingSchedule = TrainingSchedule::where('id', $id)->first();
        $trainingSchedule->delete();
        return $this->resOk(['message' => $id . ' deleted'], 204);
    }
}
