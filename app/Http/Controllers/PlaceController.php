<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Services\BootstrapTableService;
use App\Services\ResponseService;
use Cerbero\JsonParser\JsonParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class PlaceController extends Controller {
    public function countryIndex() {
        ResponseService::noAnyPermissionThenRedirect(['country-list', 'country-create', 'country-update', 'country-delete']);
        $countries = JsonParser::parse(resource_path('countries.json'))->pointers(['/-/name', '/-/id', '/-/emoji'])->toArray();
        $dbCountries = Country::select('name')->get();
        foreach ($countries as $key => $country) {
            $countries[$key]['is_already_exists'] = $dbCountries->contains(static function ($dbCountry) use ($country) {
                return $country['name'] == $dbCountry->name;
            });
        }
        return view('places.country', compact('countries'));
    }

    public function countryShow(Request $request) {
        try {
            ResponseService::noPermissionThenSendJson('country-list');
            $offset = $request->input('offset', 0);
            $limit = $request->input('limit', 15);
            $sort = $request->input('sort', 'id');
            $order = $request->input('order', 'DESC');

            $sql = Country::select(['id', 'name', 'emoji']);

            if (!empty($request->search)) {
                $sql = $sql->search($request->search);
            }
            $total = $sql->count();
            $sql = $sql->orderBy($sort, $order)->skip($offset)->take($limit);
            $result = $sql->get();
            $bulkData = array();
            $bulkData['total'] = $total;
            $rows = array();
            foreach ($result as $key => $row) {
                $tempRow = $row->toArray();
                if (auth()->user()->can('country-delete')) {
                    $tempRow['operate'] = BootstrapTableService::deleteButton(route('countries.destroy', $row->id));
                }

                $rows[] = $tempRow;
            }
            $bulkData['rows'] = $rows;


            return response()->json($bulkData);
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e, "CustomFieldController -> show");
            ResponseService::errorResponse('Something Went Wrong');
        }

    }

    public function destroyCountry($id) {
        try {
            Country::find($id)->delete();
            ResponseService::successResponse("Country deleted Successfully");
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e, "PlaceController -> destroyCountry");
            ResponseService::errorResponse('Something Went Wrong');
        }
    }

    public function stateSearch(Request $request) {
        try {
            ResponseService::noPermissionThenRedirect('state-list');
            $states = State::where('country_id', $request->country_id)->select(['id', 'name'])->orderBy('name', 'ASC')->get();
            ResponseService::successResponse("States Fetched Successfully", $states);
        } catch (Throwable $th) {
            ResponseService::logErrorRedirect($th, "PlaceController -> stateSearch");
            ResponseService::errorResponse();
        }
    }

    public function stateIndex() {
        ResponseService::noAnyPermissionThenRedirect(['country-list', 'country-create', 'country-update', 'country-delete']);
        $countries = Country::get();
        return view('places.state', compact('countries'));
    }

    public function stateShow(Request $request) {
        try {
            ResponseService::noPermissionThenSendJson('country-list');
            $offset = $request->input('offset', 0);
            $limit = $request->input('limit', 15);
            $sort = $request->input('sort', 'id');
            $order = $request->input('order', 'DESC');

            $sql = State::with('country:id,name,emoji');

            if (!empty($request->filter)) {
                $sql = $sql->filter(json_decode($request->filter, false, 512, JSON_THROW_ON_ERROR));
            }

            if (!empty($request->search)) {
                $sql = $sql->search($request->search);
            }
            $total = $sql->count();
            $sql = $sql->sort($sort, $order)->skip($offset)->take($limit);
            $result = $sql->get();
            $bulkData = array();
            $bulkData['total'] = $total;
            $rows = array();
            foreach ($result as $key => $row) {
                $tempRow = $row->toArray();
                $tempRow['country_name'] = $row->country->name;
                $rows[] = $tempRow;
            }

            $bulkData['rows'] = $rows;
            return response()->json($bulkData);
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e, "CustomFieldController -> show");
            ResponseService::errorResponse('Something Went Wrong');
        }

    }

    public function citySearch(Request $request) {
        try {
            ResponseService::noPermissionThenRedirect('city-list');
            $cities = City::where('state_id', $request->state_id)->select(['id', 'name'])->orderBy('name', 'ASC')->get();
            ResponseService::successResponse("Cities fetched Successfully", $cities);
        } catch (Throwable $th) {
            ResponseService::logErrorRedirect($th, "PlaceController -> citySearch");
            ResponseService::errorResponse();
        }

    }

    public function cityIndex() {
        ResponseService::noAnyPermissionThenRedirect(['country-list', 'country-create', 'country-update', 'country-delete']);
        $countries = Country::all();
        $states = State::get();
        return view('places.city', compact('countries', 'states'));
    }

    public function cityShow(Request $request) {
        try {
            ResponseService::noPermissionThenSendJson('country-list');
            $offset = $request->input('offset', 0);
            $limit = $request->input('limit', 15);
            $sort = $request->input('sort', 'id');
            $order = $request->input('order', 'DESC');

            $sql = City::orderBy($sort, $order)->with('state:id,name', 'country:id,name,emoji');


            if (!empty($request->search)) {
                $sql = $sql->search($request->search);
            }
            if (!empty($request->filter)) {
                $sql = $sql->filter(json_decode($request->filter, false, 512, JSON_THROW_ON_ERROR));
            }
            $total = $sql->count();
            $sql = $sql->sort($sort, $order)->skip($offset)->take($limit);
            $result = $sql->get();
            $bulkData = array();
            $bulkData['total'] = $total;
            $rows = array();
            foreach ($result as $key => $row) {
                $tempRow = $row->toArray();
                $tempRow['state_name'] = $row->state->name;
                $tempRow['country_name'] = $row->country->name;
                $rows[] = $tempRow;
            }

            $bulkData['rows'] = $rows;


            return response()->json($bulkData);
        } catch (Throwable $e) {
            ResponseService::logErrorResponse($e, "CustomFieldController -> show");
            ResponseService::errorResponse('Something Went Wrong');
        }

    }

    public function importCountry(Request $request) {
        ResponseService::noPermissionThenSendJson('country-create');
        $validator = Validator::make($request->all(), [
            'countries'   => 'required|array',
            'countries.*' => 'integer',
        ]);

        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            $country_id = $request->countries;
            DB::beginTransaction();
            foreach (JsonParser::parse(resource_path('world.json')) as $country) {
                if (in_array($country['id'], $country_id, false)) {
                    Country::create([
                        ...$country,
                        'timezones'    => json_encode($country['timezones'], JSON_THROW_ON_ERROR),
                        'translations' => json_encode($country['translations'], JSON_THROW_ON_ERROR),
                        'region_id'    => null,
                        'subregion_id' => null,
                    ]);


                    foreach ($country['states'] as $state) {
                        State::create([
                            ...$state,
                            'country_id' => $country['id']
                        ]);

                        $cities = [];
                        foreach ($state['cities'] as $city) {
                            $cities[] = [
                                ...$city,
                                'state_id'     => $state['id'],
                                'state_code'   => $state['state_code'],
                                'country_id'   => $country['id'],
                                'country_code' => $country['iso2'],
                            ];
                        }

                        City::insert($cities);
                    }

                    /*Stop the JSON file reading if country_id array is empty*/
                    unset($country_id[array_search($country['id'], $country_id, true)]);
                    if (empty($country_id)) {
                        break;
                    }
                }
            }
            DB::commit();
            ResponseService::successResponse("Country imported successfully");
        } catch (Throwable $e) {
            DB::rollBack();
            ResponseService::logErrorResponse($e, "CustomFieldController -> show");
            ResponseService::errorResponse('Something Went Wrong');
        }

    }

    public function createArea() {
        ResponseService::noAnyPermissionThenRedirect(['area-list', 'area-create', 'area-update', 'area-delete', 'get-state', 'get-city']);
        $countries = Country::all();
        return view('places.area', compact('countries'));
    }

    public function addArea(Request $request) {
        ResponseService::noPermissionThenRedirect('area-create');
        $validator = Validator::make($request->all(), [
            'name.*'     => 'required|string',
            'country_id' => 'required|exists:countries,id',
            'state_id'   => 'required|exists:states,id',
            'city_id'    => 'required|exists:cities,id',
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            $state = State::findOrFail($request->state_id);
            $area = [];
            foreach ($request->name as $name) {
                $area[] = [
                    'name'       => $name,
                    'city_id'    => $request->city_id,
                    'state_id'   => $request->state_id,
                    'country_id' => $request->country_id,
                    'state_code' => $state->state_code,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            Area::insert($area);
            ResponseService::successResponse('area added successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "place Controller -> store");
            ResponseService::errorResponse();
        }
    }

    public function areaShow(Request $request) {
        try {
            ResponseService::noPermissionThenSendJson('area-list');
            $offset = $request->input('offset', 0);
            $limit = $request->input('limit', 10);
            $sort = $request->input('sort', 'id');
            $order = $request->input('order', 'ASC');

            $sql = Area::with('city:id,name', 'state:id,name', 'country:id,name')->orderBy($sort, $order);

            if (!empty($_GET['search'])) {
                $search = $_GET['search'];
                $sql->where('id', 'LIKE', "%$search%")->orwhere('question', 'LIKE', "%$search%")->orwhere('answer', 'LIKE', "%$search%");
            }
            if (!empty($request->filter)) {
                $sql = $sql->filter(json_decode($request->filter, false, 512, JSON_THROW_ON_ERROR));
            }

            $total = $sql->count();
            $sql->skip($offset)->take($limit);
            $result = $sql->get();
            $bulkData = array();
            $bulkData['total'] = $total;
            $rows = array();
            foreach ($result as $key => $row) {
                $tempRow = $row->toArray();
                $operate = '';
                if (Auth::user()->can('area-update')) {
                    $operate .= BootstrapTableService::editButton(route('area.update', $row->id), true, '#editModal', 'areaEvents', $row->id);
                }
                if (Auth::user()->can('area-delete')) {
                    $operate .= BootstrapTableService::deleteButton(route('area.destroy', $row->id));
                }
                $tempRow['operate'] = $operate;
                $rows[] = $tempRow;
            }

            $bulkData['rows'] = $rows;
            return response()->json($bulkData);

        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "PlaceController --> show");
            ResponseService::errorResponse();
        }
    }

    public function edit(string $id) {

    }

    public function updateArea(Request $request, $id) {
        ResponseService::noPermissionThenSendJson('area-update');
        $validator = Validator::make($request->all(), [
            'name' => 'Required|string',
        ]);
        if ($validator->fails()) {
            ResponseService::validationError($validator->errors()->first());
        }
        try {
            $area = Area::findOrFail($id);
            $data = $request->all();
            $area->update($data);
            ResponseService::successResponse('Area updated successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "Area Controller -> update");
            ResponseService::errorResponse();
        }
    }

    public function destroyArea(string $id) {
        try {
            ResponseService::noPermissionThenSendJson('area-delete');
            Area::findOrFail($id)->delete();
            ResponseService::successResponse('Area delete successfully');
        } catch (Throwable $th) {
            ResponseService::logErrorResponse($th, "Place Controller -> destroy");
            ResponseService::errorResponse('Something Went Wrong');
        }
    }
}
