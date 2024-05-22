
<?php

/**
 * function to get data using library "yajra/laravel-datatables-oracle"
 * you to install this library
 */
function getDataTables($request, $data)
{
    if ($request->ajax()) {
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $actionBtn =
                    '<a href="picture/show/' . $row->id . '" class="show btn btn-warning btn-sm">Show</a>
                     <a href="album/edit/' . $row->id . '" class="edit btn btn-success btn-sm">Edit</a>
                      <a href="album/delete/' . $row->id . '" class="delete btn btn-danger btn-sm">Delete</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}


/**
 * function to save multiple images
 * you to install this library
 */

function saveMultipleImages($request, $nameFile)
{
    if ($request->hasfile($nameFile)) {
        $i = 0;
        $data = [];
        foreach ($request->file($nameFile) as $image) {
            $name =  time() . '_' . $i . '.' . $image->getClientOriginalExtension();
            $image->move(public_path() . '/images/', $name);
            $data[] = $name;
            $i++;
        }
        return $data;
    }
}

/**
 * function sendResonse return resposne as json
 */
if(!function_exists('sendResponse')){

    function sendResponse($resault, $message){
        $respone = [
            'success' => true,
            'data'    => $resault,
            'message' => $message,
        ];
        return response()->json($respone);
    }

}

/**
 * function sendResonse return response as json
 */
if(!function_exists('sendError')){

    function sendError($error, $errorMessages =[], $code = 500){
        $respone = [
            'success' => false,
            'message'    => $error
        ];

            if(!empty($errorMessages)){

                $respone['data'] = $errorMessages;
            }
        return response()->json($respone,$code);
    }

}

?>
