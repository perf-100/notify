<?php

namespace App\Http\Controllers;

use App\Helpers\MassNotificationHelper;
use App\Http\Requests\MassNotificationRequest;
use App\Http\Resources\MassNotificationResource;
use App\Models\MassNotification;

class MassNotificationController extends Controller
{
    public function __construct(private MassNotificationHelper $helper) 
    {

    }

    /**
     * @OA\Get(
     *     path="/api/massnotifications",
     *     summary="Get mass notifications",
     *     tags={"Mass Notifications"},
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
     *         description="Mass notifications list"
     *     )
     * )
     */
    public function index()
    {
        $data = $this->helper->paginate();

        return MassNotificationResource::collection($data);
    }

    /**
     * @OA\Post(
     *     path="/api/massnotifications",
     *     summary="Create mass notification",
     *     tags={"Mass Notifications"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *
     *         @OA\JsonContent(
     *             required={
     *                 "name",
     *                 "notification_type_id",
     *                 "channel",
     *                 "message",
     *                 "subscriber_ids"
     *             },
     *
     *             @OA\Property(
     *                 property="name",
     *                 type="string",
     *                 example="Маркетинговая рассылка"
     *             ),
     * 
     *             @OA\Property(
     *                 property="idempotency_key",
     *                 type="string",
     *                 example="mass-1"
     *             ),
     *
     *             @OA\Property(
     *                 property="notification_type_id",
     *                 type="integer",
     *                 example=1
     *             ),
     *
     *             @OA\Property(
     *                 property="channel",
     *                 type="string",
     *                 enum={"sms","email"},
     *                 example="email"
     *             ),
     *
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Скидка 10% на продукцию"
     *             ),
     *
     *             @OA\Property(
     *                 property="subscriber_ids",
     *                 type="array",
     *
     *                 @OA\Items(
     *                     type="integer"
     *                 ),
     *
     *                 example={1,2,3}
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Mass Notification created",
     *
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="success",
     *                 type="boolean",
     *                 example=true
     *             ),
     *
     *             @OA\Property(
     *                 property="massnotification_id",
     *                 type="integer",
     *                 example=1
     *             )
     *         )
     *     )
     * )
     */

    public function store(MassNotificationRequest $request)
    {
        $massnotification = $this->helper->create($request->validated());

        return response()->json([
            'id' => $massnotification->id,
            'message' => 'Рассылка добавлена',
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/massnotifications/{massnotification}",
     *     summary="Mass Notification details",
     *     tags={"Mass Notifications"},
     *
     *     @OA\Parameter(
     *         name="massnotification",
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
     *         description="Mass Notification details"
     *     )
     * )
     */
    public function show(MassNotification $massnotification) 
    {
        $massnotification->loadCount('notifications');

        return new MassNotificationResource($massnotification);
    }
}