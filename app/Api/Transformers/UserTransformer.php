<?php

namespace Api\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /*
     * Available includes
     *
     * @var array $availableIncludes
     */
    protected $availableIncludes = [
        'membership',
        'appointments'
    ];

    /*
     * Default includes
     *
     * @var array $defaultIncludes
     */
    protected $defaultIncludes = [
        'membership',
        'appointments'
    ];

    /**
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' 	                => (int) $user->id,
            'uuid'                  => $user->uuid,
            'name' 	                => $user->name,
            'email'                 => $user->email,
            'address'               => $user->address,
            'postal_code'           => $user->postal_code,
            'phone_country_code'    => $user->phone_country_code,
            'phone'                 => $user->phone,
            'birth_date'            => $user->birth_date,
        ];
    }

    /**
     * @param User $user
     * @return \League\Fractal\Resource\Item|null
     */
    public function includeMembership(User $user)
    {
        if ( empty($user->membership->first())) return null;

        return $this->item($user->membership->first(), new MembershipTransformer);
    }

    /**
     * @param User $user
     * @return \League\Fractal\Resource\Collection
     */
    public function includeAppointments(User $user)
    {
        if ( $user->appointments->isEmpty() ) return null;

        return $this->collection($user->appointments, new AppointmentsTransformer);
    }
}