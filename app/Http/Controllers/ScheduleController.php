<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ScheduleDates;
use Illuminate\Http\Request;
use App\Transformers\JsonApiSerializer;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;

class ScheduleController extends Controller
{
  /**
   * Create Schedule
   *
   * @param Request $request
   * @param Schedule $schedule
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function create(Request $request, Schedule $schedule)
  {
    $columns = Schema::getColumnListing($schedule->getTable());
    $this->validate($request, [
      'title' => 'required',
      'description' => 'required',
      'events' => 'required|array',
      'events.*.date' => 'required|date|distinct',
    ]);
    $sched = $schedule->create($request->only($columns));
    $sched->dates()->createMany($request->events);
    return $this->created($schedule->with('dates')->find($sched->id));
  }

  /**
   * List Schedules
   *
   * @param Request $request
   * @param Schedule $schedule
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function collection(Request $request, ScheduleDates $schedule)
  {
    $perPage = $request->input('page.size');
    $schedules = $schedule->with('event');
    $response = $perPage
      ? $schedules->paginate($perPage)->setPageName('page[number]')
      : $schedules->get();

    $results = $this->transform(
      $response,
      new JsonApiSerializer(),
      'schedules'
    );

    return $results instanceof LengthAwarePaginator
      ? $this->jsonPaginate($results)
      : response()->json($results);
  }
}
