<?php

namespace Api\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'membership',
        'appointments'
    ];

    protected $defaultIncludes = [
        'membership'
    ];

    /**
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' 	                => (int) $user->id,
            'name' 	                => $user->name,
            'email'                 => $user->email,
            'address'               => $user->address,
            'postal_code'           => $user->postal_code,
            'phone_country_code'    => $user->phone_country_code,
            'phone'                 => $user->phone,
            'birth_date'            => $user->birth_date
        ];
    }

    public function includeMembership(User $user)
    {
        return $this->item($user->membership->first(), new MembershipTransformer);
    }

}