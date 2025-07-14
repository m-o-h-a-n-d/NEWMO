import "./bootstrap";

if (role === "user") {
    window.Echo.private("users." + userId) // listing for events

        .notification((event) => {
            $(".alert.alert-warning").remove();
            $("#push-notification").prepend(`
            <div style="padding-bottom: 20px; margin: 40px 0; ">
            <a href="${event.url}?notify=${event.id}"
                        class="dropdown-item d-flex align-items-start"
                        style="text-decoration: none; background-color:white; gap: 15px;  ">
                        <img src="${event.commenter_image}"
                            class="rounded-circle" width="50" height="50"
                            style="object-fit: cover; flex-shrink: 0;" alt="User Image" />
                        <div class="flex-grow-1">
                            <strong class="d-block mb-1">
                                ${event.commenter_name}
                            </strong>
                            <div class="small text-muted mb-1">
                                علق على: <strong>${event.post_title}</strong>
                            </div>
                            <div class="text-dark" style="font-size: 14px;"  title="${
                                event.comment
                            }">
                                    ${event.comment.substring(0, 10)}
                            </div>
                        </div>
            </a>
            </div>


            `);

            count = Number($("#cont-notification").text());
            count++;
            $("#cont-notification").text(count);
        });
}
if (role === "admin") {
    window.Echo.private("admins." + adminId).notification((event) => {
        $(".alert.alert-warning").remove(); // ✅ امسح رسالة "لا توجد إشعارات"
        // النوع الثاني (notification)
        if (event.notification_type == "notification") {
            $("#notify_contact").prepend(`
                <a class="dropdown-item d-flex align-items-center" href="${event.link}?notify_admin=${event.id}">
                    <div class="mr-3">
                        <div class="icon-circle bg-primary">
                            <i class="fas fa-file-alt text-white"></i>
                        </div>
                    </div>
                    <div>
                        <div class="small text-gray-500">${event.contact_time}</div>
                        <span class="font-weight-bold">${event.contact_title}</span>
                    </div>
                </a>
            `);
        }

        // النوع الأول (mail)
        else if (event.notification_type == "mail") {
            $("#AdminContact").prepend(`
                  <a href="${event.url}?admins_con=${event.id}"
                        class="dropdown-item d-flex align-items-start p-3 border-bottom">
                        <div>
                            <img src="${event.sender_img}"
                                class="rounded-circle shadow-sm" style="width: 55px; height: 55px; object-fit: cover;"
                                alt="Sender Image">
                        </div>
                        <div class="ml-3" style="flex: 1;">
                            <div class="font-weight-bold text-dark mb-1" style="font-size: 16px;">
                                ${event.title}
                            </div>
                            <div class="small text-muted mb-1">
                               ${event.sender_name}
                               ${event.created_at}
                            </div>
                            <div class="small text-secondary">
                               ${event.sender_email}
                                Role: ${event.sender_role}
                            </div>
                        </div>
                    </a>
            `);
        }

        // تحديث العدادات
        if (event.notification_type === "notification") {
            let notifCount = Number($("#unread_notifications").text());
            notifCount++;
            $("#unread_notifications").text(notifCount);
        } else if (event.notification_type === "mail") {
            let mailCount = Number($("#mail_counter").text());
            mailCount++;
            $("#mail_counter").text(mailCount);
        }
    });
}
