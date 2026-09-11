<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer')
            ->latest();

        /*
        |--------------------------------------------------------------------------
        | FILTER EVENT
        |--------------------------------------------------------------------------
        */

        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date')) {
            $query->whereDate(
                'created_at',
                $request->date
            );
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER USER
        |--------------------------------------------------------------------------
        */

        if ($request->filled('user')) {
            $query->where('causer_id', $request->user);
        }


        $activities = $query
            ->paginate(25)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | DAFTAR USER UNTUK FILTER
        |--------------------------------------------------------------------------
        */

        $users = \App\Models\User::orderBy('name')
            ->get();


        return view(
            'activity-logs.index',
            compact(
                'activities',
                'users'
            )
        );
    }

    public function show(Activity $activity)
{
    $activity->load('causer');

    return response()->json([
        'id' => $activity->id,

        'event' => $activity->event,

        'description' => $activity->description,

        'user' => $activity->causer->name ?? 'System',

        'role' => $activity->causer
            ? ($activity->causer->getRoleNames()->first() ?? '-')
            : '-',

        'model' => class_basename(
            $activity->subject_type
        ),

        'subject_id' => $activity->subject_id,

        'subject_name' => $this->getSubjectName($activity),

        'created_at' => $activity->created_at
            ->format('d/m/Y H:i:s'),

        'properties' => $activity->properties,
    ]);
}

private function getSubjectName(Activity $activity)
{
    $properties = $activity->properties ?? [];

    $attributes =
        $properties['attributes']
        ?? [];

    $old =
        $properties['old']
        ?? [];

    $fields = [
        'name',
        'nama',
        'title',
        'invoice_number',
        'invoice_no',
        'payment_number',
        'payment_no',
        'code',
        'kode',
        'number',
        'nomor',
    ];

    foreach ($fields as $field) {

        if (
            isset($attributes[$field]) &&
            $attributes[$field] !== ''
        ) {
            return $attributes[$field];
        }

        if (
            isset($old[$field]) &&
            $old[$field] !== ''
        ) {
            return $old[$field];
        }
    }

    return class_basename(
        $activity->subject_type
    ) . ' #' . $activity->subject_id;
}
}