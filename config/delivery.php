<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Delivery Configuration
    |--------------------------------------------------------------------------
    |
    | Settings for the EpiDrive delivery service. These values control
    | pricing, distance limits, and free delivery thresholds.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Price Per Kilometer
    |--------------------------------------------------------------------------
    |
    | The cost charged per kilometer of delivery distance, in euros.
    |
    */
    'price_per_km' => (float) env('DELIVERY_PRICE_PER_KM', 0.50),

    /*
    |--------------------------------------------------------------------------
    | Maximum Delivery Distance
    |--------------------------------------------------------------------------
    |
    | The maximum distance (in kilometers) for which delivery is available.
    |
    */
    'max_distance_km' => (float) env('DELIVERY_MAX_DISTANCE_KM', 30),

    /*
    |--------------------------------------------------------------------------
    | Base Delivery Price
    |--------------------------------------------------------------------------
    |
    | The minimum flat fee charged for any delivery, in euros.
    |
    */
    'base_price' => (float) env('DELIVERY_BASE_PRICE', 2.90),

    /*
    |--------------------------------------------------------------------------
    | Free Delivery Threshold
    |--------------------------------------------------------------------------
    |
    | Orders above this amount (in euros) qualify for free delivery.
    |
    */
    'free_threshold' => (float) env('DELIVERY_FREE_THRESHOLD', 60.00),

];
