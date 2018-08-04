<?php

return [

    'request_status' => [
       'CREATED' => 'Created',
       'ACCEPTED' => 'Accepted',
       'OFFER_CREATED' => 'Offer Created',
       'OFFER_ACCEPTED' => 'Offer Accepted',
       'CLOSED_DELIVERED' => 'Closed - Delivered',
       'CLOSED_NOT_DELIVERED' => 'Closed - Not Delivered',
       'CLOSED_BUYER_CANCELLED' => 'Closed - Cancelled By Buyer',
       'CLOSED_GLOBSHOPPER_CANCELLED' => 'Closed - Cancelled By Globshopper'
    ],

    'user_type' => [
        'globshopper' => 'Globshopper',
        'buyer' => 'Buyer',
        'admin' => 'Admin'
    ],

    'notifications' => [
        'request_created' => '<a href="/requests/view/:requestId">Request #:requestId</a>  Created',
        'request_accepted' => '<a href="/requests/view/:requestId">Request #:requestId</a>  Accepted',
        'request_cancelled' => '<a href="/requests/view/:requestId">Request #:requestId</a>  Cancelled by :name',
        'request_delivered' => '<a href="/requests/view/:requestId">Request #:requestId</a>  is Delivered',
        'request_charged' => '<a href="/requests/view/:requestId">Request #:requestId</a>  is Charged',
        'offer_created' => 'Offer created for <a href="/requests/view/:requestId">Request #:requestId</a>'
    ]
];
