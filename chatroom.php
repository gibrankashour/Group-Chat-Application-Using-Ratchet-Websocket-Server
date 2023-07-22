<?php
    include 'core/init.php';

    if(!isset($_SESSION["user_data"])) {
        header('Location: /chat_application/index.php');
        exit();
    }
        
    if($_SERVER["REQUEST_METHOD"] == "POST") {
      $group_name = isset($_POST["group_name"]) && $_POST["group_name"] != null ?$_POST["group_name"] : "";
      $group_description = isset($_POST["group_description"]) && $_POST["group_description"] != null ?$_POST["group_description"] : "";
      
    }
    $user_data = $user_object->get_login_user_info();

    $groups = $user_object->get_login_user_groups();
    // الحصول على كل المستخدمين من أجل 
    $users = $user_object->get_all_users_except_me();

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title><?php $pageTitle ?></title>
    <!-- MDB icon -->
    <!-- <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon" /> -->
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    
    <link rel="stylesheet" href="vendor-front/bootstrap-5.3.0/bootstrap.css">
    <link rel="stylesheet" href="vendor-front/css/parsley.css">
    <!-- MDB -->
    <link rel="stylesheet" href="<?php echo BASE_URL?>/vendor-front/css/bootstrap-chat.min.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL?>/vendor-front/css/style.css">
    <script>
      var conn = new WebSocket('ws://localhost:8080?token=<?php echo $user_data['session_id'] ?>');
    </script>
</head>
<body>
  <span class="d-none" id="user_login_id"><?php echo $_SESSION['user_data']['id'] ?></span>
  <!-- Start your project here-->
  <section style="background-color: #eee;" class="main-section">
    <div class="container py-5">

      <div class="row">

        <div class="col-md-5 col-lg-4 col-xl-4 mb-4 mb-md-0">

          <div class="mb-3" id="image-profile">
              <img src="<?php echo BASE_URL . "/" . $user_data["user_profile"]?>" alt="" class="d-block mx-auto">
              <div class="d-flex justify-content-around mt-3">
                <a href="<?php echo BASE_URL ?>/profile.php" class="btn btn-info btn-sm">Edit</a>
                <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#create-group">Create group</a>
                <a href="<?php echo BASE_URL ?>/logout.php" class="btn btn-danger btn-sm">Logout</a>
              </div>
          </div>
          <h5 class="font-weight-bold mb-3 text-center text-lg-start">Groups</h5>

          <div class="card">
            <div class="card-body">

              <ul class="list-unstyled mb-0 groups-list">
                <?php if(!empty($groups)) {
                  foreach($groups as $group) { ?>
                  <li class="p-2 group" data-group="<?php echo $group["id"] ?>">
                    <a href="javascript:void(0)" class="d-flex justify-content-between">
                      <div class="d-flex flex-row">
                        <div class="pt-1">
                          <p class="fw-bold mb-0"><?php echo $group["name"] ?></p>
                          <p class="small text-muted group-description"><?php echo $group["description"] ?></p>
                        </div>
                        <div class="pt-1 new-message">
                          
                        </div>
                      </div>
                    </a>
                  </li>
                <?php 
                  }// end foreach
                }else {
                ?>
                <li id="no_groups_found">
                  <p class="lead m-0 ">
                    There are no groups to show, <a href="#" class="link-primary" data-bs-toggle="modal" data-bs-target="#create-group">Create One</a>
                  </p>
                </li>

                <?php } ?>
                
              </ul>

            </div>
          </div>

        </div>

        <div class="col-md-7 col-lg-8 col-xl-8">

          <ul class="list-unstyled h-100" id="messages">
            <li class="bg-white mb-3 h-100 d-flex align-items-center justify-content-center h4 rounded text-center">
                Please select group to show its messages
            </li>
          </ul>

          <ul class="list-unstyled d-none " id="send_message_form">
            <li class="bg-white mb-3">
              <div class="form-outline">
                <!-- هذه المعلومات تظهر عند الرسالة المرسلة من جهة المرسل -->
                <input type="hidden" name="user_profile" value="<?php echo $user_data["user_profile"] ?>">
                <input type="hidden" name="user_name" value="<?php echo $user_data["user_name"] ?>">
                <!-- معلومات عن المجموعة المفتوحة حاليا -->
                <input type="hidden" name="group_id" value="">
                <!-- الرسالة التي يريد المرسل ارسالها الى المجموعة -->
                <textarea class="form-control" id="messasge_conatainer" rows="4" name="message"></textarea>
                <label class="form-label" for="messasge_conatainer">Message</label>
              </div>
            </li>
            <button type="button" class="btn btn-info btn-rounded float-end" id="send_message">Send</button>
          </ul>

        </div>

      </div>

    </div>
  </section>


  <!-- Modal -->
  <div class="modal fade " id="create-group" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Create Group</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form  id="create-group-form">
          <div class="modal-body">
            <div class="mb-3">
              <label for="group-name" class="col-form-label">Group Name</label>
              <input type="text" class="form-control" id="group-name" name="group_name"
              data-parsley-minlength="4" data-parsley-maxlenght="12" data-parsley-pattern="^[\S]+.+[\S]+$" required>
            </div>
            <div class="mb-3">
              <label for="group-description" class="col-form-label">Group description</label>
              <textarea class="form-control" id=group-description" rows="5" name="group_description"
              data-parsley-minlength="6" data-parsley-maxlenght="100" data-parsley-pattern="^[\S]+.+[\S]+$" required></textarea>
            </div>
            <div class="mb-3">
              <label for="group_members" class="col-form-label d-block">Group members</label>
              <?php foreach($users as $user) { ?>
                <input data-parsley-mincheck="1" data-parsley-required type="checkbox" name="group_members[]" id="user-<?php echo $user["user_id"] ?>" value="<?php echo $user["user_id"] ?>">
                <label for="user-<?php echo $user["user_id"] ?>" class="me-2 ms-1"><?php echo $user["user_name"] ?></label>
              <?php } ?>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <input type="submit" value="Save changes" class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- End your project here-->

  <!-- MDB -->
  <script src="<?php echo BASE_URL?>/vendor-front/js/jquery-3.7.0.min.js"></script>
  <script src="vendor-front/bootstrap-5.3.0/bootstrap.bundle.js"></script>
  <script type="text/javascript" src="<?php echo BASE_URL?>/vendor-front/js/mdb.min.js"></script>
  <script type="text/javascript" src="<?php echo BASE_URL?>/vendor-front/js/chat.js"></script>
  <script src="vendor-front/js/parsley.js"></script>
  <script>
      $(document).ready(function(){
          
          $(".main-section").css("min-height", $(window).height());

          // الحصول على أي دي المستخدم المسجل دخول
          let user_login_id = $("span#user_login_id").html();
          // إنشاء مجموعة جديدة
          $("#create-group-form").parsley().on("form:submit", function() {
            let group_name = $("#create-group-form input[name=group_name]").val();
            let group_description = $("#create-group-form textarea[name=group_description]").val();
            var group_members = [];
            $("#create-group-form input:checked").each(function () {
              group_members.push($(this).val());
            });

            let data = {
              "action" : "createGroup",
              "group_name" : group_name,
              "group_description" : group_description,
              "group_members" : group_members,
            }
            data = $.param(data);
            $.ajax({
              type : "POST",
              dataType : "TEXT",
              url : "http://localhost/chat_application/action.php",
              data : data,
              success : function(data) {
                let group_id = data;
                // إضافة المجموعة الجديدة الى قائمة المجموعات
                let member = '<li class="p-2 group" data-group="'+group_id+'"><a href="javascript:void(0)" class="d-flex justify-content-between"><div class="d-flex flex-row"><div class="pt-1"><p class="fw-bold mb-0">'+ group_name +'</p><p class="small text-muted group-description">' + group_description + '</p></div><div class="pt-1 new-message"></div></div></a></li>';
                $("ul.groups-list").append(member);
                // حذف القسم الخاص بإضافة مجموعة من قائمة المجموعات
                $("ul.groups-list li#no_groups_found").detach();
                // إغلاق المودل الخاص بإنشاء مجموعة جديدة
                $("#create-group .btn-close").click();
                // 
                $(".groups-list .group").on("click", show_group_messages);
                // إرسال رسالة بالويب سوكيت حول إنشاء مجموعة جديدة
                send("create_group", [group_name, group_description], group_id);
                // حذف محتوى حقول الإدخال بعد إنشاء المجموعة 
                $("#create-group-form input[name=group_name]").val("");
                $("#create-group-form textarea[name=group_description]").val("");
                $("#create-group-form input:checked").each(function () {
                  $(this).prop('checked', false);
                });
              },
              error : function(e) {
                console.log(e)
              }
            });
            // بما اني اريد ارسال المعلومات كأجاكس وليس كظلب عادي
            // عندها يجب ان امنع ارسال المعلومات عند انتهاء عملية التحقق
            return false; // Don't submit form
          });
          // الحصول على الرسائل عند الضفظ على مجموعة ما
          $(".groups-list .group").on("click", show_group_messages);
          function show_group_messages() {
            $(this).addClass("active").siblings().removeClass("active");
            $(this).find(".new-message").html("");
            let group_id = $(this).data("group");
            // تحدييث بيانات المجموعة التي يتم ارسالها مع معلومات الرسالة
            $("input[name=group_id]").val(group_id)
            let data = {
              "action" : "groupMessages",
              "group_id" : group_id,
            }
            data = $.param(data);
            $.ajax({
              type : "POST",
              dataType : "JSON",
              url : "http://localhost/chat_application/action.php",
              data : data,
              success : function(data) {
                let returned_messages = data;
                let displayed_messages = "";
                returned_messages.forEach(function(message) {
                  if(message.user_id == user_login_id) {
                    displayed_messages += '<li class="d-flex justify-content-between mb-4"><div class="card w-100"><div class="card-header d-flex justify-content-between p-3"><p class="fw-bold mb-0">'+message.user_name+'</p><p class="text-muted small mb-0"><i class="far fa-clock"></i> '+message.created_at+'</p></div><div class="card-body"><p class="mb-0">'+message.message+'</p></div></div><img src="'+message.user_profile+'" alt="avatar" class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60"></li>';
                  }else {
                    displayed_messages += '<li class="d-flex justify-content-between mb-4"><img src="'+message.user_profile+'" alt="avatar" class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60"><div class="card w-100"><div class="card-header d-flex justify-content-between p-3"><p class="fw-bold mb-0">'+message.user_name+'</p><p class="text-muted small mb-0"><i class="far fa-clock"></i> '+message.created_at+'</p></div><div class="card-body"><p class="mb-0">'+message.message+'</p></div></div></li>';
                  }
                });
                $("ul#messages").html(displayed_messages);
                $("ul#messages").removeClass("h-100");
                $("ul#send_message_form").removeClass("d-none");

              } 
            });
          }
          function send(type, data, group_id) {
            // التابع conn.send يعيد قيمة 
            // undefined 
            // سواء كان الموقع متصل بسيرفر الرتشست او لم يكن متصل
            // لذلك حتى نعرف حالة الاتصال اولا قبل ارسال الرسالة نستخدم المتغير
            // conn.readyState
            if(conn.readyState == 1) {
              conn.send(JSON.stringify({
                group_id : group_id,
                type : type,
                data : data
              }));
              // conn.send() Return value :None (undefined).
              return true;
            }else {
              return false
            }
          }
      });
  </script>
  <script>
    let groups = document.querySelectorAll(".groups-list .group .group-description");
    groups.forEach(function(group){
      if(group.innerHTML.length > 100) {
        group.innerHTML = group.innerHTML.slice(0,100) + " ...";
      }
    });
  </script>
</body>
</html>
