<?php

class ChatUser {
    private $user_id;
    private $user_name;
    private $user_email;
    private $user_password;
    private $user_profile;
    private $user_status;
    private $user_created_on;
    private $user_verification_code;
    private $user_login_status;
    public $connect;

    public function __construct() 
    {
        // require_once('Database_connection.php');
        // بما أنو استدعيتو من ملف init.php
        // لهي مافي داعي أرجع استدعيه هون
        $database_object = new Database_connection();
        $this->connect = $database_object->connect();
    }
    // UserId
    function setUserId($user_id) {
        $this->user_id = $user_id;
    }
    function getUserId() {
        return $this->user_id;
    }
    // UserName
    function setUserName($user_name) {
        $this->user_name = $user_name;
    }
    function getUserName() {
        return $this->user_name;
    }
    // UserEmail
    function setUserEmail($user_email) {
        $this->user_email = $user_email;
    }
    function getUserEmail() {
        return $this->user_email;
    }
    // UserPassword
    function setUserPassword($user_password) {
        $this->user_password = $user_password;
    }
    function getUserPassword() {
        return $this->user_password;
    }
    // UserProfile
    function setUserProfile($user_profile) {
        $this->user_profile = $user_profile;
    }
    function getUserProfile() {
        return $this->user_profile;
    }
    // UserStatus
    function setUserStatus($user_status) {
        $this->user_status = $user_status;
    }
    function getUserStatus() {
        return $this->user_status;
    }
    // UserCreatedOn
    function setUserCreatedOn($user_created_on) {
        $this->user_created_on = $user_created_on;
    }
    function getUserCreatedOn() {
        return $this->user_created_on;
    }
    // UserVerificationCode
    function setUserVerificationCode($user_verification_code) {
        $this->user_verification_code = $user_verification_code;
    }
    function getUserVerificationCode() {
        return $this->user_verification_code;
    }
    // UserLoginStatus
    function setUserLoginStatus($user_login_status) {
        $this->user_login_status = $user_login_status;
    }
    function getUserLoginStatus() {
        return $this->user_login_status;
    }

    function make_avatar($character)
	{
	    $path = "images/". time() . ".png";
		$image = imagecreate(200, 200);
		$red = rand(0, 255);
		$green = rand(0, 255);
		$blue = rand(0, 255);
	    imagecolorallocate($image, $red, $green, $blue);  
        // لون الخظ للكلمة التي ستظهر في الصورة
	    $textcolor = imagecolorallocate($image, 255,255,255);
        // الخظ الذي سيتم استخدامه ويجب كتابة المسار كاملا والا سيظهر حظأ
	    $font = dirname(__FILE__) . '/font/arial_narrow_7.ttf';
        // هنا لأيجاد الأحداثيات الأفقية التي ستجعل الحرف يظهر في منتصف الصورة
        $tb = imagettfbbox(100, 0, $font, $character);
        $x = ceil((200 - $tb[2]) / 2); // lower left X coordinate for text

	    imagettftext($image, 100, 0, $x, 145, $textcolor, $font, $character);
	    imagepng($image, $path);
	    imagedestroy($image);
	    return $path;
	}
    
    function get_user_data_by_email()
    {
        $query = 'SELECT * FROM chat_user_table WHERE user_email = :user_mail';
        $statement = $this->connect->prepare($query);
        $statement->bindParam(':user_mail', $this->user_email);        
        if($statement->execute()){
            $user_data =  $statement->fetch(PDO::FETCH_ASSOC);
        }
        return $user_data;
    }
    function is_valid_email_verification_code($code)
    {
        $query = 'SELECT * FROM chat_user_table WHERE user_verification_code = :user_verification_code';
        $statement = $this->connect->prepare($query);
        $statement->bindParam(':user_verification_code', $code);        
        $statement->execute();
        if($statement->rowCount() > 0) {
            return true;
        }else {
            return false;
        }
    }
    // بالإعتماد على كود التفعيل الذي نحص عليه من الأيميل نختار اليوزر ونحدث معلوماته 
    function enable_user_account($code, $status) {
        $query = 'UPDATE chat_user_table 
                    SET user_status = :user_status
                    WHERE user_verification_code = :user_verification_code';
        $statement = $this->connect->prepare($query);
        $statement->bindParam(':user_status', $status);
        $statement->bindParam(':user_verification_code', $code);
        if($statement->execute()) {
            return true;
        }else {
            return false;
        }
    }
    // جعل المستخدم مسجل دخول أو مسجل خروج
    function update_user_login_data($status, $user_id =null) {
        if($user_id === null ) {
            $user_id = $_SESSION['user_data']['id']; 
        }
        $query = 'UPDATE chat_user_table 
        SET user_login_status = :user_login_status
        WHERE user_id = :user_id';
        $statement = $this->connect->prepare($query); 
        $statement->bindParam(':user_login_status', $status);
        $statement->bindParam(':user_id', $user_id);
        if($statement->execute()) {
            return true;
        }else {
            return false;
        }    
    }
    // تحديث معلومات السيشن الخاصة باليوز
    function update_user_session_id($session_id) {
        $query = 'UPDATE chat_user_table 
        SET session_id = :session_id
        WHERE user_id = :user_id';
        $statement = $this->connect->prepare($query); 
        $statement->bindParam(':session_id', $session_id);
        $statement->bindParam(':user_id', $_SESSION['user_data']['id']);
        if($statement->execute()) {
            return true;
        }else {
            return false;
        }   
    }
    // حفظ بيانات المستخدم في قاعدة البيانات
    function save_data() {
        $query = 'INSERT INTO 
                    chat_user_table 
                    (user_name, user_email, user_password, user_profile, user_status, user_created_on, user_verification_code)
                  VALUES (:user_name, :user_email, :user_password, :user_profile, :user_status, :user_created_on, :user_verification_code)';
        $statement = $this->connect->prepare($query);
        $statement->bindParam(':user_name', $this->user_name);          
        $statement->bindParam(':user_email', $this->user_email); 
        $hashed_password = password_hash($this->user_password, PASSWORD_DEFAULT);         
        $statement->bindParam(':user_password', $hashed_password);          
        $statement->bindParam(':user_profile', $this->user_profile);  
        $statement->bindParam(':user_status', $this->user_status);  
        $statement->bindParam(':user_created_on', $this->user_created_on);  
        $statement->bindParam(':user_verification_code', $this->user_verification_code);
        if($statement->execute()) {
            return true;
        }else {
            return false;
        }  
    }
    //إعادة التوجيه 
    public function redirect($location) {
        header('Location:' . BASE_URL . $location);
        exit();
    }
    //التحقق من تسجيل الدخول
    function is_logged_in() {
        return isset($_SESSION["user_data"])? true: false;
    }
    // تسجيل الخروج
    function logout() {   
        $this->update_user_login_data('Logout');     
        session_unset();
        session_destroy();
        // بعد حذف السيشن باستخدام التابع سيشن ديستروي يجب إعادة بدأ السيشن من جديد 
        // اذا كنت اريد وضع معلومات في السيشن
        // هالأستنتاج من عندي
        session_start();
        $_SESSION['success_message'] = 'You have successfully logout out from the system';
        return $this->redirect("/index.php");
    }
    // الحصول على معلومات المستخدم المسجل دخول
    function get_login_user_info() {
        if($this->is_logged_in()){
            $query = 'SELECT * FROM chat_user_table WHERE user_id = :user_id';
            $statement = $this->connect->prepare($query);
            $statement->bindParam(':user_id', $_SESSION["user_data"]["id"]); 
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        }else{
            return false;
        }
    }
    // الحصول على معلومات المستخدم بالأعتماد على معلومات السيشن
    function get_user_by_session_id($session_id) {
        $query = 'SELECT * FROM chat_user_table WHERE session_id = :session_id';
        $statement = $this->connect->prepare($query);
        $statement->bindParam(':session_id', $session_id); 
        $statement->execute();
        return $statement->fetch(PDO::FETCH_OBJ);

    }
    // تحديث بيانات المستخدم المسجل دخول
    function update_login_user_info($user_info) {
        if($user_info['photo']['name'] != null) {
            $photo_name = "images/". time() . '.' . pathinfo($user_info['photo']['name'], PATHINFO_EXTENSION);
            move_uploaded_file($user_info['photo']['tmp_name'], $photo_name);
            unlink($_SESSION['user_data']['profile']);
        }else {
            $photo_name = $_SESSION['user_data']['profile'];
        }

        if($user_info['password'] != null) {
            $query = 'UPDATE chat_user_table 
                        SET user_name = :user_name,
                            user_profile = :user_profile,
                            user_password = :user_password
                        WHERE user_id = :user_id';
            $statement = $this->connect->prepare($query); 
            $statement->bindParam(':user_name', $user_info['name']);
            $statement->bindParam(':user_profile', $photo_name);
            $hashed_password = password_hash($user_info['password'], PASSWORD_DEFAULT);
            $statement->bindParam(':user_password', $hashed_password);
            $statement->bindParam(':user_id', $_SESSION['user_data']['id']);
            if($statement->execute()) {
                $_SESSION['user_data']['name'] = $user_info['name'];
                $_SESSION['user_data']['profile'] = $photo_name;
                return true;
            }else {
                return false;
            }  
        }else {
            $query = 'UPDATE chat_user_table 
                        SET user_name = :user_name,
                            user_profile = :user_profile
                        WHERE user_id = :user_id';
            $statement = $this->connect->prepare($query); 
            $statement->bindParam(':user_name', $user_info['name']);
            $statement->bindParam(':user_profile', $photo_name);
            $statement->bindParam(':user_id', $_SESSION['user_data']['id']);
            if($statement->execute()) {
                $_SESSION['user_data']['name'] = $user_info['name'];
                $_SESSION['user_data']['profile'] = $photo_name;
                return true;
            }else {
                return false;
            } 
        }
    }
    // الحصول على محادثات مجموعة ما 
    function get_group_messages($group_id) {
        $query = 'SELECT messages.user_id as user_id,
                        messages.message as message,
                        messages.created_at as created_at,
                        chat_user_table.user_name as user_name,
                        chat_user_table.user_profile as user_profile 
                    FROM messages
                    INNER JOIN chat_user_table ON chat_user_table.user_id = messages.user_id
                    WHERE messages.group_id = :group_id ORDER BY messages.created_at ASC';
        $statement = $this->connect->prepare($query);
        $statement->bindParam(':group_id', $group_id);
        $statement->execute();
        $messages = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $messages;
    }
    // تحديث معلومات الاتصال عندما يدخل المستخدم الى صفحة المحادثة
    function update_connection_id($connection_id, $user_id) {
        $query = 'UPDATE chat_user_table SET connection_id = :connection_id WHERE user_id = :user_id';
        $statement = $this->connect->prepare($query);
        $statement->bindParam(':connection_id', $connection_id);
        $statement->bindParam(':user_id', $user_id);
        $statement->execute();
    }
    // الحصول على المساخدمين الموجودين في نفس المجموعة 
    function get_group_users($group_id) {
        $query = 'SELECT groups_users.*,
                        chat_user_table.connection_id as connection_id
                    FROM groups_users
                    INNER JOIN chat_user_table ON chat_user_table.user_id = groups_users.user_id
                    WHERE groups_users.group_id = :group_id';
        $statement = $this->connect->prepare($query);
        $statement->bindParam(':group_id', $group_id);        
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    // حفظ معلومات الرسالة المرسلة من قبل المستخدم 
    function save_message($message, $user_id, $group_id) {
        $query = 'INSERT INTO messages(message, user_id, group_id, created_at)
                    VALUES (:message, :user_id, :group_id, now())';
        $statement = $this->connect->prepare($query);
        $statement->bindParam(':message', $message);
        $statement->bindParam(':user_id', $user_id);
        $statement->bindParam(':group_id', $group_id);
        if($statement->execute()) {
            return true;
        }else {
            return false;
        }
    }
    // الحصول على المحموعات التي فيها المستخدم 
    function get_login_user_groups() {
        $query = 'SELECT * FROM groups WHERE id IN (SELECT group_id FROM groups_users WHERE user_id = :user_id)';
        $statement = $this->connect->prepare($query);
        $statement->bindParam(':user_id', $_SESSION['user_data']['id']);
        $statement->execute();
        $groups = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $groups;
    }
    // الحصول على كل المستخدمين باستثناءالمستخدم المسجل دخول
    function get_all_users_except_me() {
        $query = 'SELECT * FROM chat_user_table WHERE user_id != :user_id';
        $statement = $this->connect->prepare($query);
        $statement->bindParam(':user_id', $_SESSION['user_data']['id']);
        $statement->execute();
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
        return $users;
    }
    // إنشاء مجموعة جديدة
    function create_group($group_name, $group_description, $group_members) {
        // إنشاء المجموعة
        $query = 'INSERT INTO groups (user_creator_id, name, description, created_at)
                    VALUES (:user_creator_id, :name, :description, now())';
        $statement = $this->connect->prepare($query);
        $statement->bindParam(':user_creator_id', $_SESSION['user_data']['id']);
        $statement->bindParam(':name', $group_name);
        $statement->bindParam(':description', $group_description);
        $statement->execute();
        $group_id = $this->connect->lastInsertId();
        // إضافة الأعضاء إلى المجموعة
        foreach($group_members as $group_member) {
            $query = 'INSERT INTO groups_users (group_id, user_id) VALUES (:group_id, :user_id)';
            $statement = $this->connect->prepare($query);
            $statement->bindParam(':group_id', $group_id);
            $statement->bindParam(':user_id', $group_member);
            $statement->execute();    
        }
        // إضافة منشئ المجموعة الى المجموعة
        $query = 'INSERT INTO groups_users (group_id, user_id) VALUES (:group_id, :user_id)';
        $statement = $this->connect->prepare($query);
        $statement->bindParam(':group_id', $group_id);
        $statement->bindParam(':user_id', $_SESSION['user_data']['id']);
        $statement->execute(); 
        return $group_id;
    }
}
?>
