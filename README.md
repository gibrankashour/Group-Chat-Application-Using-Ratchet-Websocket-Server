# Group Chat Application Using Ratchet Websocket Server

## Description

It is a simple group chat application using Ratchet websocket server where user can make a group chat with other users in the system

## Features

- Create a new account 
- Send verification code to user email to verify the new account
- User can update his or her information
- User can make new groups
- Users can communicate with each others through groups  

## Notes 

- I use mailtrap to test emails so in ``` core/classes/SendEmail.php ``` file you must update username and password to your mailtrap sittings to send email verification code to your account 
- To run ratchet websocket server run this command in your terminal```  php bin/chat-server.php ```

