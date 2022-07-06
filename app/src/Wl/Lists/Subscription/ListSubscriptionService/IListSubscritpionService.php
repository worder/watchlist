<?php

namespace Wl\List\ListSubscriptionService;

use Wl\Lists\Subscription\IListSubscription;

interface IListSubscriptionService 
{
    public function createSubscription(IListSubscription $sub): IListSubscription;
    public function getSubscriptionById(int $id): ?IListSubscription;
}