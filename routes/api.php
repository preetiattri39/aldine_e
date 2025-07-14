<?php

use App\Http\Controllers\user\{AuthController, CategoryController, HelpDeskController, HomeController, SendNotificationController};

use App\Http\Controllers\Api\{SubjectController, PostShareController,ConnectionController, PostController, ReplyController,QuickSolveController,StudyRoomController,ChatController};

use App\Models\NotificationPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([
        'success' => true,
        'data' => $request->user(),
    ]);
});

Route::get('/verify-token', function (Request $request) {
    return response()->json([
        'status' => 'success',
        'message' => 'Token is valid.',
        'user' => $request->user(),
    ]);
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('verify-otp', 'verifyOtp');
    Route::post('resend-otp', 'resendOtp');
    Route::post('login', 'login');
    Route::post('forget-password', 'forgetPassword');
    Route::post('set-new-password', 'setNewPassword');
    Route::get('send-daily-push', 'sendDailyEncouragementNotification');
    Route::get('get-programs', 'getPrograms');
    Route::get('get-majors', 'getMajors');
    Route::post('upload-image', 'uploadImage');



});

Route::middleware(['auth:sanctum', 'user'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('logout', 'logOut');
        Route::post('change-password', 'changePassword');
        Route::match(['get', 'post'], 'profile', 'Profile');
        //Route::get('get-avatars', 'avatars');
        Route::get('account/delete', 'accountDelete');
        Route::post('subscribe', 'subscribe');
        Route::post('change/theme', 'changeTheme');
    });


    Route::prefix('subjects')->group(function () {
        Route::get('/', [SubjectController::class, 'index']);
        Route::get('fav-subject', [SubjectController::class, 'getFavSubjects']);
        Route::get('/{id}', [SubjectController::class, 'show']);
        Route::post('/', [SubjectController::class, 'store']);
        Route::put('/{id}', [SubjectController::class, 'update']);
        Route::delete('/{id}', [SubjectController::class, 'destroy']);
        
    });


    // Manage Home Routes
    Route::controller(HomeController::class)->group(function () {
        Route::get('/home', 'home');
        Route::get('contentPages/{slug}', 'contentPages');


    });


    // Manage Help desk Routes
    Route::controller(HelpDeskController::class)->group(function () {
        Route::prefix('helpdesk')->group(function () {
            Route::get('/', 'list');
            Route::post('add', 'add');
            Route::match(['get', 'post'], 'response/{id}', 'response');
            Route::get('changestatus/{id}', 'changeStatus');
            Route::get('/subscription-ticket', 'subscriptionTicket');
        });
    });



    Route::controller(ConnectionController::class)->group(function () {
        Route::prefix('connections')->group(function () {
            Route::get('/search', 'searchUsers');
            Route::post('/send', 'sendRequest');
            Route::post('/accept/{id}', 'acceptRequest');
            Route::post('/reject/{id}', 'rejectRequest');
            Route::get('/', 'getConnections');
            Route::get('/status', 'getConnectionsOnStatus');
            Route::delete('/disconnect/{id}', 'disconnectUser');
        });
    });


    Route::controller(PostController::class)->group(function () {
        Route::prefix('posts')->group(function () {
            Route::get('/', 'index');         // List posts
            Route::post('save', 'store');        // Create Post
            Route::get('/{id}', 'show');      // Show post with replies
            Route::delete('/{id}', 'destroy'); // Delete post
            Route::post('likePosts/{id}','likePost');
            Route::post('unlikePost/{id}','unlikePost');
            Route::post('pinPost/{id}', 'pinPost');
            Route::post('unpinPost/{id}', 'unpinPost');
        });
    });





    Route::controller(ReplyController::class)->group(function () {
        Route::prefix('replys')->group(function () {
            Route::post('/{postId}/reply', 'replyToPost');
            Route::post('/{postId}/reply/{replyId}', 'replyToReply');
            Route::get('/{postId}/list', 'showRepliesForPost');
            Route::put('/{replyId}/update', 'update');
            Route::delete('/{replyId}/delete', 'destroy');
        });
    });

    Route::controller(PostShareController::class)->group(function () {
        Route::prefix('posts')->group(function () {
            Route::post('share','share')->name('share');
        });
    });


    Route::controller(QuickSolveController::class)->group(function () {
        Route::prefix('quick-solve')->group(function () {
            Route::get('/questions/{category_id?}', 'getByCategory');
            Route::post('/questions/by-subcategories', 'getBySubCategory');
            Route::post('/questions','store');
            Route::post('/questions/{id}','update');
            Route::delete('/questions/{id}', 'destroy');

            Route::post('/replies', 'addReply');
            Route::post('/replies/{id}','updateReply');
            Route::delete('/replies/{id}', 'deleteReply');

            Route::post('/replies/{reply_id}/react', 'reactToReply');
            Route::post('/questions/{question_id}/react', 'reactToQuestion');

        });
    });


    Route::controller(StudyRoomController::class)->group(function () {
        Route::prefix('studyroom')->group(function () {
            Route::get('/', 'index');        
            Route::post('save', 'createStudyRoom');   
            Route::post('/study-rooms/{room}/request',  'sendJoinRequest');
            Route::post('/study-rooms/requests/respond','respondToJoinRequest');
   
        });
    });

    Route::controller(ChatController::class)->group(function () {
        Route::prefix('chatroom')->group(function () { 
            Route::post('save', 'create'); 
            Route::post('add-user','addUserToRoom');
            Route::post('send-message', 'saveMessage');
            Route::get('chat-list/{user_id}','getUserChatRooms');
            Route::get('get-all-messages/{room_id}','getAllMessagesInRoom');


  
        });
    });


    

    
});

Route::controller(PostController::class)->group(function () {
	Route::get('shared-recipients', 'getSharedRecipients')->middleware('auth:sanctum');
});

Route::controller(AuthController::class)->group(function () {
	Route::get('get-avatars', 'avatars');
});

Route::controller(SendNotificationController::class)->group(function () {
    Route::get('send-notification', 'sendNotifications');
});
