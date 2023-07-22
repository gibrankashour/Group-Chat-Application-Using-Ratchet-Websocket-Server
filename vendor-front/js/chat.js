$(function () {
	"use strict";

	let user_profile = document.querySelector("input[name=user_profile]");
	let user_name = document.querySelector("input[name=user_name]");
	// الحصول على أي دي المستخدم المسجل دخول
	let user_login_id = $("span#user_login_id").html();
	// جلب الديف الذي سنعرض ضمنه رسائل المحادثة
	let messages_container = document.getElementById("messages");
	// جلب حقل إدخال محتوى الرسالة
	let message_container = document.getElementById("messasge_conatainer");
	let messageBtn = document.getElementById("send_message");
	
	messageBtn.addEventListener("click", () => {
		if(message_container.value != null) {
			// اذا تم عملية ارسال الرسالة بنجاح نضيف محتوى الرسالة الى المحادثة
			// وايضا نحذف حتوى التكست أيريا
			let group_id = document.querySelector("input[name=group_id]").value;
			// نحفظ الرسالة أولا في قاعدة البيانات ثم نرسلها عن ظريق الويب سوكيت سيرفر
			let data = {
				"action" : "saveMessage",
				"group_id" : group_id,
				"user_id" : user_login_id,
				"message" : message_container.value,
			} 
			data = $.param(data);
			$.ajax({
				type : "POST",
				dataType : "TEXT",
				url : "http://localhost/chat_application/action.php",
				data : data,
				success : function(data) {
					if(data == 'saved') {
						// بعد حفظ الرسالة في قاعدة البيانات نقوم بإرسال الرسالة إلى الويب سوكيت
						let sended_message = '<li class="d-flex justify-content-between mb-4"><div class="card w-100"><div class="card-header d-flex justify-content-between p-3"><p class="fw-bold mb-0">'+user_name.value+'</p><p class="text-muted small mb-0"><i class="far fa-clock"></i> ' + show_time() +'</p></div><div class="card-body"><p class="mb-0">'+message_container.value+'</p></div></div><img src="'+user_profile.value+'" alt="avatar"class="rounded-circle d-flex align-self-start ms-3 shadow-1-strong" width="60"></li>';
						messages_container.insertAdjacentHTML("beforeend", sended_message);
						send("send_message", message_container.value, group_id);
						message_container.value = "";
					}
				},
			});			
		}
	}); 

	// التابع التالي يعمل عند الأتصال مع الويب سوكيت سيرفر
	conn.onopen = e => {
		console.log("connected to websocket server");
	}
	// عند استقبال رسالة من المرسلين الأخرين
	conn.onmessage = async e => {
		let message     = JSON.parse(e.data);
		console.log(message);
		// variables
		let by;
		let user_name;
		let user_profile;
		let message_content;
		let message_group_id;

		let group_id;
		let group_name;
		let group_description;
		// 
		let type = message.type;
		switch(type) {
			case "send_message":
				by = message.by;
				user_name = message.user_name;
				user_profile = message.user_profile;
				message_content = message.message;
				message_group_id = message.group_id;

				group_id = document.querySelector("input[name=group_id]").value;
				if(message_group_id == group_id) {
					let received_message = '<li class="d-flex justify-content-between mb-4"><img src="'+user_profile+'" alt="avatar"class="rounded-circle d-flex align-self-start me-3 shadow-1-strong" width="60"><div class="card w-100"><div class="card-header d-flex justify-content-between p-3"><p class="fw-bold mb-0">'+user_name+'</p><p class="text-muted small mb-0"><i class="far fa-clock"></i> ' + show_time() +'</p></div><div class="card-body"><p class="mb-0">'+message_content+'</p></div></div></li>';
					messages_container.insertAdjacentHTML("beforeend", received_message);
				}else {
					$(".groups-list .group[data-group="+message_group_id+"]").find(".new-message").html('<span class="badge bg-dark float-end small ">new message</span>');
				}				
			break;
			case "create_group":
				 
				// let by = message.by;
				user_name = message.user_name;
				user_profile = message.user_profile;
				group_id = message.group_id;
				group_name = message.group_name;
				group_description = message.group_description;
				// إضافة مجموعة جديدة
                let member = '<li class="p-2 group" data-group="'+group_id+'"><a href="javascript:void(0)" class="d-flex justify-content-between"><div class="d-flex flex-row"><div class="pt-1"><p class="fw-bold mb-0">'+ group_name +'</p><p class="small text-muted group-description">' + group_description + '</p></div><div class="pt-1 new-message"></div></div></a></li>';
                $("ul.groups-list").append(member);	
				// حذف القسم الخاص بإضافة مجموعة من قائمة المجموعات
                $("ul.groups-list li#no_groups_found").detach();
				// ظبعا لازم أرجع أكتب الكود مرة تانية هون لانو هالعناصر انضافت بعد تحميل 
				// dom
				// لهي بس كنت اكبس عالمجموعة الجديدة ما كانت تفتح المحادثة
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
			break;
		}
	}

	// ----------------
	// functions
	// ----------------
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

	function show_time() {
		var currentdate = new Date(); 
		var datetime = 
				  currentdate.getFullYear() + "-"  
				+ ((currentdate.getMonth()+1) > 10? (currentdate.getMonth()+1) : "0" + (currentdate.getMonth()+1))  + "-" 
				+ currentdate.getDate() + " "
				+ currentdate.getHours() + ":"  
				+ currentdate.getMinutes() + ":" 
				+ currentdate.getSeconds();
		return datetime;		
	}


})
