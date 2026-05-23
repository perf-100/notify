<?php

namespace App\Http\Controllers;

use App\Helpers\SubscriberHelper;
use App\Models\Subscriber;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubscriberResource;

class SubscriberController extends Controller
{
    public function __construct(private SubscriberHelper $helper) {

    }
    
    /**
     * @OA\Get(
     *     path="/api/subscribers",
     *     summary="Get subscribers",
     *     tags={"Subscribers"},
     *
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         required=false,
     *
     *         @OA\Schema(
     *             type="integer",
     *             default=1,
     *             example=1
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response=200,
     *         description="Notification history"
     *     )
     * )
     */

    public function index()
    {
        $data = $this->helper->paginate();

        return SubscriberResource::collection($data);
    }

    /**
     * @OA\Get(
     *     path="/api/subscribers/{subscriber}",
     *     summary="Get subscriber details",
     *     tags={"Subscribers"},
     *
     *     @OA\Parameter(
     *         name="subscriber",
     *         in="path",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="integer"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Subscriber details"
     *     )
     * )
     */

    public function show(Subscriber $subscriber)
    {
        return new SubscriberResource($subscriber);
    }
}