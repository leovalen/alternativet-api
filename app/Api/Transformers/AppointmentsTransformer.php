<?php

namespace Api\Transformers;

use App\Appointment;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class AppointmentsTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
    ];

    protected $defaultIncludes = [
    ];

    /**
     * @param Appointment $appointment
     * @return array
     */
    public function transform(Appointment $appointment)
    {
        $is_active = false;
        if ( $appointment->active_from <= Carbon::now() && $appointment->active_to > Carbon::now() )
        {
            $is_active = true;
        }
        return [
            'id'           => (int) $appointment->id,
            'name'         => $appointment->type->name,
            'forum'        => $appointment->type->forum,
            'organisation' => $appointment->organisation->name,
            'is_active'    => (bool) $is_active,
            'is_elected'   => (bool) $appointment->is_elected,
            'elected_at'   => $appointment->elected_at,
            'active_from'  => $appointment->active_from,
            'active_to'    => $appointment->active_to
        ];
    }

}