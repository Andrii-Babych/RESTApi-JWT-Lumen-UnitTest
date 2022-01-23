<?php declare(strict_types=1);

namespace App\DataTransferObject;

use Illuminate\Contracts\Support\Responsable;
use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ResponseData  extends DataTransferObject implements Responsable
{
    /**
     * @var int
     */
    public int $status = 200;

    /**
     * @var string
     */
    public string $title = 'Unauthorized';

    /**
     * @var string
     */
    public string $detail = '';

    /**
     * @param $request
     * @return JsonResponse|Response
     */
    public function toResponse($request): JsonResponse|Response
    {
        return response()->json([
            'title' => $this->title,
            'detail' => $this->detail,
            ], $this->status, $this->getHeadersArray()
        );
    }

    private function getHeadersArray(): array
    {
        return array([
            'Access-Control-Allow-Origin: *',
            'Access-Control-Allow-Headers: *',
            'Access-Control-Allow-Methods: *',
            'Access-Control-Allow-Credentials: true',
            'Content-type: json/application'
        ]);
    }
}
