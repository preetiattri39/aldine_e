<?php

return [

    "ERROR" => [
        "AUTHORIZATION"      => "Oops! You do not have permission to access.",
        "ACCOUNT_ISSUE"      => "Oops! Your account is not verified. Please check your email.",
        "INVALID_CREDENTIAL" => "The entered credentials are incorrect.",
        "NOT_FOUND"          => "Not found!",
        "SOMETHING_WRONG"    => "Oops! Something went wrong.",
        "TOKEN_EXPIRED"      => "Oops! Token expired.",
        "DELETED_ACCOUNT"    => "Your account is temporarily deleted. Please contact Admin.",
        "NO_CARDS"           => "No cards available.",
        "SELF_CONNECTION"    => "You cannot connect with yourself.",
        "REQUEST_EXISTS"     => "Request already exists.",
    ],

    "SUCCESS" => [
        "UPDATE_DONE"   => "has been updated successfully.",
        "ADD_DONE"      => "has been added successfully.",
        "CREATE_DONE"   => "has been created successfully.",
        "CHANGED_DONE"  => "has been changed successfully.",
        "DELETE_DONE"   => "has been deleted successfully.",
        "FETCH_DONE"    => "fetched successfully.",
        "VERIFY_SEND"   => "has been created successfully. Please check your email and verify your address.",
        "VERIFY_LOGIN"  => "has not been verified. Please check your email.",
        "VERIFY_DONE"   => "has been verified successfully.",
        "LOGIN"         => "Login successful.",
        "SENT_DONE"     => "has been sent successfully.",
        "LOGOUT_DONE"   => "Logged out successfully.",
        "DONE"          => "has been done successfully.",
        "RESTORE_DONE"  => "has been restored successfully.",
        
        //  CONNECTION-SPECIFIC MESSAGES
        "REQUEST_SENT"      => "Connection request sent successfully.",
        "REQUEST_ACCEPTED"  => "Connection request accepted.",
        "REQUEST_REJECTED"  => "Connection request rejected.",
        "CONNECTIONS_FETCHED" => "Connections fetched successfully.",
        
    ],

    "ROLES" => [
        "ADMIN" => "admin",
        "USER"  => "user",
    ],

    "APP_NAME"         => "Aldine E",
    "COMPANYNAME"      => env('APP_NAME', 'Aldine E'),
    "encryptionMethod" => env('ENC_DEC_METHOD', ''),
    "secrect"          => env('ENC_DEC_SECRET', ''),
    "STRIPE_KEY"       => env('STRIPE_KEY', ''),
    "STRIPE_SECRET"    => env('STRIPE_SECRET', ''),
];
