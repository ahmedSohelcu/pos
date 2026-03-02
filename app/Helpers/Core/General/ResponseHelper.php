<?php


namespace App\Helpers\Core\General;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class ResponseHelper
{
    private function convertData($data)
    {
        if ($data instanceof Model || $data instanceof Collection) {
            return $data->toArray();
        }

        if (is_object($data)) {
            return (array) $data;
        }

        // arrays and null pass through
        return $data;
    }

    public function createdResponse($name, $data = [])
    {
        return array_merge([
            'status' => true,
            'message' => trans('default.created_response', [
//                'name' => __t($name)
                'name' => $name
            ]),
        ], $this->convertData($data));
    }

    public function updatedResponse($name, $data = [])
    {
        return array_merge([
            'status' => true,
            'message' => trans('default.updated_response', [
//                'name' => __t($name)
                'name' => $name
            ]),
        ], $this->convertData($data));
    }

    public function deletedResponse($name, $data = [])
    {
        return array_merge([
            'status' => true,
            'message' => trans('default.deleted_response', [
//                'name' => __t($name),
                'name' => $name
            ]),
        ], $this->convertData($data));
    }

    function failedResponse($message = null, $status = 500)
    {
        return response()->json([
            'status' => false,
            'message' => $message ?? __('default.failed_response'), // use your translation
        ], $status);
    }

    public function attachedResponse($name, $data = [])
    {
        return array_merge([
            'status' => true,
            'message' => trans('default.attached_response', [
//                'name' => __t($name),
                'name' => $name
            ])
        ], $this->convertData($data));
    }

    public function detachedResponse($name, $data = [])
    {
        return array_merge([
            'status' => true,
            'message' => trans('default.detached_response', [
//                'name' => __t($name),
                'name' => $name
            ])
        ], $this->convertData($data));
    }

    public function duplicatedResponse($name, $data = [])
    {
        return array_merge([
            'status' => true,
            'message' => trans('default.duplicated_response', [
//                'name' => __t($name),
                'name' => $name
            ])
        ], $this->convertData($data));
    }

    public function statusResponse($name, $status, $data = [])
    {
        return array_merge([
            'status' => true,
            'message' => trans('default.status_updated_response', [
//                'name' => __t($name),
                'name' => $name,
//                'status' => strtolower(__t($status))
                'status' => strtolower($status)
            ])
        ], $this->convertData($data));
    }





    

}
