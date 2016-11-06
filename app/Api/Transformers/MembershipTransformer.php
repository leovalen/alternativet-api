<?php

namespace Api\Transformers;

use App\Membership;
use App\User;
use League\Fractal\TransformerAbstract;

class MembershipTransformer extends TransformerAbstract
{
    /**
     * @param Membership $membership
     * @return array
     */
    public function transform(Membership $membership)
    {
        return [
            'id' => (int) $membership->id,
            'valid_from' => $membership->valid_from,
            'valid_to' => $membership->valid_to,
            'renewed_at' => $membership->renewed_at,
        ];
    }

    /**
     * @param User $user
     * @return \League\Fractal\Resource\Item
     */
    public function includeMembership(User $user)
    {
        return $this->item($user->membership, new MembershipTransformer);
    }
}