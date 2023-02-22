<?php
namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FilmController extends Controller{
    private $postRules = [
        'title' => 'required',
        'rating' => 'required'
    ];

    private $uploadDir = 'uploads/images/';

    public function index(){
        try {
            $data = DB::select("SELECT * FROM films");
            if (count($data) == 0){
                return response()->json([
                    'status' => [
                        'code' => 404,
                        'message' => "There's no data available"
                    ], 'data' => $data
                ], 404);
            } else {
                return response()->json([
                    'status' => [
                        'code' => 200,
                        'message' => 'OK'
                    ], 'data' => $data
                ], 200);
            }
        } catch (Exception $th) {
            return response()->json([
                'status' => [
                    'code' => $th->getCode(),
                    'message' => $th->getMessage()
                ]
            ], $th->getCode());
        }

    }

    public function show($id){
        try {
            $data = DB::select("SELECT * FROM films where id = $id");
            if (count($data) == 0){
                return response()->json([
                    'status' => [
                        'code' => 404,
                        'message' => "There's no data available"
                    ], 'data' => $data
                ], 404);
            } else {
                return response()->json([
                    'status' => [
                        'code' => 200,
                        'message' => 'OK'
                    ], 'data' => $data
                ], 200);
            }
        } catch (Exception $th) {
            return response()->json([
                'status' => [
                    'code' => $th->getCode(),
                    'message' => $th->getMessage()
                ]
            ], $th->getCode());
        }
    }

    public function store(Request $request){
        try {
            $validator = Validator::make($request->all(), $this->postRules);

            $pic_path = "";
            if($request->file("image") !== null){
                $pic_path       = $request->file('image');
                $fileName       = $pic_path->getClientOriginalName();
            } else {
                $fileName       = "";
            }

            if (!$validator->fails()){
                $data = [
                    'title' => cleanFormString($request->title),
                    'rating' => setDecimal($request->rating),
                    'description' => cleanFormString($request->description),
                    'image' => $fileName != '' ? $this->uploadDir.$request->title.'/'.$fileName : '',
                    'created_at' => date('Y-m-d H:i:s')
                ];

                $query = genereteDataQuery($data,$request->method());
                $insert = DB::SELECT("INSERT INTO films $query");

                if($pic_path !== ""){
                    uploadPicture($this->uploadDir,$request->title,$pic_path);
                }

                return response()->json([
                    'status' => [
                        'code' => 200,
                        'message' => 'Success Save Data!',
                    ],
                ], 200);
            } else {
                return response()->json([
                    'status' => [
                        'code' => 400,
                        'message' => 'Error'
                    ],
                    'errors' => $validator->errors()
                ], 400);
            }
        } catch (Exception $th) {
            return response()->json([
                'status' => [
                    'code' => $th->getCode(),
                    'message' => $th->getMessage()
                ]
            ], $th->getCode());
        }
    }

    public function update(Request $request, $id){
        try {
            $validator = Validator::make($request->all(), $this->postRules);

            $pic_path = "";
            if($request->file("image") !== null){
                $pic_path       = $request->file('image');
                $fileName       = $pic_path->getClientOriginalName();
            } else {
                $fileName       = "";
            }

            if (!$validator->fails()){
                $data = [
                    'title' => cleanFormString($request->title),
                    'rating' => setDecimal($request->rating),
                    'description' => cleanFormString($request->description),
                    'image' => $fileName != '' ? $this->uploadDir.$request->title.'/'.$fileName : '',
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                $query = genereteDataQuery($data, $request->method());
                $insert = DB::SELECT("UPDATE films SET $query where id = $id");

                if($pic_path !== ""){
                    uploadPicture($this->uploadDir,$request->title,$pic_path);
                }

                return response()->json([
                    'status' => [
                        'code' => 200,
                        'message' => 'Success Update Data!',
                    ],
                ], 200);
            } else {
                return response()->json([
                    'status' => [
                        'code' => 400,
                        'message' => 'Error'
                    ],
                    'errors' => $validator->errors()
                ], 400);
            }
        } catch (Exception $th) {
            return response()->json([
                'status' => [
                    'code' => $th->getCode(),
                    'message' => $th->getMessage()
                ]
            ], $th->getCode());
        }
    }

    public function delete($id){
        try {
            $dataFilm = DB::SELECT("SELECT * FROM films where id = $id");
            if(count($dataFilm) > 0){
                $delete = DB::SELECT("DELETE FROM films where id = $id");
                return response()->json([
                    'status' => [
                        'code' => 410,
                        'message' => 'Success Delete Data!',
                    ],
                ], 410);
            } else {
                return response()->json([
                    'status' => [
                        'code' => 404,
                        'message' => "Movie not found in id $id"
                    ]
                ], 404);
            }
        } catch (Exception $th) {
            return response()->json([
                'status' => [
                    'code' => $th->getCode(),
                    'message' => $th->getMessage()
                ]
            ], $th->getCode());
        }
    }
}
?>
