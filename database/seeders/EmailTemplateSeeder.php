<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmailTemplate::updateOrCreate([
            'template_name' => 'Otp_Verification'
        ],[
            'template' => '<!doctype html>
                <html>
                <head>
                    <title>{{$companyName}}</title>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="x-apple-disable-message-reformatting">
                    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
                    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;1,400;1,700&amp;display=swap" rel="stylesheet" />
                    <style type="text/css">
                        body, td,p {
                        font-family: Helvetica, Arial, sans-serif !important;
                        }
                    </style>
                </head>
                <body>
                    <table style="margin: auto;background:#f5f5f5;" role="presentation" border="0" cellspacing="0" cellpadding="0" align="center" width="600">
                        <tbody>
                            <tr>
                                <td style="padding: 1.5em 2.5em 1.5em 2.5em; background-color:#79a1e1;" valign="top" align="center">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="230">
                                        <tbody>
                                            <tr>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" align="center" style="background-color:#79a1e1;padding:0px 10px 0;">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="540">
                                        <tbody>
                                            <tr>
                                                <td valign="top" style="padding: 0em 2em 1em;background:#ffffff;" valign="middle">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <!-- end tr -->
                            <tr>
                                <td style="padding: 0em 2em 1.5em; background:#f5f5f5;" valign="middle">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="540">
                                        <tbody>
                                            <tr>
                                                <td valign="top" style="padding: 0em 2.5em 2em;background:#ffffff;">
                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 18px; padding-top: 0; line-height: 1.4; font-weight: bold;font-family: Helvetica, Arial, sans-serif;">
                                                                    Hello {{$name}},
                                                                </td>
                                                            </tr>
                                                             <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 16px; padding:15px 0 15px; line-height: 1.4; font-weight: 400;font-family: Helvetica, Arial, sans-serif;">
                                                                    Welcome to {{$COMPANYNAME}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 16px; padding:15px 0 15px; line-height: 1.4; font-weight: 400;font-family: Helvetica, Arial, sans-serif;">
                                                                    Please verify your email address via enter otp.
                                                                </td>
                                                            </tr>
                                                            
                                                            
                                                             <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 16px; padding-top: 0px; line-height: 1.4; font-weight: 400;font-family: Helvetica, Arial, sans-serif;word-break: break-all;">
                                                                    <p style="text-align: left;">Verification OTP:- {{$otp}}</p>
                                                                </td>
                                                            </tr>
                                  
                                                            <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 16px; padding-top: 30px; line-height: 1.4; font-weight: 400;font-family: Helvetica, Arial, sans-serif;">
                                                                    Thanks<br><strong>{{$COMPANYNAME}} Team</strong>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td style="padding: 15px 20px 15px;background:#79a1e1;" align="center">
                                    <p style="margin: 0; font-size: 12px;font-family: Helvetica, Arial, sans-serif;">&copy; {{YEAR}} <a style="color: #141637;" >{{$COMPANYNAME}}</a>. All Rights Reserved</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </body>
            </html>',
            'subject' => 'Email Address Verification',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        EmailTemplate::updateOrCreate([
            'template_name' => 'Forget_password'
        ],[
            'template' => '<!doctype html>
                <html>
                <head>
                    <title>{{$companyName}}</title>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="x-apple-disable-message-reformatting">
                    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
                    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;1,400;1,700&amp;display=swap" rel="stylesheet" />
                    <style type="text/css">body, td,p {
                        font-family: Helvetica, Arial, sans-serif !important;
                        }
                    </style>
                </head>
                <body>
                    <table style="margin: auto;background:#f5f5f5;" role="presentation" border="0" cellspacing="0" cellpadding="0" align="center" width="600">
                        <tbody>
                            <tr>
                                <td style="padding: 1.5em 2.5em 1.5em 2.5em; background-color:#79a1e1;" valign="top" align="center">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="230">
                                        <tbody>
                                            <tr>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" align="center" style="background-color:#79a1e1;padding:0px 10px 0;">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="540">
                                        <tbody>
                                            <tr>
                                                <td valign="top" style="padding: 0em 2em 1em;background:#ffffff;" valign="middle">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <!-- end tr -->
                            <tr>
                                <td style="padding: 0em 2em 1.5em; background:#f5f5f5;" valign="middle">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="540">
                                        <tbody>
                                            <tr>
                                                <td valign="top" style="padding: 0em 2.5em 2em;background:#ffffff;">
                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 18px; padding-top: 0; line-height: 1.4; font-weight: bold;font-family: Helvetica, Arial, sans-serif;">
                                                                    Hello {{$name}},
                                                                </td>
                                                            </tr>
                                                             <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 16px; padding:15px 0 15px; line-height: 1.4; font-weight: 400;font-family: Helvetica, Arial, sans-serif;">
                                                                    Welcome to {{$COMPANYNAME}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 16px; padding:15px 0 15px; line-height: 1.4; font-weight: 400;font-family: Helvetica, Arial, sans-serif;">
                                                                    Please reset your password via enter otp .
                                                                </td>
                                                            </tr>
                                                            
                                                            
                                                             <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 16px; padding-top: 0px; line-height: 1.4; font-weight: 400;font-family: Helvetica, Arial, sans-serif;word-break: break-all;">
                                                                    <p style="text-align: left;">Verification OTP:- {{$otp}}</p>
                                                                </td>
                                                            </tr>
                                  
                                                            <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 16px; padding-top: 30px; line-height: 1.4; font-weight: 400;font-family: Helvetica, Arial, sans-serif;">
                                                                    Thanks<br><strong>{{$COMPANYNAME}} Team</strong>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td style="padding: 15px 20px 15px;background:#79a1e1;" align="center">
                                    <p style="margin: 0; font-size: 12px;font-family: Helvetica, Arial, sans-serif;">&copy; {{YEAR}} <a style="color: #141637;" >{{$COMPANYNAME}}</a>. All Rights Reserved</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </body>
            </html>',
            'subject' => 'Reset New Password',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        EmailTemplate::updateOrCreate([
            'template_name' => 'Web_Forget_password'
        ],[
            'template' => '<!doctype html>
                <html>
                <head>
                    <title>{{$companyName}}</title>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="x-apple-disable-message-reformatting">
                    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
                    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;1,400;1,700&amp;display=swap" rel="stylesheet" />
                    <style type="text/css">body, td,p {
                        font-family: Helvetica, Arial, sans-serif !important;
                        }
                    </style>
                </head>
                <body>
                    <table style="margin: auto;background:#f5f5f5;" role="presentation" border="0" cellspacing="0" cellpadding="0" align="center" width="600">
                        <tbody>
                            <tr>
                                <td style="padding: 1.5em 2.5em 1.5em 2.5em; background-color:#79a1e1;" valign="top" align="center">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="230">
                                        <tbody>
                                            <tr>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" align="center" style="background-color:#79a1e1;padding:0px 10px 0;">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="540">
                                        <tbody>
                                            <tr>
                                                <td valign="top" style="padding: 0em 2em 1em;background:#ffffff;" valign="middle">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <!-- end tr -->
                            <tr>
                                <td style="padding: 0em 2em 1.5em; background:#f5f5f5;" valign="middle">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="540">
                                        <tbody>
                                            <tr>
                                                <td valign="top" style="padding: 0em 2.5em 2em;background:#ffffff;">
                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 18px; padding-top: 0; line-height: 1.4; font-weight: bold;font-family: Helvetica, Arial, sans-serif;">
                                                                    Hello {{$name}},
                                                                </td>
                                                            </tr>
                                                             <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 16px; padding:15px 0 15px; line-height: 1.4; font-weight: 400;font-family: Helvetica, Arial, sans-serif;">
                                                                    Welcome to {{$COMPANYNAME}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 16px; padding:15px 0 15px; line-height: 1.4; font-weight: 400;font-family: Helvetica, Arial, sans-serif;">
                                                                    Click here to reset password.
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                              <td>
                                                                    <button style="background-color: #79a1e1; color: #ffffff; padding: 10px 15px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border: none; border-radius: 12px;"><a href="{{$token}}" target="_blank">Click Here</a></button>

                                                              </td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 16px; padding-top: 0px; line-height: 1.4; font-weight: 400;font-family: Helvetica, Arial, sans-serif;word-break: break-all;">
                                                                    <p style="text-align: left;">Or copy the url and paste on browser for reset password</p>
                                                                </td>
                                                            </tr>
                                                            
                                                            <tr>
                                                              <td valign="top" style="text-align: left; color: #000000; font-size: 16px; padding-top: 0px; line-height: 1.4; font-weight: 400;font-family: Helvetica, Arial, sans-serif;word-break: break-all;">
                                                                  <p style="text-align: left;">Reset Url:- {{$token}}</p>
                                                              </td>
                                                            </tr>
                                  
                                                            <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 16px; padding-top: 30px; line-height: 1.4; font-weight: 400;font-family: Helvetica, Arial, sans-serif;">
                                                                    Thanks<br><strong>{{$COMPANYNAME}} Team</strong>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td style="padding: 15px 20px 15px;background:#79a1e1;" align="center">
                                    <p style="margin: 0; font-size: 12px;font-family: Helvetica, Arial, sans-serif;">&copy; {{YEAR}} <a style="color: #141637;" >{{$COMPANYNAME}}</a>. All Rights Reserved</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </body>
            </html>',
            'subject' => 'Reset New Password',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);



        EmailTemplate::updateOrCreate([
            'template_name' => 'Account_detail'
        ],[
            'template' => '<!doctype html>
                <html>
                <head>
                    <title>{{$companyName}}</title>
                    <meta charset="utf-8">
                    <meta name="viewport" content="width=device-width">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="x-apple-disable-message-reformatting">
                    <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
                    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;1,400;1,700&amp;display=swap" rel="stylesheet" />
                    <style type="text/css">body, td,p {
                        font-family: Helvetica, Arial, sans-serif !important;
                        }
                    </style>
                </head>
                <body>
                    <table style="margin: auto;background:#f5f5f5;" role="presentation" border="0" cellspacing="0" cellpadding="0" align="center" width="600">
                        <tbody>
                            <tr>
                                <td style="padding: 1.5em 2.5em 1.5em 2.5em; background-color:#79a1e1;" valign="top" align="center">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="230">
                                        <tbody>
                                            <tr>
                                                
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" align="center" style="background-color:#79a1e1;padding:0px 10px 0;">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="540">
                                        <tbody>
                                            <tr>
                                                <td valign="top" style="padding: 0em 2em 1em;background:#ffffff;" valign="middle">
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <!-- end tr -->
                            <tr>
                                <td style="padding: 0em 2em 1.5em; background:#f5f5f5;" valign="middle">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="540">
                                        <tbody>
                                            <tr>
                                                <td valign="top" style="padding: 0em 2.5em 2em;background:#ffffff;">
                                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 18px; padding-top: 0; line-height: 1.4; font-weight: bold;font-family: Helvetica, Arial, sans-serif;">
                                                                    Hello {{$name}},
                                                                </td>
                                                            </tr>
                                                             <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 16px; padding:15px 0 15px; line-height: 1.4; font-weight: 400;font-family: Helvetica, Arial, sans-serif;">
                                                                    Welcome to {{$COMPANYNAME}}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 16px; padding:15px 0 15px; line-height: 1.4; font-weight: 400;font-family: Helvetica, Arial, sans-serif;">
                                                                    Your account has been created successfully. Now you can login with the following credentials:-
                                                                </td>
                                                            </tr>
                                                            
                                                            
                                                             <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 16px; padding-top: 0px; line-height: 1.4; font-weight: 400;font-family: Helvetica, Arial, sans-serif;word-break: break-all;">
                                                                    <p style="text-align: left;">Email:- {{$email}}</p>
                                                                </td>
                                                            </tr>
                                                            
                                                             <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 16px; padding-top: 0px; font-weight: 400;font-family: Helvetica, Arial, sans-serif;word-break: break-all;">
                                                                    <p style="text-align: left;">Password:- {{$password}}</p>
                                                                </td>
                                                            </tr>
                                  
                                                            <tr>
                                                                <td valign="top" style="text-align: left; color: #000000; font-size: 16px; padding-top: 30px; line-height: 1.4; font-weight: 400;font-family: Helvetica, Arial, sans-serif;">
                                                                    Thanks<br><strong>{{$COMPANYNAME}} Team</strong>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td style="padding: 15px 20px 15px;background:#79a1e1;" align="center">
                                    <p style="margin: 0; font-size: 12px;font-family: Helvetica, Arial, sans-serif;">&copy; {{YEAR}} <a style="color: #141637;" >{{$COMPANYNAME}}</a>. All Rights Reserved</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </body>
            </html>',
            'subject' => 'User Account Detail',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);


        EmailTemplate::updateOrCreate([
            'template_name' => 'Contact_Reply'
        ], [
            'template' => '<!doctype html>
        <html>
        <head>
            <title>{{$companyName}}</title>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="x-apple-disable-message-reformatting">
            <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
            <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;1,400;1,700&amp;display=swap" rel="stylesheet" />
            <style type="text/css">body, td, p {
                font-family: Helvetica, Arial, sans-serif !important;
            }</style>
        </head>
        <body>
            <table style="margin: auto; background:#f5f5f5;" role="presentation" border="0" cellspacing="0" cellpadding="0" align="center" width="600">
                <tbody>
                    <tr>
                        <td style="padding: 1.5em 2.5em; background-color:#79a1e1;" align="center">
                            <h2 style="color:#ffffff;margin:0;">{{$companyName}}</h2>
                        </td>
                    </tr>
        
                    <tr>
                        <td style="padding: 2em; background-color: #ffffff;">
                            <p style="font-size: 18px; font-weight: bold; margin: 0;">Hello {{$name}},</p>
                            <p style="font-size: 16px; margin-top: 15px;">
                                Thank you for reaching out to {{$companyName}}.
                            </p>
                            <p style="font-size: 16px; margin-top: 15px;">
                                <strong>Your message:</strong><br>
                                {{$user_message}}
                            </p>
                            <p style="font-size: 16px; margin-top: 20px;">
                                <strong>Our reply:</strong><br>
                                {{$reply_message}}
                            </p>
                            <p style="font-size: 16px; margin-top: 30px;">
                                If you have any more questions, feel free to reply to this email.
                            </p>
                            <p style="font-size: 16px; margin-top: 30px;">
                                Thanks,<br>
                                <strong>{{$companyName}} Team</strong>
                            </p>
                        </td>
                    </tr>
        
                    <tr>
                        <td style="padding: 15px 20px; background:#79a1e1;" align="center">
                            <p style="margin: 0; font-size: 12px; color:#fff;">&copy; {{YEAR}} {{$companyName}}. All Rights Reserved.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </body>
        </html>',
            'subject' => 'Reply from {{$companyName}}',
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
           EmailTemplate::updateOrCreate(
            ['template_name' => 'Contact_submit'],
            [
                'template' => '<!doctype html>
                    <html>
                    <head>
                        <title>{{$companyName}}</title>
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                        <meta name="x-apple-disable-message-reformatting">
                        <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
                        <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;1,400;1,700&amp;display=swap" rel="stylesheet" />
                        <style type="text/css">body, td, p {
                            font-family: Helvetica, Arial, sans-serif !important;
                        }</style>
                    </head>
                    <body>
                        <table style="margin: auto; background:#f5f5f5;" role="presentation" border="0" cellspacing="0" cellpadding="0" align="center" width="600">
                            <tbody>
                                <tr>
                                    <td style="padding: 1.5em 2.5em; background-color:#79a1e1;" align="center">
                                        <h2 style="color:#ffffff;margin:0;">{{$companyName}}</h2>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding: 2em; background-color: #ffffff;">
                                        <p style="font-size: 18px; font-weight: bold; margin: 0;">Hello {{$name}},</p>
                                        <p style="font-size: 16px; margin-top: 15px;">
                                            Thank you for reaching out to {{$companyName}}. We will get back to you soon!
                                        </p>
                                       
                                        <p style="font-size: 16px; margin-top: 30px;">
                                            If you have any more questions, feel free to reply to this email.
                                        </p>
                                        <p style="font-size: 16px; margin-top: 30px;">
                                            Thanks,<br>
                                            <strong>{{$companyName}} Team</strong>
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding: 15px 20px; background:#79a1e1;" align="center">
                                        <p style="margin: 0; font-size: 12px; color:#fff;">&copy; {{YEAR}} {{$companyName}}. All Rights Reserved.</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </body>
                    </html>',
                'subject' => 'Thank you for reaching out',
                'status' => 1,
                'created_at' =>  date('Y-m-d H:i:s'),
                
            ]);
            EmailTemplate::updateOrCreate([
                'template_name' => 'Newsletter_Subscribed'
            ],[
                'template' => '<!doctype html>
            <html>
            <head>
                <title>{{$companyName}}</title>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="x-apple-disable-message-reformatting">
                <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
                <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
                <style type="text/css">
                    body, td, p {
                        font-family: Helvetica, Arial, sans-serif !important;
                    }
                </style>
            </head>
            <body>
                <table style="margin: auto; background:#f5f5f5;" border="0" cellspacing="0" cellpadding="0" align="center" width="600">
                    <tr>
                        <td style="padding: 1.5em 2em; background-color:#79a1e1; text-align: center;">
                            <h2 style="color:#ffffff;">{{$companyName}}</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#ffffff; padding: 2em;">
                            <h3 style="color:#333;">Hello {{$name}},</h3>
                            <p style="font-size:16px; color:#555;">
                                Thank you for subscribing to the <strong>{{$companyName}}</strong> newsletter!
                            </p>
                            <p style="font-size:16px; color:#555;">
                                You’ll now receive weekly updates, learning resources, and the latest features — straight to your inbox.
                            </p>
                            <p style="font-size:16px; color:#555;">
                                Stay tuned and happy learning!
                            </p>
                            <p style="margin-top: 30px;">
                                Cheers,<br>
                                <strong>{{$companyName}} Team</strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 15px 20px; background:#79a1e1; text-align:center;">
                            <p style="margin: 0; font-size: 12px; color:#ffffff;">
                                &copy; {{YEAR}} {{$companyName}}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </body>
            </html>',
                'subject' => 'Thank you for subscribing to our newsletter!',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);


            EmailTemplate::updateOrCreate([
                'template_name' => 'Newsletter_Announcement'
            ], [
                'template' => '<!doctype html>
            <html>
            <head>
                <title>{{companyName}}</title>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta http-equiv="Content-Type" content="text/html charset=UTF-8" />
                <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
                <style type="text/css">
                    body, td, p {
                        font-family: Helvetica, Arial, sans-serif !important;
                    }
                </style>
            </head>
            <body>
                <table align="center" width="600" style="margin:auto;background:#f9f9f9;" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td style="background-color:#4a90e2;padding:20px;text-align:center;color:#fff;">
                            <h1>{{companyName}}</h1>
                        </td>
                    </tr>
                    <tr>
                     <h3 style="color:#333;">Hello {{$name}},</h3>
                        <td style="padding:30px;background:#ffffff;">
                            <h2 style="color:#333;">{{title}}</h2>
                            <p style="color:#555;font-size:16px;line-height:1.5;">{!!message!!}</p>
                            <br>
                            <p>Best regards,<br><strong>{{companyName}} Team</strong></p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:15px;background:#4a90e2;text-align:center;color:#fff;">
                            <p style="margin:0;font-size:12px;">&copy; {{YEAR}} {{companyName}}. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </body>
            </html>',
                'subject' => 'Latest Announcement from {{companyName}}',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            
            


    }
}
