<?php

namespace App\Http\Controllers;

use App\Helpers\NotificationHelper;
use App\Models\Notification;
use App\Http\Requests\NotificationRequest;
use App\Http\Resources\NotificationResource;

class NotificationController extends Controller
{
    public function __construct(private NotificationHelper $helper) 
    {

    }

    /**
     * @OA\Get(
     *     path="/api/notifications",
     *     summary="Get Notifications",
     *     tags={"Notifications"},
     *
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

        return NotificationResource::collection($data);
    }

    /**
     * @OA\Post(
     *     path="/api/notifications",
     *     summary="Create notification",
     *     tags={"Notifications"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={"subscriber_id","notification_type_id","channel","message"},
     *
     *             @OA\Property(
     *                 property="subscriber_id",
     *                 type="integer",
     *                 example=1
     *             ),
     *
     *             @OA\Property(
     *                 property="notification_type_id",
     *                 type="integer",
     *                 example=2
     *             ),
     *
     *             @OA\Property(
     *                 property="channel",
     *                 type="string",
     *                 enum={"sms","email"},
     *                 example="sms"
     *             ),
     *
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Код подтверждения 1234"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Notification queued",
     *
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *
     *             @OA\Property(
     *                 property="notification_id",
     *                 type="integer",
     *                 example=15
     *             )
     *         )
     *     )
     * )
     */
    public function store(NotificationRequest $request)
    {
        $this->helper->create($request->validated());

        return response()->json([
            'message' => 'Уведомление поставлено в очередь',
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/notifications/{notification}",
     *     summary="Get notification details",
     *     tags={"Notifications"},
     *
     *     @OA\Parameter(
     *         name="notification",
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
     *         description="Notification details"
     *     )
     * )
     */
    public function show(Notification $notification) 
    {
        $notification->load(['currentStatus', 'statuses.status']);

        return new NotificationResource($notification);
    }
}