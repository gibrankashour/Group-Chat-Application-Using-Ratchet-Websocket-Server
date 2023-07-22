<?php
namespace MyApp;

use ChatUser;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
// $user_object->update_connection_id();
require "ChatUser.php";
require "Database_connection.php";

class Chat implements MessageComponentInterface {
    protected $clients;
    public $user_object, $data;

    public function __construct() {         
        $this->clients = new \SplObjectStorage;
        $this->user_object = new ChatUser;
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
         
        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $query);
        if($data = $this->user_object->get_user_by_session_id($query["token"])){
            $this->data = $data;
            // إضافة معلومات المستخدم المتصل إلى المتغير $conn
            $conn->data = $data; 
            $this->clients->attach($conn);
            //تحديث بيانات المستخدم المتصل بالويب سوكيت سيرفر في قاعدة البيانات
            $this->user_object->update_connection_id($conn->resourceId, $this->data->user_id);
            echo "New connection! ({$this->data->user_name})-({$conn->resourceId})\n";
        }
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');
        // تحليل معلومات الرسالة التي أتت الى راتشيت سيرفر قبل ارسالها الى المستقبلين
        $data = json_decode($msg, true);
        if($data['type'] == "create_group") {
            // معلومات الرسالة التي سيتم ارسالها الى باقي المرسلين
            $send['type'] = $data["type"];    
            $send['by'] = $from->data->user_id;     
            $send['user_name'] = $from->data->user_name;     
            $send['user_profile'] = $from->data->user_profile;   
            $send['group_id'] = $data["group_id"]; 
            $send['group_name'] = $data["data"][0];     
            $send['group_description'] = $data["data"][1];   
              
            $users = $this->user_object->get_group_users($data["group_id"]);
            var_dump($users);
            foreach ($this->clients as $client) {
                if ($from !== $client) {
                    // The sender is not the receiver, send to each client connected
                    foreach($users as $user) {
                        if($user['connection_id'] == $client->resourceId) {
                            $client->send(json_encode($send));
                            break;
                        }
                    }
                }
            }
        }elseif($data['type'] == "send_message") {
            // حفظ الرسالة في قاعدة البيانات
            // $this->user_object->save_message($data["data"],$from->data->user_id, $data["group_id"]);
            // معلومات الرسالة التي سيتم ارسالها الى باقي المرسلين
            $send['by'] = $from->data->user_id;     
            $send['user_name'] = $from->data->user_name;     
            $send['user_profile'] = $from->data->user_profile;     
            $send['type'] = $data["type"];     
            $send['message'] = $data["data"];     
            $send['group_id'] = $data["group_id"];     
            $users = $this->user_object->get_group_users($data["group_id"]);
            foreach ($this->clients as $client) {
                if ($from !== $client) {
                    // The sender is not the receiver, send to each client connected
                    foreach($users as $user) {
                        if($user['connection_id'] == $client->resourceId) {
                            $client->send(json_encode($send));
                            break;
                        }
                    }
                }
            }
        }

    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}