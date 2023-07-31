<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('/students', function (Request $request) {
    $rawData = DB::select(DB::raw("select id, name, email, phone from students"));

    $responseData = [];

    foreach ($rawData as $rd) {
        array_push($responseData, [
            'id' => $rd->id,
            'name' => $rd->name,
            'email' => $rd->email,
            'phone' => $rd->phone,
        ]);
    }

    $statusCode = 200;

    return response()->json([  
            'data' => $responseData
    ], $statusCode);
});

Route::post('/students', function (Request $request) {
    try{

    $name = $request->input('name');
    $email = $request->input('email');
    $phone = $request->input('phone');
  

    $studentId = DB::table('students')->insertGetId([
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
    ]);
      $statusCode = 200;
    $responseData = [
        'data' => [
            'id' => $studentId,
        ],
    ];

    return response()->json($responseData, $statusCode);
}
    catch(Exception $e){
        $statusCode = 500;
        $responseData = [
            'data' => [
                'message' => 'Student not created successfully',
            ],
        ];
    
        return response()->json($responseData, $statusCode);
    }
    
});

Route::get('/students/{id}',function(Request $request, $id){
try{
  $rawData = DB::select(DB::raw("select id, name, email, phone from students where id = $id"));


  if ($rawData == null){
    $statusCode = 404;
    $responseData = [
        'data' => [
        ],
    ];

    return response()->json($responseData, $statusCode);
  }
  else{
    $responseData = [
        'data' => [
            'id' => $rawData[0]->id,
            'name' => $rawData[0]->name,
            'email' => $rawData[0]->email,
            'phone' => $rawData[0]->phone,
          
        ]
    ];
    $statusCode = 200;

    return response()->json(  
             $responseData
    , $statusCode);
  }

    
    

     }
    catch(Exception $e){
        $statusCode = 500;
        $responseData = [
            'data' => [
            'message' => 'Student not found',
        ],
    ];

    return response()->json($responseData, $statusCode);
}
});

 Route::put('/students/{id}',function(Request $request,$id){
    try {
      
        $name = $request->input('name');
        $email = $request->input('email');
        $phone = $request->input('phone');
      Db::table('students')
            ->where('id', $id)
            ->update(['name' => $name, 'email' => $email, 'phone' => $phone]);
        $statusCode = 200;
        $responseData = [
            'data' => [
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
            ],
        ];
        return response()->json($responseData, $statusCode);
        

    } catch (Exception $e) {
        $statusCode = 500;
        $responseData = [
            'data' => [
                'message' => 'Student not updated successfully',
            ],
        ];
    
        return response()->json($responseData, $statusCode);
    }
    
});
 
Route::get('/courses',function(Request $request){
    try{
        
    $rawData=DB::select(DB::raw("select id, name from courses"));
    $statusCode = 200;
    $responseData = [];
    foreach($rawData as $data){
        array_push(
            $responseData,[
                     'id' => $data->id,
                     'name' => $data->name,
                       ]
            );
            
    }
    return response()->json(['data'=>$responseData], $statusCode);

    }catch(Exception $e){
        $statusCode = 500;
        $responseData = [
            'data' => [
            'message' => 'Student not found',
        ],
    ];
    return response()->json($responseData, $statusCode);
    }
});

Route::post('/courses',function(Request $request){
    try{
    $name = $request->input('name');

    $rowCount = DB::table('courses')->insertGetId([
        'name' => $name,
    ]);
    $statusCode = 200;
    $responseData = [
        'data' => [
            'id' => $rowCount,
        ],
    ];

    return response()->json($responseData, $statusCode);
}
    catch(Exception $e){
        $statusCode = 500;
        $responseData = [
            'data' => [
                'message' => 'Course not created successfully',
            ],
        ];
    
        return response()->json($responseData, $statusCode);
    }
    
});

Route::get('/courses/{id}',function(Request $request, $id){
try{
  $rawData = DB::select(DB::raw("select id, name from courses where id = $id"));
  if ($rawData == null){
    $statusCode = 404;
    $responseData = [
        'data' => [
        ],
    ];

    return response()->json($responseData, $statusCode);
  }
  else{
    $responseData = [
        'data' => [
            'id' => $rawData[0]->id,
            'name' => $rawData[0]->name,
          
        ]
    ];
    $statusCode = 200;

    return response()->json(  
             $responseData
    , $statusCode);
  }

    
    

     }
    catch(Exception $e){
        $statusCode = 500;
        $responseData = [
            'data' => [
            'message' => 'Course not found',
        ],
    ];

    return response()->json($responseData, $statusCode);
}
});

Route::put('/courses/{id}',function(Request $request,$id){
    try {
      
        $name = $request->input('name');
        DB::table('courses')->where('id', $id)->update(['name' => $name]);

        $statusCode = 200;
        $responseData = [
            'data' => [
                'id' => $id,
                'name' => $name,
            ],
        ];
        return response()->json($responseData, $statusCode);
        

    } catch (Exception $e) {
        $statusCode = 500;
        $responseData = [
            'data' => [
                'message' => 'Course not updated successfully',
            ],
        ];
    
        return response()->json($responseData, $statusCode);
    }
    
});

Route::get('/grades',function(Request $request){
    try{
        
    $rawData=DB::select(DB::raw("select student_id, course_id, grade from grades"));
    $statusCode = 200;
    $responseData = [];
    foreach($rawData as $data){
        array_push(
            $responseData,[
                     'student_id' => $data->student_id,
                     'course_id' => $data->course_id,
                     'grade' => $data->grade
            ]
            );
            
    }


    return response()->json(['data'=>$responseData], $statusCode);}

    catch(Exception $e){
        $statusCode = 500;
        $responseData = [
            'data' => [
            'message' => 'Student not found',
        ],
    ];

    return response()->json($responseData, $statusCode);
    
    
}
});

Route::get('/students/{student_id}/grades',function(Request $request,$student_id){
  try  
 {  
    $rawData = DB::select(DB::raw("select student_id, course_id, grade from grades where student_id = :student_id"), ['student_id' => $student_id]);

    $statusCode = 200;
    $responseData = [];
    foreach ($rawData as $data) {
        array_push($responseData, [
            'student_id' => $data->student_id,
            'course_id' => $data->course_id,
            'grade' => $data->grade
        ]);
    }
    
    return response()->json(['data'=>$responseData], $statusCode);
    
}
    catch(Exception $e){
        $statusCode = 500;
        $responseData = [
            'data' => [
            'message' => 'Student not found',
        ],
    ];

    return response()->json($responseData, $statusCode);
    
    

    
            
    }
});

Route::get('/students/{student_id}/grades/{grade_id}',function(Request $request,$student_id,$grade_id){
    try  
   {  
    
      $rawData = DB::select(DB::raw("select student_id, course_id, grade from grades where student_id = :student_id and id = :grade_id"), [
        "student_id" => $student_id,
        "grade_id" => $grade_id
    ]);
    
    $statusCode = 200;
   
    $responseData = ["data" => [
        'student_id' => $rawData[0]->student_id,
        'course_id' => $rawData[0]->course_id,
        'grade' => $rawData[0]->grade
    ]];
    
    return response()->json($responseData, $statusCode);
    
          
  }
      catch(Exception $e){
          $statusCode = 500;
          $responseData = [
              'data' => [
              'message' => 'Student not found',
          ],
      ];
  
      return response()->json($responseData, $statusCode);
      
      
  
      
              
      }
});