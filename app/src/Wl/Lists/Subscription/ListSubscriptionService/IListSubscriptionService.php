<?php

namespace Wl\Lists\Subscription\ListSubscriptionService;

use Wl\Lists\Subscription\IListSubscription;

interface IListSubscriptionService 
{
    public function createSubscription(IListSubscription $sub): IListSubscription;
    public function getSubscription(int $listId, int $userId): ?IListSubscription;
    
    /**
     * @return IListSubscription[]
     */
    public function getUserSubscriptions(int $userId);
}