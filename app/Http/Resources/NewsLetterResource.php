<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NewsLetterResource extends ResourceCollection
{
    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->resource = $resource;
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return collect($this->resource)->map(function($newsLetter){
            return [
                "template_name" => $newsLetter['template_name'],
                "news" => $newsLetter['news'],
                "start_date" => $newsLetter['start_date'],
                "end_date" => $newsLetter['end_date'],
                "starts_at" => $newsLetter['starts_at'],
                "ends_at" => $newsLetter['ends_at'],
                "operated_by" => $newsLetter['user']['name'],
                "status" => ucfirst($newsLetter['status']),
                "send_at" => Carbon::parse($newsLetter['created_at'])->format('d, M Y'),
            ];
        })->all();
    }
}
