<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use JsonSerializable;
use Throwable;

class ItemCollection extends ResourceCollection {
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|JsonSerializable
     * @throws Throwable
     */
    public function toArray(Request $request) {
        try {
            $response = [];
            foreach ($this->collection as $key => $collection) {
                /* NOTE : This code can be improved */
                $response[$key] = $collection->toArray();
                if ($collection->status == "approved" && $collection->relationLoaded('featured_items')) {
                    $response[$key]['is_feature'] = count($collection->featured_items) > 0;
                }else{
                    $response[$key]['is_feature'] = 0;
                }


                /*** Favourites ***/
                if ($collection->relationLoaded('favourites')) {
                    $response[$key]['total_likes'] = $collection->favourites->count();
                    if (Auth::check()) {
//                        $response[$key]['is_liked'] = $collection->favourites->where(['item_id' => $collection->id, 'user_id' => Auth::user()->id])->count() > 0;
                        $response[$key]['is_liked'] = $collection->favourites->where('item_id', $collection->id)->where('user_id', Auth::user()->id)->count() > 0;
                    } else {
                        $response[$key]['is_liked'] = false;
                    }
                }

                /*** Custom Fields ***/
                if ($collection->relationLoaded('item_custom_field_values')) {
                    $response[$key]['custom_fields'] = [];

                    foreach ($collection->item_custom_field_values as $key2 => $customFieldValue) {
                        $tempRow = [];
                        if ($customFieldValue->relationLoaded('custom_field')) {
                            if (!empty($customFieldValue->custom_field)) {
                                $tempRow = $customFieldValue->custom_field->toArray();

                                if ($customFieldValue->custom_field->type == "fileinput") {
                                    if (!is_array($customFieldValue->value)) {
                                        $tempRow['value'] = !empty($customFieldValue->value) ? [url(Storage::url($customFieldValue->value))] : [];
                                    } else {
                                        $tempRow['value'] = null;
                                    }
                                } else {
                                    $tempRow['value'] = $customFieldValue->value ?? [];
                                }

                                $tempRow['custom_field_value'] = !empty($customFieldValue) ? $customFieldValue->toArray() : (object)[];
                            }

                            unset($tempRow['custom_field_value']['custom_field']);

                            $response[$key]['custom_fields'][$key2] = $tempRow;
                        }
                    }

                    unset($response[$key]['item_custom_field_values']);
                }


                /*** Item Offers ***/
                if ($collection->relationLoaded('item_offers') && Auth::check()) {
                    $response[$key]['is_already_offered'] = $collection->item_offers->where('item_id', $collection->id)->where('buyer_id', Auth::user()->id)->count() > 0;
                } else {
                    $response[$key]['is_already_offered'] = false;
                }

                /*** User Reports ***/
                if ($collection->relationLoaded('user_reports') && Auth::check()) {
                    $response[$key]['is_already_reported'] = $collection->user_reports->where('user_id', Auth::user()->id)->count() > 0;
                } else {
                    $response[$key]['is_already_reported'] = false;
                }
            }
            $featuredRows = [];
            $normalRows = [];

            foreach ($response as $key => $value) {
                // ... (Your existing code here)
                // Extracting is_feature condition and processing accordingly
                if ($value['is_feature']) {
                    $featuredRows[] = $value;
                } else {
                    $normalRows[] = $value;
                }
            }


            // Merge the featured rows first and then the normal rows
            $response = array_merge($featuredRows, $normalRows);

            if ($this->resource instanceof AbstractPaginator) {
                //If the resource has a paginated collection then we need to copy the pagination related params and actual item details data will be copied to data params
                return [
                    ...$this->resource->toArray(),
                    'data' => $response
                ];
            }

            return $response;


        } catch (Throwable $th) {
            throw $th;
        }
    }
}
